<?php
// Specify the directory where your PHP files are located
$directory = __DIR__;

// Get all PHP files in the directory
$phpFiles = glob($directory . '/../php-class/*.php');

// Include each PHP file
foreach ($phpFiles as $file) {
    include_once $file;
}

// session
if (session_status() == PHP_SESSION_NONE) {
    // Only start the session if it's not already started
    session_start();

    // this is for check if there is any session available or not if not available then goto login page
    if (!isset($_SESSION['s_user_id'])) {
        header("Location: ../index.php");
        exit();
    }
}




// class IncludeAllClass
// {
//     public function __construct()
//     {
//         $directory = __DIR__;

//         // Get all PHP files in the directory
//         $phpFiles = glob($directory . '/../php-class/*.php');

//         // Include each PHP file
//         foreach ($phpFiles as $file) {
//             include_once $file;
//         }
//     }
// }

?>
<!--  -->