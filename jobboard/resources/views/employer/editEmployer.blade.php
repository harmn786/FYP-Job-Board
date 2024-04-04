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

  <div class="card border-0 shadow mb-3">
    <form action="{{route('Employer.update')}}" class=" p-5 border rounded " method="POST">
      <h1>Profile</h1>
      @csrf
      <div class="mb-3">
          <label for="name" class="mb-2">Enter Your Name</label>
          <input type="text" value="{{old('name',$employer->name)}}" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Enter Employee Name">
          <span class="text-danger">
            @error('name')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3">
          <label for="email" class="mb-2">Enter Your Email</label>
          <input type="text" value="{{old('email',$employer->email)}}" id="email" class="form-control @error('email') is-invalid  @enderror" name="email" placeholder="Enter Your Email">
          <span class="text-danger">
            @error('email')
                {{$message}}
            @enderror
        </span>
        </div>
        
        <div class="mb-3">
          <label for="industry" class="mb-2">Enter Your Industry</label>
          <input type="text" value="{{old('industry',$employer->industry)}}" class="form-control @error('industry') is-invalid  @enderror" id="industry" name="industry" placeholder="Enter Your industry">
          <span class="text-danger">
            @error('industry')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3">
          <label for="contact_person" class="mb-2">Enter Your contact_person Name</label>
          <input type="text" value="{{old('contact_person',$employer->contact_person)}}" id="contact_person" class="form-control @error('contact_person') is-invalid  @enderror" name="contact_person" placeholder="Enter Your contact_person">
          <span class="text-danger">
            @error('contact_person')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3">
          <label for="contact_number" class="mb-2">Enter company contact_number</label>
          <input type="text" value="{{old('contact_number',$employer->contact_number)}}" id="contact_number" class="form-control @error('contact_number') is-invalid  @enderror" name="contact_number" placeholder="Enter Your contact_number">
          <span class="text-danger">
            @error('contact_number')
                {{$message}}
            @enderror
        </span>
      </div>
      <Button type="submit" class="btn btn-success" name="submit">Update</Button>
  </form>
  </div>

  <div class="card border-0 shadow mb-3">
    <div class="card-body p-4">
      <form action="{{ route('changePassword') }}" method="POST">
        @csrf
        <h3 class="fs-4 mb-1">Change Password</h3>
        <div class="mb-3">
            <label for="old_password" class="mb-2">Old Password*</label>
            <input type="password" name="old_password" placeholder="Old Password" class="form-control @error('old_password') is-invalid @enderror">
            <span class="text-danger">
              @error('old_password')
                  {{$message}}
              @enderror
          </span>
        </div>
        <div class="mb-3">
            <label for="new_password" class="mb-2">New Password*</label>
            <input type="password" name="new_password"  placeholder="New Password" class="form-control @error('new_password') is-invalid @enderror">
            <span class="text-danger">
              @error('old_password')
                  {{$message}}
              @enderror
        </div>
        <div class="mb-3">
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