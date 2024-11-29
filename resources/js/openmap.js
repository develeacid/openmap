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
// Create this file for your custom styles
import "../css/layerswitcher.css"; // Importa tu CSS aquí
//suavisar poligonos
import * as turf from "@turf/turf";
//efecto hover
import { pointerMove } from "ol/events/condition";
import Select from "ol/interaction/Select";
import Overlay from "ol/Overlay"; // Import the Overlay class

// Usar useGeographic() para coordenadas geográficas (longitud, latitud)
useGeographic();

window.inicializarMapa = function (mapDivId, geoJsonUrl) {
    // Asegurarse de que el contenedor del mapa tenga dimensiones
    const mapContainer = document.getElementById(mapDivId);
    if (!mapContainer) {
        console.error("Error: Contenedor del mapa no encontrado.");
        return; // Detener la ejecución si no se encuentra el contenedor
    }

    let currentLayerType = "region"; // Controla el nivel de la capa: 'region' o 'municipio'

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

            // Manejar el evento de doble clic
            map.on("dblclick", function (evt) {
                const feature = map.forEachFeatureAtPixel(evt.pixel, (f) => f);
                if (feature) {
                    if (currentLayerType === "region") {
                        const region = feature.get("region"); // Obtener la región
                        if (region) {
                            const newGeoJsonUrl = `/GeoJson/regionales/${region}.geojson`;
                            loadNewLayer(
                                newGeoJsonUrl,
                                map,
                                vectorLayer,
                                "municipio"
                            );
                        }
                    } else if (currentLayerType === "municipio") {
                        const cveMun = feature.get("CVE_MUN"); // Obtener el municipio
                        if (cveMun) {
                            const newGeoJsonUrl = `/GeoJson/municipales/${cveMun}.geojson`;
                            loadNewLayer(
                                newGeoJsonUrl,
                                map,
                                vectorLayer,
                                "detalle"
                            );
                        }
                    }
                }
            });            // Función para obtener el nombre de la región y el identificador del municipio
            function getRegionAndMunicipality(feature) {
                const region = feature.get("region");
                const cveMun = feature.get("CVE_MUN");
                return { region, cveMun };
            }

            // Agregar un manejador de clic para mostrar la información en la consola
            map.on("click", function (evt) {
                const feature = map.forEachFeatureAtPixel(evt.pixel, (f) => f);
                if (feature) {
                    const { region, cveMun } = getRegionAndMunicipality(feature);
                    console.log("Región:", region);
                    console.log("CVE_MUN:", cveMun);
                }
            });


            // Función para cargar nuevas capas
            function loadNewLayer(url, map, vectorLayer, nextLayerType) {
                fetch(url)
                    .then((response) => response.json())
                    .then((newGeoJsonData) => {
                        const newFeatures = new GeoJSON().readFeatures(
                            newGeoJsonData
                        );
                        const source = new VectorSource({
                            features: newFeatures,
                        });
                        vectorLayer.setSource(source); // Actualizar la fuente de la capa vectorial
                        currentLayerType = nextLayerType; // Actualizar el tipo de capa actual

                        // Ajustar la vista al nuevo contenido
                        map.getView().fit(source.getExtent(), {
                            padding: [50, 50, 50, 50],
                        });
                    })
                    .catch((error) => {
                        console.error(
                            "Error cargando nueva capa GeoJSON:",
                            error
                        );
                    });
            }

            // Create an overlay element (the tooltip itself)
            const tooltipElement = document.createElement("div");
            tooltipElement.className = "tooltip"; // Add a CSS class for styling

            const tooltipOverlay = new Overlay({
                element: tooltipElement,
                offset: [0, -15], // Offset from the pointer
                positioning: "bottom-center", // Position relative to pointer
            });
            map.addOverlay(tooltipOverlay);

            // Event listener for pointer move
            map.on("pointermove", function (evt) {
                const pixel = evt.pixel;
                const feature = map.forEachFeatureAtPixel(
                    pixel,
                    function (feature) {
                        return feature;
                    }
                );

                if (feature) {
                    const nomgeo = feature.get("NOMGEO"); // Get the NOMGEO property
                    if (nomgeo) {
                        tooltipElement.innerHTML = nomgeo;
                        tooltipOverlay.setPosition(evt.coordinate);
                    } else {
                        tooltipOverlay.setPosition(undefined); // Hide if no NOMGEO
                    }
                } else {
                    tooltipOverlay.setPosition(undefined); // Hide tooltip if no feature
                }
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
                tipLabel: "Selector de Capas", // Texto de ayuda
                title: '<div class="layer-switcher-title"><h2>Control de Capas</h2></div>', // Título personalizado
                instructions:
                    '<div class="layer-switcher-instructions"><p>Selecciona las capas que deseas mostrar.</p></div>', // Instrucciones
                groupSelectStyle: "children", //o 'group'|'none'
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
