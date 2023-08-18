@extends('layout/secondLayout')

@section('title', 'Titik Rawan')

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
                    <a href="{{ route('titikrawan.create') }}">
                        <button type="button" class="btn btn-primary mb-3">
                            Add Data
                        </button>
                    </a>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Thumbnail</th>
                                    <th>Jalan</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Keterangan</th>
                                    <th>Tahun</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($titikrawan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="wrapper-image">
                                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt=""
                                                    class="img-fluid">
                                            </div>
                                        </td>
                                        <td>{{ $item->jalan }}</td>
                                        <td>{{ $item->latitude }}</td>
                                        <td>{{ $item->longitude }}</td>
                                        <td>{!! $item->keterangan !!}</td>
                                        <td>{{ $item->tahun }}</td>
                                        <td>
                                            <a href="{{ route('titikrawan.edit', $item->id) }}">
                                                <button type="button" class="btn btn-warning"><i
                                                        class="mdi mdi-table-edit"></i>
                                                    Edit
                                                </button>
                                            </a>
                                            <form action="/titikrawan/{{ $item->id }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure?')"><i class="mdi mdi-delete"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
