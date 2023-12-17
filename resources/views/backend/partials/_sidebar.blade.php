<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="{{route('home')}}">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">--}}
{{--                    <i class="icon-layout menu-icon"></i>--}}
{{--                    <span class="menu-title">Training Session</span>--}}
{{--                    <i class="menu-arrow"></i>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="ui-basic">--}}
{{--                    <ul class="nav flex-column sub-menu">--}}
{{--                        <li class="nav-item"> <a class="nav-link" href="{{route('admin.training.session.create')}}">Add Session</a></li>--}}
{{--                        <li class="nav-item"> <a class="nav-link" href="{{route('admin.training.session')}}">All Session</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.service.index')}}">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Services</span>
                </a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('admin.training.session.create')}}">--}}
{{--                    <i class="icon-head menu-icon"></i>--}}
{{--                    <span class="menu-title">Add Session</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.training.session')}}">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">All Sessions </span>
                </a>
            </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.student.index')}}">
                <i class="icon-head menu-icon"></i>
              <span class="menu-title">Student List</span>
            </a>
          </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.contact.us')}}">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Contact Us</span>
                </a>
            </li>
        </ul>
      </nav>
