<?php
include_once 'conn.php';

class CourseDetails
{
    public $course_id, $taken_by, $session, $department, $course_code, $course_title, $credit, $completed, $creation_date, $last_modified, $join_by_id;

    public $variable_name = array();

    public $conn, $query, $result, $row, $rows; // Declare $row globally

    public function __construct()
    {
        $this->listVName();
        $this->resetVariable();
    }

    public function setValue($taken_by, $session, $department, $course_code, $course_title, $credit)
    {
        $this->taken_by = $taken_by;
        $this->session = $session;
        $this->department = $department;
        $this->course_code = $course_code;
        $this->course_title = $course_title;
        $this->credit = $credit;
    }

    public function listVName()
    {
        $this->variable_name[] = "course_id";
        $this->variable_name[] = "taken_by";
        $this->variable_name[] = "session";
        $this->variable_name[] = "department";
        $this->variable_name[] = "course_code";
        $this->variable_name[] = "course_title";
        $this->variable_name[] = "credit";
        $this->variable_name[] = "completed";
        $this->variable_name[] = "join_by_id";
        $this->variable_name[] = "creation_date";
        $this->variable_name[] = "last_modified";
    }

    public function resetVariable()
    {
        $this->course_id = 0;
        $this->taken_by = 0;
        $this->session = "";
        $this->department = "";
        $this->course_code = "";
        $this->course_title = "";
        $this->credit = 0;
        $this->completed = 0;
        $this->creation_date = "";
        $this->last_modified = "";
    }

    public function createCourseDetailsTable()
    {
        $this->query = "CREATE TABLE IF NOT EXISTS tbl_course_details (
            course_id INT AUTO_INCREMENT PRIMARY KEY,
            taken_by INT,
            session VARCHAR(255) NOT NULL,
            department VARCHAR(100),
            course_code VARCHAR(50) NOT NULL,
            course_title VARCHAR(255),
            credit FLOAT,
            completed INT DEFAULT 0,
            join_by_id INT DEFAULT 1,
            creation_date DATE DEFAULT CURRENT_DATE,
            last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->runQuery1();
    }

    public function createCourse()
    {
        $this->createCourseDetailsTable();

        $this->query = "INSERT INTO tbl_course_details (taken_by, session, department, course_code, course_title, credit) 
              VALUES ({$this->taken_by}, '{$this->session}', '{$this->department}', '{$this->course_code}', '{$this->course_title}', {$this->credit})";

        $this->course_id = $this->runQuery2();

        // $at = new AttendanceX();
        // $at->createAttendanceXTable($this->course_id);
    }

    public function getCourse()
    {
        $this->setCourse();
    }

    public function setCourse()
    {
        $this->query = "SELECT * FROM tbl_course_details WHERE {$this->variable_name[0]} = {$this->course_id}";

        $this->runQuery1();

        if ($this->result) {
            $this->row = mysqli_fetch_assoc($this->result);
            if ($this->row) {
                // Set values using variable_name
                $this->setValue(
                    $this->row[$this->variable_name[1]],
                    $this->row[$this->variable_name[2]],
                    $this->row[$this->variable_name[3]],
                    $this->row[$this->variable_name[4]],
                    $this->row[$this->variable_name[5]],
                    $this->row[$this->variable_name[6]]
                );

                // Additional fields
                $this->completed = $this->row[$this->variable_name[7]];
                $this->join_by_id = $this->row[$this->variable_name[8]];
                $this->creation_date = $this->row[$this->variable_name[9]];
                $this->last_modified = $this->row[$this->variable_name[10]];
            }
        } else {
            $this->course_id = 0;
        }
    }

    public function updateCourse()
    {
        $this->query = "UPDATE tbl_course_details SET 
        taken_by = {$this->taken_by},
        session = '{$this->session}',
        department = '{$this->department}',
        course_code = '{$this->course_code}',
        course_title = '{$this->course_title}',
        credit = {$this->credit}
        WHERE {$this->variable_name[0]} = {$this->course_id}";

        $this->runQuery1();
    }

    public function setCompleted($completed)
    {
        $this->query = "UPDATE tbl_course_details SET 
            completed = {$completed}
            WHERE " . $this->variable_name[0] . " = {$this->course_id}";

        $this->runQuery1();
    }

    public function deleteCourse(int $course_id)
    {
        $this->course_id = $course_id;
        $this->setCompleted(-1);
    }

    public function setJoinById($join_by_id)
    {
        $this->query = "UPDATE tbl_course_details SET 
            join_by_id = {$join_by_id}
            WHERE " . $this->variable_name[0] . " = {$this->course_id}";

        $this->runQuery1();
    }

    public function checkCourse()
    {
        $this->query = "SELECT course_id, taken_by FROM tbl_course_details WHERE {$this->variable_name[0]} = {$this->course_id}";

        if ($this->completed == -3) {
            $this->query .= "";
        } else {
            $this->query .= " AND {$this->variable_name[7]} = {$this->completed}";
        }
        $this->runQuery1();

        if ($this->result) {
            $this->row = mysqli_fetch_assoc($this->result);

            if ($this->row) {
                $this->course_id = $this->row['course_id'];
                $this->taken_by = $this->row['taken_by'];
            } else {
                $this->course_id = 0;
                $this->taken_by = 0;
            }
        } else {
            // Handle the error, if needed
            // echo "Error: " . mysqli_error($conn->conn) . "<br>";
            $this->course_id = -2;
        }
    }

    public function setRows()
    {
        $this->rows = array();

        if ($this->result) {
            while ($row = mysqli_fetch_assoc($this->result)) {
                $this->rows[] = $row;
            }
            // if (count($this->rows) > 0) {
            //     return $this->rows;
            // } else {
            //     return array();
            // }
        } else {
        }
    }

    public function getOngoingCourse()
    {
        $this->query = "SELECT * FROM tbl_course_details 
            WHERE {$this->variable_name[1]} = {$this->taken_by} AND {$this->variable_name[7]} =  0";

        $this->runQuery1();
        $this->setRows();
    }

    public function getCompletedCourse()
    {
        $this->query = "SELECT * FROM tbl_course_details 
            WHERE {$this->variable_name[1]} = {$this->taken_by} AND {$this->variable_name[7]} =  1";

        $this->runQuery1();
        $this->setRows();
    }

    public function runQuery1()
    {
        $conn = new Conn();
        $this->result = mysqli_query($conn->conn, $this->query);
        if ($this->result) {
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

// Usage example:
// $obj = new CourseDetails();
// $obj->readCourse(1);
// echo $obj->course_id;
// echo $obj->taken_by;
// echo $obj->session;
// echo $obj->department;
// echo $obj->course_code;
// echo $obj->course_title;
// echo $obj->credit;
// echo $obj->completed;
// echo $obj->creation_date;
// echo $obj->last_modified;
?>
<!--  -->