<?php

namespace App\Http\Controllers;
use App\Models\Blogs;
use App\Models\chat;
use App\Models\chat_notify;
use App\Models\Content;
use App\Models\Loginpage;
use App\Models\Payment;
use App\Models\Playlist;
use App\Models\usd_gpd;
use App\Models\User;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\NodeVisitor\FirstFindingVisitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class UserAdmin extends Controller
{

    public function login(){
        $data = Loginpage::select()->first();
        return view('layout.user-admin.login')->with('data', $data);
    }
    public function home(){
        $user = Auth::user();
        
        $paymentStatus = Payment::select()->where('user_id', $user->id)->orderBy('id', 'desc')->first();
        
        return view('layout.user-admin.home')->with(['Payment'=>$paymentStatus,'user' => $user]);
    }
    public function homeAjax(){
        $user = Auth::user();
        
        $paymentStatus = Payment::select()->where('user_id', $user->id)->orderBy('id', 'desc')->first();
        
        $responseData = CountDays($paymentStatus->end_date, $paymentStatus->id);

        return $responseData;
    }
    public function dashboard(){

        $thisDate = today()->format('Y-m-d');       
        $videos = chat_notify::select('video_id')->where('video_id','!=','')->with('Videos')->orderBy('video_id', 'desc')->distinct()->get();
        $Blogs = chat_notify::select('blogs_id')->where('blogs_id','!=','')->with('BlogNews')->orderBy('blogs_id', 'desc')->distinct()->get();
        $FundamentalData = chat_notify::select()->where('usd_gpds_id', '!=', '')->with('fundaMentalData')->orderBy('usd_gpds_id', 'desc')->distinct()->get();
        $ingle_video = Videos::select()->where(['real_time'=>'1'])->orderBy('id','desc')->first();

        return view('layout.user-admin.dashboard-new')->with(['videos'=>$videos,'SingleVideo'=>$ingle_video,'blogs'=>$Blogs, 'FundamentalData'=>$FundamentalData]);

    }

    // getting videos
    public function AjaxDashboard(Request $request)
    {
        $user   = Auth::user();
        if (Schema::hasColumns('chat_notify', ['user_id', 'video_id'])) {
            $existingData = chat_notify::where('user_id', $user->id)->pluck('video_id')->toArray();
            $Videos = Videos::whereNotExists(function ($query) use ($existingData) {
                $query->select('video_id')
                    ->from('chat_notify')
                    ->whereColumn('videos.id', 'chat_notify.video_id')
                    ->whereIn('video_id', $existingData);
            })
            ->take(1)
            ->get();
            $VideosIDs = $Videos->pluck('id')->toArray();
            if (count($VideosIDs) > 0) {
                foreach ($VideosIDs as $ID) {
                    if (!in_array($ID, $existingData)) {
                        $chatNotify = new chat_notify;
                        $chatNotify->user_id = $user->id;
                        $chatNotify->video_id = $ID;
                        $chatNotify->save();
                    }
                    return $Videos->toJson(); 
                }
            } else {
                return 'false';
            }
        } else {
            return 'The chat_notify table does not have the required columns.';
        }
            
        
    }

    public function training(){ 
        
        $userID = Auth::user()->id;
        $contents = Content::with('PlaylistData')->where('title', '!=', 'Indicators')->select()->get();
        $AllPlaylist = Playlist::select('id')->where('title', '!=', 'Indicators')->count();

        return view('layout.user-admin.training')->with(['contents'=> $contents, 'AllPlaylist'=>$AllPlaylist,'userID' =>$userID]);
    }
    public function playlist($id =''){
        $Videos = Videos::with('PlaylistData')->select()->where('show', '0')->where('playlists_id', $id)->orderBy('id','desc')->get();
        
        if(head($Videos->toArray()) == false){
            $Videos = '';
        }
        return view('layout.user-admin.playlist')->with(['videos' => $Videos]);
    }
    public function search(){
        
    }

    public function UserLogin(Request $request){

        //Validation...
        $this->validator($request);

        if(Auth()->guard('web')->attempt($request->only('email','password'))){
            
            return redirect()->route('user-dashboard')->with('status','You are Logged in as Admin!');
        }

        //Authentication failed...
        return $this->loginFailed();
    }

    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:users|min:5|max:191',
            'password' => 'required|string|min:3|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules,$messages);
    }
    public function logout(){
        
        Auth()->logout();
        return redirect()->route('user-login')->with('status','User has been logged out!');
    }
    public function profile(){
        $user = Auth::user();
        return view('layout.user-admin.profile')->with(['user'=>$user]);
    }
    public function update(Request $request){

        $userId = Auth::user();
        $User = User::find(intval($userId->id));
        
        if(!empty($request->password)){
            $password = Hash::make($request->password);
        }else{
            $password = $User->password;
        }
        if(!empty($request->image)){
            $image = uploadFils($request, 'image')['file'];
        }else{
            $image = $User->image;
        }

        try{
            $User->name = $request->name;
            $User->email = $request->email;
            $User->phone = $request->phone;
            $User->address = $request->address;
            $User->password = $password;
            $User->image = $image;
            $User->save();
            return redirect()->route('account');
        } catch (\Throwable$th) {
            return redirect()->back();
        }
    }
    public function signup(Request $request){
        $password = Hash::make($request->password);
        $img = uploadFils($request, 'image');
        $ok = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'hfm'       => $request->hfm,
            'password'  => $password,
            'type'      => $request->type,
            'status'    => 'Un-Paid',
            'request'   => 'Pending',
        ]);
        if ($ok) {

            $this->validator($request);
            if(Auth()->guard('web')->attempt($request->only('email','password'))){
                return redirect()->route('home')->with('status','You are Logged in as Admin!');
            }else{
                return redirect()->back();
            }
            
        } else {
            return redirect()->back();
        }
        
    }

}
