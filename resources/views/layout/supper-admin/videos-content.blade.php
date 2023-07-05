@extends('admin')
@section('MetaTitle')
<title>Videos Content | Finacial Source</title>
@endsection

@section('styles')

@endsection

@section('content')
<div class="row pt-3">
    <div class="col-6 mb-3">
        <h5 class="font-weight-bold">Videos Content</h5>
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
    <form class="col-md-12 collapse" action="{{route('add-videos-content')}}" method="post" enctype="multipart/form-data" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
        @csrf
        <div class="bg-dark-2 border-radius-10 card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold mb-1">Content Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Type Video Content Title">
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
                    <table class="table news-table mb-0" id="accordion">
                        <tr>
                            <td class="font-weight-bold bg-dark-1 border-dark w-75">Title</td> 
                            <td class="font-weight-bold bg-dark-1 border-dark w-25 text-center">Action</td> 
                        </tr>
                        @foreach ($contents as $sr => $items)
                            <tr>
                                <td class="border-dark">
                                    <h6>{{$items->title}}</h6>
                                </td> 
                                <td class="border-dark text-center">
                                    <button type="button" class="btn bg-dark-1 text-primary py-2 fa fa-pencil edit-data" data-toggle="modal" data-target="#exampleModal"></button>
                                    <form method="post" action="{{route('edit-videos-content')}}" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        @csrf
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content bg-dark-3">
                                                <div class="modal-header bg-dark-3">
                                                    <h5 class="modal-title text-white" id="exampleModalLabel">{{$items->title}}</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body border-dark">
                                                    <label for="" class="text-white">Title</label>
                                                    <input type="text" value="{{$items->title}}" name="title" class="form-control">
                                                </div>
                                                <div class="modal-footer border-dark border-top border-white">
                                                    <input type="hidden" name="id" value="{{$items->id}}">
                                                    <button type="button" class="btn border-0 btn-secondary bg-dark-2" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn border-0 text-white bg-dark-1">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a href="{{route('delete-videos-contents', ['id'=>$items->id])}}" class="btn bg-dark-1 text-danger py-2 fa fa-trash"></a>
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

@endsection