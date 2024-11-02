<?php
include_once '../php-1/include-all-class-and-session.php';

$profile;

if (isset($_SESSION['s_user_id']) && isset($_SESSION['s_account_type'])) {
    if ($_SESSION['s_account_type'] == "student") {
        $profile = new Student();
        $profile->user_id = $_SESSION['s_user_id'];
        $profile->getStudent();
    } else {
        $profile = new User();
        $profile->user_id = $_SESSION['s_user_id'];
        $profile->getUser();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile | <?php echo $_SESSION['s_account_type']; ?></title>

    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="../css/custom-bg.css"> -->
</head>

<body>
    <!-- navbar     -->
    <?php include '../php-1/navbar-1.php'; ?>

    <div style="text-align: center; margin: 0% 2%; ">
        <a href="../index.php" class="btn">Homepage</a>
    </div>

    <!-- profile card -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col md-10 pt-5">
                <div class="row z-depth-3">
                    <div class="col-sm-4 rounded-left" style="background: #575757;">
                        <div class="card-block text-center text-white" style="margin-top: 20px">
                            <img src="../db-img/profile-img/<?php echo $profile->profile_image_name; ?>" class="rounded-circle m-2" alt="profile picture" width="150px" height="150px">
                            <h2 class="font-weight-bold mt-4">Hi, <?php echo $profile->full_name; ?></h2>
                            <p>Account type: <?php echo $_SESSION['s_account_type']; ?></p>
                            <?php if ($_SESSION['s_account_type'] == "student") : ?>
                                <p>Student ID: <?php echo $profile->student_id; ?></p>
                            <?php endif; ?>
                            <div style="text-align: center; margin: 1% 2%; ">
                                <a href="change-password.php" class="btn btn-primary" target="_blank">Change password</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8 bg-white rounded-right margin">
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-sm-6">
                                <p class="font-weight-bold">User ID:</p>
                                <h6 class="text-muted"><?php echo $profile->user_id; ?></h6>
                            </div>
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Full Name:</p>
                                <h6 class="text-muted"><?php echo $profile->full_name; ?></h6>
                            </div>
                        </div>
                        <hr class="bg-primary">

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Email:</p>
                                <h6 class="text-muted"><?php echo $profile->email; ?></h6>
                            </div>
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Contact:</p>
                                <h6 class="text-muted"><?php echo $profile->contact; ?></h6>
                            </div>
                        </div>
                        <hr class="bg-primary">

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Department:</p>
                                <h6 class="text-muted"><?php echo $profile->department; ?></h6>
                            </div>
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Blood group:</p>
                                <h6 class="text-muted"><?php echo $profile->blood_group; ?></h6>
                            </div>
                        </div>
                        <hr class="bg-primary">

                        <?php if ($_SESSION['s_account_type'] == "student") : ?>

                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="font-weight-bold">Session:</p>
                                    <h6 class="text-muted"><?php echo $profile->session; ?></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="font-weight-bold">Registration number:</p>
                                    <h6 class="text-muted"><?php echo $profile->registration_number; ?></h6>
                                </div>
                            </div>
                            <hr class="bg-primary">
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Gender: </p>
                                <h6 class="text-muted"><?php echo $profile->gender; ?></h6>
                            </div>
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Address:</p>
                                <h6 class="text-muted"><?php echo $profile->address; ?></h6>
                            </div>
                        </div>
                        <hr class="bg-primary">
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Account created on (Y/M/D): </p>
                                <h6 class="text-muted"><?php echo $profile->creation_date; ?></h6>
                            </div>
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Account last modified:</p>
                                <h6 class="text-muted"><?php echo $profile->last_modified; ?></h6>
                            </div>
                        </div>
                        <hr class="bg-secondary">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-1.php'); ?>

</body>

</html>