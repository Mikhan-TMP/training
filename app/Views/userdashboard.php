<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/d3f0917775.js" crossorigin="anonymous"></script>
    <title>Dashboard</title>
    <style>
        body {
            
            background-size: cover;
        }
        .tab-pane p{
            margin-bottom: 0px;
            font-size: 16px;
            font-weight: bold;
        }
        .tab-pane label{
            font-size: 16px;
            color: #555;
            border: 1px solid #ccc;
            border-radius: 15px;
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 2rem;
        }
        .modal-header {
            border-bottom: none;
        }
        .footer {
            padding: 1.5rem 0;
        }
    </style>
</head>
<body>
<!-- Main Content -->
<main class="container mt-4">
    <div class="d-flex justify-content-end mb-3">
        <a href="<?= site_url('/'); ?>" class="btn btn-primary me-2">
            <i class="fa-solid fa-house"></i> Home
        </a>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
    </div>


    <!-- Profile Page -->
    <div class="row">
        <div class="col-md-4 mt-4 ">
            <div class="card text-center">
                <div class="card-body">
                    <?php 
                        if (session()->get('image') == null) {
                            echo '<img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="rounded-circle mb-3" width="150">';
                        } 
                        else {
                            echo '<img src="data:image/jpeg;base64,' . session()->get('image') . '" class="rounded-circle mb-3" width="150" alt="Profile Image">';
                        }

                    ?>
                    <h5>
                        <?php 
                            echo session()->get('name');
                            echo '<br>';
                            if(session()->get('isVerified') == 1){
                                echo '<span class="badge bg-success text-white">Verified</span>';
                            }  
                            else{
                                echo '<span class="badge bg-warning text-white">Not Verified</span>';
                            }
                        ?>
                    </h5>
                    <p> 
                        <?php
                        if(session()->get('email') == null || session()->get('email') == ""){
                            echo 'No Username';
                        } else{
                            echo session()->get('username'); 
                        }
                        ?>
                    </p>
                    <p class="text-muted">
                        <?php
                        if(session()->get('role') == null ){
                            echo "Role Not Set";
                        }else{
                            echo session()->get('role'); 
                        }
                        ?>
                    </p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Profile
                    </button>
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mt-2">
                            <i class="fa-solid fa-check-circle"></i>
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mt-2">
                            <i class="fa-solid fa-times-circle"></i>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Personal</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Account </button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">History</button>
                    </div>
                </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <h5 class="mb-2 fs-2 mt-4">Personal Information</h5>
                                <small class="mb-4">This section contains your personal details, such as your full name, date of birth, and contact information. Keeping this information up-to-date helps us personalize your experience and ensure smooth communication.</small>
                                <p>First Name: </p>
                                    <label>
                                    <?php echo session()->get('firstname'); ?> 
                                    </label>
                                <p>Last Name: </p>
                                    <label>
                                        <?php echo session()->get('lastname'); ?>
                                    </label>
                                <p>Email: </p>
                                    <label>
                                        <?php echo session()->get('email'); ?>
                                    </label>    
                                <p>Phone: </p>
                                    <label>
                                        <?php
                                            if(session()->get('phone') == null || session()->get('phone') == 0){
                                                echo "N/A";
                                            }else{
                                                echo '0'. session()->get('phone');
                                            }
                                        ?>
                                    </label>
                                <p>Date of Birth: </p>    
                                    <label>
                                    <?php 
                                        $birthdate = session()->get('birthdate');
                                        echo ($birthdate == '0000-00-00' || $birthdate == null) ? 'N/A' : $birthdate; 
                                    ?>
                                    </label>
                                <p>Gender: </p>
                                    <label>
                                        <?php echo session()->get('gender') ?: "N/A"; ?>
                                    </label>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <h5 class="mb-2 fs-2 mt-4">Account Information</h5>
                                <small class="mb-5">Here, you can view and manage your account settings, including your username, email address, and password. These settings are essential for account security and access to your personalized features.</small>
                                <p>ID: </p>
                                    <label>
                                        <?php echo session()->get('id'); ?>
                                    </label>
                                <p>Username: </p>
                                <label>
                                    <?php echo session()->get('username') ?: "N/A"; ?>
                                </label>
                                <p>Password:</p>
                                <label>
                                    <?php echo str_repeat('*', 8); ?>
                                </label>
                                <button type="button" class="float-end btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="fa-solid fa-key"></i> Change Password</button>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <h5 class="mb-2 fs-2 mt-4">History</h5>
                            <small>
                                This section displays the user's activity log, showing their actions over time. You can view a timeline of changes made, including edits, deletions, and additions to various menu items, categories, or courses. This history helps in tracking the user's interactions and maintaining a record of important updates.
                            </small>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Login Time</th>
                                        <th scope="col">Logout Time</th>
                                        <th scope="col">IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if (empty($histories)) {
                                        // If $histories is empty, display a message
                                        echo "<tr><td colspan='4' class='text-center'>No history found</td></tr>";
                                    } else {
                                        $rowCount = 1;
                                        foreach ($histories as $history) {
                                            // Convert login and logout times to a human-readable format
                                            $loginTime = new DateTime($history['loginTime']);
                                            $logoutTime = new DateTime($history['logoutTime']);
                                            
                                            // Format login and logout times to a specific format (e.g., October 30, 2024, 3:30 pm)
                                            $formattedLoginTime = $loginTime->format('F j, Y, g:i a'); // e.g., October 30, 2024, 3:30 pm
                                            $formattedLogoutTime = $logoutTime->format('F j, Y, g:i a'); // e.g., October 30, 2024, 4:00 pm
                                            $ipAddress = $history['ipAddress'];

                                            echo "<tr><td>$rowCount</td><td>$formattedLoginTime</td><td>$formattedLogoutTime</td><td>$ipAddress</td></tr>";
                                            $rowCount++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <!-- <a href="<?= site_url('/editprofile'); ?>" class="btn btn-primary">Edit Profile</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Profile Page -->

    <!-- Modal for Edit Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= site_url('/userdashboard/editprofile') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- For displaying Profile Image from the session image -->
                        <div class="mb-3 text-center">
                                <?php 
                                    if (session()->get('image') != null) {
                                        echo '<img src="data:image/jpeg;base64,' . session()->get('image') . '" class="rounded-circle mb-3" width="150">';
                                    }
                                    else {
                                        echo '<img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="rounded-circle mb-3" width="150">';
                                    }
                                ?>
                            <!-- <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload</button> -->
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="image"> Profile Image </label>
                            <input type="file" class="form-control" id="image" name="image" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        </div>

                        <div class="mb-3"> 
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= session()->get('username') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?= session()->get('firstname') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?= session()->get('lastname') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= session()->get('email') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= session()->get('phone') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" value="<?= session()->get('birthdate')?>">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?= session()->get('gender') =='Male'?'selected' : ''?>>Male</option>
                                <option value="Female" <?= session()->get('gender') == 'Female'?'selected' : ''?>>Female</option>
                                <option value="Other" <?= session()->get('gender') == 'Other'?'selected' : ''?>>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <!-- Modal for Change Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= site_url('/userdashboard/changepassword') ?>" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" name="currentPassword" id="currentPassword" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" name="newPassword" id="newPassword" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal for Logout -->
    <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutConfirmModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="<?= site_url('/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class=" mt-3 footer d-flex flex-wrap justify-content-between align-items-center border-top">
        <div class="col-md-4 d-flex align-items-center">
            <span class="text-muted">© 2024 Sauvage</span>
        </div>
    </footer>
</main>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSd4WybmoE5RzHh8B+5nO0Ch1NkX2yRYPTf0M68P9h1pVtR8" crossorigin="anonymous"></script>
</body>
</html>
