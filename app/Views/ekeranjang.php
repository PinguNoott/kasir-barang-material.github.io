<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your CSS links here -->
    <style>
        .item-card {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            display: flex;
            align-items: center;
        }
        .item-card img {
            max-width: 100px;
            margin-right: 15px;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
        }
        .quantity-controls input {
            width: 60px;
            text-align: center;
            margin: 0 5px;
        }
        .add-item-btn {
            margin-top: 15px;
        }
        .total-display {
            margin-top: 20px;
        }
        .no-items-message {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Edit Cart</h1>
        
        <div id="cart-items">
            <!-- Inject cart items here -->
            <?php if (empty($tiga)): ?>
                <div class="no-items-message">
                    TIDAK ADA TRANSAKSI DENGAN KERANJANG INI
                </div>
                <script>
                    // Redirect to home/datakeranjang if $tiga is empty
                    window.location.href = '<?= base_url('home/datakeranjang') ?>';
                </script>
            <?php else: ?>
                <?php foreach ($tiga as $item): ?>
                    <div class="item-card">
                        <img src="<?= base_url('photo barang/' . $item->foto) ?>" alt="<?= $item->nama_barang ?>">
                        <div>
                            <h5><?= $item->nama_barang ?></h5>
                            <p>Price: <?= number_format($item->harga_jual, 0, ',', '.') ?> IDR</p>
                            <input type="hidden" value="<?= $item->id_barang ?>" name="id_barang" id="id_barang-<?= $item->id_Keranjang ?>">
                            <div class="quantity-controls">
                                <button class="btn btn-success btn-sm" onclick="updateQuantity(<?= $item->id_Keranjang ?>, -1)">-</button>
                                <input type="number" id="quantity-<?= $item->id_Keranjang ?>" value="<?= $item->quantity ?>" min="0">
                                <button class="btn btn-success btn-sm" onclick="updateQuantity(<?= $item->id_Keranjang ?>, 1)">+</button>
                                <button class="btn btn-danger btn-sm" 
                                style="margin-left: 5px;" onclick="removeItem(<?= $item->id_Keranjang ?>)">X</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($tiga)): ?>
            <button class="btn btn-primary add-item-btn" data-toggle="modal" data-target="#addItemModal">Add New Item</button>
        <?php endif; ?>
        
        <div class="total-display">
            <h4>Total: <span id="total-price">0</span> IDR</h4>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm">
                        <div class="form-group">
                            <label for="itemSelect">Select Item</label>
                            <select class="form-control" id="itemSelect">
                                <?php foreach ($satu as $item): ?>
                                    <option value="<?= $item->id_barang ?>" data-price="<?= $item->harga_jual ?>"><?= $item->nama_barang ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" min="1" value="1">
                        </div>
                        <input type="hidden" id="kode-keranjang" value="<?= isset($tiga[0]->kode_keranjang) ? $tiga[0]->kode_keranjang : '' ?>">
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script>
    // Ensure cartItems data is correctly passed
    
    const cartItems = <?= json_encode($tiga) ?>;

    function updateQuantity(id, change) {
        const quantityInput = document.getElementById(`quantity-${id}`);
        const kodeKeranjangElement = document.getElementById('kode-keranjang');
        const kodeKeranjang = kodeKeranjangElement ? kodeKeranjangElement.value : ''; // Handle case if element is missing

        if (quantityInput) {
            let quantity = parseInt(quantityInput.value) + change;
            if (quantity < 0) quantity = 0;
            quantityInput.value = quantity;

            // Get the id_barang for the specific cart item
            const id_barang = document.getElementById(`id_barang-${id}`).value;

            if (!id_barang) {
                console.error(`id_barang for cart item ${id} not found.`);
                return;
            }

            // Send update request to server
            fetch(`<?= base_url('home/updateCart') ?>/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ quantity: quantity, kode_keranjang: kodeKeranjang, item_id: id, id_barang: id_barang }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateTotalPrice();
                    console.log(id, kodeKeranjang);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            console.error(`Quantity input for item ${id} not found.`);
        }
    }

    function updateTotalPrice() {
    let total = 0;
    cartItems.forEach(item => {
        const quantityInput = document.getElementById(`quantity-${item.id_Keranjang}`);
        if (quantityInput) {
            const quantity = parseInt(quantityInput.value, 10); // Use radix 10
            if (!isNaN(quantity)) {
                total += item.harga_jual * quantity;
            } else {
                console.error(`Invalid quantity for item ${item.id_Keranjang}`);
            }
        } else {
            console.error(`Quantity input for item ${item.id_Keranjang} not found.`);
        }
    });
    
    const formattedTotal = total.toLocaleString('id-ID');
    document.getElementById('total-price').innerText = formattedTotal;

    // Debugging
    console.log('Calculated total price:', total);

    // Convert data to URL-encoded string
    const nomorTransaksi = '<?= isset($empat->no_transaksi) ? $empat->no_transaksi : '' ?>';

    // Check if nomorTransaksi is null or empty
    if (!nomorTransaksi) {
        // Redirect to home/datakeranjang if nomorTransaksi is not set
        window.location.href = '<?= base_url('home/datakeranjang') ?>';
        return; // Stop further execution
    }

    // Prepare URL-encoded data
    const params = new URLSearchParams();
    params.append('nomor_transaksi', nomorTransaksi);
    params.append('total_price', total);

    fetch(`<?= base_url('home/updateTotalPrice') ?>`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params.toString(), // Send URL-encoded data
    })
    .then(response => response.json())
    .then(data => {
        if (total === 0) {
            window.location.href = '<?= base_url('home/datakeranjang') ?>';
        } else if (!data.success) {
            console.error('Failed to update total price in nota:', data.message);
        } else {
            console.log('Successfully updated total price:', data);
        }
    })
    .catch(error => console.error('Error:', error));
}

    function removeItem(id) {
        const kodeKeranjangElement = document.getElementById('kode-keranjang');
        const kodeKeranjang = kodeKeranjangElement ? kodeKeranjangElement.value : ''; // Handle case if element is missing
        const id_barang = document.getElementById(`id_barang-${id}`).value;

        // Use POST method to include a request body
        fetch(`<?= base_url('home/removeCart') ?>/${id}`, {
            method: 'POST', // Changed from DELETE to POST to include a body
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ kode_keranjang: kodeKeranjang, id_barang: id_barang }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const itemCard = document.querySelector(`#quantity-${id}`);
                if (itemCard) {
                    itemCard.closest('.item-card').remove();
                    updateTotalPrice();
                } else {
                    console.error(`Item card for item ${id} not found.`);
                }
            } else {
                console.error('Failed to remove item');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.getElementById('addItemForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const itemId = document.getElementById('itemSelect').value;
        const quantity = parseInt(document.getElementById('quantity').value);
        addItem(itemId, quantity);
    });

    function addItem(itemId, quantity) {
        const apiUrl = `<?= base_url('home/addItem') ?>`;
        const kodeKeranjangElement = document.getElementById('kode-keranjang');
        const kodeKeranjang = kodeKeranjangElement ? kodeKeranjangElement.value : ''; // Handle case if element is missing

        console.log('Sending itemId:', itemId, 'Quantity:', quantity, 'Kode Keranjang:', kodeKeranjang); // Log the values

        // Convert data to URL-encoded string
        const params = new URLSearchParams();
        params.append('item_id', itemId);
        params.append('quantity', quantity);
        params.append('kode_keranjang', kodeKeranjang); // Include kode_keranjang in the request

        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: params.toString(), // Send URL-encoded data
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Network response was not ok: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Server response:', data); // Log the response
            if (data.success) {
                location.reload(); // Reload page to reflect changes
            } else {
                console.error('Error from server:', data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }

    document.addEventListener('DOMContentLoaded', updateTotalPrice);
    </script>
</body>
</html>
