@extends('layout.app')

@section('content')
    <main>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-5">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0">Dashboard</h1>
                    <div class="small">
                        <span class="fw-500 text-primary">{{\Carbon\Carbon::now()->format('l')}}</span>
                        &middot; {{\Carbon\Carbon::now()->format('F d, Y')}}
                        &middot; <span id="hours">00</span>:<span id="minutes">00</span> <span>{{\Carbon\Carbon::now()->format('A')}}</span>
                    </div>
                </div>
                <!-- Date range picker example-->
                <div class="input-group input-group-joined border-0 shadow" style="width: 16.5rem">
{{--                    <span class="input-group-text"><i data-feather="calendar"></i></span>--}}
{{--                    <span class="form-control ps-0 pointer">{{\Carbon\Carbon::now()->format('F - Y')}}</span>--}}
{{--                    <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range..." />--}}
                </div>
            </div>
{{--            <!-- Illustration dashboard card example-->--}}
{{--            <div class="card card-waves mb-4 mt-5">--}}
{{--                <div class="card-body p-5">--}}
{{--                    <div class="row align-items-center justify-content-between">--}}
{{--                        <div class="col">--}}
{{--                            <h2 class="text-primary">Welcome back, your dashboard is ready!</h2>--}}
{{--                            <p class="text-gray-700">Great job, your affiliate dashboard is ready to go! You can view sales, generate links, prepare coupons, and download affiliate reports using this dashboard.</p>--}}
{{--                            <a class="btn btn-primary p-3" href="#!">--}}
{{--                                Get Started--}}
{{--                                <i class="ms-1" data-feather="arrow-right"></i>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="col d-none d-lg-block mt-xxl-n4"><img class="img-fluid px-xl-4 mt-xxl-n5" src="assets/img/illustrations/statistics.svg" /></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="row">
                <div class="col-xl-4 mb-4">
                    <!-- Dashboard example card 1-->
                    <a class="card lift h-100" href="{{url('clients')}}">
                        <div class="card-body d-flex justify-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="me-3">
                                    <i class="feather-xl text-primary mb-3" data-feather="user"></i>
                                    <h5>Clients</h5>
                                    <div class="text-muted small">There are <span class="text-danger">{{$clientsCount}}</span> active clients</div>
                                </div>
                                <img src="{{asset('assets/img/illustrations/clients2.jpg')}}" alt="..." style="width: 8rem" />
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 mb-4">
                    <!-- Dashboard example card 2-->
                    <a class="card lift h-100" href="{{url('billingFiles')}}">
                        <div class="card-body d-flex justify-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="me-3">
                                    <i class="feather-xl text-secondary mb-3" data-feather="file"></i>
                                    <h5>Billings</h5>
                                    <div class="text-muted small">You have a total of <span class="text-danger">{{$billingsCount}}</span> billings</div>
                                </div>
                                <img src="assets/img/illustrations/windows.svg" alt="..." style="width: 8rem" />
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 mb-4">
                    <!-- Dashboard example card 3-->
                    <a class="card lift h-100" href="{{url('uploadFile')}}">
                        <div class="card-body d-flex justify-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="me-3">
                                    <i class="feather-xl text-green mb-3" data-feather="upload"></i>
                                    <h5>Upload Billings</h5>
                                    <div class="text-muted small">Upload generated pdf now</div>
                                </div>
                                <img src="assets/img/illustrations/upload.jpg" alt="..." style="width: 8rem" />
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Example Colored Cards for Dashboard Demo-->
            <div class="row">
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">{{$month}} Total Billings</div>
                                    <div class="text-lg fw-bold">{{$monthBillings}}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="file-text"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="{{url('billingFiles')}}">View Billings</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Sent Billings</div>
                                    <div class="text-lg fw-bold">{{$sent}}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="check-square"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="{{url('sendBillingSent')}}">View Sent Billings</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Sending</div>

                                    <div class="text-lg fw-bold">{{$sending}}</div>
                                </div>
                                @if($sending == 0)
                                <i class="feather-xl text-white-50" data-feather="send"></i>
                                @else
                                <div class="spinner-border feather-xl text-white-50" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="{{url('sendBillingSending')}}">View Sending Billings</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Sending Failed</div>
                                    <div class="text-lg fw-bold">{{$failed}}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="alert-triangle"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="{{url('sendBillingFailed')}}">View Failed Billings</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/demo/chart-pie-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="js/litepicker.js"></script>
    <script>
        function clock() {
            var hours = document.getElementById("hours");
            var minutes = document.getElementById("minutes");
            var seconds = document.getElementById("seconds");
            var phase = document.getElementById("phase");



            var h = new Date().getHours();
            var m = new Date().getMinutes();
            var s = new Date().getSeconds();
            var am = "AM";

            if (h > 12) {
                h = h - 12;
                var am = "PM";
            }

            h = h < 10 ? "0" + h : h;
            m = m < 10 ? "0" + m : m;
            s = s < 10 ? "0" + s : s;

            hours.innerHTML = h;
            minutes.innerHTML = m;
            seconds.innerHTML = s;
            phase.innerHTML = am;
        }

        var interval = setInterval(clock, 1000);
    </script>
@endsection
