<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ route('dashboard') }}">e-Arsip DSI</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('dashboard') }}">EA</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>

      @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
      <li class="menu-header">Master Data</li>
      <li><a class="nav-link" href="{{ route('jenisDokumen.index') }}"><i class="fas fa-tags"></i> <span>Kategori</span></a></li>
      @endif

      @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
      <li class="menu-header">Arsip</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-file-alt"></i><span>Dokumen</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ route('dataArsip.index') }}">List Dokumen</a></li>
          <li><a class="nav-link" href="{{ route('dataArsip.create') }}">Tambah Dokumen</a></li>
        </ul>
      </li>
      @endif

      <li class="menu-header">Surat</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-envelope"></i><span>Surat Masuk</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ route('surat-masuk.index') }}">List Surat Masuk</a></li>
          <li><a class="nav-link" href="{{ route('surat-masuk.create') }}">Tambah Surat Masuk</a></li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-paper-plane"></i><span>Surat Keluar</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ route('surat-keluar.index') }}">List Surat Keluar</a></li>
          <li><a class="nav-link" href="{{ route('surat-keluar.create') }}">Buat Pengajuan</a></li>
        </ul>
      </li>

      @if (auth()->user()->id_role == 1)
      <li class="menu-header">User Management</li>
      <li><a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-users"></i> <span>Data Users</span></a></li>
      @endif

      {{-- Batch feature disabled for e-Arsip system --}}
      {{-- @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
      <li class="menu-header">Batch</li>
      <li><a class="nav-link" href="/batch"><i class="fas fa-file-alt"></i> <span>List Batch</span></a></li>
      @endif --}}
    </ul>

      <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button type="submit" class="btn btn-primary btn-lg btn-block btn-icon-split"><i class="fas fa-sign-out-alt"></i>Logout</button>
        </form>
      </div>
  </aside>
