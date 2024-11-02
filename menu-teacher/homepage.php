<?php
include_once '../php-1/include-all-class-and-session.php';

// echo $_SESSION['s_user_id']." ". $_SESSION['s_account_type'];

// for section 1
$courseDetails = new CourseDetails();
if (isset($_POST['edit_course'])) {
    $courseDetails->course_id = $_POST[$courseDetails->variable_name[0]];
    $courseDetails->completed = 0;
    $courseDetails->checkCourse();

    unset($_POST['edit_course']);
    unset($_POST[$courseDetails->variable_name[0]]);

    if ($courseDetails->course_id == 0) {
        $_SESSION['msg01'] = "No course found using given ID to edit.";
    } elseif ($courseDetails->course_id == -2) {
        $_SESSION['msg01'] = "Connection problem. Try again.";
    } else {
        if ($courseDetails->taken_by == $_SESSION['s_user_id']) {
            $_SESSION['course_id'] = $courseDetails->course_id;
            header("Location: ../menu-common/create-course.php");
            exit();
        } else {
            $_SESSION['msg01'] = "Given course ID to edit course is not associate with you. Please fill up again to edit course.";
        }
    }
}

// for section 2
$courseDetails->taken_by = $_SESSION['s_user_id'];
$courseDetails->getOngoingCourse(); // Call the method to fetch ongoing courses


// if (isset($_POST['course_details'])) {
//     header('Location: course-details.php');
//     exit();
// } elseif (isset($_POST['take_attendance'])) {
//     header('Location: take-attendance.php');
//     exit();
// } elseif (isset($_POST['previous_courses'])) {
//     header('Location: previous-courses.php');
//     exit();
// }

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

    <title>Homepage | <?php echo $_SESSION['s_account_type']; ?></title>
</head>

<body>
    <!-- Navbar  -->
    <?php include '../php-1/navbar-1.php'; ?>

    <!-- short notice -->
    <?php include_once '../php-1/msg01.php' ?>

    <!-- section 1 previously taken courses -->
    <div class="container">
        <h1 class="heading"></h1>
        <div class="box-container">
            <!-- <div class="box" style="background: url('../img/attendance.jpg'); background-size: cover;"> -->
            <div class="box">
                <h3>Previously taken course(s)</h3>
                <form action="taken-courses.php">
                    <button class="btn-1" type="submit" name="taken_courses" value="<?php echo $courseDetails->course_id; ?>">View</button>
                </form>
            </div>
            <div class="box">
                <h3>Create a course</h3>
                <a href="../menu-common/create-course.php" class="btn-1">Create course</a>
            </div>
            <div class="box">
                <h3>Edit a course</h3>
                <form action="" method="POST">
                    <input class="input-1" type="text" name="<?php echo $courseDetails->variable_name[0]; ?>" value="" placeholder="Course ID" required> <br>
                    <button type="submit" name="edit_course" class="btn-1">Edit course</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Section 2 -->
    <div class="container">
        <h1 class="heading">Currently taking courses</h1>
        <div class="box-container">
            <?php foreach ($courseDetails->rows as $row) : ?>
                <div class="box">
                    <h3><?php echo $row[$courseDetails->variable_name[5]]; ?></h3>
                    <p><?php echo $row[$courseDetails->variable_name[4]]; ?></p>
                    <p>Session <?php echo $row[$courseDetails->variable_name[2]]; ?></p>
                    <p>Course ID <?php echo $row[$courseDetails->variable_name[0]]; ?></p>
                    <form action="course-details.php" method="POST">
                        <button type="submit" name="course_details" value="<?php echo $row[$courseDetails->variable_name[0]]; ?>" class="btn-1">Course details</button>
                    </form>
                    <form action="take-attendance.php" method="POST">
                        <button type="submit" name="take_attendance" value="<?php echo $row[$courseDetails->variable_name[0]]; ?>" class="btn-1">Take attendance</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-2.php'); ?>
</body>

</html>