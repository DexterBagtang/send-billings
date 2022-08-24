@extends('layout.app')

@section('link')
    <meta http-equiv="refresh" content="30">
@endsection

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        @if(session()->get('sending'))
                            {{--                                    <div class="alert alert-success">--}}
                            {{--                                        {{ session()->get('success') }}--}}
                            {{--                                    </div><br />--}}
                            <div class="alert alert-success alert-dismissible fade show float-end" role="alert">
                                <h5 class="alert-heading">Note !</h5>
                                <hr>
                                {{ session()->get('sending') }}
                                <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>
                            </div>
                        @endif
                        @if(session()->get('error'))
                            {{--                                    <div class="alert alert-success">--}}
                            {{--                                        {{ session()->get('success') }}--}}
                            {{--                                    </div><br />--}}
                            <div class="alert alert-danger alert-dismissible fade show float-end" role="alert">
                                <h5 class="alert-heading">Note !</h5>
                                <hr>
                                {{ session()->get('error') }}
                                <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <div class="card mb-4">
{{--                <a href="{{url('resendBilling')}}" class="btn btn-danger"> Resend All</a>--}}

                <div class="card-header" style="font-size: 25px">
                    Sending Failed for the month of {{$month.'-'.$year}}

                    <div class="float-end">
                        {{--                        Total Billings = {{count($billings)}} <br>--}}
                        Failed = {{$countFailed}} <br>
                        {{--                        Sending = {{$countSending}} <br>--}}
                        {{--                        Not Sent = {{$notSent}}--}}


                    </div>
                </div>
                <div class="card-body">
{{--                    <form  id="billingForm" method="POST" action="{{url('sendBillingFilesPost')}}" enctype="multipart/form-data">--}}
{{--                        @csrf--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-5">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="form-label">Month</label>--}}
{{--                                    <select class="form-select" aria-label="select" name="month" id="exampleSelectBorder">--}}
{{--                                        <option value="January" {{($month == "January") ? 'selected' : ''}}>January</option>--}}
{{--                                        <option value="February" {{($month == "February") ? 'selected' : ''}}>February</option>--}}
{{--                                        <option value="March" {{($month == "March") ? 'selected' : ''}}>March</option>--}}
{{--                                        <option value="April" {{($month == "April") ? 'selected' : ''}}>April</option>--}}
{{--                                        <option value="May" {{($month == "May") ? 'selected' : ''}}>May</option>--}}
{{--                                        <option value="June" {{($month == "June") ? 'selected' : ''}}>June</option>--}}
{{--                                        <option value="July" {{($month == "July") ? 'selected' : ''}}>July</option>--}}
{{--                                        <option value="August" {{($month == "August") ? 'selected' : ''}}>August</option>--}}
{{--                                        <option value="September" {{($month == "September") ? 'selected' : ''}}>September</option>--}}
{{--                                        <option value="October" {{($month == "October") ? 'selected' : ''}}>October</option>--}}
{{--                                        <option value="November" {{($month == "November") ? 'selected' : ''}}>November</option>--}}
{{--                                        <option value="December" {{($month == "December") ? 'selected' : ''}}>December</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-5">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="form-label">Year</label>--}}
{{--                                    <select class="form-select" aria-label="select" name="year" id="exampleSelectBorder">--}}
{{--                                        <option value="2020" {{($year == "2020") ? 'selected' : ''}}>2020</option>--}}
{{--                                        <option value="2021" {{($year == "2021") ? 'selected' : ''}}>2021</option>--}}
{{--                                        <option value="2022" {{($year == "2022") ? 'selected' : ''}}>2022</option>--}}
{{--                                        <option value="2023" {{($year == "2023") ? 'selected' : ''}}>2023</option>--}}
{{--                                        <option value="2024" {{($year == "2024") ? 'selected' : ''}}>2024</option>--}}
{{--                                        <option value="2025" {{($year == "2025") ? 'selected' : ''}}>2025</option>--}}
{{--                                        <option value="2026" {{($year == "2026") ? 'selected' : ''}}>2026</option>--}}
{{--                                        <option value="2027" {{($year == "2027") ? 'selected' : ''}}>2027</option>--}}

{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-2">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="" class="form-label"></label>--}}
{{--                                    <input type="submit" class="btn btn-outline-success form-control" id="submit" value="Submit">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}

{{--                    <hr>--}}

                    {{--                    <div class="accordion accordion-flush" id="accordionFlushExample">--}}
                    {{--                        <div class="accordion-item">--}}
                    {{--                            <h2 class="accordion-header" id="flush-headingOne">--}}
                    {{--                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">--}}
                    {{--                                    Show Billing--}}
                    {{--                                </button>--}}
                    {{--                            </h2>--}}
                    {{--                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">--}}
                    {{--                                <div class="accordion-body">--}}
                    <div class="">
                        {{ $billings->withQueryString()->links('pagination::bootstrap-results') }}
                        <form action="{{url('searchFailed')}}" method="GET" class="float-end">
                            <input type="search" class="form-control" name="search" value="{{$search}}" placeholder="Search">
                            <input type="submit" class="d-none">
                        </form>
                    </div>
                    <table id="datatablesSimple2">
                        <thead>
                        <tr>
                            {{--                            <th>Account#</th>--}}
                            {{--                            <th>Contract#</th>--}}

                            <th>Company</th>
                            <th>Email</th>
                            {{--                            <th>Month and Year</th>--}}
                            <th>File</th>
                            <th>Email Status</th>
                            <th>Emailed By</th>
                            <th>Date Emailed</th>
                            <th>Action</th>
{{--                            <th>Actions</th>--}}
                        </tr>
                        </thead>
                        {{--                        <tfoot>--}}
                        {{--                        <tr>--}}
                        {{--                            <th>Name</th>--}}
                        {{--                            <th>Account</th>--}}
                        {{--                            <th>Contract</th>--}}
                        {{--                            <th>Email</th>--}}
                        {{--                            <th>Company</th>--}}
                        {{--                            <th>Contact</th>--}}
                        {{--                            <th>Status</th>--}}
                        {{--                            <th>Actions</th>--}}
                        {{--                        </tr>--}}
                        {{--                        </tfoot>--}}
                        <tbody>
                        @foreach($billings as $billing)
                            <tr>
                                <td>{{$billing->company}}</td>
                                {{--                                <td>{{$billing->account_number}}</td>--}}
                                {{--                                <td>{{$billing->contract_number}}</td>--}}
                                <td>{{Str::limit($billing->email,40)}}</td>
                                {{--                                <td>{{$billing->month}}-{{$billing->year}}</td>--}}
                                <td>
                                    <a href="{{asset('billing_files/'.$billing->month.'-'.$billing->year.'/'.$billing->storedFile)}}" target="_blank">
                                        {{$billing->filename}}
                                    </a>
                                </td>
                                <td>{{$billing->emailStatus}}</td>
                                <td>{{$billing->emailedBy}}</td>
                                <td>{{$billing->emailDate}}</td>
                                @if(count($sendings) > 0)
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Resend
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Note !</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Statements of Account are still sending, You can resend it after all the SoA are sent.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @else
                                    @if($billing->emailStatus == "sending error")
                                    <td><a href="{{url("resendBilling/$billing->id")}}" class="btn btn-danger btn-sm">Resend</a></td>
                                    @else
                                        <td></td>
                                    @endif
                                @endif

                                {{--                                <td>--}}
{{--                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i data-feather="more-vertical"></i></button>--}}
{{--                                    <button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></button>--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $billings->withQueryString()->links('pagination::bootstrap-5') }}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                    </div>--}}



                    {{--                    <form action="{{url('sendBillingNow')}}" method="POST" enctype="multipart/form-data">--}}
                    {{--                        @csrf--}}
                    {{--                        <div class="form-group">--}}
                    {{--                            <input type="hidden" name="month" value="{{$month}}">--}}
                    {{--                            <input type="hidden" name="year" value="{{$year}}">--}}
                    {{--                            --}}{{--                            <input type="submit" class="btn btn-primary btn-lg" value="Send Billing">--}}
                    {{--                        </div>--}}

                    {{--                        <!-- Button trigger modal -->--}}
                    {{--                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">--}}
                    {{--                            Send Billings--}}
                    {{--                        </button>--}}

                    {{--                        <!-- Modal -->--}}
                    {{--                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
                    {{--                            <div class="modal-dialog">--}}
                    {{--                                <div class="modal-content">--}}
                    {{--                                    <div class="modal-header">--}}
                    {{--                                        <h5 class="modal-title" id="exampleModalLabel">Send Billing</h5>--}}
                    {{--                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="modal-body">--}}
                    {{--                                        You are about to send the billings for the month of {{$month.'-'.$year}}--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="modal-footer">--}}
                    {{--                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>--}}
                    {{--                                        <input type="submit" class="btn btn-primary" value="Send Now">--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </form>--}}
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
    </main>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables/datatables-simple-demo.js')}}"></script>
@endsection
