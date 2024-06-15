
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
    <h2>Contacts</h2>

        @if(count($contactData) > 0)
        <div class="table-responsive">
            <table class="table table-striped  mt-4  border-0 rounded w-100 ml-auto mr-auto ">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Name</th>
                        <th>Email</th>
                        <th>subject</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contactData as $data)
                        <tr>
                            <td>{{ $data->name}}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->subject}}</td>
                            <td>{{ $data->message}}</td>
                            {{-- <td><a href="{{ route('admin.editUser',['userId' => $user->id]) }}" class="btn btn-success">Update</a> &nbsp; &nbsp;<a href="{{ route('admin.deleteUser',['userId' => $user->id]) }}" class="btn btn-danger">Delete</a></td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
          <div>
            {{ $contactData->links() }}
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
