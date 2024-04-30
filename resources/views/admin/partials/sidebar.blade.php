<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.dashboard') ? '': 'collapsed' }}" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-heading">Data Master</li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.jurusan') ? '': 'collapsed' }}" href="{{ route('admin.jurusan') }}">
        <i class="bi bi-mortarboard"></i>
        <span>Jurusan</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.kelas') ? '': 'collapsed' }}" href="{{ route('admin.kelas') }}">
        <i class="bi bi-people"></i>
        <span>Kelas</span>
      </a>
    </li>

  </ul>

</aside>