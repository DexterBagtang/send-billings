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
                                Uploaded Files
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
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br />
                    @endif
                    <!-- Dashboard card navigation-->
                    <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                        <li class="nav-item me-1"><a class="nav-link active" id="overview-pill" href="#overview" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">
                                Billings <span class="badge bg-primary text-white">{{count($files)}}</a>
                        </li>
                        @if(count($nullFiles) > 0)
                        <li class="nav-item"><a class="nav-link" id="activities-pill" href="#activities" data-bs-toggle="tab" role="tab" aria-controls="activities" aria-selected="false">
                                Unknown Billings <span class="badge bg-danger text-white">{{count($nullFiles)}}</span></a>
                        </li>
                        @endif
                    </ul>
{{--                    {{count(json_decode($upload->fileNames))}} Files--}}
                </div>
                <div class="card-body">
                    <div class="tab-content" id="dashboardNavContent">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">
{{--                            <form action="">--}}
                                <table id="datatablesSimple">
                                    <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Account #</th>
                                        <th>Contract #</th>
                                        <th>Email</th>
                                        <th>File</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($files as $file)
                                        <tr>
                                            <td>{{$file->company}}</td>
                                            <td>{{$file->account_number}}</td>
                                            <td>{{$file->contract_number}}</td>
                                            <td>{{$file->email}}</td>
                                            <td>
{{--                                                <a class="btn btn-outline-dark" href="{{asset('billing_files/'.$file->month.'-'.$file->year.'/'.$file->filename)}}">--}}
                                                <a class="btn btn-outline-dark" href="{{asset('billing_files/'.$file->month.'-'.$file->year.'/'.basename($file->storedFile))}}" target="_blank">
                                                {{--                                        <i data-feather="file"></i>{{$file->filename}}--}}
                                                    <div class="nav-link-icon"><i data-feather="file"></i> </div>
                                                    {{$file->filename}}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
{{--                            </form>--}}
                        </div>

                        <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-pill">
                            <table id="datatablesSimple2">
                                <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Account #</th>
                                    <th>Contract #</th>
                                    <th>Email</th>
                                    <th>File</th>
                                    <th>Status</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($nullFiles as $nullfile)
                                    <tr>
                                        <td>Unknown</td>
                                        <td>Unknown</td>
                                        <td>Unknown</td>
                                        <td>Unknown</td>
                                        <td>
                                            <a class="btn btn-outline-dark" href="{{asset('billing_files/'.$nullfile->month.'-'.$nullfile->year.'/'.$nullfile->storedFile)}}">
                                                {{--                                        <i data-feather="file"></i>{{$file->filename}}--}}
                                                <div class="nav-link-icon"><i data-feather="file"></i> </div>
                                                {{$nullfile->filename}}
                                            </a>
                                        </td>
                                        <td>
                                            @if($nullfile->deleted_at !== null)
                                                <div>deleted at <span>{{Carbon\Carbon::parse($nullfile->deleted_at)->format('d-M-Y')}}</span></div>

                                                <a href="{{url("restoreFile/$nullfile->id")}}">
                                                    restore
                                                </a>

                                            @else
                                            active
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
