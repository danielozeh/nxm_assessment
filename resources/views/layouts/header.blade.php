
    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left" style="background-color: #83c324 !important;">
            <div class="text-center">

                <a href="{{ URL('/') }}" class="logo">
                    <img class="small img-fluid" style="padding: 10px;" src="{{ asset('assets/images/naxum.png') }}">
                    <img class="big-logo img-fluid" style="height: 70px;" src="{{ asset('assets/images/naxum.png') }}">
                </a>
            </div>
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <nav class="navbar-custom" style="background-color: #83c324 !important;" >

            <ul class="list-inline float-right mb-0"> 
 
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('assets/images/user.1.png') }}" alt="user" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                    <!-- item-->
                    <div class="dropdown-item noti-title" style="background-color: #83c324 !important;">
                        <h5 class="text-overflow"><small>Welcome! Daniel Ozeh</small> </h5>
                    </div>

                </div>
            </li> 

            </ul>

            <ul class="list-inline menu-left mb-0" >
                <li class="float-left">
                    <button style="background-color: #83c324 !important;" class="button-menu-mobile open-left waves-light waves-effect">
                        <i class="dripicons-menu"></i>
                    </button>
                </li> 
            </ul>

        </nav>

    </div>
    <!-- Top Bar End -->
    @include('layouts.sidenav')



