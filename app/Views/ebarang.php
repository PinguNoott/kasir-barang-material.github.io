<style>
    .pilih{
        width: 100%;
        height: 37px;
        color: grey;
    }

</style>
<?php
// Misalkan Anda telah mengambil nilai acak dari database dan menyimpannya dalam variabel $selected_package_id

$statusbarang = $satu->status;

// Kemudian Anda bisa menggunakan variabel tersebut dalam loop untuk menandai opsi yang dipilih
?>
<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Tambah Barang</h1>
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
                                        <form action="<?=base_url('home/aksi_ebarang')?>" method="post" novalidate="novalidate">

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Nama Barang</label>
                                                <input id="cc-payment" name="nbarang" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$satu->nama_barang?>">
                                            </div>
                                            <div class="form-group has-success">
                                                <label for="cc-name" class="control-label mb-1">Kode Barang</label>
                                                <input id="cc-name" name="kbarang" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name" value="<?=$satu->kode_barang?>">
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="cc-number" class="control-label mb-1">Harga Beli</label>
                                                <input id="cc-number" name="hbeli" type="tel" class="form-control cc-number identified visa" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number" value="<?=$satu->harga_beli?>">
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="cc-number" class="control-label mb-1">Harga Jual</label>
                                                <input id="cc-number" name="hjual" type="tel" class="form-control cc-number identified visa" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number" value="<?=$satu->harga_jual?>">
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">stok</label>
                                                        <input id="cc-exp" name="stok" type="number" class="form-control cc-exp" data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" value="<?=$satu->stok?>">
                                                        <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label for="x_card_code" class="control-label mb-1">Status</label>
                                                    <div class="input-group">
                                                    <select  class="pilih form-control" tabindex="1" name="status" value="<?=$satu->status?>">
                                                        <option value="tersedia" <?php echo ($statusbarang == 'tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                                        <option value="tidak tersedia" <?php echo ($statusbarang == 'tidak tersedia') ? 'selected' : ''; ?>>Tidak Tersedia</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                    <i class="fa fa-edit fa-lg"></i>&nbsp;
                                                    <span id="payment-button-amount">Edit</span>
                                                </button>
                                                <input type="hidden" name="id" value="<?=$satu->id_barang?>">
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- .card -->

                    </div><!--/.col-->
                    </div>