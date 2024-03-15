@extends('master')
@section('content')
<div class="container py-5">
<div class="row">
    {{View::make('sidebar')}}
    <div class="col-lg-9">
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

  <div class="card border-0 shadow mb-4 p-2">
    @if(count($favorites) > 0)
    <h1 class="">Favorite Jobs</h1>
        <table class="table table-striped table-responsive  border-0 rounded w-100 ml-auto  mr-auto ">
            <caption class="">Favorite Jobs</caption>
            <thead>
                <tr class="bg-dark text-white">
                    <th>Job Title</th>
                    <th>Salary</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Detail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($favorites as $favorite)
                    <tr>
                        <td>{{ $favorite->title }}</td>
                        <td>${{ $favorite->salary }}</td>
                        <td>{{ $favorite->type }}</td>
                        <td>{{ $favorite->location }}</td>
                        <td><a class="btn btn-primary" href="{{ route('jobs.show', $favorite->id) }}">View Details</a>
                        </td>
                        <td>
                          <form action="{{ route('favorite.remove') }}" method="POST" class="form form-inline">
                            @csrf
                            <input type="hidden" name="job_id" value="{{ $favorite->id }}">
                            <button type="submit" class="btn btn-warning">Un-Favorite</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No Data found</p>
    @endif
      </div>
</div>
</div>
</div>
</div>
@endsection
