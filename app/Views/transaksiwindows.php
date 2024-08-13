<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        /* Ensure the document size and styling match an A4 page */
        @page {
            size: A4;
            margin: 0; /* Remove margins for printing */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .content {
            position: relative;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent white background for content area */
            border-radius: 8px; /* Optional: rounded corners for content box */
            box-shadow: 0 0 5px rgba(0,0,0,0.1); /* Optional: slight shadow to lift content */
        }
        .header {
            margin-bottom: 20px;
        }
        .title, .subtitle {
            text-align: left;
            margin: 0;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }
        .subtitle {
            font-size: 18px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #FFFF00; /* Yellow background for header */
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            text-align: right;
            border-top: 2px solid #000;
        }
        .total-value {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="header">
            <div class="title">Laporan Transaksi</div>
            <div class="subtitle"><?= isset($setting->judul_website) ? $setting->judul_website : 'Default Website' ?></div>
            <div class="subtitle">Tanggal Transaksi: <?= isset($startDate) ? $startDate : '0000-00-00' ?> - <?= isset($endDate) ? $endDate : '9999-12-31' ?></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>Kode</th>
                    <th>Jumlah Bayar</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalAmount = 0; foreach ($satu as $item): ?>
    <tr>
        <td><?= htmlspecialchars($item->no_transaksi, ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($item->kode_keranjang, ENT_QUOTES, 'UTF-8') ?></td>
        <td>Rp <?= number_format((float)$item->total_transaksi, 2, ',', '.') ?></td>
        <td><?= htmlspecialchars($item->username, ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($item->tanggal, ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <?php $totalAmount += (float)$item->total_transaksi; endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4">Total</td>
                    <td class="total-value">Rp <?= number_format($totalAmount, 2, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script>
    window.addEventListener('load', function() {
        window.print();
    });
</script>
</body>
</html>