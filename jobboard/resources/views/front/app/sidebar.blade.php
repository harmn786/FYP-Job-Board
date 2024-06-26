@php
use App\Models\User;
if(Session::has('user')){
  
   $userdata = User::Find(Session::get('user')['id']);
   compact('userdata');
}

@endphp
<div class="col-lg-3">
    <div class="card border-0 shadow mb-4 p-3">
        <div class="s-body text-center mt-3">
            @if (Session::has('user'))
            <img src="data:image/jpeg;base64,{{ auth()->user()->img_path }}"  class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
            {{-- {{asset('storage/' .$userdata->img_path)}} --}}
            
            @endif
            @if (Session::has('user'))
            <h5 class="mt-3 pb-0">{{Session::get('user')['name']}}</h5>
            @else
            <h5 class="mt-3 pb-0">User</h5>
            @endif

            @if (auth()->user()->jobSeeker)
            <p class="text-muted mb-1 fs-6">{{auth()->user()->jobSeeker->title}}</p>
            @elseif (auth()->user()->employer)
            <p class="text-muted mb-1 fs-6">{{auth()->user()->employer->company_name}}</p>
            @elseif (auth()->user()->admin)
            <p class="text-muted mb-1 fs-6">Administrator</p>
            @else
            <p class="text-muted mb-1 fs-6">New User</p>
            @endif
            <div class="d-flex justify-content-center mb-2 mt-2">
              <button data-bs-toggle="modal" data-bs-target="#ImageModal" type="button" class="btn btn-outline-success mt-3">Change Picture</button>
          </div>
            
        </div>
    </div>
    <div class="card account-nav border-0 shadow mb-4 mb-lg-0">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush ">

                @if (Session::has('user'))
          @if ($userdata->role === "company")
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{route('jobs.create')}}">+Post Job </a>
          </li>
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{route('employer.postedJobs')}}">Posted Jobs </a>
          </li>
          @endif
          @if ($userdata->role === "job_seeker")
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class=""  href="{{route('favorites.index')}}">Favorites </a>
          </li>
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{route('job_applications.index')}}">Applied Jobs </a>
          </li>
          @endif
          @if ($userdata->role === "admin")
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{route('users')}}">Users</a>
          </li>
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{route('companies')}}">Companies</a>
          </li>
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{route('admin.jobApprovals')}}">Job Requests</a>
          </li>
          {{-- <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{ route('users') }}">Users</a>
          </li> --}}
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{ route('admin.jobcategories') }}">Job Categories</a>
          </li>
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{ route('admin.jobtypes') }}">Job Types</a>
          </li>
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{ route('contactdata') }}">Contact Form Data</a>
          </li>
          @endif
        @endif
        @if ($userdata->role === "job_seeker")
        <li class="list-group-item d-flex justify-content-between p-3">
            <a class="" href="{{route('editJobSeeker')}}">Update Profile</a>
        </li>
        @endif
        @if ($userdata->role === "company")
        <li class="list-group-item d-flex justify-content-between p-3">
            <a class="" href="{{route('editEmployer')}}">Update Profile</a>
        </li>
        @endif
        @if ($userdata->role === "admin")
        <li class="list-group-item d-flex justify-content-between p-3">
            <a class="" href="{{route('editAdmin')}}">Update Profile</a>
        </li>
        @endif
        <li class="list-group-item d-flex justify-content-between p-3">
          <a class="" href="/logout">Logout</a>
      </li>                                               
            </ul>
        </div>
    </div>
</div>