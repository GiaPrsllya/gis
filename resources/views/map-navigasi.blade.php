@extends('layout/thirdLayout')

@section('title', 'Maps')

@section('head')
    <link rel="stylesheet" href="https://cdn.rawgit.com/Viglino/ol-ext/master/dist/ol-ext.min.css" />
@endsection

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
    <script
        src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL,Object.assign">
    </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/Viglino/ol-ext/master/dist/ol-ext.min.js"></script>
    <script src="https://unpkg.com/elm-pep"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/Viglino/Geoportail-KISS/gh-pages/apikey.js"></script>

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
            // Init For Djikstra
            // Calculate the speed factor
            var speed = {
                A: 1,
                P: 1,
                R: 1,
                L: 1
            };

            function calcSpeed() {
                if ($("#speed").prop('checked')) {
                    speed.A = 1 / Math.max(Number($(".speed #A").val()), 1);
                    speed.P = 1 / Math.max(Number($(".speed #P").val()), 1);
                    speed.R = 1 / Math.max(Number($(".speed #R").val()), 1);
                    speed.L = 1 / Math.max(Number($(".speed #L").val()), 1);
                } else {
                    speed = {
                        A: 1,
                        P: 1,
                        R: 1,
                        L: 1
                    };
                }
            }
            calcSpeed();

            var lon = position.coords.longitude;
            var lat = position.coords.latitude;

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

            // add djikstra
            var graph = new ol.source.Vector({
                url: "{{ asset('geojson/routesubang.geojson') }}",
                format: new ol.format.GeoJSON()
            });
            listenerKey = graph.on('change', function() {
                if (graph.getState() == 'ready') {
                    $('.loading').hide();
                    ol.Observable.unByKey(listenerKey);
                }
            });
            var vector = new ol.layer.Vector({
                title: 'Graph',
                source: graph,
                style: function(feature) {
                    var geometry = feature.getGeometry();
                    var styles = [
                        // linestring
                        new ol.style.Style({
                            stroke: new ol.style.Stroke({
                                color: '#ffcc33',
                                width: 2
                            })
                        })
                    ];
                    return styles;
                }
            });
            map.addLayer(vector);

            // A layer to draw the result
            var result = new ol.source.Vector();
            map.addLayer(new ol.layer.Vector({
                source: result,
                style: new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        width: 2,
                        color: "#f00"
                    })
                })
            }));

            // Dijkstra
            var dijkstra = new ol.graph.Dijkstra({
                source: graph
            });
            // Start processing
            dijkstra.on('start', function(e) {
                $('#warning').hide();
                $("#notfound").hide();
                $("#notfound0").hide();
                $("#result").hide();
                result.clear();
            });
            // Finish > show the route
            dijkstra.on('finish', function(e) {
                $('#warning').hide();
                result.clear();
                console.log(e);
                if (!e.route.length) {
                    if (e.wDistance === -1) $("#notfound0").show();
                    else $("#notfound").show();
                    $("#result").hide();
                } else {
                    $("#result").show();
                    var t = (e.distance / 1000).toFixed(2) + 'km';
                    // Weighted distance
                    if ($("#speed").prop('checked')) {
                        var h = e.wDistance / 1000;
                        var mn = Math.round((e.wDistance % 1000) / 1000 * 60);
                        if (mn < 10) mn = '0' + mn;
                        t += '<br/>' + h.toFixed(0) + 'h ' + mn + 'mn';
                    }
                    console.log(t);
                    $("#result span").html(t);
                }
                result.addFeatures(e.route);
                start = end;
                popStart.show(start);
                popEnd.hide();
            });
            // Paused > resume
            dijkstra.on('pause', function(e) {
                if (e.overflow) {
                    $('#warning').show();
                    dijkstra.resume();
                } else {
                    // User pause
                }
            });
            // Calculating > show the current "best way"
            dijkstra.on('calculating', function(e) {
                if ($('#path').prop('checked')) {
                    var route = dijkstra.getBestWay();
                    result.clear();
                    result.addFeatures(route);
                }
            });

            // Get the weight of an edge
            dijkstra.weight = function(feature) {
                return feature ? (parseInt(feature.get('jumlah_blackspot'))==0?1:parseInt(feature.get('jumlah_blackspot')+1)) : 1;                
            };
            // Get direction of the edge
            dijkstra.direction = function(feature) {
                return 2;
            }
            // Get the real length of the geom
            dijkstra.getLength = function(geom) {
                if (geom.getGeometry) {
                    //? return geom.get('km')*1000;
                    geom = geom.getGeometry();
                }
                return ol.sphere.getLength(geom)
            }

            // Display nodes in a layer
            var nodes = new ol.layer.Vector({
                title: 'Nodes',
                source: dijkstra.getNodeSource(),
                style: new ol.style.Style({
                    image: new ol.style.Icon({
                        anchor: [0.5, 0.5],
                        anchorXUnits: "fraction",
                        anchorYUnits: "fraction",
                        src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
                    })
                })
            });
            map.addLayer(nodes);

            // Start / end Placemark
            var popStart = new ol.Overlay.Placemark({
                popupClass: 'flagv',
                color: '#080'
            });
            map.addOverlay(popStart);
            var popEnd = new ol.Overlay.Placemark({
                popupClass: 'flag finish',
                color: '#000'
            });
            map.addOverlay(popEnd);

            // Manage start / end on click
            var start, end;

            // display popup on click
            map.on('click', function(evt) {
                if (!start) {
                    start = evt.coordinate;
                    popStart.show(start);
                } else {
                    popEnd.show(evt.coordinate);
                    setTimeout(function() {
                        var se = dijkstra.path(start, evt.coordinate);
                        if (se) {
                            start = se[0];
                            end = se[1];
                        } else {
                            popEnd.hide();
                        }
                    }, 100)
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
