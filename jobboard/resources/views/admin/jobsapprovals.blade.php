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

  <div class="card border-0 shadow mb-4 p-3">
    <h2>Job Approvals</h2>

        @if(count($jobsPendingApproval) > 0)
        <div class="table-responsive">
            <table class="table table-striped table-bordered mt-4  border-0 rounded w-100 ml-auto mr-auto ">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Employer Name</th>
                        <th>Employer Profile</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Total Applicants</th>
                        <th>Actions</th>
                        <th>Remarks For Job</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobsPendingApproval as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->company_name }}</td>
                            <td>{{ $job->employer->name }}</td>
                            <td><a class="btn btn-primary" href="{{ route('employer.detail', ['employer' => $job->employer]) }}"> View</a></td>
                            <td>{{ $job->approved_by_admin === 0 ? "Unactive" : "Active" }}</td>
                            <td>{{ $job->featured === 0 ? "Not in Featured" : "Featured" }}</td>
                            <td>Applications: {{ $job->jobApplications->count() }}
                            </td>
                                {{-- Add your approve and reject buttons --}}
                                {{-- <td>
                                <form method="post" action="{{ route('admin.approveJob', $job) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Active</button>
                                </form>
                                
                                <form method="post" action="{{ route('admin.rejectJob', $job) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger mt-1">Unactive</button>
                                </form>

                                <form method="post" action="{{ route('admin.rejectJob', $job) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this job?')">Reject</button>
                                </form>
                            </td> --}}
                            <td>
                                <div class="action-dots float-end">
                                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('jobs.jobDetail', $job->id) }}"> <i class="fa fa-eye" aria-hidden="true"></i> View Detail</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.featuredJob', $job) }}"><i class="fa fa-edit" aria-hidden="true"></i>Add to Featured</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.unFeaturedJob', $job) }}"><i class="fa fa-trash" aria-hidden="true"></i> Remove From Featured</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.approveJob', $job) }}"><i class="fa fa-edit" aria-hidden="true"></i>Active Job For Posting</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.rejectJob', $job) }}"><i class="fa fa-trash" aria-hidden="true"></i>UnActive Job For Posting</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.JobRemarks', ['jobId' => $job->id]) }}" class="form-inline" method="POST">
                                    @csrf
                                    <textarea type="text" name="remarks" placeholder="Remarks" class="w-100 mt-1" >{{$job->remarks}}</textarea>
                                    <button class="btn btn-sm btn-success mt-2 d-inline " type="submit">Submit</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p>No jobs pending approval.</p>
        @endif
        <div class="border-bottom mb-2"></div>
      </div>
</div>
</div>
</div>
@endsection
