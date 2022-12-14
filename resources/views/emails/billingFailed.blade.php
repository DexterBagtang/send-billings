@extends('layout.app')

@section('link')
    <meta http-equiv="refresh" content="120">
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" >--}}
@endsection

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light  mb-4">
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
                        @if(session()->get('resend'))
                            {{--                                    <div class="alert alert-success">--}}
                            {{--                                        {{ session()->get('success') }}--}}
                            {{--                                    </div><br />--}}
                            <div class="alert alert-success alert-dismissible fade show float-end" role="alert">
                                <h5 class="alert-heading">Note !</h5>
                                <hr>
                                File is stored in "Resend Failed Soa" You may check it <a href="{{url('resendBillingFiles')}}"> here</a>
{{--                                <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>--}}
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
                        @if(session()->get('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div><br />
                        @endif

                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">

            <div class="modal fade" id="empModal" >
                <div class="modal-dialog modal-xl">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
{{--                            <h4 class="modal-title">Details</h4>--}}
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="w-100" id="tblempinfo">
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            @if($search !== null)
                <div class="text-black text-lg">Search results for: "{{$search}}"</div>
            @endif
            <div class="card mb-4">
{{--                <a href="{{url('resendBilling')}}" class="btn btn-danger"> Resend All</a>--}}

                <div class="card-header" style="font-size: 25px">
                    Sending Failed for the month of {{$month.'-'.$year}}

                    <div class="float-end">
                        {{--                        Total Billings = {{count($billings)}} <br>--}}
                        Failed = {{ $billings->total() }} <br>
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
                    <table class="empTable" id="datatablesSimple2">
                        <thead>
                        <tr>
                            <th>Company</th>
                            <th>Email</th>
                            <th>File</th>
                            <th>Email Status</th>
                            <th>Emailed By</th>
                            <th>Date Emailed</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($billings as $billing)
                            <tr style="cursor: pointer"  >
                                <td  class="viewdetails" data-id="{{$billing->id}}">{{Str::limit($billing->company,30)}}</td>
                                {{--                                <td>{{$billing->account_number}}</td>--}}
                                {{--                                <td>{{$billing->contract_number}}</td>--}}
                                <td class="viewdetails" data-id="{{$billing->id}}">{{Str::limit($billing->email,30)}}</td>
                                {{--                                <td>{{$billing->month}}-{{$billing->year}}</td>--}}
                                <td>
                                    <a href="{{asset('billing_files/'.$billing->month.'-'.$billing->year.'/'.$billing->storedFile)}}" target="_blank">
                                        {{Str::limit($billing->filename,30)}}
                                    </a>
                                </td>
                                <td class="viewdetails" data-id="{{$billing->id}}">{{$billing->emailStatus}}</td>
                                <td class="viewdetails" data-id="{{$billing->id}}">{{$billing->emailedBy}}</td>
                                <td class="viewdetails" data-id="{{$billing->id}}">{{$billing->emailDate}}</td>
                                @if($sendings > 0)
                                    <td>
                                        <a href="{{url("editClient/$billing->clients_id")}}"
                                           class="btn btn-datatable btn-icon btn-outline-primary m-1" title="Edit">
                                            <i data-feather="edit-3"></i>
                                        </a>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-datatable btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <i data-feather="repeat"></i>
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
                                    <td>
                                        <a href="{{url("editClient/$billing->clients_id")}}"
                                           class="btn btn-datatable btn-icon btn-outline-primary m-1" title="Edit">
                                            <i data-feather="edit-3"></i>
                                        </a>

                                        <a href="{{url("resendBilling/$billing->id")}}"
                                           class="btn btn-datatable btn-icon btn-outline-danger m-1" title="Resend">
                                            <i data-feather="repeat"></i>
                                        </a>
                                    </td>
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
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" ></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script type='text/javascript'>
        $(document).ready(function(){

            $('.empTable').on('click','.viewdetails',function(){
                var empid = $(this).attr('data-id');

                if(empid > 0){

                    // AJAX request
                    var url = "{{url('getId/empid')}}";
                    url = url.replace('empid',empid);

                    // console.log('url');
                    // alert(url);

                    // Empty modal data
                    $('#tblempinfo tbody').empty();

                    $.ajax({
                        url: url,
                        dataType: 'json',
                        success: function(response){

                            // Add employee details
                            $('#tblempinfo tbody').html(response.html);

                            // Display Modal
                            $('#empModal').modal('show');
                        }
                    });
                }
            });

        });
    </script>
@endsection
