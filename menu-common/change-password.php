<?php

include_once '../php-1/include-all-class-and-session.php';


$acc = null;
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $retype_new_password = $_POST['retype_new_password'];

    // echo $current_password . "<br>". $new_password . "<br>". $retype_new_password . "<br>";
    // echo $_SESSION['s_account_type'];

    if ($_SESSION['s_account_type'] == "student") {
        $acc = new Student();
    } else {
        $acc = new User();
    }
    $acc->user_id = $_SESSION['s_user_id'];
    $acc->getPassword();

    $passwordMatches = password_verify($current_password, $acc->password);
    if ($passwordMatches) {
        // echo "Matched <br>";
        if ($new_password == $retype_new_password) {
            // echo "new password set  <br>";
            $acc->setPassword($new_password);
            session_destroy();
            session_start();
            $_SESSION['msg01'] = "Password changed successfully. Please login again.";
            header("Location: ../index.php");
            exit();
        } else {
            // echo "New password and retyped new passowrd not matched <br>";
            $_SESSION['msg01'] = "New password and retyped new passowrd did not match. Please try again.";
        }
    } else {
        // echo "Not matched <br>";
        $_SESSION['msg01'] = "Your current password is incorrect. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>

    <!-- for form -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/create-form.css">

    <script>
        function validatePassword() {
            var ok = 0;
            var password1 = document.getElementById("new-password").value;
            var password2 = document.getElementById("retype-new-password").value;

            // Check if the password meets the specified criteria
            var hasUpperCase1 = /[A-Z]/.test(password1);
            var hasSpecialChar1 = /[!@#$%^&*(),.?":{}|<>]/.test(password1);
            var hasNumber1 = /\d/.test(password1);

            // var hasUpperCase2 = /[A-Z]/.test(password2);
            // var hasSpecialChar2 = /[!@#$%^&*(),.?":{}|<>]/.test(password2);
            // var hasNumber2 = /\d/.test(password2);

            if (password1.length < 8 || !hasUpperCase1 || !hasSpecialChar1 || !hasNumber1) {
                alert("In new password input, password must be at least 8 characters long and include at least one uppercase letter, one special character, and one number.");
                ok = 1;
                return false;
            }
            // if (password2.length < 8 || !hasUpperCase2 || !hasSpecialChar2 || !hasNumber2) {
            //     alert("Retyped new password must be at least 8 characters long and include at least one uppercase letter, one special character, and one number.");
            //     ok = 0;
            // } 

            if (password1 != password2) {
                alert("New password and retyped new password not matched.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body class="custom-bg-1">
    <!-- navbar -->
    <?php include '../php-1/navbar-1.php'; ?>

    <?php include_once '../php-1/msg01.php'; ?>

    <div style="text-align: center; margin: 2% 2%; ">
        <!-- <a href="../index.php" class="form-btn0">Homepage</a> -->
        <a href="../index.php" class="btn btn-secondary"> Homepage </a>
    </div>

    <!-- form -->
    <div class="container" style="background-color:#dfe2e8;">
        <form action="" method="POST" onsubmit="return validatePassword()">
            <div class="form-group">
                <div>Current password</div>
                <input type="password" placeholder="Enter current password" name="current_password" class="form-control" value="" required>
            </div>
            <div class="form-group">
                <div>New password</div>
                <input type="password" id="new-password" placeholder="Enter new password" name="new_password" class="form-control" value="" required>
                <small class="text-muted">Password must be at least 8 characters long and include at least one uppercase letter, one special character, and one number.</small>
            </div>
            <div class="form-group">
                <div>Retype new password</div>
                <input type="password" id="retype-new-password" placeholder="Retype new password" name="retype_new_password" class="form-control" value="" required>
            </div>

            <div class="form-btn1">
                <button type="submit" name="change_password" value="" class="btn btn-primary"> Submit </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-1.php'); ?>
</body>

</html>