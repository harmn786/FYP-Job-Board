@extends('master')
@section('content')
<div class="container">
  <h1 class="heading">Admin Sign Up Form</h1>
  <form action="{{route('add')}}" class="p-4 border rounded mt-4" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Enter Your Name</label>
        <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Enter Employee Name">
        <span class="text-danger">
          @error('name')
              {{$message}}
          @enderror
      </span>
      </div>
      <div class="form-group">
        <label for="email">Enter Your Email</label>
        <input type="text" value="{{old('email')}}" id="email" class="form-control @error('email') is-invalid  @enderror" name="email" placeholder="Enter Your Email">
        <span class="text-danger">
          @error('email')
              {{$message}}
          @enderror
      </span>
      </div>
      
      <div class="form-group">
        <label for="password">Enter Your Password</label>
        <input type="password" value="{{old('password')}}" class="form-control @error('password') is-invalid  @enderror" id="password" name="password" placeholder="Enter Your Password">
        <span class="text-danger">
          @error('password')
              {{$message}}
          @enderror
      </span>
      </div>
      <div class="form-group">
        <input type="password" value="admin" id="role" hidden class="form-control @error('role') is-invalid  @enderror" name="role" placeholder="Confirm Your Password">
        <span class="text-danger">
          @error('role')
              {{$message}}
          @enderror
      </span>
      </div>

      <div class="form-group">
        <label for="role">Confirm Your Password</label>
        <input type="text" value="{{old('password_confirmation')}}" id="confirm_password" class="form-control @error('password_confirmation') is-invalid  @enderror" name="password_confirmation" placeholder="Confirm Your Password">
        <span class="text-danger">
          @error('password_confirmation')
              {{$message}}
          @enderror
      </span>
      </div>

    <Button type="submit" class="btn btn-primary" name="submit">Submit</Button>
    <span class="log-condition">(Already Member) <a href="{{route('userlogin')}}">Go To Login</a></span>
</form>
</div>
  @endsection