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

  <div class="card border-0 shadow mb-4">
    <form action="{{route('jobSeeker.update')}}" class=" p-4 border rounded " method="POST">
        <h2>Profile</h2>
        @csrf
        <div class="row mt-4">
        <div class="mb-3 col-md-6 ">
            <label for="name" class="form-label">Enter Your Name</label>
            <input type="text" disabled  value="{{old('name',$jobSeeker->name)}}" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Enter Employee Name">
            <span class="text-danger">
              @error('name')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6  mb-3">
            <label for="email" class="form-label">Enter Your Email</label>
            <input type="text" disabled  value="{{old('email',$jobSeeker->email)}}" id="email" class="form-control @error('email') is-invalid  @enderror" name="email" placeholder="Enter Your Email">
            <span class="text-danger">
              @error('email')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6  mb-3">
            <label for="contact_no" class="form-label">Enter Your Contact_No</label>
            <input type="text"   value="{{old('contact_no',$jobSeeker->contact_no)}}" id="contact_no" class="form-control @error('contact_no') is-invalid  @enderror" name="contact_no" placeholder="Enter Your Contact_No">
            <span class="text-danger">
              @error('contact_no')
                  {{$message}}
              @enderror
          </span>
          </div>
          
          <div class="col-md-6  mb-3">
            <label for="education" class="form-label">Enter Your education</label>
            <input type="text" value="{{old('education',$jobSeeker->education)}}" class="form-control @error('education') is-invalid  @enderror" id="education" name="education" placeholder="Enter Your education">
            <span class="text-danger">
              @error('education')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6  mb-3">
            <label for="experience" class="form-label">Enter Your experience</label>
            <input type="text" value="{{old('experience',$jobSeeker->experience)}}" id="experience" class="form-control @error('experience') is-invalid  @enderror" name="experience" placeholder="Confirm Your experience">
            <span class="text-danger">
              @error('experience')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6  mb-3">
            <label for="title" class="form-label">Enter Your Title</label>
            <input type="text" value="{{old('title',$jobSeeker->title)}}" class="form-control @error('title') is-invalid  @enderror" id="title" name="title" placeholder="Enter Your Title eg: web developer">
            <span class="text-danger">
              @error('title')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6  mb-3">
            <label for="cnic" class="form-label">Enter Your CNIC</label>
            <input type="text" value="{{old('cnic',$jobSeeker->cnic)}}" class="form-control @error('cnic') is-invalid  @enderror" id="cnic" name="cnic" placeholder="Enter Your CNIC">
            <span class="text-danger">
              @error('cnic')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6  mb-3">
            <label for="dob" class="form-label">Enter Your DOB</label>
            <input type="date" value="{{old('dob',$jobSeeker->dob)}}" class="form-control @error('dob') is-invalid  @enderror" id="dob" name="dob" placeholder="Enter Your Date Of Birth">
            <span class="text-danger">
              @error('dob')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6  mb-3">
            <label for="address" class="form-label">Enter Your Address</label>
            <input type="text" value="{{old('address',$jobSeeker->address)}}" class="form-control @error('address') is-invalid  @enderror" id="address" name="address" placeholder="Enter Your Address">
            <span class="text-danger">
              @error('address')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6 mb-3">
            <label for="skills" class="form-label">Enter Your Skills</label>
            <input type="text" value="{{old('skills',$jobSeeker->skills)}}" id="skills" class="form-control @error('skills') is-invalid  @enderror" name="skills" placeholder="Enter Your skills">
            <span class="text-danger">
              @error('skills')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="mb-3">
            <label for="facebook_link" class="form-label">Enter Your facebook_link</label>
            <input type="text" value="{{old('facebook_link',$jobSeeker->facebook_link)}}" id="facebook_link" class="form-control @error('facebook_link') is-invalid  @enderror" name="facebook_link" placeholder="Enter Your facebook_link">
            <span class="text-danger">
              @error('facebook_link')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="mb-3">
            <label for="linkedin_link" class="form-label">Enter Your linkedin_link</label>
            <input type="text" value="{{old('linkedin_link',$jobSeeker->linkedin_link)}}" id="linkedin_link" class="form-control @error('linkedin_link') is-invalid  @enderror" name="linkedin_link" placeholder="Enter Your linkedin_link">
            <span class="text-danger">
              @error('linkedin_link')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="mb-3">
            <label for="twitter_link" class="form-label">Enter Your twitter_link</label>
            <input type="text" value="{{old('twitter_link',$jobSeeker->twitter_link)}}" id="twitter_link" class="form-control @error('twitter_link') is-invalid  @enderror" name="twitter_link" placeholder="Enter Your twitter_link">
            <span class="text-danger">
              @error('twitter_link')
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

  <div class="card border-0 shadow mb-4">
    <form action="{{route('jobSeeker.updateCV')}}" class="p-4 border rounded " method="POST" enctype="multipart/form-data">
      <h1 class="">Add/Update CV</h1>
      @csrf
      <div class="mb-3">
        <label for="cv" class="form-label">Upload Your CV</label>
        <input name="cv" type="file" class="form-control @error('cv') is-invalid  @enderror" id="cv">
        <span class="text-danger">
          @error('cv')
              {{$message}}
          @enderror
      </span>
      </div>
      <Button type="submit" class="btn btn-success" name="submit">Update</Button>
      @if($jobSeeker->cv_path)
      <p class="text-success">CV is already uploaded</p>

      
      <a href="{{ route('cv.show') }}">Click To Download CV File</a>
    @endif
  </form>
  </div>
  

  

 


<div class="card border-0 shadow mb-4">
  <div class="card-body p-4">
    <form action="{{ route('changePassword') }}" method="POST">
      @csrf
      <h3 class="fs-4 mb-1">Change Password</h3>
      <div class="mb-4">
          <label for="old_password" class="mb-2">Old Password*</label>
          <input type="password" name="old_password" placeholder="Old Password" class="form-control @error('old_password') is-invalid @enderror">
          <span class="text-danger">
            @error('old_password')
                {{$message}}
            @enderror
        </span>
      </div>
      <div class="mb-4">
          <label for="new_password" class="mb-2">New Password*</label>
          <input type="password" name="new_password"  placeholder="New Password" class="form-control @error('new_password') is-invalid @enderror">
          <span class="text-danger">
            @error('old_password')
                {{$message}}
            @enderror
      </div>
      <div class="mb-4">
          <label for="confirm_password" class="mb-2">Confirm Password*</label>
          <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control @error('confirm_password') is-invalid @enderror">
          <span class="text-danger">
            @error('old_password')
                {{$message}}
            @enderror
      </div>                        
  </div>
  <div class="card-footer  p-4">
      <button type="submit" class="btn btn-success" name="submit">Update</button>
  </div>
</form>
</div> 
</div>
</div>
</div>
@endsection