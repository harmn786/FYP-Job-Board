@extends('master')

@section('content')
    <div class="container">
        <h2>Job Search</h2>

        {{-- Search Form --}}
        <form method="get" action="{{ route('jobs.index') }}">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="title">Job Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ request('title') }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="category">Category</label>
                    <input type="text" class="form-control" id="category" name="category" value="{{ request('category') }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ request('location') }}">
                </div>
                <div class="form-group col-md-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        
    </div>
@endsection
