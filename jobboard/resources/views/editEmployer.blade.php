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
    <form action="{{route('Employer.update')}}" class=" p-5 border rounded " method="POST">
      <h1>Profile</h1>
      @csrf
      <div class="form-group">
          <label for="name">Enter Your Name</label>
          <input type="text" value="{{old('name',$employer->name)}}" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Enter Employee Name">
          <span class="text-danger">
            @error('name')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="form-group">
          <label for="email">Enter Your Email</label>
          <input type="text" value="{{old('email',$employer->email)}}" id="email" class="form-control @error('email') is-invalid  @enderror" name="email" placeholder="Enter Your Email">
          <span class="text-danger">
            @error('email')
                {{$message}}
            @enderror
        </span>
        </div>
        
        <div class="form-group">
          <label for="industry">Enter Your Industry</label>
          <input type="text" value="{{old('industry',$employer->industry)}}" class="form-control @error('industry') is-invalid  @enderror" id="industry" name="industry" placeholder="Enter Your industry">
          <span class="text-danger">
            @error('industry')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="form-group">
          <label for="contact_person">Enter Your contact_person Name</label>
          <input type="text" value="{{old('contact_person',$employer->contact_person)}}" id="contact_person" class="form-control @error('contact_person') is-invalid  @enderror" name="contact_person" placeholder="Enter Your contact_person">
          <span class="text-danger">
            @error('contact_person')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="form-group">
          <label for="contact_number">Enter company contact_number</label>
          <input type="text" value="{{old('contact_number',$employer->contact_number)}}" id="contact_number" class="form-control @error('contact_number') is-invalid  @enderror" name="contact_number" placeholder="Enter Your contact_number">
          <span class="text-danger">
            @error('contact_number')
                {{$message}}
            @enderror
        </span>
      </div>
      <Button type="submit" class="btn btn-primary" name="submit">Update</Button>
  </form>
  </div>
  <div class="card border-0 shadow mb-4">
  
    <form action="{{route('Employer.updateImage')}}" class="p-5 border  rounded " method="POST" enctype="multipart/form-data">
      <h1 class="">Add/Update Image</h1>
      @csrf
      <div class="form-group">
        <label for="image">Upload Your image</label>
        <input name="image" value="{{old('image')}}" type="file" class="form-control @error('image') is-invalid  @enderror" id="image">
        <span class="text-danger">
          @error('image')
              {{$message}}
          @enderror
      </span>
      </div>
      @if($employer->img_path)
      <p class="text-success">Image is already uploaded</p>
    @endif
      <Button type="submit" class="btn btn-primary" name="submit">Update</Button>
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