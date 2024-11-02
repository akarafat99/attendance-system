<?php
include_once 'user.php';

class Student extends User
{
    public $student_id, $session, $registration_number;

    public $conn, $query;

    public function __construct()
    {
        parent::__construct();
        $this->listVName();
        $this->resetVariable();
    }

    public function setValue($account_type, $full_name, $email, $contact, $department, $blood_group, $gender, $address, $student_id, $session, $registration_number)
    {
        parent::setValue($account_type, $full_name, $email, $contact, $department, $blood_group, $gender, $address, $student_id, $session, $registration_number);
        $this->student_id = $student_id;
        $this->session = $session;
        $this->registration_number = $registration_number;
    }

    public function listVName()
    {
        parent::listVName();
        $this->variable_name[] = "student_id";
        $this->variable_name[] = "session";
        $this->variable_name[] = "registration_number";
    }

    public function resetVariable()
    {
        parent::resetVariable();
        $this->student_id = "";
        $this->session = "";
        $this->registration_number = "";
    }

    public function createStudentTable()
    {
        $this->query = "CREATE TABLE IF NOT EXISTS tbl_student (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            student_id VARCHAR(255),
            session VARCHAR(255) NOT NULL,
            registration_number VARCHAR(50) NOT NULL,
            creation_date DATE DEFAULT CURRENT_DATE,
            last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->runQuery1();
    }

    public function createStudent()
    {
        parent::createUser();
        $this->createStudentTable();

        $this->query = "INSERT INTO tbl_student (user_id, student_id, session, registration_number) 
                  VALUES ({$this->user_id}, '{$this->student_id}', '{$this->session}', '{$this->registration_number}')";

        return $this->runQuery2();
    }

    public function getStudent()
    {
        $this->setStudent();
    }

    public function setStudent()
    {
        parent::setUser();

        $this->query = "SELECT * FROM tbl_student WHERE user_id = {$this->user_id}";
        $conn = new Conn();
        $result = mysqli_query($conn->conn, $this->query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                // Assign values to class properties
                $this->student_id = $row['student_id'];
                $this->session = $row['session'];
                $this->registration_number = $row['registration_number'];
            } else {
            }
        } else {
            // echo "Error: " . mysqli_error($conn->conn) . "<br>";
        }

        $conn->disconnect();
    }
    
    public function getUserIdByStudentId()
    {
        $this->createStudentTable();
        
        $this->query = "SELECT user_id FROM tbl_student WHERE student_id = '{$this->student_id}'";
        $conn = new Conn();
        $result = mysqli_query($conn->conn, $this->query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                // Assign values to class properties
                $this->user_id = $row['user_id'];
            } else {
                $this->user_id = 0;
            }
        } else {
            // echo "Error: " . mysqli_error($conn->conn) . "<br>";
        }

        $conn->disconnect();
    }



    public function readStudentId()
    {
        $this->query = "SELECT {$this->variable_name[13]} FROM tbl_student WHERE {$this->variable_name[0]} = {$this->user_id}";

        $conn = new Conn();
        $result = mysqli_query($conn->conn, $this->query);
        $conn->disconnect();

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $this->student_id = $row[$this->variable_name[13]];
            }
        }
    }

    public function updateStudent()
    {
        parent::updateUser();

        $this->query = "UPDATE tbl_student SET 
            user_id = {$this->user_id},
            student_id = '{$this->student_id}',
            session = '{$this->session}',
            registration_number = '{$this->registration_number}'
            WHERE " . $this->variable_name[0] . " = '{$this->user_id}'";

        $this->runQuery1();
    }

    // public function deleteStudent()
    // {
    //     $query = "UPDATE tbl_student SET 
    //         session = '{$this->session}',
    //         registration_number = '{$this->registration_number}'
    //         WHERE " . $this->variable_name[0] . " = '{$this->user_id}'";

    //     return $query;
    // }

    public function runQuery1()
    {
        $conn = new Conn();
        if (mysqli_query($conn->conn, $this->query)) {
            // echo "Updated successfully <br>";
        } else {
            // echo "Error: " . mysqli_error($conn->conn);
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
}

// $i = new Student();

// echo $i->variable_name[13];
// $i->createStudentTable();

// $i->setValue('190135', '12345', 'Student', 'Tasnuba Tasnim', 'abc@gmail.com', '01676057548', 'CSE', 'O+', 'Female', 'Jashore,Khulna,Bangladesh', "2019-2020", "1901020");

// echo $i->createStudent();

// $i->session = "usecase";
// $i->updateStudent();



?>
<!--  -->