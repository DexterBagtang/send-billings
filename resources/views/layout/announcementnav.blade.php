
<div class="col-lg-2">
    <div class="nav-fixed">

        @if(\Illuminate\Support\Facades\Auth::user()->roles_id <= 2 )
        <div class="my-2">
            <a href="{{url('compose_announcements')}}" class="d-grid">
                <div class="btn btn-primary lift-sm">Compose</div>
            </a>
        </div>
        @endif

        <div class="card">
            <nav class="sidenav sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav">
                        <a class="nav-link p-3 border {{ (request()->is('announcements')) ? 'bg-primary-soft' : '' }}" href="{{url('announcements')}}">
                            <div class="nav-link-icon">
                                <i data-feather="inbox"></i>
                            </div>
                            Announcements
                        </a>

                        <a class="nav-link p-3 border {{ (request()->is('sendingAnnouncement')) ? 'bg-primary-soft' : '' }}" href="{{url('sendingAnnouncement')}}">

                            @if($blasting > 0)
                                <div class="nav-link-icon spinner-grow spinner-grow-sm text-warning" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            @else
                                <div class="nav-link-icon">
                                    <i data-feather="loader"></i>
                                </div>
                            @endif
                            Sending
                        </a>

                        <a class="nav-link p-3 border {{ (request()->is('sentAnnouncement','readAnnouncement*')) ? 'bg-primary-soft' : '' }}" href="{{url('sentAnnouncement')}}">
                            <div class="nav-link-icon">
                                <i data-feather="check-square"></i>
                            </div>
                            Sent
                        </a>

                        <a class="nav-link p-3 border {{ (request()->is('failedAnnouncement','','')) ? 'bg-primary-soft' : '' }}" href="{{url('failedAnnouncement')}}">
                            <div class="nav-link-icon">
                                <i data-feather="x-circle"></i>
                            </div>
                            Failed
                        </a>
                    </div>
                </div>
                {{--                        <div class="sidenav-footer">SB Sidenav Footer</div>--}}
            </nav>
        </div>
    </div>
</div>
