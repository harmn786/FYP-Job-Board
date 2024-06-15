<?php

namespace App\Http\Controllers;
use App\Models\Job;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Employer;
use App\Models\JobSeeker;
use App\Models\JobType;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\NotificationEmailToEmployerAfterJobstatusChangeByAdmin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\table;

class AdminController extends Controller
{
    // AdminController.php

    public function edit()
    {
        $user = auth()->user();
        $admin = $user->admin;
        return view('admin.editAdmin', compact('admin'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $admin = $user->admin;

        $request->validate([
            'contact_no'=>'required',
            'cnic'=>'required',
            // Add other fields as needed
        ]);

        // Update profile details
        $update = $admin->update([
            'cnic' => $request->input('cnic'),
            'contact_no' => $request->input('contact_no'),
            // Update other fields
        ]);

        return redirect()->route('editAdmin')->with('success', 'Profile details updated successfully.');
    }

    public function updateProfileImage(Request $request)
    {
        $user = auth()->user();
        $admin = $user->admin;

        $validator = Validator::make( $request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->passes()){

             // Remove the existing profile image
        if ($admin->admin_image) {
            File::delete(storage_path('app/public/'.$admin->admin_image));
        }
            // Generate a unique filename for the profile image
        $imageFileName = 'profile_image_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

        // Upload the new profile image
        $imagePath = $request->file('image')->storeAs('images', $imageFileName, 'public');
        
        // Update profile image file path in the database
        $admin->update(['admin_image' => $imagePath]);
        session()->flash('success', 'Profile image updated successfully.');
        return response()->json([
            'status'=> true,
            'errors'=> []
        ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'errors'=> $validator->errors()
            ]);
        }
        
    }

    public function jobApprovals()
    {
        // Fetch jobs with pending approval
        $jobsPendingApproval = Job::paginate(5);

        return view('admin.jobsapprovals', compact('jobsPendingApproval'));
    }

    public function approveJob(Job $job)
    {
        // Approve the job
        $job->update(['approved_by_admin' => true]);
        $employer = $job->employer;
        $mailData = [
            'employer' => $employer,
            'job' => $job,
        ];
        Mail::to($employer->email)->send(new NotificationEmailToEmployerAfterJobstatusChangeByAdmin($mailData));
        return redirect()->route('admin.jobApprovals')->with('success', 'Job Activated For Posting Successfully.');
        
    }
    public function rejectJob(Job $job)
    {
        // Reject the job
        $job->update(['approved_by_admin' => false]);
        $employer = $job->employer;
        $mailData = [
            'employer' => $employer,
            'job' => $job,
        ];
        Mail::to($employer->email)->send(new NotificationEmailToEmployerAfterJobstatusChangeByAdmin($mailData));
        return redirect()->route('admin.jobApprovals')->with('success', 'Job Unactivated For Posting Successfully.');
    }

    public function getCompanies()
    {
        // Fetch jobs with pending approval
        $companies = Employer::get();

        return view('admin.companies', compact('companies'));
    }
    public function getContactFormData()
    {
        // Fetch jobs with pending approval
        $contactData = DB::table('contacts')->paginate(6);

        return view('admin.contactsdata', compact('contactData'));
    }

    public function jobRemarks(Request $request, $jobId)
    {
        $request->validate([
            'remarks' => 'required'
        ]);

        $job = Job::findOrFail($jobId);
        $job->remarks = $request->remarks;
        $job->save();

        return redirect()->back()->with('success', 'Job Remarks Added Suceessfully');
    }
    public function getUsers(){
        $users = User::orderBy('name','DESC')->paginate(5);
        return view('admin.users',compact('users'));
    }
    public function getCategories(){
        $categories = Category::orderBy('name','DESC')->paginate(5);
        return view('admin.jobcategories',compact('categories'));
    }
    public function getJobTypes(){
        $jobtypes = JobType::orderBy('name','DESC')->paginate(5);
        return view('admin.jobtypes',compact('jobtypes'));
    }
    public function deleteUser(Request $request, $userId){
        $user = User::findOrFail($userId);
            $user->delete();
        return redirect()->back()->with('success', 'User Deleted Successfuly');
    }

    public function editUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.editUser', compact('user'));
    }
    public function editCategory(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.editjobcategory', compact('category'));
    }
    public function editJobType(Request $request, $jobtypeId)
    {
        $jobtype = JobType::findOrFail($jobtypeId);
        return view('admin.editjobtype', compact('jobtype'));
    }
    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|exists:users',
            'role'=>'required',
            // Add other fields as needed
        ]);
        $update = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $user->password,
            // Update other fields
        ]);
        if($update){
            $this->insertProfileData($user,$request);
            return redirect()->route('admin.editUser', $userId)->with('success', 'User Detail Updated Successfully.');
        }

    }
    public function updateCategory(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $request->validate([
            'name'=>'required',
            // Add other fields as needed
        ]);
        $update = $category->update([
            'name' => $request->name,
            // Update other fields
        ]);
        if($update){
            return redirect()->route('admin.editCategory', $categoryId)->with('success', 'Category Updated Successfully.');
        }

    }
    public function updateJobType(Request $request, $jobtypeId)
    {
        $jobtype = JobType::findOrFail($jobtypeId);
        $request->validate([
            'name'=>'required',
            // Add other fields as needed
        ]);
        $update = $jobtype->update([
            'name' => $request->name,
            // Update other fields
        ]);
        if($update){
            return redirect()->route('admin.editJobType', $jobtypeId)->with('success', 'JobType Updated Successfully.');
        }

    }
    public function deleteCategory(Request $request, $categoryId){
        $category = Category::findOrFail($categoryId);
            $category->delete();
        return redirect()->back()->with('success', 'Category Deleted Successfuly');
    }
    public function deleteJobType(Request $request, $jobtypeId){
        $jobtype = JobType::findOrFail($jobtypeId);
            $jobtype->delete();
        return redirect()->back()->with('success', 'JobType Deleted Successfuly');
    }

    protected function insertProfileData(User $user, Request $req)
    {
        switch ($req['role']) {
            case 'job_seeker':
                JobSeeker::updateOrInsert([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    // Add additional job_seeker-specific data here
                ],['name'=>$user->name,'user_id'=>$user->id]);
                break;
            case 'company':
                Employer::updateOrInsert([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    // Add additional company-specific data here
                ],['name'=>$user->name,'user_id'=>$user->id]);
            case 'admin':
                Admin::updateOrInsert([
                    'user_id' => $user->id,
                    'admin_name' => $user->name,
                    'email' => $user->email,
                    // Add additional company-specific data here
                ],['admin_name'=>$user->name,'user_id'=>$user->id]);
                break;
        }
    }


    public function featuredJob(Job $job)
    {
        // Approve the job
        $job->update(['featured' => true]);

        return redirect()->route('admin.jobApprovals')->with('success', 'Job Added to Featured.');
    }
    public function unFeaturedJob(Job $job)
    {
        // Approve the job
        $job->update(['featured' => false]);

        return redirect()->route('admin.jobApprovals')->with('success', 'Job Remove From Featured.');
    }
    public function employerDetail(Request $request,Employer $employer)
    {
        // Show the form for editing the job details
        return view('admin.employerDetail', compact('employer'));
    }
    public function addCategory(Request $request){
        $category = new Category();
        $request->validate([
            'name'=>'required',
            // Add other fields as needed
        ]);
        $add = $category->insert([
            'name' => $request->name,
            // Update other fields
        ]);
        if($add){
            return redirect()->route('admin.jobcategories')->with('success','Category Added Successfully');
        }
    }
    public function addJobType(Request $request){
        $jobtype = new JobType();
        $request->validate([
            'name'=>'required',
            // Add other fields as needed
        ]);
        $add = $jobtype->insert([
            'name' => $request->name,
            // Update other fields
        ]);
        if($add){
            return redirect()->route('admin.jobtypes')->with('success','Job Type Added Successfully');
        }
    }

}

