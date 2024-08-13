<style>
    .btntambah{
        width: 100px;
        height: 30px;
        font-size: 12px;
    }

     .buttonhe{
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 10px;
        }
</style>
<?php
$activePage = basename($_SERVER['REQUEST_URI']);

?>
<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Table</a></li>
                                    <li class="active">Data table</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            <a href="<?=base_url('home/Pemesanan')?>">
                                <button type="submit" class="btn btn-lg btn-info btn-block btntambah"><i class="ti ti-plus"></i>Tambah</button>
                            </a>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        
                                    <tr>
                                    <th>No Transaksi</th>
                                    <th>Kode Keranjang</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                    </thead>
                                    <tbody>
                                <?php 
                                foreach ($satu as $key) {
                                ?> 
                                    <tr>
                                        <td><?= $key->no_transaksi?></td>
                                        <td><?= $key->kode_keranjang?></td>
                                        <td><?= "Rp " . number_format($key->jumlah_transaksi, 2, ',', '.') ?></td>
                                        <td><?= $key->tanggal?></td>
                                        <td>
                                        <?php if ($activePage === 'transaksi') { ?>
                                        <a href="<?=base_url('home/etransaksi/'.$key ->id_transaksi)?>">
                                                    <button class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-edit uicon" style="font-size:16px"></i></button>
                                                </a>
                                        <a href="<?=base_url('home/printnota/'.$key ->kode_keranjang)?>" target="blank">
                                                    <button class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-file-text-o uicon" style="font-size:16px"></i></button>
                                        </a>
                                        <a href="<?= base_url('home/sdtransaksi/' .$key->id_transaksi) ?>" onclick="return confirmDelete()">
                                             <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
                                            <i class="fa fa-trash uicon" style="font-size:16px"></i>
                                            </button>
                                        </a>
                                        <?php } ?>

                                        <?php if ($activePage === 'rtransaksi') { ?>
                                        <a href="<?=base_url('home/etransaksi/'.$key ->id_transaksi)?>">
                                                    <button class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-edit uicon" style="font-size:16px"></i></button>
                                                </a>
                                        <a href="<?= base_url('home/rstransaksi/' .$key->id_transaksi) ?>">
                                             <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
                                            <i class="fa fa-refresh uicon" style="font-size:16px"></i>
                                            </button>
                                        </a>
                                        <a href="<?= base_url('home/htransaksi/' .$key->id_transaksi) ?>" onclick="return confirmDelete()">
                                             <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
                                            <i class="fa fa-trash uicon" style="font-size:16px"></i>
                                            </button>
                                        </a>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                                        

                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        <script>
function confirmDelete() {
// Tampilkan konfirmasi
var result = confirm("Apakah kamu yakin mau menghapus data?");

// Jika pengguna menekan OK, return true (lanjutkan penghapusan)
// Jika pengguna menekan Batal, return false (batalkan penghapusan)
return result;
}
</script>

        <div class="clearfix"></div>