<aside id="sidebar-wrapper">
<div class="sidebar-brand">
     <a href="{{ route('dashboard.index') }}">SiMonik</a>
</div>
<div class="sidebar-brand sidebar-brand-sm">
     <a href="{{ route('dashboard.index') }}">SM</a>
</div>
<ul class="sidebar-menu">
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
               @if( \Auth::user()->roles == 'admin' OR \Auth::user()->roles == 'prodi')
               <li class="{{ request()->is('master/pengguna') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master.pengguna') }}">
                         Pengguna
                    </a>
               </li>
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
               @endif
          </ul>
     </li>
</ul>
</aside>