@extends('layout.app')

@section('link')
    {{--    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <main>
        <div class="container-xl px-4 mt-4">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0">Billings for the month of {{$month.'-'.$year}}</h1>
                    <div class="small">
                        {{--                        <span class="fw-500 text-primary">{{\Carbon\Carbon::now()->format('l')}}</span>--}}
                        {{--                        &middot; {{\Carbon\Carbon::now()->format('F d, Y')}}--}}
                        {{--                        &middot; <span id="hours">00</span>:<span id="minutes">00</span> <span>{{\Carbon\Carbon::now()->format('A')}}</span>--}}
                    </div>
                </div>
                <!-- Date range picker example-->
                {{--                <div class="input-group input-group-joined border-0 shadow" style="width: 16.5rem">--}}
                {{--                    <span class="input-group-text"><i data-feather="calendar"></i></span>--}}
                {{--                    <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range..." />--}}
                {{--                </div>--}}
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br />
                    @endif
                    {{--                    Billings for the month of {{$month.'-'.$year}}--}}
                    {{--                    <div class="float-end">--}}
                    {{--                        Total Files = {{count($billings)}}--}}
                    {{--                    </div>--}}
                    <!-- Dashboard card navigation-->
                    <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                        <li class="nav-item me-1">
                            <a class="nav-link active" id="overview-pill" href="#overview" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">
                                Duplicate Billings
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="dashboardNavContent">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">

                            <table id="datatablesSimple1">
                                {{--                    <table data-toggle="table">--}}
                                <thead>
                                <tr>
                                    {{--                                    <th>Name</th>--}}
                                    <th>File Name</th>
                                    <th>Uploader</th>
                                    <th>File</th>
                                    <th>Date Uploaded</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($duplicateFiles as $duplicate)
                                    <tr>
                                        <td>{{$duplicate->filename}}</td>
                                        <td>{{$duplicate->uploader}}</td>
                                        {{--                                <td>{{$billing->month}}-{{$billing->year}}</td>--}}
                                        <td>
                                            <a href="{{asset('billing_files/'.$duplicate->month.'-'.$duplicate->year.'/'.$duplicate->storedFile)}}" target="_blank">
                                                {{$duplicate->filename}}
                                            </a>
                                        </td>
                                        {{--                                <td>{{$billing->created_at}}</td>--}}
                                        <td>{{\Carbon\Carbon::parse($duplicate->created_at)->format('F d, Y - h:i A')}}</td>
                                        <td>
                                            <form method="POST" action="{{url('removeDuplicatePost/'.$duplicate->id)}}">
                                                @csrf
                                                <a href="#" onclick="event.preventDefault();this.closest('form').submit();" class="btn btn-danger">Remove</a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>




                    </div>
                </div>
                {{--            <div class="card card-icon mb-4">--}}
                {{--                <div class="row g-0">--}}
                {{--                    <div class="col-auto card-icon-aside bg-primary"><i class="me-1 text-white-50" data-feather="alert-triangle"></i></div>--}}
                {{--                    <div class="col">--}}
                {{--                        <div class="card-body py-5">--}}
                {{--                            <h5 class="card-title">Third-Party Documentation Available</h5>--}}
                {{--                            <p class="card-text">Simple DataTables is a third party plugin that is used to generate the demo table above. For more information about how to use Simple DataTables with your project, please visit the official documentation.</p>--}}
                {{--                            <a class="btn btn-primary btn-sm" href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">--}}
                {{--                                <i class="me-1" data-feather="external-link"></i>--}}
                {{--                                Visit Simple DataTables Docs--}}
                {{--                            </a>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>
        </div>
    </main>
@endsection


@section('script')
    <!--    <script>alert('WARNING!')</script>
    <script>alert('You are being hacked!')</script>-->
    {{--    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script type="text/javascript">
        $('.show-alert-delete-box').click(function(event){
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Are you sure you want to delete this record?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                type: "warning",
                buttons: ["Cancel","Yes!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    </script>


@endsection
