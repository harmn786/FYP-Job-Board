@extends('master')
@section('content')
@if(session()->get('message'))
  <div class="alert alert-success" role="alert">
    <strong>Success: </strong>{{session()->get('message')}}
  </div>
  @endif
  @if(session()->has('user'))
  <p>Welcome To the Home Page </p>
<h1>{{session()->get('user')->name;}}</h1>
@endif
@endsection
