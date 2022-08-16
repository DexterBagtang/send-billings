@extends('layout.app')

@section('link')
{{--    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">--}}

@endsection

@section('content')
    <main>

        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0">Statement of Accounts for the month of {{$month.'-'.$year}}</h1>
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

                <div class="card-body">
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
                    <div>
                        {{ $billings->withQueryString()->links('pagination::bootstrap-results') }}

                        <form action="{{url('billingSearch')}}" method="GET" class="float-end">
                            <input type="search" class="form-control" name="search" value="{{$search}}"  placeholder="Search">
                            <input type="hidden" name="month" value="{{$month}}">
                            <input type="hidden" name="year" value="{{$year}}">
                            <input type="submit" class="d-none">
                        </form>
                    </div>
                            <table id="datatablesSimple3">
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
                    {{  $billings->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
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
