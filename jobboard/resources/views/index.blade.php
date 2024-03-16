@extends('master')
@section('content')

    @if(session()->get('success'))
  <div class="alert alert-success" role="alert">
    <strong>Success: </strong>{{session()->get('success')}}
  </div>
  @endif
    <div class="wraper">
        <div class="container">
        <div class="col-12 col-xl-8 pt-5">
            <h1 class="hero-heading text-white">Find your dream job</h1>
            <p class="hero-sub-heading text-white">Thounsands of jobs available.</p>
            <div class="banner-btn mt-5"><a href="#" class="btn btn-success mb-4 mb-sm-0">Explore Now</a></div>
        </div>
    </div>
    </div>
</div>
    <section class="site-section">
        <div class="container">
        {{-- Search Form --}}
        <form method="get" action="{{ route('jobs.index') }}" class="customize-form  pt-5 pb-5 rounded" style=" min-width:100%; padding: 20px; ">
            <div class="row">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control mb-2 mt-2" id="title" name="title" value="{{ request('title') }}" placeholder="Job-Title">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control mb-2 mt-2" id="category" name="category" value="{{ request('category') }}" placeholder="Job-Category">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control mb-2 mt-2" id="location" name="location" value="{{ request('location') }}" placeholder="Job-Location">
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-success mb-2 mt-2" style=" min-width:100%; " >Search</button>
                </div>
            </div></form>


            
          <h2 class="" >Available Jobs</h2>
<div class="row">
@foreach($jobs as $job)
<div class="col-lg-3 mb-4">
    <div class="card mt-4 shadow">
        <div class="card-body">
            <h5 class="card-title">{{ $job->title }}</h5>
            <div class="border-bottom" style="border-color:green; "></div>
            <p class="card-text">Salary: ${{ $job->salary }}</p>
            <p class="card-text">Type: {{ $job->type }}</p>
            <p class="card-text">Location: {{ $job->location }}</p>
            <p class="card-text">Posted by: {{ $job->employer->name }}</p>
            <div class="border-bottom my-2"></div>
            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-success">View Details</a>
            {{-- Add other job details as needed --}}
        </div>
    </div>
    </div>
@endforeach
<div>
    {{$jobs->links()}}
</div>
</div> 
{{-- <div class="col-md-4">
    <div class="card border-0 p-3 shadow mb-4">
        <div class="card-body">
            <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
            <p>We are in need of a {{ $job->title }} for our company.</p>
            <div class="bg-light p-3 border">
                <p class="mb-0">
                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                    <span class="ps-1">{{ $job->location }}</span>
                </p>
                <p class="mb-0">
                    <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                    <span class="ps-1">{{ $job->type }}</span>
                </p>
                <p class="mb-0">
                    <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                    <span class="ps-1">${{ $job->salary }}</span>
                </p>
            </div>

            <div class="d-grid mt-3">
                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-success">View Details</a>
            </div>
        </div>
    </div>
</div>    --}}

</div>
</section>
@endsection