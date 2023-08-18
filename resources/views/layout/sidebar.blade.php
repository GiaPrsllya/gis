<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ url('users') }}">
                <i class="mdi mdi-account-settings menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li> --}}
        <hr class="border border-dark" />
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Kelola Data</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('kecelakaan') }}">Kecelakaan</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('titikrawan') }}">Titik Rawan</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('kecamatan') }}">Kecamatan</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('rute') }}">Rute</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="mdi mdi-file-document menu-icon"></i>
                <span class="menu-title">Kelola Laporan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/laporan-kecelakaan">
                            Kecelakaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="/laporan-titikrawan">
                            Titik Rawan</a></li>
                </ul>
            </div>
        </li>
        <hr class="border border-dark" />
        {{-- <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#lainnya" aria-expanded="false"
          aria-controls="lainnya">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">Lainnya</span>
          <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="lainnya">
          <ul class="nav flex-column sub-menu">
              <li class="nav-item"><a class="nav-link" href="#">
                      Kelola Users</a></li>
              <li class="nav-item"><a class="nav-link" href="#">
                      Default</a></li>
          </ul>
      </div>
  </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ url('tentang') }}">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Tentang</span>
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
    </ul>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
