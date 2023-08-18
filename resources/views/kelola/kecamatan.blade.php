@extends('layout/secondLayout')

@section('title', 'Kecamatan')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12">
                    <h3 class="font-weight-bold">Kecamatan</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addDataModal">
                        Add Data
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog"
                        aria-labelledby="addDataModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addDataModalLabel">Add Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <form action="{{route('kecamatan.store')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nama">Nama Kecamatan</label>
                                            <input name="name" type="text" class="form-control" id="nama"
                                                placeholder="Masukkan Nama Kecamatan" value="{{ old('name') }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="latitude">Latitude</label>
                                                <input name="latitude" type="number" class="form-control" id="latitude"
                                                    placeholder="Masukkan latitude" value="{{ old('latitude') }}" step="any" required>
                                                @error('latitude')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="longitude">Longitude</label>
                                                <input name="longitude" type="number" class="form-control" id="longitude"
                                                    placeholder="Masukkan longitude" value="{{ old('longitude') }}" step="any" required>
                                                @error('longitude')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                        <button type="submit" class="btn btn-primary">save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Longitude</th>
                                <th>Latituede</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kecamatans as $kecamatan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kecamatan->name }}</td>
                                    <td>{{ $kecamatan->longitude }}</td>
                                    <td>{{ $kecamatan->latitude }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#editDataModal{{ $kecamatan->id }}"><i
                                                class="mdi mdi-table-edit"></i>
                                            Edit
                                        </button>
                                        <form action="{{ route('kecamatan.destroy', $kecamatan->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')"><i class="mdi mdi-delete"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </td>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editDataModal{{ $kecamatan->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addDataModalLabel">Edit Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <form action="{{route('kecamatan.update', $kecamatan->id)}}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="nama">Nama Kecamatan</label>
                                                            <input name="name" type="text" class="form-control" id="nama"
                                                                placeholder="Masukkan Nama" value="{{$kecamatan->name}}">
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="latitude">Latitude</label>
                                                                <input name="latitude" type="number" class="form-control" id="latitude"
                                                                    placeholder="Masukkan latitude" value="{{ $kecamatan->latitude }}" step="any" required>
                                                                @error('latitude')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="longitude">Longitude</label>
                                                                <input name="longitude" type="number" class="form-control" id="longitude"
                                                                    placeholder="Masukkan longitude" value="{{ $kecamatan->longitude }}" step="any" required>
                                                                @error('longitude')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <button type="reset" class="btn btn-danger">Reset</button>
                                                        <button type="submit" class="btn btn-primary">save</button>
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
@endsection
