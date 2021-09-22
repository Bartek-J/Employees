<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Salary;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {   
        if (isset($request->gender)) $gender = $request->gender;
        else $gender = 'all';
        if (isset($request->department)  && $request->department != 'all') $dept = $request->department;
        else $dept = '%';
        $maxSalary = Salary::select('salary')->orderBy('salary', 'desc')->limit(1)->get();
        $maxSalary = round($maxSalary[0]->salary) + 1;
        if (isset($request->to)) $to = $request->to;
        else $to = $maxSalary;
        if (isset($request->from) && $request->from < $to) $from = $request->from;
        else $from = 0;
        $employees = Employee::with(['departments', 'titles', 'salaries'])
           ->whereHas('departments', function (Builder $query) use ($dept) {
                $query->where('departments.dept_no', 'LIKE', $dept);
            })
            ->whereHas('salaries', function (Builder $query) use ($from, $to) {
                $query->whereBetween('salary', [$from, $to]);
           })
            ->gender($gender)->paginate(50);
        $departments = Department::get();
        return view('employee', compact('employees', 'departments'));
    }
    public function download($id)
    {
        if($id=='all')
        {
        $employees = Employee::with(['departmentAll', 'titles', 'salariesAll'])->limit(100)->get();
        }
        else
        {
            $employees=Employee::with(['departmentAll', 'titles', 'salariesAll'])->where('emp_no', $id)->get();
        }
        $i = 0;
        foreach ($employees as $employee) {
            $salary = 0;
            $j = 0;
            foreach ($employee->salariesAll as $sal) {
                if ($j > 0) {
                    $date1 = new DateTime($sal->to_date);
                    $date2 = new DateTime($sal->from_date);
                    $interval = $date1->diff($date2);
                    $salary = $salary + ($sal->salary * $interval->m) + (12 * $sal->salary * $interval->y);
                }
                $j++;
            }
            $data[$i] = [
                'FirstName' => $employee->first_name,
                'LastName' => $employee->last_name,
                'Department' => $employee->departmentAll[0]->dept_name,
                'Title' => $employee->titles[0]->title,
                'Salary' => $employee->salariesAll[0]->salary ,
                'SumOfSalary' => $salary ,
            ];
            $i++;
        }
        $content = json_encode($data);
        $filename = 'Employees.txt';
        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename);
    }
    public function inActive()
    {
        $inActive = DB::table('employees')->select('employees.emp_no','dept_emp.to_date','employees.first_name','employees.last_name','employees.gender')->leftJoin('dept_emp', function ($join) {
            $join->on('employees.emp_no', '=', 'dept_emp.emp_no')
                 ->where('dept_emp.to_date', 'LIKE', '9999-01-01');
        })->whereNull('to_date')->distinct()->paginate(50);
        return view('inActive',compact('inActive'));
    }
}
