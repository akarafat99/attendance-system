<?php
include_once '../php-1/include-all-class-and-session.php';

$courseE = new CourseEnroll();
$courseD = new CourseDetails();
$attendance = new Attendance();

$edit_class_attendance = 0;
if (isset($_POST['edit_class_attendance'])) {
    $edit_class_attendance = 1;
    $attendance->course_id = $_POST['edit_class_attendance'];

    if (empty($_POST['class_date'])) {
        $_SESSION['msg01'] = "No class occured. So, view/edit not possible.";
        // Forward to course-details.php with a POST value
        header("Location: course-details.php?&course_details=" . urlencode($attendance->course_id));
        exit(); // Ensure that the script stops here
    }

    $attendance->date1 = $_POST['class_date'];
    $_SESSION['date1'] = $attendance->date1;

    $courseE->course_id = $attendance->course_id;
    $courseD->course_id = $attendance->course_id;
}

if (isset($_POST['take_attendance'])) {
    $courseE->course_id = $_POST['take_attendance'];
    $courseD->course_id = $courseE->course_id;
}

$tmp01 = "";
if (isset($_POST['submit_attendance'])) {
    $attendance->course_id = $_POST['submit_attendance'];
    $selectedDate = $_POST['attendance_date'];
    $attendance->date1 = $selectedDate;

    $courseE->course_id = $attendance->course_id;
    $courseD->course_id = $attendance->course_id;


    if ($attendance->isDateExist() > 0) {
        // echo 1;
        $tmp01 = "*Already available on this date {$selectedDate}.";
    } elseif ($attendance->isDateExist() == 0) {
        // echo 0;
        $courseE->getStudentIdList();
        $query = "";
        foreach ($courseE->studentIdList as $s_id) {
            $attendanceValue = isset($_POST[$s_id]) ? $_POST[$s_id] : ''; // Get attendance value from the form

            // Validate the attendance value to prevent SQL injection
            if ($attendanceValue === '1' || $attendanceValue === '0') {
                $query .= "('{$s_id}', {$attendance->course_id}, '{$attendance->date1}', {$attendanceValue}), ";
            } else {
                // Handle invalid attendance value (optional)
                // echo "Invalid attendance value for student ID: '{$s_id}'";
                $tmp01 = "Error code 0. Try to submit again.";
            }
        }

        // Remove the trailing comma and execute the query
        $query = rtrim($query, ', ');
        // echo $query;
        $attendance->insertMultipleAttendance($query);

        $_SESSION['msg01'] = "Attendance submitted successfully. Class date: {$attendance->date1}. Course ID: {$attendance->course_id}";
        header("Location: homepage.php");
        exit();
    } else {
        // echo -2;
        $tmp01 = "Connection error. Try again.";
    }
} elseif (isset($_POST['submit_edit_attendance'])) {
    $edit_class_attendance = 1;
    $attendance->course_id = $_POST['submit_edit_attendance'];
    $selectedDate = $_POST['attendance_date'];
    $attendance->date1 = $selectedDate;

    echo $attendance->course_id . " " . $attendance->date1 . "<br>";

    $courseE->course_id = $attendance->course_id;
    $courseD->course_id = $attendance->course_id;

    echo $attendance->isDateExist() . " " . $_SESSION['date1'] . "<br>";

    if ($attendance->isDateExist() > 0 && $attendance->date1 != $_SESSION['date1']) {
        // echo 1;
        $tmp01 = "*Already available on this date {$selectedDate}.";
        $attendance->date1 = $_SESSION['date1'];
    } else {
        // } elseif ($attendance->isDateExist() > 0 && $attendance->date1 != $_SESSION['date1']) {
        // echo "In else <br>";
        $courseE->getStudentIdList();

        $query = "";

        foreach ($courseE->studentIdList as $s_id) {
            $attendanceValue = isset($_POST[$s_id]) ? $_POST[$s_id] : ''; // Get attendance value from the form

            // Validate the attendance value to prevent SQL injection
            if ($attendanceValue === '1' || $attendanceValue === '0') {
                $query .= "WHEN student_id = '{$s_id}' THEN {$attendanceValue} ";
            } else {
                // Handle invalid attendance value (optional)
                // echo "Invalid attendance value for student ID: '{$s_id}'";
                $tmp01 = "Error code 0. Try to submit again.";
            }
        }

        $query .= " END WHERE course_id = {$attendance->course_id} AND date1 = '{$_SESSION['date1']}'";

        // echo $query;
        // Execute the query
        $attendance->updateMultipleAttendance($query);
        $attendance->updateDate($_SESSION['date1']);
        unset($_SESSION['date1']);

        $_SESSION['msg01'] = "Attendance updated successfully. Class date: {$attendance->date1}. Course ID {$attendance->course_id}";
        header("Location: homepage.php");
        exit();
    }
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

    <style>
        /* Add some basic styles for the date input */
        .date-picker {
            background-color: #0080ff;
            padding: 10px;
            /* position: absolute; */
            /* transform: translate(-50%,-50%); */
            /* top: 50%;
    left: 50%; */
            font-family: "Roboto Mono", monospace;
            color: #ffffff;
            /* font-size: 18px; */
            border: none;
            outline: none;
            border-radius: 5px;
        }

        ::-webkit-calendar-picker-indicator {
            background-color: #ffffff;
            padding: 5px;
            cursor: pointer;
            border-radius: 3px;
        }
    </style>


    <title>Attendance</title>
</head>

<body>
    <!-- Navbar  -->
    <?php include '../php-1/navbar-1.php'; ?>

    <!-- short notice -->
    <?php include_once '../php-1/msg01.php' ?>

    <div style="text-align: center; margin: 0% 2%; ">
        <form action="course-details.php">
            <a href="homepage.php" class="btn-1">Homepage</a>
            <button type="submit" class="btn-1" name="course_details" value="<?php echo $courseD->course_id; ?>">course details</button>
        </form>
    </div>

    <!-- Section 1 - overview-->
    <?php $courseD->getCourse(); ?>
    <div class="container">
        <!-- <a href="homepage.php" class="btn-1">Homepage</a> -->
        <h3 class="heading-1"><?php echo $courseD->course_title; ?></h3>
        <p>Course code <?php echo $courseD->course_code; ?> </p>
        <p>Course ID <?php echo $courseD->course_id; ?> </p>
    </div>

    <!-- Section 2 -->
    <div class="responsive-grid-f1 margin-2-15">
        <h3 style="color: red;"><?php echo $tmp01; ?></h3>
        <form action="" method="POST">
            <p>Class date <input class="date-picker" type="date" name="attendance_date" value="<?php echo ($edit_class_attendance == 1) ? $attendance->date1 : ""; ?>" required> </p>
            <div class="grid-container-f1">
                <!-- Header Row -->
                <div class="grid-item-f1">Fullname</div>
                <div class="grid-item-f1">Student ID</div>
                <div class="grid-item-f1">Status</div>

                <!-- Sample Data Rows -->
                <?php
                $courseE->getStudentIdList();

                $student = new Student();
                foreach ($courseE->studentIdList as $s_id) {
                    // echo $s_id . " <br>";
                    $student->student_id = $s_id;
                    $student->getUserIdByStudentId();
                    $student->getStudent();
                ?>
                    <!-- Display student details and attendance options -->
                    <div class="grid-item-f1"> <?php echo $student->full_name; ?> </div>
                    <div class="grid-item-f1"> <?php echo $student->student_id; ?> </div>
                    <div class="grid-item-f1">
                        <?php

                        $presentChecked = "";
                        $absentChecked = "";

                        // for edit attendance
                        if ($edit_class_attendance == 1) {
                            $attendance_1 = $attendance->getAttendanceOfStudent($s_id);
                            $presentChecked = ($attendance_1 == 1) ? 'checked' : '';
                            $absentChecked = ($attendance_1 == 0) ? 'checked' : '';
                        }

                        // for create (or already POST value available for) attendance
                        $radioName = $s_id;
                        if (isset($_POST[$radioName])) {
                            $presentChecked = isset($_POST[$radioName]) && $_POST[$radioName] == "1" ? 'checked' : '';
                            $absentChecked = isset($_POST[$radioName]) && $_POST[$radioName] == "0" ? 'checked' : '';
                        }

                        ?>
                        <input type="radio" name="<?php echo $s_id; ?>" value="1" <?php echo $presentChecked; ?> required> Present
                        <input type="radio" name="<?php echo $s_id; ?>" value="0" <?php echo $absentChecked; ?> required> Absent
                    </div>
                <?php
                    $student->resetVariable();
                }
                ?>

            </div>
            <div style="text-align: center;">
                <?php
                $btnName = "submit_attendance";
                if ($edit_class_attendance == 1) {
                    $btnName = "submit_edit_attendance";
                }
                ?>
                <button type="submit" name="<?php echo $btnName; ?>" value="<?php echo $courseE->course_id; ?>" class="btn-1">Submit attendance</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-2.php'); ?>

</body>

</html>