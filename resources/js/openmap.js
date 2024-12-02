// openmap.js
import "ol/ol.css";
import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import OSM from "ol/source/OSM";
import XYZ from "ol/source/XYZ";
import GeoJSON from "ol/format/GeoJSON";
import VectorLayer from "ol/layer/Vector";
import VectorSource from "ol/source/Vector";
import { Fill, Stroke, Style } from "ol/style";
import { useGeographic } from "ol/proj";
import LayerSwitcher from "ol-layerswitcher";
import "../css/layerswitcher.css";
import * as turf from "@turf/turf";
import { pointerMove } from "ol/events/condition";
import Select from "ol/interaction/Select";
import Overlay from "ol/Overlay";

useGeographic();

const geoJsonStyle = new Style({
    fill: new Fill({
        color: "rgba(157, 36, 73, 0.5)",
    }),
    stroke: new Stroke({
        color: "#9d2449",
        width: 2,
    }),
});

const highlightStyle = new Style({
    fill: new Fill({
        color: "rgba(255, 0, 0, 0.3)",
    }),
    stroke: new Stroke({
        color: "#FF0000",
        width: 3,
    }),
});

const baseLayer = new TileLayer({
    source: new OSM(),
    title: "OpenStreetMap",
});

window.inicializarMapa = function (mapDivId, geoJsonUrl) {
    const mapContainer = document.getElementById(mapDivId);
    if (!mapContainer) {
        console.error("Error: Contenedor del mapa no encontrado.");
        return;
    }

    let currentLayerType = "region";
    let map = null; // Declarar map fuera para que sea accesible en otras funciones

    function loadGeoJson(url, nextLayerType) {
        fetch(url)
            .then((response) => response.json())
            .then((geoJsonData) => {
                const simplifiedGeoJSON = turf.simplify(geoJsonData, {
                    tolerance: 0.001,
                    highQuality: false,
                });
                const vectorSource = new VectorSource({
                    features: new GeoJSON().readFeatures(simplifiedGeoJSON),
                });

                if (!map) {
                    //Si es la primera vez, crea todo.  Si no, solo actualiza
                    const vectorLayer = new VectorLayer({
                        source: vectorSource,
                        style: geoJsonStyle,
                        title: "Municipios",
                    });
                    map = createMap(mapDivId, vectorLayer); // Crea el mapa una sola vez
                    addInteractionsToMap(map, vectorLayer); // Agrega las interacciones una sola vez
                    addLayerSwitcherToMap(map); // Agrega el control de capas una sola vez
                } else {
                    map.getLayers().item(2).setSource(vectorSource); // Actualizar capa vectorial en la posición 2
                }

                currentLayerType = nextLayerType;
                map.getView().fit(vectorSource.getExtent(), {
                    padding: [50, 50, 50, 50],
                });
            })
            .catch((error) => console.error("Error cargando GeoJSON:", error));
    }

    function resetToInitialLayer() {
        const initialGeoJsonUrl = "/GeoJson/Regiones.geojson"; // Ruta de la capa inicial
        loadGeoJson(initialGeoJsonUrl, "region");

        // Emitir evento Livewire para actualizar el breadcrumb
        window.livewire.emit("breadcrumbReset", {
            region: null,
            municipio: null,
        });

        console.log("Mapa restablecido a la capa inicial.");
    }

    window.resetMapLayer = resetToInitialLayer;

    //Encapsula la creación del mapa.
    function createMap(mapDivId, vectorLayer) {
        // Definir capas base
        const osmLayer = new TileLayer({
            source: new OSM(),
            title: "OpenStreetMap",
            visible: true,
        });

        const worldImageryLayer = new TileLayer({
            source: new XYZ({
                url: "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
                attributions:
                    "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
                projection: "EPSG:3857", // Agregar la proyección aquí
            }),
            title: "World Imagery",
            visible: false,
        });

        const map = new Map({
            target: mapDivId,
            layers: [osmLayer, worldImageryLayer, vectorLayer], // Agregar capas base
            view: new View({
                center: [-100, 20],
                zoom: 4,
                projection: "EPSG:4326",
            }),
        });
        return map;
    }

    function addInteractionsToMap(map, vectorLayer) {
        //Encapsula las interacciones del mapa.

        const tooltipElement = document.createElement("div");
        tooltipElement.className = "tooltip";

        const tooltipOverlay = new Overlay({
            element: tooltipElement,
            offset: [0, -15],
            positioning: "bottom-center",
        });
        map.addOverlay(tooltipOverlay);

        // Elemento div fuera del mapa para mostrar la información
        const infoDiv = document.createElement("div");
        infoDiv.id = "feature-info";
        infoDiv.style.cssText = `
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: white;
        padding: 10px;
        border: 1px solid gray;
        z-index: 100;
        font-size: 12px; // Tamaño de letra más pequeño
    `;

        mapContainer.parentNode.appendChild(infoDiv); // Agregar el div al contenedor padre del mapa

        map.on("pointermove", (evt) => {
            const feature = map.forEachFeatureAtPixel(evt.pixel, (f, layer) => {
                if (layer === vectorLayer) {
                    return f;
                }
            });

            if (feature) {
                // Mostrar NOMGEO en el tooltip
                tooltipElement.innerHTML = feature.get("NOMGEO") || "";
                tooltipOverlay.setPosition(
                    feature.getGeometry() ? evt.coordinate : undefined
                );

                // Mostrar todas las propiedades en el div externo
                const properties = feature.getProperties();
                const infoText = Object.entries(properties)
                    .map(([key, value]) => `${key}: ${value}`)
                    .join("<br>");
                infoDiv.innerHTML = infoText;
            } else {
                tooltipOverlay.setPosition(undefined);
                infoDiv.innerHTML = "";
            }
        });

        const hoverInteraction = new Select({
            condition: pointerMove,
            style: highlightStyle,
            filter: (feature, layer) => layer === vectorLayer,
        });

        map.addInteraction(hoverInteraction);

        map.on("click", function (evt) {
            const feature = map.forEachFeatureAtPixel(evt.pixel, (f) => f);
            if (feature) {
                const region = feature.get("region");
                const cveMun = feature.get("CVE_MUN");
                window.livewire.emit("mapClick", { region, cveMun });
                console.log("Región:", region, "CVE_MUN:", cveMun);
            }
        });

        map.on("dblclick", function (evt) {
            const feature = map.forEachFeatureAtPixel(evt.pixel, (f) => f);
            if (feature) {
                const nextLayerType =
                    currentLayerType === "region" ? "municipio" : "detalle";

                const identifierKey =
                    currentLayerType === "region" ? "region" : "CVE_MUN";
                const identifierValue = feature.get(identifierKey);

                if (identifierValue) {
                    const newGeoJsonUrl = `/GeoJson/${
                        currentLayerType === "region"
                            ? "regionales"
                            : "municipales"
                    }/${identifierValue}.geojson`;
                    loadGeoJson(newGeoJsonUrl, nextLayerType);
                }
            }
        });
    }

    function addLayerSwitcherToMap(map) {
        //Encapsula layer switcher
        const layerSwitcher = new LayerSwitcher({
            tipLabel: "Selector de Capas",
            title: '<div class="layer-switcher-title"><h2>Control de Capas</h2></div>',
            instructions:
                '<div class="layer-switcher-instructions"><p>Selecciona las capas que deseas mostrar.</p></div>',
            groupSelectStyle: "children",
        });
        map.addControl(layerSwitcher);
    }

    loadGeoJson(geoJsonUrl, currentLayerType); // Carga inicial
};
