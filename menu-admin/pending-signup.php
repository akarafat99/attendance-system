<?php
include_once '../php-1/include-all-class-and-session.php';

$user = new User();
$user->getUserList();

$searchUser = new Student();
// Check if a search query is submitted
$search = 0;
if (isset($_POST['search_by_email'])) {
    $searchEmail = $_POST['search_email'];

    // Use the User class method to search for users by email
    $searchUser->email = $searchEmail;
    $searchUser->checkUserByEmail();
    if ($searchUser->user_id > 0) {
        $search = 1;
        $searchUser->getStudent();
    } elseif ($searchUser->user_id == 0) {
        $_SESSION['msg01'] = "No user found using this email.";
    } else {
        $_SESSION['msg01'] = "Connection error. Please try again.";
    }
}

if (isset($_POST['approve']) || isset($_POST['decline'])) {
    $user->user_id = $_POST['approve'] ?? $_POST['decline'];

    // Check if the action is approval
    if (isset($_POST['approve'])) {
        // echo 0;
        // Use User class method to set 'deactivated' to 0 for approval
        $user->setDeactivated(0);
        // You may perform additional actions for approval if needed
    } else {
        // echo -2;
        // For decline, set 'deactivated' to -2
        $user->setDeactivated(-2);
        // You may perform additional actions for decline if needed
    }

    // Refresh the user list after the approval/decline action
    $user->getUserList();
}

$totalUsers = count($user->userList);
// echo "Total number of users: " . $totalUsers;
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
        .section-search {
            margin: 2% 15%;
            /* width: 90%;  */
        }

        /* Style for input field */
        .container-search input {
            transition: 1s;
            border: 0px;
            border-radius: 5px;
            padding: 8px;
            margin: 2% 0%;
            width: 75%;
            box-shadow: 0 0px 5px #80808040;
            flex: 1;
            /* Allow the input to take remaining space */
        }

        .container-search input:active,
        .container-search input:focus {
            box-shadow: 0 0px 10px #80808040;
        }

        /* Style for button */
        .container-search button {
            padding: 8px 16px;
            cursor: pointer;
        }
    </style>

    <title>Pending sign up</title>
</head>

<body>
    <!-- Navbar  -->
    <?php include '../php-1/navbar-1.php'; ?>

    <!-- short notice -->
    <?php include_once '../php-1/msg01.php' ?>

    <div style="text-align: center; margin: 0% 2%; ">
        <form action="course-details.php">
            <a href="homepage.php" class="btn-1">Homepage</a>
        </form>
    </div>

    <!-- Section 1 - search-->
    <div class="section-search">
        <div class="container-search">
            <form action="" method="POST">
                <input type="email" name="search_email" placeholder="Enter user email to search" required>
                <button type="submit" name="search_by_email" class="btn-1">Search</button>
            </form>
        </div>
    </div>

    <!-- Section 2 -->
    <div class="responsive-grid-f1 margin-2-15">
        <div class="grid-container-f2">
            <!-- Header Row -->
            <div class="grid-item-f2">User Info</div>
            <div class="grid-item-f2">Approve / decline</div>

            <!-- Search result -->
            <?php if ($search == 1 && $searchUser->deactivated == -1) { ?>
                <div class="grid-item-f2 t-a-left">
                    <h1>Search result</h1>
                    <?php
                    echo '<img src="../db-img/profile-img/' . $searchUser->profile_image_name . '" alt="User Image" style="max-width: 200px; max-height: 200px; margin-bottom: 5px; border-radius: 5px;"> <br>';
                    echo "User ID: " . $searchUser->user_id . "<br>";
                    echo "Account type: " . $searchUser->account_type . "<br>";
                    echo "Full Name: " . $searchUser->full_name . "<br>";
                    echo "Email: " . $searchUser->email . "<br>";
                    echo "Contact: " . $searchUser->contact . "<br>";
                    echo "Department: " . $searchUser->department . "<br>";
                    echo "Blood Group: " . $searchUser->blood_group . "<br>";
                    echo "Gender: " . $searchUser->gender . "<br>";
                    echo "Address: " . $searchUser->address . "<br>";

                    // Additional details based on account type
                    if ($searchUser->account_type === 'student') {
                        echo "Student ID: " . $searchUser->student_id . "<br>";
                        echo "Registration Number: " . $searchUser->registration_number . "<br>";
                        echo "Session: " . $searchUser->session . "<br>";
                    }

                    // Common details
                    echo "Creation Date: " . $searchUser->creation_date . "<br>";
                    echo "Last Modified: " . $searchUser->last_modified . "<br>";
                    ?>
                </div>
                <div class="grid-item-f2">
                    <form action="" method="POST">
                        <div style="text-align: center;">
                            <button type="submit" name="approve" value="<?php echo $searchUser->user_id; ?>" class="btn-1">Approve</button><br>
                            <button type="submit" name="decline" value="<?php echo $searchUser->user_id; ?>" class="btn-1">Decline</button>
                        </div>
                    </form>
                </div>
            <?php } ?>

            <!-- Check if userList is not empty -->
            <?php if (!empty($user->userList)) : ?>
                <!-- User Data Rows -->
                <?php $i = 1; ?>
                <?php foreach ($user->userList as $userItem) : ?>
                    <div class="grid-item-f2 t-a-left">
                        <?php
                        echo "{$i} / {$totalUsers} <br>";
                        $i++;
                        echo '<img src="../db-img/profile-img/' . $userItem->profile_image_name . '" alt="User Image" style="max-width: 200px; max-height: 200px; margin-bottom: 5px; border-radius: 5px;"> <br>';
                        echo "User ID: " . $userItem->user_id . "<br>";
                        echo "Account type: " . $userItem->account_type . "<br>";
                        echo "Full Name: " . $userItem->full_name . "<br>";
                        echo "Email: " . $userItem->email . "<br>";
                        echo "Contact: " . $userItem->contact . "<br>";
                        echo "Department: " . $userItem->department . "<br>";
                        echo "Blood Group: " . $userItem->blood_group . "<br>";
                        echo "Gender: " . $userItem->gender . "<br>";
                        echo "Address: " . $userItem->address . "<br>";

                        // Additional details based on account type
                        if ($userItem->account_type === 'student') {
                            echo "Student ID: " . $userItem->student_id . "<br>";
                            echo "Registration Number: " . $userItem->registration_number . "<br>";
                            echo "Session: " . $userItem->session . "<br>";
                        }

                        // Common details
                        echo "Creation Date: " . $userItem->creation_date . "<br>";
                        echo "Last Modified: " . $userItem->last_modified . "<br>";
                        ?>
                    </div>
                    <div class="grid-item-f2">
                        <form action="" method="POST">
                            <div style="text-align: center;">
                                <button type="submit" name="approve" value="<?php echo $userItem->user_id; ?>" class="btn-1">Approve</button><br>
                                <button type="submit" name="decline" value="<?php echo $userItem->user_id; ?>" class="btn-1">Decline</button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="grid-item-f2" style="text-align: center;">
                    No users to display.
                </div>
                <div class="grid-item-f2" style="text-align: center;">
                    -
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-2.php'); ?>
</body>

</html>