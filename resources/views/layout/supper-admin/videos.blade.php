@extends('admin')
@section('MetaTitle')
    <title>Videos | Finacial Source</title>
@endsection
@section('styles')
    <style>
        .videos img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .videos .fa-play {
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            font-size: 32px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 9px;
        }
        .videos .fa-play:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
@endsection
@section('content')
    <div class="row pt-3">
        <div class="col-6 mb-3">
            <h5 class="font-weight-bold">Videos</h5>
        </div>
        <div class="col-6 mb-3 text-right">
            <button type="button" class="btn pb-1 bg-dark-2 text-white"data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-plus"></i></button>
        </div>
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
            @endif
        </div>
        <form class="col-md-12 collapse mb-3 {{ optional($editVideo)->title ? 'show' : ''  }}" method="post" enctype="multipart/form-data" action="{{ optional($editVideo)->title ? route('update-videos') : route('add-videos')   }} "id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
            @csrf
            <div class="bg-dark-2 border-radius-10 card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold mb-1">Video Title</label>
                        <select name="playlists_id" class="form-control">
                            @if ($playlists->isNotEmpty())
                                <option value="">-- Select Anyone --</option>
                                @foreach ($playlists as $items)
                                    <option value="{{$items->id}}" {{ optional($editVideo)->playlists_id == $items->id ? 'selected' : ''  }}>{{$items->title}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold mb-1">Video Title</label>
                        <input type="text" class="form-control" name="title" value="{{ optional($editVideo)->title ? optional($editVideo)->title : '' }}" placeholder="Type Video Title">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold mb-1">Killer Player Url</label>
                        <textarea name="killerPlayer" class="form-control" rows="5" placeholder="<div style='position: relative; width: 100%;height: 0; padding-bottom: 56.25%;'><iframe style='position: absolute; width: 100%; height: 100%; left: 0; top: 0;' src='https://killerplayer.com/new/video/ec01d921-6239-49c0-9491-992dafe9467f' width='745' height='419' frameborder='0' scrolling='no' allowfullscreen></iframe></div>">{{ optional($editVideo)->killerplayer ? "<div style='position: relative; width: 100%;height: 0; padding-bottom: 56.25%;'><iframe style='position: absolute; width: 100%; height: 100%; left: 0; top: 0;' src='".optional($editVideo)->killerplayer."' width='745' height='419' frameborder='0' scrolling='no' allowfullscreen></iframe></div>" : ''}}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold mb-1">YouTube Video Link</label>
                        <textarea name="YouTube" class="form-control" rows="1"  placeholder="https://www.youtube.com/watch?v=WOD1kjQREeg">{{ optional($editVideo)->title ? 'https://www.youtube.com/watch?v='.optional($editVideo)->youtube : '' }}</textarea>
                    </div>
                    <div class="col-md-12 text-right">
                        <input type="hidden" name="id" value="{{ optional($editVideo)->id }}">
                        <button type="submit" name="" class="btn btn-sm btn-primary px-4">Submit Now</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        @foreach ($videos as $item)
            <div class="col-md-3 mb-3">
                <div class="bg-dark-2 videos border-radius-10 card-body">
                    <p class="mb-1 h6 line-1">Playlist: 
                        @foreach ($item->PlaylistData as  $data)
                            {{$data->title}}
                        @endforeach
                    </p>
                    <div class="position-relative model-video" data-toggle="modal" data-target="#exampleModal" target-title="{{ $item->title }}" target-link="{{ $item->killerplayer }}">
                        <img src="https://i.ytimg.com/vi/{{ $item->youtube }}/mqdefault.jpg"  height="200" width="100%">
                        <button type="button" class="btn fa fa-play text-danger"></button>
                    </div>
                    <h6 class="mt-3 mb-2 line-1" id="title">{{ $item->title }}</h6>
                    <div class="d-flex justify-content-between">
                        <a href="{{route('edit-videos', ['id'=> $item->id])}}" class="text-primary text-uppercase">Edit</a>
                        <a href="{{route('deleted-videos', ['id'=>$item->id])}}" class="text-danger text-uppercase">Deleted</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark-2">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold text-white" id="exampleModalLabel">Shakir</h6>
                </div>
                <div class="modal-body">
                    <div>
                        <iframe id="video" src='' width="100%" height="260"  frameborder='0' scrolling='no' allowfullscreen></iframe>
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
<script>
    $('.model-video').click(function(){
        $('#video').attr('src',$(this).attr('target-link'))
        $('#exampleModalLabel').text($(this).attr('target-title'))
    })
    $('#close-btn').click(function(){
        $('#video').attr('src', '')
    })
</script>
@endsection
