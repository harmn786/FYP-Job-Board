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
    <section class="section-4 bg-2 pt-5">    
      {{-- <div class="container pt-5">
          <div class="row">
              <div class="col">
                  <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                      <ol class="breadcrumb mb-0">
                          <li class="breadcrumb-item"><a href="jobs.html"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                      </ol>
                  </nav>
              </div>
          </div> 
      </div> --}}
          <div class="row">
              <div class="col">
                  <h2>Job-Detail</h2>
              </div>
          </div> 
          <div class="row pb-5 mt-4">
              <div class="col-md-8 ">
                  <div class="card shadow border-0 p-5">
                      <div class="job_details_header">
                          <div class="single_jobs white-bg d-flex justify-content-between">
                              <div class="jobs_left d-flex align-items-center">
                                  <div class="jobs_conetent">
                                          <h4 class="text-success">{{ $job->title }}</h4>
                                      <div class="links_locat d-flex align-items-center">
                                          <div class="location">
                                              <p> <i class="fa fa-map-marker"></i>{{ $job->location }}</p>
                                          </div>
                                          <div class="location">
                                              <p> &nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o"></i>{{ $job->type }}</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="jobs_right">
                                  <div class="apply_now">
                                      <a class="heart_mark" href="#"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="border-bottom mb-2"></div>

                      <div class="descript_wrap white-bg">
                          <div class="single_wrap">
                              <h4>Job description</h4>
                            <p>{{ $job->description }}</p>
                          </div>
                          <div class="single_wrap">
                              <h4>Other Requirements</h4>
                              <p>{{ $job->other_requirements }}</p>
                          </div>
                          <div class="single_wrap">
                              <h4>Qualifications</h4>
                              <p>{{ $job->education }}</p>
                          </div>
                          <div class="single_wrap">
                            <h4>Experience</h4>
                            <p>{{ $job->experience }}</p>
                        </div>
                          <div class="single_wrap">
                              <h4>Benefits</h4>
                              <p>{{ $job->other_benifits }}</p>
                          </div>
                          <div class="border-bottom"></div>
                          <div class="pt-3 text-end">

                            <!-- Add to Favorites Link -->
                              @if (auth()->check() && auth()->user()->jobSeeker)
                              <form action="{{ route('jobs.addToFavorites', $job->id) }}" method="post">
                                      @csrf
                                      <button type="submit" class="btn btn-warning">Add to Favorites</button>
                                  </form>
                                
                              @endif
                              {{-- <a href="#" class="btn btn-secondary">Add To Favorite</a> --}}
                              <!-- Apply for Job Link -->
                              @if (auth()->check() && auth()->user()->jobSeeker)
                              <form action="{{ route('jobs.applyJob', $job->id) }}" method="post">
                                  @csrf
                                  <button type="submit" class="btn btn-success mt-4">Apply For Job</button>
                                  <a href="{{ route('home') }}" class="btn btn-primary" style="float: right;">Back to Job Listings</a>
                              </form>

                              @else
                                  <a href="{{ route('userlogin') }}" class="btn btn-success" style="float: right;">Login To Apply for Job</a>
                                  <a href="{{ route('home') }}" class="btn btn-primary" style="">Back to Job Listings</a>
                              @endif
                              {{-- <a href="#" class="btn btn-primary">Apply</a> --}}
                              
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 job-summery">
                  <div class="card shadow border-0 p-3 ">
                      <div class="job_sumary">
                          <div class="summery_header pb-1 pt-4">
                              <h4 class="text-success">Job Summery</h4>
                          </div>
                          <div class="border-bottom"></div>
                          <div class="job_content pt-3">
                              <ul class="list-circle">
                                  <li>Application Deadline: <span>{{\Carbon\Carbon::parse( $job->application_deadline)->format('d M, Y') }}</span></li>
                                  <li>Vacancy: <span>{{ $job->vacancy }}</span></li>
                                  <li>Salary PKR: <span> {{ $job->salary }}</span></li>
                                  <li>Location: <span>{{ $job->location }}</span></li>
                                  <li>Job Nature: <span> {{ $job->type }}</span></li>
                              </ul>
                          </div>
                      </div>
                  </div>
                  <div class="card shadow border-0 my-4 p-3">
                      <div class="job_sumary">
                          <div class="summery_header pb-1 pt-4">
                              <h4 class="text-success">Company Details</h4>
                          </div>
                          <div class="border-bottom"></div>
                          <div class="job_content pt-3">
                              <ul class="list-circle">
                                  <li>Name: <span>{{ $job->company_name }}</span></li>
                                  <li>Locaion: <span>{{ $job->location }}</span></li>
                                  <li>Email: <span>{{ $job->company_email }}</span></li>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  </section>


</div>
@endsection