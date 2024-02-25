<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            @if(auth()->user()->is_super_admin)
          <li class="nav-item">
            <a class="nav-link" href="{{route('home')}}">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>



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
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.partner.index')}}">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Partner</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.trending.index')}}">
                    <i class="icon-image menu-icon"></i>
                    <span class="menu-title">Trending</span>
                </a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.certificates.index')}}">
                        <i class="icon-file menu-icon"></i>
                        <span class="menu-title">Certificates</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.training.materials.index')}}">
                        <i class="icon-folder menu-icon"></i>
                        <span class="menu-title">Training Materials</span>
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{route('student.certificates.index')}}">
                        <i class="icon-file menu-icon"></i>
                        <span class="menu-title">Certificates</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('student.training.materials.index')}}">
                        <i class="icon-folder menu-icon"></i>
                        <span class="menu-title">Training Materials</span>
                    </a>
                </li>
            @endif
        </ul>
      </nav>
