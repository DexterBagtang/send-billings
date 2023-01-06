@extends('layout.app')



@section('content')
    <main>
        <!-- Main page content-->
        <div class="container-fluid px-5 mt-4">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0 ms-5">
                    <h1 class="mb-0">Clients</h1>
                    <div class="small">
                        <span class="fw-500 text-primary">{{\Carbon\Carbon::now()->format('l')}}</span>
                        &middot; {{\Carbon\Carbon::now()->format('F d, Y')}}
                    </div>
                </div>
                @if(Auth::user()->roles_id <= 2)
                <a href="{{url('addClient')}}" class="btn btn-primary">Add Client</a>
                @endif
            </div>

            @if($search !== null)
            <div class="text-black text-lg">Search results for: "{{$search}}"</div>
            @endif
            <div class="card">
                <div class="float-end">
                    @if(session()->get('success'))
                        <div class="alert alert-success alert-dismissible fade show float-end m-3" role="alert">
                            {{ session()->get('success') }}
                            <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>
                        </div>
                    @endif
                </div>
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item me-1">
                            <a class="nav-link {{(request()->is('clients','searchClient')) ? 'active' : ""}}" aria-current="page" href="{{url('clients')}}">Clients</a>
                        </li>
                        @if(count($duplicate)>0)
                        <li class="nav-item position-relative">
                            <a class="nav-link {{(request()->is('duplicateClient')) ? 'active' : ""}}" href="{{url('duplicateClient')}}">
                                Duplicate <!--<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">-->
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-sm">
                                    @if(count($duplicate) > 100)
                                         <span class="text-danger">*</span>
                                    @else
                                        <span class="text-danger">*</span>
                                    @endif


                                            </span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div>
                        {{ $clients->withQueryString()->links('pagination::bootstrap-results') }}
                        <form action="{{url('searchClient')}}" method="GET" class="float-end">
                            <input type="search" class="form-control" name="search" value="{{$search}}" placeholder="Search">
                            <input type="submit" class="d-none">
                        </form>
                    </div>




                    <table id="datatablesSimple3">
                        <thead>
                        <tr>
                            <th>Company</th>
                            <th>Account#</th>
                            <th>Contract#</th>
                            <th>Email</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td>{{Str::limit($client->company,50)}}</td>
                            <td>{{$client->account_number}}</td>
                            <td>{{$client->contract_number}}</td>
                            <td title="{{$client->email}}">{{Str::limit($client->email,50)}}</td>
                            <td>
                                @if(Auth::user()->roles_id <= 2)
                                <a href="{{url("editClient/$client->id")}}"
                                   class="btn btn-datatable btn-icon btn-outline-primary m-1" title="Edit">
                                    <i data-feather="edit-3"></i>
                                </a>
                                @endif

                                <a href="{{url("viewClient/$client->id")}}" id="exampleModal"
                                   class="btn btn-datatable btn-icon btn-outline-success m-1" title="View">
                                    <i data-feather="eye"></i>
                                </a>

                                @if(Auth::user()->roles_id <= 2)
                                <a href="{{url("removeClient/$client->id")}}" id="exampleModal"
                                   class="btn btn-datatable btn-icon btn-outline-danger m-1" title="Remove">
                                    <i data-feather="user-minus"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{  $clients->withQueryString()->links('pagination::bootstrap-5') }}
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
