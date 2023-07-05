<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\chat_notify;
use App\Models\User;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message        = $request->message;
        $user_id        = $request->user_id;
        $sender_id      = $request->sender_id;
        $receiver_id    = $request->receiver_id;
        

        $curl = curl_init($message);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        $result = curl_exec($curl);
        if ($result !== false){
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($status_code != 404){
                echo "Not Allow";
            }
        }else{
            if (!preg_match('/^[0-9]*$/', $message)) {
                $ok = chat::create([
                    'user_id'       => $user_id,
                    'message'       => $message,
                    'sender_id'     => $sender_id,
                    'receiver_id'   => $receiver_id
                ]);
            }else{
                echo "Not Allow";
            } 
        }
    }
    public function storeAdmin(Request $request)
    {
        $message        = $request->message;
        $user_id        = $request->user_id;
        $sender_id      = $request->sender_id;
        $receiver_id    = $request->receiver_id;
        $image            = $request->img;
        if(!empty($image)){
            
            // preg_match("/data:image\/(.*?);/",$image,$image_extension);

            preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
            $image = str_replace(' ', '+', $image);
            $imageName = 'image_' . time() . '.' . $image_extension[1];

            Storage::disk('public')->put('chat/'.$imageName,base64_decode($image));

            $img = 'chat/'.$imageName;
            // $read_msg = '1';
        }else{
            $img = null;
            // $read_msg = '0';
        }
        
        $ok = chat::create([
            'user_id'       => $user_id,
            'message'       => $message,
            'sender_id'     => $sender_id,
            'receiver_id'   => $receiver_id,
            'file'          => $img
            // 'read_msg'      => $read_msg
            
        ]);
        
        // if($ok){
        //     $LastID = chat::select('id')->orderBy('id', 'desc')->take(1)->first()->id;
        //     chat_notify::create([
        //         'user_id'       => $user_id,
        //         'message_id'    => $LastID,
        //         // 'read_msg'      => $read_msg
                
        //     ]);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = '')
    {
        $chat = chat::find($id);
        $chat->delete();
        return redirect()->back(); 

    }

    public function blockUser($id = ''){
        $User = User::find(intval($id));

        try{
            $User->chat = 'Block';
            $User->save();
            return redirect()->back();
        }catch (\Throwable$th){
            return redirect()->back();
        }

        // if(!empty($request->password)){
        //     $password = Hash::make($request->password);
        // }else{
        //     $password = $User->password;
        // }
        // if(!empty($request->image)){
        //     $image = uploadFils($request, 'image')['file'];
        // }else{
        //     $image = $User->image;
        // }

        // try{
        //     $User->name = $request->name;
        //     $User->email = $request->email;
        //     $User->phone = $request->phone;
        //     $User->password = $password;
        //     $User->image = $image;
        //     $User->save();
        //     return redirect()->route('users');
        // } catch (\Throwable$th) {
        //     return redirect()->back();
        // }
    }
    public function ajaxChat(){

        $chat = chat::with('UserData')->select()->where('read_msg', 0)->get();
        $html ='';
        
        foreach($chat as $items){
            if ($items->sender_id != '1'){

                $html .='
                    <div class="d-flex mb-3 message">
                        <div class="image">';
                        if($items->UserData->isNotEmpty()){
                            foreach ($items->UserData as $img){
                                if (!empty($img->image)){
                                    $html .='<img src="'.asset('storage/'.$img->image).'" alt="">';
                                }else{
                                    $html .='<img src="'.asset('assets/images/avator.png').'" alt="">';
                                }
                            }
                        }
                $html .='</div>
                        <div class="text">
                            <div class="message-text pl-3 pr-5 pt-2 pb-2 ml-3 position-relative">
                                <div class="dropdown position-absolute" style="right:10px; bottom:4px;">
                                    <button class="btn p-0 bg-transparent text-white"  type="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i></button>
                                    <div class="dropdown-menu p-0 bg-dark-1">
                                        <a href="'.route('message-trash', ['id'=> $items->id]).'" class="btn btn-danger btn-sm rounded-0 btn-block">Deleted Message</a>
                                        <a href="'.route('block-user', ['id'=> $items->user_id]).'" class="btn btn-warning btn-sm rounded-0 btn-block">Block User</a>
                                    </div>
                                </div>
                                '.$items->message.'<br>
                                <small>'.$items->created_at->diffForHumans().'</small>
                            </div>
                        </div>
                    </div>
                ';
            }else{
                $html .= '<div class="d-flex message mb-3 justify-content-end">
                            <div class="text text-right">
                                <div class="message-text text-left px-3 pt-2 pb-2 mr-3">';
                                if (!empty($items->file)){
                                    $html .= '<div class="img-box mb-1" data-toggle="modal" data-target="#exampleModal" target-title="{{$items->message}}" target-link="'.asset('storage/'.$items->file).'">
                                                <img src="'.asset('storage/'.$items->file).'" alt="">
                                            </div>';
                                }
                $html .= '
                                    '.$items->message.'
                                    <div class="text-right">
                                        <small>'.$items->created_at->diffForHumans().'</small>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
            $chatReadMSG = Chat::select()->where('id', $items->id)->find(intval($items->id));
            $chatReadMSG->read_msg  = '1';
            $chatReadMSG->save();
        }

        

        return $html;
    }
}
