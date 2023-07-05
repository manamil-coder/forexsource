@extends('admin')

@section('MetaTitle')
<title>Admins | Finacial Source</title>
@endsection

@section('styles')



@endsection

@section('content')

<div class="row pt-3">
    <div class="col-6 mb-3">
        <h5 class="font-weight-bold">Admins</h5>
    </div>
    <div class="col-6 mb-3 text-right">
        <button type="button" class="btn pb-1 bg-dark-2 text-white" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-plus"></i></button>
    </div>
    <form class="col-md-12 collapse @if(!empty(@$editAdmin->name)) show @endif" method="post" action="@if(empty(@$editAdmin->name)) {{ route('add-admin') }} @else {{ route('update-admin') }} @endif" enctype="multipart/form-data" id="collapseOne"  aria-labelledby="headingOne" data-parent="#accordionExample">
        @csrf
        <div class="bg-dark-2 border-radius-10 card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">Name</label>
                    <input type="text" name="name" value="{{@$editAdmin->name}}" class="form-control" placeholder="Enter Name">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="" class="font-weight-bold">Email</label>
                    <input type="text" name="email" value="{{@$editAdmin->email}}" class="form-control" placeholder="Enter Email">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="" class="font-weight-bold">Password</label>
                    <input type="password" name="password" value="{{@$editAdmin->Password}}" class="form-control" placeholder="Enter password">
                </div>
                <div class="col-md-12 text-right">
                    <input type="hidden" name="id" value="{{@$editAdmin->id}}">
                    <button type="submit" name="" class="btn btn-sm btn-primary px-4">@if(!empty(@$editAdmin->name)) Save Changes @else Add Now @endif </button>
                </div>
            </div>
        </div>
    </form>
    <div class="col-md-12">
        <div class="tab-pane fade text-white mt-3 show" id="news" role="tabpanel" aria-labelledby="news-tab">
            <div class="bg-dark-2 overflow-hidden border-radius-10">
                <div class="p-3 bg-dark-3  d-flex justify-content-between align-items-center">
                    <p class="heading-fonts  text-uppercase mb-0">Recently</p>
                </div>
                <div class="bg-dark-2">
                    <table class="table news-table mb-0">
                        <tr>
                            <td width="15%" class="font-weight-bold bg-dark-1 border-dark">Name</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Email</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark text-center">Action</td>
                        </tr>
                        @if ($admins->isNotEmpty())
                            @foreach ($admins as $sr => $items)
                                @if ($sr%2)
                                    @php $bgColor = 'bg-dark-2'; @endphp
                                @else
                                    @php $bgColor = 'bg-dark-3'; @endphp
                                @endif
                                <tr class="{{$bgColor}}">
                                    <td class="text-center border-dark">{{$items->name}}</td>
                                    <td class="text-center border-dark">{{$items->email}}</td>
                                    
                                    <td class="text-center border-dark text-center">
                                        <a href="{{route('edit-admin',['id'=>$items->id])}}" class="btn bg-dark-1 text-white py-2 fa fa-pencil"></a>
                                        <a href="{{route('admin-destroy', ['id'=>$items->id])}}" class="btn bg-dark-1 text-danger py-2 fa fa-trash"></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
@endsection