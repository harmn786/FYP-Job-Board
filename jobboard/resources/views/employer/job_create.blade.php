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
    <form class="p-4 p-md-5 w-100 border rounded" action="{{route('jobs.store')}}" method="post">
      <h1>Job Creation Form</h1>     
        <!--job details-->
      @csrf
      <div class="row mt-4">
        <div class="mb-3 col-md-6">
          <label for="job_title" class="mb-2">Job Title<span class="text-danger fw-bold">*</span></label>
          <input type="text" name="job_title" value="{{old('job_title')}}" class="form-control @error('job_title') is-invalid  @enderror" id="job-title" placeholder="Product Designer">
          <span class="text-danger">
            @error('job_title')
                {{$message}}
            @enderror
        </span>
        </div>
      
    
        <div class="mb-3 col-md-6">
          <label for="job_type" class="mb-2">Select Job Type<span class="text-danger fw-bold">*</span></label>
          <select name="job_type" value="{{old('job_type')}}" class="form-select border  rounded @error('job_type') is-invalid  @enderror" id="job_type" data-style="btn-black" data-width="100%" data-live-search="true" title="Select Job Type">
            <option value="">Select Job Type</option>
            @if ($job_types->isNotEmpty())
            @foreach ($job_types as $job_type)
            <option value="{{ $job_type->id }}">{{ $job_type->name }}</option>
            @endforeach
            @endif
          </select>
          <span class="text-danger">
            @error('job_type')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3 col-md-6">
          <label for="vacancy" class="mb-2">Vacancy<span class="text-danger fw-bold">*</span></label>
          <input name="vacancy" type="text" value="{{old('vacancy')}}" class="form-control @error('vacancy') is-invalid  @enderror" id="vacancy" placeholder="e.g. 3">
          <span class="text-danger">
            @error('vacancy')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3 col-md-6">
          <label for="category" class="mb-2">Select Category<span class="text-danger fw-bold">*</span></label>
          <select name="category" value="{{old('category')}}" class="form-select border  rounded @error('category') is-invalid  @enderror" id="category" data-style="btn-black" data-width="100%" data-live-search="true" title="Select Job Category">
            <option value="">Select a Category</option>
            @if ($categories->isNotEmpty())
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
            @endif
          </select>
          <span class="text-danger">
            @error('category')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3 col-md-6">
          <label for="education" class="mb-2">Education<span class="text-danger fw-bold">*</span></label>
          <input name="education" type="text" value="{{old('education')}}" class="form-control @error('education') is-invalid  @enderror" id="education" >
          <span class="text-danger">
            @error('education')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3 col-md-6">
          <label for="experience" class="mb-2">Experience<span class="text-danger fw-bold">*</span></label>
          <select name="experience" value="{{old('experience')}}" class="form-select border  rounded @error('experience') is-invalid  @enderror" id="experience" data-style="btn-black" data-width="100%" data-live-search="true" title="Select Years of Experience">
            <option value="No Experience">No Experience</option>
            <option value="1 Year">1 Year</option>
            <option value="2 Years">2 Years</option>
            <option value="3 Years">3 Years</option>
            <option value="4 Years">4 Years</option>
            <option value="5 Years">5 Years</option>
          </select>
          <span class="text-danger">
            @error('experience')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3 col-md-6">
          <label for="salary" class="mb-2">Salary<span class="text-danger fw-bold">*</span></label>
          <input type="text" name="salary"  value="{{old('salary')}}" class="form-control @error('salary') is-invalid  @enderror" id="salary" placeholder="Salary">
          <span class="text-danger">
            @error('salary')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3 col-md-6">
          <label for="job_region" class="mb-2" >job_region<span class="text-danger fw-bold">*</span></label>
          <input name="job_region" type="text" value="{{old('job_region')}}" class="form-control @error('job_region') is-invalid  @enderror" id="job_region">
          <span class="text-danger">
            @error('job_region')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="mb-3 col-md-6">
          <label for="gender" class="mb-2">Gender<span class="text-danger fw-bold">*</span></label>
          <select name="gender" value="{{old('gender')}}" class="form-select border rounded @error('gender') is-invalid  @enderror" id="gender" data-style="btn-black" data-width="100%" data-live-search="true" title="Select Gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="male/female">Male/Female</option>
          </select>
          <span class="text-danger">
            @error('gender')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="mb-3 col-md-6">
          <label for="application_deadline" class="mb-2">Application Deadline<span class="text-danger fw-bold">*</span></label>
          <input name="application_deadline" value="{{old('application_deadline')}}" type="date" class="form-control @error('application_deadline') is-invalid  @enderror" id="application_deadline" placeholder="e.g. 20-12-2022">
          <span class="text-danger">
            @error('application_deadline')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="mb-2" for="">Job Description<span class="text-danger fw-bold">*</span></label> 
            <textarea name="job_description" value="{{old('job_description')}}" id="" cols="30" rows="7" class=" textarea @error('job_description') is-invalid  @enderror" placeholder="Write Job Description..."></textarea>
          </div>
          <span class="text-danger">
            @error('job_description')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="mb-2" for="other_requirements">other_requirements<span class="text-danger fw-bold">*</span></label> 
            <textarea name="other_requirements" value="{{old('other_requirements')}}" id="" cols="30" rows="7" class=" textarea @error('other_requirements') is-invalid  @enderror" placeholder="Write other_requirements..."></textarea>
          </div>
          <span class="text-danger">
            @error('other_requirements')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="mb-2" for="">Other Benifits<span class="text-danger fw-bold">*</span></label> 
            <textarea name="other_benifits" value="{{old('other_benifits')}}" id="other_benifits" cols="30" rows="7" class=" textarea @error('other_benifits') is-invalid  @enderror" placeholder="Write Other Benifits..."></textarea>
          </div>
          <span class="text-danger">
            @error('other_benifits')
                {{$message}}
            @enderror
        </span>
        </div>
     
        <!--company details-->
    
        <div class="mb-3">
          <label for="company_name" class="mb-2">company_name<span class="text-danger fw-bold">*</span></label>
          <input name="company_name" type="text"  value="{{old('company_name')}}" class="form-control @error('company_name') is-invalid  @enderror" id="company_name">
          <span class="text-danger">
            @error('company_name')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="mb-3">
          <label for="company_email" class="mb-2">company_email<span class="text-danger fw-bold">*</span></label>
          <input name="company_email" type="text" value="{{old('company_email')}}" class="form-control @error('company_email') is-invalid  @enderror" id="company_email">
          <span class="text-danger">
            @error('company_email')
                {{$message}}
            @enderror
        </span>
        </div>
        
        <div class="mb-3 ">
                <button type="submit" name="submit" class="btn  btn-success btn-md"  value="Save Job">Post </button>
        </div>
    
      </div>
      </form>
  </div>
</div>
</div>
</div>
@endsection