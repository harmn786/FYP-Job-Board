
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
    <h3 class="mt-3">Job Applications for {{ $job->title }} Job</h3>
<table class="table table-striped table-bordered mt-4 table-responsive border-0 rounded w-100 ml-auto mr-auto shadow">
    <thead class="bg-dark text-white">
        <tr>
            <th>Applicant Name</th>
            <th>Email</th>
            <th>Education</th>
            <th>Experience</th>
            <th>Skills</th>
            <th>CV</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jobApplications as $jobApplication)
            <tr>
                <td>{{ $jobApplication->jobSeeker->name }}</td>
                <td>{{ $jobApplication->jobSeeker->email }}</td>
                <td>{{ $jobApplication->jobSeeker->education }}</td>
                <td>{{ $jobApplication->jobSeeker->experience }}</td>
                <td>{{ $jobApplication->jobSeeker->skills }}</td>
                <td><a href="{{ asset('storage/' .$jobApplication->jobSeeker->cv_path) }}" class="btn btn-warning">ReviewCV</a></td>
                <td>{{ $jobApplication->status }}</td>
                <td>
                    @if ($jobApplication)
                        <form action="{{ route('employer.approveJobApplication', ['applicationId' => $jobApplication->id]) }}" class="form-inline" method="POST">
                            @csrf
                            <select name="status" class="selectpicker border rounded" data-live-search="true">
                                <option value="Accepted">Accept</option>
                                <option value="Rejected">Reject</option>
                            </select>
                            <textarea type="text" name="remarks" placeholder="Remarks" class="w-100 mt-1" >{{$jobApplication->remarks}}</textarea>
                            <button class="btn btn-sm btn-success mt-2 d-inline " type="submit">Submit</button>

                        </form>
                    </td>
                    @endif
            </tr>
        @endforeach
    </tbody>
</table>
<div>
    {{$jobApplications->links()}}
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
