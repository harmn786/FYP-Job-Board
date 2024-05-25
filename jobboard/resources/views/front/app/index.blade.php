@extends('front.app.master')
@section('content')
    <div class="wraper">
        <div class="container text-center">
        <div class="col-12 pt-5">
            <h1 class="hero-heading text-white ">Find your dream job</h1>
            <p class="hero-sub-heading text-white lh-1 " id="typing"  onload="typeWriter();"></p>
            <div class="banner-btn mt-5"><a href="{{ route('explorejobs') }}" class="btn btn-success shadow mb-4 me-2 mb-sm-0">Explore Now</a><a href="{{route('userregister')}}" class="btn btn-outline-success-hero  shadow mb-4  mb-sm-0">Register Now</a></div>
        </div>
    </div>
    </div>
</div>
    <section class="site-section">
        <div class="">
            <div class="container">
        {{-- Search Form --}}
        <form method="get" action="{{ route('jobs.index') }}" class="customize-form  pt-5 pb-5 rounded" style=" min-width:100%; padding: 20px; ">
                <div class="row">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control mb-2 mt-2" id="title" name="title" value="{{ request('title') }}" placeholder="Job-Title">
                </div>
                <div class="form-group col-md-3 mb-2 mt-2">
                    <select name="category"  value="{{old('category')}}" class="form-select border  rounded @error('category') is-invalid  @enderror" id="category" data-style="btn-black" data-width="100%" data-live-search="true" title="Select Job Category">
                        <option value="">Select a Category</option>
                        @if ($categories->isNotEmpty())
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control mb-2 mt-2" id="location" name="location" value="{{ request('location') }}" placeholder="Job-Location">
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-success mb-2 mt-2" style=" min-width:100%; " >Search</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="bg-light pt-4 pb-5">
        <div class="container">
            <h2 class="" >Job Categories</h2>
            <div class="row ">
            @foreach ($categories as $category)
            <div class="col-lg-3 " >
                <a class="text-decoration-none text-dark" href="{{ route('jobs.jobsByCategory', $category->id ) }}">
                <div class="card mt-4 shadow ">
                    <div class="card-body ">
                        <div class=" d-flex justify-content-start align-items-start flex-column rounded" style="line-height:0.5em">
                        <span class=" h4 fs-4 fw-bolder">{{ $category->name }}</span><br>
                        <p><span class=" fs-5 fw-bold">{{ $category->jobs->where('category_id',$category->id  )->count() }}</span> Vacancy</p>
                        </div>
                        {{-- Add other job details as needed --}}
                    </div>
                </div>
            </a>
                </div>
                
            @endforeach
            {{-- <div>
                {{$jobs->links()}}
            </div> --}}
            </div> 
        </div>
        </div>

        <div class="pt-4 pb-5">
<div class="container">
    <h2 class="" >Latest Jobs</h2>
<div class="row">

@foreach ($jobs as $job)
<div class="col-md-4">
    <div class="card border-0 p-3 shadow mb-4 mt-4">
        <div class="card-body">
            <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
            <p>{{ Str::words(strip_tags($job->description), $words=5, '...') }}</p>
            <div class="bg-light p-3 border">
                <p class="mb-0">
                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                    <span class="ps-1">{{ $job->location }}</span>
                </p>
                <p class="mb-0">
                    <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                    <span class="ps-1">{{ $job->jobType->name }}</span>
                </p>
                <p class="mb-0">
                    <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                    <span class="ps-1">${{ $job->salary }}</span>
                </p>
            </div>

            <div class="d-grid mt-3">
                <a href="{{ route('jobs.jobDetail', $job->id) }}" class="btn btn-success btn-lg">Details</a>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- <div>
    {{$jobs->links()}}
</div> --}}
</div>
</div> 
</div>

<div class="pt-4 pb-5 bg-light">
<div class="container">
<h2 class="" >Featured Jobs</h2>
<div class="row">
@foreach($featured_jobs as $featured_job)
<div class="col-md-4">
    <div class="card border-0 p-3 shadow mb-4 mt-4">
        <div class="card-body">
            <h3 class="border-0 fs-5 pb-2 mb-0">{{ $featured_job->title }}</h3>
            <p>{{ Str::words(strip_tags($featured_job->description), $words=5, '...') }}</p>
            <div class="bg-light p-3 border">
                <p class="mb-0">
                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                    <span class="ps-1">{{ $featured_job->location }}</span>
                </p>
                <p class="mb-0">
                    <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                    <span class="ps-1">{{ $featured_job->jobType->name }}</span>
                </p>
                <p class="mb-0">
                    <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                    <span class="ps-1">${{ $featured_job->salary }}</span>
                </p>
            </div>

            <div class="d-grid mt-3">
                <a href="{{ route('jobs.jobDetail', $featured_job->id) }}" class="btn btn-success btn-lg">Details</a>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- <div>
    {{$featured_jobs->links()}}
</div> --}}
</div>
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
                <a href="{{ route('jobs.jobDetail', $job->id) }}" class="btn btn-success">View Details</a>
            </div>
        </div>
    </div>
</div>    --}}

 <!-- Contact Start -->
 <div class="pt-4 pb-5">
    <div class="container">
        <h2>Contact Us</h2>
        <div class="row g-4 mt-5 mb-5 p-3 bg-white shadow ">
            <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29035.235998024!2d81.28556709234934!3d24.54068012824352!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39845a348b85dbbd%3A0xbc368e68a40a6da9!2sRewa%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1664383570024!5m2!1sen!2sin" width="530" height="470" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6">
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
                <div class="wow fadeInUp" data-wow-delay="0.5s">
                    <p class="mb-4">Lorem ipsum dolor, sit amet consectetur adipisicing elit
                        Nequaperiam inventore, suscipit dolorem quae eius in omnis laboriosam consequuntur facilis consequatur! Obcaecati, placeat.
                          </a></p>
                    <form action="{{ route('addContactUsData') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Your Name">
                                    <label for="name">Your Name</label>
                                    <span class="text-danger">
                                        @error('name')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid  @enderror" id="email" name="email" placeholder="Your Email">
                                    <label for="email">Your Email</label>
                                    <span class="text-danger">
                                        @error('email')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('subject') is-invalid  @enderror" name="subject" id="subject" placeholder="Subject">
                                    <label for="subject">Subject</label>
                                    <span class="text-danger">
                                        @error('subject')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('message') is-invalid  @enderror" name="message" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                    <label for="message">Message</label>
                                    <span class="text-danger">
                                        @error('message')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success w-100 py-3" type="submit" name="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

 </div>
 <!-- Contact End -->
</section>
@endsection
@section('customJs')
<script>
    var i = 0;
    var txt = "Thounsands of jobs available.";
    var speed = 80;
    function typeWriter() {
    if (i < txt.length) {
      document.getElementById("typing").innerHTML += txt.charAt(i);
      i++;
      setTimeout(typeWriter, speed);
    }
    }
    </script>

@endsection