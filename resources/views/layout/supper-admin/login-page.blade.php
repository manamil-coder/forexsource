@extends('admin')

@section('MetaTitle')
<title>Admins | Finacial Source</title>
@endsection

@section('styles')



@endsection

@section('content')

<div class="row pt-3">
    <div class="col-6 mb-3">
        <h5 class="font-weight-bold">Login Page</h5>
    </div>
    <form class="col-md-12" method="post" action="{{route('udpateLogin')}}" enctype="multipart/form-data">
        @csrf
        <div class="bg-dark-2 border-radius-10 card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold">Heading</label>
                    <input type="text" name="title" value="{{@$data->title}}" class="form-control" placeholder="Enter Name">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="" class="font-weight-bold">Description</label>
                    <textarea name="description" class="form-control" rows="10">{{@$data->description}}</textarea>
                </div>
                <div class="col-md-12 text-right">
                    <input type="hidden" name="id" value="">
                    <button type="submit" name="" class="btn btn-sm btn-primary px-4"> Save Changes  </button>
                </div>
            </div>
        </div>
    </form>
</div>


@endsection
@section('scripts')
@endsection