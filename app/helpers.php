<?php

use GuzzleHttp\Psr7\MimeType;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\CssSelector\Node\FunctionNode;

    function uploadFils($requestfile, $inputName = null)
    {
        if(!empty($requestfile->$inputName)){
            // $request->validate([
            //     'image' => 'required|mimes:png,jpg,webp,svg|max:4096',
            // ]);

            //get image extension
          
            $ext = "." . $requestfile->file("$inputName")->getClientOriginalExtension();

            $mainType = $requestfile->file("$inputName")->getMimeType();
            $mainTypeExplode = explode('/',$mainType);
            //Target => Year/Month (Create that name)
            $target = date('Y') . '/' . date('M');
            if (!Storage::exists($target)) {
                Storage::makeDirectory($target, 0777, true, true);
            }
            // getting file original name
            $filename_with_ext = preg_replace('/[^A-Za-z0-9\.]/', "", $requestfile->file("$inputName")->getClientOriginalName());
            
            // GET FILENAME WITHOUT EXTENSION
            $parts = explode('.', $filename_with_ext);
            $last = array_pop($parts);
            $parts = array(implode('.', $parts), $last);
            $filename_without_ext = $parts[0];
            // END FILENAME WITHOUT EXTENSION
            $rand = rand(0, 999);
            $filename = "HFM-HF-MARKETS-".$rand.$ext;
            $path = $requestfile->file("$inputName")->storeAs(
                $target, $filename
            );
            return array('type'=>$mainTypeExplode['0'], 'file'=>$path);
        }else{
            return array('file'=>'', 'type'=> '');
        }
    }

    function CountDays($endDate, $id, $startDate ='', $table='')
    {
        if(!empty($startDate)){
            $date1 = new DateTime($startDate);
        }else{
            $date1 = new DateTime(date("Y-m-d"));
        }
        $date2 = new DateTime($endDate);
        $interval = $date1->diff($date2);
        if(empty($table)){
            if($interval->format('%R%a') <= 0){
                DB::table('payments')->where('id', $id)->update(['status' => 'Expire']);
                return "0 Day Remaining Account has been expired";
            }else{
                return $interval->format('%a');
            }
        }else{
            
        }
    }
    function UserPayPlaylistAmount($id ='',$playlistId=''){

        $contents  = DB::table('contents')
        ->select('playlist_amounts.*', 'contents.id','playlists.id')
        ->join('playlists', 'contents.id', '=', 'playlists.contents_id')
        ->join('playlist_amounts', 'playlists.id','=','playlist_amounts.playlists_id')
        ->where('playlist_amounts.user_id', '=', $id)
        ->where('playlist_amounts.playlists_id', '=', $playlistId)
        ->latest()
        ->first();

        return $contents;
    
    }
    function isValidEmail($email){ 
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"; 
        if (mb_eregi($pattern, $email)){ 
            return true; 
        } 
        else { 
            return false; 
        }    
    } 

    function UserData($id= null){
        return $Users  = DB::table('users')->where('id', $id)->first();
       
         
    }
    