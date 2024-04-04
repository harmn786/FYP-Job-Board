
<!-- {{-- jobs/index.blade.php --}} -->
@extends('front.app.master')
@section('content')
<div class="container py-5">
<div class="row">
    {{View::make('front.app.sidebar')}}
    <div class="col-lg-9">
@if(session()->get('success'))
<div class="alert alert-success" role="alert">
  <strong>Success: </strong>{{session()->get('success')}}
</div>
@endif
@if(session()->get('error'))
<div class="alert alert-danger" role="alert">
  <strong>Error: </strong>{{session()->get('error')}}
</div>
@endif

  <div class="card border-0 shadow mb-4 p-2">
    <h2 class="mt-3">Detail For JobSeeker {{ $jobSeeker->name }}</h2>
    <div class="table-responsive">
<table class="table table-striped table-bordered mt-4  border-0 rounded w-100 ml-auto mr-auto shadow">
    <thead class="bg-dark text-white">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>DOB</th>
            <th>CNIC</th>
            <th>Education</th>
            <th>Experience</th>
            <th>Skills</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td>{{ $jobSeeker->name }}</td>
                <td>{{ $jobSeeker->email }}</td>
                <td>{{ $jobSeeker->dob }}</td>
                <td>{{ $jobSeeker->cnic }}</td>
                <td>{{ $jobSeeker->education }}</td>
                <td>{{ $jobSeeker->experience }}</td>
                <td>{{ $jobSeeker->skills }}</td>
                <td>{{ $jobSeeker->address }}</td>
            </tr>
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
