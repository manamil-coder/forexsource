@extends('main')
@section('MetaTitle')
<title>Playlist | Finacial Source</title>
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
    border-bottom:solid 2px #2A2A2A;
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
    top: -5px;
    bottom: -45px;
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

</style>
@endsection
@section('content')
@if($videos != '')
<section class="tabs-sectionbg mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">    
                <div class="bg-dark-2 mt-3 text-white overflow-hidden border-raduis-10">
                    <div class="p-3 bg-light-3 d-flex justify-content-between align-items-center">
                        <p class="heading-fonts text-uppercase mb-0">{{$videos['0']->PlaylistData['0']->title}}</p>
                    </div>
                    <div class="px-4 py-3">
                        <div class="row justify-content-center">
                            <div class="col-md-8 mb-3 ">
                                <div class="vidoes-box mb-3">
                                    <div class="loading"></div>
                                    <img src="{{asset('assets/images/mirror-black.png')}}" height="581" class="w-100">
                                    <iframe id="video" style='position: absolute;  width: 100%; height: 100%; left: 0; top: 0;' src='{{$videos['0']->killerplayer}}' width='745' height='419' frameborder='0' scrolling='no' allowfullscreen></iframe>
                                </div>
                                <h4 id="title" class="mb-0">{{$videos['0']->title}}</h1>
                            </div>
                            <div class="col-md-4">
                                <h5>Playlist</h5>
                                <div class="playlist">
                                    <div class="videosShow"></div>
                                    @foreach ($videos as $items)
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
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@else
<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="text-white text-center">Empty</p>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
$('#btnBack').click(function () {
    window.history.back();            
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
setInterval(function(){
    $.ajax({
        type: "POST",
        url: '{{route('GettingVideos')}}',
        data: '',
        async: true,
        success: function(text) {
            response = text;
            $('.videosShow').append(response)
        }
    });
}, 5000);
function PlayVideo($this){
    $('#video').attr('src',$this.attr('target-link'))
    $('#title').text($this.attr('target-title'))
    $('.loading').addClass('show')
    setTimeout(function(){$('.loading').removeClass('show')}, 4000);
}
$('.playlist-videos').click(function(){PlayVideo($(this))});
</script>
@endsection
