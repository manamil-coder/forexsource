
@extends('admin')
@section('MetaTitle')
<title>Chat | Finacial Source</title>
@endsection

@section('styles')
<style>
    .contacts{
        height: 500px;
        min-width: 280px;
    }
    .chat-area{
        height: 500px;
        width: 100%;
    }
    .contacts .search{
        border-radius:20px;
    }
    .contacts .users{
        height: 420px;
        overflow: auto;
    }
    .contacts .users::-webkit-scrollbar{height:7px;}
    .contacts .users::-webkit-scrollbar{width:7px;}
    .contacts .users::-webkit-scrollbar-thumb{background-color:#0B0C10;border-radius:200px;}
    .contacts .users .user-box{
        border-radius: 16px;
    }
    .contacts .users .user-box.active,
    .contacts .users .user-box:hover{
        background-color: black;
    }
    .contacts .users .user-box .user-img{
        width: 50px;
        height: 50px;
        border-radius:100%;
        overflow: hidden;
    }
    .contacts .users .user-box .user-img img{
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
    .chat{
        height: 461px;
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
        display: inline-block;
        width: 60%;
    }
    .message .message-text{
        background-color: #1B1B1B;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        border-top-right-radius: 15px;
        display: inline-block;
    }
    .message .message-text.text-left{
        background-color: #1B1B1B;
        border-top-left-radius: 15px;
        border-top-right-radius: 0px; 
    }
    .drapdarea{
        position: absolute;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        border: solid 1px #2D2E31;
        background-color: #0B0C10;
        z-index: 99999999;
        border-bottom-left-radius:10px; 
        border-bottom-right-radius:10px; 
    }
    .drapdarea .images-area{
        width: 400px;
        height: 420px;
        margin: auto;
        overflow: hidden;
        border-radius:10px;  
    }
    .drapdarea .images-area img{
        width: 100%;
        height: 500px;
        object-fit: cover;
        object-position: center center;
    }
    .drapdarea .img-text{
        width: 402px;
        margin: auto;
        border-radius:5px;  
        overflow: hidden;
    }
    .close-preview{
        position: absolute;
        top: 0px;
        right: 0px;
        z-index:99999999999999999999;
        background: red;
        padding: 5px 10px;
        border-bottom-left-radius: 10px;
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
<div class="row py-3">
    <div class="col-6">
        <h5 class="font-weight-bold">Chat</h5>
    </div>
    <div class="col-md-12">
        <div class="tab-pane fade text-white mt-3 show" id="news" role="tabpanel" aria-labelledby="news-tab">
            <div class="bg-dark-2 overflow-hidden border-radius-10">
                <div class="p-3 bg-dark-3  d-flex justify-content-between align-items-center">
                    <p class="heading-fonts mb-0">Users Chat</p>
                </div>
                <div class="bg-dark-2 d-flex">
                    <div class="chat-area before-upload upload-area position-relative">
                        <span class="close-preview d-none js-close-preview">x</span>
                        <label for="file" class="drapdarea d-none pt-3 mb-0">
                            <div class="images-area mb-2">
                                <div class="after-loader d-none">
                                    <span class="p-relative">
                                        <img src="" alt="image-logo" id="img-prev">
                                    </span>
                                    <span class="img-name">1144182.jpg</span>
                                    <span class="img-size">5.07MB</span>
                                </div>
                            </div>
                            <div class="input-group img-text border-top border-dark">
                                <input type="text" value="" class="form-control rounded-0 bg-dark-2 border-0 get-message2" placeholder="Type message..." >
                                <div class="input-group-append">
                                    <input type="submit" name="message" value="Send Now" class="btn send-message bg-dark-3 rounded-0 text-white px-3">
                                </div>
                            </div>
                            <input type="file" hidden id="file" name="image" value="" accept="image/*">
                        </label>
                        <div class="pt-3 px-3 chat" id="div_id">
                            @if ($chat->isNotEmpty())
                                @foreach ($chat as $items )
                                    @if ($items->sender_id != '1')
                                        <div class="d-flex mb-3 message">
                                            <div class="image">
                                                @if ($items->UserData->isNotEmpty())
                                                    @foreach ($items->UserData as $img)
                                                        @if (!empty($img->image))
                                                            <img src="{{ asset('storage/'.$img->image)}}" alt="">
                                                        @else
                                                            <img src="{{ asset('assets/images/avator.png')}}" alt="">
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="text">
                                                <div class="message-text pl-3 pr-5 pt-2 pb-2 ml-3 position-relative">
                                                    <div class="dropdown position-absolute" style="right:10px; bottom:4px;">
                                                        <button class="btn p-0 bg-transparent text-white"  type="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i></button>
                                                        <div class="dropdown-menu p-0 bg-dark-1">
                                                            <a href="{{route('message-trash', ['id'=> $items->id])}}" class="btn btn-danger btn-sm rounded-0 btn-block">Deleted Message</a>
                                                            <a href="{{route('block-user', ['id'=> $items->user_id])}}" class="btn btn-warning btn-sm rounded-0 btn-block">Block User</a>
                                                        </div>
                                                    </div>
                                                    {{$items->message}}<br>
                                                    <small>{{ date("d-m-Y H:ia", strtotime($items->created_at)) }} </small> 
                                                    @if ($items->UserData->isNotEmpty())
                                                        @foreach ($items->UserData as $userDatas)
                                                            @if (!empty($userDatas->chat))
                                                                <small>({{$userDatas->chat}})</small>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex message mb-3 justify-content-end">
                                            <div class="text text-right">
                                                <div class="message-text text-left px-3 pt-2 pb-2 mr-3" >
                                                    @if (!empty($items->file))
                                                        <div class="img-box mb-1" data-toggle="modal" data-target="#exampleModal" target-title="{{$items->message}}" target-link="{{ asset('storage/'.$items->file)}}">
                                                            <img src="{{ asset('storage/'.$items->file)}}" alt="">
                                                        </div>
                                                    @endif
                                                    {{$items->message}}
                                                    <div class="text-right">
                                                        <small>{{ date("d-m-Y H:ia", strtotime($items->created_at)) }} </small> 
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="image">
                                                <img src="{{asset('assets/images/favicon.png')}}" alt="">
                                            </div> --}}
                                        </div>
                                    @endif
                                @endforeach
                            @else

                            @endif
                            <div class="left-box right-box-msg"></div>
                        </div>
                        <div class="inputs d-flex rounded-0">
                            <div class="input-group bg-dark-3 align-items-center">
                                <label for="file" class="mb-0 input-group-append attach">
                                    <i class="fa fa-paperclip btn rounded-0"></i>
                                </label>
                                <input type="text" value="" class="form-control rounded-0 bg-dark-2 border-0 get-message getMessageByEnter" placeholder="Type message..." >
                                <div class="input-group-append">
                                    <input type="submit" name="message"  value="Send Message" class="btn send-message sendMessageByEnter bg-dark-3 rounded-0 text-white px-5">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark-2">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold text-white" id="exampleModalLabel">Shakir</h6>
            </div>
            <div class="modal-body">
                <div><img src="" id="video" width="100%" alt="">
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
$('.img-box').click(function(){
    
    $('#video').attr('src', $(this).attr('target-link')) 
    $('#exampleModalLabel').text($(this).attr('target-title'))
})
$('#close-btn').click(function(){
    $('#video').attr('src', '')
})

var objDiv = document.getElementById('div_id');
objDiv.scrollTop = objDiv.scrollHeight

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

$('.send-message').click(function(){
    
    var message ='';
    if($('.get-message2').val() != ''){
        message    = $('.get-message2').val();
    }else{

        message         = $('.get-message').val();
    }
    var user_id         = "1"
    var sender_id       = "1";
    var receiver_id     = "1";
    var img = $('#img-prev').attr('src');
    
    $.ajax({
        type: "POST",
        url: '{{ route("Admin-chat-ajax") }}',
        data: 'message='+message+'&user_id='+user_id+'&sender_id='+sender_id+'&receiver_id='+receiver_id+'&img='+img+'',
        async: true,
        success: function(text) {
            response = text;
            
            $('.get-message').val('');
            if(img != ''){
                $(".js-close-preview").click()
                
            }
            
            // yahn par aek error ha ya wab theek ha jab tak koi note nhi karta
            // var html = '<div class="d-flex message mb-3 text-right justify-content-end"><div class="message-text text-left pl-3 pr-5 pt-2 pb-2 mr-3">'+message+'<br><small>{{date("d-m-Y H:i")}}</small></div></div></div>';
            // $('.right-box-msg').append(html);
            // var objDiv = document.getElementById('div_id');
            // objDiv.scrollTop = objDiv.scrollHeight
        }
    });
})

setInterval(function(){
    chatload();
}, 1000);

function chatload(){
    $.ajax({
        type: "POST",
        url: "{{route('ajax-chat')}}",
        data: '',
        async: true,
        success: function(text) {
            response = text;
            $('.right-box-msg').append(response)
            if(response != ''){
                var objDiv = document.getElementById('div_id');
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        }
    });
}
//attach image
$("#file").on("change", function (e) {
    
    let file = e.target.files[0];
    
        convert_image_base64(file);
        if (file.type != "application/pdf") {
            $(this).val("");
        }
    
});

//PDF file and other
function show_file_info(file) {
    var fileName = file.name; // get file name
    if (fileName.length > 20) {
        fileName = fileName.substr(0, 20);
    }
    var fileSize = file.bytes; // get file size
    if (typeof fileSize == "undefined") {
        fileSize = file.size;
    }
    fileSize = (fileSize / (1024 * 1024)).toFixed(2);
    let data = {
        src: file.link,
        fileName,
        fileSize,
        fileType: "application/pdf",
    };
    platform = "file";
    preview_img(data);
}



//drag and drop script

var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png", "application/pdf"];
// preventing page from redirecting
$("html").on("dragover", function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $("html").on("drop", function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Drag enter
    $(".upload-area").on("dragenter", function (e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $(".upload-area").on("dragleave", function (e) {
        e.stopPropagation();
        e.preventDefault();
    });

    // Drag over
    $(".upload-area").on("dragover", function (e) {
        e.stopPropagation();
        e.preventDefault();
    });
    // Drop
    $(".upload-area").on("drop", function (e) {
        e.stopPropagation();
        e.preventDefault();
        
        let file = e.originalEvent.dataTransfer.files[0];
        convert_image_base64(file)
        if (file.type == "application/pdf") {
            show_file_info(file);
            copy_paste_file = file;
        }
        
        platform = "file";
    });
//convert base64
function convert_image_base64(file) {
    var done = function (url) {
        image = url;
    };
    
    var fileType = file.type;
    
    if (!validImageTypes.includes(fileType)) {
        alert("Images type not allow");
        return false;
    }
    if (file && file.length > 0) {
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
    var fileName = file.name; // get file name
    if (fileName.length > 30) {
        fileName = fileName.substr(0, 20);
    }
    var fileSize = file.size; // get file size
    fileSize = (fileSize / 1000000).toFixed(2);
    var fileType = file.type; // get file type
    var reader = new FileReader();
    reader.onload = function (e) {
        let src = e.target.result;
        let data = { src, fileName, fileSize, fileType };

        
        preview_img(data);
    };
    reader.readAsDataURL(file);
    return true;
}
//function to preview
function preview_img({ src, fileName, fileSize, fileType }, info = 1) {
    $(".drapdarea").removeClass("d-none");
    $(".after-loader").removeClass("d-none");
    $(".close-preview").removeClass("d-none");
    if (fileType != "application/pdf") {
        $("#img-prev").attr("src", src);
    }
    image = src;
    if (info == 1) {
        $(".img-name").html(fileName);
        $(".img-size").html(fileSize + "MB");
    } else {
        $(".img-name , .img-size").html("");
    }
    return src;
}

$(".js-close-preview").on("click", function (e) {
    startOver();
});



function startOver() {
    $(".drapdarea").addClass("d-none");
    $(".after-loader").addClass("d-none");
    $("#img-prev").attr("src", '');
    $(".img-name").html('');
    $(".img-size").html('');
    $(".close-preview").addClass("d-none");
}

$('.getMessageByEnter').keyup(function(e){
    if(e.which == 13){
        // event.preventDefault();
        // return false;
        $('.sendMessageByEnter').click();
    }
});
</script>
@endsection