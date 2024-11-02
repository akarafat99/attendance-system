<?php

include_once '../php-1/include-all-class-and-session.php';

$objCourseD = new CourseDetails();

if (isset($_POST['delete_this_course'])) {
    if ($_POST['delete_this_course'] != $_POST[$objCourseD->variable_name[0]]) {
        $_SESSION['msg01'] = "Input wrong data. Please try again to delete this course (Course ID: {$_POST['delete_this_course']}).";

        header("Location: ../index.php");
        exit();
    } else {
        $objCourseD->course_id = $_POST[$objCourseD->variable_name[0]];
    }
}

if (isset($_POST['confirm_delete_this_course'])) {
    $objCourseD->course_id = $_POST[$objCourseD->variable_name[0]];
    $objCourseD->setCourse();

    if ($objCourseD->taken_by == $_POST[$objCourseD->variable_name[1]]) {
        $objCourseD->deleteCourse($objCourseD->course_id);
        $_SESSION['msg01'] = "Course deleted. (Course ID: {$objCourseD->course_id}).";
    } else {
        $_SESSION['msg01'] = "Input wrong data. Please try again to delete this course (Course ID: {$objCourseD->course_id}).";
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
    <title>Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/create-form.css">
</head>

<body>
    <!-- navbar -->
    <?php include '../php-1/navbar-1.php'; ?>

    <div style="text-align: center; margin: 2% 2%; ">
        <a href="../index.php" class="btn btn-secondary">Homepage</a>
    </div>

    <!-- form -->
    <h1 style="text-align: center; margin: 2% 0%; ">Course delete form</h1>
    <div class="container" style="background-color:#aacdcf;">
        <form action="" method="post">
            <div class="form-group">
                <div>Teacher ID:</div>
                <input type="text" placeholder="Enter Teacher ID:" name="<?php echo $objCourseD->variable_name[1]; ?>" class="form-control" value="" required>
            </div>

            <div class="form-group">
                <div>Course ID:</div>
                <input type="text" placeholder="Enter Course ID:" name="<?php echo $objCourseD->variable_name[0]; ?>" value="<?php echo $objCourseD->course_id; ?>" class="form-control" required readonly>
            </div>

            <div class="form-group">
                <!-- <div>Course ID:</div> -->
                <input type="checkbox" required> By deleting you confirm to delete course and this course can only be retrive by admin only. <i style="color: red">Action can't be undone</i>
            </div>

            <div class="from-btn1">
                <button type="submit" name="confirm_delete_this_course" class="btn btn-primary"> Confirm delete of this course </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-2.php'); ?>
</body>

</html>