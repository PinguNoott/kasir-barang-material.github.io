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
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); /* 2 items per row */
        gap: 20px;
    }

    /* Responsive styling */
    @media (max-width: 767px) {
        .row {
            grid-template-columns: 1fr; /* 1 item per row on mobile */
        }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .row {
            grid-template-columns: repeat(2, 1fr); /* 2 items per row on tablet */
        }
    }

    @media (min-width: 1025px) {
        .row {
            grid-template-columns: repeat(2, 1fr); /* 2 items per row on desktop */
        }
    }

    .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%; /* Ensure cards fill their container */
        display: flex;
        flex-direction: column; /* Ensure the card content stacks vertically */
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column; /* Stack elements vertically */
        text-align: left;
    }

    .dataplacement {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-bottom: 10px;
    }

    .photobarang > img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
    }

    .datakeranjang {
        flex-grow: 1;
    }

    .datakeranjang p {
        margin: 5px 0;
        font-size: 1em;
    }

    .card-header {
        background-color: #007bff;
        color: #fff;
        padding: 15px;
        font-size: 1.25em;
        font-weight: bold;
        text-align: center;
    }

    .button-container {
        text-align: center; /* Center align the button */
        margin-top: auto; /* Push the button to the bottom of the card */
    }

    .button-container a {
        text-decoration: none; /* Remove underline from the link */
    }

    .button-container button {
        background-color: red;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-container button:hover {
        background-color: #0056b3;
    }

    </style>
</head>
<body>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <?php if (empty($satu)) { ?>
                <div class="col-12">
                    <p class="no-data-message">Tidak Ada Keranjang</p>
                </div>
            <?php } else { ?>
                <?php foreach ($satu as $key) { ?>
                    <div class="card">
                        <div class="card-body text-secondary">
                            <a href="<?=base_url('home/dkeranjang/'.$key->kode_keranjang)?>" style="text-decoration: none; color: inherit;">
                                <div class="dataplacement">
                                    <div class="photobarang">
                                        <img src="<?=base_url('photo barang/'.$key->foto)?>" alt="Foto Barang">
                                    </div>
                                    <div class="datakeranjang">
                                        <p>Kode Keranjang: <?=$key->kode_keranjang?></p>
                                        <p>Total Harga: <?=number_format($key->total_harga, 2)?></p>
                                    </div>
                                </div>
                            </a>
                            <div class="button-container">
                                <a href="<?=base_url('home/sdkeranjang/'.$key->kode_keranjang)?>">
                                    <button>Remove</button>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>