<style>
    .pilih{
        width: 100%;
        height: 37px;
        color: grey;
    }

</style>
<?php
// Misalkan Anda telah mengambil nilai acak dari database dan menyimpannya dalam variabel $selected_package_id
$statusbarang = $tiga->kode_keranjang;
?>
<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Edit Transaksi</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Barang</a></li>
                                    <li class="active">Tambah Barang</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="animated fadeIn"></div>
<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Cipta Puri Powerindo</strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        <form action="<?=base_url('home/aksi_etransaksi')?>" method="post" novalidate="novalidate" enctype="multipart/form-data">

                                        <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Keranjang</label>
                                                <select  class="pilih form-control" tabindex="1" name="keranjang">
                                                <?php foreach ($satu as $key): ?>
                                <option value="<?= $key->kode_keranjang ?>" <?= $key->kode_keranjang == $statusbarang ? 'selected' : '' ?>>
                                            <?= $key->kode_keranjang ?>
                                    </option>
                                <?php endforeach; ?>
                                                        </select>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="cc-number" class="control-label mb-1">Total</label>
                                                <input id="cc-number" name="total" type="tel" value="<?= $tiga->jumlah_transaksi ?>" class="form-control cc-number identified visa" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number">
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                            </div>
                                           
                                               <input type="hidden" name="id" value="<?= $tiga->no_transaksi ?>">
                                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                    <i class="fa fa-edit fa-lg"></i>&nbsp;
                                                    <span id="payment-button-amount">Edit</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- .card -->

                    </div><!--/.col-->
                    </div>