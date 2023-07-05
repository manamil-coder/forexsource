@extends('main')
@section('MetaTitle')
<title>Home | Finacial Source</title>
@endsection
@section('styles')
<style>

.indicators .indicators-box .box-img,
.indicators .indicators-box{
    border-radius:10px;
}
.indicators .indicators-box .box-img{
    min-width: 100px;
    width: 100px;
    height: 100px;
    overflow: hidden;
}
.indicators .indicators-box .box-img img{
    widows: 100%;
    height: 100px;
    object-fit: cover;
    object-fit: center;
}.indicators .indicators-box .box-text{
    width: 350px;
    min-width: 350px;
}
</style>
@endsection
@section('content')
@if($user->type != 'HFM')
<section class="py-5 text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if(empty($Payment) or @$Payment->status == 'Expire')
                    <h5 class="text-white ">Subscribe to our premium membership to use this features.</h5>
                    <form action="{{route('payment')}}" method="post" enctype="multipart/form-data"> 
                        @csrf
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="image">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-dark border-0 btn-sm px-4">Upload Screenshort</button>
                            </div>
                        </div>
                    </form>
                    @if (@$Payment->status == 'Expire')
                        <p class="text-white">Your package has been expired. Please subscribe again.</p>
                    @endif
                @endif
                @if (@$Payment->status == 'Pending')
                    <p class="text-white responseData">Your payment has been received, and the activation of your account will take 24 hours.</p>
                @elseif (@$Payment->status == 'Accepted')
                    <p class="text-white responseData">Your account has been activated, your package will expire in {{CountDays($Payment->end_date, $Payment->id)}} days.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@else
@if (@$Payment->status == 'Accepted')
    <p class="text-white text-center responseData">Your account has been activated, your package will expire in {{CountDays($Payment->end_date, $Payment->id)}} days.</p>
@else
    <p class="text-white text-center responseData">Your request has been received, and the activation of your account will take 24 hours.</p>
@endif
@endif
{{-- 
<section class="indicators pt-3">
    <div class="container">
        <h5 class="text-white mb-3 heading-fonts">Indicators </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="indicators-box p-3 mb-3 bg-dark-2 d-flex align-items-center">
                    <div class="box-img">
                        <img src="{{asset('assets/images/Trade.png')}}" alt="">
                    </div>
                    <div class="box-text ml-3">
                        <h6 class="text-white heading-fonts">Real Time Video Trade Ideas</h5>
                        <p class="text-white mb-0 line-3 small">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet laboriosam, excepturi facilis architecto non, quidem cumque perferendis quam ducimus 
                        </p>
                    </div>
                    <div class="box-action ml-4 w-100 text-right">
                        <p class="text-white text-uppercase mb-4 pb-1 small">Include in your legacy <br> PLAN</p>
                        <a href="#0" class="btn btn-primary px-4 py-2 btn-sm ">Add to dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>     --}}

@endsection
@section('scripts')
{{-- <script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    setInterval(function(){
        $.ajax({
            type: "POST",
            url: '{{route('homeAjax')}}',
            data: '',
            async: true,
            success: function(text) {
                response = text;
                $('.responseData').html('Your account has been activated, your package will expire in '+response+' days.')
            }
        });
    }, 1000);
</script> --}}
@endsection
