{{-- jobs/index.blade.php --}}

@extends('front.app.master')

@section('content')
    <div class="container">
        <h2 class="mt-4">Job Categories</h2>
        <div class="row">
        @foreach ($categories as $category)
        <div class="col-lg-3 mb-4" >
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
        <div>
            {{$categories->links()}}
        </div>
    </div>
    
    </div>
@endsection
