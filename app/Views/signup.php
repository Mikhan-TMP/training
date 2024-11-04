<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>CodeIgniter 4 Register Page</title>
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
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff; 
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }
        .input-group-text {
            color: black; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card p-4">
                    <div class="text-center mb-4">
                        <h1 class="fw-bold">Sign Up</h1>
                    </div>
                    <?php if(isset($validation)): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?= $validation->listErrors() ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    <form action="<?php echo base_url(); ?>/SignupController/store" method="post">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                <input type="text" name="first_name" placeholder="First Name" value="<?= set_value('first_name') ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                <input type="text" name="last_name" placeholder="Last Name" value="<?= set_value('last_name') ?>" class="form-control" required>
                            </div>
                        </div>
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
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit</button> <!-- Changed to blue -->
                        </div>
                    </form>
                    <!-- already have an account -->
                    <div class="text-end mt-3">
                        <small>Already have an account? <a class="fs " href="<?php echo base_url(); ?>signin">Sign in</a></small>
                    </div>
                    <!-- or login using -->
                    <div class="text-center mt-3">
                        <small>or login using</small>
                        <br>
                        <a href="#" class="btn btn-success"><i class="fab fa-google"></i> Google</a>
                        <a href="#" class="btn btn-primary"><i class="fab fa-facebook"></i> Facebook</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
