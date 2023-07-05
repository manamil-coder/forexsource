<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\chat_notify;
use App\Models\Playlist;
use App\Models\playlist_amount;
use App\Models\User;
use App\Models\Videos;
use App\Models\usd_gpd;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function index($id=''){
        $users = User::with('UserPayment')->with('PaymentHistory')->select()->orderBy('id', 'desc')->get();
        if(!empty($id)){
            $EditUser = User::select()->where('id', $id)->first();
        }
        return view('layout.supper-admin.users')->with(['users'=>$users,'editUser'=>@$EditUser]);
    }

    public function userInfo($id=''){
        
            $users = User::select()->where('id', $id)->first();
            $BuyList = playlist_amount::with('PlaylistName')->select()->where('user_id',$id)->get();
            
        
        
        return view('layout.supper-admin.users-info')->with(['users'=>$users,'BuyList'=>$BuyList ]);
    }

    public function store(Request $request)
    {
        $password = Hash::make($request->password);
        $img = uploadFils($request, 'image');
        $ok = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'password'  => $password,
            'image'     => $img['file'],
        ]);
        if ($ok) {
            return redirect()->route('users');
        } else {
            return redirect()->back();
        }
    }
    
    public function destroy($id){
        User::find($id)->delete();
        return redirect()->back();  
    }
    public function update(Request $request){
        
        $User = User::find(intval($request->id));
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
            return redirect()->route('users');
        } catch (\Throwable$th) {
            return redirect()->back();
        }
    }
    public function ajaxUserNote(Request $request){

        $User = User::find(intval($request->id));

        try{
            $User->note = $request->note;
            $User->save();
            return redirect()->route('users');
        } catch (\Throwable$th) {
            return redirect()->back();
        }
    }
    public function videos($id = null){

        if(!empty($id)){
            $editVideo = Videos::find(intval($id));
        }else{
            $editVideo = null;
        }
        $Videos = Videos::with('PlaylistData')->select()->where('real_time', '0')->orderBy('id','desc')->get();
        $playlists = Playlist::select()->orderby('id', 'desc')->get();
        return view('layout.supper-admin.videos')->with(['playlists'=>$playlists,'videos' => $Videos, 'editVideo' => $editVideo]);
    }

    public function videosUpdate(Request $request)  {

        $videos = Videos::find(intval($request->id));

        $KillerPlayerUrl        = explode("'", explode(" src='", $request->input('killerPlayer'))[1])['0'];
        $YouTube                = explode("&", explode("v=", $request->input('YouTube'))[1])[0];

        $videos->title          = $request->title;
        $videos->killerPlayer   = $KillerPlayerUrl;
        $videos->YouTube        = $YouTube;

        $videos->save();
        return  redirect()->route('videos')->with('success', 'Save changes successfully.');
    }

    public function add_videos(Request $request){
        $KillerPlayerUrl    = explode("'", explode(" src='", $request->killerPlayer)[1])['0'];
        $YouTube            = explode("&", explode("v=", $request->YouTube)[1])[0];
        $ok = Videos::create([
            'killerplayer'  => $KillerPlayerUrl,
            'youtube'       => $YouTube,
            'title'         => $request->title,
            'playlists_id'  => $request->playlists_id,
            'show'          => '0',
        ]);
        if ($ok) {
            return redirect()->route('videos')->with('success', 'Video Successfully inserted.');
        } else {
            return redirect()->back();
        }
    }
    public function deleted_videos($id = ''){
        $Videos = Videos::find($id);
        $Videos->delete();
        return redirect()->route('videos')->with('success', 'Video Successfully deleted.');  
    }

    public function realTimeVideos($id = null){
        if(!empty($id)){
            $EditVideo = Videos::select()->where('real_time', '1')->where('id', $id)->first();
        }else{
            $EditVideo = null;
        }
        $Videos = Videos::select()->where('real_time', '1')->orderBy('id','desc')->get();
        return view('layout.supper-admin.real-time-videos')->with(['videos' => $Videos, 'EditVideo'=>$EditVideo]);
    }

    public function realTimeVideoUpdate(Request $request, $id) {
        
        $videos = Videos::find($id);

        $KillerPlayerUrl        = explode("'", explode(" src='", $request->input('killerPlayer'))[1])['0'];
        $YouTube                = explode("&", explode("v=", $request->input('YouTube'))[1])[0];

        $videos->title          = $request->input('title');
        $videos->killerPlayer   = $KillerPlayerUrl;
        $videos->YouTube        = $YouTube;

        $videos->save();
        return  redirect()->route('real-time-videos')->with('success', 'Save changes successfully.');

    }


    public function addRealTimeVideos(Request $request){
        $KillerPlayerUrl    = explode("'", explode(" src='", $request->killerPlayer)[1])['0'];
        $YouTube            = explode("&", explode("v=", $request->YouTube)[1])[0];
        $ok = Videos::create([
            'killerplayer'  => $KillerPlayerUrl,
            'youtube'       => $YouTube,
            'title'         => $request->title,
            'show'          => '0',
            'real_time'     => '1',
        ]);
        if ($ok) {
            return redirect()->route('real-time-videos')->with('success', 'Insert data successfully.');
        } else {
            return redirect()->back();
        }
    }
    public function deleteRealTimeVideos($id = ''){
        $Videos = Videos::find($id);
        $Videos->delete();
        return  redirect()->route('real-time-videos')->with('success', 'Delete video Successfully.');
    }


    public function gettingFundamentalData(){
        $user = Auth::user();

        if (Schema::hasColumns('chat_notify', ['user_id', 'usd_gpds_id'])) {
            $existingData = chat_notify::where('user_id', $user->id)->pluck('usd_gpds_id')->toArray();
            $GPDS = usd_gpd::whereNotExists(function ($query) use ($existingData) {
                $query->select('usd_gpds_id')
                    ->from('chat_notify')
                    ->whereColumn('usd_gpds.id', 'chat_notify.usd_gpds_id')
                    ->whereIn('usd_gpds_id', $existingData);
            })
            ->take(1)
            ->get();

            $GPDSIDs = $GPDS->pluck('id')->toArray();
            if (count($GPDSIDs) > 0) {
                foreach ($GPDSIDs as $ID) {
                    // Check if the blogs_id already exists in chat_notify for the user
                    if (!in_array($ID, $existingData)) {
                        $chatNotify = new chat_notify;
                        $chatNotify->user_id = $user->id;
                        $chatNotify->usd_gpds_id = $ID;
                        $chatNotify->save();
                    }
                    return $GPDS->toJson(); 
                }
            }else {
                return 'false';
            }
        }
    }

    public function UserAjaxChat(){
        $chat = chat::with('UserData')->select()->where('created_at', '>=', Carbon::today())->get();
        $html ='';
        $user = Auth::user();

        
        foreach ($chat as $items ){
            $chatNotify  = chat_notify::select('user_id')->where('message_id', $items->id)->where('user_id', $user->id)->take(1)->first();
            if(!$chatNotify){
            
                if($items->sender_id == $user->id){
                    $html .='<div class="d-flex message mb-3 text-right justify-content-end">
                                <div class="text">
                                    <div class="message-text text-left pl-3 pr-5 pt-2 pb-2 mr-3">
                                        '.$items->message.'<br>
                                        <small>'.$items->created_at->diffForHumans().'</small>
                                    </div>
                                </div>
                            </div>';
                }else{
                    $html .='<div class="d-flex mb-3 message">
                                <div class="image">';
                                    if ($items->UserData->isNotEmpty()){
                                        foreach ($items->UserData as $img){
                                            if (!empty($img->image)){
                                                $html .='<img src="'. asset('storage/'.$img->image).'" alt="">';
                                            }else{
                                                $html .='<img src="'.asset('assets/images/avator.png').'" alt="">';
                                            }
                                        }
                                    }else{
                                        $html .='<img src="'.asset('assets/images/favicon.png').'" alt="">';
                                    }
                    $html .='</div>
                                <div class="text">
                                    <div class="message-text pl-3 pr-5 pt-2 pb-2 ml-3">';
                                    if (!empty($items->file)){
                                        $html .='<div class="img-box mb-1" data-toggle="modal" data-target="#exampleModal" target-title=" '.$items->message.'" target-link="'.asset("storage/$items->file").'">
                                            <img src="'.asset("storage/$items->file").'" alt="">
                                        </div>';
                                    }
                                   
                                    
                     $html .='      '.$items->message.'<br>
                                        <small>'.$items->created_at->diffForHumans().'</small>
                                    </div>
                                </div>
                            </div>';
                }  
            
                chat_notify::create([
                    'user_id'       => $user->id,
                    'message_id'    => $items->id,
                ]);
            }else{
                ;
            }
           
        }
        return $html;
    }
}
