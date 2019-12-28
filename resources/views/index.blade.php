<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="video conference and voice chat">
    <meta name="author" content="NikooWeb">

    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <title> video confrence  | voice chat </title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- font-awesome-->
    <link rel="stylesheet" href="{{asset('front/css/font-awesome.min.css')}}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/style.css')}}">

</head>
<body>

<div class="main">
    <div class="header">
         <a href="{{ url('/home') }}" class="btn logo-btn"> demo </a>
    </div>
    <div class="content">
        <div class="title">
            <h3> Video And Voice Chat Rooms </h3>
        </div>

        {!! Form::open(['url' => 'room/create']) !!}
        {!! Form::label('roomName', 'Create or Join a Room') !!}
        {!! Form::text('roomName') !!}
        {!! Form::submit('Go') !!}
        {!! Form::close() !!}

        @if($rooms)
            <div class="rooms-box">
                <h3 class="rooms-box-title"> Rooms </h3>
                @foreach ($rooms as $room)
                    <div class="room">
                        <span class="room-title">  {{ $room }} :  </span>
                        <a href="{{ url('/room/join/'.$room) }}" class="video-btn room-btn">video-chat </a>
                        <a href="{{ url('/room/join/voice/'.$room) }}" class="voice-btn room-btn">voice-chat </a>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

</body>
</html>
