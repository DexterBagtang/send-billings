{{--<nav class="topnav navbar navbar-expand shadow-lg justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">--}}
    <nav class="topnav navbar navbar-expand  justify-content-between justify-content-sm-start navbar-light bg-info-soft bg-gradient" id="sidenavAccordion">

    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
{{--    <a class="navbar-brand pe-3 ps-4 ps-lg-1 text-center text-black" style="font-size: 20px" href="{{url('/')}}"> Phil <span class=" text-black bg-yellow p-1 border-round" style="border-radius: 5px">Com</span>--}}
{{--    <a class="navbar-brand pe-3 ps-4 ps-lg-1 text-center text-black " style="font-size: 20px; font-family: 'Segoe UI Black',serif" href="{{url('/')}}">--}}
{{--        <span class="fw-100">PhilCom SoA</span>--}}
{{--    <a class="navbar-brand ms-2 pe-3 ps-4 ps-lg-2 display-6" href="{{url('/')}}">PhilCom SoA <i data-feather="mail"></i> </a>--}}
    <a href="{{url('/')}}" class="ms-2">
        <img src="{{asset('logo3.png')}}" alt="" width="155">
    </a>

        {{--        <h2 class="text-white" style="font-size: 30px; font-family:'Berlin Sans FB',serif">Phil <p>Com</p> </h2>--}}
{{--        <div class="small" style="font-size: small; font-weight: lighter">Billing System</div>--}}
    </a>
{{--    <a  href="{{'/'}}">--}}
{{--        <img class="pe-3 ps-4 ps-lg-2" src="{{asset('assets/img/logo2.png')}}" alt=""  width="200">--}}
{{--    </a>--}}

    <!-- Navbar Search Input-->
    <!-- * * Note: * * Visible only on and above the lg breakpoint-->
{{--    <form class="form-inline me-auto d-none d-lg-block me-3">--}}
{{--        <div class="input-group input-group-joined input-group-solid">--}}
{{--            <input class="form-control pe-0" type="search" placeholder="Search" aria-label="Search" />--}}
{{--            <div class="input-group-text"><i data-feather="search"></i></div>--}}
{{--        </div>--}}
{{--    </form>--}}
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">
{{--        <!-- Documentation Dropdown-->--}}
{{--        <li class="nav-item dropdown no-caret d-none d-md-block me-3">--}}
{{--            <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                <div class="fw-500">Documentation</div>--}}
{{--                <i class="fas fa-chevron-right dropdown-arrow"></i>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-end py-0 me-sm-n15 me-lg-0 o-hidden animated--fade-in-up" aria-labelledby="navbarDropdownDocs">--}}
{{--                <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro" target="_blank">--}}
{{--                    <div class="icon-stack bg-primary-soft text-primary me-4"><i data-feather="book"></i></div>--}}
{{--                    <div>--}}
{{--                        <div class="small text-gray-500">Documentation</div>--}}
{{--                        Usage instructions and reference--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--                <div class="dropdown-divider m-0"></div>--}}
{{--                <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/components" target="_blank">--}}
{{--                    <div class="icon-stack bg-primary-soft text-primary me-4"><i data-feather="code"></i></div>--}}
{{--                    <div>--}}
{{--                        <div class="small text-gray-500">Components</div>--}}
{{--                        Code snippets and reference--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--                <div class="dropdown-divider m-0"></div>--}}
{{--                <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/changelog" target="_blank">--}}
{{--                    <div class="icon-stack bg-primary-soft text-primary me-4"><i data-feather="file-text"></i></div>--}}
{{--                    <div>--}}
{{--                        <div class="small text-gray-500">Changelog</div>--}}
{{--                        Updates and changes--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </li>--}}
        <!-- Navbar Search Dropdown-->
        <!-- * * Note: * * Visible only below the lg breakpoint-->
        <li class="nav-item dropdown no-caret me-3 d-lg-none">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="searchDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="search"></i></a>
            <!-- Dropdown - Search-->
            <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--fade-in-up" aria-labelledby="searchDropdown">
                <form class="form-inline me-auto w-100">
                    <div class="input-group input-group-joined input-group-solid">
                        <input class="form-control pe-0" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                        <div class="input-group-text"><i data-feather="search"></i></div>
                    </div>
                </form>
            </div>
        </li>
<!--        &lt;!&ndash; Alerts Dropdown&ndash;&gt;
        <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" d
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="bell"></i> &lt;!&ndash;<span class="badge bg-red text-white">5</span>&ndash;&gt;</a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated&#45;&#45;fade-in-up" aria-labelledby="navbarDropdownAlerts">
                <h6 class="dropdown-header dropdown-notifications-header">
                    <i class="me-2" data-feather="bell"></i>
                    Alerts Center
                </h6>
                &lt;!&ndash; Example Alert 1&ndash;&gt;
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">December 29, 2021</div>
                        <div class="dropdown-notifications-item-content-text">This is an alert message. It's nothing serious, but it requires your attention.</div>
                    </div>
                </a>
                &lt;!&ndash; Example Alert 2&ndash;&gt;
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-info"><i data-feather="bar-chart"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">December 22, 2021</div>
                        <div class="dropdown-notifications-item-content-text">A new monthly report is ready. Click here to view!</div>
                    </div>
                </a>
                &lt;!&ndash; Example Alert 3&ndash;&gt;
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">December 8, 2021</div>
                        <div class="dropdown-notifications-item-content-text">Critical system failure, systems shutting down.</div>
                    </div>
                </a>
                &lt;!&ndash; Example Alert 4&ndash;&gt;
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-success"><i data-feather="user-plus"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">December 2, 2021</div>
                        <div class="dropdown-notifications-item-content-text">New user request. Woody has requested access to the organization.</div>
                    </div>
                </a>
                <a class="dropdown-item dropdown-notifications-footer" href="#!">View All Alerts</a>
            </div>
        </li>
        &lt;!&ndash; Messages Dropdown&ndash;&gt;
        <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="mail"></i></a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated&#45;&#45;fade-in-up" aria-labelledby="navbarDropdownMessages">
                <h6 class="dropdown-header dropdown-notifications-header">
                    <i class="me-2" data-feather="mail"></i>
                    Message Center
                </h6>
                &lt;!&ndash; Example Message 1  &ndash;&gt;
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <img class="dropdown-notifications-item-img" src="assets/img/illustrations/profiles/profile-2.png" />
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                        <div class="dropdown-notifications-item-content-details">Thomas Wilcox ?? 58m</div>
                    </div>
                </a>
                &lt;!&ndash; Example Message 2&ndash;&gt;
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <img class="dropdown-notifications-item-img" src="assets/img/illustrations/profiles/profile-3.png" />
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                        <div class="dropdown-notifications-item-content-details">Emily Fowler ?? 2d</div>
                    </div>
                </a>
                &lt;!&ndash; Example Message 3&ndash;&gt;
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <img class="dropdown-notifications-item-img" src="assets/img/illustrations/profiles/profile-4.png" />
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                        <div class="dropdown-notifications-item-content-details">Marshall Rosencrantz ?? 3d</div>
                    </div>
                </a>
                &lt;!&ndash; Example Message 4&ndash;&gt;
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <img class="dropdown-notifications-item-img" src="assets/img/illustrations/profiles/profile-5.png" />
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                        <div class="dropdown-notifications-item-content-details">Colby Newton ?? 3d</div>
                    </div>
                </a>
                &lt;!&ndash; Footer Link&ndash;&gt;
                <a class="dropdown-item dropdown-notifications-footer" href="#!">Read All Messages</a>
            </div>
        </li>-->
        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-primary dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
{{--                <img class="img-fluid" src="{{asset('assets/img/johnny.webp')}}" />--}}
                @if(\Illuminate\Support\Facades\Auth::user()->profile_picture == null)
                    <img class="img-fluid" src="{{asset('assets/img/illustrations/profiles/profile-2.png')}}" />
                @else
                    <img class="img-fluid" src="{{asset('profile/'. \Illuminate\Support\Facades\Auth::user()->profile_picture)}}" />
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    @if(\Illuminate\Support\Facades\Auth::user()->profile_picture == null)
                        <img class="dropdown-user-img" src="{{asset('assets/img/illustrations/profiles/profile-2.png')}}" alt="#">
                    @else
                        <img class="dropdown-user-img" src="{{asset('profile/'. \Illuminate\Support\Facades\Auth::user()->profile_picture)}}" alt="#">
                    @endif
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                        <div class="dropdown-user-details-email">{{\Illuminate\Support\Facades\Auth::user()->email}}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('account')}}">
                    <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                    Account
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item" href="#!" onclick="event.preventDefault();this.closest('form').submit();">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Logout
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
