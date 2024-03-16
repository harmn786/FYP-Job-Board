@extends('master')
@section('content')
<div class="container py-5">
<div class="row">
    {{View::make('sidebar')}}
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
    <form action="{{route('jobSeeker.update')}}" class=" p-5 border rounded " method="POST">
        <h1>Profile</h1>
        @csrf
        <div class="mb-3">
            <label for="name">Enter Your Name</label>
            <input type="text"  value="{{old('name',$jobSeeker->name)}}" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Enter Employee Name">
            <span class="text-danger">
              @error('name')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="mb-3">
            <label for="email">Enter Your Email</label>
            <input type="text" value="{{old('email',$jobSeeker->email)}}" id="email" class="form-control @error('email') is-invalid  @enderror" name="email" placeholder="Enter Your Email">
            <span class="text-danger">
              @error('email')
                  {{$message}}
              @enderror
          </span>
          </div>
          
          <div class="mb-3">
            <label for="education">Enter Your education</label>
            <input type="text" value="{{old('education',$jobSeeker->education)}}" class="form-control @error('education') is-invalid  @enderror" id="education" name="education" placeholder="Enter Your education">
            <span class="text-danger">
              @error('education')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="mb-3">
            <label for="experience">Enter Your experience</label>
            <input type="text" value="{{old('experience',$jobSeeker->experience)}}" id="experience" class="form-control @error('experience') is-invalid  @enderror" name="experience" placeholder="Confirm Your experience">
            <span class="text-danger">
              @error('experience')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="mb-3">
            <label for="skills">Enter Your Skills</label>
            <input type="text" value="{{old('skills',$jobSeeker->skills)}}" id="skills" class="form-control @error('skills') is-invalid  @enderror" name="skills" placeholder="Enter Your skills">
            <span class="text-danger">
              @error('skills')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="mb-3">
            <label for="facebook_link">Enter Your facebook_link</label>
            <input type="text" value="{{old('facebook_link',$jobSeeker->facebook_link)}}" id="facebook_link" class="form-control @error('facebook_link') is-invalid  @enderror" name="facebook_link" placeholder="Enter Your facebook_link">
            <span class="text-danger">
              @error('facebook_link')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="mb-3">
            <label for="linkedin_link">Enter Your linkedin_link</label>
            <input type="text" value="{{old('linkedin_link',$jobSeeker->linkedin_link)}}" id="linkedin_link" class="form-control @error('linkedin_link') is-invalid  @enderror" name="linkedin_link" placeholder="Enter Your linkedin_link">
            <span class="text-danger">
              @error('linkedin_link')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="mb-3">
            <label for="twitter_link">Enter Your twitter_link</label>
            <input type="text" value="{{old('twitter_link',$jobSeeker->twitter_link)}}" id="twitter_link" class="form-control @error('twitter_link') is-invalid  @enderror" name="twitter_link" placeholder="Enter Your twitter_link">
            <span class="text-danger">
              @error('twitter_link')
                  {{$message}}
              @enderror
          </span>
          </div>
        <Button type="submit" class="btn btn-primary" name="submit">Update</Button>
    </form>

  </div>

  <div class="card border-0 shadow mb-4">
    <form action="{{route('jobSeeker.updateCV')}}" class="p-4 border rounded " method="POST" enctype="multipart/form-data">
      <h1 class="">Add/Update CV</h1>
      @csrf
      <div class="mb-3">
        <label for="cv">Upload Your CV</label>
        <input name="cv" type="file" class="form-control @error('cv') is-invalid  @enderror" id="cv">
        <span class="text-danger">
          @error('cv')
              {{$message}}
          @enderror
      </span>
      </div>
      <Button type="submit" class="btn btn-primary" name="submit">Update</Button>
      @if($jobSeeker->cv_path)
      <p class="text-success">CV is already uploaded</p>
      <a href="{{ asset('storage/' . $jobSeeker->cv_path) }}" target="_blank">Click To Download CV File</a>
    @endif
  </form>
  </div>
  <div class="card border-0 shadow mb-4">
  <form action="{{route('jobSeeker.updateImage')}}" class=" p-4 border rounded " method="POST" enctype="multipart/form-data">
    <h1>Add/Update Image</h1>
    @csrf
    <div class="mb-3">
      <label for="image">Upload Your image</label>
      <input name="image"  type="file" class="form-control @error('image') is-invalid  @enderror" id="image">
      <span class="text-danger">
        @error('image')
            {{$message}}
        @enderror
    </span>
    </div>
    <Button type="submit" value = "submit" class="btn btn-primary" name="submit">Update</Button>
    @if($jobSeeker->img_path)
  <p class="text-success">Profile Image is already uploaded</p>
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
      <button type="submit" class="btn btn-primary" name="submit">Update</button>
  </div>
</form>
</div> 

</div>
</div>
</div>
@endsection