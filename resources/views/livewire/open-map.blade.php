<div>
  <div id="map" class="map"></div> 

  <script type="module">
    import { inicializarMapa } from '../../js/openmap.js'; 
    import '../../css/openmap.css'; 

    document.addEventListener('livewire:load', function () {
      inicializarMapa('map'); 
    });
  </script>
</div>