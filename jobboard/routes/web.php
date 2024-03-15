<?php
use App\Models\Job;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobApplication;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('master');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
Route::view("/userregister","userregister")->name('userregister');
Route::view("/registerjob","registerjob")->name('addjob');
Route::view("/userupdate","userupdate")->name('userupdate');
Route::view("/userlogin","userlogin")->name('userlogin');
Route::view("/users","users")->name('users');
Route::post('/addUserData',[UserController::class,'addUserData'])->name('add');
Route::post('/postjob',[UserController::class,'postJob'])->name('postjob');
Route::post('/userlog',[UserController::class,'userLogin'])->name('userlog');
Route::post('/changePassword',[UserController::class,'changePassword'])->name('changePassword');
Route::view("uploadfile","uploadfile");
Route::post('updateUserData/{id}',[UserController::class,'update']);
Route::get("/",[JobController::class,'index'])->name('home');
Route::get('/verify/{id}', [UserController::class, 'verify'])->name('verify');
Route::get('/verification', [UserController::class, 'verification'])->name('verification');
Route::get('/verificationEmailMessage', [UserController::class, 'verificationEmailMessage'])->name('verificationEmailMessage');
Route::get('/logout', function () {
    Session::forget('user');
    return redirect('userlogin');
});


Route::get('/jobs', [JobController::class, 'jobs'])->name('jobs');
Route::get('/jobs/{id}', [JobController::class,'show'])->name('jobs.show');
Route::get('/jobs', [JobController::class, 'jobSearch'])->name('jobs.index');
Route::post('/jobs/{id}/add-to-favorites',[JobSeekerController::class,'addToFavorites'])->middleware('JobSeeker')->name('jobs.addToFavorites');
Route::get('/favorites', [JobSeekerController::class, 'favorite_jobs'])->middleware('JobSeeker')->name('favorites.index');
Route::post('/jobs/{id}/apply-job',[JobSeekerController::class,'applyJob'])->middleware('JobSeeker')->name('jobs.applyJob');
// Route::get('/update/profile', [UserController::class, 'edit'])->middleware('auth')->middleware('auth','verify')->name('edit');
Route::get('/update/jobseeker/profile', [JobSeekerController::class, 'edit'])->middleware('auth')->middleware('auth','verify')->name('editJobSeeker');
Route::post('/job-seeker/update', [JobSeekerController::class, 'update'])->middleware('auth')->name('jobSeeker.update');
Route::post('/job-seeker/update-cv', [JobSeekerController::class, 'updateCV'])->middleware('JobSeeker')->name('jobSeeker.updateCV');
Route::post('/job-seeker/update-profile-image', [JobSeekerController::class, 'updateProfileImage'])->middleware('JobSeeker')->name('jobSeeker.updateImage');
Route::get('/job-applications', [JobSeekerController::class, 'applications'])->middleware('JobSeeker')->name('job_applications.index');
Route::post('/favorite/remove', [JobSeekerController::class, 'removeFavorite'])->name('favorite.remove');
Route::get('/deleteApplication/{applicationId}', [JobSeekerController::class, 'deleteApplication'])->name('deleteApplication');


Route::get('/update/employer/profile', [EmployerController::class, 'edit'])->middleware('auth')->middleware('auth','verify')->name('editEmployer');
Route::get('/create/jobs', [EmployerController::class, 'create_job'])->name('jobs.create');
Route::post('/jobs', [EmployerController::class, 'store'])->middleware('auth')->name('jobs.store');
Route::post('/employer/update', [EmployerController::class, 'update'])->middleware('auth')->name('Employer.update');
Route::post('/employer/update-profile-image', [EmployerController::class, 'updateProfileImage'])->middleware('auth')->name('Employer.updateImage');
// Route::get('/employer/job-applications', [EmployerController::class, 'jobApplications'])->middleware('auth')->name('employer.jobApplications');
Route::post('/employer/job-applications/{jobApplication}/approve', [EmployerController::class, 'approveApplication'])->middleware('auth')->name('employer.approveApplication');
Route::post('/employer/job-applications/{jobApplication}/reject', [EmployerController::class, 'rejectApplication'])->middleware('auth')->name('employer.rejectApplication');
Route::get('/posted-jobs', [EmployerController::class, 'postedJobs'])->name('employer.postedJobs');
Route::get('/posted-jobs/{job}/edit', [EmployerController::class, 'editJob'])->name('employer.editJob');
Route::post('/posted-jobs/{job}/update', [EmployerController::class, 'updateJob'])->name('employer.updateJob');
Route::get('/job/{jobId}/applications', [EmployerController::class, 'showJobApplications'])->name('employer.showJobApplications');
Route::post('/job-application/{applicationId}/approve', [EmployerController::class, 'approveJobApplication'])->name('employer.approveJobApplication');
Route::get('/download-cvs/{jobId}', [EmployerController::class, 'downloadCVs'])->name('downloadCVs');
// Route::post('/jobs/{jobId}/export', [EmployerController::class, 'exportApplicants'])->name('job.export');
Route::get('/job/{jobId}/applicants/download', [EmployerController::class, 'downloadApplicants'])->name('job.applicants.download');


Route::view("/adminRegister","adminregister")->name('adminRegister');
Route::post('/addAdminData',[UserController::class,'addAdminData'])->name('addAdmin');
Route::get('/admin/job-approvals', [AdminController::class, 'jobApprovals'])->middleware('auth')->name('admin.jobApprovals');
Route::post('/admin/jobs/{job}/approve', [AdminController::class, 'approveJob'])->middleware('auth')->name('admin.approveJob');
Route::post('/job/{jobId}/remarks', [AdminController::class, 'jobRemarks'])->name('admin.JobRemarks');
Route::post('/admin/jobs/{job}', [AdminController::class, 'rejectJob'])->middleware('auth')->name('admin.rejectJob');
Route::get('/companies',[AdminController::class,'getCompanies'])->name('companies');
Route::get("/forget-password",[UserController::class,'forgetPassword'])->name('forgetPassword');
Route::post("/forget-password-post",[UserController::class,'forgetPasswordPost'])->name('forgetPasswordPost');
Route::post('/update/admin/profileimage', [AdminController::class, 'updateProfileImage'])->middleware('auth')->name('admin.updateImage');
Route::get('/update/admin/profile', [AdminController::class, 'edit'])->middleware('auth')->name('editAdmin');

Route::post("/reset-password-post",[UserController::class,'resetPasswordPost'])->name('resetPasswordPost');
Route::get("/resetPassword/{token}",[UserController::class,'resetPassword'])->name('reset-password');

require __DIR__.'/auth.php';