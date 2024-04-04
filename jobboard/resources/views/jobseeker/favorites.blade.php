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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($favorites as $favorite)
                    <tr>
                        <td>{{ $favorite->title }}</td>
                        <td>${{ $favorite->salary }}</td>
                        <td>{{ $favorite->type }}</td>
                        <td>{{ $favorite->location }}</td>
                        <td>
                            <div class="action-dots float-end">
                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    {{-- <li><a class="dropdown-item" href=""> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li> --}}
                                    <li><a class="dropdown-item" href="{{ route('jobs.jobDetail', $favorite->id) }}"><i class="fa fa-eye" aria-hidden="true"></i> View Detail</a></li>
                                    <li><a class="dropdown-item" href="{{ route('favorite.remove',[ 'favoriteId' => $favorite->id ]) }}"><i class="fa fa-trash" aria-hidden="true"></i> Remove From Favoritee</a></li>
                                </ul>
                            </div>
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
