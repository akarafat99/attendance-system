<?php

include_once '../php-1/include-all-class-and-session.php';

$courseDetails = new CourseDetails();
$attendance = new Attendance();
$courseEnroll = new CourseEnroll();

if (isset($_POST['complete'])) {
    $courseDetails->course_id = $_POST['complete'];
    $courseDetails->setCompleted(1);
}
if (isset($_POST['incomplete'])) {
    $courseDetails->course_id = $_POST['incomplete'];
    $courseDetails->setCompleted(0);
}

if (isset($_POST['join_by_id_on'])) {
    $courseDetails->course_id = $_POST['join_by_id_on'];
    // echo $courseDetails->course_id;
    $courseDetails->setJoinById(0);
}
if (isset($_POST['join_by_id_off'])) {
    $courseDetails->course_id = $_POST['join_by_id_off'];
    // echo $courseDetails->course_id;
    $courseDetails->setJoinById(1);
}

if (isset($_POST['course_details'])) {
    $courseDetails->course_id = $_POST['course_details'];
}

if (isset($_GET['course_details'])) {
    $courseDetails->course_id = $_GET['course_details'];
}

$courseDetails->getCourse();

$attendance->course_id = $courseDetails->course_id;
$attendance->getAllDate();

$courseEnroll->course_id = $courseDetails->course_id;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- section 1 -->
    <link rel="stylesheet" href="../css/card-1.css">
    <link rel="stylesheet" href="../css/view-details-1.css">
    <link rel="stylesheet" href="../css/view-details-2.css">

    <title>Course details</title>
</head>

<body>
    <!-- navbar  -->
    <?php include '../php-1/navbar-1.php'; ?>

    <div style="text-align: center; margin: 0% 2%; ">
        <a href="homepage.php" class="btn-1">Homepage</a>
    </div>

    <!-- short notice -->
    <?php include_once '../php-1/msg01.php' ?>

    <!-- section 1 Overview -->
    <div class="container">
        <h3 class="heading-1"><?php echo $courseDetails->course_title . " | " . $courseDetails->course_code; ?></h3>

        <div class="box-container box-container-3">
            <div class="box box-3" style="text-align: left">
                <!-- <h3>Currently</h3> -->
                <p>Total class: <?php echo count($attendance->dateList); ?></p>
                <p>Total student: <?php echo $courseEnroll->getTotalStudentNumber(); ?></p>
                <p>Course ID: <?php echo $courseDetails->course_id; ?></p>
                <p>Session: <?php echo $courseDetails->session; ?></p>
                <p><?php echo $courseDetails->department; ?></p>
            </div>
            <div class="box">
                <p>Mark course as </p>
                <form action="" method="POST">
                    <?php
                    $nm = ($courseDetails->completed == 1) ? "incomplete" : "complete";
                    ?>
                    <button type="submit" name="<?php echo $nm; ?>" value=<?php echo $courseDetails->course_id; ?> class="btn-1"><?php echo $nm; ?></a>
                </form>
            </div>
            <div class="box">
                <p>Course enrollment using course id</p>
                <form action="" method="POST">
                    <?php
                    $joinById = ($courseDetails->join_by_id == 1) ? "join_by_id_on" : "join_by_id_off";

                    $btnTitle = ($courseDetails->join_by_id == 1) ? "Disable now" : "Enable now";
                    ?>
                    <button type="submit" name="<?php echo $joinById; ?>" value="<?php echo $courseDetails->course_id; ?>" class="btn-1"><?php echo $btnTitle; ?></button>
                </form>
            </div>
            <div class="box">
                <p>Delete this course</p>
                <p><i>Action can't be undone</i></p>
                <form action="../menu-common/delete_course.php" method="POST">
                    <input class="input-1" type="number" name="course_id" value="" placeholder="Course ID" required> <br>
                    <button type="submit" name="delete_this_course" value="<?php echo $courseDetails->course_id; ?>" class="btn-1">Proceed</button>
                </form>
            </div>
        </div>
    </div>

    <!-- section 2 -->
    <div class="container">
        <!-- <h1 class="heading"></h1> -->
        <div class="box-container">
            <div class="box">
                <p>Manage students</p>
                <!-- <a href="#" class="btn-1">Export as excel file</a><br> -->
                <form action="manage-students.php" method="POST">
                    <button name="manage_students" value="<?php echo $courseDetails->course_id; ?>" class="btn-1">Manage</button>
                </form>
            </div>
            <div class="box">
                <p>View student attendance summary</p>
                <!-- <a href="#" class="btn-1">Export as excel file</a><br> -->
                <form action="student-attendance-summary.php" method="POST">
                    <button name="student_attendance_summary" value="<?php echo $courseDetails->course_id; ?>" class="btn-1">View</button>
                </form>
            </div>
            <div class="box">
                <p>View / edit a class attendance</p>

                <form action="take-attendance.php" method="POST">
                    <div class="selectdiv-1">
                        <label>
                            <select name="class_date">
                                <?php foreach ($attendance->dateList as $date) { ?>
                                    <option value="<?php echo $date; ?>">Class on <?php echo $date; ?></option>
                                <?php } ?>
                            </select>
                        </label>
                    </div>

                    <button type="submit" name="edit_class_attendance" value="<?php echo $courseDetails->course_id; ?>" class="btn-1">Go</button>
                </form>
            </div>

            <div class="box">
                <p>Individual student attendance details</p>
                <form action="../menu-student/student-course-details.php" method="POST" target="_blank">
                    <input class="input-1" type="number" name="student_id" value="" placeholder="Student ID" required> <br>
                    <button type="submit" name="student_course_details" value="<?php echo $courseDetails->course_id; ?>" class="btn-1">View in new tab</button>
                </form>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-2.php'); ?>
</body>

</html>