@extends('admin')

@section('MetaTitle')
<title>Users Information | Finacial Source</title>
@endsection

@section('styles')
<style>
    .user-info .img{
        width: 150px;
        height: 150px;
        border-radius:100%;
        overflow: hidden;
    }
    .user-info .img img{
        width:100%;
        height:150px;
        object-fit: cover;
        object-position: center;    
    }
</style>
@endsection
@section('content')
    <div class="row pt-3" id="accordion">
        <div class="col-6 mb-3"> <h5 class="font-weight-bold"></h5> </div>
        <div class="col-md-12 user-info">
            <div class="card card-body bg-dark-2 border-radius-10">
                <div class="row">
                    <div class="col-lg-3 mb-lg-0 mb-5">
                        <div class="text-center">
                            <div class="img mb-3">
                                @if(!empty($users->image))
                                    <img src="{{ asset('storage/'.$users->image)}}" alt="">
                                @else
                                    <img src="{{ asset('assets/images/avator.png')}}" alt="">
                                @endif
                            </div>
                            <h6 class="d-flex justify-content-between"><i style="width:50px;" class="fa fa-user mr-2"></i><span class="w-100 text-left">{{ $users->name}}</span></h6>
                            <h6 class="d-flex justify-content-between"><i style="width:50px;" class="fa fa-envelope mr-2"></i><span class="w-100 text-left text-break">{{ $users->email}}</span></h6>
                            <h6 class="d-flex justify-content-between"><i style="width:50px;" class="fa fa-phone mr-2"></i><span class="w-100 text-left">{{ $users->phone}}</span></h6>
                            <h6 class="d-flex justify-content-between"><i style="width:50px;" class="fa fa-dot-circle-o mr-2"></i><span class="w-100 text-left">{{ $users->type}}</span></h6>
                            <h6 class="d-flex justify-content-between"><i style="width:50px;" class="fa fa-map mr-2"></i><span class="w-100 text-left">{{ $users->address}}</span></h6>
                            <h6 class="d-flex justify-content-between"><i style="width:50px;" class="fa fa-sticky-note mr-2"></i><span class="w-100 text-left">Note</span></h6>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <h5 class="bg-dark rounded p-2">Playlists</h5>
                        <table class="table">
                            <tr>
                                <td width="25%" class="font-weight-bold small bg-dark p-2">Playlist Name</td>
                                <td width="25%" class="text-center font-weight-bold small bg-dark p-2">Start Date</td>
                                <td width="25%" class="text-center font-weight-bold small bg-dark p-2">End Date</td>
                                <td width="25%" class="text-center font-weight-bold small bg-dark p-2">ScreenShot</td>
                            </tr>
                            @foreach ($BuyList as $items)
                                <tr>
                                    <td class="small p-2">{{$items->PlaylistName->title}}</td>
                                    <td class="text-center small p-2">{{ $items->start_date }}</td>
                                    <td class="text-center small p-2">{{ $items->end_date }}</td>
                                    <td class="text-center small p-2">
                                        <button type="button" class="btn show-screenshot bg-dark-1 text-white py-1 btn-sm px-4" data-toggle="modal" data-target="#PlaylistModel" target-id="{{$items->id}}" target-title="{{$items->PlaylistName->title}}" target-link="{{ asset('storage/'.$items->screenshot)}}">View Screenshot</button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form method="post" enctype="multipart/form-data" action="{{route('playlist-makepackage')}}" class="modal fade" id="PlaylistModel" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark-2">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold text-white" id="exampleModalLabel"></h6>
                </div>
                <div class="modal-body">
                    
                    <div class="imgbox"><img src="" id="view-img" alt=""></div>
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
<script>
    $('.show-screenshot').click(function(){
        $('#updateId').val($(this).attr('target-id'));
        $('#view-img').attr('src',$(this).attr('target-link'))
        $('#exampleModalLabel').text($(this).attr('target-title'))
    })
</script>
@endsection