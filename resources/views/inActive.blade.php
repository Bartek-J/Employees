@extends('layouts.app')

@section('content')

<div class="container  align-items-center justify-content-center">
<div class="row">
        <h4>Currently showing inactive employees, click <a href="{{route('home')}}">here</a> to switch, to active ones.</h4>
        </div>
    <div class="row align-items-center justify-content-center">
        <table class="table table-bordered rounded">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inActive as $employee)
                <tr>
                    <td>{{$employee->first_name}}</td>
                    <td>{{$employee->last_name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row align-items-center justify-content-center mt-4">
        {{ $inActive->withQueryString()->links("pagination::bootstrap-4")  }}
    </div>
    <div class="row mt-3">
        <div class="card col-12">
            <div class="card-body align-items-center justify-content-center text-center">
            </div>
        </div>
    </div>
</div>

@endsection