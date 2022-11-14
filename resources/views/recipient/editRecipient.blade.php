@extends('layout.app')

@section('content')
    <main>

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
                            <div>Edit Recipient</div>
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
                            <form class="row g-3" method="POST" action="{{url('updateRecipient')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$recipient->id}}">
                                <div class="col-md-12">
                                    <label for="inputEmail4" class="form-label">Company</label>
                                    <input type="text" name="company" class="form-control" value="{{$recipient->recipient_name}}" id="inputEmail4">
                                </div>
                                <div class="col-md-12">
                                    <label for="inputPassword4" class="form-label">Email <!--<span class="text-danger text-sm fw-bold">(with multiple emails, just add comma(,) in between emails with no spaces)</span>--></label>
                                    <input type="text" class="form-control" name="email" value="{{$recipient->recipient_email}}" id="inputPassword4">
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
    </main>
@endsection
