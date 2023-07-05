@extends('admin')
@section('MetaTitle')
    <title>USD GPD | Finacial Source</title>
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
    
</style>
@endsection

@section('content')
<div class="row pt-3">
    <div class="col-6 mb-3">
        <h5 class="font-weight-bold">Create Playlist</h5>
    </div>
    <div class="col-6 mb-3 text-right">
        <button type="button" class="btn pb-1 bg-dark-2 text-white" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-plus"></i></button>
    </div>
    <form class="col-md-12 collapse" action="{{route('usdGPD.store')}}" method="post" enctype="multipart/form-data" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
        @csrf
        <div class="bg-dark-2 border-radius-10 card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold mb-1"></label>
                    <select name="fundamental" class="form-control" id="">
                        <option >-- Select Fundamental Data --</option>
                        <option value="USD">USD</option>
                        <option value="CAD">CAD</option>
                        <option value="EUR">EUR</option>
                        <option value="NZD">NZD</option>
                        <option value="CHF">CHF</option>
                        <option value="GBP">GBP</option>
                        <option value="AUD">AUD</option>
                        <option value="JPY">JPY</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold mb-1"></label>
                    <input type="text" class="form-control" name="title" placeholder="Type Playlist Title">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold mb-1">Paste Iframe Code</label>
                    <textarea class="form-control" name="iframe" placeholder="<iframe src='https://tradingeconomics.com/embed/?s=gdp+cqoq&v=202211301437v20220312&h=300&w=600&ref=/united-states/gdp-growth' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-states/gdp-growth'>tradingeconomics.com</a>" rows="3"></textarea>
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
                    <p class="heading-fonts  text-uppercase mb-0">Recently USD GPD</p>
                </div>
                <div class="bg-dark-2">
                    <table class="table news-table mb-0" id="accordion">
                        <tr>
                            <td class="w-50 font-weight-bold bg-dark-1 border-dark">Title</td> 
                            <td class="w-25 font-weight-bold bg-dark-1 border-dark">Fundamental</td> 
                            <td class="w-25 text-center font-weight-bold bg-dark-1 border-dark">Action</td> 
                        </tr>
                        @foreach ($gpd as $items)
                            <tr>
                                <td colspan="3" class="w-75 font-weight-bold bg-dark-1 px-0 border-dark">
                                    <div class="d-flex align-items-center" data-toggle="collapse" data-target="#collapseOne{{$items->id}}" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="w-50 pl-3">
                                            {{$items->title}}
                                        </div>
                                        <div class="w-25 pl-3">
                                            {{$items->fundamental}}
                                        </div>
                                        <div class="w-25 text-center">
                                            <a href="{{route('usdGPD.destroy', ['id'=> $items->id])}}" class="btn bg-dark-1 text-danger py-2 fa fa-trash"></a>
                                        </div>
                                    </div>
                                    <div class="collapse px-3 text-center"  id="collapseOne{{$items->id}}" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <iframe src='{{$items->iframe}}' height='280' width='100%' class="iframe" frameborder='0' scrolling='no'></iframe>
                                    </div>
                                </td> 
                            </tr>
                        @endforeach
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
$('.iframe').live('click', function () {

   alert();

});
</script>
@endsection