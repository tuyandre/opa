<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            @if(auth()->user()->is_super_admin)
          <span class="nav-section-label">Overview</span>
          <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('home')}}">
              <i class="mdi mdi-view-dashboard menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>

          <span class="nav-section-label">Training</span>
            <li class="nav-item {{ request()->routeIs('admin.service.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.service.index')}}">
                    <i class="mdi mdi-widgets menu-icon"></i>
                    <span class="menu-title">Services</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.training.session*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.training.session')}}">
                    <i class="mdi mdi-calendar-clock menu-icon"></i>
                    <span class="menu-title">All Sessions </span>
                </a>
            </li>
          <li class="nav-item {{ request()->routeIs('admin.student.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('admin.student.index')}}">
                <i class="mdi mdi-account-multiple menu-icon"></i>
              <span class="menu-title">Student List</span>
            </a>
          </li>
                <li class="nav-item {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('admin.certificates.index')}}">
                        <i class="mdi mdi-certificate menu-icon"></i>
                        <span class="menu-title">Certificates</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.training.materials.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('admin.training.materials.index')}}">
                        <i class="mdi mdi-folder-multiple menu-icon"></i>
                        <span class="menu-title">Training Materials</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.assessments.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('admin.assessments.index')}}">
                        <i class="mdi mdi-clipboard-check-outline menu-icon"></i>
                        <span class="menu-title">Assessments</span>
                    </a>
                </li>

          <span class="nav-section-label">Content</span>
            <li class="nav-item {{ request()->routeIs('admin.contact.us*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.contact.us')}}">
                    <i class="mdi mdi-email-outline menu-icon"></i>
                    <span class="menu-title">Contact Us</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.partner.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.partner.index')}}">
                    <i class="mdi mdi-handshake menu-icon"></i>
                    <span class="menu-title">Partner</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.trending.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.trending.index')}}">
                    <i class="mdi mdi-trending-up menu-icon"></i>
                    <span class="menu-title">Trending</span>
                </a>
            </li>
                <li class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('admin.gallery.index')}}">
                        <i class="mdi mdi-image-multiple menu-icon"></i>
                        <span class="menu-title">Galleries</span>
                    </a>
                </li>

          <span class="nav-section-label">Clients</span>
            <li class="nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.clients.index')}}">
                    <i class="mdi mdi-domain menu-icon"></i>
                    <span class="menu-title">Clients</span>
                </a>
            </li>

          <span class="nav-section-label">Documents</span>
            <li class="nav-item {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.documents.index')}}">
                    <i class="mdi mdi-file-document-box-multiple menu-icon"></i>
                    <span class="menu-title">Company Documents</span>
                </a>
            </li>

          <span class="nav-section-label">Administration</span>
            <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.users.index')}}">
                    <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.roles.index')}}">
                    <i class="mdi mdi-shield-account menu-icon"></i>
                    <span class="menu-title">Roles</span>
                </a>
            </li>
                @elseif(is_null(auth()->user()->student_id))
                    {{-- Staff account (no student_id, not super admin): sidebar driven by permissions --}}
                    <span class="nav-section-label">Overview</span>
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('home')}}">
                            <i class="mdi mdi-view-dashboard menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    @if(auth()->user()->can('manage-services') || auth()->user()->can('manage-sessions') || auth()->user()->can('manage-students') || auth()->user()->can('manage-certificates') || auth()->user()->can('manage-materials') || auth()->user()->can('manage-assessments'))
                        <span class="nav-section-label">Training</span>
                        @can('manage-services')
                            <li class="nav-item {{ request()->routeIs('admin.service.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.service.index')}}">
                                    <i class="mdi mdi-widgets menu-icon"></i>
                                    <span class="menu-title">Services</span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-sessions')
                            <li class="nav-item {{ request()->routeIs('admin.training.session*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.training.session')}}">
                                    <i class="mdi mdi-calendar-clock menu-icon"></i>
                                    <span class="menu-title">All Sessions</span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-students')
                            <li class="nav-item {{ request()->routeIs('admin.student.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.student.index')}}">
                                    <i class="mdi mdi-account-multiple menu-icon"></i>
                                    <span class="menu-title">Student List</span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-certificates')
                            <li class="nav-item {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.certificates.index')}}">
                                    <i class="mdi mdi-certificate menu-icon"></i>
                                    <span class="menu-title">Certificates</span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-materials')
                            <li class="nav-item {{ request()->routeIs('admin.training.materials.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.training.materials.index')}}">
                                    <i class="mdi mdi-folder-multiple menu-icon"></i>
                                    <span class="menu-title">Training Materials</span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-assessments')
                            <li class="nav-item {{ request()->routeIs('admin.assessments.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.assessments.index')}}">
                                    <i class="mdi mdi-clipboard-check-outline menu-icon"></i>
                                    <span class="menu-title">Assessments</span>
                                </a>
                            </li>
                        @endcan
                    @endif

                    @if(auth()->user()->can('manage-contact-us') || auth()->user()->can('manage-partners') || auth()->user()->can('manage-trending') || auth()->user()->can('manage-galleries'))
                        <span class="nav-section-label">Content</span>
                        @can('manage-contact-us')
                            <li class="nav-item {{ request()->routeIs('admin.contact.us*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.contact.us')}}">
                                    <i class="mdi mdi-email-outline menu-icon"></i>
                                    <span class="menu-title">Contact Us</span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-partners')
                            <li class="nav-item {{ request()->routeIs('admin.partner.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.partner.index')}}">
                                    <i class="mdi mdi-handshake menu-icon"></i>
                                    <span class="menu-title">Partner</span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-trending')
                            <li class="nav-item {{ request()->routeIs('admin.trending.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.trending.index')}}">
                                    <i class="mdi mdi-trending-up menu-icon"></i>
                                    <span class="menu-title">Trending</span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-galleries')
                            <li class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.gallery.index')}}">
                                    <i class="mdi mdi-image-multiple menu-icon"></i>
                                    <span class="menu-title">Galleries</span>
                                </a>
                            </li>
                        @endcan
                    @endif

                    @can('view-clients')
                        <span class="nav-section-label">Clients</span>
                        <li class="nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{route('admin.clients.index')}}">
                                <i class="mdi mdi-domain menu-icon"></i>
                                <span class="menu-title">Clients</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage-documents')
                        <span class="nav-section-label">Documents</span>
                        <li class="nav-item {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{route('admin.documents.index')}}">
                                <i class="mdi mdi-file-document-box-multiple menu-icon"></i>
                                <span class="menu-title">Company Documents</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage-users')
                        <span class="nav-section-label">Administration</span>
                        <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{route('admin.users.index')}}">
                                <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                                <span class="menu-title">Users</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{route('admin.roles.index')}}">
                                <i class="mdi mdi-shield-account menu-icon"></i>
                                <span class="menu-title">Roles</span>
                            </a>
                        </li>
                    @endcan
                @else
                <li class="nav-item {{ request()->routeIs('student.certificates.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('student.certificates.index')}}">
                        <i class="mdi mdi-certificate menu-icon"></i>
                        <span class="menu-title">Certificates</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('student.training.materials.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('student.training.materials.index')}}">
                        <i class="mdi mdi-folder-multiple menu-icon"></i>
                        <span class="menu-title">Training Materials</span>
                    </a>
                </li>
            @endif
        </ul>
      </nav>
