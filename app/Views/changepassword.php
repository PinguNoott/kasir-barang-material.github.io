<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.5em;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-group label {
            font-weight: 600;
        }

        .input-group {
            position: relative;
        }

        .input-group .btn {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 0 5px 5px 0;
        }

        .form-control {
            border-radius: 5px;
            padding-right: 40px; /* Make space for the button */
        }

        .btn-login {
            background-color: #007bff;
            color: #fff;
            font-size: 1em;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ganti Password</h5>
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session('success') ?>
                    </div>
                <?php endif; ?>

                <form novalidate method="post" action="<?= base_url('home/aksi_changepass') ?>" class="row g-3">
                    <div class="mb-3">
                        <label for="inputName5" class="form-label">Old Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="inputName5" name="old">
                            <button class="btn btn-outline-secondary" type="button" id="showOldPassword">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="inputEmail5" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="inputEmail5" name="new">
                            <button class="btn btn-outline-secondary" type="button" id="showNewPassword">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-login">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('showOldPassword').addEventListener('click', togglePasswordVisibility('inputName5'));
        document.getElementById('showNewPassword').addEventListener('click', togglePasswordVisibility('inputEmail5'));

        function togglePasswordVisibility(inputId) {
            return function () {
                var passwordInput = document.getElementById(inputId);
                var icon = document.querySelector(#${inputId} ~ .btn .fa-eye-slash, #${inputId} ~ .btn .fa-eye);
                
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    passwordInput.type = "password";
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            };
        }
    </script>
</body>
</html>