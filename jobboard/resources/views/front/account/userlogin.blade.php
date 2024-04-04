@extends('front.app.master')
@section('content')
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
<div class="container">
  <div class="card border-0 p-4 shadow mb-4 customize-form mt-4">
    <h2>Login</h2>
    {{-- <div class="border-bottom"></div> --}}
  <form action="{{route('userlog')}}"  method="POST" class="mt-2">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input name="email" value="{{old('email')}}" type="text" class="form-control @error('email') is-invalid  @enderror" id="email" placeholder="Enter Your Email">
      <span class="text-danger">
        @error('email')
            {{$message}}
        @enderror
    </span>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input name="password" value="{{old('password')}}" type="password" class="form-control @error('password') is-invalid  @enderror" id="email" placeholder="Enter Your Password">
      <span class="text-danger">
        @error('password')
            {{$message}}
        @enderror
    </span>
    </div>
    <div class="mb-3">
    <Button type="submit" class="btn btn-success btn-block " name="submit" style="width:100%; ">Submit</Button>
    </div>
    <div class="form-group choice">
    <span class="log-condition">(Not a Member) <a href="{{route('userregister')}}">Sign Up First</a></span>
    <span class="reset-password"><a href="{{route('forgetPassword') }}">Forgot Password!</a></span>
    </div>
</form>
</div>
</div>
  @endsection