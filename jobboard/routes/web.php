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



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
Route::get('/dashboard', function () {
    return view('front.app.dashboard');
})->middleware('verify')->name('dashboard');
        Route::view("/userregister","front.account.userregister")->name('userregister');
        Route::view("/registerjob","registerjob")->name('addjob');
        Route::view("/userupdate","userupdate")->name('userupdate');
        Route::view("/userlogin","front.account.userlogin")->name('userlogin');
        Route::get('/explorejobs',[JobController::class,'exploreJobs'])->name('explorejobs');
        Route::view("/users","users")->name('users');
        Route::post('/addUserData',[UserController::class,'addUserData'])->name('add');
        Route::post('/addContactData',[UserController::class,'addContactFormData'])->name('addContactUsData');
        Route::post('/postjob',[UserController::class,'postJob'])->name('postjob');
        Route::post('/userlog',[UserController::class,'userLogin'])->name('userlog');
        Route::post('/changePassword',[UserController::class,'changePassword'])->name('changePassword');
        Route::view("uploadfile","uploadfile");
        Route::view("/contactus","front.app.contactus")->name('contactus');
        Route::view("/aboutus","front.app.aboutus")->name('aboutus');
        Route::post('updateUserData/{id}',[UserController::class,'update']);
        Route::get("/",[JobController::class,'index'])->name('home');
        Route::get('/categories', [JobController::class, 'categories'])->name('categories');
        Route::get('/jobs/{id}', [JobController::class,'jobDetail'])->name('jobs.jobDetail');
        Route::get('/job/category/{id}', [JobController::class,'jobsByCategory'])->name('jobs.jobsByCategory');
        Route::get('/jobsearch', [JobController::class, 'jobSearch'])->name('jobs.index');
        Route::get('/jobs/{id}/add-to-favorites',[JobSeekerController::class,'addToFavorites'])->name('jobs.addToFavorites');
        Route::get('/verify/{id}', [UserController::class, 'verify'])->name('verify');
        Route::get('/verification', [UserController::class, 'verification'])->name('verification');
        Route::get('/verificationEmailMessage', [UserController::class, 'verificationEmailMessage'])->name('verificationEmailMessage');
        Route::post('/user/updateProfileImage', [UserController::class, 'updateProfileImage'])->name('user.updateImage');
        Route::view("/adminRegister","front.account.adminregister")->name('adminRegister');
        Route::post('/addAdminData',[UserController::class,'addAdminData'])->name('addAdmin');
        Route::get("/forget-password",[UserController::class,'forgetPassword'])->name('forgetPassword');
        Route::post("/forget-password-post",[UserController::class,'forgetPasswordPost'])->name('forgetPasswordPost');
        Route::post("/reset-password-post",[UserController::class,'resetPasswordPost'])->name('resetPasswordPost');
        Route::get("/resetPassword/{token}",[UserController::class,'resetPassword'])->name('reset-password');
        Route::get('/logout', function () {
            Session::forget('user');
            return redirect('userlogin');
        });

Route::middleware(['JobSeeker'])->group(function(){
        Route::get('/favorites', [JobSeekerController::class, 'favorite_jobs'])->name('favorites.index');
        Route::post('/jobs/{id}/apply-job',[JobSeekerController::class,'applyJob'])->name('jobs.applyJob');
        // Route::get('/update/profile', [UserController::class, 'edit'])->middleware('auth')->middleware('auth','verify')->name('edit');
        Route::get('/update/jobseeker/profile', [JobSeekerController::class, 'edit'])->middleware('auth')->middleware('auth','verify')->name('editJobSeeker');
        Route::post('/job-seeker/update', [JobSeekerController::class, 'update'])->middleware('auth')->name('jobSeeker.update');
        Route::post('/job-seeker/update-cv', [JobSeekerController::class, 'updateCV'])->name('jobSeeker.updateCV');
        Route::get('/job-seeker/view-cv', [JobSeekerController::class, 'viewCV'])->name('cv.show');
        Route::get('/job-applications', [JobSeekerController::class, 'applications'])->name('job_applications.index');
        Route::get('/favorite/{favoriteId}/remove', [JobSeekerController::class, 'removeFavorite'])->name('favorite.remove');
        Route::get('/deleteApplication/{applicationId}', [JobSeekerController::class, 'deleteApplication'])->name('deleteApplication');

});

Route::middleware(['Employer'])->group(function(){
    Route::get('/update/employer/profile', [EmployerController::class, 'edit'])->middleware('auth')->middleware('auth','verify')->name('editEmployer');
    Route::get('/create/jobs', [EmployerController::class, 'create_job'])->name('jobs.create');
    Route::post('/jobs', [EmployerController::class, 'store'])->middleware('auth')->name('jobs.store');
    Route::post('/employer/update', [EmployerController::class, 'update'])->middleware('auth')->name('Employer.update');
    // Route::get('/employer/job-applications', [EmployerController::class, 'jobApplications'])->middleware('auth')->name('employer.jobApplications');
    Route::post('/employer/job-applications/{jobApplication}/approve', [EmployerController::class, 'approveApplication'])->middleware('auth')->name('employer.approveApplication');
    Route::post('/employer/job-applications/{jobApplication}/reject', [EmployerController::class, 'rejectApplication'])->middleware('auth')->name('employer.rejectApplication');
    Route::get('/posted-jobs', [EmployerController::class, 'postedJobs'])->name('employer.postedJobs');
    Route::get('/job-seeker/view-cv/{id}', [EmployerController::class, 'viewCVByEmployer'])->name('cv.showToEmployer');
    Route::get('/posted-jobs/{job}/edit', [EmployerController::class, 'editJob'])->name('employer.editJob');
    Route::post('/posted-jobs/{job}/update', [EmployerController::class, 'updateJob'])->name('employer.updateJob');
    Route::get('/posted-jobs/{job}/delete', [EmployerController::class, 'deleteJob'])->name('employer.deleteJob');
    Route::get('/job/{jobId}/applications', [EmployerController::class, 'showJobApplications'])->name('employer.showJobApplications');
    Route::post('/job-application/{applicationId}/approve', [EmployerController::class, 'approveJobApplication'])->name('employer.approveJobApplication');
    Route::get('/download-cvs/{jobId}', [EmployerController::class, 'downloadCVs'])->name('downloadCVs');
    // Route::post('/jobs/{jobId}/export', [EmployerController::class, 'exportApplicants'])->name('job.export');
    Route::get('/job/{jobId}/applicants/download', [EmployerController::class, 'downloadApplicants'])->name('job.applicants.download');
    Route::get('/jobSeeker/{jobSeeker}/detail', [EmployerController::class, 'jobSeekerDetail'])->name('jobSeeker.detail');
});


Route::middleware(['Admin'])->group(function(){
    Route::post('/admin/update', [AdminController::class, 'update'])->middleware('auth')->name('admin.update');
    Route::get('/admin/job-approvals', [AdminController::class, 'jobApprovals'])->middleware('auth')->name('admin.jobApprovals');
    Route::get('/admin/jobs/{job}/approve', [AdminController::class, 'approveJob'])->middleware('auth')->name('admin.approveJob');
    Route::get('/job/{jobId}/remarks', [AdminController::class, 'jobRemarks'])->name('admin.JobRemarks');
    Route::get('/admin/jobs/{job}', [AdminController::class, 'rejectJob'])->middleware('auth')->name('admin.rejectJob');
    Route::get('/employer/{employer}/detail', [AdminController::class, 'employerDetail'])->name('employer.detail');
    Route::get('/companies',[AdminController::class,'getCompanies'])->name('companies');
    Route::get('/users',[AdminController::class,'getUsers'])->name('users');
    Route::get('/update/admin/profile', [AdminController::class, 'edit'])->middleware('auth')->name('editAdmin');
    Route::get('/delete/{userId}/user', [AdminController::class, 'deleteUser'])->middleware('auth')->name('admin.deleteUser');
    Route::get('/edit/{userId}/user', [AdminController::class, 'editUser'])->middleware('auth')->name('admin.editUser');
    Route::post('/update/{userId}/user', [AdminController::class, 'updateUser'])->middleware('auth')->name('user.update');
    Route::post('/update/{categoryId}/category', [AdminController::class, 'updateCategory'])->middleware('auth')->name('category.update');
    Route::post('/update/{jobtypeId}/jobtype', [AdminController::class, 'updateJobType'])->middleware('auth')->name('jobtype.update');
    Route::get('/users', [AdminController::class, 'getUsers'])->middleware('auth')->name('users');
    Route::get('/contactdata', [AdminController::class, 'getContactFormData'])->middleware('auth')->name('contactdata');
    Route::get('/admin/jobs/{job}/featured', [AdminController::class, 'featuredJob'])->middleware('auth')->name('admin.featuredJob');
    Route::get('/admin/jobs/{job}/Unfeatured', [AdminController::class, 'unFeaturedJob'])->middleware('auth')->name('admin.unFeaturedJob');
    Route::get('/jobcategories', [AdminController::class, 'getCategories'])->middleware('auth')->name('admin.jobcategories');
    Route::get('/delete/{categoryId}/category', [AdminController::class, 'deleteCategory'])->middleware('auth')->name('admin.deleteCategory');
    Route::get('/edit/{categoryId}/category', [AdminController::class, 'editCategory'])->middleware('auth')->name('admin.editCategory');
    Route::get('/jobtypes', [AdminController::class, 'getJobTypes'])->middleware('auth')->name('admin.jobtypes');
    Route::get('/delete/{jobtypeId}/jobtype', [AdminController::class, 'deleteJobType'])->middleware('auth')->name('admin.deleteJobType');
    Route::get('/edit/{jobtypeId}/jobtype', [AdminController::class, 'editJobType'])->middleware('auth')->name('admin.editJobType');
    Route::view("/newcategory","admin.newcategory")->name('newcategory');
    Route::post("/addcategory",[AdminController::class, 'addCategory'])->name('addCategory');
    Route::view("/newjobtype","admin.newjobtype")->name('newjobtype');
    Route::post("/addjobtype",[AdminController::class, 'addJobType'])->name('addJobType');
});


require __DIR__.'/auth.php';