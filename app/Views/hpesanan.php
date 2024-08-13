<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.content {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.no-data-message {
    text-align: center;
    font-size: 1.5em;
    color: #666;
    margin-top: 20px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.col {
    flex: 1 1 calc(50% - 20px); /* 2 items per row */
    box-sizing: border-box; /* Include padding and border in width */
}

.card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding: 15px;
    display: flex; /* Flex container */
    align-items: center; /* Vertically center items */
    gap: 20px; /* Space between image and text */
}

.card-body {
    flex: 1;
    display: flex;
    flex-direction: row; /* Stack text elements vertically */
}

.card-body img {
    width: 100px; /* Fixed width */
    height: 100px; /* Fixed height */
    object-fit: cover; /* Maintain aspect ratio */
    border-radius: 8px; /* Rounded corners */
    margin-right: 15px; /* Space between image and text */
}

.card-text {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center text vertically */
}

.btn {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    color: #fff;
    text-align: center;
    font-size: 0.9em;
    font-weight: bold;
}

.btn-danger {
    background-color: #dc3545;
}

.btn-info {
    background-color: #17a2b8;
}

.btn-success {
    background-color: #28a745;
}

.btn-secondary {
    background-color: #6c757d;
}

@media (max-width: 768px) {
    .col {
        flex: 1 1 100%; /* 1 item per row on smaller screens */
    }
}


    </style>
</head>
<body>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <?php if (empty($satu)) { ?>
                <div class="col-12">
                    <p class="no-data-message">Tidak Ada Riwayat Pesanan</p>
                </div>
            <?php } else { ?>
                <?php foreach ($satu as $key) { ?>
                    <div class="col">
                        <section class="card">
                            <div class="card-body">
                                <img src="<?=base_url('photo barang/'.$key->foto)?>" alt="Foto Barang">
                                <div class="card-text">
                                    <a href="<?=base_url('home/dkeranjang/'.$key->kode_keranjang)?>" style="text-decoration: none; color: inherit;">
                                        <p>Kode Keranjang: <?=$key->kode_keranjang?></p>
                                        <p>Total Harga: <?=number_format((float)$key->total_transaksi, 2)?></p>
</p>
                                    </a>
                                    <?php
                                    $buttonClass = '';
                                    // Menentukan kelas tombol berdasarkan status transaksi
                                    switch ($key->status_transaksi) {
                                        case 'Pending':
                                            $buttonClass = 'btn-danger'; // Kelas untuk Pending
                                            break;
                                        case 'On The Way':
                                            $buttonClass = 'btn-info'; // Kelas untuk On The Way
                                            break;
                                        case 'Done':
                                            $buttonClass = 'btn-success'; // Kelas untuk Done
                                            break;
                                        default:
                                            $buttonClass = 'btn-secondary'; // Kelas default untuk status lain
                                            break;
                                    }
                                    ?>
                                    <div class="btn <?= $buttonClass ?>">
                                        <?= $key->status_transaksi ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>