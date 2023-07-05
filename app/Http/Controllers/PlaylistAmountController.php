<?php

namespace App\Http\Controllers;

use App\Models\playlist_amount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistAmountController extends Controller
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
        $img = uploadFils($request, 'image');
        $user = Auth::user()->id;
        
        $ok = playlist_amount::create([
            'user_id'       => $user,
            'status'        => 'Processing',
            'playlists_id'  => $request->id,
            'screenshot'    => $img['file'],
            
        ]);

        if ($ok) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\playlist_amount  $playlist_amount
     * @return \Illuminate\Http\Response
     */
    public function show(playlist_amount $playlist_amount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\playlist_amount  $playlist_amount
     * @return \Illuminate\Http\Response
     */
    public function edit(playlist_amount $playlist_amount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\playlist_amount  $playlist_amount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, playlist_amount $playlist_amount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\playlist_amount  $playlist_amount
     * @return \Illuminate\Http\Response
     */
    public function destroy(playlist_amount $playlist_amount)
    {
        //
    }
}
