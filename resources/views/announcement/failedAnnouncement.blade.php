@extends('layout.app')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="container-fluid px-4 mt-4">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                @include('layout.announcementnav')


                <!-- /.col -->
                <div class="col-md-10">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
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
                            <h3 class="card-title">Failed Announcements</h3>

                            <form action="{{url('searchAnnouncement')}}" method="GET">
                                @csrf
                                <div class="card-tools">
                                    <div class="input-group ">
                                        <input type="hidden" name="status" value="Sending Error">
                                        <input type="search" name="search" class="form-control" value="{{isset($search)? "$search":''}}" placeholder="Search Mail">
                                        <input type="submit" class="d-none">
                                        <div class="input-group-append">
                                            <a href="!#" onclick="event.preventDefault();this.closest('form').submit();">
                                                <div class="btn btn-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- /.card-tools -->
                        </div>
                        <form action="{{url('deleteAnnouncement')}}" method="GET">
                            <div class="row card-header">
                                <div onclick="window.location.href='javascript:history.back()'" class="btn btn-icon btn-blue-soft mx-2 mt-2">
                                    <i data-feather="arrow-left"></i>
                                </div>

                                @if(\Illuminate\Support\Facades\Auth::user()->roles_id <= 2 )
                                <div onclick="event.preventDefault();if (!confirm('Are you sure delete ?')) { return false } this.closest('form').submit();" class="btn btn-icon btn-blue-soft mx-2 mt-2">
                                    <i data-feather="trash-2"></i>
                                </div>
                                @endif

                                <div onclick="window.location.reload()" class="btn btn-icon btn-blue-soft mx-2 mt-2">
                                    <i data-feather="rotate-cw"></i>
                                </div>
                            </div>


                            @if(count($announcements) > 0)

                            <div class="card-header">
                                @if(!isset($check))
                                    <input type="hidden" value="Sending Error" name="status">
                                    <div onclick="window.location.href='{{url('mark/Sending Error')}}'" class="btn btn-twitter mx-2 mt-2"> Mark all</div>
                                @else
                                    <input type="hidden" value="Sending Error" name="status">
                                    <div onclick="window.location.href='{{url('unmark/Sending Error')}}'" class="btn btn-twitter mx-2 mt-2"> Unmark all</div>
                                @endif

{{--                                <div onclick="event.preventDefault();if (!confirm('Are you sure to resend ?')) { return false } this.closest('form').submit();" class="btn btn-twitter mx-2 mt-2"> Resend--}}
{{--                                    --}}{{--                                    <i data-feather="rotate-cw"></i>--}}
{{--                                </div>--}}

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
                                                        <div class="text-warning">Statements of account are still sending at this moment, You're able to send this after all the SoA are processed.</div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        {{--                                        <input type="submit" class="btn btn-primary" value="Send Now">--}}
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-twitter mx-2 mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Resend
                                        </button>
                                    @elseif($blasting > 0)
                                        <!-- Modal -->
{{--                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                                            <div class="modal-dialog ">--}}
{{--                                                <div class="modal-content">--}}
{{--                                                    <div class="modal-header">--}}
{{--                                                        <h5 class="modal-title" id="exampleModalLabel">Unable to send !</h5>--}}
{{--                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-body">--}}
{{--                                                        <div>Announcements are still sending at this moment, You're able to send this after all the SoA are processed.</div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-footer">--}}
{{--                                                        --}}{{--                                        <input type="submit" class="btn btn-primary" value="Send Now">--}}
{{--                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <button type="button" onclick="alert('Unable to send! \n\rAnnouncements are still sending...')" class="btn btn-twitter mx-2 mt-2">
                                            Resend
                                        </button>

                                    @else
                                        <button type="submit" formaction="{{url('resendAnnouncement')}}"
                                                formmethod="get"
                                                value="Resend" class="btn btn-twitter mx-2 mt-2">Resend</button>
                                    @endif
                            </div>
                            @endif

                            <!-- /.card-header -->
                            <div class="card-body p-1">
                                <div class="px-1 mt-1">{{ $announcements->withQueryString()->links() }}</div>
                                <div class="table-responsive mailbox-messages">
                                    <table class="table table-hover table-striped">
                                        @if(count($announcements) > 0)
                                            <tbody>
                                            @foreach($announcements as $announcement)
                                                <tr>
                                                    <td>
                                                        <div class="">
                                                            <input type="checkbox" value="{{$announcement->id}}" name="ids[]" id="check1"  @if(isset($check))
                                                                {{$check}}
                                                                @endif>
                                                            <label for="check1"></label>
                                                        </div>
                                                    </td>
                                                    {{--                                        <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>--}}
                                                    <td class="mailbox-name"><a href="{{url("readAnnouncement/$announcement->id")}}">To: {{Str::limit($announcement->emailTo,25)}}</a></td>
                                                    <td class="mailbox-subject">
                                                        {!!Str::limit(("<b>".$announcement->subject."</b>" ." - ". str_replace(array("p>"),'span>',$announcement->content)),120)!!}
                                                    </td>
                                                    <td class="mailbox-attachment"></td>
                                                    <td class="mailbox-date">{{\Carbon\Carbon::parse($announcement->emailDate)->diffForHumans()}}</td>
<!--                                                    <td>
                                                        <a href="#" id="exampleModal"
                                                           class="btn btn-datatable btn-icon btn-outline-danger m-1" title="Resend">
                                                            <i data-feather="repeat"></i>
                                                        </a>
                                                    </td>-->
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        @else
                                            <tbody>
                                            <tr>
                                                <td class="text-center">No data available !</td>
                                            </tr>
                                            </tbody>
                                        @endif

                                    </table>
                                    <!-- /.table -->
                                </div>
                                <!-- /.mail-box-messages -->
                            </div>


                            <!-- /.card-body -->
                            <div class="card-footer p-0">
                                <!--                            <div class="mailbox-controls float-end">
                                                                &lt;!&ndash; Check all button &ndash;&gt;
                                                                <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                                                                    <i class="far fa-square"></i>
                                                                </button>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-default btn-sm">
                                                                        <i class="far fa-trash-alt"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-default btn-sm">
                                                                        <i class="fas fa-reply"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-default btn-sm">
                                                                        <i class="fas fa-share"></i>
                                                                    </button>
                                                                </div>
                                                                &lt;!&ndash; /.btn-group &ndash;&gt;
                                                                <button type="button" class="btn btn-default btn-sm">
                                                                    <i class="fas fa-sync-alt"></i>
                                                                </button>
                                                                <div class="float-right">
                                                                    1-50/200
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-default btn-sm">
                                                                            <i class="fas fa-chevron-left"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default btn-sm">
                                                                            <i class="fas fa-chevron-right"></i>
                                                                        </button>
                                                                    </div>
                                                                    &lt;!&ndash; /.btn-group &ndash;&gt;
                                                                </div>
                                                                &lt;!&ndash; /.float-right &ndash;&gt;
                                                            </div>-->
                            </div>
                        </form>
                        <!-- /.card-body -->
                        <div class="card-footer p-0">
<!--                            <div class="mailbox-controls float-end">
                                &lt;!&ndash; Check all button &ndash;&gt;
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                                    <i class="far fa-square"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>
                                &lt;!&ndash; /.btn-group &ndash;&gt;
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <div class="float-right">
                                    1-50/200
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    &lt;!&ndash; /.btn-group &ndash;&gt;
                                </div>
                                &lt;!&ndash; /.float-right &ndash;&gt;
                            </div>-->
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

@endsection
