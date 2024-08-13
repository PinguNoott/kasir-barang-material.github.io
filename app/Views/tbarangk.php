<style>
    .pilih{
        width: 100%;
        height: 37px;
        color: grey;
    }

</style>
<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Tambah Barang Keluar</h1>
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
                                        <form action="<?=base_url('home/aksi_tbarangk')?>" method="post" novalidate="novalidate" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Nama Barang</label>
                                                <select  class="pilih form-control" tabindex="1" name="namabarang">
                                                <?php
                                    foreach ($tiga as $key) {
                                    ?> 
                                                        <option value="<?=$key->id_barang?>"><?=$key->nama_barang?></option>
                                    <?php } ?>
                                                        </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Jumlah</label>
                                                        <input id="cc-exp" name="stok" type="number" class="form-control cc-exp" data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year">
                                                        <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                    <i class="fa fa-plus fa-lg"></i>&nbsp;
                                                    <span id="payment-button-amount">Tambah</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- .card -->

                    </div><!--/.col-->
                    </div>