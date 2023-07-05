<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\playlist_amount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
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
        
        $ok = Payment::create([
            'user_id'       => $user,
            'status'        => 'Pending',
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {

        
        if($request->type == 'HFM'){
            $StartDate = date('Y-m-d', strtotime($request->start_date));
            $EndDate = date('Y-m-d', strtotime($request->end_date));
            
            $ok = Payment::create([
                'start_date'    => $StartDate,
                'end_date'      => $EndDate,
                'user_id'       => $request->id,
                'status'        => 'Accepted',
            ]);

            if ($ok) {

                $user = User::find($request->id);
                $user = User::where('id',$request->id)->first();
                $user->request = 'Accepted';
                $user->save();

                return redirect()->back();
            } else {
                return redirect()->back();
            }


        }else{

            $StartDate = date('Y-m-d', strtotime($request->start_date));
            $EndDate = date('Y-m-d', strtotime($request->end_date));
    
            $Payment = Payment::find(intval($request->id));
    
            try{
                $Payment->start_date = $StartDate;
                $Payment->end_date = $EndDate;
                $Payment->status = 'Accepted';
                
                $Payment->save();
                return redirect()->back();
            } catch (\Throwable$th) {
                return redirect()->back();
            }
        }

    }
    public function makepackage(Request $request){
        $StartDate = date('Y-m-d', strtotime($request->start_date));
        $EndDate = date('Y-m-d', strtotime($request->end_date));

        $Payment = playlist_amount::find(intval($request->id));
        
        try{
            $Payment->start_date = $StartDate;
            $Payment->end_date = $EndDate;
            $Payment->status = 'Accepted';
            
            $Payment->save();
            return redirect()->back();
        } catch (\Throwable$th) {
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
