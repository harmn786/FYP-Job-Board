<!-- {{-- jobs/index.blade.php --}} -->

@extends('master')

@section('content')
    <div class="container">
        <h2>Available Jobs</h2>

        @foreach($jobs as $job)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $job->title }}</h5>
                    <p class="card-text">Salary: ${{ $job->salary }}</p>
                    <p class="card-text">Type: {{ $job->type }}</p>
                    <p class="card-text">Location: {{ $job->location }}</p>
                    <p class="card-text">Posted by: {{ $job->employer->name }}</p>
                    {{-- Add other job details as needed --}}
                </div>
            </div>
            <br>
        @endforeach
    </div>
@endsection
