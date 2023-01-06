<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - PhilCom | SoA</title>
    <link href="css/styles.css" rel="stylesheet" />
{{--    <link rel="icon" type="image/x-icon" href="assets/img/send.svg" />--}}
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/email.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body style="
background:rgba(255, 255, 255, 0) url('bg/bg11.png') no-repeat fixed  center top;
background-size:cover;
background-blend-mode: overlay;">

<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container-xl px-4 ">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="text-center">
                            <div class="mt-5 pe-2 justify-content-center">
                                <img src="https://www.philcom.com/images/logo/logo-redfont1.png" alt=""
                                     style="width: 100%; max-width:350px; min-width: 150px;">
                            </div>
                        </div>


                        <!-- Basic login form-->
                        <div class="card shadow-lg border-0 rounded-lg mt-5 bg-light" >
                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="m-1 p-3 text-danger" :errors="$errors" />

{{--                            @if ($errors->any())--}}
{{--                                <div class="alert alert-danger">--}}
{{--                                    <ul>--}}
{{--                                        @foreach ($errors->all() as $error)--}}
{{--                                            <li>{{ $error }}</li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <div class="card-header bg-gray-300 justify-content-center">--}}
{{--                                <img src="https://www.philcom.com/images/logo/logo-redfont1.png" alt="" width="350">--}}
{{--                            </div>--}}
                            <div class="card-body">
                                @if(session()->get('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div><br />
                                @endif
                                <!-- Login form-->
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <!-- Form Group (email address)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                                        <input class="form-control" id="inputEmailAddress" name="email" type="email" placeholder="Enter email address" />
                                    </div>
                                    <!-- Form Group (password)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputPassword">Password</label>
                                        <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Enter password" />
                                    </div>
                                    <!-- Form Group (remember password checkbox)-->
{{--                                    <div class="mb-3">--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" id="remember_me" type="checkbox" name="remember" />--}}
{{--                                            <label class="form-check-label" for="rememberPasswordCheck">Remember password</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- Form Group (login box)-->--}}
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        @if (Route::has('password.request'))
                                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="#">
{{--                                                {{ __('Forgot your password?') }}--}}
                                            </a>
                                        @endif
                                        <input type="submit" class="btn btn-primary" value="Login">
                                    </div>
                                </form>
                            </div>
{{--                            <div class="card-footer text-center">--}}
{{--                                <div class="small"><a href="auth-register-basic.html">Need an account? Sign up!</a></div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="footer-admin mt-auto footer-dark">
            <div class="container-xl px-4">
                <div class="row">
{{--                    <div class="col-md-6 small">Copyright &copy; Your Website 2021</div>--}}
{{--                    <div class="col-md-6 text-md-end small">--}}
{{--                        <a href="#!">Privacy Policy</a>--}}
{{--                        &middot;--}}
{{--                        <a href="#!">Terms &amp; Conditions</a>--}}
{{--                    </div>--}}
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
