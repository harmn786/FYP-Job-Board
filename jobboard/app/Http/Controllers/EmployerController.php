<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Employer;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Mail\NotificationEmailToAdminForApproveJob;
use App\Mail\NotificationEmailToEmployerPostJob;
use App\Mail\NotificationEmailToJobSeekerAfterApplicationStatusChange;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JobApplicantsExport;
use App\Models\Admin;
use App\Models\JobSeeker;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Support\Facades\Log;
use Exception;
use ZipArchive;
use League\Csv\Writer;
use League\Csv\CannotInsertRecord;
use Illuminate\Support\Facades\Response;
use Purifier;


class EmployerController extends Controller
{

    public function edit()
    {
        $user = auth()->user();
        $employer = $user->Employer;
        return view('employer.editEmployer', compact('employer'));
    }

    public function create_job()
    {
        $user = auth()->user();
        $employer = $user->Employer;
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $job_types = JobType::orderBy('name','ASC')->where('status',1)->get();

        if($user->role == 'company'){
            return view('employer.job_create',['job_types' => $job_types,'categories' => $categories]);
        }
    }
    
    public function store(Request $request)
    {
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $job_types = JobType::orderBy('name','ASC')->where('status',1)->get();

        // Validate the form data
        $request->validate([
            'job_title' => 'required|string|max:255',
            'job_type' => 'required',
            'vacancy' => 'required|numeric',
            'salary' => 'required|numeric',
            'education' => 'required',
            'experience' => 'required',
            'job_region' => 'required',
            'gender' => 'required',
            'application_deadline' => 'required',
            'job_description' => 'required',
            'other_requirements' => 'required',
            'other_benifits' => 'required',
            'company_email' => 'required',
            'category' => 'required',
            
        ]);
        $user = auth()->user();
        $employer = $user->Employer;
        // Create a new job with status set to pending
        if(!$employer->hasMandatoryFieldsFilled()){
            return redirect()->route('jobs.create')->with('success', 'Please Complete Your Profile to Post a Job',['job_types' => $job_types,'categories' => $categories]);
        }
        $job = $employer->jobs()->create([
            'title' => $request->input('job_title'),
            'job_type_id' => $request->input('job_type'),
            'vacancy' => $request->input('vacancy'),
            'salary' => $request->input('salary'),
            'education' => $request->input('education'),
            'experience' => $request->input('experience'),
            'location' => $request->input('job_region'),
            'gender' => $request->input('gender'),
            'application_deadline' => $request->input('application_deadline'),
            'description' => Purifier::clean($request->input('job_description')),
            'other_requirements' => Purifier::clean($request->input('other_requirements')),
            'other_benifits' =>Purifier::clean($request->input('other_benifits')),
            'company_name' => $request->input('company_name'),
            'company_email' => $request->input('company_email'),
            'category_id' => $request->input('category'),
            'employer_id' => $employer->id,
            'company_image' => $employer->img_path,
            'approved_by_admin' => false,
            'created_at' => now(),
            'updated_at '=> now(),
        ]);
        $mailData = [
            'employer' => $employer,
            'job' => $job,
        ];
        Mail::to($employer->email)->send(new NotificationEmailToEmployerPostJob($mailData));
        Mail::to('devbyabdulrehman@gmail.com')->send(new NotificationEmailToAdminForApproveJob($mailData));
        return redirect()->route('jobs.create')->with('success', 'Job posted successfully. Awaiting admin approval.',['job_types' => $job_types,'categories' => $categories]);

    }

    

    public function update(Request $request)
    {
        $user = auth()->user();
        $employer = $user->Employer;

        $request->validate([
            'industry'=>'required',
            'contact_person'=>'required',
            'contact_number'=>'required',
            // Add other fields as needed
        ]);

        // Update profile details
        $update = $employer->update([
            'name' => $user->name,
            'email' => $user->email,
            'industry' => $request->input('industry'),
            'contact_person' => $request->input('contact_person'),
            'contact_number' => $request->input('contact_number'),
            // Update other fields
        ]);

        return redirect()->route('editEmployer')->with('success', 'Profile details updated successfully.');
    }


    public function updateProfileImage(Request $request)
    {
        $user = auth()->user();
        $employer = $user->Employer;

        $validator = Validator::make( $request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->passes()){

             // Remove the existing profile image
        if ($employer->img_path) {
            File::delete(storage_path('app/public/'.$employer->img_path));
        }
            // Generate a unique filename for the profile image
        $imageFileName = 'profile_image_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

        // Upload the new profile image
        $imagePath = $request->file('image')->storeAs('images', $imageFileName, 'public');
        
        // Update profile image file path in the database
        $employer->update(['img_path' => $imagePath]);
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

    // public function approveApplication(Request $request,JobApplication $jobApplication)
    // {
    //     // Check if the logged-in user is the employer associated with the job
    //     $user = auth()->user();
    //     $employer = $user->Employer;
    //     if ($employer->id !== $jobApplication->job->employer_id) {
    //         abort(403, 'Unauthorized action.');
    //     }
    //     // Approve the job application
    //     $jobApplication->update(['status' => 'approved']);

    //     return redirect()->route('employer.jobApplications')->with('success', 'Job application approved successfully.');
    // }

    // public function rejectApplication(JobApplication $jobApplication)
    // {
    //     // Check if the logged-in user is the employer associated with the job
    //     $user = auth()->user();
    //     $employer = $user->Employer;
    //     if ($employer->id !== $jobApplication->job->employer_id) {
    //         abort(403, 'Unauthorized action.');
    //     }
    //     // Reject the job application
    //     $jobApplication->update(['status' => 'rejected']);

    //     return redirect()->route('employer.jobApplications')->with('success', 'Job application rejected successfully.');
    // }

    public function postedJobs()
    {
        $user = auth()->user();

        // Fetch jobs posted by the logged-in employer
        $jobs = $user->employer->jobs;
        return view('employer.posted_jobs', compact('jobs'));
    }

    public function editJob(Request $request,Job $job)
    {
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $job_types = JobType::orderBy('name','ASC')->where('status',1)->get();
        // Show the form for editing the job details
        return view('employer.update_job', compact('job'),['job_types' => $job_types,'categories' => $categories]);
    }

    public function updateJob(Request $request, Job $job)
    {
        // Validate the form data
        $request->validate([

            'job_title' => 'required|string|max:255',
            'job_type' => 'required',
            'vacancy' => 'required|numeric',
            'salary' => 'required|numeric',
            'education' => 'required',
            'experience' => 'required',
            'job_region' => 'required',
            'gender' => 'required',
            'application_deadline' => 'required',
            'job_description' => 'required',
            'other_requirements' => 'required',
            'other_benifits' => 'required',
            'company_email' => 'required',
            'category' => 'required',

        ]);

        // Update the job details
        $job->update([
            'title' => $request->input('job_title'),
            'job_type_id' => $request->input('job_type'),
            'vacancy' => $request->input('vacancy'),
            'salary' => $request->input('salary'),
            'education' => $request->input('education'),
            'experience' => $request->input('experience'),
            'location' => $request->input('job_region'),
            'gender' => $request->input('gender'),
            'application_deadline' => $request->input('application_deadline'),
            'description' => $request->input('job_description'),
            'other_requirements' => $request->input('other_requirements'),
            'other_benifits' => $request->input('other_benifits'),
            'company_name' => $request->input('company_name'),
            'company_email' => $request->input('company_email'),
            'category_id' => $request->input('category'),
            'approved_by_admin' => false,
        ]);

        return redirect()->route('employer.editJob',$job)->with('success', 'Job details updated successfully and send to admin for approval changes.');
    }

    public function deleteJob(Request $request, Job $job)
    {
        $delete = $job->delete();
        if($delete){
            return redirect()->route('employer.postedJobs')->with('success', 'Job deleted successfully.');
        }
    }

    public function showJobApplications($jobId)
    {
        $job = Job::findOrFail($jobId);
        $jobApplications = JobApplication::where('job_id', $jobId)->paginate(5);

        return view('employer.job_applications_for_approval', compact('job', 'jobApplications'));
    }
    public function viewCVByEmployer($id)
    {

        $Application = JobApplication::where('id',$id)->first();
        $pdfData = $Application->jobSeeker->cv_path;

        // Set response headers
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline', // or 'attachment' to force download
        ];

        // Stream the PDF file content to the user's browser
        return response($pdfData, 200, $headers);
    }

    public function approveJobApplication(Request $request, $applicationId)
    {
        $request->validate([
            'status' => 'required|in:Accepted,Rejected',
            'remarks' => 'required'
        ]);

        $jobApplication = JobApplication::findOrFail($applicationId);
        $job = $jobApplication->job;
        $jobSeeker = $jobApplication->jobSeeker;
        $jobApplication->status = $request->status;
        $jobApplication->remarks = $request->remarks;
        $jobApplication->save();
        $mailData = [
            'jobSeeker'=>$jobSeeker,
            'job' => $job,
        ];
        Mail::to($jobSeeker->email)->send(new NotificationEmailToJobSeekerAfterApplicationStatusChange($mailData));

        return redirect()->back()->with('success', 'Job application has been updated successfully.');
    }

    public function downloadCVs($jobId)
    {
        // Get all job applications for the specific job
        $jobApplications = JobApplication::where('job_id', $jobId)->get();
        
        // Create a temporary directory to store the CV files
        $tempDir = storage_path('app/temp_cvs');
        File::makeDirectory($tempDir, 0755, true);
        // Loop through each job application
        foreach ($jobApplications as $jobApplication) {
            $jobSeeker = $jobApplication->jobSeeker;
            $cvPath = $jobSeeker->cv_path;


            // Get the job seeker name for the filename
            $filename = $jobSeeker->cnic . '.pdf';
            if ($cvPath === false) {
                // Log or handle error
                continue; // Skip to the next job application
            }

            // Save the CV file to the temporary directory
            if (file_put_contents($tempDir . '/' . $filename, $cvPath) === false) {
                // Log or handle error
                continue; // Skip to the next job application
            }
        }

        // Create a zip archive of the CV files
        $zipFilePath = storage_path('app/applicants_cvs.zip');
        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = File::files($tempDir);
            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }

        // Delete the temporary directory
        File::deleteDirectory($tempDir);

        // Download the zip archive
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
    
    // public function downloadCVs($jobId)
    // {
        
    //     // Get job applications related to the given job ID
    //     $jobApplications = JobApplication::where('job_id', $jobId)->get();
    //     // Create a temporary directory to store the CV files
    //     $tempDir = storage_path('temp');
    //     File::makeDirectory($tempDir);
    //     // Add each job seeker's CV to the temporary directory
    //     foreach ($jobApplications as $jobApplication) {
    //         $cvPath = storage_path('app/public/' . $jobApplication->jobSeeker->cv_path);
    //         $cvName = $jobApplication->jobSeeker->email . '_CV.pdf';
    //         File::copy($cvPath, storage_path('temp/' . $cvName));
    //     }
    //     // Create a zip file containing the CV files
    //     $zipFilePath = storage_path('temp.zip');
    //     $zip = new ZipArchive;
    //     if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
    //         $files = File::files($tempDir);
    //         foreach ($files as $file) {
    //             $zip->addFile($file, basename($file));
    //         }
    //         $zip->close();
    //     }
    //     // Clean up the temporary directory
    //     File::deleteDirectory($tempDir);
    //     // Download the zip file
    //     try{
    //         return response()->download($zipFilePath)->deleteFileAfterSend(true);
    //     }
    //     catch(Exception $e){
    //         return redirect()->back()->with('error', 'No Applicants Founds');
    //     }
    // }


    // public function downloadApplicants($jobId)
    // {
    //     // Get job applications for the specified job
    //     $jobApplications = JobApplication::where('job_id', $jobId)->get();

    //     // Generate and download Excel sheet
    //     return Excel::download(new JobApplicantsExport($jobApplications), 'applicants.xlsx');
    // }

    public function downloadApplicants($jobId)
    {
        // Get all job applications for the specific job
        $jobApplications = JobApplication::where('job_id', $jobId)->get();

        // Create a new CSV writer
        $csv = Writer::createFromString('');

        // Insert CSV headers
        $csv->insertOne(['Job Seeker Name', 'Email', 'Phone', 'CNIC', 'DOB', 'Address', 'Education', 'Experience', 'Skills', 'Application Date']);

        // Insert job application data
        foreach ($jobApplications as $jobApplication) {
            $jobSeeker = $jobApplication->jobSeeker;
            $data = [
                $jobSeeker->name,
                $jobSeeker->email,
                $jobSeeker->contact_no,
                $jobSeeker->cnic,
                $jobSeeker->dob,
                $jobSeeker->address,
                $jobSeeker->education,
                $jobSeeker->experience,
                $jobSeeker->skills,
                $jobApplication->application_date,
            ];

            try {
                $csv->insertOne($data);
            } catch (CannotInsertRecord $e) {
                // Handle insertion error
                return back()->with('error', 'Failed to insert record to CSV');
            }
        }

        // Set CSV response headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="applicants.csv"',
        ];

        // Output the CSV content to the browser
        return response($csv, 200, $headers);
    }

    public function jobSeekerDetail(Request $request,JobSeeker $jobSeeker)
    {
        // Show the form for editing the job details
        return view('employer.jobseekerDetail', compact('jobSeeker'));
    }

}

