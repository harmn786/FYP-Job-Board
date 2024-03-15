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
            @if (Session::has('user') && $userdata->role === "job_seeker")
            <img src="{{asset('storage/' .$userdata->jobSeeker->img_path)}}"  class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
            @endif
            @if (Session::has('user') && $userdata->role === "company")
            <img src="{{asset('storage/' .$userdata->employer->img_path)}}"  class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
            @endif
            @if (Session::has('user') && $userdata->role === "admin")
            <img src="{{asset('storage/' .$userdata->admin->admin_image)}}"  class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
            @endif
            @if (Session::has('user'))
            <h5 class="mt-3 pb-0">{{Session::get('user')['name']}}</h5>
            @else
            <h5 class="mt-3 pb-0">User</h5>
            @endif
            <p class="text-muted mb-1 fs-6">Full Stack Developer</p>
            <div class="d-flex justify-content-center mb-2">
                <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
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
            <a class="" href="{{route('companies')}}">Companies</a>
          </li>
          <li class="list-group-item d-flex justify-content-between p-3" >
            <a class="" href="{{route('admin.jobApprovals')}}">Job Requests</a>
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
            </ul>
        </div>
    </div>
</div>