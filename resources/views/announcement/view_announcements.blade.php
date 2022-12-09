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
                            <h3 class="card-title">Announcements</h3>

                            <form action="{{url('searchCompositions')}}" method="GET">
                                @csrf
                                <div class="card-tools">
                                    <div class="input-group ">
{{--                                        <input type="hidden" name="status" value=" ">--}}
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
                        </div>

                        <form action="{{url('deleteComposition')}}" method="get">

                        <div class="row card-header">
                            <div onclick="window.location.href='javascript:history.back()'" class="btn btn-icon btn-blue-soft mx-2 mt-2">
                                <i data-feather="arrow-left"></i>
                            </div>

                            <div onclick="event.preventDefault();if (!confirm('Are you sure delete ?')) { return false } this.closest('form').submit();" class="btn btn-icon btn-blue-soft mx-2 mt-2">
                                <i data-feather="trash-2"></i>
                            </div>

                            <div onclick="window.location.reload()" class="btn btn-icon btn-blue-soft mx-2 mt-2">
                                <i data-feather="rotate-cw"></i>
                            </div>
                            {{--                                    <div onclick="window.location.href='javascript:history.back()'" class="btn btn-sm btn-icon btn-blue-soft m-2">--}}
                            {{--                                        <i data-feather="arrow-right"></i>--}}
                            {{--                                    </div>--}}
                        </div>

                            <!-- /.card-tools -->
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
                                                        <input type="checkbox" value="{{$announcement->id}}" name="ids[]" id="check1">
                                                        <label for="check1"></label>
                                                    </div>
                                                </td>
                                                {{--                                        <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>--}}
{{--                                                <td class="mailbox-name"><a href="{{url("readAnnouncement/$announcement->id")}}">To: {{Str::limit($announcement->emailTo,25)}}</a></td>--}}
                                                <td style="cursor: pointer" onclick="window.location.href='{{'view_compositions/'.$announcement->id}}'" class="mailbox-subject">
{{--                                                    <a href="{{'view_compositions/'.$announcement->id}}">--}}
{{--                                                        {!!Str::limit(("<b>".$announcement->subject."</b>" ." - ". str_replace(array("p>"),'span>',$announcement->content)),150)!!}--}}
{{--                                                    </a>--}}
                                                    {!!Str::limit(("<b>".$announcement->subject."</b>" ." - ". strip_tags($announcement->content)),130)!!}

                                                </td>
                                                <td class="mailbox-attachment">
                                                    @if($announcement->attachment != null)
                                                    <i class="fas fa-paperclip"></i>
                                                    @else
                                                    @endif
                                                </td>
                                                <td class="mailbox-date">{{\Carbon\Carbon::parse($announcement->created_at)->diffForHumans()}}</td>
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

                        </form>
                        <!-- /.card-body -->
                        <div class="card-footer p-0">
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
