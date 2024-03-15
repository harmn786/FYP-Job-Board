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
    <h2 class="">Applied Jobs</h2>

    @if(count($jobApplications) > 0)
        <table class="table table-striped table-responsive mt-4  border-0 rounded w-100 ml-auto mr-auto shadow">
            <caption class="">Applied Jobs</caption>
            <thead>
                <tr class="bg-dark text-white">
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <td>
                        Action
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($jobApplications as $application)
                    <tr>
                        <td>{{ $application->job->title }}</td>
                        <td>{{ $application->job->company_name }}</td>
                        <td>{{ $application->status }}</td>
                        <td>{{ $application->remarks }}</td>
                        <td><a class="btn btn-danger" href="{{ route('deleteApplication', ['applicationId' => $application->id])}}">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You haven't applied to any jobs yet.</p>
    @endif
      </div>
</div>
</div>
</div>
@endsection
