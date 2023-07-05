@extends('main')
@section('MetaTitle')
<title>Dashboard | Finacial Source</title>
@endsection

@section('styles')
<style>
.tabs-active.active{
    background-color: #007BFF !important;
}
.tabs-active{
    background-color: #292929 !important;
}

.vidoes-box{
    position: relative;
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
    border-radius: 10px;
    overflow: hidden;
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
.logo{
    width: 40px;
    height: 40px;
    border-radius: 100%;
}
.logo img{
    width: 100%;
    height: 36px;
    object-fit: cover;
}
</style>
@endsection
@section('content')
<div class="tabs-sectionbg my-3">
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="rounded bg-dark-2">
                    <button type="button" class="tabs-active px-4 btn-sm btn text-white active border-0" data-target="live-analysis"><i class="fa fa-window-maximize pr-2"></i> Videos</button>
                    <button type="button" class="tabs-active px-4 btn-sm btn text-white border-0" data-target="news"><i class="fa fa-file-o pr-2"></i> News</button>
                    <button type="button" class="tabs-active px-4 btn-sm btn text-white border-0" data-target="Fundamental-data"><i class="fa fa-usd pr-2"></i> Fundamental Data</button>
                    <button type="button" class="tabs-active px-4 btn-sm btn text-white border-0" data-target="Sheet"><i class="fa fa-file pr-2"></i> Sheet</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="bg-dark-2 mt-3 overflow-hidden rounded border-raduis-10 tab-content" id="live-analysis">
                    <div class="p-3 bg-light-3">
                        <p class="heading-fonts text-center text-uppercase mb-0 text-white">Live Analysis</p>
                    </div>
                    <div>
                        <div class="pt-3 pb-3 px-3">
                            <div class="container">
                                <div class="row ">
                                    <div class="col-md-8 mb-3 ">
                                        <h4 id="title" class="text-white">Title</h1>
                                        <div class="vidoes-box">
                                            <div class="loading"></div>
                                            <img src="{{asset('assets/images/mirror-black.png')}}" height="545px" class="w-100">
                                            <iframe id="video" style='position: absolute;  width: 100%; height: 100%; left: 0; top: 0;' src='{{ !empty($SingleVideo->killerplayer) ? $SingleVideo->killerplayer : '' }}' width='745' height='419' frameborder='0' scrolling='no' allowfullscreen></iframe>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-white">Playlist</h5>
                                        <div class="playlist">
                                            <div class="paylist-show"></div>
                                            @if($videos->isNotEmpty())
                                                @foreach ($videos as $items)
                                                    <div class="d-flex mb-3 playlist-videos align-items-center px-3 py-3 bg-dark-1" target-title="{{$items->Videos->title}}" target-link="{{$items->Videos->killerplayer}}">
                                                        <div class="img">
                                                            <img src="https://i.ytimg.com/vi/{{$items->Videos->youtube}}/mqdefault.jpg"  height="200" width="100%">
                                                        </div>
                                                        <div class="text ml-3">
                                                            <h6 class="line-2 text-white">{{$items->Videos->title}}</h6>
                                                            <p class="text-white mb-0 small datetime" data-dataTime="{{$items->Videos->created_at}}">{{$items->Videos->created_at}}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-dark-2 mt-3 overflow-hidden rounded border-raduis-10 d-none tab-content" id="news">
                    <div class="p-3 bg-light-3">
                        <p class="heading-fonts text-center text-uppercase mb-0 text-white">Breaking News</p>
                    </div>
                    <div>
                        <div class="pt-3 pb-3 px-3" id="accordion">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter text-primary" target-data="all">All News</a>
                                        <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter" target-data="Must-Read">Must Read</a>
                                        <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter" target-data="Research-Analysis">Research & Analysis</a>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <span class="text-uppersace font-weight-bold small ml-3 text-white">{{date('M')}}</span>
                                </div>
                                <div class="col-md-12 newsdata"></div>
                                <div class="col-md-12">
                                    @if ($blogs->isNotEmpty())
                                        @foreach ($blogs as $item)
                                            <div class="data" id="{{$item->BlogNews->status}}">
                                                @if ($item->BlogNews->collapse == 'collapse')
                                                    <div class="text-white bg-dark-3 p-0 border-top-0 d-flex rounded py-3 px-3 border-bottom border-white" data-toggle="collapse" data-target="#collapseOne{{ $item->BlogNews->id}}" aria-expanded="true" aria-controls="collapseOne">
                                                        <div class="logo mr-3"><img src="{{asset('assets/images/forex.jpg')}}" alt=""></div>
                                                        <div class="text w-100">
                                                            <h6 class="mb-0">
                                                                {{$item->BlogNews->webname}} - {{ $item->BlogNews->title}}
                                                                @if ($item->BlogNews->link)
                                                                    <a href="{{$item->BlogNews->link}}" target="_blank" class="text-warning pl-2 fa fa-external-link"></a>    
                                                                @endif
                                                            </h6>
                                                            <p class="mb-0 small datetime" data-dataTime="{{$item->BlogNews->created_at}}"></p>
                                                        </div>
                                                    </div>
                                                    <div class="collapse" id="collapseOne{{ $item->BlogNews->id}}" aria-labelledby="headingOne" data-parent="#accordion">
                                                        <div class="py-3 px-3 text-white">
                                                            {!! $item->BlogNews->description !!}
                                                            @if ($item->BlogNews->type != 'image')
                                                                <a href="{{asset('storage/'.$item->BlogNews->file)}}" download="donwload" class="text-warning">
                                                                    @if(!empty($item->BlogNews->file_name)) {{$item->BlogNews->file_name}} @else {{$item->BlogNews->file}}  @endif
                                                                    <i class="fa fa-download ml-3"></i>
                                                                </a>  
                                                            @else
                                                                <img src="{{asset('storage/'.$item->BlogNews->file)}}" width="50%" alt="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-white bg-dark-3 p-0 border-top-0 d-flex rounded py-3 px-3 border-bottom border-white">
                                                        <div class="logo">
                                                            @if ($item->BlogNews->webname == 'FXStreet')
                                                                <img src="{{asset('assets/images/FXStreet.jpg')}}" alt="">     
                                                            @else
                                                                <img src="{{asset('assets/images/forex.jpg')}}" alt="">     
                                                            @endif
                                                        </div>
                                                        <div class="ml-2">
                                                            <h6 class="mb-0">{{$item->BlogNews->title}} 
                                                                @if ($item->BlogNews->link)
                                                                    <a href="{{$item->BlogNews->link}}" target="_blank" class="text-warning pl-2 fa fa-external-link"></a>    
                                                                @endif
                                                            </h6>
                                                            <p class="mb-0 small datetime" data-dataTime="{{$item->BlogNews->created_at}}"></p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-dark-2 mt-3 overflow-hidden rounded border-raduis-10 d-none tab-content" id="Fundamental-data">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="p-3 bg-light-3">
                                <p class="heading-fonts text-center text-uppercase mb-0 text-white">USD CAD EUR NZD CHF GBP AUD JPY</p>
                            </div>
                            <div class="text-center p-3">
                                <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter2 text-primary" target-data="all">All</a>
                                <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter2" target-data="USD">USD</a>
                                <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter2" target-data="CAD">CAD</a>
                                <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter2" target-data="EUR">EUR</a>
                                <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter2" target-data="NZD">NZD</a>
                                <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter2" target-data="CHF">CHF</a>
                                <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter2" target-data="GBF">GBF</a>
                                <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter2" target-data="AUD">AUD</a>
                                <a href="#0" class="d-inline-block font-weight-bold mx-2 text-white text-uppercase small filter2" target-data="JPY">JPY</a>
                            </div>
                        </div>
                        <div class="col-md-12" id="accordion2">
                            <div class="Fdata"></div>
                            @if($FundamentalData->isNotEmpty())
                                @foreach ($FundamentalData as $item)
                                    <div class="data2" id="{{$item->fundaMentalData->fundamental}}">
                                        <div class="text-white bg-dark-3 p-0 border-top-0 rounded py-3 px-3 border-bottom border-white" data-toggle="collapse" data-target="#Fundamental{{$item->id}}" aria-expanded="true" aria-controls="collapseOne">
                                            <h6 class="mb-0">{{$item->fundaMentalData->title}}</h6>
                                            <p class="mb-0 small datetime" data-dataTime="{{$item->fundaMentalData->created_at}}"></p>
                                        </div>
                                        <div class="collapse" id="Fundamental{{$item->id}}" aria-labelledby="headingOne" data-parent="#accordion2">
                                            <div class="py-3 px-3 text-white">
                                                <iframe src="{{$item->fundaMentalData->iframe}}" height="300" width="100%" frameborder="0"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('assets/script/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/script/popper.min.js') }}"></script>
<script>
$('.tabs-active').click(function(){
    $('.tabs-active').removeClass('active');
    $(this).addClass('active');
    var targetID = $(this).attr('data-target');
    $('.tab-content').addClass('d-none');
    $('#'+targetID).removeClass('d-none');
})
$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

// Real Time Videos
setInterval(function(){
    $.ajax({
        type: "POST",
        url: '{{route('AjaxDashboard')}}',
        data: '',
        async: true,
        success: function(dataJson) {
            if(dataJson != 'false'){
                var parsedData = JSON.parse(dataJson);
                $.each(parsedData, function(index, item) {
                    var html ='<div class="d-flex mb-3 playlist-videos align-items-center px-3 py-3 bg-dark-1" target-title="'+item.title+'" target-link="'+item.killerplayer+'">';
                    html +='<div class="img">';
                    html +='<img src="https://i.ytimg.com/vi/'+item.youtube+'/mqdefault.jpg"  height="200" width="100%">';
                    html +='</div>';
                    html +='<div class="text ml-3">';
                    html +='<h6 class="line-2 text-white">'+item.title+'</h6>';
                    html +='<p class="text-white mb-0 small datetime" data-dataTime="'+item.created_at+'"></p>';
                    html +='</div>';
                    html +='</div>';
                    $('.paylist-show').prepend(html);
                });
                updateTimeDifference();
            }
        }
    });
    // breaking news 
    $.ajax({
        type: 'POST',
        url: '{{route('breakingNews')}}',
        data: '',
        async: true,
        success: function(Data){
            if(Data != 'false'){
                var parsedData = JSON.parse(Data);
                $.each(parsedData, function(index, item) {
                    var html  = '<div class="data" id="'+item.status+'">'
                    if(item.collapse == 'collapse'){
                        html += '<div class="text-white bg-dark-3 p-0 border-top-0 d-flex rounded py-3 px-3 border-bottom border-white" data-toggle="collapse" data-target="#collapseOne'+item.id+'" aria-expanded="true" aria-controls="collapseOne">'
                        html += '<div class="logo mr-3"><img src="{{asset('assets/images/forex.jpg')}}" alt=""></div>'
                        html += '<div class="text w-100">'
                        html += '<h6 class="mb-0"> '+item.title+''
                        if(item.link != ''){
                            html += '<a href="'+item.link+'" target="_blank" class="text-warning pl-2 fa fa-external-link"></a>'
                        }
                        html += '</h6>'
                        html += '<p class="mb-0 small datetime" data-dataTime="'+item.created_at+'"></p>'
                        html += '</div>'
                        html += '</div>'
                        html += '<div class="collapse" id="collapseOne'+item.id+'" aria-labelledby="headingOne" data-parent="#accordion">'
                        html += '<div class="py-3 px-3 text-white">'+item.description+''
                        if(item.type != 'image'){
                            var fileURL = "{{ asset('storage') }}/" + item.file;
                            html += '<a href="'+fileURL+'" download="donwload" class="text-warning">' + item.file_name + '<i class="fa fa-download ml-3"></i></a>';
                        }else{
                            var fileURL = '{{ asset("storage") }}/' + item.file;
                            html += '<img src="'+fileURL+'" width="50%" alt="">'
                        }
                        html += '</div>'
                        html += '</div>'
                        
                    }else{
                        html += '<div class="text-white bg-dark-3 p-0 border-top-0 d-flex rounded py-3 px-3 border-bottom border-white">'
                        html += '<div class="logo">'
                        if(item.webname == 'FXStreet'){ html += '<img src="{{asset('assets/images/FXStreet.jpg')}}" alt="FXStreet">' }
                        else{ html += '<img src="{{asset('assets/images/forex.jpg')}}" alt="">' }
                        html += '</div>'
                        html += '<div class="ml-2">'
                        html += '<h6 class="mb-0"> '+item.title+''
                        if(item.link != null){ html += '<a href="'+item.link+'" target="_blank" class="text-warning pl-2 fa fa-external-link"></a>' }
                        html += '</h6>'
                        html += '<p class="mb-0 small datetime" data-dataTime="'+item.created_at+'"></p>'
                        html += '</div>'
                        html += '</div>'
                    }
                    html += '</div>'
                    $('.newsdata').prepend(html);
                });
            }
        }
    });
    $.ajax({
        type: 'POST',
        url: '{{route('gettingFundamentalData')}}',
        data: '',
        async: true,
        success: function(Data){
            if(Data != 'false'){
                var FData = JSON.parse(Data);
                $.each(FData, function(index, item) {
                    var html = '<div class="text-white bg-dark-3 p-0 border-top-0 rounded py-3 px-3 border-bottom border-white" data-toggle="collapse" data-target="#Fundamental'+item.id+'" aria-expanded="true" aria-controls="collapseOne">'
                    html += '<h6 class="mb-0">'+item.title+'</h6>'
                    html += '<p class="mb-0 small datetime" data-dataTime="'+item.created_at+'"></p>'
                    html += '</div>'
                    html += '<div class="collapse" id="Fundamental'+item.id+'" aria-labelledby="headingOne" data-parent="#accordion">'
                    html += '<div class="py-3 px-3 text-white">'
                    html += '<iframe src="'+item.iframe+'" height="300" width="100%" frameborder="0"></iframe>'
                    html += '</div>'
                    html += '</div>'
                    $('.Fdata').prepend(html);
                });
            }
        }
    });
}, 3000);

//time ago
$(document).ready(function() {
    function updateTimeDifference() {
        $('.datetime').each(function() {
            var datetime = $(this).attr('data-dataTime');
            var dateTimeObj = new Date(datetime);
            var now = new Date();
            var diff = now - dateTimeObj;
            var seconds = Math.floor(diff / 1000);
            var minutes = Math.floor(seconds / 60);
            var hours = Math.floor(minutes / 60);
            var days = Math.floor(hours / 24);
            var timeDiff;
            if (days > 0) { timeDiff = days + ' day' + (days > 1 ? 's' : '') + ' ago'; } 
            else if (hours > 0) { timeDiff = hours + ' hour' + (hours > 1 ? 's' : '') + ' ago'; } 
            else if (minutes > 0) { timeDiff = minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago'; } 
            else { timeDiff = seconds + ' second' + (seconds > 1 ? 's' : '') + ' ago'; }
            $(this).text(timeDiff);
        });
        setTimeout(function() {
            updateTimeDifference();
        }, 2000);
    }
    updateTimeDifference();
    $('.filter').click(function(){
        $('.filter').removeClass('text-primary');
        $('.data').hide();
        var id = $(this).attr('target-data');
        $(this).addClass('text-primary');
        if(id == 'all'){
            $('.data').show();
        }else{
            $('#'+id).show();
        }
    }) 
    $('.filter2').click(function(){
        $('.filter2').removeClass('text-primary');
        $('.data2').hide();
        var id = $(this).attr('target-data');
        $(this).addClass('text-primary');
        if(id == 'all'){
            $('.data2').show();
        }else{
            $('#'+id).show();
        }
    })
    //click to play video
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

});


</script>
@endsection