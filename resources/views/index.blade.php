@extends('layout.app')

@section('content')
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #060a1f;
        }

        #clock h2 {
            position: relative;
            display: block;
            color: #fff;
            text-align: center;
            margin: 10px 0;
            font-weight: 700;
            text-transform: 0.4em;
            font-size: 2em;
        }

        #clock #time {
            display: flex;
        }

        #clock #time div {
            position: relative;
            margin: 0 5px;
            -webkit-box-reflect: below 1px linear-gradient(transparent, #0004);
        }

        #clock #time div span {
            position: relative;
            display: block;
            width: 100px;
            height: 80px;
            background: #2196f3;
            color: #fff;
            font-weight: 300;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 3em;
            z-index: 10;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
        }

        #clock #time div span:nth-child(2) {
            height: 30px;
            font-size: 0.7em;
            letter-spacing: 0.2em;
            font-weight: 500;
            z-index: 9;
            box-shadow: none;
            background: #127fd6;
            text-transform: uppercase;
        }

        #clock #time div:nth-last-child(2) span {
            background: #ff006a;
        }

        #clock #time div:nth-last-child(2) span:nth-child(2) {
            background: #ec0062;
        }

        #clock #time div:nth-last-child(1) span {
            position: absolute;
            bottom: 0;
            width: 60px;
            height: 40px;
            font-size: 1.5em;
            background: #fff;
            color: #000;
            -webkit-box-reflect: below 1px linear-gradient(transparent, #0004);
        }
    </style>
    <body>
    <div id="clock">
        <h2>{{\Carbon\Carbon::now()->format('l, jS \of F Y')}}</h2>
        <h2>Time is</h2>
        <div id="time">
            <div>
                <span id="hours">00</span>
                <span>Hours</span>
            </div>
            <div>
                <span id="minutes">00</span>
                <span>Minutes</span>
            </div>
            <div>
                <span id="seconds">00</span>
                <span>Seconds</span>
            </div>
            <div>
                <span id="phase">AM</span>
            </div>
        </div>
    </div>
    <script>
        function clock() {
            var hours = document.getElementById("hours");
            var minutes = document.getElementById("minutes");
            var seconds = document.getElementById("seconds");
            var phase = document.getElementById("phase");



            var h = new Date().getHours();
            var m = new Date().getMinutes();
            var s = new Date().getSeconds();
            var am = "AM";

            if (h > 12) {
                h = h - 12;
                var am = "PM";
            }

            h = h < 10 ? "0" + h : h;
            m = m < 10 ? "0" + m : m;
            s = s < 10 ? "0" + s : s;

            hours.innerHTML = h;
            minutes.innerHTML = m;
            seconds.innerHTML = s;
            phase.innerHTML = am;
        }

        var interval = setInterval(clock, 1000);
    </script>
@endsection
