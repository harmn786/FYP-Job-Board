<?php

namespace App\Http\Controllers;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Session;
use App\Models\Category;
use App\Models\JobType;
class JobController extends Controller
{
    // function index(){
    //     $data =  Job::all();
    //     return view('index',['jobdata'=>$data]);
    // }
    public function index()
    {
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        // $jobs = Job::with('employer')->where('approved_by_admin', true)->paginate(8);
        $jobs = Job::where('approved_by_admin', true)->whereDate('application_deadline', '>=', Carbon::now()->toDateString())->orderby('created_at','DESC')
        ->limit(3)->get();
        $featured_jobs = Job::with('employer')->where('featured', true)->orderby('created_at','DESC')->limit(3)->get();
        return view('front.app.index',['categories' => $categories], compact('featured_jobs','jobs'));
    }
    public function categories()
    {
        $categories = Category::orderBy('name','ASC')->where('status',1)->paginate(8);
        return view('front.app.categories',['categories' => $categories]);
    }

    public function exploreJobs(Request $request){
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $job_types = JobType::orderBy('name','ASC')->where('status',1)->get();
        $jobs = Job::query();

        // Check if the request contains a job title filter
        if ($request->has('title')) {
            $jobs->where('title', 'like', '%' . $request->input('title') . '%');
        }

        // Check if the request contains a category filter
        if ($request->has('category')) {
            $jobs->where('category_id', 'like', '%' . $request->input('category') . '%');
        }

        // Check if the request contains a location filter
        if ($request->has('location')) {
            $jobs->where('location', 'like', '%' . $request->input('location') . '%');
        }
        $jobtypeArray = [];
         // Check if the request contains a Job_Type filter
         if ($request->has('job_type')) {
            $jobtypeArray = explode(',', $request->job_type);
            $jobs->whereIn('job_type_id',$jobtypeArray);
        }

        // Check if the request contains a Experience filter
        if ($request->has('experience')) {
            $jobs->where('experience', 'like', '%' . $request->input('experience') . '%');
        }

        if($request->has('sort') && $request->input('sort') == 1){
            $jobs = $jobs->orderBy('created_at','DESC');
        }
        else{
            $jobs = $jobs->orderBy('created_at','ASC');
        }

        $jobs = $jobs->paginate(6);

        
        
       
        // $jobs =  Job::whereDate('application_deadline', '>=', Carbon::now()->toDateString())->orderby('created_at','DESC')
        // ->paginate(8);
        return view('front.app.exploreJobs', ['jobs'=>$jobs,'categories' => $categories,'job_types'=>$job_types, 'jobTypeArray'=>$jobtypeArray]);
    }


    public function jobDetail($id)
    {
        // Fetch the details of a specific job
        $job = Job::findOrFail($id);

        return view('front.app.jobDetail', compact('job'));
    }


    public function jobSearch(Request $request)
    {
        $jobs = Job::query();

        // Check if the request contains a job title filter
        if ($request->has('title')) {
            $jobs->where('title', 'like', '%' . $request->input('title') . '%');
        }

        // Check if the request contains a category filter
        if ($request->has('category')) {
            $jobs->where('category_id', 'like', '%' . $request->input('category') . '%');
        }

        // Check if the request contains a location filter
        if ($request->has('location')) {
            $jobs->where('location', 'like', '%' . $request->input('location') . '%');
        }

        $jobs = $jobs->paginate(6);

        return view('front.app.search_result', compact('jobs'));
    }

    public function jobsByCategory($id){

        $jobs = Job::where('category_id',$id)->paginate(6);

        return view('front.app.search_result', compact('jobs'));
    }
    

}
