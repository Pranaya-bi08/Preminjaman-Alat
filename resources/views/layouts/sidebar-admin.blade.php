@php
    $role = auth()->user()->role; // 'admin', 'petugas', 'peminjam'
@endphp

<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                {{-- ================= ADMIN ================= --}}
                @if ($role === 'admin')
                    <li class="nav-small-cap">
                        <i class="mdi mdi-dots-horizontal"></i>
                        <span class="hide-menu">Admin</span>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.dashboard') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-tune"></i>
                            <span class="hide-menu">Kelola Data</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('user.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-account"></i>
                                    <span class="hide-menu">User</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('alat.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-view-parallel"></i>
                                    <span class="hide-menu">Alat</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('kategori.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-tag-multiple"></i>
                                    <span class="hide-menu">Kategori</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-swap-horizontal"></i>
                            <span class="hide-menu">Transaksi</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('peminjaman.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-clipboard-text"></i>
                                    <span class="hide-menu">Data Peminjaman</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('pengembalian.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-backup-restore"></i>
                                    <span class="hide-menu">Pengembalian</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ route('log.index') }}">
                            <i class="mdi mdi-history"></i>
                            <span class="hide-menu">Log Aktivitas</span>
                        </a>
                    </li>
                @endif

                {{-- ================= PETUGAS ================= --}}
                @if ($role === 'petugas')
                    <li class="nav-small-cap">
                        <i class="mdi mdi-dots-horizontal"></i>
                        <span class="hide-menu">Petugas</span>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ route('petugas.dashboard') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ Route::has('persetujuan.index') ? route('persetujuan.index') : route('petugas.dashboard') }}">
                            <i class="mdi mdi-check-circle"></i>
                            <span class="hide-menu">Menyetujui Peminjaman</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ Route::has('pengembalian.index') ? route('pengembalian.index') : route('petugas.dashboard') }}">
                            <i class="mdi mdi-eye"></i>
                            <span class="hide-menu">Memantau Pengembalian</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ Route::has('peminjaman.laporan') ? route('peminjaman.laporan') : '#' }}">
                            <i class="mdi mdi-printer"></i>
                            <span class="hide-menu">Mencetak Laporan</span>
                        </a>
                    </li>
                @endif

                {{-- ================= PEMINJAM ================= --}}
                @if ($role === 'peminjam')
                    <li class="nav-small-cap">
                        <i class="mdi mdi-dots-horizontal"></i>
                        <span class="hide-menu">Peminjam</span>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('peminjam.dashboard') ? 'selected' : '' }}">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ route('peminjam.dashboard') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('peminjam.alat.*') ? 'selected' : '' }}">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ route('peminjam.alat.index') }}">
                            <i class="mdi mdi-view-list"></i>
                            <span class="hide-menu">Daftar & Kategori Alat</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('peminjam.pengajuan.*') ? 'selected' : '' }}">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ route('peminjam.pengajuan.index') }}">
                            <i class="mdi mdi-send"></i>
                            <span class="hide-menu">Pengajuan Pinjam</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('peminjam.pengembalian.*') ? 'selected' : '' }}">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ route('peminjam.pengembalian.index') }}">
                            <i class="mdi mdi-backup-restore"></i>
                            <span class="hide-menu">Pengembalian Alat</span>
                        </a>
                    </li>
                @endif

                

            </ul>
        </nav>
    </div>
</aside>
