<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>PhilCom - Billing</title>
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/email.png')}}" />

    @yield('link')
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

</head>
<style>
    html{
        font-size: 12px;
    }
</style>
{{--<body class="nav-fixed" style="/*background-color:rgba(255, 255, 255, .9) ;*/background-image: url('bg/bg.png'); background-blend-mode: overlay; background-position: center; background-size: cover">--}}
<body class="nav-fixed ">
<!-- Navbar -->
@include('layout.navbar')

<!-- Navbar -->

<!-- Sidebar -->
@include('layout.sidebar')
<!-- Sidebar end -->
@if(session()->get('denied'))
        <div class="alert alert-danger m-5">
            <button class="btn-close float-end" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session()->get('denied') }}
        </div><br />
@endif

{{--<x:notify-messages />--}}
        {{--Main Content--}}
        @yield('content')
{{--        User Manual Modal--}}
        <div class="modal fade" id="exampleModalLg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">User Guide</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
{{--                        <embed src="{{asset('userguide.pdf')}}" width="100%" height="600">--}}
                        <object data="{{asset('userguide.pdf')}}" type="application/pdf" width="100%" height="600"></object>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button></div>
                </div>
            </div>
        </div>
{{--        End of User Manual Modal--}}
        {{-- Main Content --}}

        <footer class="footer-admin mt-auto footer-light">
            <div class="container-xl px-4">
                <div class="row">
                    <div class="col-md-6 small"><!--Copyright &copy; Your Website 2021--></div>
                    <div class="col-md-6 text-md-end small">
                        <a href="#!">Privacy Policy</a>
                        &middot;
                        <a href="#!">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{asset('js/scripts.js')}}"></script>
<script src="{{asset('js/toasts.js')}}"></script>
{{--@notifyJs--}}
@yield('script')
</body>
</html>
