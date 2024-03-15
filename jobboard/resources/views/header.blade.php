@php
use App\Models\User;
if(Session::has('user')){
  
   $userdata = User::Find(Session::get('user')['id']);
   compact('userdata');
}

@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container">
    <a class="navbar-brand text-success" href="{{route('home')}}">Job-Board</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown" >
      <ul class="navbar-nav ml-auto ">
        <li class="nav-item active" >
          <a class="nav-link" style="color:seagreen !important;" href="{{route('home')}}">Home</a>
        </li>
        {{-- @if (Session::has('user'))
          @if ($userdata->role === "company")
          <li class="nav-item active" >
            <a class="nav-link" href="{{route('jobs.create')}}">+Post Job </a>
          </li>
          <li class="nav-item active" >
            <a class="nav-link" href="{{route('employer.postedJobs')}}">Posted Jobs </a>
          </li>
          @endif
          @if ($userdata->role === "job_seeker")
          <li class="nav-item active" >
            <a class="nav-link"  href="{{route('favorites.index')}}">Favorites </a>
          </li>
          <li class="nav-item active" >
            <a class="nav-link" href="{{route('job_applications.index')}}">Applied Jobs </a>
          </li>
          @endif

          @if ($userdata->role === "admin")
          <li class="nav-item active" >
            <a class="nav-link" href="{{route('companies')}}">Companies</a>
          </li>
          <li class="nav-item active" >
            <a class="nav-link" href="{{route('admin.jobApprovals')}}">Job Requests</a>
          </li>
          @endif
        @endif --}}
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
        <li class="nav-item dropdown">
          @if (Session::has('user'))
          
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            
            {{Session::get('user')['name']}}
          </a>
          @else
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            User
          </a>
          @endif
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            @if(!Session::has('user'))
            <a class="dropdown-item" href="{{route('userregister')}}">Register</a>
            <a class="dropdown-item" href="{{route('userlogin')}}">Login</a>
            @else
            <a class="dropdown-item" href="/logout">Logout</a>
            @if ($userdata->role === "job_seeker" || $userdata->role === "company" || $userdata->role === "admin")
            <a class="dropdown-item" href="{{route('dashboard')}}">Profile</a>
            @endif
            @endif
          </div>
        </li>
      </ul>
      @if (Session::has('user') && $userdata->role === "job_seeker")
      <ul class="navbar-nav ">
        <li class="nav-item">
          <img src="{{asset('storage/' .$userdata->jobSeeker->img_path)}}" class="user-img" alt="user-img">
        </li>
        </ul>
        @endif

        @if (Session::has('user') && $userdata->role === "company")
      <ul class="navbar-nav ">
        <li class="nav-item">
          <img src="{{asset('storage/' .$userdata->employer->img_path)}}" class="user-img" alt="user-img">
        </li>
        </ul>
        @endif
    </div>
</div>
</nav>