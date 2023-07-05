<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    //
    public function index($id=''){
        $admins = Admin::select()->orderBy('id', 'desc')->where('id', '!=' , 1)->get();
        if(!empty($id)){
            $EditAdmin = Admin::select()->where('id', $id)->first();
        }
        return view('layout.supper-admin.admins')->with(['admins'=>$admins,'editAdmin'=>@$EditAdmin]);
    }

    public function store(Request $request)
    {
        $password = Hash::make($request->password);
        $ok = Admin::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $password,
        ]);
        if ($ok) {
            $role = Role::create(['name' => 'writer']);
            $permission = Permission::create(['name' => 'edit articles']);
            return redirect()->route('admins');
        } else {
            return redirect()->back();
        }
    }

    public function update(Request $request){
        
        $Admin = Admin::find(intval($request->id));
        if(!empty($request->password)){
            $password = Hash::make($request->password);
        }else{
            $password = $Admin->password;
        }

        try{
            $Admin->name = $request->name;
            $Admin->email = $request->email;
            $Admin->password = $password;
            $Admin->save();
            return redirect()->route('admins');
        } catch (\Throwable$th) {
            return redirect()->back();
        }
    }

    public function destroy($id){
        Admin::find($id)->delete();
        return redirect()->back();  
    }

}
