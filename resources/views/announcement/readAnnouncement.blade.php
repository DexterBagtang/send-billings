@extends('layout.app')

@section('content')
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            @include('layout.announcementnav')

            <div class="col-md-10">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div onclick="window.location.href='javascript:history.back()'" class="btn btn-sm btn-icon btn-blue-soft mb-4 mx-1">
                                <i data-feather="arrow-left"></i>
                            </div>
{{--                            <div onclick="window.location.href='javascript:history.back()'" class="btn btn-sm btn-icon btn-blue-soft mb-4">--}}
{{--                                <i data-feather="arrow-left"></i>--}}
{{--                            </div>--}}
                        </div>

                        <h3 class="card-title">{{$announcement->subject}}
                            <span class="mailbox-read-time float-end">{{\Carbon\Carbon::parse($announcement->emailDate)->format('d-M. Y h:i A')}}</span>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-4">
                        <div class="mailbox-read-info mb-3">
                            {{--                        <h5>Message Subject Is Placed Here</h5>--}}
                            <h6><a href="mailto:{{$announcement->emailTo}}">
                                    To:  {{$announcement->emailTo}}
                                </a>

                            </h6>
                        </div>
                        <!-- /.mailbox-read-info -->
                        <!--                    <div class="mailbox-controls with-border text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                                                        <i class="fas fa-reply"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                                                        <i class="fas fa-share"></i>
                                                    </button>
                                                </div>
                                                &lt;!&ndash; /.btn-group &ndash;&gt;
                                                <button type="button" class="btn btn-default btn-sm" title="Print">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </div>-->
                        <!-- /.mailbox-controls -->
                        <div class="mailbox-read-message">
                            {!! $announcement->content !!}
                        </div>
                        <!-- /.mailbox-read-message -->
                    </div>
                    <!-- /.card-body -->
                    @if($announcement->attachment != null)
                        <div class="card-footer bg-white">

                            @foreach(json_decode($announcement->attachment) as $file)
                                <div class="m-1">
                                    <a href="{{asset("announcement/$file")}}" class="btn btn-outline-dark" target="_blank"><i
                                            class="fas fa-paperclip"></i>
                                        {{$file}}</a>
                                    <span class="mailbox-attachment-size clearfix mt-1">
                          <a href="{{asset("announcement/$file")}}" class="btn btn-outline-dark" download="{{$file}}"><i
                                  class="fas fa-cloud-download-alt"></i></a>
                        </span>
                                </div>

                            @endforeach
                            <!--                        <li>
                            <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> App Description.docx</a>
                                <span class="mailbox-attachment-size clearfix mt-1">
                          <span>1,245 KB</span>
                          <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                        </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i> photo1.png</a>
                                <span class="mailbox-attachment-size clearfix mt-1">
                          <span>2.67 MB</span>
                          <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                        </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i> photo2.png</a>
                                <span class="mailbox-attachment-size clearfix mt-1">
                          <span>1.9 MB</span>
                          <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                        </span>
                            </div>
                        </li>-->
                        </div>
                    @endif
                    {{--                <!-- /.card-footer -->--}}
                    {{--                <div class="card-footer">--}}
                    {{--                    <div class="float-right">--}}
                    {{--                        <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>--}}
                    {{--                        <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>--}}
                    {{--                    </div>--}}
                    {{--                    <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>--}}
                    {{--                    <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>--}}
                    {{--                </div>--}}
                    {{--                <!-- /.card-footer -->--}}
                </div>
                <!-- /.card -->
            </div>

        </div>
    </div>


@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
@endsection
