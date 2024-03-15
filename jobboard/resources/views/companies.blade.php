<!-- {{-- jobs/index.blade.php --}} -->
@extends('master')
@section('content')
<div class="container py-5">
<div class="row">
    {{View::make('sidebar')}}
    <div class="col-lg-9">
@if(session()->get('message'))
<div class="alert alert-success" role="alert">
  <strong>Success: </strong>{{session()->get('message')}}
</div>
@endif
@if(session()->get('error'))
<div class="alert alert-danger" role="alert">
  <strong>Error: </strong>{{session()->get('error')}}
</div>
@endif

  <div class="card border-0 shadow mb-4 p-2">
    <h2 class="">Companies</h2>

    @if(count($companies) > 0)
        <table class="table table-striped table-responsive mt-4  rounded w-100 ml-auto mr-auto">
            <caption class="">Companies/Employers</caption>
            <thead>
                <tr class="bg-dark text-white">
                    <th>Employer Name</th>
                    <th>Email</th>
                    <th>Industry</th>
                    <th>Contact Person</th>
                    <th>Contact Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email}}</td>
                        <td>{{ $company->industry }}</td>
                        <td>{{ $company->contact_person }}</td>
                        <td>{{ $company->contact_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No Companies Registerd Yet</p>
    @endif
    <div class="border-bottom mb-2"></div>
      </div>
</div>
</div>
</div>
@endsection
