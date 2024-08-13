<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        .card {
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            font-size: 1.5em;
            font-weight: bold;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th, .items-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .items-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            font-size: 1.2em;
        }

        .payment-options {
            margin-top: 20px;
        }

        .payment-options label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .payment-options input[type="text"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        .tombolco {
            text-align: center;
            margin-top: 20px;
        }

        .tombolco button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .tombolco button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            .items-table {
                font-size: 0.9em;
            }

            .items-table th, .items-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="card">
            <div class="card-header">
                Pembayaran
            </div>
            <div class="card-body">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($satu)): ?>
                            <?php
                            $totalPrice = 0;
                            foreach ($satu as $item): 
                                $itemTotal = $item->quantity * $item->harga_jual;
                                $totalPrice += $itemTotal;
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($item->nama_barang); ?></td>
                                    <td><?= htmlspecialchars($item->quantity); ?></td>
                                    <td>Rp <?= number_format($itemTotal, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">Tidak Ada Barang.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="total">
                    Total Barang: <?= count($satu); ?><br>
                    Total Harga: Rp <?= number_format($totalPrice, 0, ',', '.'); ?>
                </div>
                <div class="payment-options">
                    <form id="payment-form" action="<?= base_url('home/cash') ?>" method="post" onsubmit="return validateForm()">
                        <label>Nominal Pembayaran</label>
                        <input type="text" id="payment-amount" name="payment_amount" placeholder="Masukkan Jumlah Uang" required>

                        <label>Kembalian</label>
                        <input type="text" id="change" name="change" readonly>

                        <?php foreach ($satu as $item): ?>
                            <input type="hidden" name="id_barang[]" value="<?= htmlspecialchars($item->id_barang) ?>">
                            <input type="hidden" name="quantity[]" value="<?= htmlspecialchars($item->quantity) ?>">
                        <?php endforeach; ?>
                        <input type="hidden" name="kode_keranjang" value="<?= htmlspecialchars($kode_keranjang) ?>">
                        <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user) ?>">
                        <input type="hidden" name="total_price" value="<?= htmlspecialchars($totalPrice) ?>">
                        <div class="tombolco">
                            <button type="submit">Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var paymentAmount = parseFloat(document.getElementById('payment-amount').value.replace(/[^0-9.,]/g, '')) || 0;
            var totalPrice = parseFloat("<?= $totalPrice ?>");
            var change = paymentAmount - totalPrice;

            document.getElementById('change').value = "Rp " + change.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            if (paymentAmount < totalPrice) {
                alert("Jumlah uang tidak cukup.");
                return false;
            }
            return true;
        }

        document.getElementById('payment-amount').addEventListener('input', function() {
            var paymentAmount = parseFloat(this.value.replace(/[^0-9.,]/g, '')) || 0;
            var totalPrice = parseFloat("<?= $totalPrice ?>");
            var change = paymentAmount - totalPrice;

            document.getElementById('change').value = "Rp " + change.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        });

        document.getElementById('payment-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            if (!validateForm()) return; // Validate the form

            // Create a new FormData object to send with the requests
            var formData = new FormData(this);
            
            // Log form data for debugging
            formData.forEach((value, key) => {
                console.log(key, value);
            });

            // Send AJAX request to home/cash
            fetch(this.action, {
                method: 'POST',
                body: formData
            }).then(response => {
                return response.text().then(text => {
                    console.log('Response Text:', text); // Log response for debugging
                    if (response.ok) {
                        // Open home/print_nota in a new tab
                        window.open('<?= base_url('home/printnota/'. $kode_keranjang) ?>', '_blank');
                        window.location.href = '<?= base_url('home/Pemesanan') ?>';
                    } else {
                        alert("Terjadi kesalahan saat memproses pembayaran.");
                    }
                });
            }).catch(error => {
                alert("Terjadi kesalahan: " + error.message);
                console.error('Fetch Error:', error);
            });
        });
    </script>
</body>
</html>
