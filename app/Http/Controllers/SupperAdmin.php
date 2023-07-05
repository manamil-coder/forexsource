<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\chat;
use App\Models\Content;
use App\Models\Loginpage;
use App\Models\Payment;
use App\Models\Playlist;
use App\Models\Videos;
use App\Models\playlist_amount;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupperAdmin extends Controller
{
    public function index(){
        return view('layout.supper-admin.login');
    } 
    public function dashboard(){

        // $UserPayment = Payment::with('PaddingUsers')->select()->where('status', 'Pending')->get();
        // $usersHFM = User::select()->where(['request'=> 'Pending', 'ajax_show'=>'1' ])->orderby('id', 'desc')->get();
        // $totalIncome = Playlist::sum('price');
        
        $totalUsers = User::select();
        $totalVideos = Videos::count();
        $UserPayment = Payment::select()->with('User')->where('status', 'Pending')->get();
        $playlists = playlist_amount::with('getUsers')->select()->where(['status'=>'Processing'])->orderby('id', 'desc')->get();

        // $user = user::select()->with('UserPayment')->get();
        return view('layout.supper-admin.dashboard')->with([
            'UserPayment'=> $UserPayment,
            'totalVideos'=> $totalVideos,
            'totalUsers'=> $totalUsers,
            'playlists'=> $playlists
        ]);

        // return view('layout.supper-admin.dashboard')->with(['UserPayment'=>$UserPayment, 'usersHFM'=>$usersHFM, 'playlists'=>$playlists, 'totalUsers'=>$totalUsers, 'totalVideos'=>$totalVideos, 'totalIncome'=>$totalIncome]);
    }  

    public function ajaxPendingPlayListData(){
        $playlists = playlist_amount::with('getUsers')->select()->where(['status'=>'Processing', 'ajax_show'=>'0'])->orderby('id', 'desc')->get();
        foreach ($playlists as $data){
            echo'
                <tr>
                    <td width="15%" class="border-dark">
                        <div class="d-flex users align-items-center">
                            <div class="img bg-dark-1">';
                                if (!empty($data->getUsers->image)){
                                    echo'<img src="'. asset('storage/'.$data->getUsers->image).'" alt="">';
                                }else{
                                    echo'<img src="'. asset('assets/images/avator.png').'" alt="">';
                                }
                                echo'
                            </div>
                            <div class="ml-2">'.$data->getUsers->name.'</div>
                        </div>
                    </td>
                    <td class="text-center border-dark">
                        <button type="button" class="btn playlist-request bg-dark-1 text-white py-1 px-3 btn-sm" data-toggle="modal" data-target="#PlaylistModel" target-id="'.$data->id.'" target-title="'.$data->getUsers->name.'" target-link="'. asset('storage/'.$data->screenshot).'">View Screenshot</button>
                    </td>
                </tr>    
            ';
                
            $chatReadMSG = playlist_amount::select()->where('id', $data->id)->find(intval($data->id));
            $chatReadMSG->ajax_show  = '1';
            $chatReadMSG->save();
        }
    }
    public function ajaxHFMUserData(){

        $usersHFM = User::select()->where(['request'=> 'Pending', 'ajax_show'=>'0' ])->orderby('id', 'desc')->get();
         
        if($usersHFM->isNotEmpty()){
            foreach ($usersHFM as $sr => $items){
                if($sr%2){
                    $bgColor = 'bg-dark-2';
                }else{
                    $bgColor = 'bg-dark-3';
                }
                echo'
                <tr class="'.$bgColor.'">
                    <td width="15%" class="font-weight-bold border-dark">
                        <div class="d-flex users align-items-center">
                            <div class="img bg-dark-1">';
                                if(!empty($items->image)){
                                    echo'<img src="'. asset('storage/'.$items->image).'" alt="">';
                                }else{
                                    echo'<img src="'. asset('assets/images/avator.png').'" alt="">';
                                }
                                echo'
                            </div>
                            <div class="ml-2">'.$items->name.'</div>
                        </div>
                    </td>
                    <td class="text-center font-weight-bold border-dark">'.$items->phone.'</td>
                    <td class="text-center font-weight-bold border-dark">'.$items->address.'</td>
                    <td class="text-center font-weight-bold border-dark">Free</td>
                    <td class="text-center border-dark text-center">
                        <button type="button" class="btn show-screenshot bg-dark-1 text-white py-2 px-3 btn-sm  fa fa-info" data-toggle="modal" data-target="#exampleModal" target-type="HFM" target-id="'.$items->id.'" target-title="'.$items->name.'" target-link=""></button>
                        <a href="'.route('edit-user',['id'=>$items->id]).'" class="btn bg-dark-1 text-white py-2 fa fa-pencil"></a>
                    </td>
                </tr>';
                
                $chatReadMSG = User::select()->where('id', $items->id)->find(intval($items->id));
                $chatReadMSG->ajax_show  = '1';
                $chatReadMSG->save();
            }
        }
    }

    public function content(){

        $contents = Content::select()->orderby('id', 'desc')->get();
        
        return view('layout.supper-admin.videos-content')->with(['contents'=>$contents]);
    }

    public function store(Request $request)
    {
        $ok = Content::create([
            'title' => $request->title,
        ]);

        if ($ok) {
            return redirect()->route('videos-content')->with('success', 'insert data successfully.');
        } else {
            return redirect()->back();
        }
    }

    public function contentUpdate(Request $request){
        $content = content::find(intval($request->id));
        try{
            $content->title = $request->title;
            $content->save();
            return redirect()->route('videos-content')->with('success', 'Save changes successfully.');
        } catch (\Throwable$th) {
            return redirect()->back();
        }
        dd($content);
    }

    public function destroy($id = ''){
        $Content = Content::find($id);
        $Content->delete();
        return redirect()->route('videos-content')->with('success', 'deleted successfully.');  
    }

    public function playlist(){
        $contents = Content::select()->orderby('id', 'desc')->get();
        $playlists = Playlist::with('contentData')->select()->orderby('id', 'desc')->get();
        
        return view('layout.supper-admin.create-playlist')->with(['playlists'=>$playlists, 'contents'=>$contents]);
    }

    public function ajaxPlaylistNote(Request $request){
        $Playlist = Playlist::find(intval($request->id));
        try{
            $Playlist->note = $request->note;
            $Playlist->save();
            return redirect()->route('create-playlist');
        } catch (\Throwable$th) {
            return redirect()->back();
        }
    }
    
    public function CreatePlaylist(Request $request){
        $img = uploadFils($request, 'file');
        $ok = Playlist::create([
            'title'         => $request->title,
            'file'          => $img['file'],
            'contents_id'   => $request->contents_id,
        ]);
        if ($ok) {
            return redirect()->route('create-playlist')->with('success', 'insert data successfully.');
        } else {
            return redirect()->back();
        }
    }
    
    public function lockedPlaylist(Request $request){
        $Payment = Playlist::find(intval($request->id));
        try{
            $Payment->price = $request->price;
            $Payment->status = 'Paid';
            $Payment->save();
            return redirect()->back();
        } catch (\Throwable$th) {
            return redirect()->back();
        }
    }
    public function updatePlaylist(Request $request)  {
        $Playlist = Playlist::find(intval($request->id));
        if($request->file){
            $img = uploadFils($request, 'file');
            $image = $img['file'];
        }else{
            $image =    $Playlist->file;
        }
        try{
            $Playlist->title = $request->title;
            $Playlist->contents_id = $request->contents_id;
            $Playlist->file = $image;
            $Playlist->save();
            return redirect()->route('create-playlist')->with('success', 'save changes successfully.');
        } catch (\Throwable$th) {
            return redirect()->back();
        }
    }

    public function playlistdestroy($id = ''){
        $Playlist = Playlist::find($id);
        $Playlist->delete();
        return redirect()->back();  
    }
    
    public function chat(){
        // $chat ='';
        // $Get_id = @$_GET['id'];
        // $users = User::select()->orderBy('id', 'desc')->get();
        // if(!empty($Get_id)){
        //     $EditUser = User::select()->where('id', $Get_id)->first();
        // }
        $chat = chat::with('UserData')->select()->where('read_msg', '1')->get();

        return view('layout.supper-admin.chat')->with(['chat'=>@$chat]);
    }

    public function loginpage()
    {
        $data = Loginpage::select()->first();
        return view('layout.supper-admin.login-page')->with('data',$data);
    }
    public function LoginTextUpdate(Request $request)
    {

        $data = Loginpage::find(intval(1));


        try{
            $data->title = $request->title;
            $data->description = $request->description;
            $data->save();
            return redirect()->back();
        } catch (\Throwable$th) {
            return redirect()->back();
        }

  
    }
}