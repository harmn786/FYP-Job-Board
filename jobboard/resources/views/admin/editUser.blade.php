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


  <div class="card border-0 shadow mb-4 rounded p-4">
    <div class="card-body p-4">
      <h2>Edit User</h2>
      <form action="{{route('user.update',['userId' => $user->id])}}" class="" method="POST">
        @csrf
        <div class="row mt-4">
        <div class="mb-3 col-md-6 ">
            <label for="name" class="form-label">Enter User Name</label>
            <input type="text"   value="{{old('name',$user->name)}}" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Enter Employee Name">
            <span class="text-danger">
              @error('name')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6  mb-3">
            <label for="email" class="form-label">Enter User Email</label>
            <input type="text"   value="{{old('email',$user->email)}}" id="email" class="form-control @error('email') is-invalid  @enderror" name="email" placeholder="Enter Your Email">
            <span class="text-danger">
              @error('email')
                  {{$message}}
              @enderror
          </span>
          </div>
          
          <div class="mb-3">
            <label for="role" class="form-label"> Select User Type</label>
            <select name="role" value="{{old('role',$user->role)}}" class="form-control @error('role') is-invalid  @enderror" id="role" placeholder="Select Role" >
                <option></option>
                <option value="job_seeker">Job_Seeker</option>
                <option value="company">Company</option>
            </select>
            <span class="text-danger">
                @error('role')
                    {{$message}}
                @enderror
            </span>
          </div>
         
          <div class="mb-3">
        <Button type="submit" class="btn btn-success" name="submit">Update</Button>
      </div>
      </div>
    </form>
  </div> 
  </div>
</div>
</div>
</div>
@endsection