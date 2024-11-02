<?php
include_once '../php-1/include-all-class-and-session.php';

// echo $_SESSION['s_user_id']." ". $_SESSION['s_account_type'];

// for section 1
$courseDetails = new CourseDetails();

$courseDetails->taken_by = $_SESSION['s_user_id'];
$courseDetails->getCompletedCourse(); // Call the method to fetch completed courses


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

    <title>Homepage</title>
</head>

<body>
    <!-- Navbar  -->
    <?php include '../php-1/navbar-1.php'; ?>

    <!-- short notice -->
    <?php include_once '../php-1/msg01.php' ?>

    <div style="text-align: center; margin: 0% 2%; ">
        <a href="homepage.php" class="btn-1">Homepage</a>
    </div>

    <!-- Section 1 -->
    <div class="container">
        <h1 class="heading">Previously Taken courses</h1>
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
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<!-- Footer -->
<?php include_once('../php-1/footer-2.php'); ?>

</body>

</html>