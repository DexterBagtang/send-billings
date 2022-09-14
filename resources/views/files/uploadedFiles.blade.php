@extends('layout.app')

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                {{--                                <div class="page-header-icon"><i data-feather="file"></i></div>--}}
                                Uploaded Statement of Account
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
                <div class="card-header">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br>
                    @endif
                        @if(session()->get('emailError'))
                            <div class="alert alert-danger">
                                {{ session()->get('emailError') }}
                            </div><br />
                        @endif
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
{{--                            <th>Files</th>--}}
                            <th>Uploader</th>
                            <th>Number of SoA uploaded</th>
                            <th>Date Uploaded</th>
                            <th>Month</th>
                            <th>Year</th>
{{--                            <th>Status</th>--}}
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
{{--                            <th>Files</th>--}}
                            <th>Uploader</th>
                            <th>Number of Files</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Date Uploaded</th>
                            {{--                            <th>Status</th>--}}
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($uploads as $upload)
                            <tr>
{{--                                <td>--}}
{{--                                    @foreach(json_decode($upload->fileNames) as $fileName)--}}
{{--                                    <div>--}}
{{--                                        {{$fileName}}--}}
{{--                                    </div>--}}
{{--                                    @endforeach--}}
{{--                                </td>--}}
                                <td>{{$upload->uploader}}</td>
                                <td>{{$upload->fileCount}}</td>
                                <td>{{\Carbon\Carbon::parse($upload->created_at)->format('F d, Y - h:i A')}}</td>
                                <td>{{$upload->month}}</td>
                                <td>{{$upload->year}}</td>
{{--                                <td><div class="badge bg-primary text-white rounded-pill">Active</div></td>--}}
                                <td>
                                    <a href="{{url('viewUploadedFiles/'.$upload->id)}}" class="btn btn-outline-dark btn-sm" title="View">
                                        View<i data-feather="arrow-right"></i>
                                    </a>
{{--                                    <a class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></a>--}}
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
