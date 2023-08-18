@extends('layout/secondLayout')

@section('title', 'Titik Rawan')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12">
                    <h3 class="font-weight-bold">Titik Rawan</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="/laporan-titikrawan" class="float-right" method="POST" id="filterForm">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <select name="tahun" id="tahun" class="form-control"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach ($tahun as $item)
                                        <option value="{{ $item->tahun }}">{{ $item->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="myTableLap" class="display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jalan</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($titikrawan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->jalan }}</td>
                                        <td>{{ $item->latitude }}</td>
                                        <td>{{ $item->longitude }}</td>
                                        <td>{{ $item->tahun }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
