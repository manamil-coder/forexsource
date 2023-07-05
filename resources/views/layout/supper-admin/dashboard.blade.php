@extends('admin')
@section('MetaTitle')
    <title>Dashboard | Finacial Source</title>
@endsection

@section('styles')
<style>
.dashboard .earn{
	overflow: hidden;
	background-image: url('../../images/admin/earning-back.jpg');
	background-size: contain;
	background-repeat: no-repeat;
}
.dashboard .earn .avatar{
	border-radius:100%;
	overflow: hidden;
	width: 52px;
	height: 52px;
	margin-top: -40px;
	margin-left: auto;
	margin-right: auto;
}
.dashboard .user .details-area .img{
	width: 52px;
	height: 34px;
}
.dashboard .user .details-area .img img{
	width: 100%;
	height: 34px;
	object-fit: cover;
}
.users .img{
    width: 30px;
    height: 30px;
    border-radius:100%;
    overflow: hidden;
}
.users .img img{
    width:100%;
    height:30px;
    object-fit: cover;
    object-position: center;    
}
</style>
@endsection

@section('content')
<div class="row dashboard mt-3">
    <div class="col-lg-6 mb-3">
        <div class="pt-5 earn  bg-dark-2 border-20">
            <div class="content text-center p-3 bg-dark-2">
                <div class="avatar mb-3"><img src="{{ asset('assets/images/Ordericons-02.png') }}" width="52" height="52" alt=""></div>
                <h5 class="">Total Videos</h5>
                <p class="text-uppercase h6 font-weight-bold ">{{$totalVideos}}</p>
                
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <div class="pt-5 earn  bg-dark-2 border-20">
            <div class="content text-center p-3 bg-dark-2">
                <div class="avatar mb-3"><img src="{{ asset('assets/images/Ordericons-01.png') }}" width="52" height="52" alt=""></div>
                <h5 class="">Total Users</h5>
                <p class="text-uppercase h6 font-weight-bold ">{{$totalUsers->count()}}</p>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-4 mb-3">
        <div class="pt-5 earn  bg-dark-2 border-20">
            <div class="content text-center p-3 bg-dark-2">
                <div class="avatar mb-3"><img src="{{ asset('assets/images/Ordericons-02.png') }}" width="52" height="52" alt=""></div>
                <h5 class="">Free Users</h5>
                <p class="text-uppercase h6 font-weight-bold ">{{$totalUsers->where(['type' => 'HFM'])->count()}}</p>
            </div>
        </div>
    </div> --}}
</div>

    <div class="col-md-12">
        <h1></h1>
        <div class="tab-pane fade text-white mt-3 show" id="news" role="tabpanel" aria-labelledby="news-tab">
            <div class="bg-dark-2 overflow-hidden border-radius-10">
                <div class="p-3 bg-dark-3  d-flex justify-content-between align-items-center">
                    <p class="heading-fonts  text-uppercase mb-0">Pending user requests.</p>
                </div>
                <div class="bg-dark-2">
                    <table class="table news-table mb-0">
                        <tr>
                            <td width="15%" class="font-weight-bold bg-dark-1 border-dark">Name</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Phone</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Address</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Status</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark text-center">Action</td>
                        </tr>
                        <tbody class="ajaxHFMUserData">
                            @if ($UserPayment->isNotEmpty())
                                @foreach ($UserPayment as $sr => $items)
                                    @if ($sr%2)
                                        @php $bgColor = 'bg-dark-2'; @endphp
                                    @else
                                        @php $bgColor = 'bg-dark-3'; @endphp
                                    @endif
                                    <tr class="{{$bgColor}}">
                                        <td width="15%" class="font-weight-bold border-dark">
                                            <div class="d-flex users align-items-center">
                                                <div class="img bg-dark-1">
                                                    @if (!empty($items->User->image))
                                                        <img src="{{ asset('storage/'.$items->User->image)}}" alt="">
                                                    @else
                                                        <img src="{{ asset('assets/images/avator.png')}}" alt="">
                                                    @endif
                                                </div>
                                                <div class="ml-2">{{$items->User->name}}</div>
                                            </div>
                                        </td>
                                        <td class="text-center font-weight-bold border-dark">{{$items->User->phone}}</td>
                                        <td class="text-center font-weight-bold border-dark">{{$items->User->address}}</td>
                                        <td class="text-center font-weight-bold border-dark">Paid</td>
                                        <td class="text-center font-weight-bold border-dark"><button type="button" class="btn show-screenshot bg-dark-1 text-white py-2 px-3 btn-sm fa fa-info" data-toggle="modal" data-target="#exampleModal" target-id="{{$items->id}}" target-title="{{$items->User->name}}" target-link="{{asset('storage/'.$items->screenshot)}}"></button></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <h1></h1>
        <div class="tab-pane fade text-white mt-3 show" id="news" role="tabpanel" aria-labelledby="news-tab">
            <div class="bg-dark-2 overflow-hidden border-radius-10">
                <div class="p-3 bg-dark-3  d-flex justify-content-between align-items-center">
                    <p class="heading-fonts  text-uppercase mb-0">Pending playlist requests.</p>
                </div>
                <div class="bg-dark-2">
                    <table class="table news-table mb-0">
                        <tr>
                            <td width="80%" class="font-weight-bold bg-dark-1 border-dark">Name</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Payment Screenshot</td>
                        </tr>
                        <tbody class="ajaxPendingPlayListData">
                            @if ($playlists->isNotEmpty())
                                @foreach ($playlists as $data)
                                    <tr>
                                        <td width="15%" class="border-dark">
                                            <div class="d-flex users align-items-center">
                                                <div class="img bg-dark-1">
                                                    @if (!empty($data->getUsers->image))
                                                        <img src="{{ asset('storage/'.$data->getUsers->image)}}" alt="">
                                                    @else
                                                        <img src="{{ asset('assets/images/avator.png')}}" alt="">
                                                    @endif
                                                </div>
                                                <div class="ml-2">{{@$data->getUsers->name}}</div>
                                            </div>
                                        </td>
                                        <td class="text-center border-dark">
                                            <button type="button" class="btn playlist-request bg-dark-1 text-white py-1 px-3 btn-sm" data-toggle="modal" data-target="#PlaylistModel" target-id="{{$data->id}}" target-title="{{@$data->getUsers->name}}" target-link="{{ asset('storage/'.$data->screenshot)}}">View Screenshot</button>
                                        </td>
                                    </tr>    
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="post" enctype="multipart/form-data" action="{{route('update-payment')}}" class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark-2">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold text-white" id="exampleModalLabel"></h6>
            </div>
            <div class="modal-body pb-0">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="font-weight-bold mb-0 text-white">Start Date</label>
                        <input type="date" class="form-control" name="start_date">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="font-weight-bold mb-0 text-white">Start Date</label>
                        <input type="date" class="form-control" name="end_date">
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" class="form-control" value="" id="updateId" name="id">
                        <input type="hidden" class="form-control" id="accountType" name="type" value="">
                    </div>
                </div>
                <div class="imgbox"><img src="" id="view-img" alt=""></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm bg-dark-1 text-white border-0 px-3 py-2 btn-sm">Save Changes</button>
                <button type="button" class="btn btn-sm bg-danger text-white border-0 px-3 py-2 btn-sm" id="close-btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</form>

<form method="post" enctype="multipart/form-data" action="{{route('playlist-makepackage')}}" class="modal fade" id="PlaylistModel" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark-2">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold text-white" id="PlaylistModellabel"></h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="font-weight-bold mb-0 text-white">Start Date</label>
                        <input type="date" class="form-control" name="start_date">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="font-weight-bold mb-0 text-white">Start Date</label>
                        <input type="date" class="form-control" name="end_date">
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" class="form-control" value="" id="updateId2" name="id">
                    </div>
                </div>
                <div class="imgbox"><img src="" id="view-img2" alt=""></div>
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
{{-- 
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    setInterval(function(){
        $.ajax({
            type: "POST",
            url: '{{route('ajaxPendingPlayListData')}}',
            data: '',
            async: true,
            success: function(text) {
                response = text;
                $('.ajaxPendingPlayListData').prepend(response)
            }
        });
    }, 1000);

    setInterval(function(){
        $.ajax({
            type: "POST",
            url: '{{route('ajaxHFMUserData')}}',
            data: '',
            async: true,
            success: function(text) {
                response = text;
                $('.ajaxHFMUserData').prepend(response)
            }
        });
    }, 1000);

    $('.show-screenshot').click(function(){
        $('#updateId').val($(this).attr('target-id'));
        $('#view-img').attr('src',$(this).attr('target-link'))
        $('#exampleModalLabel').text($(this).attr('target-title'))
        $('#accountType').val($(this).attr('target-type'))
    })
    $('.playlist-request').click(function(){
        $('#updateId2').val($(this).attr('target-id'));
        $('#view-img2').attr('src',$(this).attr('target-link'))
        $('#PlaylistModellabel').text($(this).attr('target-title'))
    })
    $('#close-btn').click(function(){
        $('#video').attr('src', '')
    })
</script> --}}

<script>
 $('.show-screenshot').click(function(){
        $('#updateId').val($(this).attr('target-id'));
        $('#view-img').attr('src',$(this).attr('target-link'))
        $('#exampleModalLabel').text($(this).attr('target-title'))
        $('#accountType').val($(this).attr('target-type'))
    })
    $('.playlist-request').click(function(){
        $('#updateId2').val($(this).attr('target-id'));
        $('#view-img2').attr('src',$(this).attr('target-link'))
        $('#PlaylistModellabel').text($(this).attr('target-title'))
    })
    $('#close-btn').click(function(){
        $('#video').attr('src', '')
    })    
</script>
@endsection