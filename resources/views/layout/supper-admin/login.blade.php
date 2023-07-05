@extends('admin')
@section('MetaTitle')
<title>Supper Admin Login | Finacial Source</title>
@endsection

@section('styles')

@endsection

@section('content')
<section class=" d-flex login h-100">
    <div class="from-side bg-dark-1">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-md-10">
                <div class="py-5 px-4">
                    <img src="{{ asset('assets/images/logo-here.png') }}" width="200" class="mb-2" alt="">
                    <p class="text-white h6 mb-5">Wellcome to please login to your account.</p>
                    <form action="{{route('admin.login')}}"  method="post">
                        @csrf
                        <label class="d-block mb-3 h6 font-weight-bold text-white">Username</label>
                        <input type="text" name="email" class="form-control mb-4" placeholder="Enter your username">
                        <label class="d-block mb-3 h6 font-weight-bold text-white">Password</label>
                        <input type="password" name="password" class="form-control mb-5" placeholder="Enter your password">
                        {{-- <input type="submit" class="btn bg-blue-dark px-5 text-white" value="Login"> --}}
                        <button type="submit" class="btn bg-blue-dark px-5 text-white">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="background-side">
        <img src="{{ asset('assets/images/Screenshot_1.png') }}" width="100%" alt="">
    </div>
    </section>
@endsection
@section('scripts')

@endsection