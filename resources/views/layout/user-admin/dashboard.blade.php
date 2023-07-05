@extends('main')
@section('MetaTitle')
<title>Dashboard | Finacial Source</title>
@endsection
@section('styles')
<style>
.tabs-sectionbg .nav.nav-tabs{
    border-radius:10px;
}
.tabs-sectionbg .nav.nav-tabs .links{
    width: 150px;
}
.tabs-sectionbg .nav.nav-tabs .links.active{
    background-color: #373A41;
    border-radius:10px;
}
.border-raduis-10{
    border-radius:10px;
}
.news-table tr td{
    border-bottom:solid 1px #DEE2E6;
}
.undread{
    background-color: #2e2d2d;
}
.playlist{
    height: 500px;
    overflow: auto;
    padding-right: 10px
}
.playlist-videos{
    border-radius: 20px;
    cursor: pointer;
}
.playlist-videos .img{
    min-width: 80px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
}
.playlist-videos .img img{
    width: 100%;
    height: 80px;
    object-fit: cover;
    object-position: center;
}
.vidoes-box{
    position: relative;
}
.loading{
    top:-40px;
    bottom: -10px;
    left: -10px;
    right: -10px;
    z-index: 9999999;
    position: absolute;
    background-color:#1B1B1B;
    border-radius: 20px;
    background-position: center center;
    background-repeat: no-repeat;
    background-size:100px;
    display: none;
    background-image: url({{asset('assets/images/play-button01.gif')}}); 
}
.loading.show{
    display: block;
}
.logo{
    border:solid #0B0C10 2px;
    background-color:#0B0C10;
    width: 40px;
    height: 40px;
    margin-right:10px;
    border-radius:100%;
    overflow: hidden;
}
.logo img{
    width: 38px;
    height: 38px;
    object-fit: cover;
    object-position: center;
}
.chat{
    height: 500px;
    overflow: auto;
}
.chat::-webkit-scrollbar{height:7px;}
.chat::-webkit-scrollbar{width:7px;}
.chat::-webkit-scrollbar-thumb{background-color:#363636;}
.message .image{
    width: 50px;
    height: 50px;
    border-radius:100%; 
    background-color: #373A41;
    overflow: hidden;
}
.message .image img{
    width: 50px;
    height: 50px;
    object-fit: cover;
}
.message .text{
    width: 60%;
    display: inline-block;
}
.message .message-text{
    background-color: #1B1B1B;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
    border-top-right-radius: 15px;
    display: inline-block;
    font-size:14px;
    
}
.message .message-text.text-left{
    background-color: #1B1B1B;
    border-top-left-radius: 15px;
    border-top-right-radius: 0px; 
}
.bg-dark-3{
    background-color:#363636;
}
.img-box{
    position: relative;
    width: 200px;
    height:200px;
    margin-top:6px;
    cursor: pointer;
}
.img-box::before{
    content:'\f06e';
    font: normal normal normal 14px/1 FontAwesome;
    position: absolute;
    left: 0px;
    right:0px;
    top:0px;
    bottom:2px;
    background-color: rgba(0,0,0, 0.8);
    border-radius: 5px;
    display: none;
    align-items:center; 
    justify-content: center;
    font-size:30px;
    color:white;
}
.img-box:hover::before{
    display: flex;
}
.img-box img{
    width:100%;
    height: 198px;
    object-fit: cover;
    border-radius: 6px
}
</style>
@endsection
@section('content')
<section class="tabs-sectionbg my-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="nav nav-tabs border-0 bg-dark-2" id="myTab" role="tablist">
                    <a class="heading-fonts py-1 links pl-3 pr-2 small text-white active d-flex justify-content-between" id="videos-tab" data-toggle="tab" href="#videos" role="tab" aria-controls="videos" aria-selected="true"><div class=""><i class="fa fa-window-maximize pr-2"></i> Videos</div> <div class="text-light">|</div></a>
                    {{-- <a class="heading-fonts py-1 links pl-3 pr-2 small text-white d-flex justify-content-between" id="Calender-tab" data-toggle="tab" href="#Calender" role="tab" aria-controls="Calender" aria-selected="false"><div><i class="fa fa-window-maximize pr-2"></i> Calender</div><div class="text-light">|</div></a> --}}
                    <a class="heading-fonts py-1 links pl-3 pr-2 small text-white d-flex justify-content-between" id="news-tab" data-toggle="tab" href="#news" role="tab" aria-controls="news" aria-selected="false"><div><i class="fa fa-window-maximize pr-2"></i> News</div><div class="text-light">|</div></a>
                    {{-- <a class="heading-fonts py-1 links pl-3 pr-2 small text-white d-flex justify-content-between" id="meter-tab" data-toggle="tab" href="#meter" role="tab" aria-controls="meter" aria-selected="false"><div><i class="fa fa-window-maximize pr-2"></i> Meter</div><div class="text-light">|</div></a> --}}
                    {{-- <a class="heading-fonts py-1 links pl-3 pr-2 small text-white d-flex justify-content-between" id="interest-rate-tab" data-toggle="tab" href="#interest-rate" role="tab" aria-controls="interest-rate" aria-selected="false"><div><i class="fa fa-window-maximize pr-2"></i> Interest Rates</div><div class="text-light">|</div></a> --}}
                    {{-- <a class="heading-fonts py-1 links pl-3 pr-2 small text-white d-flex justify-content-between" id="chat-tab" data-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="false"><div><i class="fa fa-window-maximize pr-2"></i> Chat</div><div class="text-light">|</div></a> --}}
                    <a class="heading-fonts py-1 links pl-3 pr-2 small text-white d-flex justify-content-between" id="usd-fpd-tab" data-toggle="tab" href="#usd-fpd" role="tab" aria-controls="usd-fpd" aria-selected="false"><div><i class="fa fa-usd-fpd pr-2"></i> Fundamental Data</div><div class="text-light">|</div></a>
                    <a class="heading-fonts py-1 links pl-3 pr-2 small text-white d-flex justify-content-between" id="Sheet-tab" data-toggle="tab" href="#Sheet" role="tab" aria-controls="Sheet" aria-selected="false"><div><i class="fa fa-usd-fpd pr-2"></i> Sheet</div></a>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade text-white show active" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                        <div class="bg-dark-2 mt-3 overflow-hidden border-raduis-10">
                            <div class="p-3 bg-light-3">
                                <p class="heading-fonts text-center text-uppercase mb-0">Live Analysis</p>
                                
                            </div>
                            <div class="pt-3 pb-3 px-3">
                                {{-- <div class="mb-3">
                                    <i class="fa fa-search text-white"></i>
                                    <span class="text-light"><i class="fa fa-comment ml-3"></i> <small>Ask Question</small></span>
                                </div> --}}
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 mb-3 ">
                                            <h4 id="title"> @if ($videos->isNotEmpty()) {{@$videos['0']->Videos[0]->title}} @endif</h1>
                                            <div class="vidoes-box">
                                                <div class="loading"></div>
                                                <img src="{{asset('assets/images/mirror-black.png')}}" height="581" class="w-100">
                                                <iframe id="video" style='position: absolute;  width: 100%; height: 100%; left: 0; top: 0;' src='@if ($videos->isNotEmpty()){{@$videos['0']->Videos[0]->killerplayer}} @endif' width='745' height='419' frameborder='0' scrolling='no' allowfullscreen></iframe>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h5>Playlist</h5>
                                            <div class="playlist">
                                                <div class="videosShow"></div>
                                                @if ($videos->isNotEmpty())
                                                    @foreach ($videos as $video)
                                                        @foreach ($video->Videos as $items)
                                                            <div class="d-flex mb-3 playlist-videos align-items-center px-3 py-3 bg-dark-1" target-title="{{ $items->title }}" target-link="{{ $items->killerplayer }}">
                                                                <div class="img">
                                                                    <img src="https://i.ytimg.com/vi/{{$items->youtube}}/mqdefault.jpg"  height="200" width="100%">
                                                                </div>
                                                                <div class="text ml-3">
                                                                    <h6 class="line-2">{{$items->title}}</h6>
                                                                    <p class="text-white mb-0 small">{{$items->created_at->diffForHumans()}}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade text-white" id="Sheet" role="tabpanel" aria-labelledby="Sheet-tab">
                        <iframe width="100%" height="700" class="bg-white" src="https://lookerstudio.google.com/embed/reporting/35dd5979-7462-4d9d-beba-e4e81e1e7dee/page/p_p2z9ngep5c" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                    {{-- News --}}
                    <div class="tab-pane fade text-white mt-3" id="news" role="tabpanel" aria-labelledby="news-tab">
                        <div class="bg-dark-2 overflow-hidden border-raduis-10">
                            <div class="p-3 bg-light-3">
                                <p class="heading-fonts text-center text-uppercase mb-0">Breaking News</p>
                            </div>
                            <div class="pt-3">
                                <div class="mb-3 ml-3 d-flex align-items-center">
                                    <div style="cursor:pointer;" id="searach" class="py-2 px-2"><i class="fa fa-search text-white"></i></div>
                                    <div class="input-group border-dark d-none input" role="search">
                                        <input type="text" id="search" name="search" class="form-control bg-dark-1 border-dark" placeholder="Search now">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="#0" class="d-inline-block mx-2 clear-filter">All News</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter" id="Must-Read">Must Read</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter" id="Research-Analysis">Research & Analysis</a>
                                </div>
                                <span class="text-uppersace font-weight-bold small ml-3">{{date('M')}}</span>
                                <table class="table news-table mb-0 myTable" id="accordion">
                                    
                                    <tr><td id="Append-Data" class="p-0 border-dark border-top"></td></tr>
                                    @foreach ($blogs as $sr => $item)
                                        @foreach ($item->BlogNews as $sr => $items)
                                            @if ($sr%2)
                                                @php $bgColor = 'bg-dark-2'; @endphp
                                            @else
                                                @php $bgColor = 'bg-dark-3'; @endphp
                                            @endif
                                            <tr class="{{$items->status}} data-here">
                                                <td collspan="2" class="text-white {{$bgColor}} p-0 border-top-0">
                                                    <div class="border-bottom d-flex align-items-center border-dark py-2 px-3" data-toggle="collapse" data-target="#{{$items->id}}" style="cursor:pointer;" aria-expanded="true" aria-controls="collapseOne">
                                                        <div class="logo">
                                                            @if (!empty($items->webname))
                                                                <img src="{{asset('assets/images/'.$items->webname.'.jpg')}}" alt="">
                                                            @else
                                                                <img src="{{ asset('assets/images/avator.png')}}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="w-75">
                                                            <h6 class="mb-1">
                                                                @if (!empty($items->webname))
                                                                    {{$items->webname}} - 
                                                                @endif
                                                                {{ $items->title}}
                                                                @if (!empty($items->url) or !empty($items->link))<a href="{{ $items->url}}{{$items->link}}" target="_blank" class="text-warning pl-1 fa fa-external-link"></a>@endif    
                                                            </h6>
                                                            <p class="text-white mb-0">
                                                                @if($items->webname == 'forex')
                                                                    {{ $items->created_at->diffForHumans() }} 
                                                                @else
                                                                    @if (!empty( $items->date))
                                                                        {{ date("d-m-Y", strtotime($items->created_at)) }} 
                                                                    @else
                                                                        {{ date("d-m-Y", strtotime($items->created_at)) }} 
                                                                    @endif
                                                                @endif
                                                                @if ($items->type == 'application')
                                                                    <span class="px-2">|</span>  
                                                                    <a href="{{$items->file}}" download="donwload" class="text-warning">
                                                                        @if(!empty($items->file_name)) {{$items->file_name}} @else {{$items->file}}  @endif
                                                                        <i class="fa fa-caret-down"></i>
                                                                    </a>  
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @if (!empty($items->description) or !empty($items->file))
                                                    {{-- @if($items->type == 'image') @php $show = 'show'; @endphp @else @php $show = ''; @endphp
                                                    @endif --}
                                                        {{-- <div id="{{$items->id}}" class="collapse {{$show}} px-2" aria-labelledby="headingOne" data-parent="#accordion"> --}}
                                                        <div id="{{$items->id}}" class="collapse px-2" aria-labelledby="headingOne" data-parent="#accordion">
                                                            <div class="mb-0 py-2">
                                                                <div class="text-center"><img src="{{ asset('storage/'.$items->file) }}" width="40%" alt=""></div>
                                                                {!! $items->description !!}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>   
                                        @endforeach
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div> {{-- end video --}}
                    {{-- <div class="tab-pane fade text-white" id="meter" role="tabpanel" aria-labelledby="meter-tab">meter</div> --}}
                    {{-- <div class="tab-pane fade text-white" id="interest-rate" role="tabpanel" aria-labelledby="interest-rate-tab">interest-rate</div> --}}
                    {{-- Chat --}}
                    {{-- <div class="tab-pane fade text-white mt-3" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                        <div class="bg-dark-2 overflow-hidden border-raduis-10">
                            <div class="p-3 bg-light-3">
                                <p class="heading-fonts text-center text-uppercase mb-0">Chat</p>
                            </div>
                            <div class="pt-3 px-3 chat" id="div_id">
                                @if ($chat->isNotEmpty())
                                    @foreach ($chat as $item )
                                        @foreach ($item->chat as $items )
                                            @if ($items->sender_id == $user->id)
                                                <div class="d-flex message mb-3 text-right justify-content-end">
                                                    <div class="text">
                                                        <div class="message-text text-left pl-3 pr-5 pt-2 pb-2">
                                                            {{$items->message}}<br>
                                                            <small>{{ date("d-m-Y H:ia", strtotime($items->created_at)) }} </small> 
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex mb-3 message">
                                                    <div class="image">
                                                        @if ($items->id != '1')
                                                            @php
                                                                $userData = UserData("$items->id");
                                                            @endphp
                                                            @if (!empty($userData->image))
                                                                <img src="{{ asset('storage/'.$userData->image)}}" alt="">
                                                            @else
                                                                <img src="{{ asset('assets/images/avator.png')}}" alt="">
                                                            @endif
                                                        @else
                                                            <img src="{{asset('assets/images/favicon.png')}}" alt="">
                                                        @endif
                                                    </div>
                                                    <div class="text">
                                                        <div class="message-text px-3 py-2 ml-3">
                                                            @if (!empty($items->file))
                                                                <div class="img-box mb-1" data-toggle="modal" data-target="#exampleModal" target-title="{{$items->message}}" target-link="{{ asset('storage/'.$items->file)}}">
                                                                    <img src="{{ asset('storage/'.$items->file)}}" alt="">
                                                                </div>
                                                            @endif
                                                            {{$items->message}}<br>
                                                            <small>{{ date("d-m-Y H:ia", strtotime($items->created_at)) }} </small> 
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                        @endforeach
                                    @endforeach
                                @endif 
                                <div class="" id="loadChat"></div>
                            </div>
                            <div class="inputs d-flex rounded-0">
                                @if ($user->chat != 'Block')
                                    <div class="input-group border-top border-dark">
                                        <input type="text" class="form-control rounded-0 bg-dark-2 get-message border-0" placeholder="Type your message...">
                                        <div class="input-group-append">
                                            <input type="submit" name="message" value="Send Message" class="btn bg-dark-1 send-message text-white px-5">
                                        </div>
                                    </div> 
                                @else
                                    <div class="input-group border-top border-dark">
                                        <div class="w-100 py-2">
                                            <p class="text-center mb-0">You are blocked due to violation.</p>
                                        </div>
                                    </div> 
                                @endif
                            </div>
                        </div>
                    </div> --}}
                    <div class="tab-pane fade text-white mt-3" id="usd-fpd" role="tabpanel" aria-labelledby="usd-fpd-tab">
                        <div class="bg-dark-2 overflow-hidden border-raduis-10">
                            <div class="p-3 bg-light-3">
                                <p class="heading-fonts text-center text-uppercase mb-0">USD CAD EUR NZD CHF GBP AUD JPY</p>
                            </div>
                            <div class="pt-3 px-3">
                                <div class="text-center pb-3">
                                    <a href="#0" class="d-inline-block mx-2 clear-filter1">All</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter1" id="USD">USD</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter1" id="CAD">CAD</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter1" id="EUR">EUR</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter1" id="NZD">NZD</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter1" id="CHF">CHF</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter1" id="GBP">GBP</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter1" id="AUD">AUD</a>
                                    <a href="#0" class="d-inline-block mx-2 text-white filter1" id="JPY">JPY</a>
                                </div>
                                <table class="table news-table1 mb-0 fundamentalData" id="accordion1">
                                    @foreach ($gpd as $gpds)
                                        @foreach ($gpds->fundaMentalData as $gpdITEMS)
                                            <tr class="{{$gpdITEMS->fundamental}} data-here1">
                                                <td class="">
                                                    <div class="" data-toggle="collapse" data-target="#collapseOne{{$gpdITEMS->id}}" aria-expanded="true" aria-controls="collapseOne">{{$gpdITEMS->title}}</div>
                                                    <div class="collapse px-3 text-center"  id="collapseOne{{$gpdITEMS->id}}" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        <iframe src='{{$gpdITEMS->iframe}}' height='280' width='100%' class="iframe" frameborder='0' scrolling='no'></iframe>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark-2">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold text-white" id="exampleModalLabel">Shakir</h6>
            </div>
            <div class="modal-body">
                <div><img src=""id="videosfgsdfg" width="100%" alt="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm bg-dark-1 border-0 px-3 py-2 btn-sm" id="close-btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('assets/script/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/script/popper.min.js') }}"></script>
<script>


$("#div_id").scrollTop(1000);
$('.img-box').click(function(){
    $('#videosfgsdfg').attr('src', $(this).attr('target-link')); 
    $('#exampleModalLabel').text($(this).attr('target-title'));
});
$('#close-btn').click(function(){
    $('#video').attr('src', '');
});



$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

setInterval(function(){
    $.ajax({
        type: "POST",
        url: '{{route('GettingVideos')}}',
        data: '',
        async: true,
        success: function(text) {
            response = text;
            $('.videosShow').prepend(response)
        }
    });
}, 1000);

setInterval(function(){
    $.ajax({
        type: "POST",
        url: '{{route('gettingFundamentalData')}}',
        data: '',
        async: true,
        success: function(text) {
            response = text;
            $('.fundamentalData').prepend(response)
        }
    });
}, 1000);

function PlayVideo($this){
    $('#video').attr('src',$this.attr('target-link'))
    $('#title').text($this.attr('target-title'))
    $('.loading').addClass('show');
    setTimeout(function() { 
        $('.loading').removeClass('show');
    }, 4000);
}

$('.playlist-videos').click(function(){
    PlayVideo($(this));
});

$('.filter').click(function(){
    var value = $(this).attr('id');
    $("#accordion").find(".data-here").css("display","none");
    $("."+value).css("display","");
})

$('.clear-filter').click(function(){
    $("#accordion").find(".data-here").css("display","");
});


$('.filter1').click(function(){
    var value = $(this).attr('id');
    $("#accordion1").find(".data-here1").css("display","none");
    $("."+value).css("display","");
})
$('.clear-filter1').click(function(){
    $("#accordion1").find(".data-here1").css("display","");
});


$('#searach').click(function(){
    $('.input').toggleClass('d-none');
})

$('.get-message').keydown(function (e) {
    if (e.keyCode == 13) {
        $('.send-message').click()
    }
});
// $('.send-message').click(function(){
//     var message         = $('.get-message').val();
//     var user_id         = "{{$user->id}}"
//     var sender_id       = "{{$user->id}}";
//     var receiver_id     = "1";
//     $('.get-message').val('');
//     $('#texth').prop("disabled", true);
//     $.ajax({
//         type: "POST",
//         url: '{{ route("chat-ajax") }}',
//         data: 'message='+message+'&user_id='+user_id+'&sender_id='+sender_id+'&receiver_id='+receiver_id+'',
//         async: true,
//         success: function(text) {
//             response = text;
//             $('#texth').prop("disabled", false);
//             if(response != ''){
//                 var html = '<div class="d-flex message mb-3 text-right justify-content-end"><div class="message-text text-left pl-3 pr-5 pt-2 pb-2 mr-3">'+response+'<br><small>{{date("d-m-Y H:i")}}</small></div></div></div>';
//                 $('#loadChat').append(html);
//             }
//             var objDiv = document.getElementById('div_id');
//             objDiv.scrollTop = objDiv.scrollHeight
//         }
//     });
    
// })


// setInterval(function(){
//     chatload();
// }, 1000); 

// function chatload(status){
//     $.ajax({
//         type: "POST",
//         url: "{{route('user-ajax-chat')}}",
//         data: '',
//         async: true,
//         success: function(text) {
//             response = text;
//             $('#loadChat').append(response)
//             if(response != ''){
//                 var objDiv = document.getElementById('div_id');
//                 objDiv.scrollTop = objDiv.scrollHeight;
//             }
//         }
//     });
// }
setInterval(function(){
    $.ajax({
        type: "POST",
        url: '{{route('GettingPostUSERS')}}',
        data: '',
        async: true,
        success: function(text) {
            response = text;
            $('#Append-Data').prepend(response)
            
            // if(response != ''){
            //     var objDiv = document.getElementById('div_id');
            //     objDiv.scrollTop = objDiv.scrollHeight;
            // }
        }
    });
}, 3000);



// $('.get-message').keyup(function(e){
//   if(e.which==13){

//     event.preventDefault();
//       return false;
//     $('.send-message').click();
//   }
// });
$(document).ready(function() {
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

</script>
@endsection