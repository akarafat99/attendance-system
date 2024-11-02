<?php
include_once 'conn.php';
include_once 'file-manager.php';

class User
{
    public $user_id, $password, $account_type, $full_name, $email, $contact, $department, $blood_group, $gender, $address, $deactivated, $creation_date, $last_modified, $profile_image_id, $profile_image_name;

    public $variable_name = array();
    public $variable_name_2 = array();

    public $conn, $query, $result, $row, $userList;

    public function __construct()
    {
        $this->listVName();
        $this->resetVariable();
        $this->checkUserTableExistence();
    }

    public function setValue($account_type, $full_name, $email, $contact, $department, $blood_group, $gender, $address, $student_id, $session, $registration_number)
    {
        $this->account_type = $account_type;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->contact = $contact;
        $this->department = $department;
        $this->blood_group = $blood_group;
        $this->gender = $gender;
        $this->address = $address;
    }

    public function listVName()
    {
        $this->variable_name = array(
            "user_id", "password", "account_type", "full_name", "email",
            "contact", "department", "blood_group", "gender", "address",
            "deactivated", "creation_date", "last_modified"
        );

        $this->variable_name_2 = array("profile_image_id");
    }

    public function resetVariable()
    {
        $this->user_id = 0;
        $this->password = "just123";
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->account_type = "";
        $this->full_name = "";
        $this->email = "";
        $this->contact = "";
        $this->department = "";
        $this->blood_group = "";
        $this->gender = "";
        $this->address = "";
        $this->deactivated = 0;
        $this->profile_image_id = 0;
        $this->profile_image_name = "0.jpg";
        $this->last_modified = "";
        $this->creation_date = "";
    }

    public function createUserTable()
    {
        $this->query = "CREATE TABLE IF NOT EXISTS tbl_user (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            password VARCHAR(255) NOT NULL,
            account_type VARCHAR(50) NOT NULL,
            full_name VARCHAR(100),
            email VARCHAR(100),
            contact VARCHAR(15),
            department VARCHAR(100),
            blood_group VARCHAR(5),
            gender VARCHAR(100),
            address VARCHAR(255),
            deactivated INT DEFAULT 0,
            profile_image_id INT DEFAULT 0,
            creation_date DATE DEFAULT CURRENT_DATE,
            last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->runQuery1();
    }

    private function insertAdmin()
    {
        // Insert a default admin user
        $this->resetVariable();
        $this->account_type = 'admin';
        $this->full_name = 'Admin User';
        $this->email = 'admin@admin';
        $this->password = password_hash('admin@admin', PASSWORD_DEFAULT);

        $this->query = "INSERT INTO tbl_user (password, account_type, full_name, email) 
                        VALUES ('{$this->password}', '{$this->account_type}', '{$this->full_name}', '{$this->email}')";

        $this->user_id = $this->runQuery2();
    }
    public function checkUserTableExistence()
    {
        $this->query = "SHOW TABLES LIKE 'tbl_user'";
        $this->runQuery1();

        if ($this->result) {
            // Check if the result set has at least one row
            if (mysqli_num_rows($this->result) > 0) {
                // Table exists
                // echo "Table tbl_user exists!";
            } else {
                // Table does not exist
                // echo "Table tbl_user does not exist.";
                // Create the table and insert admin
                $this->createUserTable();
                $this->insertAdmin();
            }
        } else {
            // Handle the query execution error

        }

        // Note: $result and $row are now global properties and can be accessed outside this method.
    }


    public function createUser()
    {
        $this->createUserTable();

        $this->query = "INSERT INTO tbl_user (password, account_type, full_name, email, contact, department, blood_group, gender, address) 
              VALUES ('{$this->password}', '{$this->account_type}', '{$this->full_name}', '{$this->email}', '{$this->contact}', '{$this->department}', '{$this->blood_group}', '{$this->gender}', '{$this->address}')";

        $this->user_id = $this->runQuery2();
    }

    public function getUser()
    {
        $this->setUser();
    }

    public function setUser()
    {
        $this->query = "SELECT * FROM tbl_user WHERE user_id = {$this->user_id}";
        $conn = new Conn();
        $result = mysqli_query($conn->conn, $this->query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                // Assign values to class properties
                $this->user_id = $row['user_id'];
                $this->password = $row['password'];
                $this->account_type = $row['account_type'];
                $this->full_name = $row['full_name'];
                $this->email = $row['email'];
                $this->contact = $row['contact'];
                $this->department = $row['department'];
                $this->blood_group = $row['blood_group'];
                $this->gender = $row['gender'];
                $this->address = $row['address'];
                $this->deactivated = $row['deactivated'];
                $this->profile_image_id = $row['profile_image_id'];

                $file = new FileManager();
                $file->getFileName($this->profile_image_id);
                $this->profile_image_name = $file->file_name;
                // echo $this->profile_image_name . "<br>";

                $this->creation_date = $row['creation_date'];
                $this->last_modified = $row['last_modified'];
            } else {
                $this->user_id = -1;
            }
        } else {
            // echo "Error: " . mysqli_error($conn->conn) . "<br>";
        }

        $conn->disconnect();
    }

    public function getPassword()
    {
        $this->query = "SELECT password FROM tbl_user WHERE user_id = {$this->user_id}";

        $this->runQuery1();

        if ($this->result) {
            $this->row = mysqli_fetch_assoc($this->result);
            if ($this->row) {
                $this->password = $this->row['password'];
            }
        }
    }

    public function setPassword($password)
    {
        $this->password = $password;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $this->query = "UPDATE tbl_user SET 
                password = '{$this->password}'
                WHERE {$this->variable_name[0]} = {$this->user_id}";
        $this->runQuery1();
    }

    public function getUserList()
    {
        $this->query = "SELECT user_id, account_type FROM tbl_user WHERE deactivated = -1";
        $this->runQuery1();

        $this->userList = array(); // Initialize the $userList array
        if ($this->result) {
            while ($row = mysqli_fetch_assoc($this->result)) {
                // Check the account type
                $accountType = $row['account_type'];
                $user = null;
                // echo $row['user_id'] . "<br>";

                if ($accountType == 'student') {
                    // If the account type is Student, create a Student object
                    $user = new Student();
                    $user->user_id = $row['user_id'];
                    $user->getStudent(); // Populate the student-specific details
                } else {
                    // For other account types, create a User object
                    $user = new User();
                    $user->user_id = $row['user_id'];
                    $user->getUser(); // Populate the common user details
                }

                // Add the user object to the $userList array
                $this->userList[] = $user;
            }
        }
    }


    public function resetPassword($password)
    {
        $this->password = $password;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $this->query = "UPDATE tbl_user SET 
                password = '{$this->password}'
                WHERE {$this->variable_name[0]} = {$this->user_id}";
        $this->runQuery1();
    }

    public function getProfileImageId()
    {
        $this->query = "SELECT profile_image_id FROM tbl_user WHERE user_id = {$this->user_id}";

        $this->runQuery1();

        if ($this->result) {
            $this->row = mysqli_fetch_assoc($this->result);
            if ($this->row) {
                $this->profile_image_id = $this->row['profile_image_id'];
            }
        }
    }

    public function updateProfileImageId($profile_image_id)
    {
        $this->query = "UPDATE tbl_user SET 
                profile_image_id = {$profile_image_id}
                WHERE {$this->variable_name[0]} = {$this->user_id}";
        $this->runQuery1();
    }

    public function updateUser()
    {
        $this->query = "UPDATE tbl_user SET 
                account_type = '{$this->account_type}',
                full_name = '{$this->full_name}',
                password = '{$this->password}',
                email = '{$this->email}',
                contact = '{$this->contact}',
                department = '{$this->department}',
                blood_group = '{$this->blood_group}',
                gender = '{$this->gender}',
                address = '{$this->address}',
                deactivated = {$this->deactivated}
                -- profile_image_id = {$this->profile_image_id}
                WHERE {$this->variable_name[0]} = {$this->user_id}";

        $this->runQuery1();
    }

    // public function setUserId()
    // {
    //     $this->query = "SELECT user_id FROM tbl_user WHERE {$this->variable_name[0]} = {$this->user_id}";

    //     $this->runQuery1();

    //     if ($this->result) {
    //         $this->row = mysqli_fetch_assoc($this->result);
    //         if($this->row) {
    //             $this->user_id = $this->row['user_id'];
    //         } else {
    //             $this->user_id = 0;
    //         }
    //     } else{
    //         $this->user_id = -2;
    //     }
    // }

    public function checkUserById()
    {
        $this->query = "SELECT user_id FROM tbl_user WHERE {$this->variable_name[0]} = {$this->user_id}";

        $this->runQuery1();

        if ($this->result) {
            $this->row = mysqli_fetch_assoc($this->result);
            if ($this->row) {
                $this->user_id = $this->row['user_id'];
            } else {
                $this->user_id = 0;
            }
        } else {
            $this->user_id = -2;
        }
    }

    public function checkUserByEmail()
    {
        $this->query = "SELECT * FROM tbl_user WHERE {$this->variable_name[4]} = '{$this->email}'";

        $conn = new Conn();
        $result = mysqli_query($conn->conn, $this->query);

        if ($result !== false) {
            // Check the number of rows returned by the query
            $numRows = mysqli_num_rows($result);

            if ($numRows > 0) {
                $row = mysqli_fetch_assoc($result);
                $this->user_id = $row['user_id'];
            } else {
                $this->user_id = 0;
            }
        } else {
            $this->user_id = -2;
        }

        $conn->disconnect();
    }




    public function setUserIdByIdOrEmail($idOrEmail)
    {
        if (is_numeric($idOrEmail)) {
            // echo 'numeric <br>';
            $this->user_id = $idOrEmail;
            $this->checkUserById();
        } else {
            // echo 'email <br>';
            $this->email = $idOrEmail;
            // also save the user_id in object
            $this->checkUserByEmail();
        }
    }

    public function getDeactivated()
    {
        $this->query = "SELECT deactivated FROM tbl_user WHERE {$this->variable_name[0]} = {$this->user_id}";

        $this->runQuery1();

        if ($this->result) {
            $this->row = mysqli_fetch_assoc($this->result);
            if ($this->row) {
                $this->deactivated = $this->row['deactivated'];
                // echo "User Type: {$userType} <br>";
            } else {
                $this->deactivated = "-1";
                // echo "User not found <br>";
            }
        } else {
            // echo "Error: " . mysqli_error($conn->conn) . "<br>";
            $this->deactivated = "-2";
        }
    }

    public function setDeactivated($deactivated)
    {
        $this->query = "UPDATE tbl_user SET 
            deactivated = {$deactivated}
            WHERE " . $this->variable_name[0] . " = {$this->user_id}";

        $this->runQuery1();
    }

    public function getUserId()
    {
        $this->checkUserById();
    }

    public function getAccountType()
    {
        $this->query = "SELECT account_type FROM tbl_user WHERE {$this->variable_name[0]} = {$this->user_id}";

        $this->runQuery1();

        if ($this->result) {
            $this->row = mysqli_fetch_assoc($this->result);
            if ($this->row) {
                $this->account_type = $this->row['account_type'];
                // echo "User Type: {$userType} <br>";
            } else {
                $this->account_type = "0";
                // echo "User not found <br>";
            }
        } else {
            // echo "Error: " . mysqli_error($conn->conn) . "<br>";
            $this->account_type = "-2";
        }
    }


    public function runQuery1()
    {
        $conn = new Conn();
        $result = mysqli_query($conn->conn, $this->query);

        if ($result !== false) {
            $this->result = $result;
            // Query executed successfully
            // Additional handling or logging can be added here if needed
        } else {
            // Handle the query execution error
            echo "Error: " . mysqli_error($conn->conn);
        }

        $conn->disconnect();
    }

    public function runQuery2()
    {
        $conn = new Conn();
        $insertKey = 0;
        if (mysqli_query($conn->conn, $this->query)) {
            // echo "Updated successfully <br>";
            $insertKey = mysqli_insert_id($conn->conn);
        } else {
            // echo "Error: " . mysqli_error($conn->conn);
        }
        $conn->disconnect();
        return $insertKey;
    }

    public function sendEmail1($to, $subject)
    {
        $sub = '';
        $msg = '';

        // Set subject and message based on the provided subject
        if ($subject == "signup") {
            $sub = "Account registration successful (SIAS). #{$this->user_id}";
            $msg = "Dear {$this->full_name},<br><br>";
            $msg .= "Thank you for registering with student information and attendance system (SIAS). Your account (User ID: {$this->user_id}) has been successfully created.<br><br>";
            $msg .= "Best regards, <br>The SIAS Team";
        } elseif ($subject == "resetPassword") {
            $sub = "Password Reset Request (SIAS). #{$this->user_id}";
            $msg = "We received a request to reset your password. Default passowrd is just123. If you did not make this request, please contact with authority or email us.<br>";
            $msg .= $msg .= "Best regards, <br>The SIAS Team";
        } elseif ($subject == "forgotPassword") {
            $sub = "Forgot Password (SIAS)";
            $msg = "We received a request of forgot password through your email address {$this->email}. Your OTP is: <br><br>";
            $msg .= "If you did not request this, it is possible that someone else is trying to access your account. Do not forward or give this OTP code to anyone.";
            $msg .= "Sincerely yours, <br>The SIAS Team";
            
            // You may want to replace [TEMPORARY_PASSWORD] with the actual temporary password.
        }

        // Include the necessary file and send the email
        include_once '../email-system/send-email.php';
        sendMail($to, $sub, $msg);
    }


    // public function runQuery3()
    // {
    //     $conn = new Conn();
    //     $result = mysqli_query($conn->conn, $this->query);
    //     $conn->disconnect();


    // }
}

// $i = new User();
// $i->email = "170115.cse@student.just.edu.bd";
// $i->checkUserByEmail();
// echo $i->user_id;

// $i = new User();
// $i->setValue('190135', '12345', 'Student', 'Tasnuba Tasnim', 'abc@gmail.com', '01676057548', 'CSE', 'O+', 'Female', 'Jashore,Khulna,Bangladesh');
// $i->createUserTable();
// echo $i->createUser();

// $i->password = "101010";
// $i->updateUser("190135");

// $i->deactivateUser("190135");

?>

<!--  -->