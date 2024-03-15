<!-- {{-- jobs/index.blade.php --}} -->
@extends('master')
@section('content')
<div class="container py-5">
<div class="row">
    {{View::make('sidebar')}}
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
    <h3>Job Approvals</h3>

        @if(count($jobsPendingApproval) > 0)
            <table class="table table-striped table-responsive mt-4  border-0 rounded w-100 ml-auto mr-auto ">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Employer Name</th>
                        <th>Status</th>
                        <th>Job Detail</th>
                        <th>Approval Actions</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobsPendingApproval as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->company_name }}</td>
                            <td>{{ $job->employer->name }}</td>
                            <td>{{ $job->approved_by_admin === 0 ? "Unactive" : "Active" }}</td>
                            <td><a class="btn btn-primary" href="{{ route('jobs.show', $job->id) }}">Detail</a></td>
                            
                            <td>
                                {{-- Add your approve and reject buttons --}}
                                <form method="post" action="{{ route('admin.approveJob', $job) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Active</button>
                                </form>
                                
                                <form method="post" action="{{ route('admin.rejectJob', $job) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger mt-1">Unactive</button>
                                </form>

                                {{-- <form method="post" action="{{ route('admin.rejectJob', $job) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this job?')">Reject</button>
                                </form> --}}
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
        @else
            <p>No jobs pending approval.</p>
        @endif
        <div class="border-bottom mb-2"></div>
      </div>
</div>
</div>
</div>
@endsection
