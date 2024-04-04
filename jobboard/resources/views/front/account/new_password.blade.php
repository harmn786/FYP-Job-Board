@extends('front.app.master')
@section('content')
@if(session()->get('success'))
  <div class="alert alert-success" role="alert">
    <strong>Success: </strong>{{session()->get('success')}}
  </div>
  @endif
<div class="container">
  <div class="card border-0 p-4 shadow mb-4 customize-form mt-4">
    <h2>Reset Password</h2>
    <div class="border-bottom"></div>
  <form action="{{ route('resetPasswordPost')}}"  method="POST">
    @csrf
    <input type="text" name="token" hidden value="{{$token}}">

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
      <label for="confirm_password" class="form-label">Confirm Password</label>
      <input name="confirm_password" value="{{old('confirm_password')}}" type="password" class="form-control @error('confirm_password') is-invalid  @enderror" id="confirm_password" placeholder="Confirm Your Password">
      <span class="text-danger">
        @error('confirm_password')
            {{$message}}
        @enderror
    </span>
    </div>
    <Button type="submit" class="btn btn-success btn-block" name="submit" style="width:100%; ">Submit</Button>
</form>
  </div>
</div>
  @endsection