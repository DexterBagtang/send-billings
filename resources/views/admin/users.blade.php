@extends('layout.app')

@section('content')
    <main>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0">Users</h1>
                    <div class="small">
                        <span class="fw-500 text-primary">{{\Carbon\Carbon::now()->format('l')}}</span>
                        &middot; {{\Carbon\Carbon::now()->format('F d, Y')}}
                    </div>
                </div>
                <a href="{{url('register')}}" class="btn btn-primary"><i class="me-1" data-feather="user-plus"></i>Register New User</a>
            </div>
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
                            <a class="nav-link {{(request()->is('users','search-users')) ? 'active' : ""}}" aria-current="page" href="{{url('users')}}">Users</a>
                        </li>
                        {{--                        <li class="nav-item">--}}
                        {{--                            <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Removed</a>--}}
                        {{--                        </li>--}}
                    </ul>
                </div>
                <div class="card-body">
                    <div>
{{--                        {{ $clients->withQueryString()->links('pagination::bootstrap-results') }}--}}
                        <form action="{{url('search-users')}}" method="GET" class="float-end">
                            <input type="search" class="form-control" name="search" value="{{$search}}" placeholder="Search">
                            <input type="submit" class="d-none">
                        </form>
                    </div>


                    <table id="datatablesSimple3">
                        <thead>
                        <tr>
                            {{--                            <th>Name</th>--}}
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date Created</th>
                            {{--                            <th>Contact</th>--}}
                            <th>Last Login</th>
{{--                            <th>Actions</th>--}}

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->role_name}}</td>
                                <td>{{\Carbon\Carbon::parse($user->created_at)->diffForHumans()}}</td>
                                <td>{{$user->login}}</td>
{{--                                <td>--}}
{{--                                    <a href="{{url('forgot-password')}}"> forgot</a>--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--                    {{$clients->links()}}--}}
{{--                    {{  $clients->withQueryString()->links('pagination::bootstrap-5') }}--}}
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
