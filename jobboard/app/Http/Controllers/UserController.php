<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\JobSeeker;
use App\Models\Employer;
use App\Models\Admin;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Session\Session as SessionSession;

class UserController extends Controller
{
    
    public function forgetPassword(){
        return view('front.account.forget_password');
    }
    public function forgetPasswordPost(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users'
        ]);
        $token = Str::random(length:64);
        DB::table('password_reset')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now()
        ]);
        Mail::send("front.account.forget_password_mail_template",['token'=>$token],function($message) use ($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return redirect()->to(route('forgetPassword'))->with('success','we have send a mail to your email to reset password');
    }
    public function resetPassword($token){
        return view('front.account.new_password',compact('token'));
    }
    public function resetPasswordPost(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users',
            'password'=>'required',
            'confirm_password'=>'required|same:password'
            
        ]);
        $updatePassword = DB::table('password_reset')->where([
            'email'=> $request->email,
            'token'=> $request->token,
        ])->first();
        if(!$updatePassword){
            return redirect()->to(route('resetPassword'))->with('message','invalid');
        }
        User::where('email',$request->email)->update(['password'=>Hash::make($request->password)]);
        DB::table('password_reset')->where(['email'=>$request->email])->delete();
        return redirect()->to(route('userlogin'))->with('success','Password Reset Successfully');
    }
    // function that validate inputs and register the user
    //  and also call the fuction to add data to their specific role model
    public function addUserData(Request $req){
        $req->validate([
            'name'=>'required',
            'email'=>'required|email',
            'role'=>'required',
            'password'=>'required',
            'password_confirmation'=>'required|same:password'
        ]);
        $user = User::create([
            'name'=> $req['name'],
            'email'=>$req['email'],
            'role'=> $req['role'],
            'password'=>Hash::make($req['password']),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        // event(new Registered($user));
        // Auth::login($user);
        // return redirect(RouteServiceProvider::Home);
        if($user){
            $this->insertProfileData($user, $req);
            $this->sendVerificationEmail($user);
            return redirect()->route('userlogin')->with('success','Please verify your email to access dashboard check your inbox or spam folder to verify');
        }
        else{
            return redirect()->back();
        }
    }
    public function verificationEmailMessage(){
        $user = Auth::user();
        $this->sendVerificationEmail($user);
        
        return redirect()->route('verification')->with('success','Email send successfully please check your inbox or spam folder ');
    }
    
   private function sendVerificationEmail($user)
    {
        $verificationUrl = route('verify', ['id' => $user->id]);
        try{
            Mail::send('front.account.verify', ['verificationUrl' => $verificationUrl], function ($message) use ($user) {
                $message->to($user->email)->subject('Verify Your Email Address');
        });
        }
        catch(Exception  $e){
            // return redirect()->route('verification')->with('error',$e->getMessage() );
        }
    }

    public function verify($id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('userlogin')->with('success', 'Email verified successfully. You can now login.');
    }
    public function verification(){
        return view('front.account.verification');
    }

    // function that store the data to the job_seeker or employer table based on their role
    protected function insertProfileData(User $user, Request $req)
    {
        switch ($req['role']) {
            case 'job_seeker':
                JobSeeker::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    // Add additional job_seeker-specific data here
                ]);
                break;
            case 'company':
                Employer::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    // Add additional company-specific data here
                ]);
            case 'admin':
                Admin::create([
                    'user_id' => $user->id,
                    'admin_name' => $user->name,
                    'email' => $user->email,
                    // Add additional company-specific data here
                ]);
                break;
        }
    }

    public function postJob(Request $req){
        $req->validate([
            'job_title'=>'required',
            'job_region'=>'required',
            'job_type'=> 'required',
            'vacancy'=>'required',
            'job_category'=>'required',
            'experience'=>'required',
            'salary'=> 'required',
            'gender'=>'required',
            'application_deadline'=> 'required',
            'job_description'=>'required',
            'responsibilities'=>'required',
            'education_experience'=>'required',
            'other_benifits'=>'required',
        ]);
        $company = User::find(Session::get('user')['id']);
        $user = DB::table('jobs')->insert([
            'job_title'=> $req->job_title,
            'job_region'=>$req->job_region,
            'job_type'=> $req->job_type,
            'vacancy'=>$req->vacancy,
            'job_category'=>$req->job_category,
            'experience'=>$req->experience,
            'salary'=> $req->salary,
            'gender'=>$req->gender,
            'application_deadline'=> $req->application_deadline,
            'job_description'=>$req->job_description,
            'responsibilities'=>$req->responsibilities,
            'education_experience'=>$req->education_experience,
            'other_benifits'=>$req->other_benifits,
            'company_id'=> $company->id,
            'company_email'=> $company->email,
            'company_name'=> $company->username,
            'company_image'=>$company->img,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        if($user){
            return redirect()->route('users')->with('message','Registered Successfully');
        }
        else{
            return back()->withErrors('Error');
        }
        
    }
    // function that authenticate the user for login
    public function userLogin(Request $req){

        $req->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        // Another Mehod for authenticate
        // $user =  User::where(['email'=>$req->email])->first();
        // if(!$user || !Hash::check($req->password,$user->mypassword)){
        //     return "<script>alert('Error')</script>";
        // }
        if(Auth::attempt($req->only('email','password'))){
            $user = auth()->user();
            $req->session()->put('user',$user);
            return redirect()->route('home')->with('success','SignIn Successfully');
        }
        else{
            return redirect()->route('userlogin')->with('error','Invalid Crediantials');
        }
    }


    public function edit()
    {
        $user = auth()->user();
        $jobSeeker = $user->jobSeeker;
        $employer = $user->Employer;
        if($user->role == 'job_seeker'){
            return view('editJobSeeker', compact('jobSeeker'));
        }
        if($user->role == 'company'){
            return view('editEmployer', compact('employer'));
        }
    }
    public function update(Request $req,$id){
       $user = User::find($id);
                
                        if($req->hasFile('img')){
                            $destination = storage_path($user->img);
                            if(file_exists($destination)){
                                // unlink($destination);
                            }
                            $imgname = time()."-ab.".$req->file('img')->getClientOriginalExtension();
                            $path = $req->file('img')->storeAs('images',$imgname,'public');
                            $imgname = '/storage/images/'.$imgname;
                        }
                        else{
                            $imgname=$user->img;
                        }
                        $req->validate([
                            'name'=>'required',
                            'email'=>'required|email',
                            'img'=>'file|mimes:jpg,png|max:2048',
                            'contactno'=>'required',
                            'title'=>'required',
                            'bio'=>'required'
                            ]);
                
                $users = DB::table('users')->where('id',$id)->update([
                    'username'=>$req->name,
                    'email'=>$req->email,
                    'img'=>$imgname,
                    'contactno'=>$req->contactno,
                    'title'=>$req->title,
                    'bio'=>$req->bio,
                    'facebook'=>$req->facebook,
                    'twitter'=>$req->twitter,
                    'linkedin'=>$req->linkedin,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
                if($users){
                    return back()->with('success','Profile Updated Successfully');
                }
                else{
                    return back()->with('error','Error');
                }
    }


    public function addAdminData(Request $req){
        $req->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'password_confirmation'=>'required|same:password'
        ]);
        $user = User::create([
            'name'=> $req['name'],
            'email'=>$req['email'],
            'role'=> $req['role'],
            'password'=>Hash::make($req['password']),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        if($user){
            $this->insertProfileData($user, $req);
            return redirect()->route('userlogin')->with('success','Registered Successfully');

        }
        
        else{
            return redirect()->back();
        }

    }
    public function changePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
            
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error',$validator->errors());
        }
        if(Hash::check($request->old_password,Auth::user()->password) == false){
            return redirect()->back()->with('error','Your Old Password is incorrect');
        }
        
        $user = User::Find(Session::get('user')['id']);
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success','Password Updated Successfully');

            
    }

    public function updateProfileImage(Request $request)
    {
        $user = User::Find(Session::get('user')['id']);

        $validator = Validator::make( $request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->passes()){

             // Remove the existing profile image
        if ($user->img_path) {
            File::delete(storage_path('app/public/'.$user->img_path));
        }
            // Generate a unique filename for the profile image
        $imageFileName = 'profile_image_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

        // Upload the new profile image
        $imagePath = $request->file('image')->storeAs('images', $imageFileName, 'public');
        
        // Update profile image file path in the database
        
        $user->img_path = $imagePath;
        $user->save();
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
}