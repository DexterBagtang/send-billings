@extends('layout.app')

@section('link')
    {{--    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">--}}

@endsection

@section('content')
    <main>
        {{--        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">--}}
        {{--            <div class="container-xl px-4">--}}
        {{--                <div class="page-header-content">--}}
        {{--                    <div class="row align-items-center justify-content-between pt-3">--}}
        {{--                        <div class="col-auto mb-3">--}}
        {{--                            <h1 class="page-header-title">--}}
        {{--                                --}}{{--                                <div class="page-header-icon"><i data-feather="file"></i></div>--}}
        {{--                                Billing Files--}}
        {{--                            </h1>--}}
        {{--                        </div>--}}
        {{--                        <div class="col-12 col-xl-auto mb-3"></div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </header>--}}
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0">Removed Statement of Accounts for the month of {{$month.'-'.$year}}</h1>
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
            @if($search !== null)
                <div class="text-black text-lg">Search results for: "{{$search}}"</div>
            @endif
            <div class="card mb-4">
                <div class="card-header">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br />
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{--                    Billings for the month of {{$month.'-'.$year}}--}}
                    {{--                    <div class="float-end">--}}
                    {{--                        Total Files = {{count($billings)}}--}}
                    {{--                    </div>--}}
                        @include('layout.billingnav')
                </div>

                {{---------------------------------------------REMOVED BILLINGS---------------------------------------------------------------}}

                <div class="card-body">
                    <div class="row">
                        <!-- Sticky Navigation-->
                        {{--                                <div class="col-lg-4">--}}
                        {{--                                    <div class="nav-sticky">--}}
                        {{--                                        <div class="card">--}}
                        {{--                                            <div class="card-body">--}}
                        {{--                                                <ul class="nav flex-column fw-bold">--}}
                        {{--                                                    <li class="nav-item text-uppercase text-danger">Removed Billings</li>--}}
                        {{--                                                    <li class="nav-item">- File has been uploaded multiple times</li>--}}
                        {{--                                                    --}}{{--                                                    <li class="nav-item">- File must have been misspelled</li>--}}
                        {{--                                                    --}}{{--                                                    <li class="nav-item">- Double check the filename</li>--}}
                        {{--                                                    --}}{{--                                                    <li class="nav-item">- Update the clients if there are changes</li>--}}
                        {{--                                                    --}}{{--                                                    <li class="nav-item">- Uploading may take a while</li>--}}
                        {{--                                                    --}}{{--                                                    <li class="nav-item">- instruction 4</li>--}}
                        {{--                                                </ul>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        <div class="col-lg-12">
                            <div>
                                {{ $deletedFiles->withQueryString()->links('pagination::bootstrap-results') }}
                                <form action="{{url('removedSearch')}}" method="GET" class="float-end">
                                    <input type="search" class="form-control" name="search" value="{{$search}}"  placeholder="Search">
                                    <input type="hidden" name="month" value="{{$month}}">
                                    <input type="hidden" name="year" value="{{$year}}">
                                    <input type="submit" class="d-none">
                                </form>
                            </div>
                            <table id="datatablesSimple3">
                                <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Date Uploaded</th>
                                    <th>Uploaded By</th>
                                    <th>Date Removed</th>
                                    <th>Removed By</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deletedFiles as $deleted)
                                    <tr>
                                        <td>{{$deleted->filename}}</td>
                                        <td>{{\Carbon\Carbon::parse($deleted->created_at)->format('d-M-Y h:i')}}</td>
                                        <td>{{$deleted->uploader}}</td>
                                        <td>{{\Carbon\Carbon::parse($deleted->deleted_at)->format('d-M-Y h:i')}}</td>
                                        <td>{{$deleted->deletedBy}}</td>
                                        <td>
                                            <a href="{{url("restoreFile/$deleted->id")}}" class="btn btn-warning btn-sm">Restore</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $deletedFiles->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
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
    {{--    <script>alert('WARNING!')</script>--}}
    {{--    <script>alert('You are being hacked!')</script>--}}
    {{--    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables/datatables-simple-demo.js')}}"></script>
@endsection
