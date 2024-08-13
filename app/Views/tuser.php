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
                                <h1>Tambah User</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">User</a></li>
                                    <li class="active">Tambah User</li>
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
                                        <form action="<?=base_url('home/aksi_tuser')?>" method="post" novalidate="novalidate" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Username</label>
                                                <input  name="username" type="text" class="form-control" required>
                                            </div>
                                            <div class="form-group has-success">
                                                <label for="cc-name" class="control-label mb-1">Password</label>
                                                <input id="cc-name" name="password" type="text" class="form-control cc-name valid" data-val="true" data-val-required="" autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name">
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="cc-number" class="control-label mb-1">Email</label>
                                                <input id="cc-number" name="email" type="tel" class="form-control cc-number identified visa" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number">
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Foto</label>
                                                        <input id="cc-number" name="foto" type="file" class="form-control cc-number identified visa" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number">
                                                        <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label for="x_card_code" class="control-label mb-1">Level</label>
                                                    <div class="input-group">
                                                    <select  class="pilih form-control" tabindex="1" name="level">
                                                        <option value="1">Admin</option>
                                                        <option value="3">Pelanggan</option>
                                                        
                                                        </select>
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