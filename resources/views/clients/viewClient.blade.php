@extends('layout.app')
@section('content')
    <main>
{{--        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">--}}
{{--            <div class="container-xl px-4">--}}
{{--                <div class="page-header-content">--}}
{{--                    <div class="row align-items-center justify-content-between pt-3">--}}
{{--                        <div class="col-auto mb-3">--}}
{{--                            <h1 class="page-header-title">--}}
{{--                                --}}{{--                                <div class="page-header-icon"><i data-feather="upload"></i></div>--}}
{{--                                Remove Client--}}
{{--                            </h1>--}}
{{--                        </div>--}}
{{--                        <div class="col-12 col-xl-auto mb-3"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </header>--}}
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            Details
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session()->get('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div><br>
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST" action="">
                                @csrf
                                <input type="hidden" name="id" value="{{$client->id}}">
                                <div class="col-md-12">
                                    <label for="inputEmail4" class="form-label">Company</label>
                                    <input type="text" name="company" class="form-control" disabled value="{{$client->company}}" id="inputEmail4" row="2">
                                </div>


                                <div class="col-6">
                                    <label for="inputAddress" class="form-label">Account Number</label>
                                    <input type="text" name="account_number" class="form-control" disabled value="{{$client->account_number}}" id="inputAddress" >
                                </div>
                                <div class="col-6">
                                    <label for="inputAddress2" class="form-label">Contract Number</label>
                                    <input type="text" name="contract_number" class="form-control" disabled value="{{$client->contract_number}}" id="inputAddress2">
                                </div>

                                <div class="col-md-12">
                                    <label for="inputPassword4" class="form-label">Email</label>

                                    <ul class="form-control bg-gray-200">
                                        @foreach($emails as $email)
                                            <li class="m-1 p-1">
                                                {{$email}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="col-12">
                                    <div class="float-end">
{{--                                        <button type="submit" class="btn btn-primary">Remove</button>--}}
                                        {{--                                        <a href="javascript:history.back()" class="btn btn-danger">Cancel</a>--}}
                                        <a onclick="window.location.href='javascript:history.back()'" class="btn btn-danger">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection
@section('script')

@endsection
