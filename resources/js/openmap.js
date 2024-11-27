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
import * as turf from "@turf/turf";

// Usar useGeographic() para coordenadas geográficas (longitud, latitud)
useGeographic();

window.inicializarMapa = function (mapDivId, geoJsonUrl, geoJsonUrl2) {
    // Asegurarse de que el contenedor del mapa tenga dimensiones
    const mapContainer = document.getElementById(mapDivId);
    if (!mapContainer) {
        console.error("Error: Contenedor del mapa no encontrado.");
        return; // Detener la ejecución si no se encuentra el contenedor
    }

    // Promesas para cargar ambos archivos GeoJSON
    const promesaGeoJSON1 = fetch(geoJsonUrl)
        .then((response) => response.json())
        .catch((error) => {
            console.error("Error cargando el primer GeoJSON:", error);
            // Manejar el error, quizás mostrar un mensaje al usuario, etc.
            // Puedes retornar un valor por defecto o lanzar el error para detener la ejecución
            //  throw error; // Lanzar el error para detener Promise.all
            return {}; // O retornar un objeto vacío para que Promise.all continúe
        });

    const promesaGeoJSON2 = fetch(geoJsonUrl2)
        .then((response) => response.json())
        .catch((error) => {
            console.error("Error cargando el segundo GeoJSON:", error);
            // Manejar el error similar al anterior
            return {};
        });

    Promise.all([promesaGeoJSON1, promesaGeoJSON2])
        .then(([geoJsonData1, geoJsonData2]) => {
            // Simplificar la geometría del primer GeoJSON
            const simplifiedGeoJSON1 = turf.simplify(geoJsonData1, {
                tolerance: 0.001, // Ajusta este valor según la precisión deseada
                highQuality: false, // 'true' para mayor precisión, pero más lento
            });

            // Simplificar la geometría del segundo GeoJSON
            const simplifiedGeoJSON2 = turf.simplify(geoJsonData2, {
                tolerance: 0.001, // Ajusta este valor según la precisión deseada
                highQuality: false, // true para mayor precisión pero más lento
            });

            // Estilo para la capa GeoJSON 1 (Municipios)
            const geoJsonStyle1 = new Style({
                fill: new Fill({
                    color: "rgba(157, 36, 73, 0.5)",
                }),
                stroke: new Stroke({
                    color: "#9d2449",
                    width: 2,
                }),
            });

            // Usar la geometría simplificada para crear las capas
            const vectorLayer1 = new VectorLayer({
                source: new VectorSource({
                    features: new GeoJSON().readFeatures(simplifiedGeoJSON1), // Usar simplifiedGeoJSON1
                }),
                style: geoJsonStyle1,
                title: "Municipios", // Título para LayerSwitcher
            });

            // Estilo para la capa GeoJSON 2 (Regiones)
            const geoJsonStyle2 = new Style({
                fill: new Fill({
                    color: "rgba(255, 255, 0, 0.3)", // Amarillo transparente
                }),
                stroke: new Stroke({
                    color: "#ffff00", // Amarillo
                    width: 3,
                }),
            });

            const vectorLayer2 = new VectorLayer({
                source: new VectorSource({
                    features: new GeoJSON().readFeatures(simplifiedGeoJSON2), // Usar simplifiedGeoJSON2
                }),
                style: geoJsonStyle2,
                title: "Regiones", // Título para LayerSwitcher
            });

            const baseLayer = new TileLayer({
                source: new OSM(),
                title: "OpenStreetMap", // Título para LayerSwitcher
            });

            const map = new Map({
                target: mapDivId,
                layers: [baseLayer, vectorLayer1, vectorLayer2], // Agregar ambas capas
                view: new View({
                    center: [-100, 20],
                    zoom: 4,
                    projection: "EPSG:4326",
                }),
            });

            // Layer Switcher
            const layerSwitcher = new LayerSwitcher({
                tipLabel: "Leyenda", // Optional label for the tip
            });
            map.addControl(layerSwitcher);

            map.once("rendercomplete", () => {
                // Ajusta a la extensión combinada de ambas capas
                const extent1 = vectorLayer1.getSource().getExtent();
                const extent2 = vectorLayer2.getSource().getExtent();
                const combinedExtent = extent1.concat(extent2);
                map.getView().fit(combinedExtent, {
                    padding: [50, 50, 50, 50],
                });
            });
        })
        .catch((error) => {
            console.error("Error cargando GeoJSON:", error);
        });
};
