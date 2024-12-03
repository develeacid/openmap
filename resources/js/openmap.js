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

// Configuración inicial
useGeographic();

const CONFIG = {
    initialCenter: [-100, 20],
    initialZoom: 4,
    initialGeoJsonUrl: "/GeoJson/Regiones.geojson",
    tileUrls: {
        worldImagery:
            "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
    },
    styles: {
        geoJson: new Style({
            fill: new Fill({ color: "rgba(157, 36, 73, 0.5)" }),
            stroke: new Stroke({ color: "#9d2449", width: 2 }),
        }),
        highlight: new Style({
            fill: new Fill({ color: "rgba(255, 0, 0, 0.3)" }),
            stroke: new Stroke({ color: "#FF0000", width: 3 }),
        }),
    },
};

// Inicializa la función global
window.inicializarMapa = function (mapDivId, geoJsonUrl) {
    const mapContainer = document.getElementById(mapDivId);
    if (!mapContainer) {
        console.error("Error: Contenedor del mapa no encontrado.");
        return;
    }

    let currentLayerType = "region";
    let map = null;

    // Cargar GeoJSON y actualizar el mapa
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
                    const vectorLayer = new VectorLayer({
                        source: vectorSource,
                        style: CONFIG.styles.geoJson,
                        title: "Capa Vectorial",
                    });
                    map = createMap(mapDivId, vectorLayer);
                    addInteractionsToMap(map, vectorLayer);
                    addLayerSwitcherToMap(map);
                } else {
                    map.getLayers().item(2).setSource(vectorSource);
                }

                currentLayerType = nextLayerType;
                map.getView().fit(vectorSource.getExtent(), {
                    padding: [50, 50, 50, 50],
                });
            })
            .catch((error) => console.error("Error cargando GeoJSON:", error));
    }

    // Crear el mapa principal
    function createMap(mapDivId, vectorLayer) {
        const osmLayer = new TileLayer({
            source: new OSM(),
            title: "OpenStreetMap",
            visible: true,
        });
        const worldImageryLayer = new TileLayer({
            source: new XYZ({
                url: CONFIG.tileUrls.worldImagery,
                projection: "EPSG:3857",
            }),
            title: "World Imagery",
            visible: false,
        });

        return new Map({
            target: mapDivId,
            layers: [osmLayer, worldImageryLayer, vectorLayer],
            view: new View({
                center: CONFIG.initialCenter,
                zoom: CONFIG.initialZoom,
                projection: "EPSG:4326",
            }),
        });
    }

    // Agregar interacciones al mapa
    function addInteractionsToMap(map, vectorLayer) {
        const tooltipElement = createTooltipElement();
        const infoDiv = createInfoDiv(mapContainer);

        const tooltipOverlay = new Overlay({
            element: tooltipElement,
            offset: [0, -15],
            positioning: "bottom-center",
        });
        map.addOverlay(tooltipOverlay);

        map.on("pointermove", (evt) =>
            handlePointerMove(
                evt,
                map,
                vectorLayer,
                tooltipElement,
                tooltipOverlay,
                infoDiv
            )
        );
        map.on("click", (evt) => handleClick(evt, map));
        map.on("dblclick", (evt) => handleDblClick(evt, map, vectorLayer));
    }

    // Agregar un selector de capas
    function addLayerSwitcherToMap(map) {
        const layerSwitcher = new LayerSwitcher({
            tipLabel: "Selector de Capas",
            title: "Control de Capas",
            groupSelectStyle: "children",
        });
        map.addControl(layerSwitcher);
    }

    // Crear elementos adicionales para la UI
    function createTooltipElement() {
        const tooltipElement = document.createElement("div");
        tooltipElement.className = "tooltip";
        return tooltipElement;
    }

    function createInfoDiv(mapContainer) {
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
            font-size: 12px;
        `;
        mapContainer.parentNode.appendChild(infoDiv);
        return infoDiv;
    }

    // Eventos del mapa
    function handlePointerMove(
        evt,
        map,
        vectorLayer,
        tooltipElement,
        tooltipOverlay,
        infoDiv
    ) {
        const feature = map.forEachFeatureAtPixel(evt.pixel, (f, layer) =>
            layer === vectorLayer ? f : null
        );
        if (feature) {
            tooltipElement.innerHTML = feature.get("NOMGEO") || "";
            tooltipOverlay.setPosition(
                feature.getGeometry() ? evt.coordinate : undefined
            );

            infoDiv.innerHTML = Object.entries(feature.getProperties())
                .map(([key, value]) => `${key}: ${value}`)
                .join("<br>");
        } else {
            tooltipOverlay.setPosition(undefined);
            infoDiv.innerHTML = "";
        }
    }

    function handleClick(evt, map) {
        const feature = map.forEachFeatureAtPixel(evt.pixel, (f) => f);
        if (feature) {
            const region = feature.get("region");
            const cveMun = feature.get("CVE_MUN");
            window.livewire.emit("mapClick", { region, cveMun });
            console.log("Región:", region, "CVE_MUN:", cveMun);
        }
    }

    function handleDblClick(evt, map, vectorLayer) {
        const feature = map.forEachFeatureAtPixel(evt.pixel, (f) => f);
        if (feature) {
            const nextLayerType =
                currentLayerType === "region" ? "municipio" : "detalle";
            const identifierKey =
                currentLayerType === "region" ? "region" : "CVE_MUN";
            const identifierValue = feature.get(identifierKey);

            if (identifierValue) {
                const newGeoJsonUrl = `/GeoJson/${
                    currentLayerType === "region" ? "regionales" : "municipales"
                }/${identifierValue}.geojson`;
                loadGeoJson(newGeoJsonUrl, nextLayerType);
            }
        }
    }

    loadGeoJson(geoJsonUrl, currentLayerType);

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

    function resetToRegionLayer(region) {
        // Construir la URL del archivo GeoJSON para la región seleccionada
        const geoJsonUrl = `/GeoJson/regionales/${region}.geojson`;

        // Llamar a la función loadGeoJson para cargar la capa del mapa correspondiente a la región
        loadGeoJson(geoJsonUrl, "region");

        // Emitir evento Livewire para restablecer el breadcrumb
        window.livewire.emit("breadcrumbReset", {
            region: region,
            municipio: null,
        });

        console.log(`Mapa restablecido a la capa de la región: ${region}`);
    }

    // Asignamos la función al objeto global para que se pueda llamar desde el HTML
    window.resetMapLayerRegion = resetToRegionLayer;
};
