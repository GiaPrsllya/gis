@extends('layout/secondLayout')

@section('title', 'Dashboard')

@section('content')
    <div class="row">

        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Titik Rawan Kecelakaan</p>
                    <p class="fs-30 mb-2">{{ $titikrawan }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-dark-blue"
                title="MD:{{ $total_md }} , LR: {{ $total_lr }}, LB:{{ $total_lb }} ">
                <div class="card-body">
                    <p class="mb-4">Jumlah Korban</p>
                    <p class="fs-30 mb-2">{{ $total_korban }}</p>
                    <small class="text-white">MD:{{ $total_md }} , LR: {{ $total_lr }}, LB:{{ $total_lb }} </small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-light-blue">
                <div class="card-body">
                    <p class="mb-4">Laporan Tahunan</p>
                    <p class="fs-30 mb-2">{{ count($tahun) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-light-danger">
                <div class="card-body">
                    <p class="mb-4">Users</p>
                    <p class="fs-30 mb-2">{{ $users }}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-6">
            <div id="map" class="map">
                <div id="popup"></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="kecelakaanChart" style="min-height:300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>

    <script type="text/javascript">
        // get current position from gps
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            const rasterLayer = new ol.layer.Tile({
                source: new ol.source.OSM(),
            });

            const iconFeature = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([lon, lat])),
                name: 'Posisi Anda',
                population: 4000,
                rainfall: 500,
            });

            const iconStyle = new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 46],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    src: 'https://openlayers.org/en/v4.6.5/examples/data/icon.png',
                }),
            });

            iconFeature.setStyle(iconStyle);

            const vectorSource = new ol.source.Vector({
                features: [iconFeature],
            });


            const vectorLayer = new ol.layer.Vector({
                source: vectorSource,
            });

            const map = new ol.Map({
                layers: [rasterLayer, vectorLayer],
                target: document.getElementById('map'),
                view: new ol.View({
                    center: ol.proj.fromLonLat([lon, lat]),
                    zoom: 15,
                }),
            });
            const element = document.getElementById('popup');

            const popup = new ol.Overlay({
                element: element,
                positioning: 'bottom-center',
                stopEvent: false,
            });
            map.addOverlay(popup);
            let popover;

            function disposePopover() {
                if (popover) {
                    popover.dispose();
                    popover = undefined;
                }
            }
            // display popup on click
            map.on('click', function(evt) {
                var coordinate = evt.coordinate;
                coordinate = ol.proj.toLonLat(coordinate);

                console.log(coordinate);

                const feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
                    return feature;
                });
                disposePopover();
                console.log(feature);
                if (!feature) {
                    return;
                }
                popup.setPosition(evt.coordinate);
                popover = new bootstrap.Popover(element, {
                    placement: 'top',
                    html: true,
                    content: feature.get('name'),
                });
                popover.show();
            });

            // change mouse cursor when over marker
            map.on('pointermove', function(e) {
                const pixel = map.getEventPixel(e.originalEvent);
                const hit = map.hasFeatureAtPixel(pixel);
                map.getTarget().style.cursor = hit ? 'pointer' : '';
            });
            // Close the popup when the map is moved
            map.on('movestart', disposePopover);
        }

        getLocation();
    </script>
    <script>
        var ctx = document.getElementById('kecelakaanChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($tahun as $item)
                        '{{ $item }}',
                    @endforeach
                ],
                datasets: [{
                        label: 'R2',
                        data: [
                            @foreach ($total_kendaraan as $item)
                                '{{ $item->total_r2 }}',
                            @endforeach
                        ],
                        backgroundColor: 'rgba(75, 12, 192, .5)',
                        borderColor: 'rgba(75, 12, 192)',
                        borderWidth: 1,
                        // categoryPercentage: 0.7,
                        // order: 2,
                    },
                    {
                        label: 'R4',
                        data: [
                            @foreach ($total_kendaraan as $item)
                                '{{ $item->total_r4 }}',
                            @endforeach
                        ],
                        backgroundColor: 'rgba(250, 250, 0, .5)',
                        borderColor: 'rgba(250, 250, 0)',
                        borderWidth: 1,
                        // categoryPercentage: 0.5,
                        // order: 1,
                    },
                    {
                        label: 'R6',
                        data: [
                            @foreach ($total_kendaraan as $item)
                                '{{ $item->total_r6 }}',
                            @endforeach
                        ],
                        backgroundColor: 'rgba(200, 0, 10, .5)',
                        borderColor: 'rgba(200, 0, 10)',
                        borderWidth: 1,
                        // categoryPercentage: 0.4,
                        // order: 0,
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Jumlah kasus kecelakaan',
                    fontSize: 16,
                },
                maintainAspectRatio: false,
            }
        });
    </script>
@endsection
