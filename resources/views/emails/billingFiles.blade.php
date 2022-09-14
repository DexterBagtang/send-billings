@extends('layout.app')

@section('link')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
{{--                        <div class="col-auto mb-3">--}}
{{--                            <h1 class="page-header-title">--}}
{{--                                --}}{{--                                <div class="page-header-icon"><i data-feather="file"></i></div>--}}
{{--                                Billing Files--}}
{{--                            </h1>--}}
{{--                        </div>--}}
{{--                        <div class="col-12 col-xl-auto mb-3">--}}
{{--                            @if(session()->get('sending'))--}}
{{--                                --}}{{--                                    <div class="alert alert-success">--}}
{{--                                --}}{{--                                        {{ session()->get('success') }}--}}
{{--                                --}}{{--                                    </div><br />--}}
{{--                                <div class="alert alert-success alert-dismissible fade show float-end" role="alert">--}}
{{--                                    <h5 class="alert-heading">Note !</h5>--}}
{{--                                    <hr>--}}
{{--                                    {{ session()->get('sending') }}--}}
{{--                                    <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                                @if(session()->get('error'))--}}
{{--                                    --}}{{--                                    <div class="alert alert-success">--}}
{{--                                    --}}{{--                                        {{ session()->get('success') }}--}}
{{--                                    --}}{{--                                    </div><br />--}}
{{--                                    <div class="alert alert-danger alert-dismissible fade show float-end" role="alert">--}}
{{--                                        <h5 class="alert-heading">Note !</h5>--}}
{{--                                        <hr>--}}
{{--                                        {{ session()->get('error') }}--}}
{{--                                        <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>--}}
{{--                                    </div>--}}
{{--                                @endif--}}


{{--                            @if ($errors->any())--}}
{{--                                <div class="alert alert-danger">--}}
{{--                                    <ul>--}}
{{--                                        @foreach ($errors->all() as $error)--}}
{{--                                            <li>{{ $error }}</li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            @if($search !== null)
                <div class="text-black text-lg">Search results for: "{{$search}}"</div>
            @endif
            <div class="card mb-4">
                <div class="card-header" style="font-size: 25px">
                    Statement of Account for the month of {{$month.'-'.$year}}
                    <div class="float-end" style="font-size: 20px">
{{--                        Total SOA = {{}} <br>--}}
{{--                        Ready for sending = {{$notSent}} <br>--}}
                        Ready for sending = {{ $billings->total() }} <br>

                        {{--                        Sent Billings = {{$countSent}} <br>--}}
{{--                        Sending = {{$countSending}} <br>--}}
{{--                        Failed = {{$billingFailed}}--}}


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
{{--                                    <input type="submit" class="btn btn-success form-control" id="submit" value="Submit">--}}
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
{{--                    {{  $billings->withQueryString()->links('pagination::bootstrap-results') }}--}}
                    <div class="">
                        {{ $billings->withQueryString()->links('pagination::bootstrap-results') }}
                        <form action="{{url('searchSend')}}" method="GET" class="float-end">
                            <input type="search" class="form-control" name="search" value="{{$search}}" placeholder="Search">
                            <input type="submit" class="d-none">
                        </form>
                    </div>
                                    <table id="datatablesSimple2">
                                        <thead>
                                        <tr>
{{--                                            <th>Name</th>--}}
                                            {{--                            <th>Account#</th>--}}
                                            {{--                            <th>Contract#</th>--}}
                                            <th>Company</th>
                                            <th>Email</th>
                                            {{--                            <th>Month and Year</th>--}}
                                            <th>File</th>
                                            <th>Date Uploaded</th>
                                            <th>Email Status</th>
{{--                                            <th>Actions</th>--}}
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
{{--                                                <td>{{$billing->name}}</td>--}}
                                                {{--                                <td>{{$billing->account_number}}</td>--}}
                                                {{--                                <td>{{$billing->contract_number}}</td>--}}
                                                <td>{{$billing->company}}</td>
                                                <td>{{Str::limit($billing->email,40)}}</td>

                                                {{--                                <td>{{$billing->month}}-{{$billing->year}}</td>--}}
                                                <td>
                                                    <a href="{{asset('billing_files/'.$billing->month.'-'.$billing->year.'/'.$billing->storedFile)}}" target="_blank">
                                                        {{$billing->filename}}
                                                    </a>
                                                </td>
                                                <td>{{$billing->created_at}}</td>
                                                <td>{{$billing->emailStatus}}
                                                    @if($billing->emailStatus == "sent")
                                                        <span>{{\Carbon\Carbon::parse($billing->emailDate)->diffForHumans()}}</span>
                                                    @endif
                                                </td>
{{--                                                <td>--}}
{{--                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i data-feather="more-vertical"></i></button>--}}
{{--                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></button>--}}
{{--                                                </td>--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                    {{  $billings->withQueryString()->links('pagination::bootstrap-5') }}


                    {{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}

                    <hr>


                    <form action="{{url('sendBillingNow')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="month" value="{{$month}}">
                            <input type="hidden" name="year" value="{{$year}}">
{{--                            <input type="submit" class="btn btn-primary btn-lg" value="Send Billing">--}}
                        </div>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Send Now
                        </button>

                        @if($billingSending > 0)
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Send Statement of Account</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div> Uploaded Statements of Account are still sending</div>
                                        <br>
                                    </div>
                                    <div class="modal-footer">
{{--                                        <input type="submit" class="btn btn-primary" value="Send Now">--}}
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($notSent > 0)
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Send Statement of Account</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div> You are about to send the statement of accounts for the month of {{$month.'-'.$year}}</div>
                                            <br>
                                            <div class="row mb-3">
                                                <label for="inputPassword3" class="col-sm-1 col-form-label">Subject:</label>
                                                <div class="col-sm-11">
                                                    <input type="text" class="form-control" id="inputPassword3" name="subject" placeholder="Enter the Subject for these emails" required >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-form-label">Message:</label>
                                                <textarea class="summernote" name="message">
{{--<pre style="font-family:Calibri,sans-serif; font-size: 11pt">--}}
{{--Hi Ma’am/Sir;--}}

{{--Good day!--}}

{{--Hope this message finds you well!--}}

{{--Kindly see attached softcopy of your billing for the month of <b>{{strtoupper($month)}} {{$year}}</b>.--}}


{{--You may pay your bills on any BDO Bank nationwide using bills payment facility. Please see payment instruction for your reference.--}}

{{--For those client that made payment last month or prior and was not posted, kindly send your proof of payment to <a href="mailto:Famela.sunio@philcom.com" style="font-style: italic">Famela.sunio@philcom.com</a> .--}}

{{--Please settle your dues on time to avoid penalties and temporary interruption of your circuit.--}}

{{--It is very well appreciated if you could acknowledge this email and if you have any concern or clarifications you may contact our mobile number <b>0917-315-8033</b>, please don’t hesitate to notify us.--}}

{{--Thank you and have a nice day!--}}
{{--</pre>--}}

<div style="font-family:Calibri,sans-serif; font-size: 11pt">
<p>Hi Ma’am/Sir;</p>

<p>Good day!</p>

<p>Hope this message finds you well!</p>

<p>Kindly see attached soft-copy of your billing for the month of <b>{{strtoupper($month)}} {{$year}}</b>.</p>
<br>
<p>You may pay your bills on any BDO Bank nationwide using bills payment facility. Please see payment instruction for your reference.</p>

<p>For those client that made payment last month or prior and was not posted, kindly send your proof of payment to <a href="mailto:Famela.sunio@philcom.com" style="font-style: italic">Famela.sunio@philcom.com</a> .</p>

<p>Please settle your dues on time to avoid penalties and temporary interruption of your circuit.</p>

<p>It is very well appreciated if you could acknowledge this email and if you have any concern or clarifications you may contact our mobile number <b>0917-315-8033</b>, please don’t hesitate to notify us.</p>

<p>Thank you and have a nice day!</p><br>
</div>

                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary" value="Send Now">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Send Statement of Account</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div> All the uploaded Statements of Account for the month of {{$month}} are sent</div>
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        {{--                                        <input type="submit" class="btn btn-primary" value="Send Now">--}}
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </form>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.summernote').summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    // ['font', ['strikethrough', 'superscript', 'subscript']],
                    // ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    // ['height', ['height']]
                ]
            });
        });
    </script>
@endsection
