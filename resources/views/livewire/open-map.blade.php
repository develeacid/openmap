<div>
    <script src="https://openlayers.org/en/v6.15.1/build/ol.js"></script>
    <style>
        .map {
            height: 400px;
            width: 100%;
        }
    </style>
    <h1>open map livewire</h1>
    <div id="map" class="map"></div>

    <script type="text/javascript">
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({   

            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([-96.7266, 17.0732]), // Centra el mapa en Oaxaca
          zoom: 8
        })
      });
    </script>

</div>
