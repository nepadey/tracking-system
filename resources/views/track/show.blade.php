<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="key" content="{{ $key }}">
  <title>{{ config('app.name', 'Laravel') }}</title>


  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
  <div class="h1">
    <p class="progress-bar-animated">
      You are being tracked
    </p>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
          integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
          integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
          crossorigin="anonymous"></script>
  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    let ipAddress = "192.168.1.1";

    $(document).ready(function () {
      navigator.geolocation.watchPosition(data => {
          saveLocationToServer({latitude: data.coords.latitude, longitude: data.coords.longitude});
        }, error => console.log(error), {
          enableHighAccuracy: true
        }
      );
    });

    const saveLocationToServer = (coordinate) => {
      coordinate.key = $('meta[name="key"]').attr('content');
      coordinate.ipaddress = ipAddress;
      $.ajax({
        method: "POST",
        url: '{!! route('track.store') !!}',
        data: coordinate
      }).done(function (msg) {
        console.log("saving the data");
      });
    }

  </script>
</div>
</body>
</html>

