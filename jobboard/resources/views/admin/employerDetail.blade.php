
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
    <h2 class="mt-3">Detail For Employer {{ $employer->name }}</h2>
    <div class="table-responsive">
<table class="table table-striped table-bordered mt-4  border-0 rounded w-100 ml-auto mr-auto shadow">
    <thead class="bg-dark text-white">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>CNIC</th>
            <th>Industry</th>
            <th>Company Name</th>
            <th>Company Type</th>
            <th>Contact Person</th>
            <th>contact_number</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td>{{ $employer->name }}</td>
                <td>{{ $employer->email }}</td>
                <td>{{ $employer->cnic}}</td>
                <td>{{ $employer->industry }}</td>
                <td>{{ $employer->company_name }}</td>
                <td>{{ $employer->company_type }}</td>
                <td>{{ $employer->contact_person }}</td>
                <td>{{ $employer->contact_number}}</td>
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
