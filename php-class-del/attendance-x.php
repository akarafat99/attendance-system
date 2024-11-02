<?php
include_once 'conn.php';

class AttendanceX
{
    public $date, $student_id, $attendance;
    public $variable_name = array();

    public $conn, $query;

    public function __construct()
    {
        $this->listVName();
        $this->resetVariable();
    }

    public function setValue($date, $student_id, $attendance)
    {
        $this->date = $date;
        $this->student_id = $student_id;
        $this->attendance = $attendance;
    }

    public function listVName()
    {
        $this->variable_name[] = "id";
        $this->variable_name[] = "date";
        $this->variable_name[] = "student_id";
        $this->variable_name[] = "attendance";
    }

    public function resetVariable()
    {
        $this->date = "";
        $this->student_id = "";
    }

    public function createAttendanceXTable($course_id)
    {
        $tbl_name = "tbl_" . $course_id;
        $this->query = "CREATE TABLE IF NOT EXISTS $tbl_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            date DATE,
            student_id VARCHAR(255),
            attendance INT,
            last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $this->runQuery1();
    }

    public function doAttendance($course_id, $date, $student_id, $attendance)
    {
        $tbl_name = "tbl_" . $course_id;
        $this->query = "INSERT INTO $tbl_name (date, student_id, attendance) 
                  VALUES ('$date', '$student_id', $attendance)";
        return $this->runQuery2();
    }

    public function changeAttendance($course_id, $date, $student_id, $attendance)
    {
        $tbl_name = "tbl_" . $course_id;
        $this->query = "UPDATE $tbl_name SET 
        attendance = {$attendance}
        WHERE {$this->variable_name[2]} = '{$student_id}' AND 
        {$this->variable_name[1]} = '{$date}'";

        $this->runQuery1();
    }

    public function runQuery1()
    {
        $conn = new Conn();
        if (mysqli_query($conn->conn, $this->query)) {
            echo "Updated successfully <br>";
        } else {
            echo "Error: " . mysqli_error($conn->conn);
        }
        $conn->disconnect();
    }
    public function runQuery2()
    {
        $conn = new Conn();
        $insertKey = 0;
        if (mysqli_query($conn->conn, $this->query)) {
            echo "Updated successfully <br>";
            $insertKey = mysqli_insert_id($conn->conn);
        } else {
            echo "Error: " . mysqli_error($conn->conn);
        }
        $conn->disconnect();
        return $insertKey;
    }
}

// $i = new AttendanceX();
// $i->createAttendanceXTable(1024);
// $i->doAttendance(1024, "2023-12-19", "90122", 1);
// $i->changeAttendance(1024, "2023-12-19", "90122", 0);

// Create table
// $obj = new AttendanceX();
// $q = $obj->createAttendanceXTable(190122);

// if (mysqli_query($conn, $q)) {
//     echo "Table created successfully <br>";
// } else {
//     echo "Error: " . mysqli_error($conn);
// }

// insert
// $q = $obj->doAttendance(190122, "2023-12-05", '190122', 1);
// if (mysqli_query($conn, $q)) {
//     echo "Insert successfully<br>";

// } else {
//     echo "Error: " . mysqli_error($conn);
// }

// update
// $q = $obj->changeAttendance(190122, "2023-12-05", '190122', 0);
// $q = $obj->changeAttendance(123, "Y-M-D", "19191", 1);
// if (mysqli_query($conn, $q)) {
//     echo "Updated successfully <br>";
// } else {
//     echo "Error: " . mysqli_error($conn);
// }


// Close the connection after all operations
// mysqli_close($conn);
?>

<!--  -->