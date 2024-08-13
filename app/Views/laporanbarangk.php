<style>
    .btntambah{
        width: 100px;
        height: 30px;
        font-size: 12px;
    }
</style>



        <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            <div class="page-title">
                                <h1>Barang Keluar</h1>
                            </div>
                            <div class="btn-group" role="group">
                            
                            <a href="#" onclick="generatePDF()" class="btn btn-danger">Print PDF</a>
                            <a href="#" onclick="generateEXCEL()"class="btn btn-success">Export Excel</a>
                            <a href="#" onclick="generateWINDOWS()" class="btn btn-primary">Print Windows</a>
                        </div>
                            </div>
                            <div class="card-body">
                            <form method="GET" action="<?= base_url('home/filtertanggalbk') ?>">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="startDate">Tanggal Mulai:</label>
                                    <input type="date" id="startDate" name="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="endDate">Tanggal Akhir:</label>
                                    <input type="date" id="endDate" name="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                </div>
                            </div>
                        </form>
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kode</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>

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
                                            <td><?= $key->jumlah?></td>
                                            <td><?= $key->status?></td>
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
function generatePDF() {
    var startDate = document.querySelector('input[name="start_date"]').value;
    var endDate = document.querySelector('input[name="end_date"]').value;

    // Build the URL for the PDF
    var url = '<?= base_url('home/barangk_pdf') ?>' + '?start_date=' + encodeURIComponent(startDate) + '&end_date=' + encodeURIComponent(endDate);

    // Open the URL in a new tab
    window.open(url, '_blank');
}

function generateEXCEL() {
    var startDate = document.querySelector('input[name="start_date"]').value;
    var endDate = document.querySelector('input[name="end_date"]').value;

    // Build the URL for the PDF
    var url = '<?= base_url('home/barangk_excel') ?>' + '?start_date=' + encodeURIComponent(startDate) + '&end_date=' + encodeURIComponent(endDate);

    // Open the URL in a new tab
    window.open(url, '_blank');
}

function generateWINDOWS() {
    var startDate = document.querySelector('input[name="start_date"]').value;
    var endDate = document.querySelector('input[name="end_date"]').value;

    // Build the URL for the PDF
    var url = '<?= base_url('home/barangk_windows') ?>' + '?start_date=' + encodeURIComponent(startDate) + '&end_date=' + encodeURIComponent(endDate);

    // Open the URL in a new tab
    window.open(url, '_blank');
}
</script>
        <div class="clearfix"></div>