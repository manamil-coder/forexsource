@extends('main')
@section('MetaTitle')
    <title>Profile | Finacial Source</title>
@endsection
@section('styles')

@endsection
@section('content')
<section class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" enctype="multipart/form-data" action="{{route('profile-update')}}" class="row">
                @csrf
                <div class="col-md-6 mb-3">
                    <label for="" class="text-white mb-0 font-weight-bold">Name</label>
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="Enter your name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="" class="text-white mb-0 font-weight-bold">Email</label>
                    <input type="text" name="email" value="{{$user->email}}" readonly class="form-control" placeholder="Enter your email">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="" class="text-white mb-0 font-weight-bold">Phone</label>
                    <input type="text" name="phone" value="{{$user->phone}}" class="form-control" placeholder="Enter your phone">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="" class="text-white mb-0 font-weight-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="" class="text-white mb-0 font-weight-bold">Address</label>
                    <input type="text" name="address" value="{{$user->address}}" class="form-control" placeholder="Enter your address">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="" class="text-white mb-0 font-weight-bold">Select Profile Picture</label>
                    <input type="file" name="image" class="form-control" placeholder="Enter Profile Piture">
                </div>
                <div class="col-md-12 text-right">
                    <input type="submit" value="Save Changes" class="btn btn-block bg-dark text-white">
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
@endsection
