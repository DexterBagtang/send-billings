@extends('layout.app')

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
{{--                                <div class="page-header-icon"><i data-feather="file"></i></div>--}}
                                Clients
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3"></div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <div class="card mb-4">
                <div class="card-header"></div>
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
                                <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i data-feather="more-vertical"></i></button>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
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
