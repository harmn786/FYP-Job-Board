{{-- jobs/index.blade.php --}}

@extends('front.app.master')

@section('content')
    <div class="container">
        <h2>Job Search</h2>
        <div class="col-md-8 col-lg-9 ">
            <div class="row">
                @if (count($jobs)>0)
            @foreach($jobs as $job)
            <div class="col-md-4 mt-4">
                <div class="card border-0 p-3 shadow mb-4">
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
                
                <div>
                    {{$jobs->links()}}
                </div>
                @else
                <p>Jobs Not Found</p>
                @endif
            </div>
        </div>
    </div>
@endsection
