{{--@extends('layout.app')--}}

{{--@section('content')--}}
{{--    <!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <title>Laravel 8 Add/Remove Multiple Input Fields Example</title>--}}
{{--    <!-- CSS -->--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">--}}
{{--    <style>--}}
{{--        .container {--}}
{{--            max-width: 600px;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="container">--}}
{{--    <form action="" method="POST">--}}
{{--        @csrf--}}
{{--        @if ($errors->any())--}}
{{--            <div class="alert alert-danger" role="alert">--}}
{{--                <ul>--}}
{{--                    @foreach ($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        @if (Session::has('success'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                <p>{{ Session::get('success') }}</p>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <table class="table table-bordered" id="dynamicAddRemove">--}}
{{--            <tr>--}}
{{--                <th>Subject</th>--}}
{{--                <th>Action</th>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td><input type="text" name="addMoreInputFields[0][subject]" placeholder="Enter subject" class="form-control" />--}}
{{--                </td>--}}
{{--                <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Subject</button></td>--}}
{{--            </tr>--}}
{{--        </table>--}}
{{--        <button type="submit" class="btn btn-outline-success btn-block">Save</button>--}}
{{--    </form>--}}
{{--</div>--}}
{{--</body>--}}
{{--<!-- JavaScript -->--}}

{{--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>--}}
{{--<script type="text/javascript">--}}
{{--    var i = 0;--}}
{{--    $("#dynamic-ar").click(function () {--}}
{{--        ++i;--}}
{{--        $("#dynamicAddRemove").append('' +--}}
{{--            '<tr>' +--}}
{{--            '<td>' +--}}
{{--            '   <input type="text" name="addMoreInputFields[' + i +--}}
{{--            '][subject]" placeholder="Enter subject" class="form-control" />' +--}}
{{--                '</td>' +--}}
{{--            '<td>' +--}}
{{--                '<button type="button" class="btn btn-outline-danger remove-input-field">Delete</button>' +--}}
{{--            '</td>' +--}}
{{--            '</tr>'--}}
{{--        );--}}
{{--    });--}}
{{--    $(document).on('click', '.remove-input-field', function () {--}}
{{--        $(this).parents('tr').remove();--}}
{{--    });--}}
{{--</script>--}}
{{--</html>--}}
{{--@endsection--}}


{{--    <!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <script src="https://cdn.tailwindcss.com"></script>--}}
{{--    <title>Document</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-lg flex items-center space-x-4">--}}
{{--    <div class="shrink-0">--}}
{{--        <img class="h-12 w-12" src="/img/logo.svg" alt="ChitChat Logo">--}}
{{--    </div>--}}
{{--    <div>--}}
{{--        <div class="text-xl font-medium text-black">ChitChat</div>--}}
{{--        <p class="text-slate-500">You have a new message!</p>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<main class="my-0 mx-auto max-w-3xl text-center">--}}
{{--    <h2 class="p-6 text-4xl">A Basic Tailwind CSS Example</h2>--}}

{{--    <p class="px-10 pb-10 text-left">Tailwind CSS works by scanning all of your HTML files, JavaScript components, and any other templates for class names, generating the corresponding styles and then writing them to a static CSS file. It's fast, flexible, and reliable — with zero-runtime.</p>--}}

{{--    <button class="bg-sky-600 hover:bg-sky-700 px-5 py-3 text-white rounded-lg">BUTTON EXAMPLE</button>--}}

{{--    <div class="bg-green-300 border-green-600 border-b-2 p-5 m-5 rounded-lg">--}}
{{--        Hello World--}}
{{--    </div>--}}

{{--    <div class="bg-gray-700 border-5 p-5 m-5 text-white text-3xl rounded-lg">--}}
{{--        TailWind CSS--}}
{{--    </div>--}}

{{--</main>--}}

{{--</body>--}}
{{--</html>--}}



<html>
<head>
    <title>Laravel 9 ChartJS Chart Example - ItSolutionStuff.com</title>
</head>

<body>
<h1>Laravel 9 ChartJS Chart Example - ItSolutionStuff.com</h1>
<canvas id="myChart" height="100px"></canvas>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">

    var labels =  {{ Js::from($labels) }};
    var users =  {{ Js::from($data) }};

    const data = {
        labels: labels,
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: users,
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

</script>
</html>
