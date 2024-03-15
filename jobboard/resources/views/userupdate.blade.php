@php
use App\Models\User;
   $userdata = User::Find(Session::get('user')['id']);
   compact('userdata');
@endphp
@extends('master')
@section('content')
@if(session()->get('message'))
  <div class="alert alert-success" role="alert">
    <strong>Success: </strong>{{session()->get('message')}}
  </div>
  @endif
  @if(session()->get('error'))
  <div class="alert alert-danger" role="alert">
    <strong>Error: </strong>{{session()->get('error')}}
  </div>
  @endif
<div class="container">
  <h1 class="heading">User Update Profile Form</h1>
    <form action="{{url('updateUserData/'.Session::get('user')['id'])}}" class="customize-form p-4  border rounded mt-4" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" value="{{$userdata->username}}" class="form-control @error('name') is-invalid  @enderror" name="name" placeholder="Enter Employee Name"><br><br>
    <span class="text-danger">
        @error('name')
            {{$message}}
        @enderror
    </span>
    <input type="text" value="{{$userdata->email}}" class="form-control @error('email') is-invalid  @enderror"  name="email"  placeholder="Enter Your Email"><br><br>
    <span class="text-danger">
        @error('email')
            {{$message}}
        @enderror
    </span>
    <input type="text" value="{{$userdata->contactno}}" class="form-control @error('contactno') is-invalid  @enderror" name="contactno" placeholder="Enter Contact No"><br><br>
    <span class="text-danger">
        @error('contactno')
            {{$message}}
        @enderror
    </span>
    <input type="text" value="{{$userdata->bio}}" class="form-control @error('bio') is-invalid  @enderror" name="bio" placeholder="Enter Your Bio"><br><br>
    <span class="text-danger">
        @error('bio')
            {{$message}}
        @enderror
    </span>
    <input type="text" value="{{$userdata->title}}" class="form-control @error('title') is-invalid  @enderror" name="title" placeholder="Enter Title"><br><br>
    <span class="text-danger">
        @error('title')
            {{$message}}
        @enderror
    </span>
    <label for="select-image">Select Image</label>
    <input type="file" value="{{$userdata->img}}" id="select-image" name="img" placeholder="Upload Image" class="form-control @error('img') is-invalid  @enderror"><br><br>
    <span class="text-danger">
        @error('img')
            {{$message}}
        @enderror
    </span>
    <input type="text" value="{{$userdata->facebook}}" class="form-control @error('facebook') is-invalid  @enderror" name="facebook" placeholder="Enter Facebook Link"><br><br>
    <span class="text-danger">
        @error('facebook')
            {{$message}}
        @enderror
    </span>
    <input type="text" value="{{$userdata->twitter}}" class="form-control @error('twiter') is-invalid  @enderror" name="twitter" placeholder="Enter Twitter Link"><br><br>
    <span class="text-danger">
        @error('twitter')
            {{$message}}
        @enderror
    </span>
    <input type="text" value="{{$userdata->linkedin}}" class="form-control @error('linkedin') is-invalid  @enderror" name="linkedin" placeholder="Enter LinkenIn Link"><br><br>
    <span class="text-danger">
        @error('linkedin')
            {{$message}}
        @enderror
    </span>
    <br><br>
    <Button type="submit" class="btn btn-primary" name="submit">Submit</Button>
    <span class="log-condition">(Already Member) <a href="{{route('userlogin')}}">Go To Login</a></span>
</form>
</div>
  @endsection