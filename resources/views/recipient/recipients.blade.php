@extends('layout.app')

@section('content')
    <main>
        <!-- Main page content-->
        <div class="container-fluid px-5 mt-4">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0 ms-5">
                    <h1 class="mb-0">Recipients</h1>
                    <div class="small">
                        <span class="fw-500 text-primary">{{\Carbon\Carbon::now()->format('l')}}</span>
                        &middot; {{\Carbon\Carbon::now()->format('F d, Y')}}
                    </div>
                </div>
                <a href="{{url('addRecipient')}}" class="btn btn-primary">Add Recipient</a>
            </div>
{{--            @if($search !== null)--}}
{{--                <div class="text-black text-lg">Search results for: "{{$search}}"</div>--}}
{{--            @endif--}}
            <div class="card">
                <div class="float-end">
                    @if(session()->get('success'))
                        {{--                            <div class="alert alert-success">--}}
                        {{--                                {{ session()->get('success') }}--}}
                        {{--                                <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>--}}

                        {{--                            </div><br />--}}
                        <div class="alert alert-success alert-dismissible fade show float-end m-3" role="alert">
                            {{--                                <h5 class="alert-heading"></h5>--}}
                            {{--                                <hr>--}}
                            {{ session()->get('success') }}
                            <a class="btn-close" type="" data-bs-dismiss="alert" aria-label="Close"></a>
                        </div>
                    @endif
                </div>
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item me-1">
                            <a class="nav-link {{(request()->is('recipients','searchClient')) ? 'active' : ""}}" aria-current="page" href="{{url('clients')}}">Recipients</a>
                        </li>
{{--                        @if(count($duplicate)>0)--}}
{{--                            <li class="nav-item position-relative">--}}
{{--                                <a class="nav-link {{(request()->is('duplicateClient')) ? 'active' : ""}}" href="{{url('duplicateClient')}}">--}}
{{--                                    Duplicate <!--<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">-->--}}
{{--                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-sm">--}}
{{--                                    @if(count($duplicate) < 100)--}}
{{--                                            <span class="text-danger">*</span>--}}
{{--                                        @else--}}
{{--                                            99+--}}
{{--                                        @endif--}}


{{--                                            </span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
                        {{--                        <li class="nav-item">--}}
                        {{--                            <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Removed</a>--}}
                        {{--                        </li>--}}
                    </ul>
                </div>
                <div class="card-body">
                    <div>
                        {{ $recipients->withQueryString()->links('pagination::bootstrap-results') }}
                        <form action="{{url('searchRecipient')}}" method="GET" class="float-end">
                            <input type="search" class="form-control" name="search" value="@if(isset($search)){{$search}} @endif" placeholder="Search">
                            <input type="submit" class="d-none">
                        </form>
                    </div>




                    <table id="datatablesSimple3">
                        <thead>
                        <tr>
                            {{--                            <th>Name</th>--}}
                            <th>Recipient Name</th>
                            <th>Email Address</th>
{{--                            <th>Contract#</th>--}}
{{--                            <th>Email</th>--}}
                            {{--                            <th>Contact</th>--}}
{{--                            <th>Status</th>--}}
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recipients as $recipient)
                            <tr>
                                <td>{{$recipient->recipient_name}}</td>
                                <td>{{$recipient->recipient_email}}</td>
                                <td>
                                    <a href="{{url("editRecipient/$recipient->id")}}"
                                       class="btn btn-datatable btn-icon btn-outline-primary m-1" title="Edit">
                                        <i data-feather="edit-3"></i>
                                    </a>

                                    <a href="{{url("removeRecipient/$recipient->id")}}" id="delete"
                                       class="btn btn-datatable btn-icon btn-outline-danger m-1" title="Remove">
                                        <i data-feather="user-minus"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--                    {{$clients->links()}}--}}
                    {{  $recipients->withQueryString()->links('pagination::bootstrap-5') }}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.3/bootbox.min.js"></script>
    <script>
        $(document).on("click", "#delete", function(e){
            e.preventDefault();
            var link = $(this).attr("href");
            bootbox.confirm("Do you really want to delete this element ?", function(confirmed){
                if (confirmed){
                    window.location.href = link;
                };
            });
        });
    </script>

@endsection
