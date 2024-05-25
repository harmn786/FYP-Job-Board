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


  <div class="card border-0 shadow mb-4 rounded p-4">
    <div class="card-body p-4">
      <h2>Edit JobType</h2>
      <form action="{{route('jobtype.update',['jobtypeId' => $jobtype->id])}}" class="" method="POST">
        @csrf
        <div class="row mt-4">
        <div class="mb-3 col-md-6 ">
            <label for="name" class="form-label">Enter Category Name</label>
            <input type="text"   value="{{old('name',$jobtype->name)}}" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Enter JobType Name">
            <span class="text-danger">
              @error('name')
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
  </div>
</div>
</div>
</div>
@endsection