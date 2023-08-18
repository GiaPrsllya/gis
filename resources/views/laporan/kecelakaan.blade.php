@extends('layout/secondLayout')

@section('title', 'Kecelakaan')

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

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="/laporan-kecelakaan" class="float-right" method="GET" id="filterForm">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <select name="tahun" id="tahun" class="form-control"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Pilih Tahun</option>
                                    @foreach ($tahun as $item)
                                        <option value="{{ $item }}"
                                            {{ $item == request()->get('tahun') ? 'selected' : '' }}>{{ $item }}
                                        </option>
                                    @endforeach
                                    @empty($tahun)
                                        <option value="">-- Tidak Ada Tahun --</option>
                                    @endempty
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="myTableLapKec" class="display">
                            <thead>
                                <tr>
                                    <th rowspan="2">NO</th>
                                    <th rowspan="2">TAHUN</th>
                                    <th rowspan="2">BULAN</th>
                                    <th rowspan="2">JK</th>
                                    <th colspan="3">KORBAN</th>
                                    <th rowspan="2">RUGI MATERI</th>
                                    <th colspan="3">KENDARAAN YANG TERLIBAT</th>
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


@section('script')
    <script>
        $('#myTableLapKec').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                },
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-primary',
                    text: 'PDF',
                    orientation: 'landscape',
                    @if (strlen($periode) == 4)
                        title: 'Laporan Data Kecelakaan Tahun {{ $periode }}',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                    @else
                        title: 'Laporan Data Kecelakaan Periode Tahun {{ $periode }}',
                    @endif
                    customize: function(doc) {
                        var colCount = new Array();
                        $('#myTableLapKec').find('tbody tr:first-child td').each(function() {
                            if ($(this).attr('colspan')) {
                                for (var i = 1; i <= $(this).attr('colspan'); $i++) {
                                    colCount.push('*');
                                }
                            } else {
                                colCount.push('*');
                            }
                        });
                        doc.content[1].table.widths = colCount;
                    }
                }
            ]
        });
    </script>
@endsection
