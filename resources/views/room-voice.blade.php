<!doctype html>
<html lang="{{ app()->getLocale() }}">
<script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
<script>
    function trackAdded(div, track) {
        div.appendChild(track.attach());
        var video = div.getElementsByTagName("video")[0];
        if (video) {
            video.setAttribute("style", "max-width:300px;");
        }
    }

    function trackRemoved(track) {
        track.detach().forEach( function(element) { element.remove() });
    }
    function participantConnected(participant) {
        console.log('Participant "%s" connected', participant.identity);

        const div = document.createElement('div');
        div.id = participant.sid;
        div.setAttribute("class", "voice-box , ripleout");
        var txt="<div class='voice-box-title'>" +participant.identity +"</div>"
        div.innerHTML = txt;

        participant.tracks.forEach(function(track) {
            trackAdded(div, track)
        });

        participant.on('trackAdded', function(track) {
            trackAdded(div, track)
        });
        participant.on('trackRemoved', trackRemoved);

        document.getElementById('media-div').appendChild(div);
    }

    function participantDisconnected(participant) {
        console.log('Participant "%s" disconnected', participant.identity);

        participant.tracks.forEach(trackRemoved);
        document.getElementById(participant.sid).remove();
    }
    Twilio.Video.createLocalTracks({
        audio: true,
        video: false
    }).then(function (localTracks) {
        return Twilio.Video.connect('{{ $accessToken }}', {
            name: '{{ $roomName }}',
            tracks: localTracks,
            video: false
        });
    }).then(function (room) {
        console.log('Successfully joined a Room: ', room.name);

        room.participants.forEach(participantConnected);

        var previewContainer = document.getElementById(room.localParticipant.sid);
        if (!previewContainer || !previewContainer.querySelector('video')) {
            participantConnected(room.localParticipant);
        }

        room.on('participantConnected', function (participant) {
            console.log("Joining: '"+
            participant.identity+
            "'"
        )
            ;
            participantConnected(participant);
        });

        room.on('participantDisconnected', function (participant) {
            console.log("Disconnected: '"+
            participant.identity+
            "'"
        )
            ;
            participantDisconnected(participant);
        });
    });
    // additional functions will be added after this point
</script>
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
        <div class="title voice-title">
            <h3> <span class="fa fa-phone-square"></span>  voice Chat Rooms</h3>
        </div>
        <div id="media-div">
        </div>
    </div>
</div>
</body>
</html>
