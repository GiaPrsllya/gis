@extends('layout/secondLayout')

@section('title', 'Dashboard')

@section('head')
    <style>
        .wrapper-image {
            position: relative;
            max-width: 200px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <h3 class="font-weight-bold">Edit Titik Rawan</h3>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada kesalahan dalam input data! <br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div id="map" class="map">
                <div id="popup"></div>
            </div>
        </div>
        <div class="col-md-6">
            <form action="{{ route('titikrawan.update', $titikrawan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="thumbnail">Thumbnail</label>
                    <div class="wrapper-image">
                        <img src="{{ asset('storage/' . $titikrawan->thumbnail) }}" alt="thumbnail" class="img-fluid">
                    </div>
                </div>

                <div class="form-group">
                    <label for="thumbnail">Thumbnail Baru</label>
                    <input name="thumbnail" type="file" class="form-control" id="thumbnail"
                        placeholder="Masukkan thumbnail" accept="image/*">
                    @error('thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama-jalan">Nama Jalan</label>
                    <input name="jalan" type="text" class="form-control" id="nama-jalan"
                        placeholder="Masukkan nama jalan" value="{{ $titikrawan->jalan }}">
                    @error('jalan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="latitude">Latitude</label>
                        <input name="latitude" type="text" class="form-control" id="latitude"
                            placeholder="Klik point di map" value="{{ $titikrawan->latitude }}" readonly>
                        @error('latitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="longitude">Longitude</label>
                        <input name="longitude" type="text" class="form-control" id="longitude"
                            placeholder="Klik point di map" value="{{ $titikrawan->longitude }}" readonly>

                        @error('longitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input name="tahun" type="number" class="form-control" id="tahun" placeholder="Masukkan Tahun"
                        value="{{ $titikrawan->tahun }}">
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control" id="keterangan" rows="3" placeholder="Masukkan keterangan">{{ $titikrawan->keterangan }}</textarea>
                </div>
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-primary">save</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
    <script src="https://cdn.tiny.cloud/1/j5gqw60qypi9txea3m892uu1z4c38jvmw74cpvjetog9q3td/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'link lists searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            menubar: false,
        });
    </script>

    <script type="text/javascript">
        // get current position from gps
        var lat = parseFloat({{ $titikrawan->latitude }});
        var lon = parseFloat({{ $titikrawan->longitude }});

        const rasterLayer = new ol.layer.Tile({
            source: new ol.source.OSM(),
        });

        const iconFeature = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([lon, lat])),
            name: 'Titik Rawan',
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

            // change marker position
            iconFeature.setGeometry(new ol.geom.Point(ol.proj.fromLonLat(coordinate)));

            // set longitude and latitude value
            document.getElementById('latitude').value = coordinate[1];
            document.getElementById('longitude').value = coordinate[0];

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
    </script>
@endsection
