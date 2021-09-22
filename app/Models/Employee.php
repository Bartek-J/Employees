<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    public function departments()
    {
        return $this->belongsToMany(Department::class,'dept_emp','emp_no','dept_no','emp_no','dept_no')->wherePivot('to_date', '9999-01-01')->orderBy('to_date','desc');
    }
    public function departmentAll()
    {
        return $this->belongsToMany(Department::class,'dept_emp','emp_no','dept_no','emp_no','dept_no')->orderBy('to_date','desc');
    }
    public function titles()
    {
        return $this->hasMany(Title::class,'emp_no','emp_no');
    }
    public function salaries()
    {
        return $this->hasMany(Salary::class,'emp_no','emp_no')->where('to_date', '9999-01-01');
    }
    public function salariesAll()
    {
        return $this->hasMany(Salary::class,'emp_no','emp_no')->orderBy('to_date','desc');
    }
    public function scopeGender($query, $gender)
    {
        if($gender == 'all') return $query;
        return $query->where('gender',$gender);
    }
    public function scopeDepartment($query, $department)
    {
        return $query->where('dept_no',$department);
    }
}
