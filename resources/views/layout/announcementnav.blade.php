<!-- Account page navigation-->
<nav class="nav nav-borders">
    <a class="nav-link {{ (request()->is('announcements')) ? 'active ms-0' : '' }}" href="{{url('announcements')}}">Compose Announcement</a>
    <a class="nav-link" href="account-billing.html">Announcements</a>
    <a class="nav-link {{ (request()->is('sendingAnnouncement')) ? 'active' : '' }}" href="{{url('sendingAnnouncement')}}">Sending</a>
    <a class="nav-link {{ (request()->is('sentAnnouncement')) ? 'active' : '' }}" href="{{url('sentAnnouncement')}}">Sent</a>
</nav>
<hr class="mt-0 mb-4" />
