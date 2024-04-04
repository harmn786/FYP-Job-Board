<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\JobSeeker;
use App\Mail\JobNotificationEmailToEmployer;
use App\Mail\JobNotificationEmailToJobSeeker;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Employer;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\File;
use Session;

class JobSeekerController extends Controller
{



    public function edit()
    {
        $user = auth()->user();
        $jobSeeker = $user->jobSeeker;
        return view('jobseeker.editJobSeeker', compact('jobSeeker'));
    }
    public function update(Request $request)
    {
        $user = auth()->user();
        $jobSeeker = $user->jobSeeker;

        $request->validate([
            'education'=>'required',
            'experience'=>'required',
            // Add other fields as needed
        ]);

        // Update profile details
        $update = $jobSeeker->update([
            'name' => $user->name,
            'email' => $user->email,
            'title' => $request->input('title'),
            'cnic' => $request->input('cnic'),
            'dob' => $request->input('dob'),
            'address' => $request->input('address'),
            'education' => $request->input('education'),
            'experience' => $request->input('experience'),
            'skills' => $request->input('skills'),
            'facebook_link' => $request->input('facebook_link'),
            'twitter_link' => $request->input('twitter_link'),
            'linkedin_link' => $request->input('linkedin_link'),
            // Update other fields
        ]);

        return redirect()->route('editJobSeeker')->with('success', 'Profile details updated successfully.');
    }

    public function updateCV(Request $request)
    {
        $user = auth()->user();
        $jobSeeker = $user->jobSeeker;

        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048', // Assuming PDF file format for CV
        ]);

        // Remove the existing CV file
        if ($jobSeeker->cv_path) {
            Storage::disk('public')->delete($jobSeeker->cv_path);
        }

        // Generate a unique filename for the CV
        $cvFileName = 'cv_' . uniqid() . '.' . $request->file('cv')->getClientOriginalExtension();

        // Upload the new CV
        $cvPath = $request->file('cv')->storeAs('cv', $cvFileName, 'public');
        
        // Update CV file path in the database
        $jobSeeker->update(['cv_path' => $cvPath]);

        return redirect()->route('editJobSeeker')->with('success', 'CV updated successfully.');
    }

    public function updateProfileImage(Request $request)
    {
        $user = auth()->user();
        $jobSeeker = $user->jobSeeker;

        $validator = Validator::make( $request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->passes()){

             // Remove the existing profile image
        if ($jobSeeker->img_path) {
            File::delete(storage_path('app/public/'.$jobSeeker->img_path));
        }
            // Generate a unique filename for the profile image
        $imageFileName = 'profile_image_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

        // Upload the new profile image
        $imagePath = $request->file('image')->storeAs('images', $imageFileName, 'public');
        
        // Update profile image file path in the database
        $jobSeeker->update(['img_path' => $imagePath]);
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

    public function applyJob($jobId)
    {
        $job= Job::where('id',$jobId)->first();
        $employer= $job->employer;
        $jobSeeker = auth()->user()->jobSeeker;

        $mailData = [
            'employer' => $employer,
            'jobseeker'=> $jobSeeker,
            'job' => $job,
        ];
        if(!Session::has('user')){
            return redirect()->route('jobs.show', $jobId)->with('error', 'Please Sign In First to add Job to Apply For Job!');
        }

        if (!$jobSeeker->cv_path) {
            return redirect()->back()->with('error', 'Please upload a CV and complete profile in profile section before applying for jobs.');
        }
        // Assuming authentication logic to get the logged-in user
        // Check if the job is already applied
        if (!$jobSeeker->jobApplications()->where('job_id', $jobId)->exists()) {
            $jobSeeker->jobApplications()->create([
                'job_id' => $jobId,
                'job_seeker_id'=>$jobSeeker->id,
                'application_date'=>now(),
                'updated_at'=>now(),
                'created_at'=>now(),
            ]);
        }
        else{
            return redirect()->route('jobs.show', $jobId)->with('error', 'Job is Already Applied');
        }
        // Mail::to($employer->email,$jobSeeker->email)->send(new JobNotificationEmailToEmployer($mailData),new JobNotificationEmailToJobSeeker($mailData));
        Mail::to($employer->email)->send(new JobNotificationEmailToEmployer($mailData));
        Mail::to($jobSeeker->email)->send(new JobNotificationEmailToJobSeeker($mailData));
        return redirect()->route('jobs.show', $jobId)->with('success', 'Job application submitted!');
    }

    public function addToFavorites($jobId)
    {
        // Assuming authentication logic to get the logged-in user
        if(!Session::has('user')){
            return redirect()->route('jobs.show', $jobId)->with('error', 'Please Sign In First to add Job to Favorite!');
        }
            $jobSeeker = auth()->user()->jobSeeker;
            if (!$jobSeeker->favorites()->where('job_id', $jobId)->exists()) {
                if(auth()->user()){}
                $jobSeeker->favorites()->attach($jobId);
            }
            else{
                return redirect()->route('jobs.show', $jobId)->with('error', 'Job is Already Favorited!');
            }
        // Check if the job is already in favorites

        return redirect()->route('jobs.show', $jobId)->with('success', 'Job added to favorites!');
    }
    public function favorite_jobs()
    {
        $user = auth()->user();

        $favorites = $user->jobSeeker->favorites;

        return view('jobseeker.favorites', compact('favorites'));
    }
    public function applications()
    {
        $user = auth()->user();

        // Fetch job applications for the logged-in job seeker
        $jobApplications = $user->jobSeeker->jobApplications;

        return view('jobseeker.job_applications', compact('jobApplications'));
    }

    public function removeFavorite($favoriteId )
    {

        $jobSeekerID = auth()->user()->jobSeeker->id;
        $jobId = $favoriteId;

        $favorite = Favorite::where('job_id', $jobId,)->where('job_seeker_id',$jobSeekerID)
                            ->first();
        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'Job removed from favorites.');
        } else {
            return redirect()->route('favorites.index')->with('error', 'Job is not in favorites.');
        }
    }
    public function deleteApplication($applicationId){
        $application = JobApplication::where('id',$applicationId)->delete();
        if($application){
            return redirect()->back()->with('success','Application Deleted Successfully');
        }
        else{
            return redirect()->back()->with('error','There is some Error');
        }
        
    }

}
