@extends('master')
@section('content')
@if(session()->get('message'))
  <div class="alert alert-success" role="alert">
    <strong>Success: </strong>{{session()->get('message')}}
  </div>
  @endif
<div class="container">
  <div class="card border-0 p-4 shadow mb-4 customize-form mt-4">
    <h3>Forget Password</h3>
    <p>We will a link to reset your password to your email</p>
    <div class="border-bottom"></div>
  <form action="{{ route('forgetPasswordPost')}}"  method="POST">
    @csrf
    <div class="form-group">
      <label for="email">Email</label>
      <input name="email" value="{{old('email')}}" type="text" class="form-control @error('email') is-invalid  @enderror" id="email" placeholder="Enter Your Email">
      <span class="text-danger">
        @error('email')
            {{$message}}
        @enderror
    </span>
    </div>
    <Button type="submit" class="btn btn-success btn-block" name="submit" style="width:100%; ">Submit</Button>
</form>
  </div>
</div>
  @endsection