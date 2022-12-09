@extends('layout.app')

@section('content')
    <div class="container-fluid px-4 mt-4">
        <div class="row">
{{--            @include('layout.announcementnav')--}}

            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10">
                                <div onclick="window.location.href='javascript:history.back()'" class="btn btn-sm btn-icon btn-blue-soft mb-4 mx-1">
                                    <i data-feather="arrow-left"></i>
                                </div>
{{--                                <div onclick="window.location.href='javascript:history.back()'" class="btn btn-sm btn-icon btn-blue-soft mb-4">--}}
{{--                                    <i data-feather="arrow-left"></i>--}}
{{--                                </div>--}}
                            </div>
                            <div class="col-2">
                                @if($billing->emailStatus == 'sending')
                                    <div class="text-gray-700 float-end">Pending</div>
                                @else
                                    <div class="text-gray-700 float-end">{{\Carbon\Carbon::parse($billing->emailDate)->format('d-M. Y h:i A')}}</div>
                                @endif
                            </div>
                        </div>

                        <h3 class="card-title">{{$billing->subject}}

                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-4">
                        <div class="mailbox-read-info mb-3">
                            {{--                        <h5>Message Subject Is Placed Here</h5>--}}
                            <h6>To:  {{$billing->company}}
                                <a href="mailto:{{$billing->email}}">
                                    <div class="small ms-1 fw-light">{{$billing->email}}</div>
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
                            {!! $billing->contents !!}
                        </div>
                        <!-- /.mailbox-read-message -->
                    </div>
                    <!-- /.card-body -->

                        <div class="card-footer bg-white">
                            <div class="m-1">
                                <a href="{{asset('billing_files/'.$billing->month.'-'.$billing->year.'/'.$billing->storedFile)}}" class="btn btn-outline-dark" target="_blank">
                                    <i class="fas fa-paperclip"></i>
                                    {{$billing->filename}}</a>
                                <span class="mailbox-attachment-size clearfix mt-1">
                          <a href="{{asset('billing_files/'.$billing->month.'-'.$billing->year.'/'.$billing->storedFile)}}" class="btn btn-outline-dark" download="{{$billing->filename}}"><i
                                  class="fas fa-download"></i></a>
                        </span>
                            </div>
                            @if($billing->attachment != '[null]')
                                @foreach(json_decode($billing->attachment) as $file)
                                    <div class="m-1">
                                        <a href="{{asset("attachments/$file")}}" class="btn btn-outline-dark" target="_blank">
                                            <i class="fas fa-paperclip"></i>
                                            {{$file}}</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                          <a href="{{asset("attachments/$file")}}" class="btn btn-outline-dark" download="{{$file}}">
                                              <i class="fas fa-download"></i>
                                          </a>
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </div>


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
