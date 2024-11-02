<?php
if (session_status() == PHP_SESSION_NONE) {
    // Only start the session if it's not already started
    session_start();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Navbar</title>

</head>

<body>
    <header class="header">
        <a href="../index.php" class="logo"><abbr title="Student Information & Attendance System">SIAS</abbr> </a>
        <nav class="navbar">
            <form action="" method="POST">
                <a href="../menu-common/profile-1.php"><i class="fa-solid fa-user"></i> Profile</a>
                <button type="submit" name="logout"><i class="fa-solid fa-arrow-right-from-bracket" style="color: #000000;"></i> logout</button>
            </form>
        </nav>
    </header>
</body>

</html>