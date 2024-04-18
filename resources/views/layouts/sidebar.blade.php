<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('img/logistyx1.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ Config::get('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->foto }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('user.profil') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if(Auth::user()->level == 0)
                <li class="nav-header">Master</li>
                <li class="nav-item">
                    <a href="{{ route('gudang.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-warehouse"></i>
                        <p>
                            Gudang
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kategori.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-cube"></i>
                        <p>
                            Kategori
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('produk.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-cubes"></i>
                        <p>
                            Produk
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supplier.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-truck"></i>
                        <p>
                            Supplier
                        </p>
                    </a>
                </li>

                <li class="nav-header">Transaksi</li>


                <li class="nav-item">
                    <a href="{{ route('pembelian.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-download"></i>
                        <p>
                            Pembelian
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('penjualan.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-upload"></i>
                        <p>
                            Penjualan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transaksi.baru') }}" class="nav-link">
                        <i class="nav-icon fa fa-cart-arrow-down"></i>
                        <p>
                            Transaksi Aktif
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transaksi.baru') }}" class="nav-link">
                        <i class="nav-icon fa fa-cart-arrow-down"></i>
                        <p>
                            Transaksi Baru
                        </p>
                    </a>
                </li>

                <li class="nav-header">SYSTEM</li>

                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('setting.index') }}" class="nav-link">
                        <i class="fa fa-cogs"></i>
                        <p>
                            Setting
                        </p>
                    </a>
                </li>
                @else
                <li class="nav-header">Transaksi</li>
                <li class="nav-item">
                    <a href="{{ route('penjualan.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-upload"></i>
                        <p>
                            Penjualan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transaksi.baru') }}" class="nav-link">
                        <i class="nav-icon fa fa-cart-arrow-down"></i>
                        <p>
                            Transaksi Aktif
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transaksi.baru') }}" class="nav-link">
                        <i class="nav-icon fa fa-cart-arrow-down"></i>
                        <p>
                            Transaksi Baru
                        </p>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

@push('scripts')
<script>
    $(document).ready(function() {
        var url = window.location;
        // for sidebar menu entirely but not cover treeview
        $('ul.nav-sidebar a').filter(function() {
            return this.href == url;
        }).addClass('active');

        // for treeview
        $('ul.nav-treeview a').filter(function() {
            return this.href == url;
        }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
    })

</script>
@endpush
