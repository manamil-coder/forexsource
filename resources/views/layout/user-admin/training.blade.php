@extends('main')
@section('MetaTitle')
<title>Traning | Finacial Source</title>
@endsection
@section('styles')
<style>
.video{
    height: 250px;
    border-radius:20px;
    position: relative;
}
.video.locked{
    cursor: pointer;
}
.video.locked:before{
    position: absolute;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px; 
    content: '\f023';
    font: normal normal normal 14px/1 FontAwesome;
    z-index: 1;
    background-color: rgba(0, 0, 0, 0.6);
    font-size:32px;
    text-align: center;
    padding-top: 110px;
    color: white;
}
.video.wating:before{
    position: absolute;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px; 
    content: '\f017';
    font: normal normal normal 14px/1 FontAwesome;
    z-index: 1;
    background-color: rgba(0, 0, 0, 0.6);
    font-size:32px;
    text-align: center;
    padding-top: 110px;
    color: white;
}
.video img{
    width:100%;
    height: 250px;
    object-fit: cover
}
.content a:hover{
    background-color: #007BFF;
}
</style>
@endsection
@section('content')
@if ($contents->isNotEmpty())
<section class="indicators pt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-white mb-3 heading-fonts">Content </h5>
            </div>
            <div class="col-md-3">
                <a class="nav-link mb-3 d-flex justify-content-between btn bg-dark-2 text-white mb-3 align-items-center active" id="all-home-tab" data-toggle="pill" href="#all-home" role="tab" aria-controls="all-home" aria-selected="true"><div>All</div><div>{{$AllPlaylist}}</div></a>
                @foreach ($contents as $item)
                    <a class="nav-link mb-3 d-flex justify-content-between btn bg-dark-2 text-white mb-3 align-items-center active" id="all-home-tab" data-toggle="pill" href="#all-home" role="tab" aria-controls="all-home" aria-selected="true">
                        <div>{{$item->title}}</div>
                        <div>{{$item->PlaylistData->count()}}</div>
                    </a>   
                @endforeach
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    @foreach ($contents as $items)
                        <div class="tab-pane fade show active " id="all-home" role="tabpanel" aria-labelledby="all-home-tab">
                            <h5 class="text-white mb-3 heading-fonts">{{$items->title}}</h5>
                            <div class="row mb-3">
                                @foreach ($items->PlaylistData as  $data)
                                    @if (@$data->status == 'Free')
                                        <a href="{{route('playlist', ['id'=>$data->id])}}"class="col-md-4">
                                            <div class="video bg-dark-2 mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                            <h6 class="text-white small font-weight-bold text-uppercase">Contants 0 recorded streams</h6>
                                            <h5 class="text-white line-1">{{$data->title}}</h5>
                                        </a>  
                                    @elseif (@$data->status == 'Paid')
                                        @php
                                            @$UserPayPlaylistAmount = UserPayPlaylistAmount($userID,$data->id);
                                        @endphp
                                        @if (@$UserPayPlaylistAmount->status == 'Pending' or @$UserPayPlaylistAmount->status == 'Expire')
                                            <div class="col-md-4 show-screenshot" data-toggle="modal" data-target="#exampleModal" target-id="{{$data->id}}" target-title="{{$data->title}}" target-link="">
                                                <div class="video bg-dark-2 locked mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                                <p class="text-white line-2 mb-0"><small>Price: {{$data->price}}/Rs</small></p>
                                                <h5 class="text-white line-1">{{$data->title}}</h5>
                                            </div> 
                                        @elseif (@$UserPayPlaylistAmount->status == 'Accepted')

                                            <a href="{{route('playlist', ['id'=>$data->id])}}"class="col-md-4">
                                                <div class="video bg-dark-2 mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                                <h6 class="text-white small">
                                                    Your playlist will expire in {{CountDays($UserPayPlaylistAmount->end_date, '')}} days.
                                                </h6>
                                                <h5 class="text-white line-1">{{$data->title}}</h5>
                                            </a> 
                                        @elseif (@$UserPayPlaylistAmount->status == 'Processing')
                                            <div class="col-md-4 show-screenshot">
                                                <div class="video bg-dark-2 wating mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                                <p class="text-white line-2 mb-0"><small>Your payment has been received, and the playlist unlocked will take 3-4 working days.</small></p>
                                                <h5 class="text-white line-1">{{$data->title}}</h5>
                                            </div> 
                                        @else
                                            <div class="col-md-4 show-screenshot" data-toggle="modal" data-target="#exampleModal" target-id="{{$data->id}}" target-title="{{$data->title}}" target-link="">
                                                <div class="video bg-dark-2 locked mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                                <p class="text-white line-2 mb-0"><small>Price: {{$data->price}}/Rs</small></p>
                                                <h5 class="text-white line-1">{{$data->title}}</h5>
                                            </div>
                                        @endif
                                    @endif
                                    
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endif
{{-- 
            <div class="col-md-3 content">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @if ($contents->isNotEmpty())
                        <a class="nav-link mb-3 d-flex justify-content-between btn bg-dark-2 text-white mb-3 align-items-center active" id="all-home-tab" data-toggle="pill" href="#all-home" role="tab" aria-controls="all-home" aria-selected="true"><div>All</div><div>{{$AllPlaylist}}</div></a>
                        @foreach ($contents as $items)
                            <a class="nav-link mb-3 d-flex justify-content-between btn bg-dark-2 text-white mb-3 align-items-center" id="{{$items->id}}-home-tab" data-toggle="pill" href="#{{$items->id}}-home" role="tab" aria-controls="{{$items->id}}-home" aria-selected="true"><div>{{$items->title}}</div><div>{{count($items->PlaylistData )}}</div></a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                @if ($contents->isNotEmpty())
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active " id="all-home" role="tabpanel" aria-labelledby="all-home-tab">
                        @foreach ($contents as $items)
                            <h5 class="text-white mb-3 heading-fonts">{{$items->title}}</h5>
                            <div class="row mb-3">
                                @foreach ($items->PlaylistData as  $data)
                                    @if ($data->status == 'Paid')
                                        @php
                                            $UserPayPlaylistAmount =   UserPayPlaylistAmount($userID,$data->id);
                                        @endphp
                                        @if (@$UserPayPlaylistAmount->status == 'Pending')
                                            <div class="col-md-4 show-screenshot">
                                                <div class="video bg-dark-2 wating mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                                <p class="text-white line-2 mb-0"><small>Your payment has been received, and the playlist unlocked will take 3-4 working days.</small></p>
                                                <h5 class="text-white line-1">{{$data->title}}</h5>
                                            </div>   
                                        @else
                                            <div class="col-md-4 show-screenshot" data-toggle="modal" data-target="#exampleModal" target-id="{{$data->id}}" target-title="{{$data->title}}" target-link="">
                                                <div class="video bg-dark-2 locked mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                                <h6 class="text-white small font-weight-bold text-uppercase">Amount: {{$data->price}}</h6>
                                                <h3 class="text-white font-weight-bold">
                                                <h5 class="text-white line-1">{{@$UserPayPlaylistAmount->status}}</h5>
                                                <h5 class="text-white line-1">{{$data->title}}</h5>
                                            </div>     
                                        @endif
                                    @else
                                        <a href="{{route('playlist', ['id'=>$data->id])}}"class="col-md-4">
                                            <div class="video bg-dark-2 mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                            <h6 class="text-white small font-weight-bold text-uppercase">Contants 0 recorded streams</h6>
                                            <h5 class="text-white line-1">{{$data->title}}</h5>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    @foreach ($contents as $items)
                    <div class="tab-pane fade" id="{{$items->id}}-home" role="tabpanel" aria-labelledby="{{$items->id}}-home-tab">
                        <h5 class="text-white mb-3 heading-fonts">{{$items->title}}</h5>
                        <div class="row mb-3">
                            @foreach ($items->PlaylistData as  $data)
                                @if ($data->status == 'Paid')
                                    @php
                                        $UserPayPlaylistAmount =   UserPayPlaylistAmount($userID, $data->id);
                                    @endphp
                                    @if (@$UserPayPlaylistAmount->status == 'Pending')
                                        <div class="col-md-4 show-screenshot">
                                            <div class="video bg-dark-2 wating mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                            <p class="text-white line-2 mb-0"><small>Your payment has been received, and the playlist unlocked will take 3-4 working days.</small></p>
                                            <h5 class="text-white line-1">{{$data->title}}</h5>
                                        </div>   
                                    @else
                                        <div class="col-md-4 show-screenshot" data-toggle="modal" data-target="#exampleModal" target-id="{{$data->id}}" target-title="{{$data->title}}" target-link="">
                                            <div class="video bg-dark-2 locked mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                            <h6 class="text-white small font-weight-bold text-uppercase">Amount: {{$data->price}}</h6>
                                            <h3 class="text-white font-weight-bold">
                                            <h5 class="text-white line-1">{{@$UserPayPlaylistAmount->status}}</h5>
                                            <h5 class="text-white line-1">{{$data->title}}</h5>
                                        </div>     
                                    @endif
                                @else
                                    <a href="{{route('playlist', ['id'=>$data->id])}}"class="col-md-4">
                                        <div class="video bg-dark-2 mb-2 overflow-hidden"><img src="{{ asset('storage/'.$data->file)}}" alt=""></div>
                                        <h6 class="text-white small font-weight-bold text-uppercase">Contants 0 recorded streams</h6>
                                        
                                        <h5 class="text-white line-1">{{$data->title}}</h5>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section> --}}
<form method="post" enctype="multipart/form-data" action="{{route('unlocked')}}" class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark-2">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold text-white" id="exampleModalLabel"></h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="image">
                        <input type="hidden" class="form-control" value="" id="updateId" name="id">
                        <input type="hidden" class="form-control" id="accountType" name="type" value="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm bg-dark-1 text-white border-0 px-3 py-2 btn-sm">Save Changes</button>
                <button type="button" class="btn btn-sm bg-danger text-white border-0 px-3 py-2 btn-sm" id="close-btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</form>

@endsection
@section('scripts')
<script src="{{ asset('assets/script/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/script/popper.min.js') }}"></script>
<script>
    $('.show-screenshot').click(function(){
        $('#updateId').val($(this).attr('target-id'));
        $('#exampleModalLabel').text($(this).attr('target-title'))
    })
    $('#close-btn').click(function(){
        $('#video').attr('src', '')
    })
</script>
@endsection
