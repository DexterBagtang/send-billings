@extends('layout.app')

@section('content')
    <main>
{{--        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">--}}
{{--            <div class="container-xl px-4">--}}
{{--                <div class="page-header-content">--}}
{{--                    <div class="row align-items-center justify-content-between pt-3">--}}
{{--                        <div class="col-auto mb-3">--}}
{{--                            <h1 class="page-header-title">--}}
{{--                                <div class="page-header-icon"><i data-feather="file"></i></div>--}}
{{--                                Clients--}}
{{--                            </h1>--}}
{{--                        </div>--}}
{{--                        <div class="col-12 col-xl-auto mb-3">--}}
{{--                            @if(session()->get('success'))--}}
{{--                                                                    <div class="alert alert-success">--}}
{{--                                                                        {{ session()->get('success') }}--}}
{{--                                                                    </div><br />--}}
{{--                                <div class="alert alert-success alert-dismissible fade show float-end" role="alert">--}}
{{--                                    <h5 class="alert-heading"></h5>--}}
{{--                                    <hr>--}}
{{--                                    {{ session()->get('success') }}--}}
{{--                                    <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </header>--}}

        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0">Clients</h1>
                    <div class="small">
                        <span class="fw-500 text-primary">{{\Carbon\Carbon::now()->format('l')}}</span>
                        &middot; {{\Carbon\Carbon::now()->format('F d, Y')}}
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
                    <a href="{{url('addClient')}}" class="btn btn-primary">Add Client</a>
                    <div class="float-end">
                        @if(session()->get('success'))
{{--                            <div class="alert alert-success">--}}
{{--                                {{ session()->get('success') }}--}}
{{--                                <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>--}}

{{--                            </div><br />--}}
                            <div class="alert alert-success alert-dismissible fade show float-end" role="alert">
{{--                                <h5 class="alert-heading"></h5>--}}
{{--                                <hr>--}}
                                {{ session()->get('success') }}
                                <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple1">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Account#</th>
                            <th>Contract#</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Actions</th>
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
                        @foreach($clients as $client)
                        <tr>
                            <td>{{$client->name}}</td>
                            <td>{{$client->account_number}}</td>
                            <td>{{$client->contract_number}}</td>
                            <td>{{$client->email}}</td>
                            <td>{{$client->company}}</td>
                            <td>{{$client->contact}}</td>
                            <td><div class="badge bg-primary text-white rounded-pill">Active</div></td>
                            <td>

                                <a href="{{url("editClient/$client->id")}}"
                                   class="btn btn-datatable btn-icon btn-transparent-dark me-2" title="Edit">
                                    <i data-feather="edit-3"></i>
                                </a>
{{--                                <button class="btn btn-datatable btn-icon btn-transparent-dark" ><i data-feather="edit"></i></button>--}}
                                <!-- Button trigger modal -->
{{--                                <a href="{{url("edit_client/$client->id")}}"  class="btn btn-primary" >--}}
{{--                                    Edit--}}
{{--                                </a>--}}
{{--                                <a href="" id="editCompany" data-bs-toggle="modal" data-bs-target='#practice_modal' data-id="{{ $client->id }}">Edit</a>--}}

{{--                                <!-- Modal -->--}}
{{--                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">--}}
{{--                                    <div class="modal-dialog">--}}
{{--                                        <div class="modal-content">--}}
{{--                                            <div class="modal-header">--}}
{{--                                                <h5 class="modal-title" id="staticBackdropLabel"></h5>--}}
{{--                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                                            </div>--}}
{{--                                            <form action="">--}}
{{--                                                @csrf--}}
{{--                                                <div class="modal-body">--}}
{{--                                                    {{$client->name}}--}}
{{--                                                </div>--}}
{{--                                            </form>--}}

{{--                                            <div class="modal-footer">--}}
{{--                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                                                <button type="button" class="btn btn-primary">Understood</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/components/prism-core.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/plugins/autoloader/prism-autoloader.min.js" crossorigin="anonymous"></script>

@endsection
