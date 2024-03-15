{{-- jobs/index.blade.php --}}

@extends('master')

@section('content')
    <div class="container">
        <h2>Job Search</h2>

        {{-- Search Form --}}
        <form method="get" action="{{ route('jobs.index') }}">
        {{-- Job Results --}}
        @if(count($jobs) > 0)
            <table class="table table-striped mt-4  border-0 rounded w-100 ml-auto mr-auto shadow">
                <thead>
                    <tr class="text-white bg-dark">
                        <th>Job Title</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>View Detail</th>
                        {{-- Add other job details as needed --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->category }}</td>
                            <td>{{ $job->location }}</td>
                            <td><a href="{{ route('jobs.show', $job->id) }}">View Details</a></td>
                            {{-- Add other job details as needed --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No jobs found.</p>
        @endif
    </div>
@endsection
