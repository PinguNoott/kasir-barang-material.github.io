<style>
    .btntambah{
        width: 100px;
        height: 30px;
        font-size: 12px;
    }

    .aksicuy{
        width: 50px;
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
                            <?php if ($activePage === 'user') { ?>
                            <a href="<?=base_url('home/tuser')?>">
                                <button type="submit" class="btn btn-lg btn-info btn-block btntambah"><i class="ti ti-plus"></i>Tambah</button>
                            </a>
                            <?php } ?>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        
                                        <tr>
                                            <th>Nama</th>
                                            <th>Level</th>
                                            <th class="aksicuy">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $no=1;
                                    foreach ($satu as $key) {
                                        $level = '';
                                        if ($key->level == 1) {
                                            $level = 'Admin';
                                       
                                        } elseif ($key->level == 3) {
                                            $level = 'Pelanggan';
                                        }
                                    ?> 
                                        <tr>
                                            <td><?= $key->username?></td>
                                            <td><?= $level?></td>
                                            <td>
                                                <div class="buttonhe">
                                                <?php if ($activePage === 'user') { ?>
                                                <a href="<?=base_url('home/resetpassword/'.$key ->id_user)?>">
                                                <button class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-undo uicon" style="font-size:16px"></i></button></a>
                                                <a href="<?=base_url('home/detailuser/'.$key ->id_user)?>">
                                                <button class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-edit uicon" style="font-size:16px"></i></button></a>
                                                <a href="<?=base_url('home/sduser/'.$key ->id_user)?>" onclick="return confirmDelete()">
                                                <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-trash-o uicon" style="font-size:16px"></i></button></a>
                                                <?php } ?>
                                                <?php if ($activePage === 'ruser') { ?>
                                                    <a href="<?=base_url('home/rsuser/'.$key ->id_user)?>" onclick="return confirmDelete()">
                                                    <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-refresh uicon" style="font-size:16px"></i></button></a>
                                                    <a href="<?=base_url('home/huser/'.$key ->id_user)?>" onclick="return confirmDelete()">
                                                    <button id="showPopupButton" class="btn btn-lg btn-info btn-block hebutton"><i class="fa fa-trash-o uicon" style="font-size:16px"></i></button></a>
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