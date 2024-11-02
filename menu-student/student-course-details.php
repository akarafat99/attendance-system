<?php
include_once '../php-1/include-all-class-and-session.php';

$courseE = new CourseEnroll();
$courseD = new CourseDetails();
$attendance = new Attendance();
$student = new Student();

if (isset($_POST['student_course_details'])) {
    if(isset($_POST['student_id'])) {
        $courseE->student_id = $_POST['student_id'];
        $courseE->course_id = $_POST['student_course_details'];
        $enrolled = $courseE->isEnrolled();
        if ($enrolled == 0) {
            $_SESSION['msg01'] = "Student (Student ID {$_POST['student_id']}) not enrolled to this course. Try again.";
        } elseif($enrolled == -2 || $enrolled == 2) {
            $_SESSION['msg01'] = "Connection error (Code -2 / 2). Try again.";
        }

        $attendance->student_id = $_POST['student_id'];
    } else {
        $student->user_id = $_SESSION['s_user_id'];
        $student->getStudent();
        $attendance->student_id = $student->student_id;
    }

    $courseD->course_id = $_POST['student_course_details'];
    $courseD->getCourse();

    $attendance->course_id = $courseD->course_id;
    $attendance->getTotalAttendanceRatePresentAbsentOfAStudent();
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
    <link rel="stylesheet" href="../css/view-details-1.css">
    <link rel="stylesheet" href="../css/view-details-2.css">

    <title>Student course details</title>
</head>

<body>
    <!-- navbar  -->
    <?php include '../php-1/navbar-1.php'; ?>

     <!-- short notice -->
     <?php include_once '../php-1/msg01.php' ?>

    <div style="text-align: center; margin: 0% 2%; ">
        <a href="../index.php" class="btn-1">Homepage</a>
    </div>

    <!-- section 1 - overview-->
    <div class="container">
        <h3 class="heading-1">Student ID <?php echo $attendance->student_id; ?></h3>
        <div class="box-container box-container-3">
            <div class="box" style="text-align: left">
                <p><?php echo $courseD->course_title; ?></p>
                <p>Course code <?php echo $courseD->course_code; ?> </p>
                <p>Course taken by (ID) <?php echo $courseD->taken_by; ?></p>
                <p>Session <?php echo $courseD->session; ?> </p>
                <p>Department <?php echo $courseD->department; ?></p>
                <p>Credit <?php echo $courseD->credit; ?></p>
            </div>
            <div class="box box-3">
                <!-- <h3>Currently</h3> -->
                <p>Currently Attendance rate <?php echo $attendance->attendanceRate; ?>%</p>
                <p>Total class: <?php echo $attendance->totalClasses; ?></p>
                <p>Total present: <?php echo $attendance->present; ?></p>
                <p>Total absent: <?php echo $attendance->absent; ?></p>
            </div>
            <div class="box box-3">
                <?php

                $ifpresent = round(($attendance->totalClasses > 0) ? (($attendance->present + 1) / ($attendance->totalClasses + 1)) * 100 : 0, 3);

                $ifabsent = round(($attendance->totalClasses > 0) ? (($attendance->present + 0) / ($attendance->totalClasses + 1)) * 100 : 0, 3);

                ?>
                <h3>If present on next class</h3>
                <p>Attendance rate will be <?php echo $ifpresent; ?> %</p>
                <h3>If absent on next class</h3>
                <p>Attendance rate will be <?php echo $ifabsent; ?> %</p>
            </div>
        </div>
    </div>

    <!-- section 2 present absent -->
    <div class="container">
        <h1 class="heading">Present / absent date list</h1>
        <div class="box-container box-container-2">
            <div class="box box-2">
                <h3>Present on</h3>
                <p>
                    <?php
                    $list = "";
                    foreach ($attendance->attendanceList as $key => $attendanceValue) {
                        if ($attendanceValue == 1) {
                            $list .= $attendance->dateForAttendanceList[$key] . "<br>";
                        }
                    }
                    // $list = rtrim($list, ",   ");
                    echo $list;
                    ?>
                </p>
            </div>
            <div class="box box-2">
                <h3>Absent on</h3>
                <p>
                    <?php
                    $list = "";
                    foreach ($attendance->attendanceList as $key => $attendanceValue) {
                        if ($attendanceValue == 0) {
                            $list .= $attendance->dateForAttendanceList[$key] . "<br>";
                        }
                    }
                    echo $list;
                    ?>
                </p>
            </div>
        </div>
    </div>


<!-- Footer -->
<?php include_once('../php-1/footer-2.php'); ?>

</body>

</html>