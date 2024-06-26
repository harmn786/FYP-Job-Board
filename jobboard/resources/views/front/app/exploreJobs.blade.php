@extends('front.app.master')
@section('content')
<div class="container py-5">
    <section>
    <div class="row">
        <div class="col-6 col-md-10 ">
            <h2>Find Jobs</h2>  
        </div>
        <div class="col-6 col-md-2">
            <div class="align-end">
                
                <select name="sort" id="sort" class="form-control" >
                    <option {{ (Request::get('sort') == 1) ? 'selected' : '' }} value="1">Latest</option>
                    <option {{ (Request::get('sort') == 0) ? 'selected' : '' }} value="0">Oldest</option>
                </select>
            </div>
        </div>
    </div>
<div class="row mt-4">
<div class="col-md-4 col-lg-3 sidebar mb-4 ">
    <form name="searchForm" id="searchForm"  action="" >
        <div class="card border-0 shadow p-4">
            <div class="mb-4">
                <h3>Keywords</h3>
                <input value="{{ Request::get('title') }}" type="text" id="title" name="title" placeholder="title" class="form-control">
            </div>

            <div class="mb-4">
                <h3>Location</h3>
                <input value="{{ Request::get('location') }}" type="text" id="location" name="location" placeholder="Location" class="form-control">
            </div>

            <div class="mb-4">
                <h3>Category</h3>
                <select name="category" id="category" class="form-control">
                    @if ($categories)
                        <option value="">Select Category</option>
                    @foreach ( $categories as $category )
                        <option {{ (Request::get('category') == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>                   

            <div class="mb-4">
                <h3>Job Type</h3>
                @if ($job_types)
                @foreach ($job_types as $type)
                <div class="form-check mb-2"> 
                    <input class="form-check-input " {{ (in_array($type->id,$jobTypeArray)) ? 'checked' : '' }} name="job_type" type="checkbox" value="{{ $type->id }}" id="job-type-{{ $type->id }}">    
                    <label class="form-check-label " for="job-type-{{ $type->id }}">{{ $type->name }}</label>
                </div>
                @endforeach
                    
                @endif

            </div>

            <div class="mb-4">
                <h3>Experience</h3>
                <select name="experience" id="experience" class="form-control">
                    <option value="">Not selected</option>
                    <option {{ (Request::get('experience') == 1) ? 'selected' : '' }} value="1">1 Year</option>
                    <option {{ (Request::get('experience') == 2) ? 'selected' : '' }} value="2">2 Years</option>
                    <option {{ (Request::get('experience') == 3) ? 'selected' : '' }} value="3">3 Years</option>
                    <option {{ (Request::get('experience') == 4) ? 'selected' : '' }} value="4">4 Years</option>
                    <option {{ (Request::get('experience') == 5) ? 'selected' : '' }} value="5">5 Years</option>
                    <option {{ (Request::get('experience') == 6) ? 'selected' : '' }} value="6">6 Years</option>
                    <option {{ (Request::get('experience') == 7) ? 'selected' : '' }} value="7">7 Years</option>
                    <option {{ (Request::get('experience') == 8) ? 'selected' : '' }} value="8">8 Years</option>
                    <option {{ (Request::get('experience') == 9) ? 'selected' : '' }} value="9">9 Years</option>
                    <option {{ (Request::get('experience') == 10) ? 'selected' : '' }} value="10">10 Years</option>
                    <option {{ (Request::get('experience') == 11) ? 'selected' : '' }} value="11">10+ Years</option>
                </select>
            </div>
            <Button type="submit" class="btn btn-success mb-3" >Submit</Button>
        </form>                    
        </div>
        
</div>

<div class="col-md-8 col-lg-9 ">
    <div class="row">
    @foreach($jobs as $job)
    <div class="col-md-4">
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
    </div>
</div>
</div>
</div>
</section>
@endsection
@section('customJs')
<script>
$("#searchForm").submit(function(e){
    e.preventDefault();
        var url = '{{ route("explorejobs") }}?';
        var sort = $("#sort").val();
        var title = $("#title").val();
        var location = $("#location").val();
        var category = $("#category").val();
        var job_type = $("#job_type").val();
        var experience = $("#experience").val();
        
        var checkedJobs = $("input:checkbox[name='job_type']:checked").map(function(){
            return $(this).val();
        }).get();
        if(title != ""){
            url += '&title='+title; 
        }
        if(location != ""){
            url += '&location='+location; 
        }
        if(category != ""){
            url += '&category='+category; 
        }
        if(checkedJobs != ""){
            url += '&job_type='+checkedJobs; 
        }
        if(experience.length > 0){
            url += '&experience='+experience; 
        }
        
        url += '&sort='+sort;
        

        window.location.href=url;


    });


    $("#sort").change(function(){
        $("#searchForm").submit();
    });
</script>
@endsection
