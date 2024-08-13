<?php
$activePage = basename($_SERVER['REQUEST_URI']);

?>

<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav menu">
            <li class="<?= ($activePage === 'index') ? 'active' : '' ?>">
             <a href="<?= base_url('home/index') ?>"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
            </li>
            
            <?php if (session()->get('level') == 1) { ?>
            <li class="menu-title">Barang</li><!-- /.menu-title -->
                
                    <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-database"></i>Data
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="<?= base_url('home/barang') ?>" class="<?= ($activePage === 'barang') ? 'active' : '' ?>"><i class="fa fa-table"></i>Barang</a></li>
                        <li><a href="<?= base_url('home/barangmasuk') ?>" class="<?= ($activePage === 'barangmasuk') ? 'active' : '' ?>"><i class="fa fa-table"></i>Barang Masuk</a></li>
                        <li><a href="<?= base_url('home/barangkeluar') ?>" class="<?= ($activePage === 'barangkeluar') ? 'active' : '' ?>"><i class="fa fa-table"></i>Barang Keluar</a></li>
                        <li><a href="<?= base_url('home/user/') ?>" class="<?= ($activePage === 'user') ? 'active' : '' ?>"><i class="fa fa-table"></i>User</a></li>
                        <li><a href="<?= base_url('home/datakeranjang/') ?>" class="<?= ($activePage === 'datakeranjang') ? 'active' : '' ?>"><i class="fa fa-table"></i>Keranjang</a></li>
                        <li><a href="<?= base_url('home/transaksi/') ?>" class="<?= ($activePage === 'transaksi') ? 'active' : '' ?>"><i class="fa fa-table"></i>Transaksi</a></li>
                    </ul>
                </li>

            <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-undo"></i>Restore Data
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="<?= base_url('home/rbarang') ?>" class="<?= ($activePage === 'rbarang') ? 'active' : '' ?>"><i class="fa fa-table"></i>Barang</a></li>
                        <li><a href="<?= base_url('home/rbarangmasuk') ?>" class="<?= ($activePage === 'rbarangmasuk') ? 'active' : '' ?>"><i class="fa fa-table"></i>Barang Masuk</a></li>
                        <li><a href="<?= base_url('home/rbarangkeluar') ?>" class="<?= ($activePage === 'rbarangkeluar') ? 'active' : '' ?>"><i class="fa fa-table"></i>Barang Keluar</a></li>
                        <li><a href="<?= base_url('home/ruser/') ?>" class="<?= ($activePage === 'ruser') ? 'active' : '' ?>"><i class="fa fa-table"></i>User</a></li>
                        <li><a href="<?= base_url('home/rkeranjang/') ?>" class="<?= ($activePage === 'rkeranjang') ? 'active' : '' ?>"><i class="fa fa-table"></i>Keranjang</a></li>
                        <li><a href="<?= base_url('home/rtransaksi/') ?>" class="<?= ($activePage === 'rtransaksi') ? 'active' : '' ?>"><i class="fa fa-table"></i>Transaksi</a></li>
                    </ul>
                </li>
            </li>

            <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-file-text"></i>Laporan
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="<?= base_url('home/laporantransaksi') ?>" class="<?= ($activePage === 'laporantransaksi') ? 'active' : '' ?>"><i class="fa fa-file-word-o"></i>Transaksi</a></li>
                        <li><a href="<?= base_url('home/laporanbarangmasuk') ?>" class="<?= ($activePage === 'laporanbarangmasuk') ? 'active' : '' ?>"><i class="fa fa-file-word-o"></i>Barang Masuk</a></li>
                        <li><a href="<?= base_url('home/laporanbarangkeluar') ?>" class="<?= ($activePage === 'laporanbarangkeluar') ? 'active' : '' ?>"><i class="fa fa-file-word-o"></i>Barang Keluar</a></li>
                    </ul>
                </li>
            </li>

            
            

            <?php } ?>

            <?php if (session()->get('level') == 3 || session()->get('level') == 1) { ?>
                <li class="menu-title">Barang</li>
            <li class="<?= ($activePage === 'Pemesanan') ? 'active' : '' ?>">
            <a href="<?= base_url('home/Pemesanan') ?>"><i class="menu-icon fa fa-shopping-bag"></i>Barang Material</a>
            </li>

            <!-- <li class="<?= ($activePage === session()->get('id')) ? 'active' : '' ?>">
            <a href="<?= base_url('home/keranjang/'.session()->get('id')) ?>"><i class="menu-icon fa fa-shopping-cart"></i>keranjang</a>
            </li>

            <li class="<?= ($activePage === 'Pesanan') ? 'active' : '' ?>">
            <a href="<?= base_url('home/Pesanan') ?>"><i class="menu-icon fa fa-cart-plus"></i>Pesanan</a>
            </li>

            <li class="<?= ($activePage === 'hPesanan') ? 'active' : '' ?>">
            <a href="<?= base_url('home/hPesanan') ?>"><i class="menu-icon fa fa-cart-plus"></i>Riwayat Pesanan</a>
            </li> -->
        
            <?php } ?>

            <!-- <?php if (session()->get('level') == 2 || session()->get('level') == 1) { ?>
                <li class="menu-title">Pesanan</li>
                <li class="<?= ($activePage === 'Pemesanan') ? 'active' : '' ?>">
            <a href="<?= base_url('home/infopesanan') ?>"><i class="menu-icon fa fa-laptop"></i>Pesanan</a>
            </li>
            <?php } ?> -->

            <?php if (session()->get('level') == 1) { ?>
                <li class="menu-title">Website</li>
            <li class="<?= ($activePage === 'setting') ? 'active' : '' ?>">
            <a href="<?= base_url('home/setting') ?>"><i class="menu-icon fa fa-gear"></i>Setting</a>
            </li>
            <?php } ?>
   


                   

                    
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="<?=base_url('images/'.$setting->menu_icon)?>" alt="Logo" width="42px"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>

                       

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="<?=base_url('images/'.$dua->foto)?>" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="<?=base_url('home/profile')?>"><i class="fa fa- user"></i>My Profile</a>

                            <a class="nav-link" href="<?=base_url('home/changepassword')?>"><i class="fa fa -cog"></i>Change Password</a>

                            <a class="nav-link" href="<?=base_url('home/logout')?>"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- /#header -->
        <!-- Content -->