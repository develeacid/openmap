//openlayer
import "ol/ol.css";
import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import OSM from "ol/source/OSM";
//layerswitcher
import "ol-layerswitcher/dist/ol-layerswitcher.css";
import LayerSwitcher from "ol-layerswitcher";

export function inicializarMapa(mapElementId) {
    const map = new Map({
        target: mapElementId,
        layers: [
            new TileLayer({
                source: new OSM(),
            }),
        ],
        view: new View({
            center: ol.proj.fromLonLat([-96.7266, 17.0732]),
            zoom: 8,
        }),
    });

    // Agregar LayerSwitcher al mapa
    var layerSwitcher = new LayerSwitcher({
        tipLabel: "Leyenda", // Opcional: cambia el texto del tooltip
    });
    map.addControl(layerSwitcher);

    return map; // Devolver la instancia del mapa
}
