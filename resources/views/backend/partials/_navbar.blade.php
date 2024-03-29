@php use App\Constants\VariableConstants; @endphp
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="{{url('/home')}}"><img src="{{asset(url()->to('/').VariableConstants::ROOT_FOLDER.'assets/img/logo_black.png')}}" class="mr-2" alt="logo" style="height: 100px !important;"/></a>
        <a class="navbar-brand brand-logo-mini" href="{{url('/home')}}"><img src="{{asset(url()->to('/').VariableConstants::ROOT_FOLDER.'assets/img/logo_white.jpg')}}" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">

        </ul>
        <ul class="navbar-nav navbar-nav-right">

          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="{{asset(url()->to('/').VariableConstants::ROOT_FOLDER.'backend/assets/images/faces/face28.png')}}" alt="profile"/>
                <span class="nav-profile-name">{{Auth::user()->name}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="ti-power-off text-primary"></i>Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>

            </div>
          </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
