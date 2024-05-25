
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
    <h2>Job Types</h2>

        @if(count($jobtypes) > 0)
        <div class="table-responsive">
            <table class="table table-striped  mt-4  border-0 rounded w-100 ml-auto mr-auto ">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>JobType ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobtypes as $jobtype)
                        <tr>
                            <td>{{ $jobtype->id}}</td>
                            <td>{{ $jobtype->name }}</td>
                            <td>
                              <div class="action-dots float-end">
                                  <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                      <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end">
                                      {{-- <li><a class="dropdown-item" href=""> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li> --}}
                                      <li><a class="dropdown-item" href="{{ route('admin.editJobType',['jobtypeId' => $jobtype->id]) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                      <li><a class="dropdown-item" href="{{ route('admin.deleteJobType',['jobtypeId' => $jobtype->id]) }}" onclick="return confirm('Are you sure to want to delete this record')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                  </ul>
                              </div>
                          </td>
                            {{-- <td><a href="{{ route('admin.editUser',['userId' => $user->id]) }}" class="btn btn-success">Update</a> &nbsp; &nbsp;<a href="{{ route('admin.deleteUser',['userId' => $user->id]) }}" class="btn btn-danger">Delete</a></td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
          <div>
            {{ $jobtypes->links() }}
          </div>
          <div>
            <a href="{{ route('newjobtype') }}" class="btn btn-success">Add New JobType</a>
          </div>
        @else
            <p>No Users Registered Yet.</p>
        @endif
        <div class="border-bottom mb-2"></div>
      </div>
</div>
</div>
</div>
@endsection
