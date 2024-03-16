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

  <div class="card border-0 shadow mb-4 p-4">
    <h2>Posted Jobs</h2>
        @if(count($jobs) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped   border-0 rounded w-100 ml-auto mr-auto shadow mt-4"class="table table-striped">
                <thead class="text-white bg-dark">
                    <tr>
                        <th>Title</th>
                        <th>Salary</th>
                        <th>Location</th>
                        <th>Job Detail</th>
                        <th>Job Status</th>
                        <th>Action</th>
                        <th>Job Applications</th>
                        <th>CV Archive</th>
                        <th>Export Applicants</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                        <tr>
                            <td><p>{{ $job->title }}</p></td>
                            <td>${{ $job->salary }}</td>
                            <td>{{ $job->location }}</td>
                            <td><a href="{{ route('jobs.show', $job->id) }}">View Details</a></td>
                            <td>{{ $job->approved_by_admin === 0 ? "Unactive" : "Active" }}</td>
                            <td>
                                {{-- Add your update and delete buttons --}}
                                <a href="{{ route('employer.editJob', $job) }}" class="btn btn-success">Update</a>

                            </td>
                            <td><p><a href="{{ route('employer.showJobApplications', $job->id) }}" class="btn btn-warning">Applications</a></p>
                                <br> <span>Total: {{ $job->jobApplications->count() }}</span>
                            </td>
                            <td>
                                <a href="{{ route('downloadCVs', ['jobId' => $job->id]) }}" class="btn btn-primary">Download</a>
                            </td>
                            <td>
                                <a class="btn bg-dark text-white" href="{{ route('job.applicants.download', ['jobId' => $job->id]) }}">Export</a>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            <div>

            </div>
        @else
            <p>No jobs posted.</p>
        @endif
      </div>
</div>
</div>
</div>
</div>
@endsection
