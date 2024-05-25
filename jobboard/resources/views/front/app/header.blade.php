@php
use App\Models\User;
if(Session::has('user')){
  
   $userdata = User::Find(Session::get('user')['id']);
   compact('userdata');
}

@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3 align-items-center">
  <div class="container">
    <a class="navbar-brand logo d-inline " href="{{route('home')}}"><i class="fs-4">Job-<span class="text-dark">Board</span></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav   mb-2 mb-lg-0 ms-auto ">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('explorejobs') }}">Jobs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('categories') }}">Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('aboutus') }}">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('contactus') }}">Contact Us</a>
        </li>
        
        @if(Session::has('user'))
        @if ($userdata->role === "job_seeker" || $userdata->role === "company" || $userdata->role === "admin")
          <li class="nav-item">
            <a class="nav-link " href="{{route('dashboard')}}">Dashboard</a>
          </li>
          @endif
          @endif

        <li class="nav-item dropdown">

          @if (Session::has('user'))
          
          <a class="nav-link " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{Session::get('user')['name']}}
          </a>
            
          {{-- @else
          <a class="nav-link " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            User
          </a> --}}
          @endif
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

            {{-- @if(Session::has('user'))
            @if ($userdata->role === "job_seeker" || $userdata->role === "company" || $userdata->role === "admin")
            <li><a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a></li>
            @endif
            @endif --}}
          </ul>
          
          @if(!Session::has('user'))
          <li class="nav-item">
            <a class="nav-link btn btn-outline-success me-2 " href="{{route('userlogin')}}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-success text-white " href="{{route('userregister')}}">Register</a>
          </li>
          @else

          @if (Session::has('user'))
        <li class="nav-item">
          <img src="data:image/jpeg;base64,{{ auth()->user()->img_path }}" class="user-img me-4" alt="user-img">
        </li>
        @endif
          <li class="nav-item">
            <a class="nav-link btn btn-success text-white " href="/logout">Logout</a>
          </li>
          @endif

        </li>
      </ul>
    </div>
  </div>
</nav>