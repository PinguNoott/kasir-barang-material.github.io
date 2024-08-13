<style>
    .btntambah{
        width: 100px;
        height: 30px;
        font-size: 12px;
    }

    .aksiwidth{
        width: 150px;
    }

    .statuswidth{
        width: 50px;
    }

    .spacebutton{
        display: flex;
        justify-content: space-between;
    }
    .btn-consistent-width {
    width: 100px; /* Set your desired width here */
    height: 30px; /* Maintain the height */
    font-size: 12px; /* Maintain font size */
    display: inline-flex; /* Ensure the button text is centered */
    align-items: center;
    justify-content: center;
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
                                <h1>Keranjang</h1>
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
                            
                            <a href="<?=base_url('home/tkeranjang')?>">
                                <button type="submit" class="btn btn-lg btn-info btn-block btntambah"><i class="ti ti-plus"></i>Tambah</button>
                            </a>
                         
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        
                                        <tr>

                                            <th>Kode</th>
                                            <th>Total Harga</th>
                                            <th class="statuswidth">Status</th>
                                            <th class="aksiwidth">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $no=1;
                                    foreach ($satu as $key) {
                                    ?> 
                                        <tr>
                                            <td><?= $key->kode_keranjang?></td>
                                            <td><?= "Rp " . number_format($key->total_harga, 2, ',', '.') ?></td>
                                            <td>
                                            <?php if ($key->status === 'pending'): ?>
        <button class="btn btn-danger btn-consistent-width">Pending</button>
    <?php elseif ($key->status === 'checkout'): ?>
        <button class="btn btn-success btn-consistent-width">Checkout</button>
    <?php else: ?>
        <button class="btn btn-default btn-consistent-width">Other Status</button>
    <?php endif; ?>
</td>
                                            <td>
                                            <?php
 switch ($activePage) {
    case 'datakeranjang':
        $urlPath = 'home/sddatakeranjang';
        $idParam = 'kode_keranjang';
        break;
    case 'rkeranjang':
        $urlPath = 'home/rsdatakeranjang';
        $idParam = 'kode_keranjang';
        break;
    default:
        $urlPath = '';
        $idParam = '';
        break;
}
?>

                                            <?php if ($urlPath && $idParam && in_array($activePage, ['datakeranjang'])) { ?>
                                            <div class="spacebutton">
                                            <a href="<?= base_url($urlPath . '/' . $key->$idParam)?>">
                                            <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
                                            <i class="fa fa-trash uicon" style="font-size:16px"></i>
                                            </button>
                                            </a>
                                            <?php } ?>

                                            <?php if ($urlPath && $idParam && in_array($activePage, ['rkeranjang'])) { ?>
                                            <div class="spacebutton">
                                            <a href="<?= base_url($urlPath . '/' . $key->$idParam)?>">
                                            <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
                                            <i class="fa fa-refresh uicon" style="font-size:16px"></i>
                                            </button>
                                            </a>
                                            <?php } ?>
                                            <?php if ($key->status == 'checkout') { ?>
                                            <a href="<?= base_url('home/ekeranjang/'.$key->kode_keranjang)?>">
                                            <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
                                            <i class="fa fa-edit uicon" style="font-size:16px"></i>
                                            </button>
                                            </a>
                                            <?php } ?>
                                            <?php if ($key->status == 'pending') { ?>
                                            <a href="<?= base_url('home/ekeranjangp/'.$key->kode_keranjang)?>">
                                            <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
                                            <i class="fa fa-edit uicon" style="font-size:16px"></i>
                                            </button>
                                            </a>
                                            <?php } ?>
                                            <a href="<?=base_url('home/dkeranjang/'.$key->kode_keranjang)?>">
                                            <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton">
                                            <i class="fa fa-info-circle uicon" style="font-size:16px"></i>
                                            </button>
                                            </a>
                                            </div>






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
var result = confirm("Apakah kamu yakin mau menghapus data pelanggan?");

// Jika pengguna menekan OK, return true (lanjutkan penghapusan)
// Jika pengguna menekan Batal, return false (batalkan penghapusan)
return result;
}
</script>

        <div class="clearfix"></div>