<!-- HTML and PHP for the form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        .login {
            display: flex;
            justify-content: center;
            font-weight: bold;
            color: #4a934a;
        }
    </style>
</head>
<body class="bg-dark">
<div class="container mt-3">
    <?php if (session()->getFlashdata('toast_message')): ?>
        <div class="alert alert-<?= session()->getFlashdata('toast_type') == 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('toast_message') ?>
          
        </div>
    <?php endif; ?>
</div>
<div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
        <div class="login-content">
            <div class="login-logo">
                <a href="index.html">
                    <img class="align-content" src="<?=base_url('images/'.$setting->login_icon)?>" alt="" width="127px" height="130px">
                </a>
            </div>
            <div class="login-form">
                <form action="<?=base_url('home/aksi_login')?>" method="POST">
                    <h2 class="login">LOGIN</h2>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="Username" name="username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <!-- Google reCAPTCHA -->
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LeKfiAqAAAAAIYfzHJCoT6fOpGTpktdJza3fixn"></div>
                    </div>
                    <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                    <div class="register-link m-t-15 text-center">
                        <p>Don't have account ? <a href="<?=base_url('home/signup')?>"> Sign Up Here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="<?=base_url('assets/js/main.js')?>"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>