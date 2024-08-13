<style>
/* Style umum */
#cardcenter {
    display: flex;
    justify-content: center;
}

.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 15px; /* Margin untuk memberikan ruang pada card */
    position: relative; /* Agar tombol dapat diposisikan di dalam card */
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
    padding: 15px;
    font-size: 1.25em;
    font-weight: bold;
}

.card-body {
    padding: 15px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #f8f9fa;
}

.table td {
    font-size: 1em;
}

.text-center {
    text-align: center;
}

.total-row {
    font-weight: bold;
    margin-top: 10px;
}

.pay-button {
    position: absolute;
    bottom: 15px;
    right: 15px;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
}

.pay-button:hover {
    background-color: #0056b3;
}

/* Media query untuk layar kecil */
@media (max-width: 768px) {
    .card {
        margin: 10px;
    }

    .table th, .table td {
        padding: 8px;
        font-size: 0.9em;
    }

    .card-header {
        font-size: 1.1em;
    }

    .card-body {
        padding: 10px;
    }

    .total-row h5 {
        font-size: 1.1em;
    }

    .pay-button {
        padding: 8px 15px;
        font-size: 0.9em;
    }
}

/* Media query untuk layar ekstra kecil */
@media (max-width: 576px) {
    .card {
        margin: 5px;
    }

    .table th, .table td {
        padding: 6px;
        font-size: 0.8em;
    }

    .card-header {
        font-size: 1em;
    }

    .card-body {
        padding: 8px;
    }

    .total-row h5 {
        font-size: 1em;
    }

    .pay-button {
        padding: 6px 10px;
        font-size: 0.8em;
    }
}
</style>

<div class="content">
    <div class="animated fadeIn">
        <div class="row" id="cardcenter">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Keranjang
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Quantity</th>
                                    <th>Harga Per Unit</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $grand_total = 0;
                                foreach ($tiga as $key) {
                                    // Perhitungan total harga per item
                                    $total_harga = $key->quantity * $key->harga_jual;
                                    // Menambahkan total harga per item ke grand total
                                    $grand_total += $total_harga;
                                ?> 
                                <tr>
                                    <td><?=$key->nama_barang?></td>
                                    <td><?=$key->quantity?></td>
                                    <td><?=number_format($key->harga_jual, 2)?></td>
                                    <td><?=number_format($total_harga, 2)?></td>
                                    <form action="<?=base_url('home/bayar')?>" method="POST">
                                    <input type="hidden" value="<?=$key->kode_keranjang?>" name="kode_keranjang">
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="total-row text-center">
                            <h5>Total Keseluruhan: <?=number_format($grand_total, 2)?></h5>
                        </div>
                        
                        <?php if (session()->get('level') == $empat->id_user && $empat->status === 'pending') { ?>    
                                    <button type="submit" class="pay-button">Checkout</button>
                                <?php } ?>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div><!-- .row -->
    </div><!-- .animated -->
</div>