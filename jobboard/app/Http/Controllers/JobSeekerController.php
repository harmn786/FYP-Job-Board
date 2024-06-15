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
use Illuminate\Support\Str;
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
            'cnic' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'skills' => 'required',
            'contact_no' => 'required',
            // Add other fields as needed
        ]);

        // Update profile details
        $update = $jobSeeker->update([
            'name' => $user->name,
            'email' => $user->email,
            'contact_no' => $request->input('contact_no'),
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

    public function updateCv(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'cv' => 'required|file|mimes:pdf|max:2048', // Assuming maximum file size is 2MB
        ]);

        // Get the uploaded file
        $cvFile = $request->file('cv');

        // Read the file content
        $fileData = file_get_contents($cvFile->getRealPath());

        // Get the authenticated job seeker
        $jobSeeker = auth()->user()->jobSeeker;

        // Update the cv_path column with the file data
        $jobSeeker->update(['cv_path' => $fileData]);

        // Redirect back with success message
        return back()->with('success', 'CV uploaded successfully!');
    }

    public function viewCV()
    {
        $user = auth()->user();
        $pdfData = $user->jobSeeker->cv_path;

        // Set response headers
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline', // or 'attachment' to force download
        ];

        // Stream the PDF file content to the user's browser
        return response($pdfData, 200, $headers);
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
        $pdfData = $jobSeeker->cv_path;
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline', // or 'attachment' to force download
        ];
        $resume = response($pdfData, 200, $headers);
        $mailData = [
            'employer' => $employer,
            'jobseeker'=> $jobSeeker,
            'job' => $job,
        ];
        if(!Session::has('user')){
            return redirect()->route('jobs.jobDetail', $jobId)->with('error', 'Please Sign In First to add Job to Apply For Job!');
        }

        if (!$jobSeeker->hasMandatoryFieldsFilled()) {
            return redirect()->route('editJobSeeker',compact('jobSeeker') )->with('error', 'Please upload a CV and complete profile in profile section before applying for jobs.');
        }
        else{
            if (!$jobSeeker->jobApplications()->where('job_id', $jobId)->exists()) {
                $jobSeeker->jobApplications()->create([
                    'job_id' => $jobId,
                    'job_seeker_id'=>$jobSeeker->id,
                    'application_date'=>now(),
                    'updated_at'=>now(),
                    'created_at'=>now(),
                ]);
                Mail::to($employer->email)->send(new JobNotificationEmailToEmployer($mailData));
                Mail::to($jobSeeker->email)->send(new JobNotificationEmailToJobSeeker($mailData));
                return redirect()->route('jobs.jobDetail', $jobId)->with('success', 'Job application submitted!');
            }
            else{
                return redirect()->route('jobs.jobDetail', $jobId)->with('error', 'Job is Already Applied');
            }
        }
        // Assuming authentication logic to get the logged-in user
        // Check if the job is already applied
        
        // Mail::to($employer->email,$jobSeeker->email)->send(new JobNotificationEmailToEmployer($mailData),new JobNotificationEmailToJobSeeker($mailData));
    }

    public function addToFavorites($jobId)
    {
        // Assuming authentication logic to get the logged-in user
        if(!Session::has('user')){
            return redirect()->route('jobs.jobDetail', $jobId)->with('error', 'Please Sign In First to add Job to Favorite!');
        }
            $jobSeeker = auth()->user()->jobSeeker;
            if (!$jobSeeker->favorites()->where('job_id', $jobId)->exists()) {
                if(auth()->user()){}
                $jobSeeker->favorites()->attach($jobId);
            }
            else{
                return redirect()->route('jobs.jobDetail', $jobId)->with('error', 'Job is Already Favorited!');
            }
        // Check if the job is already in favorites

        return redirect()->route('jobs.jobDetail', $jobId)->with('success', 'Job added to favorites!');
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
