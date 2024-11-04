<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>CodeIgniter 4 Login Page</title>
    <style>
        body {
        background-size: cover;
        background-position: center;
        }
        body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://images.pexels.com/photos/733852/pexels-photo-733852.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
        background-size: cover;
        background-position: center;
        filter: blur(5px);
        z-index: -1;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.9); 
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card p-4">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Login</h2>
                    </div>
                    <!-- Display the alert message -->
                    <?php if(session()->getFlashdata('alert')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('alert') ?>
                        </div>
                    <?php endif; ?>
                    <!-- Display the error message -->
                    <?php if(session()->getFlashdata('msg')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('msg') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    <form action="<?php echo base_url(); ?>/SigninController/loginAuth" method="post">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" placeholder="Password" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>

                        <!-- remember me -->
                        <div class="form-check mt-3">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>

                        <div class="text-end fs-6">
                            <small>Forgot Password? <a class="fst-italic text-decoration-none" href="<?= base_url() ?>/ForgotPasswordController">Reset Password</a></small>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <small>Don't have an account? <a href="<?= base_url() ?>signup">Sign up</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
