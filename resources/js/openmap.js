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
            // Crear un estilo para la capa GeoJSON
            const geoJsonStyle = new Style({
                fill: new Fill({
                    color: "rgba(157, 36, 73, 0.5)", // Relleno semi-transparente
                }),
                stroke: new Stroke({
                    color: "#9d2449", // Color del borde
                    width: 2, // Ancho del borde
                }),
            });

            // Crear la capa vectorial con los datos GeoJSON y el estilo
            const vectorLayer = new VectorLayer({
                source: new VectorSource({
                    features: new GeoJSON().readFeatures(geoJsonData),
                }),
                style: geoJsonStyle, // Aplicar el estilo
            });

            // Crear la capa base (puedes usar OSM u otra)
            const baseLayer = new TileLayer({
                source: new OSM(),
            });

            const map = new Map({
                target: mapDivId,
                layers: [baseLayer, vectorLayer],
                view: new View({
                    center: [-100, 20], //  Si son coordenadas geográficas
                    zoom: 4,
                    projection: "EPSG:4326", // Especificar la proyección
                }),
            });

            // Ajustar la vista una vez el mapa esté renderizado
            map.once("rendercomplete", () => {
                const extent = vectorLayer.getSource().getExtent();
                map.getView().fit(extent, { padding: [50, 50, 50, 50] });
            });
        })
        .catch((error) => {
            console.error("Error cargando GeoJSON:", error);
        });
};
