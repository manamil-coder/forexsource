@extends('admin')
@section('MetaTitle')
<title>Breaking News & Squawk | Finacial Source</title>
@endsection

@section('styles')
<style>
    .undread {
        background-color: #2e2d2d;
    }
    .news-table tr {
        border-bottom: solid 2px #363636;
    }
    .news-table tr:last-child {
        border-bottom: none;
    }
    .card-header.note-toolbar{
        background-color: #0B0C10 !important;
        padding: 10px 14px 14px 14px !important;
    }
    .btn.btn-light{
        color: white !important;
        background-color: #2D2E31 !important;
        border: none !important
    }
    .note-editor.note-frame{
        border: none !important
    }
    .note-editor.note-frame .note-editing-area .note-editable {
        padding: 10px;
        overflow: auto;
        color: #fff !important;
        word-wrap: break-word;
        background-color: #2D2E31 !important;
    }
    .note-editor.note-frame .note-statusbar {
        background-color: #0B0C10 !important;
        border-top: 1px solid #0B0C10 !important;
    }
    .logo{
        border:solid #0B0C10 2px;
        background-color:#0B0C10;
        min-width: 40px;
        min-height: 40px;
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
</style>

@endsection

@section('content')

<div class="row py-3">
    <div class="col-6 mb-3">
        <h5 class="font-weight-bold">Breaking News & Squawk</h5>
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
    <form method="post" enctype="multipart/form-data" action="{{ optional($eidtBlog)->title ? route('blog.update') : route('breaking-news-squawk-add') }} " class="col-md-12 collapse {{ optional($eidtBlog)->title ? 'show' : '' }}" id="collapseOne"  aria-labelledby="headingOne" data-parent="#accordionExample">
        @csrf
        <div class="bg-dark-2 border-radius-10 card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold mb-1">Type Title</label>
                    <input type="text" name="title" value="{{ optional($eidtBlog)->title ? $eidtBlog->title : '' }}" class="form-control" placeholder="Type Title">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold mb-1">Externel Link</label>
                    <input type="link" name="link" value="{{ optional($eidtBlog)->link ? $eidtBlog->link : '' }}" class="form-control" placeholder="https://example.com">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold mb-1">Select Status</label>
                    <select name="status" class="form-control">
                        <option>-- Select Anyone --</option>
                        <option {{ optional($eidtBlog)->status == 'Must-Read' ? 'selected' : '' }} value="Must-Read">Most Read</option>
                        <option {{ optional($eidtBlog)->status == 'Research-Analysis' ? 'selected' : '' }} value="Research-Analysis">Research & Analysis</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="" class="font-weight-bold">Type Description</label>
                    <textarea class="form-control" name="description" id="summernote">{{ optional($eidtBlog)->description ? $eidtBlog->description : '' }}</textarea>
                </div>
                <div class="col-12 mb-3">
                    <label class="font-weight-bold mb-1">Type File Name</label>
                    <input type="text" name="file_name" placeholder="File Name" value="{{ optional($eidtBlog)->file_name ? $eidtBlog->file_name : '' }}" class="form-control">
                </div>
                <div class="col-12 mb-3">
                    <label class="font-weight-bold mb-1">Select File</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="col-md-12">
                    @if($eidtBlog)
                        <a href="{{asset('storage/'.$eidtBlog->file)}}" download="donwload" class="text-warning">
                            Download & See
                            <i class="fa fa-download ml-2"></i>
                        </a>  
                    @endif
                </div>
                <div class="col-md-12 text-right">
                    <input type="hidden" value="{{optional($eidtBlog)->id}}" name="id">
                    <input type="submit" class="btn btn-primary btn-sm px-4" value="{{ optional($eidtBlog)->file_name ? 'Update Now' : 'Add Now' }}">
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
                <div class="bg-dark-2" id="accordion">
                    <div class="text-center py-3">
                        <button type="button" class="d-inline-block mx-2 bg-transparent border-0 text-primary text-white filter" target-data="all">All News</button>
                        <button type="button" class="d-inline-block mx-2 bg-transparent border-0 text-white filter" target-data="Must-Read">Must Read</button>
                        <button type="button" class="d-inline-block mx-2 bg-transparent border-0 text-white filter" target-data="Research-Analysis">Research & Analysis</button>
                    </div>

                        @if ($blogs->isNotEmpty($blogs))
                            @foreach ($blogs as $sr => $item)
                            <div class="data" id="{{ $item->status}}">
                                @if ($item->collapse == 'collapse')
                                    <div class="d-flex align-items-center bg-dark-3 border-bottom p-2" data-toggle="collapse" data-target="#collapseOne{{ $item->id}}" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="logo"><img src="{{asset('assets/images/forex.jpg')}}" alt=""></div>
                                        <div class="text w-100">
                                            <h6 class="mb-0 font-weight-bold">
                                                {{$item->webname}} - {{ $item->title}}
                                                @if ($item->link)
                                                    <a href="{{$item->link}}" target="_blank" class="text-warning pl-2 fa fa-external-link"></a>    
                                                @endif
                                            </h6>
                                            {{ date("d-m-Y", strtotime($item->created_at)) }} 
                                        </div>
                                        <div class="action w-25 text-right">
                                            <a href="{{route('breaking-news-squawk-edit', ['id'=>$item->id])}}" class="btn bg-dark-1 text-primary py-2 fa fa-pencil"></a>
                                            <a href="{{route('breaking-news-squawk-destroy', ['id'=>$item->id])}}" class="btn bg-dark-1 text-danger py-2 fa fa-trash"></a>
                                        </div>
                                    </div>
                                    <div class="collapse" id="collapseOne{{ $item->id}}" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="pb-3 px-3">
                                            <p>{!! $item->description !!}</p>
                                            @if ($item->type != 'image')
                                                <a href="{{asset('storage/'.$item->file)}}" download="donwload" class="text-warning">
                                                    @if(!empty($item->file_name)) {{$item->file_name}} @else {{$item->file}}  @endif
                                                    <i class="fa fa-download ml-3"></i>
                                                </a>  
                                            @else
                                                <img src="{{asset('storage/'.$item->file)}}" width="50%" alt="">
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center bg-dark-3 border-bottom p-2">
                                        <div class="logo">
                                            @if ($item->webname == 'FXStreet')
                                                <img src="{{asset('assets/images/FXStreet.jpg')}}" alt="">     
                                            @else
                                                <img src="{{asset('assets/images/forex.jpg')}}" alt="">     
                                            @endif
                                        </div>
                                        <div class="text w-100">
                                            <h6 class="mb-0 font-weight-bold">
                                                {{$item->webname}} - {{ $item->title}}
                                                @if ($item->link)
                                                    <a href="{{$item->link}}" target="_blank" class="text-warning pl-2 fa fa-external-link"></a>    
                                                @endif
                                            </h6>
                                            {{ date("d-m-Y", strtotime($item->created_at)) }} 
                                        </div>
                                        <div class="action w-25 text-right">
                                            <a href="{{route('breaking-news-squawk-edit', ['id'=>$item->id])}}" class="btn bg-dark-1 text-primary py-2 fa fa-pencil"></a>
                                            <a href="{{route('breaking-news-squawk-destroy', ['id'=>$item->id])}}" class="btn bg-dark-1 text-danger py-2 fa fa-trash"></a>
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
<div class="row mb-4">
    <div class="col-md-12 text-right">
        {{-- {{$blogs->links('pagination::bootstrap-4')}} --}}
    </div>
</div>

@endsection
@section('scripts')
<link href="{{ asset('assets/texteditor/summernote-bs4.css') }}" rel="stylesheet">
<script src="{{asset('assets/texteditor/summernote-bs4.js')}}"></script>
<script src="{{asset('assets/texteditor/plugin/tam-emoji/js/config.js')}}"></script>
<script>
$(document).ready(function () {
    $("#summernote").summernote({
        height: 250,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['emoji','link', 'picture', 'video', 'hr']],
            ['view', ['codeview']]
        ],
        image: [
            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
            ['float', ['floatLeft', 'floatRight', 'floatNone']],
            ['remove', ['removeMedia']]
        ],
        link: [
            ['link', ['linkDialogShow', 'unlink']]
        ],
        table: [
            ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
            ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
        ],
        air: [
            ['color', ['color']],
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']]
        ]
    });
});
$('.filter').click(function(){
    var value = $(this).attr('id');
    $("#accordion").find(".data-here").css("display","none");
    $("."+value).css("display","");
})
$('.clear-filter').click(function(){
    $("#accordion").find(".data-here").css("display","");
});

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
</script>

@endsection
