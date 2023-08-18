@extends('layout/secondLayout')

@section('title', 'Kecelakaan')

@section('head')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0;
            /* <-- Apparently some margin are still there even though it's hidden */
        }

        input[type=number] {
            -moz-appearance: textfield;
            /* Firefox */
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12">
                    <h3 class="font-weight-bold">Kecelakaan</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addDataModal">
                            Add Data
                        </button>
                        <button type="button" class="btn btn-primary ms-3 mb-3" data-toggle="modal"
                            data-target="#importDataModal">
                            Import Data
                        </button>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Terjadi Kesalahan!</h4>
                            <p>Periksa kembali data yang anda masukkan.</p>
                            <hr>
                            <p class="mb-0">
                                @foreach ($errors->all() as $error)
                                    {{ $error }} <br>
                                @endforeach
                            </p>
                        </div>
                    @endif

                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th rowspan="2">NO</th>
                                <th rowspan="2">TAHUN</th>
                                <th rowspan="2">BULAN</th>
                                <th rowspan="2">JK</th>
                                <th colspan="3">KORBAN</th>
                                <th rowspan="2">RUGI MATERI</th>
                                <th colspan="3">KENDARAAN YANG TERLIBAT</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>MD</th>
                                <th>LB</th>
                                <th>LR</th>
                                <th>R2</th>
                                <th>R4</th>
                                <th>R6</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kecelakaan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->bulan }}</td>
                                    <td>{{ $item->jumlah_kecelakaan }}</td>
                                    <td>{{ $item->meninggal_dunia }}</td>
                                    <td>{{ $item->luka_berat }}</td>
                                    <td>{{ $item->luka_ringan }}</td>
                                    <td>{{ $item->rugi_materi }}</td>
                                    <td>{{ $item->r2 }}</td>
                                    <td>{{ $item->r4 }}</td>
                                    <td>{{ $item->r6 }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editDataModal{{ $item->id }}">Edit</button>
                                        <form action="{{ route('kecelakaan.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editDataModal{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="addDataModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addDataModalLabel">Add Data</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('kecelakaan.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="tahun">Tahun</label>
                                                                <input type="number" class="form-control" id="tahun"
                                                                    name="tahun" placeholder="Enter tahun"
                                                                    value="{{ $item->tahun }}" min="1900">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="bulan">Bulan</label>
                                                                <select class="form-control" id="bulan" name="bulan">
                                                                    <option value="" selected hidden disabled>Pilih
                                                                        Bulan</option>
                                                                    <option value="Januari"
                                                                        {{ $item->bulan == 'Januari' ? 'selected' : '' }}>
                                                                        Januari
                                                                    </option>
                                                                    <option value="Februari"
                                                                        {{ $item->bulan == 'Februari' ? 'selected' : '' }}>
                                                                        Februari</option>
                                                                    <option value="Maret"
                                                                        {{ $item->bulan == 'Maret' ? 'selected' : '' }}>
                                                                        Maret
                                                                    </option>
                                                                    <option value="April"
                                                                        {{ $item->bulan == 'April' ? 'selected' : '' }}>
                                                                        April
                                                                    </option>
                                                                    <option value="Mei"
                                                                        {{ $item->bulan == 'Mei' ? 'selected' : '' }}>Mei
                                                                    </option>
                                                                    <option value="Juni"
                                                                        {{ $item->bulan == 'Juni' ? 'selected' : '' }}>Juni
                                                                    </option>
                                                                    <option value="Juli"
                                                                        {{ $item->bulan == 'Juli' ? 'selected' : '' }}>Juli
                                                                    </option>
                                                                    <option value="Agustus"
                                                                        {{ $item->bulan == 'Agustus' ? 'selected' : '' }}>
                                                                        Agustus
                                                                    </option>
                                                                    <option value="September"
                                                                        {{ $item->bulan == 'September' ? 'selected' : '' }}>
                                                                        September</option>
                                                                    <option value="Oktober"
                                                                        {{ $item->bulan == 'Oktober' ? 'selected' : '' }}>
                                                                        Oktober
                                                                    </option>
                                                                    <option value="November"
                                                                        {{ $item->bulan == 'November' ? 'selected' : '' }}>
                                                                        November</option>
                                                                    <option value="Desember"
                                                                        {{ $item->bulan == 'Desember' ? 'selected' : '' }}>
                                                                        Desember</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="jumlah_kecelakaan">Jumlah Kecelakaan</label>
                                                                <input type="number" class="form-control"
                                                                    id="jumlah_kecelakaan" name="jumlah_kecelakaan"
                                                                    placeholder="Enter jumlah_kecelakaan"
                                                                    value="{{ $item->jumlah_kecelakaan }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="md">MD</label>
                                                                <input required name="meninggal_dunia" type="number"
                                                                    class="form-control" id="md"
                                                                    placeholder="Jumlah MD"
                                                                    value="{{ $item->meninggal_dunia }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="lb">LB</label>
                                                                <input required name="luka_berat" type="number"
                                                                    class="form-control" id="lb"
                                                                    placeholder="Jumlah lb"
                                                                    value="{{ $item->luka_berat }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="lr">LR</label>
                                                                <input required name="luka_ringan" type="number"
                                                                    class="form-control" id="lr"
                                                                    placeholder="Jumlah lr"
                                                                    value="{{ $item->luka_ringan }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="r2">R2</label>
                                                                <input name="r2" type="number" class="form-control"
                                                                    id="r2" placeholder="Jumlah R2"
                                                                    value="{{ $item->r2 }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="r4">R4</label>
                                                                <input name="r4" type="number" class="form-control"
                                                                    id="r4" placeholder="Jumlah R4"
                                                                    value="{{ $item->r4 }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="r6">R6</label>
                                                                <input name="r6" type="number" class="form-control"
                                                                    id="r6" placeholder="Jumlah R6"
                                                                    value="{{ $item->r6 }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="rugi_materi">Rugi Materi</label>
                                                                <input required name="rugi_materi" type="number"
                                                                    class="form-control" id="rugi_materi"
                                                                    placeholder="Jumlah rugi materi"
                                                                    value="{{ $item->rugi_materi }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataModalLabel">Add Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/kecelakaan/" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" class="form-control" id="tahun" name="tahun"
                                        placeholder="Enter tahun" value="{{ old('tahun') }}" min="1900">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select class="form-control" id="bulan" name="bulan">
                                        <option value="" selected hidden disabled>Pilih Bulan</option>
                                        <option value="Januari" {{ old('bulan') == 'Januari' ? 'selected' : '' }}>Januari
                                        </option>
                                        <option value="Februari" {{ old('bulan') == 'Februari' ? 'selected' : '' }}>
                                            Februari</option>
                                        <option value="Maret" {{ old('bulan') == 'Maret' ? 'selected' : '' }}>Maret
                                        </option>
                                        <option value="April" {{ old('bulan') == 'April' ? 'selected' : '' }}>April
                                        </option>
                                        <option value="Mei" {{ old('bulan') == 'Mei' ? 'selected' : '' }}>Mei</option>
                                        <option value="Juni" {{ old('bulan') == 'Juni' ? 'selected' : '' }}>Juni
                                        </option>
                                        <option value="Juli" {{ old('bulan') == 'Juli' ? 'selected' : '' }}>Juli
                                        </option>
                                        <option value="Agustus" {{ old('bulan') == 'Agustus' ? 'selected' : '' }}>Agustus
                                        </option>
                                        <option value="September" {{ old('bulan') == 'September' ? 'selected' : '' }}>
                                            September</option>
                                        <option value="Oktober" {{ old('bulan') == 'Oktober' ? 'selected' : '' }}>Oktober
                                        </option>
                                        <option value="November" {{ old('bulan') == 'November' ? 'selected' : '' }}>
                                            November</option>
                                        <option value="Desember" {{ old('bulan') == 'Desember' ? 'selected' : '' }}>
                                            Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jumlah_kecelakaan">Jumlah Kecelakaan</label>
                                    <input type="number" class="form-control" id="jumlah_kecelakaan"
                                        name="jumlah_kecelakaan" placeholder="Enter jumlah_kecelakaan"
                                        value="{{ old('tahun') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="md">MD</label>
                                    <input required name="meninggal_dunia" type="number" class="form-control"
                                        id="md" placeholder="Jumlah MD" value="{{ old('md') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lb">LB</label>
                                    <input required name="luka_berat" type="number" class="form-control" id="lb"
                                        placeholder="Jumlah lb" value="{{ old('lb') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lr">LR</label>
                                    <input required name="luka_ringan" type="number" class="form-control"
                                        id="lr" placeholder="Jumlah lr" value="{{ old('lr') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="r2">R2</label>
                                    <input name="r2" type="number" class="form-control" id="r2"
                                        placeholder="Jumlah R2" value="{{ old('r2') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="r4">R4</label>
                                    <input name="r4" type="number" class="form-control" id="r4"
                                        placeholder="Jumlah R4" value="{{ old('r4') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="r6">R6</label>
                                    <input name="r6" type="number" class="form-control" id="r6"
                                        placeholder="Jumlah R6" value="{{ old('r6') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rugi_materi">Rugi Materi</label>
                                    <input required name="rugi_materi" type="number" class="form-control"
                                        id="rugi_materi" placeholder="Jumlah rugi materi"
                                        value="{{ old('rugi_materi') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importDataModal" tabindex="-1" role="dialog" aria-labelledby="importDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importDataModalLabel">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kecelakaan.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="file">File</label>
                            <input required name="file" type="file" class="form-control" id="file"
                                placeholder="Enter file" value="{{ old('file') }}"
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <div class="form-text">File harus berupa .csv, .xlsx, .xls. Format bisa diunduh <a
                                    href="{{ asset('storage/kecelakaan/template.xlsx') }}">Disini</a></div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
