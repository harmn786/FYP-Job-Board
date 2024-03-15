<?php

namespace App\Http\Controllers;
use App\Models\Job;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // AdminController.php

    public function edit()
    {
        $user = auth()->user();
        $admin = $user->admin;
        return view('editAdmin', compact('admin'));
    }

    public function updateProfileImage(Request $request)
    {
        $user = auth()->user();
        $admin = $user->admin;

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Remove the existing profile image
        if ($admin->admin_image) {
            Storage::disk('public')->delete($admin->admin_image);
        }

        // Generate a unique filename for the profile image
        $imageFileName = 'profile_image_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

        // Upload the new profile image
        $imagePath = $request->file('image')->storeAs('images', $imageFileName, 'public');
        
        // Update profile image file path in the database
        $admin->update(['admin_image' => $imagePath]);

        return redirect()->route('editAdmin')->with('success', 'Profile image updated successfully.');
    }

    public function jobApprovals()
    {
        // Fetch jobs with pending approval
        $jobsPendingApproval = Job::get();

        return view('jobsapprovals', compact('jobsPendingApproval'));
    }

    public function approveJob(Job $job)
    {
        // Approve the job
        $job->update(['approved_by_admin' => true]);

        return redirect()->route('admin.jobApprovals')->with('success', 'Job Activated For Posting Successfully.');
    }

    public function rejectJob(Job $job)
    {
        // Reject the job
        $job->update(['approved_by_admin' => false]);

        return redirect()->route('admin.jobApprovals')->with('success', 'Job Unactivated For Posting Successfully.');
    }

    public function getCompanies()
    {
        // Fetch jobs with pending approval
        $companies = Employer::get();

        return view('companies', compact('companies'));
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
}

