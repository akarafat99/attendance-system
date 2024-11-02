<?php
// session
if (session_status() == PHP_SESSION_NONE) {
    // Only start the session if it's not already started
    session_start();
}

if (isset($_GET['forgot_password']) && $_GET['forgot_password'] == 'true') {
    $_SESSION['msg01'] = "Please contact to the authority or email us to reset your password to default password. <b>After reset password to default by admin, change your password to your desired one from profile.</b> Thank you.<br><br>-SIAS Team";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/create-form.css">

    <style>
        .custom-bg-1 {
            background-image: url('../img/image_2.jpg');
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

    <?php include_once '../php-1/msg01.php'; ?>

    <div style="min-height: 75vh;">
        <div class="container" style="background-color:#f8f7f7f7; margin-top: 3%; border-radius: 5px;">
            <h3 style="text-align: center; margin:10px;">Contact Us</h3>
            <div style="padding: 10px 0; background-color: #333; text-align: center;">
                <p style="color: #fff; font-size: 18px;">Email: <a href="mailto:190122.cse@student.just.edu.bd" style="color: white;">190122.cse@student.just.edu.bd</a></p>
                <p style="color: #fff; font-size: 18px;">Phone: (Not available)</p>
                <p style="color: #fff; font-size: 18px;">Address: Jashore University of Science and Technology (JUST), Jashore – 7408</p>
                <p style="color: #fff; font-size: 18px;">Website: <a href="https://just.edu.bd" style="color: white;" target="_blank">https://just.edu.bd</a></p>
                
                <!-- <div style="margin-top: 20px;">
                    <a href="#" style="color: #fff; margin-right: 10px;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" style="color: #fff; margin-right: 10px;"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color: #fff; margin-right: 10px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: #fff; margin-right: 10px;"><i class="fab fa-linkedin-in"></i></a>
                </div> -->
            </div>
        </div>


    </div>




    <!-- Footer -->
    <?php include_once('../php-1/footer-2.php'); ?>
</body>

</html>