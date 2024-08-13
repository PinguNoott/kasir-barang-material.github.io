<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%; /* Membuat gambar menjadi bulat */
            object-fit: cover;
            border: 3px solid #ddd;
            margin-right: 20px;
        }

        .profile-header h1 {
            font-size: 1.5em;
            margin: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-group input[type="file"] {
            display: block;
            margin-top: 5px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            color: #fff;
            background-color: #007bff;
            border: none;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src="<?= base_url('images/'.$dua->foto) ?>" alt="Profile Picture">
            <h1>Profile</h1>
        </div>
        
        <form action="<?= base_url('home/aksi_eprofile') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= $dua->username ?>" required>
            </div>

            <div class="form-group">
                <label for="no_telp">No. Telp</label>
                <input type="text" id="no_telp" name="no_telp" value="<?= $dua->no_telp ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= $dua->email ?>" required>
            </div>

            <div class="form-group">
                <label for="foto">Ganti Foto</label>
                <input type="file" id="foto" name="foto">
            </div>
            <input type="hidden" value="<?=$dua->id_user?>" name="id">
            <input type="hidden" value="<?=$dua->level?>" name="level">
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</body>
</html>