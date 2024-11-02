<?php

include_once '../php-1/include-all-class-and-session.php';

$student = new Student();
$courseEnroll = new CourseEnroll();
$courseDetails = new CourseDetails();

$student->user_id = $_SESSION['s_user_id'];
$student->setStudent();
$courseEnroll->student_id = $student->student_id;
$courseEnroll->getCourseIdList();

if (isset($_POST['course_enroll'])) {
    $courseEnroll->course_id = $_POST[$courseDetails->variable_name[0]];
    if ($courseEnroll->isEnrolled() == 1) {
        $_SESSION['msg01'] = "Already enrolled to this course (Course ID {$courseEnroll->course_id})";
    } else {
        $courseDetails->course_id = $courseEnroll->course_id;
        $courseDetails->getCourse();
        if ($courseDetails->join_by_id == 1 && $courseDetails->completed == 0) {
            $courseEnroll->enrollStudent($courseEnroll->student_id, $courseEnroll->course_id);
            $_SESSION['msg01'] = "Join to the course (Course ID {$courseEnroll->course_id}) successful.";

            $attendance = new Attendance();
            $attendance->student_id = $courseEnroll->student_id;
            $attendance->course_id = $courseEnroll->course_id;
            $attendance->setSomeAttendanceOfAStudent();
        } else {
            if ($courseDetails->join_by_id == 0) {
                $_SESSION['msg01'] = "Join by course ID (Course ID {$courseEnroll->course_id}) is currently disable. Please contact course teacher or department.";
            }
            if ($courseDetails->completed == 1) {
                $_SESSION['msg01'] = "You can not join a course (Course ID {$courseEnroll->course_id}) which has been completed.";
            } elseif ($courseDetails->completed == -1) {
                $_SESSION['msg01'] = "You can not join a course (Course ID {$courseEnroll->course_id}) which has been deleted temporarily.";
            }
        }
    }
    header("Location: ../index.php");
    exit();
}

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

    <!-- section 1  Management -->
    <div class="container">
        <h1 class="heading"></h1>
        <div class="box-container">
            <div class="box">
                <h3>Enroll in course</h3>
                <form action="" method="POST">
                    <input class="input-1" type="number" name="<?php echo $courseDetails->variable_name[0];  ?>" value="" placeholder="Course ID" required> <br>
                    <button type="submit" name="course_enroll" class="btn-1">Submit to complete enrollment</button>
                </form>
            </div>
            <div class="box">
                <h3>Completed course(s)</h3>
                <a href="completed-courses.php" class="btn-1">View</a>
            </div>
        </div>
    </div>

    <!-- Section 2 to view ongoing course list and details -->
    <div class="container">
        <h1 class="heading">Ongoing courses</h1>
        <div class="box-container">
            <?php foreach ($courseEnroll->courseIdList as $c_id) : ?>
                <?php
                $courseDetails->course_id = $c_id;
                $courseDetails->getCourse();
                if ($courseDetails->completed == 0) {
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