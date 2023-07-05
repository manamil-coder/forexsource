@extends('admin')

@section('MetaTitle')
<title>Users | Finacial Source</title>
@endsection

@section('styles')
<style>
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

<div class="row pt-3" id="accordion">
    <div class="col-6 mb-3">
        <h5 class="font-weight-bold">Users</h5>
    </div>
    <div class="col-6 mb-3 text-right">
        <button class="btn pb-1 bg-dark-2 text-white" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-search"></i></button>
        <button class="btn pb-1 bg-dark-2 text-white" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"><i class="fa fa-plus"></i></button>
    </div>
    <div class="col-md-12 collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="bg-dark-2 border-radius-10 card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold">Name</label>
                    <input type="text" name="name" value="" id="search" class="form-control" placeholder="Search user">
                </div>
            </div>
        </div>
    </div>
    <form class="col-md-12 collapse @if(!empty(@$editUser->name)) show @endif" method="post" action="@if(empty(@$editUser->name)) {{ route('add-user') }} @else {{ route('update-user') }} @endif" enctype="multipart/form-data" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordion">
        @csrf
        <div class="bg-dark-2 border-radius-10 card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="font-weight-bold">Name</label>
                    <input type="text" name="name" value="{{@$editUser->name}}" class="form-control" placeholder="Enter Name">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="" class="font-weight-bold">Email</label>
                    <input type="text" name="email" value="{{@$editUser->email}}" class="form-control" placeholder="Enter Email">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="" class="font-weight-bold">Phone</label>
                    <input type="text" name="phone" value="{{@$editUser->phone}}" class="form-control" placeholder="Enter phone">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="" class="font-weight-bold">Password</label>
                    <input type="password" name="password" value="{{@$editUser->Password}}" class="form-control" placeholder="Enter password">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="" class="font-weight-bold">Address</label>
                    <input type="text" name="address" value="{{@$editUser->address}}" class="form-control" placeholder="Enter Address">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="" class="font-weight-bold">Select Picture</label>
                    <input type="file" name="image" value="" class="form-control" placeholder="Enter Address">
                </div>
                <div class="col-md-12 text-right">
                    <input type="hidden" name="id" value="{{@$editUser->id}}">
                    <button type="submit" name="" class="btn btn-sm btn-primary px-4">@if(!empty(@$editUser->name)) Save Changes @else Add Now @endif </button>
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
                    <table class="table news-table myTable mb-0" id="accordion2">
                        <tr>
                            <td width="15%" class="font-weight-bold bg-dark-1 border-dark">Name</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Note</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Phone</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Payment Screenshot</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Address</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Wallet #</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark">Remaining Days</td>
                            <td class="text-center font-weight-bold bg-dark-1 border-dark text-center">Action</td>
                        </tr>
                        @if ($users->isNotEmpty())
                            @foreach ($users as $sr => $items)
                                @if ($sr%2)
                                    @php $bgColor = 'bg-dark-2'; @endphp
                                @else
                                    @php $bgColor = 'bg-dark-3'; @endphp
                                @endif
                                <tr class="{{$bgColor}}">
                                    <td class="border-dark">
                                        <a href="{{route('info-user',['id'=>$items->id])}}" class="d-flex users align-items-center text-light">
                                            <div class="img bg-dark-1">
                                                @if (!empty($items->image))
                                                    <img src="{{ asset('storage/'.$items->image)}}" alt="">
                                                @else
                                                    <img src="{{ asset('assets/images/avator.png')}}" alt="">
                                                @endif
                                            </div>
                                            <div class="ml-2">{{$items->name}}</div>
                                        </a>
                                    </td>
                                    <td class="text-center border-dark text" id="heading-{{$items->id}}" data-toggle="collapse" data-target="#collapse-{{$items->id}}" aria-expanded="true" aria-controls="collapse-{{$items->id}}"><i class="fa fa-sticky-note-o"></i></td>
                                    <td class="text-center border-dark">{{$items->phone}}</td>
                                    <td class="text-center border-dark">
                                        @if (!empty($items->UserPayment))
                                            <button type="button" class="btn show-screenshot bg-dark-1 text-white py-1 btn-sm px-4" data-toggle="modal" data-target="#exampleModal" target-id="{{$items->UserPayment->id}}" target-title="{{$items->name}}" target-link="{{ asset('storage/'.$items->UserPayment->screenshot)}}">View Screenshot</button>
                                        @endif
                                    </td>
                                    <td class="text-center border-dark">{{$items->address}}</td>
                                    <td class="text-center border-dark">{{$items->hfm}}</td>
                                    <td class="text-center border-dark">
                                        @if (!empty($items->UserPayment->end_date))
                                            {{CountDays($items->UserPayment->end_date, $items->UserPayment->id)}} Day(s) Remaining 
                                        @endif
                                    </td>
                                    <td class="text-center border-dark text-center">
                                        @if($items->PaymentHistory->isNotEmpty())
                                        <a href="#0" class="btn bg-dark-1 text-white py-1 px-3 btn-sm" data-toggle="modal" data-target="#Payment-history{{$items->id}}">Payment History</a>
                                        <div class="modal fade" id="Payment-history{{$items->id}}" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            @csrf
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content bg-dark-2">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title font-weight-bold text-white">{{$items->name}}</h6>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table news-table mb-0">
                                                            <tr>
                                                                <td width="33%" class="font-weight-bold bg-dark-1 text-white border-dark">Start Date</td>
                                                                <td width="33%" class="text-center font-weight-bold bg-dark-1 text-white border-dark">End Date</td>
                                                                <td width="33%" class="text-center font-weight-bold bg-dark-1 text-white border-dark">Total Days</td>
                                                            </tr>
                                                            @foreach ($items->PaymentHistory as $sr => $history)
                                                                @if ($sr%2)
                                                                    @php $bgColorH = 'bg-dark-2'; @endphp
                                                                @else
                                                                    @php $bgColorH = 'bg-dark-3'; @endphp
                                                                @endif
                                                                <tr>
                                                                    <td width="33%" class="font-weight-bold {{$bgColorH}} text-white border-dark">{{$history->start_date}}</td>
                                                                    <td width="33%" class="text-center font-weight-bold {{$bgColorH}} text-white border-dark">{{$history->end_date}}</td>
                                                                    <td width="33%" class="text-center font-weight-bold {{$bgColorH}} text-white border-dark">{{CountDays($history->end_date, '', $history->start_date)}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm bg-danger text-white border-0 px-3 py-2 btn-sm" id="close-btn" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <a href="{{route('edit-user',['id'=>$items->id])}}" class="btn bg-dark-1 text-white py-2 fa fa-pencil"></a>
                                        <a href="{{route('user-destroy', ['id'=>$items->id])}}" class="btn bg-dark-1 text-danger py-2 fa fa-trash"></a>
                                    </td>
                                </tr>
                                <tr class="collapse" id="collapse-{{$items->id}}" aria-labelledby="heading-{{$items->id}}" data-parent="#accordion2">
                                    <td colspan="8">
                                        <textarea name="note" class="noteTextArea form-control" data-id="{{$items->id}}">{{$items->note}}</textarea>
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
<form method="post" action="{{route('update-payment')}}" class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark-2">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold text-white" id="exampleModalLabel"></h6>
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
                    <div class="col-md-12 mb-3">
                        <input type="hidden" class="form-control" value="" id="updateId" name="id">
                    </div>
                </div>
                <div class="imgbox">
                    <img src="" id="view-img" alt="">
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
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $('.show-screenshot').click(function(){
        $('#updateId').val($(this).attr('target-id'));
        $('#view-img').attr('src',$(this).attr('target-link'))
        $('#exampleModalLabel').text($(this).attr('target-title'))
    })
    $('#close-btn').click(function(){
        $('#video').attr('src', '')
    })
    $(document).ready(function() {
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    $(document).ready(function() {
        $('.noteTextArea').on('keyup', function() {
            var primaryId =  $(this).attr("data-id");
            var note =  $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{route("ajaxUserNote")}}',
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
</script>
@endsection