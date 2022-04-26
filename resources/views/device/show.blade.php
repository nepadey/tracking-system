@extends("layouts.app")

@section("custom_style")
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    #map {
      margin: 80px;
      position: absolute;
      top: 0;
      bottom: 0;
      width: 60%;
    }
  </style>
@endsection

@section("content")
  <div id="map"></div>
@endsection

@section("custom_script")
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js"></script>
  <script>
    $(document).ready(function () {
      getLocationData()
        .then(coordinateList => {
          let coordinates = [];
          $.each(coordinateList, (key, value) => {
            let coordinate = [];
            coordinate.push(value.lng)
            coordinate.push(value.lat)
            coordinates.push(coordinate);
          })
          generateMap(coordinates)
        })
    })

    const getLocationData = () => {
      return $.ajax({
        method: "POST",
        url: '{!! route('device.location_history',['id'=> $device->id]) !!}',
        dataType: 'json',
      })
        // .done((data) => {
        //   console.log(data);
        // })
    }

    const generateMap = (coordinates) => {
      mapboxgl.accessToken = 'pk.eyJ1IjoiYWthc2gwOXN0aGEiLCJhIjoiY2wyYTkybXAxMDBrODNlbzhzdndhbTlqZyJ9.xEgP1psFbWbw65Xm92O9RA';
      let center = coordinates[parseInt(coordinates.length / 2)]
      const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: center,
        zoom: 15
      });
      map.on('load', () => {
        map.addSource('route', {
          'type': 'geojson',
          'data': {
            'type': 'Feature',
            'properties': {},
            'geometry': {
              'type': 'LineString',
              'coordinates': coordinates
            }
          }
        });
        map.addLayer({
          'id': 'route',
          'type': 'line',
          'source': 'route',
          'layout': {
            'line-join': 'round',
            'line-cap': 'round'
          },
          'paint': {
            'line-color': '#888',
            'line-width': 8
          }
        });
      });
    }
  </script>
@endsection
