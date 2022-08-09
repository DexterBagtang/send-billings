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
                                Billings  <span class="badge bg-danger">{{count($billings)}}</span>
                            </a>
                        </li>
                        @if(count($nullFiles) > 0)
                        <li class="nav-item">
                            <a class="nav-link" id="activities-pill" href="#activities" data-bs-toggle="tab" role="tab" aria-controls="activities" aria-selected="false">
                                Unknown Billings <span class="badge bg-danger text-white">{{count($nullFiles)}}</span>
                            </a>
                        </li>
                        @endif

                        @if(count($duplicateFiles) > 0)
                            <li class="nav-item">
                                <a class="nav-link" id="duplicate-pill" href="#duplicate" data-bs-toggle="tab" role="tab" aria-controls="duplicate" aria-selected="false">
                                    Duplicate Billings <span class="badge bg-danger text-white">{{count($duplicateFiles)}}</span>
                                </a>
                            </li>
                        @endif

                        @if(count($deletedFiles) > 0)
                            <li class="nav-item">
                                <a class="nav-link" id="deleted-pill" href="#deleted" data-bs-toggle="tab" role="tab" aria-controls="deleted" aria-selected="false">
                                    Removed Billings <span class="badge bg-danger text-white">{{count($deletedFiles)}}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="dashboardNavContent">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">
                            <form  id="billingForm" method="POST" action="{{url('billingFiles')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="form-label">Month</label>
                                            <select class="form-select" aria-label="select" name="month" id="exampleSelectBorder">
                                                <option value="January" {{($month == "January") ? 'selected' : ''}}>January</option>
                                                <option value="February" {{($month == "February") ? 'selected' : ''}}>February</option>
                                                <option value="March" {{($month == "March") ? 'selected' : ''}}>March</option>
                                                <option value="April" {{($month == "April") ? 'selected' : ''}}>April</option>
                                                <option value="May" {{($month == "May") ? 'selected' : ''}}>May</option>
                                                <option value="June" {{($month == "June") ? 'selected' : ''}}>June</option>
                                                <option value="July" {{($month == "July") ? 'selected' : ''}}>July</option>
                                                <option value="August" {{($month == "August") ? 'selected' : ''}}>August</option>
                                                <option value="September" {{($month == "September") ? 'selected' : ''}}>September</option>
                                                <option value="October" {{($month == "October") ? 'selected' : ''}}>October</option>
                                                <option value="November" {{($month == "November") ? 'selected' : ''}}>November</option>
                                                <option value="December" {{($month == "December") ? 'selected' : ''}}>December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="form-label">Year</label>
                                            <select class="form-select" aria-label="select" name="year" id="exampleSelectBorder">
                                                <option value="2020" {{($year == "2020") ? 'selected' : ''}}>2020</option>
                                                <option value="2021" {{($year == "2021") ? 'selected' : ''}}>2021</option>
                                                <option value="2022" {{($year == "2022") ? 'selected' : ''}}>2022</option>
                                                <option value="2023" {{($year == "2023") ? 'selected' : ''}}>2023</option>
                                                <option value="2024" {{($year == "2024") ? 'selected' : ''}}>2024</option>
                                                <option value="2025" {{($year == "2025") ? 'selected' : ''}}>2025</option>
                                                <option value="2026" {{($year == "2026") ? 'selected' : ''}}>2026</option>
                                                <option value="2027" {{($year == "2027") ? 'selected' : ''}}>2027</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="" class="form-label"></label>
                                            <input type="submit" class="btn btn-success form-control" id="submit" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <table id="datatablesSimple1">
                                {{--                    <table data-toggle="table">--}}
                                <thead>
                                <tr>
{{--                                    <th>Name</th>--}}
                                    <th>Company</th>
                                    <th>Account#</th>
                                    <th>Contract#</th>
                                    <th>Email</th>
                                    <th>Uploader</th>
                                    {{--                            <th>Month and Year</th>--}}
                                    <th>File</th>
                                    <th>Date Uploaded</th>

{{--                                    <th>Actions</th>--}}
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Account</th>
                                    <th>Contract</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($billings as $billing)
                                    <tr>
                                        <td>{{$billing->company}}</td>
                                        <td>{{$billing->account_number}}</td>
                                        <td>{{$billing->contract_number}}</td>
                                        <td>{{$billing->email}}</td>
                                        <td>{{$billing->uploader}}</td>
                                        {{--                                <td>{{$billing->month}}-{{$billing->year}}</td>--}}
                                        <td>
                                            <a href="{{asset('billing_files/'.$billing->month.'-'.$billing->year.'/'.$billing->storedFile)}}" target="_blank">
                                                {{$billing->filename}}
                                            </a>
                                        </td>
                                        {{--                                <td>{{$billing->created_at}}</td>--}}
                                        <td>{{\Carbon\Carbon::parse($billing->created_at)->format('F d, Y - h:i A')}}</td>

{{--                                        <td>--}}
{{--                                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i data-feather="more-vertical"></i></button>--}}
{{--                                            <button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></button>--}}
{{--                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

{{--                        @if(!isset($nullFiles))--}}
                        <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-pill">
                            <div class="row">
                                <!-- Sticky Navigation-->
                                <div class="col-lg-4">
                                    <div class="nav-sticky">
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="nav flex-column fw-bold">
                                                    <li class="nav-item text-uppercase text-danger">Unknown Billings</li>
                                                    <li class="nav-item">- File didn't match any of the clients in the database</li>
                                                    <li class="nav-item">- File must have been misspelled</li>
                                                    <li class="nav-item">- Double check the filename</li>
                                                    <li class="nav-item">- Update the clients if there are changes</li>
{{--                                                    <li class="nav-item">- Uploading may take a while</li>--}}
{{--                                                    <li class="nav-item">- instruction 4</li>--}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <table id="datatablesSimple2">
                                        <thead>
                                        <tr>
{{--                                            <th>Company</th>--}}
{{--                                            <th>Account #</th>--}}
{{--                                            <th>Contract #</th>--}}
{{--                                            <th>Email</th>--}}
                                            <th>File</th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($nullFiles as $nullfile)
                                            <tr>
<!--                                                <td>Unknown</td>
                                                <td>Unknown</td>
                                                <td>Unknown</td>
                                                <td>Unknown</td>-->
                                                <td>
                                                    <a class="btn btn-outline-dark" href="{{asset('billing_files/'.$nullfile->month.'-'.$nullfile->year.'/'.$nullfile->storedFile)}}" target="_blank">
                                                        {{--                                        <i data-feather="file"></i>{{$file->filename}}--}}
                                                        <div class="nav-link-icon"><i data-feather="file"></i>
                                                        {{$nullfile->filename}}
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-success">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
{{--                        @endif--}}

                        {{--                        DUPLICATE BILLINGS--}}

                        <div class="tab-pane fade" id="duplicate" role="tabpanel" aria-labelledby="duplicate-pill">
                            <div class="row">
                                <!-- Sticky Navigation-->
                                <div class="col-lg-4">
                                    <div class="nav-sticky">
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="nav flex-column fw-bold">
                                                    <li class="nav-item text-uppercase text-danger">Duplicate Billings</li>
                                                    <li class="nav-item">- File has been uploaded multiple times</li>
                                                    {{--                                                    <li class="nav-item">- File must have been misspelled</li>--}}
                                                    {{--                                                    <li class="nav-item">- Double check the filename</li>--}}
                                                    {{--                                                    <li class="nav-item">- Update the clients if there are changes</li>--}}
                                                    {{--                                                    <li class="nav-item">- Uploading may take a while</li>--}}
                                                    {{--                                                    <li class="nav-item">- instruction 4</li>--}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <table id="datatablesSimple">
                                        <thead>
                                        <tr>
                                            <th>Filename</th>
                                            <th>Duplicate</th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($duplicateFiles as $duplicate)
                                            <tr>
                                                <td>{{$duplicate->filename}}</td>
                                                <td>{{$duplicate->count}}</td>
                                                <td>
                                                    <a href="{{url("viewDuplicate/$duplicate->filename/$month/$year")}}" class="btn btn-success">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

{{--                        REMOVED BILLINGS--}}

                        <div class="tab-pane fade" id="deleted" role="tabpanel" aria-labelledby="deleted-pill">
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
                                    <table id="datatablesSimple4">
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
<!--    <script>alert('WARNING!')</script>
    <script>alert('You are being hacked!')</script>-->
{{--    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables/datatables-simple-demo.js')}}"></script>
@endsection
