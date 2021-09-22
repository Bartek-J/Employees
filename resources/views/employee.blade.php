@extends('layouts.app')

@section('content')

<div class="container  align-items-center justify-content-center">
<div class="row">
        <h4>Currently showing active employees, click <a href="{{route('inactive')}}">here</a> to switch, to inactive ones.</h4>
        </div>
    <div class="row mb-4">
        <div class="card" style='width:100%'>
            <div class="card-header " data-toggle="collapse" href="#filterCollapse" role="button" aria-expanded="false" aria-controls="filterCollapse">
                Filters
            </div>
            <div class="card-body collapse" id="filterCollapse">
                <form action="{{route('home')}}" method="GET">
                    <div class="row">
                        <div class="input-group mb-3 col-md-6">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="from">Salary From:</label>
                            </div>
                            <input class="form-control" type="number" name="from" id="from" min="0">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="to">To:</label>
                            </div>
                            <input class="form-control" type="number" name="to" min="0" id="to">

                        </div>
                        <div class="input-group mb-3  col-md-6">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="gender">Gender</label>
                            </div>

                            <select class="custom-select" name="gender" id="gender">
                                <option value="all" selected>All</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                        <div class="input-group mb-3  col-md-6">
                            <div class="input-group-prepend ">
                                <label class="input-group-text" for="department">Department</label>
                            </div>
                            <select class="custom-select" name="department" id="department">
                                <option value="all" selected>All</option>
                                @foreach($departments as $department)
                                <option value="{{$department->dept_no}}">{{$department->dept_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row align-items-center justify-content-center">
        <table class="table table-bordered rounded">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Department</th>
                    <th>Title</th>
                    <th>Salary</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{$employee->first_name}}</td>
                    <td>{{$employee->last_name}}</td>
                    <td>{{$employee->departments[0]->dept_name}}</td>
                    <td>{{$employee->titles[0]->title}}</td>
                    <td>{{$employee->salaries[0]->salary}}$</td>
                    <td>
                        <a href="{{route('download',$employee->emp_no)}}" class="">Download</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row align-items-center justify-content-center mt-4">
        {{ $employees->withQueryString()->links("pagination::bootstrap-4")  }}
    </div>
    <div class="row mt-3">
        <div class="card col-12">
            <div class="card-body align-items-center justify-content-center text-center">
                <a href="{{route('download','all')}}" class="">
                    <h4>Download Data</h4>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection