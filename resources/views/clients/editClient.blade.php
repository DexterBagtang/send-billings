@extends('layout.app')
@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                {{--                                <div class="page-header-icon"><i data-feather="upload"></i></div>--}}
                                Edit Client
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3"></div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <div class="row">
                {{--                <!-- Sticky Navigation-->--}}
                {{--                <div class="col-lg-4">--}}
                {{--                    <div class="nav-sticky">--}}
                {{--                        <div class="card">--}}
                {{--                            <div class="card-body">--}}
                {{--                                <ul class="nav flex-column fw-bold">--}}
                {{--                                    <li class="nav-item text-uppercase text-danger">Please note !</li>--}}
                {{--                                    <li class="nav-item">- Files must be in pdf file</li>--}}
                {{--                                    <li class="nav-item">- Multiple files can be uploaded</li>--}}
                {{--                                    <li class="nav-item">- Maximum files per upload is 500</li>--}}
                {{--                                    <li class="nav-item">- Please wait until files are uploaded</li>--}}
                {{--                                    <li class="nav-item">- Uploading may take a while</li>--}}
                {{--                                    <li class="nav-item">- instruction 4</li>--}}
                {{--                                </ul>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
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
                            <form class="row g-3" method="POST" action="{{url('editedClient')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$client->id}}">
                                <div class="col-md-12">
                                    <label for="inputEmail4" class="form-label">Company</label>
                                    <input type="text" name="company" class="form-control" value="{{$client->company}}" id="inputEmail4">
                                </div>
{{--                                <div class="col-md-12">--}}
{{--                                    <label for="inputPassword4" class="form-label">Email</label>--}}
{{--                                    <input type="text" class="form-control" name="email" value="{{$client->email}}" id="inputPassword4">--}}
{{--                                </div>--}}
                                <div class="col-md-12">
                                    <label for="inputPassword4" class="form-label">Email <span class="text-danger text-sm fw-bold">(with multiple emails, just add comma(,) in between emails with no spaces)</span></label>
                                    @foreach($emails as $email)
                                    <input type="text" class="form-control m-1" name="email[]" value="{{$email}}" id="inputPassword4">
                                    @endforeach
                                </div>

                                <div class="col-6">
                                    <label for="inputAddress" class="form-label">Account Number</label>
                                    <input type="text" name="account_number" class="form-control" value="{{$client->account_number}}" id="inputAddress" >
                                </div>
                                <div class="col-6">
                                    <label for="inputAddress2" class="form-label">Contract Number</label>
                                    <input type="text" name="contract_number" class="form-control" value="{{$client->contract_number}}" id="inputAddress2">
                                </div>

                                <div class="col-6">
                                    <label for="inputAddress" class="form-label">Incharge</label>
                                    <input type="text" name="incharge" value="{{$client->incharge}}" class="form-control" id="inputAddress" >
                                </div>
                                <div class="col-6">
                                    <label for="inputAddress2" class="form-label">Email Incharge</label>
                                    <input type="text" name="incharge_email" value="{{$client->incharge_email}}" class="form-control" id="inputAddress2">
                                </div>

                                <div class="col-12">
                                    <div class="float-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        {{--                                        <a href="javascript:history.back()" class="btn btn-danger">Cancel</a>--}}
                                        <a onclick="window.location.href='javascript:history.back()'" class="btn btn-danger">Cancel</a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="page" class="p-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection
@section('script')

@endsection
