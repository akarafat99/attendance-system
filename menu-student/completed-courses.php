<?php

include_once '../php-1/include-all-class-and-session.php';

$student = new Student();
$courseEnroll = new CourseEnroll();
$courseDetails = new CourseDetails();

$student->user_id = $_SESSION['s_user_id'];
$student->setStudent();
// echo $student->student_id;
$courseEnroll->student_id = $student->student_id;
$courseEnroll->getCourseIdList();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

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

    <div style="text-align: center; margin: 0% 2%; ">
        <a href="homepage.php" class="btn-1">Homepage</a>
    </div>

    <!-- Section 2 to view completed course list and details -->
    <div class="container">
        <h1 class="heading">Completed courses</h1>
        <div class="box-container">
            <?php foreach ($courseEnroll->courseIdList as $c_id) : ?>
                <?php
                $courseDetails->course_id = $c_id;
                $courseDetails->getCourse();
                // echo $courseDetails->course_code . "<br>";
                if ($courseDetails->completed != 0) {
                ?>
                    <div class="box">
                        <h3><?php echo  $courseDetails->course_title; ?></h3>
                        <p>Course code: <?php echo $courseDetails->course_code; ?></p>
                        <p>Session <?php echo $courseDetails->session; ?></p>
                        <p>Course ID <?php echo $courseDetails->course_id; ?></p>
                        <form action="student-course-details.php" method="POST">
                            <button type="submit" name="student_course_details" value="<?php echo $courseDetails->course_id; ?>" class="btn-1">Course details</button>
                        </form>
                    </div>
                <?php } ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-2.php'); ?>

</body>

</html>