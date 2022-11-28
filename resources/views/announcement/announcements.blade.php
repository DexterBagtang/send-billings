@extends('layout.app')
@section('link')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection
@section('content')
    <style>
        .custom-file-button input[type=file] {
            margin-left: -2px !important;
        }

        .custom-file-button input[type=file]::-webkit-file-upload-button {
            display: none;
        }

        .custom-file-button input[type=file]::file-selector-button {
            display: none;
        }

        .custom-file-button:hover label {
            background-color: #dde0e3;
            cursor: pointer;
        }
    </style>
    <main>
{{--        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">--}}
{{--            <div class="container-xl px-4">--}}
{{--                <div class="page-header-content">--}}
{{--                    <div class="row align-items-center justify-content-between pt-3">--}}
{{--                        <div class="col-auto mb-3">--}}
{{--                            <h1 class="page-header-title">--}}
{{--                                <div class="page-header-icon"><i data-feather="user"></i></div>--}}
{{--                                Account Settings - Profile--}}
{{--                            </h1>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </header>--}}
        <!-- Main page content-->
        <div class="container-fluid px-4 mt-4">


{{--                @include('layout.announcementnav')--}}

            <div class="row">
                {{-- Email Blast side bar --}}
                @include('layout.announcementnav')
                {{--End of email blase side bar --}}
{{--                <div class="col-xl-2">--}}
{{--                    <!-- Profile picture card-->--}}
{{--                    <div class="card mb-4 mb-xl-0">--}}
{{--                        <div class="card-header">Profile Picture</div>--}}
{{--                        <div class="card-body text-center">--}}
{{--                            <a class="nav-link {{(request()->is('sendBillingFiles','searchSend')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('sendBillingFiles')}}">--}}
{{--                                <div class="nav-link-icon text-primary"><i data-feather="mail"></i> Send SoA</div>--}}
{{--                                Send SoA--}}
{{--                            </a>--}}

{{--                            <!-- Sidenav Link (Sent Billings) -->--}}
{{--                            <a class="nav-link {{(request()->is('sendBillingSent','sendBillingSentPost*','searchSent')) ? 'active border bg-primary-soft rounded-pill' : ''}}" href="{{url('sendBillingSent')}}">--}}
{{--                                <div class="nav-link-icon text-success"><i data-feather="check-circle"></i></div>--}}
{{--                                Sent--}}
{{--                                --}}{{--                        <span class="badge bg-danger text-white ms-2 text-xs">{{$finalcountsent}}</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-xl-10">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br />
                    @endif


                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}
                                        <button class="btn-close float-end" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Account details card-->
                    <form method="post" action="{{url('sendAnnouncement')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card mb-4">
                            <div class="card-header">Compose Announcement</div>
                            <div class="card-body">
                                <div class="input-group mb-1">
                                    <label class="input-group-text">To:</label>
                                    {{--                                    <input type="text" class="form-control" aria-label="With textarea">--}}
                                    <select class="form-select" id="inputGroupSelect01" readonly="readonly">
                                        <option selected>All...</option>
                                        @foreach($clients as $client)
                                            <option value="1" disabled>{{$client->company}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">Subject:</span>
                                    <input type="text" class="form-control" name="subject" value="{{old('subject')}}" aria-label="With textarea" required>
                                </div>
                                {{--                                            <div class="row mb-3">--}}
                                {{--                                                <div class="col-sm-3">--}}
                                {{--                                                    <div class="input-group custom-file-button">--}}
                                {{--                                                        <label class="input-group-text" for="inputGroupFile"><i class="fas fa-paperclip"> </i> Attach</label>--}}
                                {{--                                                        <input type="file" class="form-control" id="inputGroupFile">--}}
                                {{--                                                    </div>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}

                                <div class="form-group mb-3">
                                    <label class="col-sm-2 col-form-label">Message:</label>
                                    <textarea class="summernote" name="message" required>

                                    </textarea>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <div class="input-group custom-file-button">
                                            <label class="input-group-text" for="inputGroupFile"><i
                                                    class="fas fa-paperclip"> </i> Attachment</label>
                                            <input type="file" class="form-control" id="inputGroupFile"
                                                   name="attachments[]" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @if($sendings > 0)
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog ">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Unable to send !</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div>Statements of account are still sending at this moment, You're able to send this after all the SoA are processed.</div>
                                                </div>
                                                <div class="modal-footer">
                                                    {{--                                        <input type="submit" class="btn btn-primary" value="Send Now">--}}
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Send Now
                                    </button>
                                @else
                                <input type="submit" class="btn btn-primary" value="Send Now">
                                @endif
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
                // fontNames:['Arial','Calibri'],
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript','family']],
                    // ['fontname',['fontname']],
                    // ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                ]
            });
        });
    </script>
@endsection
