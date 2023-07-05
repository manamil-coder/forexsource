@extends('admin')
@section('MetaTitle')
<title>Create Playlist | Finacial Source</title>
@endsection

@section('styles')
<style>
    .img{
        width:40px ;
        height: 40px;
        border-radius:100%; 
        overflow: hidden;
    }
    .img img{
        width:40px ;
        height: 40px;
        object-fit: cover;
    }
    .content-img{
        height: 200px;
    }
</style>
@endsection

@section('content')

<div class="row pt-3">
    <div class="col-6 mb-3">
        <h5 class="font-weight-bold">Create Playlist</h5>
    </div>
    <div class="col-6 mb-3 text-right">
        <button class="btn pb-1 bg-dark-2 text-white" id="headingOne" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"><i class="fa fa-search"></i></button>
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
    <div class="col-md-12 collapse" id="collapseTwo" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="bg-dark-2 border-radius-10 card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold">Name</label>
                    <input type="text" name="name" value="" id="search" class="form-control" placeholder="Search user">
                </div>
            </div>
        </div>
    </div>
    <form class="col-md-12 collapse" action="{{route('add-create-playlist')}}" method="post" enctype="multipart/form-data" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
        @csrf
        <div class="bg-dark-2 border-radius-10 card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold mb-1">Select Content</label>
                    <select class="form-control" name="contents_id">
                        @if ($contents->isNotEmpty())
                            <option value="">-- Select Anyone --</option>
                            @foreach ($contents as $items)
                                <option value="{{$items->id}}">{{$items->title}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold mb-1">Playlist Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Type Playlist Title">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold mb-1">Select Thumbnail</label>
                    <input type="file" class="form-control" name="file" placeholder="Type Playlist Title">
                </div>
                <div class="col-md-12 text-right">
                    <button type="submit" name="" class="btn btn-sm btn-primary px-4">Submit Now</button>
                </div>
            </div>
        </div>
    </form>
    <div class="col-md-12">
        <div class="tab-pane fade text-white mt-3 show" id="news" role="tabpanel" aria-labelledby="news-tab">
            <div class="bg-dark-2 overflow-hidden border-radius-10">
                <div class="p-3 bg-dark-3  d-flex justify-content-between align-items-center">
                    <p class="heading-fonts  text-uppercase mb-0">Recently Added</p>
                </div>
                <div class="bg-dark-2">
                    <table class="table myTable news-table mb-0" id="accordion2">
                        <tr>
                            <td class="font-weight-bold bg-dark-1 border-dark">Title</td> 
                            <td class="font-weight-bold bg-dark-1 border-dark text-center">Note</td> 
                            <td class="font-weight-bold bg-dark-1 border-dark text-center">Content</td> 
                            <td class="font-weight-bold bg-dark-1 border-dark text-center">Status</td> 
                            <td class="font-weight-bold bg-dark-1 border-dark text-center">Price</td> 
                            <td class="font-weight-bold bg-dark-1 border-dark text-center">Action</td> 
                        </tr>
                        @foreach ($playlists as $sr => $items)
                            <tr>
                                <td class="border-dark">
                                    <div class="d-flex align-items-center">
                                        <div class="img mr-3">
                                            <img src="{{ asset('storage/'.$items->file)}}" alt="">
                                        </div>
                                        <div class="text"><h6 class="mb-0">{{$items->title}}</h6></div>
                                    </div>
                                </td> 
                                <td class="text-center border-dark text" id="heading-{{$items->id}}" data-toggle="collapse" data-target="#collapse-{{$items->id}}" aria-expanded="true" aria-controls="collapse-{{$items->id}}"><i class="fa fa-sticky-note-o"></i></td>
                                <td class="border-dark text-center">
                                    @foreach ($items->contentData as $name)
                                        {{$name->title}}
                                    @endforeach
                                </td> 
                                <td class="border-dark text-center">{{$items->status}}</td> 
                                <td class="border-dark text-center">{{$items->price}}</td> 
                                <td class="border-dark text-center">
                                    <a href="#0" class="btn bg-dark-1 text-info py-2 fa fa-lock show-screenshot"  data-toggle="modal" data-target="#exampleModal" target-price="{{$items->price}}" target-id="{{$items->id}}" target-title="{{$items->title}}"></a>
                                    <a href="#0" class="btn bg-dark-1 text-primary py-2 fa fa-pencil" data-toggle="modal" data-target="#exampleModal{{$items->id}}"></a>
                                    <form method="post" enctype="multipart/form-data" action="{{route('updatePlaylist')}}" class="modal fade" id="exampleModal{{$items->id}}" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        @csrf
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content bg-dark-2">
                                                <div class="modal-header">
                                                    <h6 class="modal-title font-weight-bold text-white" >{{$items->title}}</h6>
                                                </div>
                                                <div class="modal-body pb-0">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="" class="font-weight-bold mb-0 text-white">Select Content</label>
                                                            <select class="form-control" name="contents_id">
                                                                @if ($contents->isNotEmpty())
                                                                    <option value="">-- Select Anyone --</option>
                                                                    @foreach ($contents as $item)
                                                                        <option value="{{$item->id}}" {{ $items->contents_id == $item->id ? 'selected' : '' }} >{{$item->title}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label for="" class="mb-0 text-white">Title</label>
                                                            <input type="text" name="title" value="{{ $items->title }}" class="form-control">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="" class="mb-0 text-white">Select Image File</label>
                                                            <input type="file" name="file" class="form-control">
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <input type="hidden" class="form-control" value="{{ $items->id }}"  name="id">
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <div class="content-img">
                                                                <img src="{{ asset('storage/'.$items->file)}}" style="width:100%; height:200px; object-fit:cover" class="w-100" alt="">
                                                            </div>
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
                                    <a href="{{route('deleted-create-playlist', ['id'=>$items->id])}}" class="btn bg-dark-1 text-danger py-2 fa fa-trash"></a>
                                </td> 
                            </tr>
                            <tr class="collapse" id="collapse-{{$items->id}}" aria-labelledby="heading-{{$items->id}}" data-parent="#accordion2">
                                <td colspan="6">
                                    <textarea name="note" class="noteTextArea form-control" data-id="{{$items->id}}">{{$items->note}}</textarea>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="post" action="{{route('locked')}}" class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark-2">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold text-white" id="exampleModalLabel"></h6>
            </div>
            <div class="modal-body pb-0">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="font-weight-bold mb-0 text-white">Price</label>
                        <input type="number" class="form-control" id="price" name="price">
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" class="form-control" value="" id="updateId" name="id">
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
<script>
    $('.show-screenshot').click(function(){
        $('#updateId').val($(this).attr('target-id'));
        $('#exampleModalLabel').text($(this).attr('target-title'))
        $('#price').val($(this).attr('target-price'))
    })
    $('#close-btn').click(function(){
        $('#video').attr('src', '')
    })

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $(document).ready(function() {
        $('.noteTextArea').on('keyup', function() {
            var primaryId =  $(this).attr("data-id");
            var note =  $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{route("ajaxPlaylistNote")}}',
                data: 'id='+primaryId+'&note='+note+'',
                async: true,
                success: function(data) {
                    // console.log(data);
                },
                error:function(){

                }
            });
        });
    });
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