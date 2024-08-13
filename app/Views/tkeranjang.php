<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart and Modal Example</title>
    <style>
        .sspemesanan {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .sspemesanan .item {
            flex: 1 0 calc(33.333% - 20px);
            max-width: calc(33.333% - 20px);
            box-sizing: border-box;
            padding: 10px;
        }

        .sspemesanan .item .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .sspemesanan .item .card .photobarang {
            height: 210px;
            object-fit: cover;
        }

        .sspemesanan .item .card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #divbeli {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .quantity-control {
            display: none; /* Hide quantity controls initially */
            align-items: center;
            margin-right: 10px;
        }

        .checkmark-button {
            display: none; /* Hide checkmark button initially */
            margin-right: 5px;
        }

        .quantity-control button {
            padding: 5px 10px;
            margin: 0 5px;
            cursor: pointer;
        }

        .quantity-control input {
            width: 60px;
            text-align: center;
        }

        .cart-container {
            position: fixed;
            bottom: 0;
            width: 50%;
            background-color: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            display: none;
            flex-direction: column;
            z-index: 1000;
        }

        .cart-header {
            padding: 10px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-items {
            max-height: 200px;
            overflow-y: auto;
        }

        .cart-item {
            padding: 10px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-summary {
            padding: 10px;
            background-color: #e9ecef;
            margin-bottom: 60px;
        }

        .cart-display {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid black;
            border-radius: 50px;
            padding: 10px 20px;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            z-index: 1000;
            display: none;
        }

        .lihat-item-btn {
            background-color: green;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 5px 10px;
            cursor: pointer;
            margin-left: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .payment-btn {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
            z-index: 10;
        }

        .save-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
            z-index: 10;
        }

        @media only screen and (max-width: 768px) {
            .sspemesanan .item {
                flex: 1 0 calc(50% - 20px);
                max-width: calc(50% - 20px);
            }

            .cart-display {
                width: 100%;
                left: 0;
                transform: none;
                padding: 10px;
            }

            .modal-content {
                width: 90%;
            }
        }

        @media only screen and (max-width: 480px) {
            .sspemesanan .item {
                flex: 1 0 100%;
                max-width: 100%;
            }

            .sspemesanan .item .card {
                padding: 5px;
            }

            .quantity-control input {
                width: 40px;
            }

            .cart-display span {
                font-size: 14px;
            }

            .save-btn,
            .payment-btn {
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
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
                                <li><a href="#">UI Elements</a></li>
                                <li class="active">Grids</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-12 sspemesanan">
                <?php foreach ($satu as $key) { ?>
                    <div class="item">
                        <div class="card">
                            <img class="card-img-top photobarang" src="<?=base_url('photo barang/'.$key->foto)?>" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title mb-3"><?=$key->nama_barang?></h4>
                                <p class="card-text"><?= "Rp " . number_format($key->harga_jual, 2, ',', '.') ?></p>
                                <p class="card-text stok">Stok <?=$key->stok?></p>
                                <?php if (session()->get('level') == 1) { ?>
                                <div id="divbeli">
                                    <button class="btn btn-success beli-btn" type="button" data-id="<?=$key->id_barang?>" data-nama="<?=$key->nama_barang?>" data-harga="<?=$key->harga_jual?>">Beli</button>
                                    <div class="quantity-control">
                                        <button class="decrement btn btn-success">-</button>
                                        <input type="number" class="quantity-input" value="1" min="1">
                                        <button class="increment btn btn-success">+</button>
                                        <button class="btn btn-danger cancel-btn">X</button>
                                    </div>
                                    <div class="checkmark-button">
                                        <button class="btn btn-success checkmark-btn"><i class="fa fa-check"></i></button>
                                    </div>
                                    <input type="hidden" name="id_barang" value="<?=$key->id_barang?>">
                                    <input type="hidden" id="user-id" value="<?= session()->get('id') ?>">
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="cart-display">
        <div>Total items: <span id="total-items">0</span></div>
        <div>Total price: Rp <span id="total-price">0</span></div>
        <button class="lihat-item-btn" onclick="showModal()">Lihat Item</button>
    </div>

    <!-- Modal -->
    <div id="itemModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="cart-items" id="item-list"></div>
            <div class="cart-summary">
                Total Price: Rp <span id="modal-total-price">0</span>
            </div>
            <button class="save-btn">Simpan</button>
        </div>
    </div>

    <script>

    document.addEventListener('DOMContentLoaded', () => {
        let cart = []; // Declare the cart variable

        // Handle "Beli" button click
        document.querySelectorAll('.beli-btn').forEach(button => {
            button.addEventListener('click', function() {
                const parent = this.closest('.card-body');
                const quantityControl = parent.querySelector('.quantity-control');
                const id = this.getAttribute('data-id');
                const harga = parseInt(this.getAttribute('data-harga'));
                const quantityInput = parent.querySelector('.quantity-input');
                const quantity = parseInt(quantityInput.value);
                const stokText = parent.querySelector('.stok').innerText;
                const stok = parseInt(stokText.replace('Stok ', '')); // Process the stock value

                console.log(`Stok: ${stok}, Requested Quantity: ${quantity}`); // Debugging

                // Check if quantity exceeds stock
                if (quantity > stok) {
                    alert(`Jumlah yang diminta melebihi stok yang tersedia (${stok}).`);
                    return;
                }

                // Toggle quantity controls and "Beli" button
                if (quantityControl.style.display === 'none' || quantityControl.style.display === '') {
                    quantityControl.style.display = 'flex'; // Show quantity controls
                    this.style.display = 'none'; // Hide "Beli" button
                } else {
                    quantityControl.style.display = 'none'; // Hide quantity controls
                    this.style.display = 'block'; // Show "Beli" button
                }

                // Update or add cart item with the specified quantity
                const item = cart.find(item => item.id === id);
                if (item) {
                    item.quantity = quantity; // Update quantity
                } else {
                    cart.push({
                        id,
                        nama: this.getAttribute('data-nama'),
                        harga,
                        quantity
                    });
                }
                updateCartDisplay();
            });
        });

        // Handle increment and decrement buttons
        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('increment') || event.target.classList.contains('decrement')) {
                const parent = event.target.closest('.card-body');
                const quantityInput = parent.querySelector('.quantity-input');
                const stokText = parent.querySelector('.stok').innerText;
                const stok = parseInt(stokText.replace('Stok ', '')); // Process the stock value
                let currentValue = parseInt(quantityInput.value);

                if (event.target.classList.contains('increment')) {
                    if (currentValue < stok) {
                        quantityInput.value = currentValue + 1;
                    } else {
                        alert(`Jumlah yang diminta melebihi stok yang tersedia (${stok}).`);
                    }
                } else if (event.target.classList.contains('decrement') && currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }

                const id = parent.querySelector('input[name="id_barang"]').value;
                const item = cart.find(item => item.id === id);
                if (item) {
                    item.quantity = parseInt(quantityInput.value);
                }
                updateCartDisplay();
            }
        });

        // Handle cancel button click
        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('cancel-btn')) {
                const parent = event.target.closest('.card-body');
                const id = parent.querySelector('input[name="id_barang"]').value;

                // Remove item from cart and update display
                cart = cart.filter(item => item.id !== id);
                parent.querySelector('.quantity-control').style.display = 'none';
                parent.querySelector('.beli-btn').style.display = 'block'; // Show "Beli" button again
                parent.querySelector('.quantity-input').value = 1; // Reset quantity input to 1
                updateCartDisplay();
            }
        });

        // Handle save button click
        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('save-btn')) {
                saveCart().then(() => {
                    window.location.href = '<?= base_url('home/tkeranjang') ?>';
                }).catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving the cart.');
                });
            }
        });

        // Handle bayar button click
        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('payment-btn')) {
                saveCart().then(() => {
                    window.location.href = '<?= base_url('home/bayar') ?>'; // Redirect to bayar page
                }).catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing the payment.');
                });
            }
        });

        function saveCart() {
            return new Promise((resolve, reject) => {
                const cartData = JSON.stringify({ items: cart });

                console.log('Sending data:', cartData); // Log data to be sent

                fetch('<?= base_url('home/save_cart') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: cartData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log('Cart saved successfully.');
                        resolve();
                    } else {
                        alert('Failed to save cart: ' + data.message);
                        reject();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving the cart.');
                    reject();
                });
            });
        }

        function updateCartDisplay() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const totalPrice = cart.reduce((sum, item) => sum + item.harga * item.quantity, 0);

            document.getElementById('total-items').innerText = totalItems;
            document.getElementById('total-price').innerText = totalPrice;

            document.getElementById('item-list').innerHTML = cart.map(item => `
                <li class="cart-item">
                    ${item.nama} - ${item.quantity} x Rp ${item.harga}
                    <button class="btn btn-danger remove-btn" data-id="${item.id}">Remove</button>
                </li>
            `).join('');

            document.getElementById('modal-total-price').innerText = totalPrice;

            // Show or hide the cart display based on the total number of items
            const cartDisplay = document.querySelector('.cart-display');
            if (totalItems > 0) {
                cartDisplay.style.display = 'flex';
            } else {
                cartDisplay.style.display = 'none';
            }
        }

        // Show modal
        window.showModal = function() {
            document.getElementById('itemModal').style.display = 'block';

            // Add event listener for remove button in modal
            document.querySelectorAll('.remove-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    cart = cart.filter(item => item.id !== id);
                    updateCartDisplay();
                });
            });
        };

        // Close modal
        window.closeModal = function() {
            document.getElementById('itemModal').style.display = 'none';
        };
    });



    </script>
</body>
</html>
