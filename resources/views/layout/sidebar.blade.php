
<div id="layoutSidenav">
{{--    <meta http-equiv="refresh" content="30">--}}
    <div id="layoutSidenav_nav">
        <nav class="sidenav shadow-right-lg sidenav-light">

            <div class="sidenav-menu">
                <div class="nav accordion m-1" id="accordionSidenav">

                    <div class="sidenav-menu-heading">File</div>
                    <!-- Sidenav Link (Tables)-->
                    <a class="nav-link  {{(request()->is('clients','duplicateClient',"*Client*")) ? 'active bg-primary-soft rounded-pill' : ''}}" href="{{url('clients')}}">
                        <div class="nav-link-icon text-info"><i data-feather="users"></i></div>
                        Clients
                    </a>

                    @if(\Illuminate\Support\Facades\Auth::user()->roles_id <= 2 )
                    <!-- Sidenav Link (Upload File)-->
                    <a class="nav-link  {{(request()->is('uploadFile')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('uploadFile')}}">
                        <div class="nav-link-icon text-success"><i data-feather="upload"></i></div>
                        Upload SoA
                    </a>
                    @endif

                    <!-- Sidenav Link (Files) -->
                    <a class="nav-link {{(request()->is("uploadedFiles","viewUploadedFiles*")) ? 'active bg-primary-soft rounded-pill' : ''}}" href="{{url('uploadedFiles')}}">
                        <div class="nav-link-icon text-warning"><i data-feather="folder"></i></div>
                        View Uploads
                    </a>

                    <!-- Sidenav Link (Billing Files) -->
                    <a class="nav-link {{(request()->is('billingFiles','billingUnknown','billingDuplicate',"viewDuplicate*",
                            "billingRemoved","billingSearch*",'unknownSearch','duplicateSearch','removedSearch')) ? 'active bg-primary-soft rounded-pill' : ''}}" href="{{url('billingFiles')}}">
                        <div class="nav-link-icon text-secondary"><i data-feather="file-text"></i></div>
                        Uploaded SoA
                    </a>

                    <div class="sidenav-menu-heading">Email</div>

                    @if(\Illuminate\Support\Facades\Auth::user()->roles_id <= 2 )
                    <!-- Sidenav Link (Send Billings) -->
                    <a class="nav-link {{(request()->is('sendBillingFiles','searchSend')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('sendBillingFiles')}}">
                        <div class="nav-link-icon text-primary"><i data-feather="mail"></i></div>
                        Send SoA
                    </a>
                    @endif

                    <!-- Sidenav Link (Sent Billings) -->
                    <a class="nav-link {{(request()->is('sendBillingSent','sendBillingSentPost*','searchSent')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('sendBillingSent')}}">
                        <div class="nav-link-icon text-success"><i data-feather="check-circle"></i></div>
                        Sent
{{--                        <span class="badge bg-danger text-white ms-2 text-xs">{{$finalcountsent}}</span>--}}
                    </a>

                    <!-- Sidenav Link (Sending Billings) -->
                    <a class="nav-link {{(request()->is('sendBillingSending','searchSending')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('sendBillingSending')}}">
                        <div class="nav-link-icon text-warning"><i data-feather="send"></i></div>
                        <div>Sending </div>
                        @if($sendings > 0 )
                        <div class="sidenav-collapse-arrow">
                            <span class="spinner-border spinner-border-sm text-xs text-danger" role="status"></span>
                        </div>
                        @endif
                    </a>

                    <!-- Sidenav Link (Failed) -->
                    <a class="nav-link {{(request()->is('sendBillingFailed','searchFailed')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('sendBillingFailed')}}">
                        <div class="nav-link-icon text-danger"><i data-feather="alert-triangle"></i></div>
                        Failed
                    </a>

                    @if($resend > 0 )
                    <a class="nav-link {{(request()->is('resendBillingFiles')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('resendBillingFiles')}}">
                        <div class="nav-link-icon text-danger"><i data-feather="repeat"></i></div>
                        Resend Failed SoA
                    </a>
                    @endif

                    <div class="sidenav-menu-heading">Announcement</div>
                    <a class="nav-link {{(request()->is('*announcement*','*Announcement*')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('announcements')}}">
                        <div class="nav-link-icon text-cyan"><i class="fas fa-bullhorn"></i></div>
                        Email Blasting
                    </a>

{{--                    <!-- Sidenav Accordion (Flows)-->--}}
{{--                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">--}}
{{--                        <div class="nav-link-icon text-secondary"><i data-feather="alert-octagon"></i></div>--}}
{{--                        Announcements--}}
{{--                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
{{--                    </a>--}}
{{--                    <div class="collapse {{(request()->is('recipients','addRecipient')) ? 'show' : ''}}" id="collapseFlows" data-bs-parent="#accordionSidenav">--}}
{{--                        <nav class="sidenav-menu-nested nav">--}}
{{--                            <a class="nav-link" href="multi-tenant-select.html">Send Announcements</a>--}}
{{--                            <a class="nav-link {{(request()->is('recipients','addRecipient')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('recipients')}}">Recipients</a>--}}
{{--                        </nav>--}}
{{--                    </div>--}}



                    @if(\Illuminate\Support\Facades\Auth::user()->roles_id <= 2 )

                    <div class="sidenav-menu-heading">Admin</div>

                    <a class="nav-link {{(request()->is('users')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('users')}}">
                        <div class="nav-link-icon text-dark"><i data-feather="user-check"></i></div>
                        Users
                    </a>
                    @endif
                </div>
            </div>
            <!-- Sidenav Footer-->
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Logged in as:</div>
                    <div class="sidenav-footer-title">{{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
