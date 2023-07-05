<?php

namespace App\Http\Middleware;

use App\Models\Payment;
use Closure;
use Illuminate\Http\Request;

class CheckUserPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $PaymentStatus = Payment::select('status','end_date','id')->where('user_id', $user->id)->where('status', 'Accepted')->orderBy('id', 'desc')->first();
        
        if(@$PaymentStatus->status == 'Accepted'){
            if (!empty($PaymentStatus->end_date)){
                CountDays($PaymentStatus->end_date, $PaymentStatus->id);
                return $next($request);
            }else{
                return redirect()->route('home');
            }
        }else{
            return redirect()->route('home');
        }
        
    }
}
