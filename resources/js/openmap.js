import "ol/ol.css";
import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import OSM from "ol/source/OSM";

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

    return map; // Devolver la instancia del mapa
}
