@php
use App\Models\User;
if(Session::has('user')){
  
   $userdata = User::Find(Session::get('user')['id']);
   compact('userdata');
}

@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3 align-items-center">
  <div class="container">
    <a class="navbar-brand d-inline" href="{{route('home')}}">Job-Board</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav   mb-2 mb-lg-0 ms-auto ">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="">About Us</a>
        </li>
        <li class="nav-item dropdown">

          @if (Session::has('user'))
          
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{Session::get('user')['name']}}
          </a>
            
          @else
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            User
          </a>
          @endif
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

            @if(Session::has('user'))
            @if ($userdata->role === "job_seeker" || $userdata->role === "company" || $userdata->role === "admin")
            <li><a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a></li>
            @endif
            @endif
          </ul>
          @if(!Session::has('user'))
          <li class="nav-item">
            <a class="nav-link btn btn-outline-success me-2 " href="{{route('userlogin')}}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-success text-white" href="{{route('userregister')}}">Register</a>
          </li>
          @else

          {{-- @if ($userdata->role === "job_seeker" || $userdata->role === "company" || $userdata->role === "admin")
          <li class="nav-item">
            <a class="nav-link " href="{{route('dashboard')}}">Dashboard</a>
          </li>
          @endif --}}

          
          <li class="nav-item">
            <a class="nav-link btn btn-success text-white me-4" href="/logout">Logout</a>
          </li>
          @endif
        </li>



		@if (Session::has('user') && $userdata->role === "job_seeker")
        <li class="nav-item">
          <img src="{{asset('storage/' .$userdata->jobSeeker->img_path)}}" class="user-img" alt="user-img">
        </li>
        @endif

		@if (Session::has('user') && $userdata->role === "company")
        <li class="nav-item">
          <img src="{{asset('storage/' .$userdata->employer->img_path)}}" class="user-img" alt="user-img">
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>