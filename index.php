<?php

if (session_status() == PHP_SESSION_NONE) {
    // Only start the session if it's not already started
    session_start();
}

include_once 'php-class/login.php';

if (isset($_POST['student'])) {
    $_SESSION['signup'] = 'student';
    header("Location: menu-signup/create-student.php");
    exit();
}
if (isset($_POST['notstudent'])) {
    $_SESSION['signup'] = 'notstudent';
    header("Location: menu-signup/create-teacher-admin.php");
    exit();
}

$login = new Login();

if (isset($_SESSION['s_user_id']) && $_SESSION['s_user_id'] > 0) {
    $login->user->user_id = $_SESSION['s_user_id'];
    $login->user->getAccountType();
    $_SESSION['s_account_type'] = $login->user->account_type;
    if ($login->user->account_type == "student") {
        header("Location: menu-student/homepage.php");
        exit();
    } elseif ($login->user->account_type == "teacher") {
        header("Location: menu-teacher/homepage.php");
        exit();
    } else {
        header("Location: menu-admin/homepage.php");
        exit();
    }
}

if (isset($_POST['login'])) {
    // echo $login->checkCredential($_POST['id'], $_POST['password']);
    unset($_POST['login']);
    if ($login->checkCredential($_POST['id'], $_POST['password']) > 0) {
        if ($login->user->deactivated == 0) {
            $_SESSION['s_user_id'] = $login->user->user_id;
            $_SESSION['s_account_type'] = $login->user->account_type;

            if ($login->user->account_type == "student") {
                header("Location: menu-student/homepage.php");
                exit();
            } elseif ($login->user->account_type == "teacher") {
                header("Location: menu-teacher/homepage.php");
                exit();
            } else {
                header("Location: menu-admin/homepage.php");
                exit();
            }
        } elseif ($login->user->deactivated == 1) {
            $_SESSION['msg01'] = "User account is disabled. Please contact to authority to solve this issue.";
        } elseif ($login->user->deactivated == -1) {
            $_SESSION['msg01'] = "User account is not approved yet. Please contact to authority to solve this issue or wait for some time for account approval.";
        } else {
            $_SESSION['msg01'] = "User account user has been declined. Please contact to authority to solve this issue.";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/create-form.css">

    <style>
        .custom-bg-1 {
            background-image: url('img/image_1.jpg');
            /* Replace 'your-image-url.jpg' with the path to your image file */
            background-repeat: no-repeat;
            background-size: cover;
            /* This property ensures that the background image covers the entire body */
            background-position: center;
            /* This property centers the background image */
        }
    </style>
</head>

<body class="body1 custom-bg-1">

    <div style="background:#fffffff6; margin: 0;">
        <h1 style="text-align: center; padding:10px;">Student information and attendance system (SIAS)</h1>
    </div>

    <?php include_once 'php-1/msg01.php'; ?>

    <div class="container" style="background-color:#f8f7f7f7; margin-top: 3%; border-radius: 5px;">
        <h3 style="text-align: center; margin:10px;">Log in</h3>
        <form action="index.php" method="post">
            <div class="form-group">
                <div>User ID:</div>
                <input type="number" placeholder="Enter Your User ID" name="id" class="form-control" required>
            </div>
            <div class="form-group">
                <div>Password:</div>
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="from-btn1">
                <button type="submit" value="" name="login" class="btn btn-primary">Login </button>
            </div>
        </form>
        <a href="menu-common/contact-us.php?forgot_password=true" target="_blank">Forgot password?</a>

        <hr>
        <form action="" method="post" style="text-align: left;">
            <p style="margin: 10px 0px;">Don't have an account?</p>
            <div class="from-btn1">
                <button type="submit" value="" name="student" class="btn btn-secondary">
                    <i class="fa-solid fa-graduation-cap"></i> Signup for student account
                </button>
                <span style="margin: 5px 0px;"> </span>
                <button type="submit" value="" name="notstudent" class="btn btn-secondary" style="margin: 5px 0px;">
                    <i class="fa-solid fa-user-tie"></i> Signup for teacher/admin account
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <?php include_once('php-1/footer-1.php'); ?>
</body>

</html>