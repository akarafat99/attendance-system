<?php
include_once '../php-1/include-all-class-and-session.php';
// $all = new IncludeAllClass();

$user = new User();
$student = new Student();
$courseDetails = new CourseDetails();

if (isset($_POST['edit_user'])) {
    $user->user_id =  $_POST[$user->variable_name[0]];
    unset($_POST['edit_user']);
    unset($_POST[$user->variable_name[0]]);
    
    $user->getAccountType();

    $_SESSION['user_id'] = $user->user_id;
    if ($user->account_type == "0") {
        $_SESSION['msg01'] = "No user found";
    } elseif($user->account_type == "-2") {
        $_SESSION['msg01'] = "connection error. Try again.";
    } elseif ($user->account_type == "student") {
        header("Location: ../menu-common/create-student.php");
        exit();
    } else {
        header("Location: ../menu-common/create-teacher-admin.php");
        exit();
    }
}

if (isset($_POST['edit_course'])) {
    $courseDetails->course_id = $_POST[$courseDetails->variable_name[0]];
    unset($_POST['edit_course']);
    $courseDetails->completed = -3; // 2 or -2 is used for connection error code.
    $courseDetails->checkCourse();

    if ($courseDetails->course_id == 0) {
        $_SESSION['msg01'] = "No course found. Course ID {$_POST[$courseDetails->variable_name[0]]}";
    } else {
        $_SESSION['course_id'] = $courseDetails->course_id;
        header("Location: ../menu-common/create-course.php");
        exit();
    }
}

if (isset($_POST['deactivate_user'])) {
    $user->user_id =  $_POST[$user->variable_name[0]];
    $changeTo = $_POST['deactivate_user'];
    
    unset($_POST['deactivate_user']);
    unset($_POST[$user->variable_name[0]]);
    
    $user->checkUserById();
    
    if($user->user_id == 0) {
        $_SESSION['msg01'] = "No user found using this user ID. Try again.";
    } elseif($user->checkUserById() == -2) {
        $_SESSION['msg01'] = "Connection error. Try again.";
    } else {
        $user->setDeactivated($changeTo);
        if($changeTo == 1) {
            $_SESSION['msg01'] = "Account deactivated. User ID ". $user->user_id;
        } else {
            $_SESSION['msg01'] = "Account activated. User ID ". $user->user_id;
        }
    }
}

if(isset($_POST['reset_password'])) {
    $user->setUserIdByIdOrEmail($_POST['idOrEmail']);
    if($user->user_id == 0) {
        $_SESSION['msg01'] = "No user found to reset password using {$_POST['idOrEmail']}";
    } elseif($user->user_id == -2) {
        $_SESSION['msg01'] = "Connection error. Please try again.";
    } else {
        $user->resetPassword("just123");
        if($user->result) {
            $_SESSION['msg01'] = "Password reset completed. User ID {$user->user_id}. Default password is <b><i>just123<i><b>";
        } else {
            $_SESSION['msg01'] = "Password reset failed. Please try again.";
        }
    }
}

if (isset($_POST['retrieve_course'])) {
    $courseDetails->course_id = $_POST[$courseDetails->variable_name[0]];
    $courseDetails->completed = -1;
    $courseDetails->checkCourse();

    if ($courseDetails->course_id == 0) {
        $_SESSION['msg01'] = "No course found using course ID {$_POST[$courseDetails->variable_name[0]]} which was deleted.";
    } else {
        $courseDetails->setCompleted(1);
        $_SESSION['msg01'] = "Course retrieved and set as completed. Course ID {$courseDetails->course_id}";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- For card(s) of section 1 -->
    <link rel="stylesheet" href="../css/card-1.css">
    <link rel="stylesheet" href="../css/view-details-1.css">
    <link rel="stylesheet" href="../css/view-details-2.css">

    <title>Homepage |  | <?php echo $_SESSION['s_account_type']; ?></title>
</head>

<body>
    <!-- Navbar  -->
    <?php include '../php-1/navbar-1.php'; ?>

    <!-- short notice -->
    <?php include_once '../php-1/msg01.php' ?>

    <!-- Section 1 -->
    <div class="container">
        <!-- <h1 class="heading"></h1> -->
        <div class="box-container">
            <div class="box">
                <h3>Create profile</h3>
                <a href="../menu-common/create-student.php" class="btn-1">Student profile form</a>
                <a href="../menu-common/create-teacher-admin.php" class="btn-1">Teacher / admin profile form</a>
                <!-- <a href="../menu-common/edit-profile-1.php" class="btn-1">Office staff profile form</a> -->
                <!-- <p>or,</p>
                <a href="../menu-common/form-2.php" class="btn-1">Upload excel file</a> -->
            </div>
            <div class="box">
                <h3>Edit user</h3>
                <form action="" method="POST">
                    <input class="input-1" type="text" name="<?php echo $user->variable_name[0]; ?>" value="" placeholder="user ID" required> <br>
                    <button type="submit" name="edit_user" class="btn-1">Goto form</button>
                </form>
            </div>
            <div class="box">
                <h3>Activate / deactivate user</h3>
                <form action="" method="POST">
                    <input class="input-1" type="text" name="<?php echo $user->variable_name[0]; ?>" value="" placeholder="user ID" required> <br>
                    <button type="submit" name="deactivate_user" value="0" class="btn-1">Activate</button>
                    <button type="submit" name="deactivate_user" value="1" class="btn-1">Deactivate</button>
                </form>
            </div>
            <div class="box">
                <h3>Reset user password</h3>
                <form action="" method="POST">
                    <input class="input-1" type="text" name="idOrEmail" value="" placeholder="Enter user ID or email" required> <br>
                    <button type="submit" name="reset_password" class="btn-1">Confirm reset</button>
                </form>
            </div>
        </div>
    </div>

    <!-- section 2 -->
    <div class="container">
        <!-- <h1 class="heading"></h1> -->
        <div class="box-container">
            <div class="box">
                <h3>Review pending user registration</h3>
                <a href="pending-signup.php" class="btn-1" target="_blank"><abbr title="Will open in new tab">Go</abbr></a>
            </div>
            <div class="box">
                <h3>Create a course</h3>
                <a href="../menu-common/create-course.php" class="btn-1">Goto form</a>
            </div>
            <div class="box">
                <h3>Edit a course</h3>
                <form action="" method="POST">
                    <input class="input-1" type="text" name="<?php echo $courseDetails->variable_name[0]; ?>" value="" placeholder="Course ID" required> <br>
                    <button type="submit" name="edit_course" class="btn-1">Edit course</button>
                </form>
            </div>
            <div class="box">
                <h3>Retrieve a deleted course</h3>
                <form action="" method="POST">
                    <input class="input-1" type="number" name="<?php echo $courseDetails->variable_name[0]; ?>" value="" placeholder="Course ID" required> <br>
                    <button type="submit" name="retrieve_course" value="-1" class="btn-1">Proceed</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-2.php'); ?>
</body>

</html>