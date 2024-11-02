<?php

include_once '../php-1/include-all-class-and-session.php';

// echo $_POST['course_id'] . "<br>";

$objCourseD = new CourseDetails();
$objUser = new User();
$objDept = new Department();

// echo $_SESSION['s_user_id']." ". $_SESSION['s_account_type'];

if(isset($_SESSION['s_user_id']) && isset($_SESSION['s_account_type']) && $_SESSION['s_account_type']=="teacher") {
    $objCourseD->taken_by = $_SESSION['s_user_id'];
    // echo $objCourseD->taken_by;
}


// update course
if (isset($_SESSION['course_id'])) {
    // echo "inside update <br>";
    $objCourseD->course_id = $_SESSION['course_id'];
    unset($_SESSION['course_id']);
    $objCourseD->setCourse();
}

// create course
if (isset($_POST['create_course'])) {
    // echo "inside create <br>";
    // Get form values
    $teacherId = $_POST[$objCourseD->variable_name[1]];
    $department = $_POST[$objCourseD->variable_name[3]];
    $session = $_POST[$objCourseD->variable_name[2]];
    $courseTitle = $_POST[$objCourseD->variable_name[5]];
    $courseCode = $_POST[$objCourseD->variable_name[4]];
    $courseCredit = $_POST[$objCourseD->variable_name[6]];

    // Set values in the CourseDetails object
    $objCourseD->setValue($teacherId, $session, $department, $courseCode, $courseTitle, $courseCredit);
    $objCourseD->course_id = $_POST['create_course'];

    if ($objCourseD->course_id == 0) {
        // Create the course
        $objCourseD->createCourse();
        $course_id=$objCourseD->course_id;
        $_SESSION['msg01'] = "Course created. Course ID {$course_id}.";
    } else {
        // Update course
        $objCourseD->updateCourse();
        $_SESSION['msg01'] = "Course updated. Course ID {$objCourseD->course_id}.";

    }
    header("Location: ../index.php");
    exit();
    // Print values for testing
    // echo "Course ID: " . $objCourseD->course_id . "<br>";
    // echo "Teacher ID: " . $objCourseD->taken_by . "<br>";
    // echo "Department: " . $objCourseD->department . "<br>";
    // echo "Session: " . $objCourseD->session . "<br>";
    // echo "Course Title: " . $objCourseD->course_title . "<br>";
    // echo "Course Code: " . $objCourseD->course_code . "<br>";
    // echo "Course Credit: " . $objCourseD->credit . "<br>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course</title>

    <!-- for form -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/create-form.css">
</head>

<body>
    <!-- navbar -->
    <?php include '../php-1/navbar-1.php'; ?>


    <div style="text-align: center; margin: 2% 2%; ">
        <!-- <a href="../index.php" class="form-btn0">Homepage</a> -->
        <a href="../index.php" class="btn btn-secondary"> Homepage </a>
    </div>

    <!-- form -->
    <div class="container" style="background-color:#aacdcf;">
        <form action="" method="post">
            <div class="form-group">
                <div>Teacher ID:</div>
                <input type="text" placeholder="Enter Teacher ID:" name="<?php echo $objCourseD->variable_name[1]; ?>" class="form-control" value="<?php echo $objCourseD->taken_by; ?>" required>
            </div>

            <div class="form-group">
                <div>Course for department</div>
                <!-- Choose Department: -->
                <label for="departments">
                    <select name="<?php echo $objCourseD->variable_name[3]; ?>" id="" required>
                        <?php foreach ($objDept->department as $dept) : ?>
                            <option value="<?php echo $dept[0]; ?>" <?php echo ($objCourseD->department == $dept[0]) ? 'selected' : ''; ?>>
                                <?php echo $dept[0]; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>

            <div class="form-group">
                <div>Session:</div>
                <input type="text" placeholder="Enter Your Session" name="<?php echo $objCourseD->variable_name[2]; ?>" class="form-control" value="<?php echo $objCourseD->session; ?>" required>
            </div>
            <div class="form-group">
                <div>Course Title:</div>
                <input type="text" placeholder="Enter Course Title:" name="<?php echo $objCourseD->variable_name[5]; ?>" class="form-control" value="<?php echo $objCourseD->course_title; ?>" required>
            </div>
            <div class="form-group">
                <div>Course code:</div>
                <input type="text" placeholder="Enter Course Code:" name="<?php echo $objCourseD->variable_name[4]; ?>" class="form-control" value="<?php echo $objCourseD->course_code; ?>" required>
            </div>
            <div class="form-group">
                <div>Course Credit</div>
                <input type="number" step="0.01" placeholder="Enter Course Credit" name="<?php echo $objCourseD->variable_name[6]; ?>" class="form-control" value="<?php echo $objCourseD->credit; ?>" required>
            </div>
            <div class="form-btn1">
                <button type="submit" name="create_course" value="<?php echo $objCourseD->course_id; ?>" class="btn btn-primary"> Submit </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-1.php'); ?>
</body>

</html>