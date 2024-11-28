// openmap.js
import "ol/ol.css";
import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import OSM from "ol/source/OSM";

import GeoJSON from "ol/format/GeoJSON";
import VectorLayer from "ol/layer/Vector";
import VectorSource from "ol/source/Vector";
import { Fill, Stroke, Style } from "ol/style";
import { useGeographic } from "ol/proj"; // Importar useGeographic
// LayerSwitcher (asegúrate de tenerlo instalado: npm install ol-layerswitcher)
import LayerSwitcher from "ol-layerswitcher";
//suavisar poligonos
import * as turf from "@turf/turf";
//efecto hover
import { pointerMove } from "ol/events/condition";
import Select from "ol/interaction/Select";

// Usar useGeographic() para coordenadas geográficas (longitud, latitud)
useGeographic();

window.inicializarMapa = function (mapDivId, geoJsonUrl) {
    // Asegurarse de que el contenedor del mapa tenga dimensiones
    const mapContainer = document.getElementById(mapDivId);
    if (!mapContainer) {
        console.error("Error: Contenedor del mapa no encontrado.");
        return; // Detener la ejecución si no se encuentra el contenedor
    }

    fetch(geoJsonUrl)
        .then((response) => response.json())
        .then((geoJsonData) => {
            // Simplificar la geometría
            const simplifiedGeoJSON = turf.simplify(geoJsonData, {
                tolerance: 0.001,
                highQuality: false,
            });

            const geoJsonStyle = new Style({
                fill: new Fill({
                    color: "rgba(157, 36, 73, 0.5)",
                }),
                stroke: new Stroke({
                    color: "#9d2449",
                    width: 2,
                }),
            });

            const vectorLayer = new VectorLayer({
                source: new VectorSource({
                    features: new GeoJSON().readFeatures(simplifiedGeoJSON),
                }),
                style: geoJsonStyle,
                title: "Municipios", // Título para LayerSwitcher
            });

            const baseLayer = new TileLayer({
                source: new OSM(),
                title: "OpenStreetMap",
            });

            const map = new Map({
                target: mapDivId,
                layers: [baseLayer, vectorLayer], // Solo una capa vectorial
                view: new View({
                    center: [-100, 20], // Ajusta el centro inicial si es necesario
                    zoom: 4, // Ajusta el zoom inicial si es necesario
                    projection: "EPSG:4326",
                }),
            });

            // Estilo para el hover
            const highlightStyle = new Style({
                fill: new Fill({
                    color: "rgba(255, 0, 0, 0.3)",
                }),
                stroke: new Stroke({
                    color: "#FF0000",
                    width: 3,
                }),
            });

            const hoverInteraction = new Select({
                condition: pointerMove,
                style: highlightStyle,
                filter: (feature, layer) => {
                    return layer === vectorLayer; // Filtra solo interacciones con vectorLayer.
                },
            });
            map.addInteraction(hoverInteraction);

            const layerSwitcher = new LayerSwitcher({
                tipLabel: "Leyenda",
            });
            map.addControl(layerSwitcher);

            // Ajustar a la extensión de la capa cargada
            map.getView().fit(vectorLayer.getSource().getExtent(), {
                padding: [50, 50, 50, 50], // Ajusta el padding según sea necesario
            });
        })
        .catch((error) => {
            console.error("Error cargando GeoJSON:", error);
        });
};
