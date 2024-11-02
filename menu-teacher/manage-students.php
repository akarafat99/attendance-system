<?php
include_once '../php-1/include-all-class-and-session.php';

$courseE = new CourseEnroll();
$courseD = new CourseDetails();
$attendance = new Attendance();

if(isset($_POST['remove_from_course'])) {
    $courseE->course_id = $_POST['course_id'];
    $courseE->student_id = $_POST['remove_from_course'];
    
    $courseD->course_id = $courseE->course_id;

    $courseE->removeStudent();
    $_SESSION['msg01'] = "Student ID {$courseE->student_id} removed from this course (Course ID {$courseE->course_id})";

    unset($_POST['remove_from_course']);
    unset($_POST['course_id']);
}

if (isset($_POST['manage_students'])) {
    $courseE->course_id = $_POST['manage_students'];
    $courseD->course_id = $courseE->course_id;
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
        <h3 class="heading-1"><?php echo $courseD->course_title; ?></h3>
        <p>Course code <?php echo $courseD->course_code; ?> </p>
        <p>Course ID <?php echo $courseD->course_id; ?> </p>
    </div>

    <!-- Section 2 -->
    <div class="responsive-grid-f1 margin-2-15">
        <!-- <h3 style="color: red;"><?php echo $tmp01; ?></h3> -->
        <div class="grid-container-f1">
            <!-- Header Row -->
            <div class="grid-item-f1">Student details</div>
            <div class="grid-item-f1">Student ID</div>
            <div class="grid-item-f1"></div>

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
                <div class="grid-item-f1 t-a-left">
                    <?php
                    echo "Full name: " . $student->full_name;
                    echo "<br>Session: " . $student->session;
                    echo "<br>Registration Number: " . $student->registration_number;
                    echo "<br>User ID: " . $student->user_id;
                    echo "<br>Email: " . $student->email;
                    echo "<br>Contact: " . $student->contact;
                    echo "<br>Department: " . $student->department;
                    echo "<br>Gender: " . $student->gender;
                    // Add more information as needed
                    ?>
                </div>
                <div class="grid-item-f1"> <?php echo $student->student_id; ?> </div>
                <div class="grid-item-f1">
                    <form action="" method="POST">
                    <input type="hidden" name="course_id" value="<?php echo $courseE->course_id; ?>">

                        <div style="text-align: center;">
                            <button type="submit" name="remove_from_course" value="<?php echo $student->student_id; ?>" class="btn-1">Remove from course</button>
                        </div>
                    </form>
                </div>
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