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
      <label for="email" class="form-label">Email<span class="text-danger fw-bold">*</span></label>
      <input name="email" value="{{old('email')}}" type="text" class="form-control @error('email') is-invalid  @enderror" id="email" placeholder="Enter Your Email">
      <span class="text-danger">
        @error('email')
            {{$message}}
        @enderror
    </span>
    </div>
    <div class="mb-3 password-container">
      <label for="password" class="form-label">Password<span class="text-danger fw-bold">*</span></label>
      <input name="password" value="{{old('password')}}" type="password" class="form-control @error('password') is-invalid  @enderror" id="password" placeholder="Enter Your Password">
      <i class=" fa fa-sold fa-eye fa-eye-password" id="show-password"></i>
      <span class="text-danger">
        @error('password')
            {{$message}}
        @enderror
    </span>
    </div>
    <div class="mb-3 password-container">
      <label for="confirm_password" class="form-label">Confirm Password</label>
      <input name="confirm_password" value="{{old('confirm_password')}}" type="password" class="form-control @error('confirm_password') is-invalid  @enderror" id="confirm_password" placeholder="Confirm Your Password">
      <i class=" fa fa-sold fa-eye fa-eye-password" id="show-confirm-password"></i>
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
  @section('customJs')
  <script>
    const showPassword = document.querySelector("#show-password");
    const passwordField = document.querySelector("#password");
    const showConfirmPassword = document.querySelector("#show-confirm-password");
    const confirmPasswordField = document.querySelector("#confirm_password"); 
    
    showPassword.addEventListener("click",function(){
      this.classList.toggle("fa-eye-slash");
      const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
      passwordField.setAttribute("type",type);
  });
  showConfirmPassword.addEventListener("click",function(){
      this.classList.toggle("fa-eye-slash");
      const type = confirmPasswordField.getAttribute("type") === "password" ? "text" : "password";
      confirmPasswordField.setAttribute("type",type);
  });
  </script>
  @endsection