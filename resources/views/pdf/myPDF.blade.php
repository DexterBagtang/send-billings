<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .text-center{
        text-align: center;
    }

</style>
<body style="padding: 50px">
<h1 class="text-center" style="padding: 10px">Billings</h1>
<div class="container" style="font-size: 30px; border:1px solid black; padding: 20px 10px;">
    <div>Company: {{ $company }}</div>
    <hr>
    <div>Account Number: {{ $account  }}</div>
    <hr>
    <div>Contract Number: {{$contract}}</div>
    <hr>
    <div>{{ $email }}</div>
</div>


</body>
</html>
