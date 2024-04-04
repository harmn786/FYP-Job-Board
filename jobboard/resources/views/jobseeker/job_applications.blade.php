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
    <h2 class="">Applied Jobs</h2>

    @if(count($jobApplications) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped  mt-4  border-0 rounded w-100 ml-auto mr-auto shadow">
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
                            <td>
                                <div class="action-dots float-end">
                                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        {{-- <li><a class="dropdown-item" href=""> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li> --}}
                                        <li><a class="dropdown-item" href="{{ route('jobs.jobDetail', $application->job->id) }}"><i class="fa fa-eye" aria-hidden="true"></i> View Detail</a></li>
                                        <li><a class="dropdown-item" href="{{ route('deleteApplication', ['applicationId' => $application->id])}}" onclick="return confirm('Are you sure to want to delete this record')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p>You haven't applied to any jobs yet.</p>
    @endif
      </div>
</div>
</div>
</div>
@endsection
