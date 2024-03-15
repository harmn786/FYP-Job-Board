@extends('master')
@section('content')
@if(session()->get('message'))
  <div class="alert alert-success" role="alert">
    <strong>Success: </strong>{{session()->get('message')}}
  </div>
  @endif
<div class="container">
  <div class="card border-0 p-4 shadow mb-4 customize-form mt-4">
    <h3>Reset Password</h3>
    <div class="border-bottom"></div>
  <form action="{{ route('resetPasswordPost')}}"  method="POST">
    @csrf
    <input type="text" name="token" hidden value="{{$token}}">

    <div class="form-group">
      <label for="email">Email</label>
      <input name="email" value="{{old('email')}}" type="text" class="form-control @error('email') is-invalid  @enderror" id="email" placeholder="Enter Your Email">
      <span class="text-danger">
        @error('email')
            {{$message}}
        @enderror
    </span>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input name="password" value="{{old('password')}}" type="password" class="form-control @error('password') is-invalid  @enderror" id="email" placeholder="Enter Your Password">
      <span class="text-danger">
        @error('password')
            {{$message}}
        @enderror
    </span>
    </div>
    <div class="form-group">
      <label for="confirm_password">Confirm Password</label>
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