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
                                <h1>Setting</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Setting</a></li>
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
                                        <form action="<?=base_url('home/aksi_esetting')?>" method="post" novalidate="novalidate" enctype="multipart/form-data">
                                        <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Judul Website</label>
                                                <input  name="judul_website" type="text" class="form-control" value="<?=$setting->judul_website?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Tab Icon</label>
                                                <input  name="t_icon" type="file" class="form-control" value="<?=$setting->tab_icon?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Menu Icon</label>
                                                <input  name="m_icon" type="file" class="form-control" value="<?=$setting->menu_icon?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cc-number" class="control-label mb-1">Login_icon</label>
                                                <input id="cc-number" name="l_icon" type="file" value="<?=$setting->login_icon?>" class="form-control cc-number identified visa" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number">
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                            </div>
    
                                            </div>
                                            
                                            <div>
                                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                    <i class="fa fa-plus fa-lg"></i>&nbsp;
                                                    <span id="payment-button-amount">Tambah</span>
                                                </button>
                                                <input type="hidden" value="<?=$setting->id_setting?>" name="id">
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- .card -->

                    </div><!--/.col-->
                    </div>