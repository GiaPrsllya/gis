<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @guest
            <li class="nav-item">
                <div class="container">
                    <select class="form-control" name="daerah" id="daerah">
                        <option selected hidden disabled>Filter Daerah</option>
                        @foreach($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->latitude.','.$kecamatan->longitude }}">{{ $kecamatan->name }}</option>
                        @endforeach
                    </select>
                </div>
            </li>
            <hr />
            <!-- <li class="nav-item">
                <a class="nav-link" href="/tentang-dishub">
                    <i class="icon-grid menu-icon mdi mdi-information"></i>
                    <span class="menu-title">Tentang Dishub</span>
                </a>
            </li>
 <li class="nav-item">
                <a class="nav-link" href="javascript:;" data-bs-toggle="modal" data-bs-target="#kontak">
                    <i class="icon-grid menu-icon mdi mdi-whatsapp"></i>
                    <span class="menu-title">Hubungi</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('navigasi')}}">
                    <i class="icon-grid menu-icon mdi mdi-navigation"></i>
                    <span class="menu-title">Navigasi</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <div class="container">
                    <select class="form-control" name="daerah" id="daerah">
                        <option selected hidden disabled>Filter Daerah</option>
                        @foreach($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->latitude.','.$kecamatan->longitude }}">{{ $kecamatan->name }}</option>
                        @endforeach
                    </select>
                </div>
            </li>
            <hr />
            <!-- <li class="nav-item">
                <a class="nav-link" href="/tentang-dishub">
                    <i class="icon-grid menu-icon mdi mdi-information-variant"></i>
                    <span class="menu-title">Tentang Dishub</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:;" data-bs-toggle="modal" data-bs-target="#kontak">
                    <i class="icon-grid menu-icon mdi mdi-whatsapp"></i>
                    <span class="menu-title">Hubungi</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('navigasi')}}">
                    <i class="icon-grid menu-icon mdi mdi-navigation"></i>
                    <span class="menu-title">Rute</span>
                </a>
            </li>
            <hr />
            <li class="nav-item">
                <a class="nav-link" href="{{ url('dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript(0);"
                    onclick="
          event.preventDefault();
          document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-logout menu-icon"></i>
                    <span class="menu-title">Logout</span>
                </a>
            </li>
        @endguest
    </ul>
</nav>

<!-- Modal Tentang-->
<div class="modal fade" id="tentang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tentang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ $settings['3']->option_value }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kontak-->
<div class="modal fade" id="kontak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- table  --}}
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td><i class="mdi mdi-compass"></i> Alamat</td>
                            <td>:</td>
                            <td>{{ $settings['0']->option_value }}</td>
                        </tr>
                        <tr>
                            <td><i class="mdi mdi-contact-mail"></i> Email</td>
                            <td>:</td>
                            <td>{{ $settings['1']->option_value }}</td>
                        </tr>
                        <tr>
                            <td><i class="mdi mdi-web"></i> Website</td>
                            <td>:</td>
                            <td>{{ $settings['2']->option_value }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
