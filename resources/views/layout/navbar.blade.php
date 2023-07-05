<section class="py-2 topbar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3">
                <img src="{{asset('assets/images/logo-here.png')}}" width="150" alt="">
            </div>
            <div class="col-md-6 text-center">
                <a href="{{route('home')}}" class="text-white topbar-links px-1 heading-fonts text-uppercase {{ (request()->is('home')) ? 'active' : '' }}"><i class="fa fa-home pr-2"></i> Home</a>
                <a href="{{route('user-dashboard')}}" class="px-1 heading-fonts d-inline-block topbar-links text-white text-uppercase ml-4 {{ (request()->is('dashboard')) ? 'active' : '' }}"><i class="fa fa-dashboard pr-2"></i> Indicators</a>
                <a href="{{route('training')}}" class="px-1 d-inline-block topbar-links text-white heading-fonts text-uppercase ml-4 {{ (request()->is('training')) ? 'active' : '' }}"><i class="fa fa-television pr-2"></i> Course</a>
                <a href="{{route('account')}}" class="px-1 d-inline-block topbar-links text-white heading-fonts text-uppercase ml-4 {{ (request()->is('account')) ? 'active' : '' }}"><i class="fa fa-user-circle-o pr-2"></i> Account</a>
                <a href="{{route('user-Logout')}}" class="px-1 d-inline-block topbar-links text-white heading-fonts text-uppercase ml-4 {{ (request()->is('logout')) ? 'active' : '' }}"><i class="fa fa-sign-out pr-2"></i> Logout</a>
            </div>
        </div>
    </div>
</section>