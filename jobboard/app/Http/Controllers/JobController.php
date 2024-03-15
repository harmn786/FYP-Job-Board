<?php

namespace App\Http\Controllers;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class JobController extends Controller
{
    // function index(){
    //     $data =  Job::all();
    //     return view('index',['jobdata'=>$data]);
    // }
    public function index()
    {
        $jobs = Job::with('employer')->where('approved_by_admin', true)->paginate(8);
        return view('index', compact('jobs'));
    }
    public function show($id)
    {
        // Fetch the details of a specific job
        $job = Job::findOrFail($id);

        return view('show', compact('job'));
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
            $jobs->where('category', 'like', '%' . $request->input('category') . '%');
        }

        // Check if the request contains a location filter
        if ($request->has('location')) {
            $jobs->where('location', 'like', '%' . $request->input('location') . '%');
        }

        $jobs = $jobs->get();

        return view('search_result', compact('jobs'));
    }

    

}
