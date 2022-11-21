<!-- Account page navigation-->
{{--<nav class="nav nav-borders">--}}
{{--    <a class="nav-link {{ (request()->is('compose_announcements')) ? 'active ms-0' : '' }}" href="{{url('compose_announcements')}}">Compose Announcement</a>--}}
{{--    <a class="nav-link {{ (request()->is('announcements')) ? 'active ms-0' : '' }}" href="{{url('announcements')}}"> Announcement</a>--}}
{{--    <a class="nav-link {{ (request()->is('sendingAnnouncement')) ? 'active' : '' }}" href="{{url('sendingAnnouncement')}}">Sending</a>--}}
{{--    <a class="nav-link {{ (request()->is('sentAnnouncement','searchAnnouncement','readAnnouncement*')) ? 'active' : '' }}" href="{{url('sentAnnouncement')}}">Sent</a>--}}
{{--</nav>--}}
{{--<hr class="mt-0 mb-4" />--}}

<div class="col-lg-2">
    <div class="nav-fixed">

        <div class="my-2">
            <a href="{{url('compose_announcements')}}" class="d-grid">
                <div class="btn btn-primary">Compose</div>
            </a>
        </div>

        <div class="card">
            <nav class="sidenav sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav">
                        <a class="nav-link p-3 border {{ (request()->is('announcements')) ? 'active' : '' }}" href="{{url('announcements')}}">
                            <div class="nav-link-icon">
                                <i data-feather="inbox"></i>
                            </div>
                            Announcements
                        </a>

                        <a class="nav-link p-3 border {{ (request()->is('sendingAnnouncement')) ? 'active' : '' }}" href="{{url('sendingAnnouncement')}}">
                            <div class="nav-link-icon">
                                <i data-feather="loader"></i>
                            </div>
                            Sending
                        </a>

                        <a class="nav-link p-3 border {{ (request()->is('sentAnnouncement','searchAnnouncement','readAnnouncement*')) ? 'active' : '' }}" href="{{url('sentAnnouncement')}}">
                            <div class="nav-link-icon">
                                <i data-feather="check-square"></i>
                            </div>
                            Sent
                        </a>

                    </div>
                </div>
                {{--                        <div class="sidenav-footer">SB Sidenav Footer</div>--}}
            </nav>

        </div>


    </div>
</div>
