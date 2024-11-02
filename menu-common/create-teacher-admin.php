<?php

include_once '../php-1/include-all-class-and-session.php';

$user = new User();
$objDeptClass = new Department();

// update
if (isset($_SESSION['user_id'])) {
    $user->user_id = $_SESSION['user_id'];
    $user->setUser();
    unset($_SESSION['user_id']);
}

// create
if (isset($_POST['create_teacher_admin'])) {
    // Get form values

    // Check if a file has been uploaded
    $uploaded = 0;
    if (!empty($_FILES['profile_image']['tmp_name'])) {
        $uploaded = 1;
    }

    // $user_id = $_POST[$user->variable_name[0]];
    $account_type = $_POST[$user->variable_name[2]];
    $full_name = $_POST[$user->variable_name[3]];
    $email = $_POST[$user->variable_name[4]];
    $contact = $_POST[$user->variable_name[5]];
    $department = $_POST[$user->variable_name[6]];
    $blood_group = $_POST[$user->variable_name[7]];
    $gender = $_POST[$user->variable_name[8]];
    $address = $_POST[$user->variable_name[9]];
    $student_id = "";
    $session = "";
    $registration_number = "";

    // set values
    $user->setValue($account_type, $full_name, $email, $contact, $department, $blood_group, $gender, $address, $student_id, $session, $registration_number);

    $user->user_id = $_POST['create_teacher_admin'];

    if ($user->user_id != 0) {
        // update user
        $file_manager = new FileManager();
        // if the image uploaded then start
        if ($uploaded == 1) {
            $file_manager->insertFile();
            $user->profile_image_id = $file_manager->file_id;
            $user->updateProfileImageId($user->profile_image_id);

            $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $file_name = $file_manager->file_id . "." . $file_extension;

            // update the file name with extension in tbl_file
            $file_manager->updateFileName($file_name);

            //Move the uploaded file to folder with custom name
            $destination_folder = "../db-img/profile-img/";
            $destination_path = $destination_folder . $file_name;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination_path);
        }

        $user->updateUser();
        $_SESSION['msg01'] = "User updated. User ID {$user->user_id}.";
    } else {
        // Create user
        $user->checkUserByEmail();

        if ($user->user_id == 0) {

            $file_manager = new FileManager();
            // if the image uploaded then start
            if ($uploaded == 1) {
                $file_manager->insertFile();

                $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                $file_name = $file_manager->file_id . "." . $file_extension;

                echo $file_name . "<br>";
                // update the file name with extension in tbl_file
                $file_manager->updateFileName($file_name);

                //Move the uploaded file to folder with custom name
                $destination_folder = "../db-img/profile-img/";
                $destination_path = $destination_folder . $file_name;
                move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination_path);
            }

            $user->createUser();
            $user->updateProfileImageId($file_manager->file_id);
            $user->setDeactivated(0);
            $_SESSION['msg01'] = "User created. User ID {$user->user_id}.";
        } elseif ($user->user_id == -2) {
            $_SESSION['msg01'] = "Connection error. Please try again.";
        } else {
            $_SESSION['msg01'] = "User already available using this email {$email}";
        }
        header("Location: ../index.php");
        exit();
    }

    header("Location: ../index.php");
    exit();

    // Echo values for testing purposes
    // echo "User ID: " . $user->user_id . "<br>";
    // echo "Password: " . $user->password . "<br>";
    // echo "Account Type: " . $user->account_type . "<br>";
    // echo "Full Name: " . $user->full_name . "<br>";
    // echo "Email: " . $user->email . "<br>";
    // echo "Contact: " . $user->contact . "<br>";
    // echo "Department: " . $user->department . "<br>";
    // echo "Blood Group: " . $user->blood_group . "<br>";
    // echo "Gender: " . $user->gender . "<br>";
    // echo "Address: " . $user->address . "<br>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher / Admin Profile</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- for form -->
    <link rel="stylesheet" href="../css/create-form.css">
</head>

<body>
    <!-- Navbar  -->
    <?php include '../php-1/navbar-1.php'; ?>

    <div style="text-align: center; margin: 2% 2%; ">
        <!-- <a href="../index.php" class="form-btn0">Homepage</a> -->
        <a href="../index.php" class="btn btn-secondary"> Homepage </a>
    </div>

    <!-- form -->
    <div class="container" style="background-color:#aacdcf;">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="card-block text-center text-white" style="margin-top: 20px">
                    <img src="../db-img/profile-img/<?php echo $user->profile_image_name; ?>" class="rounded-circle m-2" width="150px" height="150px" />
                    <input type="file" class="form-control" name="profile_image" id="file" accept="image/png, image/jpeg*" <?php echo ($user->user_id == 0) ? "required" : ''; ?>>
                </div>
            </div>
            <div class="form-group">
                <div>Password is (by default): just123</div>
            </div>
            <div class="form-group">
                <div>Account type:</div>
                <input type="radio" class="teacher" name="<?php echo $user->variable_name[2]; ?>" value="teacher" <?php echo ($user->account_type == 'teacher') ? 'checked' : ''; ?> required>Teacher
                <input type="radio" class="admin" name="<?php echo $user->variable_name[2]; ?>" value="admin" <?php echo ($user->account_type == 'admin') ? 'checked' : ''; ?> required>Admin
            </div>
            <div class="form-group">
                <div>Full Name:</div>
                <input type="text" class="form-control" name="<?php echo $user->variable_name[3]; ?>" value="<?php echo $user->full_name; ?>" required>
            </div>

            <div class="form-group">
                <div>Email Address:</div>
                <input type="text" class="form-control" name="<?php echo $user->variable_name[4]; ?>" value="<?php echo $user->email; ?>" required>
            </div>
            <div class="form-group">
                <div>Contact No:</div>
                <input type="text" class="form-control" name="<?php echo $user->variable_name[5]; ?>" value="<?php echo $user->contact; ?>" required>
            </div>
            <div class="form-group">
                <div>Department:</div>
                <label for="departments">
                    Choose Department:
                    <select name="<?php echo $user->variable_name[6] ?>" id="" required>
                        <?php foreach ($objDeptClass->department as $dept) : ?>
                            <option value="<?php echo $dept[0]; ?>" <?php echo ($user->department == $dept[0]) ? 'selected' : ''; ?>>
                                <?php echo $dept[0]; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <div class="form-group">
                <div>Blood Group:</div>
                <input type="text" class="form-control" name="<?php echo $user->variable_name[7]; ?>" value="<?php echo $user->blood_group; ?>" required>
            </div>
            <div class="form-group">
                <div>Address:</div>
                <input type="text" class="form-control" name="<?php echo $user->variable_name[9]; ?>" value="<?php echo $user->address; ?>" required>
            </div>
            <div class="form-group">
                <div>Gender:</div>
                <input type="radio" class="Male" name="<?php echo $user->variable_name[8]; ?>" value="male" <?php echo ($user->gender == 'male') ? 'checked' : ''; ?> required>Male
                <input type="radio" class="Female" name="<?php echo $user->variable_name[8]; ?>" value="female" <?php echo ($user->gender == 'female') ? 'checked' : ''; ?> required>Female
                <input type="radio" class="Other" name="<?php echo $user->variable_name[8]; ?>" value="other" <?php echo ($user->gender == 'other') ? 'checked' : ''; ?> required>Other
            </div>
            <hr class="bg-primary">
            <div class="form-btn1">
                <button type="submit" name="create_teacher_admin" value="<?php echo $user->user_id; ?>" class="btn btn-secondary">Submit</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <?php include_once('../php-1/footer-1.php'); ?>

</body>

</html>