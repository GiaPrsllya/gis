@extends('layout/thirdLayout')

@section('title', 'Maps')

@section('content')
    <div class="row">
        <div class="col-12">
            <div id="map" class="map">
                <div id="popup"></div>
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
                thumbnail: 'https://ionicframework.com/docs/img/demos/avatar.svg',
                keterangan: 'Hai, ini adalah posisi anda',
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

            @foreach ($blackspots as $spot)
                const iconFeature{{ $spot->id }} = new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat({{ $spot->longitude }}), parseFloat(
                        {{ $spot->latitude }})])),
                    name: '{{ $spot->jalan }}',
                    thumbnail: "{{ asset('storage/'.$spot->thumbnail) }}",
                    keterangan: `{!! $spot->keterangan !!}`,
                });

                const iconStyle{{ $spot->id }} = new ol.style.Style({
                    image: new ol.style.Icon({
                        anchor: [0.5, 32],
                        anchorXUnits: 'fraction',
                        anchorYUnits: 'pixels',
                        src: "{{ asset('assets/images/titikrawan_marker.png') }}",
                    }),
                });

                iconFeature{{ $spot->id }}.setStyle(iconStyle{{ $spot->id }});
            @endforeach

            const vectorSource = new ol.source.Vector({
                features: [iconFeature,
                    @foreach ($blackspots as $spot)
                        iconFeature{{ $spot->id }},
                    @endforeach
                ],
            });


            const vectorLayer = new ol.layer.Vector({
                source: vectorSource,
            });

            const map = new ol.Map({
                layers: [rasterLayer, vectorLayer],
                target: document.getElementById('map'),
                view: new ol.View({
                    center: ol.proj.fromLonLat([lon, lat]),
                    zoom: 12,
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
                // create content Card from feature
                var content = `
                <div class="card" style="width: 18rem;">
                    <img src="${feature.get('thumbnail')}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">${feature.get('name')}</h5>
                        <p class="card-text">${feature.get('keterangan')}</p>
                    </div>
                </div>`;

                popover = new bootstrap.Popover(element, {
                    placement: 'bottom',
                    html: true,
                    content: content,
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

            // on change select daerah
            $('#daerah').on('change', function() {
                // get value from this select
                const daerah = $(this).val();
                // split value to get lat and lon
                const lat = daerah.split(',')[0];
                const lon = daerah.split(',')[1];
                // convert lat and lon to float
                const latFloat = parseFloat(lat);
                const lonFloat = parseFloat(lon);
                // map move center
                map.getView().setCenter(ol.proj.fromLonLat([lonFloat, latFloat]));
                // set zoom level
                map.getView().setZoom(15);
            });
        }

        getLocation();
    </script>
@endsection
