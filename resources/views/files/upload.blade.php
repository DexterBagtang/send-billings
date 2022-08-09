@extends('layout.app')

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
{{--                                <div class="page-header-icon"><i data-feather="upload"></i></div>--}}
                                Upload File
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3"></div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <!-- Sticky Navigation-->
                <div class="col-lg-4">
                    <div class="nav-sticky">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav flex-column fw-bold">
                                    <li class="nav-item text-uppercase text-danger">Please note !</li>
                                    <li class="nav-item">- Files must be in pdf file</li>
                                    <li class="nav-item">- Multiple files can be uploaded</li>
                                    <li class="nav-item">- Maximum files per upload is 500</li>
                                    <li class="nav-item">- Please wait until files are uploaded</li>
                                    <li class="nav-item">- Uploading may take a while</li>
                                    <li class="nav-item">- instruction 4</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
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
                        </div>
                        <div class="card-body">
                            <form class="row g-3" id="fileUploadForm" method="POST" action="{{url('uploadedFile')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form-label">Month</label>
                                        <select class="form-select" aria-label="select" name="month" id="exampleSelectBorder">
                                            <option value="January" {{(\Carbon\Carbon::now()->format('F') == "January") ? 'selected' : ''}}>January</option>
                                            <option value="February" {{(\Carbon\Carbon::now()->format('F') == "February") ? 'selected' : ''}}>February</option>
                                            <option value="March" {{(\Carbon\Carbon::now()->format('F') == "March") ? 'selected' : ''}}>March</option>
                                            <option value="April" {{(\Carbon\Carbon::now()->format('F') == "April") ? 'selected' : ''}}>April</option>
                                            <option value="May" {{(\Carbon\Carbon::now()->format('F') == "May") ? 'selected' : ''}}>May</option>
                                            <option value="June" {{(\Carbon\Carbon::now()->format('F') == "June") ? 'selected' : ''}}>June</option>
                                            <option value="July" {{(\Carbon\Carbon::now()->format('F') == "July") ? 'selected' : ''}}>July</option>
                                            <option value="August" {{(\Carbon\Carbon::now()->format('F') == "August") ? 'selected' : ''}}>August</option>
                                            <option value="September" {{(\Carbon\Carbon::now()->format('F') == "September") ? 'selected' : ''}}>September</option>
                                            <option value="October" {{(\Carbon\Carbon::now()->format('F') == "October") ? 'selected' : ''}}>October</option>
                                            <option value="November" {{(\Carbon\Carbon::now()->format('F') == "November") ? 'selected' : ''}}>November</option>
                                            <option value="December" {{(\Carbon\Carbon::now()->format('F') == "December") ? 'selected' : ''}}>December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form-label">Year</label>
                                        <select class="form-select" aria-label="select" name="year" id="exampleSelectBorder">
                                            <option value="2020" {{(\Carbon\Carbon::now()->format('Y') == "2020") ? 'selected' : ''}}>2020</option>
                                            <option value="2021" {{(\Carbon\Carbon::now()->format('Y') == "2021") ? 'selected' : ''}}>2021</option>
                                            <option value="2022" {{(\Carbon\Carbon::now()->format('Y') == "2022") ? 'selected' : ''}}>2022</option>
                                            <option value="2023" {{(\Carbon\Carbon::now()->format('Y') == "2023") ? 'selected' : ''}}>2023</option>
                                            <option value="2024" {{(\Carbon\Carbon::now()->format('Y') == "2024") ? 'selected' : ''}}>2024</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Upload</label>
                                    <input type="file" class="form-control" name="billing_file[]" id="customFile"  multiple accept="application/pdf">
                                </div>



                                <div class="col-12">
                                    <div class="float-end">
                                    <button type="submit" class="btn btn-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">
                                        Upload
                                    </button>
{{--                                    <a  class="btn btn-danger">Cancel</a>--}}
                                    </div>
                                </div>

{{--                                <button class="btn btn-primary" type="button"--}}
{{--                                        data-bs-toggle="modal"--}}
{{--                                        data-bs-target="#staticBackdrop">--}}
{{--                                    Launch Demo Modal--}}
{{--                                </button>--}}

{{--                                <!-- Modal -->--}}
{{--                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                                    <div class="modal-dialog" role="document">--}}
{{--                                        <div class="modal-content">--}}
{{--                                            <div class="modal-header">--}}
{{--                                                <h5 class="modal-title" id="exampleModalLabel">Uploading--}}
{{--                                                    <div class="spinner-border" role="status">--}}
{{--                                                        <span class="visually-hidden">Loading...</span>--}}
{{--                                                    </div>--}}
{{--                                                </h5>--}}
{{--                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                                            </div>--}}
{{--                                            <div class="modal-body">Please wait, Files are uploading...--}}
{{--                                            </div>--}}
{{--                                            <div class="modal-footer">--}}
{{--                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>--}}
{{--                                                <button class="btn btn-primary" type="button">Save changes</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <!-- Button trigger modal -->--}}
{{--                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">--}}
{{--                                    Launch static backdrop modal--}}
{{--                                </button>--}}

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Uploading...
                                                    <div class="spinner-border" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </h5>
{{--                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
                                            </div>
                                            <div class="modal-body">
                                                Files are uploading, Please wait
                                            </div>
{{--                                            <div class="modal-footer">--}}
{{--                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                                                <button type="button" class="btn btn-primary">Understood</button>--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

{{--                        <div class="card-header"></div>--}}

                    </div>
                </div>

            </div>
        </div>
    </main>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="{{asset('js/toasts.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/components/prism-core.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/plugins/autoloader/prism-autoloader.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{asset('js/litepicker.js')}}"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/components/prism-core.min.js" crossorigin="anonymous"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/plugins/autoloader/prism-autoloader.min.js" crossorigin="anonymous"></script>--}}
@endsection
