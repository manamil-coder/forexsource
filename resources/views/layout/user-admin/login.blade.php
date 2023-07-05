@extends('main')
@section('MetaTitle')
    <title>Finacial Source</title>
@endsection
@section('styles')

@endsection

@section('content')
<section class="login-page h-100 position-relative">
    <div class="container h-100">
        <div class="row align-items-center justify-content-between h-100">
            <div class="col-md-5 text-center">
                <img src="{{asset('assets/images/logo-here.png')}}" class="mb-4" width="300" alt="">
                <h4 class="text-white mb-4"> {{@$data->title}} </h4>
                <p class="text-white"> {{@$data->description}} </p>
            </div>
            <div class="col-md-6 login-form">
                <div class="mb-5">
                    <button class="bg-transparent text-white btn p-0 rounded-0 tabs-btn text-white btn-lg border-0 active" target-data="login">Sign in</button>
                    <button class="bg-transparent text-white btn p-0 rounded-0 tabs-btn text-white btn-lg border-0 ml-3" target-data="signup">Sign Up</button>
                </div>
                <div class="tabs">
                    <form action="{{route('Userlogin')}}" autocomplete="off" method="post" id="login" class="">
                        @csrf
                        <div class="input-group mb-4 py-2">
                            <div class="input-group-prepend pl-3 pr-0">
                                <span class="input-group-text border-0 bg-transparent text-white" ><i class="fa fa-user-o"></i></span>
                            </div>
                            <input type="text" name="email" class="form-control text-white border-0 bg-transparent" placeholder="Type Your Email">
                        </div>
                        <div class="input-group mb-1 py-2">
                            <div class="input-group-prepend pl-3 pr-0">
                                <span class="input-group-text border-0 bg-transparent text-white" ><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control text-white border-0 bg-transparent" placeholder="Type Your Password">
                        </div>
                        <div class="row align-items-center mt-5">
                            <div class="col-6">
                                {{-- <a href="#0" class="text-white">Forgot Password?</a> --}}
                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" class="btn btn-submit border-0 text-white px-5 py-2">Sign in</button>
                            </div>
                        </div>
                    </form>
                    <form action="{{route('signup')}}" method="post" id="signup" class="d-none" autocomplete="off">
                        @csrf
                        <div class="input-group mb-4 py-2">
                            <div class="input-group-prepend pl-3 pr-0">
                                <span class="input-group-text border-0 bg-transparent text-white" ><i class="fa fa-user-o"></i></span>
                            </div>
                            <input type="text" name="name" required class="form-control text-white border-0 bg-transparent" placeholder="Type Your Name">
                        </div>
                        <div class="input-group mb-4 py-2">
                            <div class="input-group-prepend pl-3 pr-0">
                                <span class="input-group-text border-0 bg-transparent text-white" ><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="text" name="email" required class="form-control text-white border-0 bg-transparent" placeholder="Type Your Email">
                        </div>
                        <div class="input-group mb-4 py-2">
                            <div class="input-group-prepend pl-3 pr-0">
                                <span class="input-group-text border-0 bg-transparent text-white" ><i class="fa fa-phone"></i></span>
                            </div>
                            <input type="text" name="phone" required class="form-control text-white border-0 bg-transparent" placeholder="Type Your Phone Number">
                        </div>
                        {{-- <div class="input-group mb-4 py-2 hfrm">
                            <div class="input-group-prepend pl-3 pr-0">
                                <span class="input-group-text border-0 bg-transparent text-white" ><i class="fa fa-cloud"></i></span>
                            </div>
                            <input type="text" name="hfm" class="form-control text-white border-0 bg-transparent" placeholder="Type Your HFM Wallet Number">
                        </div> --}}
                        <div class="input-group mb-4 py-2">
                            <div class="input-group-prepend pl-3 pr-0">
                                <span class="input-group-text border-0 bg-transparent text-white" ><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="password" required class="form-control text-white border-0 bg-transparent" placeholder="Create Password">
                        </div>
                        <div class="row align-items-center">
                            {{-- <input type="hidden" name="type" value="HFM"> --}}
                            {{-- <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" required name="type" id="inlineRadio1" value="HFM">
                                    <label class="form-check-label text-white ml-2" for="inlineRadio1">HFM (Free)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" required name="type" id="inlineRadio2" value="Paid">
                                    <label class="form-check-label text-white ml-2" for="inlineRadio2">Paid</label>
                                </div>
                            </div> --}}
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-submit border-0 text-white px-5 py-2">Sign up</button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    $('.btn-lg').click(function(){
        var TabId = $(this).attr('target-data');
        if ($('.btn-lg').hasClass("active")){
            $('.btn-lg').removeClass('active');
        }
        if ($('.tabs form').hasClass("d-none")) {
            $('.tabs form').addClass("d-none"); 
        }
        $('#'+TabId).removeClass('d-none');
        $(this).addClass('active');  
    })
    $('.form-check-input').change(function(){
        if($(this).val() == 'HFM'){
            $('.hfrm').removeClass('d-none')
        }else{
            $('.hfrm').addClass('d-none')
        }
    })
</script>
@endsection
