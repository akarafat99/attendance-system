<?php
include_once '../php-1/include-all-class-and-session.php';

$courseE = new CourseEnroll();
$courseD = new CourseDetails();
$attendance = new Attendance();

if (isset($_POST['student_attendance_summary'])) {
    $courseE->course_id = $_POST['student_attendance_summary'];
    $courseD->course_id = $courseE->course_id;
    $attendance->course_id = $courseE->course_id;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- section 1 -->
    <link rel="stylesheet" href="../css/card-1.css">
    <!-- <link rel="stylesheet" href="../css/view-details-1.css">
    <link rel="stylesheet" href="../css/view-details-2.css"> -->

    <!-- For section 2 -->
    <link rel="stylesheet" href="../css/form-1.css">

    <title>Attendance Overview</title>
</head>

<body>
    <!-- Navbar  -->
    <?php include '../php-1/navbar-1.php'; ?>

    <div style="text-align: center; margin: 0% 2%; ">
        <form action="course-details.php">
            <a href="homepage.php" class="btn-1">Homepage</a>
            <button type="submit" class="btn-1" name="course_details" value="<?php echo $courseD->course_id; ?>">course details</button>
        </form>
    </div>

    <!-- Section 1 - overview-->
    <?php $courseD->getCourse(); ?>
    <div class="container">
        <h3 class="heading-1"><?php echo $courseD->course_title; ?></h3>
        <p>Course code <?php echo $courseD->course_code; ?> </p>
        <p>Course ID <?php echo $courseD->course_id; ?> </p>
    </div>

    <!-- Section 2 -->
    <div class="responsive-grid-f1 margin-2-15">
        <!-- <h3 style="color: red;"><?php echo $tmp01; ?></h3> -->
        <div class="grid-container-f1">
            <!-- Header Row -->
            <div class="grid-item-f1">Student ID / Fullname</div>
            <div class="grid-item-f1">Attendance rate</div>
            <div class="grid-item-f1">Present / Absent</div>

            <!-- Sample Data Rows -->
            <?php
            $courseE->getStudentIdList();

            $student = new Student();
            foreach ($courseE->studentIdList as $s_id) {
                // echo $s_id . " <br>";
                $student->student_id = $s_id;
                $student->getUserIdByStudentId();
                $student->getStudent();

                $attendance->student_id = $s_id;
                $attendance->getTotalAttendanceRatePresentAbsentOfAStudent();
            ?>
                <!-- Display student details and attendance options -->
                <div class="grid-item-f1"> <?php echo $student->student_id ."<br>". $student->full_name; ?> </div>
                <div class="grid-item-f1"> <?php echo $attendance->attendanceRate . "%"; ?> </div>
                <div class="grid-item-f1"><?php echo $attendance->present ."<br>". $attendance->absent; ?></div>
            <?php
                $student->resetVariable();
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-2.php'); ?>

</body>

</html>