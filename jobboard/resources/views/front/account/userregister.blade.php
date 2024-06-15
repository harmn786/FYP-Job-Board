@extends('front.app.master')
@section('content')
<div class="container">
  <div class="card border-0 p-4 shadow mb-4 customize-form mt-4">
    <h2>Sign Up</h2>
  <form action="{{route('add')}}" class="mt-2 " method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name<span class="text-danger fw-bold">*</span></label>
        <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Enter Your Name">
        <span class="text-danger">
          @error('name')
              {{$message}}
          @enderror
      </span>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email<span class="text-danger fw-bold">*</span></label>
        <input type="text" value="{{old('email')}}" id="email" class="form-control @error('email') is-invalid  @enderror" name="email" placeholder="Enter Your Email">
        <span class="text-danger">
          @error('email')
              {{$message}}
          @enderror
      </span>
      </div>
      
      <div class="mb-3 password-container">
        <label for="password" class="form-label">Password<span class="text-danger fw-bold">*</span></label>
        <input type="password" value="{{old('password')}}" class="form-control  @error('password') is-invalid  @enderror" id="password" name="password" placeholder="Enter Your Password">
        <i class=" fa fa-sold fa-eye fa-eye-password" id="show-password"></i>
        <span class="text-danger">
          @error('password')
              {{$message}}
          @enderror
      </span>
      </div>
      <div class="mb-3 password-container">
        <label for="confirm_password" class="form-label">Confirm Password<span class="text-danger fw-bold">*</span></label>
        <input type="password" value="{{old('password_confirmation')}}" id="confirm_password" class="form-control @error('password_confirmation') is-invalid  @enderror" name="password_confirmation" placeholder="Confirm Your Password">
        <i class=" fa fa-sold fa-eye fa-eye-password" id="show-confirm-password"></i>
        <span class="text-danger">
          @error('password_confirmation')
              {{$message}}
          @enderror
      </span>
      </div>
      <div class="mb-3">
        <label for="role" class="form-label"> Select User Type<span class="text-danger fw-bold">*</span></label>
        <select name="role" value="{{old('role')}}" class="form-control @error('role') is-invalid  @enderror" id="role" placeholder="Select Role" >
            <option></option>
            <option value="job_seeker">Job_Seeker</option>
            <option value="company">Company</option>
        </select>
        <span class="text-danger">
            @error('type')
                {{$message}}
            @enderror
        </span>
      </div>
    <Button type="submit" class="btn btn-success mb-3" name="submit">Submit</Button>
    <span class="log-condition">(Already Member) <a href="{{route('userlogin')}}">Go To Login</a></span>
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