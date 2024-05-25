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
    <form class="p-4 p-md-5 border rounded" action="{{route('employer.updateJob', $job)}}" method="post">
      <h2>Update Job</h2>          
      @csrf
      <div class="row mt-4">
    <div class="mb-3 mt-2 col-md-6">
          <label for="job_title" class="form-label">Job Title<span class="text-danger fw-bold">*</span></label>
          <input type="text" name="job_title" value="{{old('job_title',$job->title)}}" class="form-control @error('job_title') is-invalid  @enderror" id="job-title" placeholder="Product Designer">
          <span class="text-danger">
            @error('job_title')
                {{$message}}
            @enderror
        </span>
        </div>
      
    
        <div class="mb-3 col-md-6">
          <label for="job_type" class="mb-3">Select Job Type<span class="text-danger fw-bold">*</span></label>
          <select name="job_type" value="{{old('job_type')}}" class="form-select border  rounded @error('job_type') is-invalid  @enderror" id="job_type" data-style="btn-black" data-width="100%" data-live-search="true" title="Select Job Type">
            <option value="">Select Job Type</option>
            @if ($job_types->isNotEmpty())
            @foreach ($job_types as $job_type)
            <option {{ ($job->job_type_id == $job_type->id) ? 'selected' : '' }}  value="{{ $job_type->id }}">{{ $job_type->name }}</option>
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
          <label for="vacancy" class="form-label">Vacancy<span class="text-danger fw-bold">*</span></label>
          <input name="vacancy" type="text" value="{{old('vacancy',$job->vacancy)}}"  class="form-control @error('vacancy') is-invalid  @enderror" id="vacancy" placeholder="e.g. 3">
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
            <option {{ ($job->category_id == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
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
          <label for="education" class="form-label">Education<span class="text-danger fw-bold">*</span></label>
          <input name="education" type="text" value="{{old('education',$job->education)}}" class="form-control @error('education') is-invalid  @enderror" id="education" >
          <span class="text-danger">
            @error('education')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3 col-md-6">
          <label for="experience" class="form-label">Experience<span class="text-danger fw-bold">*</span></label>
          <select name="experience"  value="{{old('experience',$job->experience)}}" class="form-select border rounded @error('experience') is-invalid  @enderror" id="experience" data-style="btn-black" data-width="100%" data-live-search="true" title="Select Years of Experience">
            <option {{ ($job->experience == '1 to 3 Years') ? 'selected' : '' }} value="1 to 3 Years">1-3 years</option>
            <option {{ ($job->experience == '3 to 6 Years') ? 'selected' : '' }} value="3 to 6 Years">3-6 years</option>
            <option {{ ($job->experience == '6 to 9 Years') ? 'selected' : '' }} value="6 to 9 Years">6-9 years</option>
          </select>
          <span class="text-danger">
            @error('experience')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3 col-md-6">
          <label for="salary" class="form-label">Salary<span class="text-danger fw-bold">*</span></label>
          <input type="text" name="salary" value="{{old('salary',$job->salary)}}"  class="form-control @error('salary') is-invalid  @enderror" id="salary" placeholder="Salary">
          <span class="text-danger">
            @error('salary')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="mb-3 col-md-6">
          <label for="job_region" class="form-label">job_region<span class="text-danger fw-bold">*</span></label>
          <input name="job_region" value="{{old('job_region',$job->location)}}" type="text" class="form-control @error('job_region') is-invalid  @enderror" id="job_region">
          <span class="text-danger">
            @error('job_region')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="mb-3 col-md-6">
          <label for="gender" class="form-label">Gender<span class="text-danger fw-bold">*</span></label>
          <select name="gender"  value="{{old('gender',$job->gender)}}"  class="form-select border rounded @error('gender') is-invalid  @enderror" id="gender" data-style="btn-black" data-width="100%" data-live-search="true" title="Select Gender">
            <option {{ ($job->gender == 'male') ? 'selected' : '' }} value="male">Male</option>
            <option {{ ($job->gender == 'female') ? 'selected' : '' }} value="female">Female</option>
            <option {{ ($job->gender == 'male/female') ? 'selected' : '' }} value="male/female">Male/Female</option>
          </select>
          <span class="text-danger">
            @error('gender')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="mb-3 col-md-6">
          <label for="application_deadline" class="form-label">Application Deadline<span class="text-danger fw-bold">*</span></label>
          <input name="application_deadline" value="{{old('application_deadline',$job->application_deadline)}}"  type="date" class="form-control @error('application_deadline') is-invalid  @enderror" id="application_deadline" placeholder="e.g. 20-12-2022">
          <span class="text-danger">
            @error('application_deadline')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="form-label" for="job_description">Job Description<span class="text-danger fw-bold">*</span></label> 
            <textarea name="job_description"  id="job_description" cols="30" rows="7" class=" textarea @error('job_description') is-invalid  @enderror" placeholder="Write Job Description...">{{$job->description}}</textarea>
          </div>
          <span class="text-danger">
            @error('job_description')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="form-label" for="">other_requirements<span class="text-danger fw-bold">*</span></label> 
            <textarea name="other_requirements"  id="" cols="30" rows="7" class=" textarea @error('other_requirements') is-invalid  @enderror" placeholder="Write other_requirements..."> {{$job->other_requirements}}</textarea>
          </div>
          <span class="text-danger">
            @error('other_requirements')
                {{$message}}
            @enderror
        </span>
        </div>
        <div class="row mb-3">
          <div class="col-md-12">
            <label class="form-label" for="">Other Benifits<span class="text-danger fw-bold">*</span></label> 
            <textarea name="other_benifits"  id="other_benifits" cols="30" rows="7" class=" textarea @error('other_benifits') is-invalid  @enderror" placeholder="Write Other Benifits...">{{ $job->other_benifits }}</textarea>
          </div>
          <span class="text-danger">
            @error('other_benifits')
                {{$message}}
            @enderror
        </span>
        </div>
     
        <!--company details-->
    
        <div class="mb-3">
          <label for="company_name" class="form-label">company_name<span class="text-danger fw-bold">*</span></label>
          <input name="company_name" type="text" value="{{old('company_name',$job->company_name)}}" class="form-control @error('company_name') is-invalid  @enderror" id="company_name">
          <span class="text-danger">
            @error('company_name')
                {{$message}}
            @enderror
        </span>
        </div>
    
        <div class="mb-3">
          <label for="company_email" class="form-label">company_email<span class="text-danger fw-bold">*</span></label>
          <input name="company_email" value="{{old('company_email',$job->company_email)}}" type="text" class="form-control @error('company_email') is-invalid  @enderror" id="company_email">
          <span class="text-danger">
            @error('company_email')
                {{$message}}
            @enderror
        </span>
        </div>
        </div class="mb-3 ">
                <button type="submit" class="btn btn-success">Update</button>
        </div>
      </div>
      </form>
  </div>
</div>
</div>
</div>
@endsection