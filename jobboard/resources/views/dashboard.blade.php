@extends('master')
@section('content')
<div class="container py-5">
<div class="row">
    {{View::make('sidebar')}}
    <div class="col-lg-9">

        
        <div class="card border-0 shadow mb-4">
            <div class="card-body  p-4">
                <h1 class="text-center">Welcome To Profile</h1>                
            </div>
        </div>              
    </div>
</div>
</div>
@endsection