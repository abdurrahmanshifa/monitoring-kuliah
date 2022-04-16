<aside id="sidebar-wrapper">
<div class="sidebar-brand">
     <a href="{{ route('dashboard.index') }}">SiMonik</a>
</div>
<div class="sidebar-brand sidebar-brand-sm">
     <a href="{{ route('dashboard.index') }}">SM</a>
</div>
<ul class="sidebar-menu">
     @if( \Auth::user()->roles == 'mahasiswa')
     <li class="menu-header">Perkuliahan</li>
     <li class="{{ request()->is('perkuliahan') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('perkuliahan') }}">
               <i class="far fa-file-alt"></i>  <span>Perkuliahan</span>
          </a>
     </li>
     @endif
     @if( \Auth::user()->roles == 'admin' OR \Auth::user()->roles == 'prodi')
     <li class="menu-header">Dashboard</li>
     <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard.index') }}">
               <i class="fas fa-th-large"></i>  <span>Dashboard</span>
          </a>
     </li>
     <li class="menu-header">Master Data</li>
     <li class="nav-item dropdown {{ request()->is('master*') ? 'active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
               <i class="far fa-file-alt"></i> <span>Master Data</span></a>
          <ul class="dropdown-menu">
               @if( \Auth::user()->roles == 'admin')
               <li class="{{ request()->is('master/pengguna') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master.pengguna') }}">
                         Pengguna
                    </a>
               </li>
               @endif
               @if( \Auth::user()->roles == 'admin' OR \Auth::user()->roles == 'prodi')
               <li class="{{ request()->is('master/prodi') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master.prodi') }}">
                         Prodi
                    </a>
               </li>
               <li class="{{ request()->is('master/mahasiswa') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master.mahasiswa') }}">
                         Mahasiswa
                    </a>
               </li>
               <li class="{{ request()->is('master/dosen') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master.dosen') }}">
                         Dosen
                    </a>
               </li>
               <li class="{{ request()->is('master/mata-kuliah') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master.mata-kuliah') }}">
                         Mata Kuliah
                    </a>
               </li>
               <li class="{{ request()->is('master/ruang') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master.ruang') }}">
                         Ruang
                    </a>
               </li>
               <li class="{{ request()->is('master/semester') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master.semester') }}">
                         Semester
                    </a>
               </li>
               <li class="{{ request()->is('master/pertanyaan-survey') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master.pertanyaan-survey') }}">
                         Survey Pertanyaan
                    </a>
               </li>
               @endif
          </ul>
     </li>
     <li class="menu-header">Monitoring Perkuliahan</li>
     <li class="{{ request()->is('perkuliahan') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('perkuliahan') }}">
               <i class="far fa-file-alt"></i>  <span>Perkuliahan</span>
          </a>
     </li>
     <li class="menu-header">Laporan</li>
     <li class="{{ request()->is('rekapan') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('laporan.rekapan') }}">
               <i class="far fa-copy"></i>  <span>Perkuliahan</span>
          </a>
     </li>
     <li class="{{ request()->is('penilaian') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('laporan.penilaian') }}">
               <i class="far fa-copy"></i>  <span>Penilaian Dosen</span>
          </a>
     </li>
     @endif
</ul>
<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
     <a href="{{ route('survey.index') }}" target="_blank" class="btn btn-primary btn-lg btn-block btn-icon-split">
          <i class="fas fa-rocket"></i> Form Survey Penilaian
     </a>
</div>
</aside>