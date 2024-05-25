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
            <div class="card-body  p-4">
                <h1 class="text-center"><i class="fa fa-dashboard" aria-hidden="true"></i>&nbsp;Welcome To Dashboard</h1>                
            </div>
        </div>              
    </div>
</div>
</div>
@endsection