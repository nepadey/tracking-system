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

    .marker {
      background-image: url('/marker.jpeg');
      background-size: cover;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      cursor: pointer;
    }

    .mapboxgl-popup {
      max-width: 200px;
    }

    .mapboxgl-popup-content {
      text-align: center;
      font-family: 'Open Sans', sans-serif;
    }

  </style>
@endsection

@section("content")
  <div id="map"></div>
@endsection

@section("custom_script")
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js"></script>
  <script>

    mapboxgl.accessToken = 'pk.eyJ1IjoiYWthc2gwOXN0aGEiLCJhIjoiY2wyYTkybXAxMDBrODNlbzhzdndhbTlqZyJ9.xEgP1psFbWbw65Xm92O9RA';

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
          let center = coordinates[parseInt(coordinates.length / 2)]
          const lastLocation = [coordinateList[coordinates.length - 1].lng, coordinateList[coordinates.length - 1].lat];
          let map = generateMap(center);
          generateRouteMap(map, coordinates);
          generateMapMarker(map, lastLocation);
        })


      generateMapMarker();
    })

    const getLocationData = () => {
      return $.ajax({
        method: "POST",
        url: '{!! route('device.location_history',['id'=> $device->id]) !!}',
        dataType: 'json',
      })
    }

    const generateMap = (center) => {
      return new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: center,
        zoom: 15
      });
    }

    const generateRouteMap = (map, coordinates) => {
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

    const generateMapMarker = (map, location) => {
      const geojson = {
        'type': 'FeatureCollection',
        'features': [
          {
            'type': 'Feature',
            'geometry': {
              'type': 'Point',
              'coordinates': location
            },
            'properties': {
              'title': 'Mapbox',
              'description': 'Washington, D.C.'
            }
          }
        ]
      };

      // add markers to map
      const el = document.createElement('div');
      el.className = 'marker';
      const feature = geojson.features[0]
      // make a marker for each feature and add it to the map
      new mapboxgl.Marker(el)
        .setLngLat(feature.geometry.coordinates)
        .setPopup(
          new mapboxgl.Popup({offset: 25}) // add popups
            .setHTML(
              `<h3>${feature.properties.title}</h3><p>${feature.properties.description}</p>`
            )
        )
        .addTo(map);
    }

  </script>
@endsection
