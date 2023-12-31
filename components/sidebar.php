<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="stok.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                    Stok Barang
                </a>
                <a class="nav-link" href="aset.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                    Aset Toko
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsMasuk" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                    Barang Masuk
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsMasuk" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="transaksimasuk.php">Transaksi Barang Masuk</a>
                        <a class="nav-link" href="masuk.php">Laporan Barang Masuk</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsKeluar" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-upload"></i></div>
                    Barang Keluar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsKeluar" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="transaksikeluar.php">Transaksi Barang Keluar</a>
                        <a class="nav-link" href="keluar.php">Laporan Barang Keluar</a>
                    </nav>
                </div>
                <a class="nav-link" href="pesanan.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-bag"></i></div>
                    Pemesanan
                </a>
                <a class="nav-link" href="kategori.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tag"></i></div>
                    Kategori
                </a>
                <a class="nav-link" href="supplier.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-headset"></i></div>
                    Supplier
                </a>
                <a class="nav-link" href="alat.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                    Status Alat
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsKeuangan" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                    Keuangan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsKeuangan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="pemasukan.php">Pemasukan</a>
                        <a class="nav-link" href="pengeluaran.php">Pengeluaran</a>
                        <a class="nav-link" href="labarugi.php">Laporan Laba Rugi</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsGrafik" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-simple"></i></div>
                    Grafik
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsGrafik" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="grafikkategori.php">Grafik Kategori</a>
                        <a class="nav-link" href="grafikstok.php">Grafik Stok</a>
                        <!--<a class="nav-link" href="grafiklaris.php">Grafik Barang Terlaris</a>!-->
                    </nav>
                </div>
                <a class="nav-link" href="logout.php">
                    Logout
                </a>


            </div>
        </div>
    </nav>
</div>