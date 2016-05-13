<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0-rc.1/leaflet.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.2.3/leaflet.draw.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.min.css" rel="stylesheet" type="text/css">
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            font-weight: 100;
        }

        .container {
            height: 100vh;
        }

        #map {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div id="map"></div>
    </div>
</div>
</body>

<script id="result-common-tpl" type="text/template">
    <div class="result">
        <div class="result__city-name"></div>
        <div class="result__street-name"></div>
        <div class="result__build-number"></div>

        <div class="result__companies"></div>
    </div>
</script>

<script id="result-firm-tpl" type="text/template">
    <div class="result__company">
        <div class="result__company-name"></div>
        <div class="result__company-phones"></div>
    </div>
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0-rc.1/leaflet-src.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.2.3/leaflet.draw.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>
<script>
    var $resultCommonTpl = $($('#result-common-tpl').html()),
            $resultCompanyTpl = $($('#result-company-tpl').html());

    var mapInstance = L.map('map').setView([55.041489, 82.963132], 12),
            markerLayers = new L.FeatureGroup(),
            shapeLayer = null;

    function addTiles(mapInstance) {
        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a rel="nofollow" href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapInstance);
    }

    function addMarkers(mapInstance, buildings) {
        buildings.forEach(function (build) {
            var coords = build.location.coordinates,
                    options = { buildData: build };

            markerLayers.addLayer(
                    L.marker([coords[0], coords[1]], options)
                            .addTo(mapInstance)
                            .on('click', clickMarkerHandler)
            );
        });
    }

    addTiles(mapInstance);

    var editableLayers = new L.FeatureGroup();
    mapInstance.addLayer(editableLayers);

    var options = {
        position: 'topright',
        draw: {
            polyline: false,
            polygon: false,
            circle: true,
            marker: false,
            rectangle: {
                shapeOptions: {
                    clickable: false
                }
            }
        },
        edit: false
    };

    var drawControl = new L.Control.Draw(options);
    mapInstance.addControl(drawControl);

    mapInstance.on('draw:created', function (e) {
        var type = e.layerType, layer = e.layer;

        shapeLayer && mapInstance.removeLayer(shapeLayer);

        if (type === 'marker') {
            layer.bindPopup('A popup!');
        }

        switch (type) {
            case 'circle':
                prepareCircleFetch(e);
                break;
            case 'rectangle':
                prepareRectangleFetch(e);
        }

        shapeLayer = layer;
        mapInstance.addLayer(layer);
    });

    function prepareCircleFetch(e) {
        var payload = {
            type: 'circle',
            coords: [e.layer.getLatLng().lat, e.layer.getLatLng().lng],
            radius: e.layer.getRadius().toFixed(),
        };

        fetchCompanies(payload);
    }

    function prepareRectangleFetch(e) {
        var coords = e.layer.getLatLngs()[0];
        var payload = {
            type: 'rectangle',
            coords: [coords[0].lat, coords[0].lng, coords[2].lat, coords[2].lng]
        };

        fetchCompanies(payload);
    }

    function fetchCompanies(payload) {
        fetch('{{ route('api:v1:companies.search_gis') }}?' + $.param(payload))
                .then(function (res) {
                    return res.json();
                })
                .then(function (res) {
                    var buildings = normalizeResponse(res);

                    markerLayers.eachLayer(function (layer) {
                        mapInstance.removeLayer(layer);
                    });

                    addMarkers(mapInstance, buildings);
                });
    }

    function normalizeResponse(res) {
        var cacheIds = [];
        var result = [];

        res.result.forEach(function (company) {
            if (cacheIds.indexOf(company.build.id) === -1) {
                cacheIds.push(company.build.id);
                result.push(company.build);
            }
        });

        return result;
    }

    //    function fetchCompanies(payload) {
    //        return fetch('/api/v1/companies?' + $.param(payload))
    //                .then(function (res) {
    //                    return res.json();
    //                });
    //    }

    function clickMarkerHandler(marker) {
        var payload = {
            id: marker.target.options.buildData.id,
        };

        fetchCompanies(payload)
                .then(function (res) {
                    console.log(res);
                });
    }
</script>
</html>
