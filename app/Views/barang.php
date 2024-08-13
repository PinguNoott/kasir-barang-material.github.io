<style>
    .btntambah{
        width: 100px;
        height: 30px;
        font-size: 12px;
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
                            <?php if ($activePage === 'barang') { ?>
                            <a href="<?=base_url('home/tbarang')?>">
                                <button type="submit" class="btn btn-lg btn-info btn-block btntambah"><i class="ti ti-plus"></i>Tambah</button>
                            </a>
                            <?php } ?>
                            <?php if ($activePage === 'barangmasuk') { ?>
                            <a href="<?=base_url('home/tbarangm')?>">
                                <button type="submit" class="btn btn-lg btn-info btn-block btntambah"><i class="ti ti-plus"></i>Tambah</button>
                            </a>
                            <?php } ?>
                            <?php if ($activePage === 'barangkeluar') { ?>
                            <a href="<?=base_url('home/tbarangk')?>">
                                <button type="submit" class="btn btn-lg btn-info btn-block btntambah"><i class="ti ti-plus"></i>Tambah</button>
                            </a>
                            <?php } ?>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kode</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <?php if ($activePage === 'barang') { ?>
                                            <th>Stok</th>
                                            <?php } ?>
                                            <?php if ($activePage === 'barangmasuk') { ?>
                                            <th>Jumlah</th>
                                            <?php } ?>
                                            <?php if ($activePage === 'barangkeluar') { ?>
                                            <th>Jumlah</th>
                                            <?php } ?>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $no=1;
                                    foreach ($satu as $key) {
                                    ?> 
                                        <tr>
                                            <td><?= $key->nama_barang?></td>
                                            <td><?= $key->kode_barang?></td>
                                            <td><?= $key->harga_beli?></td>
                                            <td><?= $key->harga_jual?></td>
                                            <?php if ($activePage === 'barang') { ?>
                                            <td><?= $key->stok?></td>
                                            <?php } ?>
                                            <?php if ($activePage === 'barangmasuk') { ?>
                                            <td><?= $key->quantity?></td>
                                            <?php } ?>
                                            <?php if ($activePage === 'barangkeluar') { ?>
                                            <td><?= $key->jumlah?></td>
                                            <?php } ?>
                                            <td><?= $key->status?></td>
                                            <td>
                                                <div class="buttonhe">
                                                <?php if ($activePage === 'barang') { ?>
                                                <a href="<?=base_url('home/ebarang/'.$key ->id_barang)?>">
                                                    <button class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-edit uicon" style="font-size:16px"></i></button></a>
                                                <?php } ?>
                                                <?php if ($activePage === 'barangkeluar') { ?>
                                                <a href="<?=base_url('home/ebarangk/'.$key ->id_bkeluar)?>">
                                                    <button class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-edit uicon" style="font-size:16px"></i></button></a>
                                                <?php } ?>
                                                <?php if ($activePage === 'barangmasuk') { ?>
                                                <a href="<?=base_url('home/ebarangm/'.$key ->id_bmasuk)?>">
                                                    <button class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-edit uicon" style="font-size:16px"></i></button></a>
                                                <?php } ?>

                                                <?php
// Determine the URL path and ID parameter based on the active page
switch ($activePage) {
    case 'barang':
        $urlPath = 'home/sdbarang';
        $idParam = 'id_barang';
        break;
    case 'barangmasuk':
        $urlPath = 'home/sdbarangm';
        $idParam = 'id_bmasuk';
        break;
    case 'barangkeluar':
        $urlPath = 'home/sdbarangk';
        $idParam = 'id_bkeluar';
        break;
    case 'rbarang':
        $urlPath = 'home/rsbarang';
        $idParam = 'id_barang';
        $urlPathh = 'home/hbarang';
        break;
    case 'rbarangmasuk':
        $urlPath = 'home/rsbarangm';
        $idParam = 'id_bmasuk';
        $urlPathh = 'home/hbarangm';
        break;
    case 'rbarangkeluar':
        $urlPath = 'home/rsbarangk';
        $idParam = 'id_bkeluar';
        $urlPathh = 'home/hbarangk';
        break;
    default:
        $urlPath = '';
        $idParam = '';
        break;
}
?>

<?php if ($urlPath && $idParam && in_array($activePage, ['rbarang', 'rbarangmasuk', 'rbarangkeluar'])) { ?>
    <a href="<?= base_url($urlPath . '/' . $key->$idParam) ?>" onclick="return confirmDelete()">
        <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
            <i class="fa fa-refresh uicon" style="font-size:16px"></i>
        </button>
    </a>
<?php } ?>

<?php if ($urlPath && $idParam && in_array($activePage, ['rbarang', 'rbarangmasuk', 'rbarangkeluar'])) { ?>
    <a href="<?= base_url($urlPathh. '/' . $key->$idParam) ?>" onclick="return confirmDelete()">
        <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
            <i class="fa fa-trash uicon" style="font-size:16px"></i>
        </button>
    </a>
<?php } ?>

<?php if ($urlPath && $idParam && in_array($activePage, ['barang', 'barangmasuk', 'barangkeluar'])) { ?>
    <a href="<?= base_url($urlPath . '/' . $key->$idParam) ?>" onclick="return confirmDelete()">
        <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
            <i class="fa fa-trash uicon" style="font-size:16px"></i>
        </button>
    </a>
<?php } ?>
                                                </div>
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