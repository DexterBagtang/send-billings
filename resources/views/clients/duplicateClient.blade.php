@extends('layout.app')

@section('content')
    <main>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0">Clients</h1>
                    <div class="small">
                        <span class="fw-500 text-primary">{{\Carbon\Carbon::now()->format('l')}}</span>
                        &middot; {{\Carbon\Carbon::now()->format('F d, Y')}}
                    </div>
                </div>
                <a href="{{url('addClient')}}" class="btn btn-primary position-relative">Add Client</a>

            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{(request()->is('clients')) ? 'active' : ""}}" aria-current="page" href="{{url('clients')}}">Clients</a>
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link {{(request()->is('duplicateClient')) ? 'active' : ""}} position-relative" href="{{url('duplicateClient')}}">
                                Duplicate <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
    <span class="visually-hidden">New alerts</span>
  </span>
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Removed</a>--}}
{{--                        </li>--}}
                    </ul>

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
                    {{$duplicates->withQueryString()->links('pagination::bootstrap-results')}}
                    <form action="{{url('searchDuplicateClient')}}" method="GET" class="float-end">
                        <input type="search" class="form-control" name="search" value="{{$search}}" placeholder="Search">
                        <input type="submit" class="d-none">
                    </form>
                    <table id="datatablesSimple3">
                        <thead>
                        <tr>
                            <th>Company</th>
                            <th>Account#</th>
                            <th>Contract#</th>
                            <th>Email</th>
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
                        @foreach($duplicates as $duplicate)
                            <tr>
                                <td>{{$duplicate->company}}</td>
                                <td>{{$duplicate->account_number}}</td>
                                <td>{{$duplicate->contract_number}}</td>
                                <td>{{$duplicate->email}}</td>
                                <td>{{$duplicate->contact}}</td>
                                <td><div class="badge bg-primary text-white rounded-pill">Active</div></td>
                                <td>
                                    <a href="{{url("editClient/$duplicate->id")}}"
                                       class="btn btn-datatable btn-icon btn-transparent-dark me-2" title="Edit">
                                        <i data-feather="edit-3"></i>
                                    </a>

                                    <a href="#"
                                       class="btn btn-datatable btn-icon btn-transparent-dark me-2" title="Remove">
                                        <i data-feather="user-minus"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $duplicates->links() }}
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