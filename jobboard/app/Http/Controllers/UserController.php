<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
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
                break;
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

    // function that authenticate the user for login
    public function userLogin(Request $req){

        $req->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($req->only('email','password'))){
            $user = auth()->user();
            $req->session()->put('user',$user);
            return redirect()->route('dashboard')->with('success','Please update your profile credentials if you have not updated yet ');
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
    // Validate the uploaded image
    $validator = Validator::make( $request->all(),[
                'image' => 'required|image|mimes:jpeg,png|max:2048',
            ]);
    // Get the uploaded image
    $image = $request->file('image');

    // Read the image file content and encode it as base64
    $imageData = base64_encode(file_get_contents($image->getRealPath()));

    // Get the authenticated user
    $user = auth()->user();

    // Update the img column with the image data
    // Redirect back with success message or return JSON response
    if($validator->passes()){
        $user->update(['img_path' => $imageData]);
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
    public function addContactFormData(Request $req){
        $req->validate([
            'name'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required',
        ]);
        $data = DB::table('contacts')->insert([
            'name'=> $req['name'],
            'email'=>$req['email'],
            'subject'=>$req['subject'],
            'message'=>$req['message'],
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        if($data){
            return redirect()->back()->with('message','Form Data Submitted Successfully');
        }
        else{
            return redirect()->back()->with('error','Error');
        }
    }
}