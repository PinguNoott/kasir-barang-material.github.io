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
            flex-direction: column;
            gap: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 15px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            flex-grow: 1;
        }

        .card-body a {
            text-decoration: none;
            color: inherit;
        }

        .card-body p {
            margin: 5px 0;
            font-size: 1em;
        }

        .statust {
            margin-left: 20px;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .btn {
            padding: 5px 10px;
            border-radius: 20px;
            color: #fff;
            font-size: 0.9em;
            text-align: center;
        }

        .btn-danger { background-color: #dc3545; }
        .btn-info { background-color: #17a2b8; }
        .btn-success { background-color: #28a745; }
        .btn-secondary { background-color: #6c757d; }

        .buttonpe {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 0.9em;
            display: flex;
            align-items: center;
        }

        .buttonpe:hover {
            background-color: #0056b3;
        }

        .buttonpe.fa-check::before {
            content: "\f00c";
            font-family: FontAwesome;
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <?php if (empty($satu)) { ?>
                <div class="col-12">
                    <p class="no-data-message">Tidak Ada Pesanan</p>
                </div>
            <?php } else { ?>
                <?php foreach ($satu as $key) { ?>
                    <div class="card">
                        <div class="card-body text-secondary">
                            <a href="<?=base_url('home/dkeranjang/'.$key->kode_keranjang)?>">
                                <p>Kode Keranjang: <?=$key->kode_keranjang?></p>
                                <p>Total Harga: <?=number_format($key->total_transaksi, 2)?></p>
                            </a>
                        </div>

                        <?php if (session()->get('level') == 1) { ?>    
                        <a href="<?=base_url('home/printnota/'.$key->kode_keranjang)?>">
                        <button class="buttonpe">Print Nota</button>
                        </a>
                        <?php } ?>

                        <div class="statust">
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
                            <?php if (session()->get('level') == 1 && $key->status_transaksi == 'Pending') { ?>
                                <a href="<?=base_url('home/statusto/'.$key->id_transaksi)?>">
                                    <button class="buttonpe fa fa-check">Verifikasi</button>
                                </a>
                            <?php } ?>
                            
                            <?php if (session()->get('id') == $satu[0]->id_user || session()->get('level') == 1) { ?>    
                            <?php if ($key->status_transaksi == 'On The Way') { ?>
                                <a href="<?=base_url('home/statustd/'.$key->id_transaksi)?>">
                                    <button class="buttonpe fa fa-check">Selesai</button>
                                </a>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>