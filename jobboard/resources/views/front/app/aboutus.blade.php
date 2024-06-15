{{-- jobs/index.blade.php --}}

@extends('front.app.master')

@section('content')
<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <h2 class=" mb-4">About Us</h2>
        <div class="row g-5 mt-4 bg-white p-4 align-items-center">
            <div class="col-lg-6 ">
                <div class="row g-0 about-bg rounded overflow-hidden">
                    <div class="col-6 text-start">
                        <img class="img-fluid w-100" src="images/about-1.jpg">
                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid" src="images/about-2.jpg" style="width: 85%; margin-top: 15%;">
                    </div>
                    <div class="col-6 text-end">
                        <img class="img-fluid" src="images/about-3.jpg" style="width: 85%;">
                    </div>
                    <div class="col-6 text-end">
                        <img class="img-fluid w-100" src="images/about-4.jpg">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn " data-wow-delay="0.5s">
                <h1 class="mb-4">We Help To Get The Best Job And Find A Talent</h1>
                <p class="mb-4">Here you can find thousands of jobs that match your expertise with your related field you can search jobs by:</p>
                <p><i class="fa fa-check text-primary me-3"></i>Job Catejory</p>
                <p><i class="fa fa-check text-primary me-3"></i>Job Location</p>
                <p><i class="fa fa-check text-primary me-3"></i>Job Title</p>
                <a class="btn btn-primary py-3 px-5 mt-3" href="">Read More</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->  
@endsection
