@extends('layout/secondLayout')

@section('title', 'Kelola Rute')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="font-weight-bold">Kelola Rute</h3>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Terjadi kesalahan pada saat input data<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row bg-white g-3 p-3">
        <div class="col-md-12">
            <div id="map" class="map">
                <div id="popup"></div>
            </div>
        </div>
        <div class="col-md-6">
            <p>Longitude: <span id="longitude"></span></p>
            <p>Latitude: <span id="latitude"></span></p>
        </div>
        <div class="col-md-6">
            <form id="form-rute" action="{{ route('rute.store') }}" method="POST">
                @csrf
                <input type="text" name="name" id="name" class="form-control mb-3" placeholder="Nama Rute"
                    required>
                <input type="number" name="jumlah_blackspot" id="jumlah_blackspot" value="0" class="form-control mb-3"
                    placeholder="Jumlah Titik Rawan" required>
                <button type="button" class="btn btn-secondary" id="btn-reset">Reset</button>
                <button type="button" class="btn btn-primary" id="btn-save">Simpan</button>
            </form>

            <form id="formDelete" action="{{ route('rute.destroy', '') }}" class="d-none" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="id">
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>

    <script type="text/javascript">
        let currCoord = [0, 0];
        let nextCoord = [0, 0];
        let firstCoord = [0, 0];
        let vectorLayers = [];
        let markers = [];

        function addMarker(map, coordinate) {
            // console.log("halo", coordinate);
            var vectorLayer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.fromLonLat(coordinate)),
                        long: coordinate[0],
                        lat: coordinate[1]
                    })]
                }),
                style: new ol.style.Style({
                    image: new ol.style.Icon({
                        anchor: [0.5, 0.5],
                        anchorXUnits: "fraction",
                        anchorYUnits: "fraction",
                        src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
                    })
                })
            });
            vectorLayers.push(vectorLayer);
            markers.push(coordinate);
            map.addLayer(vectorLayer);
        }

        function drawLineString(map, coordinate, color = "#ffcc33", init = false, jumlah_blackspot = 0, id_feature = 0) {
            // convert all coordinate to point
            var points = [];
            for (let i = 0; i < coordinate.length; i++) {
                points.push(ol.proj.fromLonLat(coordinate[i]));
            }
            // console.log(points, coordinate);
            var vectorLayer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [new ol.Feature({
                        geometry: new ol.geom.LineString(points),
                        name: 'Line',
                        jumlah_blackspot: jumlah_blackspot,
                        id: id_feature
                    })]
                }),
                style: new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: color,
                        width: 5
                    })
                })
            });
            if (!init) {
                vectorLayers.push(vectorLayer);
                addMarker(map, coordinate[1]);
            }
            map.addLayer(vectorLayer);
        }

        function resetAll(map) {
            for (let i = 0; i < vectorLayers.length; i++) {
                map.removeLayer(vectorLayers[i]);
            }
            vectorLayers = [];
            markers = [];
        }

        // get current position from gps
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showMap);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showMap(position) {
            var lon = 107.77364731254058;
            var lat = -6.311647276484834;

            const rasterLayer = new ol.layer.Tile({
                source: new ol.source.OSM(),
            });

            const iconFeature = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([lon, lat])),
                name: 'Posisi Anda',
                population: 4000,
                rainfall: 500,
                lon: lon,
                lat: lat
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
                    thumbnail: "{{ asset('storage/' . $spot->thumbnail) }}",
                    keterangan: `{{ $spot->keterangan }}`,
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

            @foreach ($features as $feature)
                const iconStyleNode{{ $feature->id }} = new ol.style.Style({
                    image: new ol.style.Icon({
                        anchor: [0.5, 0.5],
                        anchorXUnits: 'fraction',
                        anchorYUnits: 'fraction',
                        src: "https://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/Green_Dot.svg/15px-Green_Dot.svg.png",
                    }),
                });

                @foreach ($feature->coordinates as $coordinate)
                    const iconFeatureNode{{ $coordinate->id }} = new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat({{ $coordinate->longitude }}),
                            parseFloat({{ $coordinate->latitude }})
                        ])),
                        name: '{{ $feature->name }}',
                        lon: parseFloat({{ $coordinate->longitude }}),
                        lat: parseFloat({{ $coordinate->latitude }}),
                    });
                    iconFeatureNode{{ $coordinate->id }}.setStyle(iconStyleNode{{ $feature->id }});
                @endforeach
            @endforeach

            const vectorSource = new ol.source.Vector({
                features: [iconFeature,
                    @foreach ($blackspots as $spot)
                        iconFeature{{ $spot->id }},
                    @endforeach
                    @foreach ($features as $feature)
                        @foreach ($feature->coordinates as $coordinate)
                            iconFeatureNode{{ $coordinate->id }},
                        @endforeach
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
                    zoom: 15,
                }),
            });

            @foreach ($features as $feature)
                // draw line
                var coordinate{{ $feature->id }} = [];
                @foreach ($feature->coordinates as $coordinate)
                    coordinate{{ $feature->id }}.push([parseFloat({{ $coordinate->longitude }}), parseFloat(
                        {{ $coordinate->latitude }})]);
                @endforeach

                // foreach coordinate for draw line
                for (let i = 0; i < coordinate{{ $feature->id }}.length; i++) {
                    if (i == 0) {
                        drawLineString(map, [coordinate{{ $feature->id }}[i], coordinate{{ $feature->id }}[i + 1]],
                            "#24abea", true, {{$feature->jumlah_blackspot}}, {{ $feature->id }});
                    } else if (i == coordinate{{ $feature->id }}.length - 1) {
                        drawLineString(map, [coordinate{{ $feature->id }}[i - 1], coordinate{{ $feature->id }}[i]],
                            "#24abea", true, {{$feature->jumlah_blackspot}}, {{ $feature->id }});
                    } else {
                        drawLineString(map, [coordinate{{ $feature->id }}[i - 1], coordinate{{ $feature->id }}[i],
                            coordinate{{ $feature->id }}[i + 1]
                        ], "#24abea", true, {{$feature->jumlah_blackspot}}, {{ $feature->id }});
                    }
                }
            @endforeach

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
                const feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
                    return feature;
                });
                disposePopover();
                if (feature) {
                    popup.setPosition(evt.coordinate);
                    if (feature.getGeometry().getType() !== 'LineString') {
                        // set coordinate
                        coordinate = [feature.get('lon'), feature.get('lat')];
                        popover = new bootstrap.Popover(element, {
                            placement: 'top',
                            html: true,
                            content: feature.get('lon') + ', ' + feature.get('lat')
                        });
                    } else {
                        popover = new bootstrap.Popover(element, {
                            placement: 'top',
                            html: true,
                            content: feature.get('jumlah_blackspot') + ' blackspot.'+ '. ID: '+ feature.get('id'),
                        });

                        // confirm delete
                        if(confirm("Apakah anda yakin ingin menghapus data ini?")){
                            const id = feature.get('id');
                            const url = "{{ route('rute.destroy', ':id') }}";
                            const urlDelete = url.replace(':id', id);
                            const form = document.getElementById('formDelete');
                            form.setAttribute('action', urlDelete);
                            form.submit();
                        };                        
                    }
                    popover.show();
                } else {
                    coordinate = ol.proj.toLonLat(coordinate);
                }

                // if coordinate is not undefined
                if (coordinate) {
                    // set coordinate
                    document.getElementById('longitude').innerHTML = coordinate[0];
                    document.getElementById('latitude').innerHTML = coordinate[1];

                    if (currCoord[0] == 0 && currCoord[1] == 0) {
                        currCoord = coordinate;
                        firstCoord = coordinate;
                        // console.log(currCoord);
                        addMarker(map, currCoord);
                    } else {
                        nextCoord = coordinate;
                        drawLineString(map, [currCoord, nextCoord]);
                        currCoord = nextCoord;
                    }
                    // // set current coordinate
                    // currCoord = coordinate;
                    // // set first coordinate
                    // if (firstCoord[0] == 0 && firstCoord[1] == 0) {
                    //     firstCoord = coordinate;
                    // }
                    // // set next coordinate
                    // nextCoord = coordinate;
                    // // add marker
                    // addMarker(map, coordinate);
                    // // draw line
                    // drawLineString(map, [firstCoord, nextCoord]);
                }
            });

            // change mouse cursor when over marker
            map.on('pointermove', function(e) {
                const pixel = map.getEventPixel(e.originalEvent);
                const hit = map.hasFeatureAtPixel(pixel);
                map.getTarget().style.cursor = hit ? 'pointer' : '';
            });
            // Close the popup when the map is moved
            map.on('movestart', disposePopover);

            // on click reset btn
            document.getElementById('btn-reset').addEventListener('click', function() {
                currCoord = [0, 0];
                nextCoord = [0, 0];
                firstCoord = [0, 0];
                resetAll(map);
                console.log("reset");
            });

            // on click btn save
            document.getElementById('btn-save').addEventListener('click', function() {
                // then get all coordinate
                var coordinate = markers;
                console.log(coordinate);
                // foreach coordinate
                for (let i = 0; i < coordinate.length; i++) {
                    // append input element to form-rute
                    var input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("name", "longitude[]");
                    input.setAttribute("value", coordinate[i][0]);
                    document.getElementById("form-rute").appendChild(input);

                    var input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("name", "latitude[]");
                    input.setAttribute("value", coordinate[i][1]);
                    document.getElementById("form-rute").appendChild(input);
                }

                // submit form
                document.getElementById("form-rute").submit();
            });
        }

        getLocation();
    </script>
@endsection
