<?php
include_once 'conn.php';

class CourseEnroll
{
    public $id, $student_id, $course_id, $creation_date, $last_modified;

    public $variable_name = array();

    public $conn, $query, $result, $row, $courseIdList, $studentIdList;

    public function __construct()
    {
        $this->listVName();
        $this->resetVariable();
    }

    public function setValue($student_id, $course_id)
    {
        $this->student_id = $student_id;
        $this->course_id = $course_id;
    }

    public function listVName()
    {
        $this->variable_name[] = "id";
        $this->variable_name[] = "student_id";
        $this->variable_name[] = "course_id";
        $this->variable_name[] = "creation_date";
        $this->variable_name[] = "last_modified";
    }

    public function resetVariable()
    {
        $this->student_id = "";
        $this->course_id = 0;
        // $this->creation_date = "";
        // $this->last_modified = "";
    }

    public function createCourseEnrollTable()
    {
        $this->query = "CREATE TABLE IF NOT EXISTS tbl_course_enroll (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id VARCHAR(255),
            course_id INT,
            creation_date DATE DEFAULT CURRENT_DATE,
            last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->runQuery1();
    }

    public function enrollStudent($student_id, $course_id)
    {
        $this->createCourseEnrollTable();

        $this->query = "INSERT INTO tbl_course_enroll (student_id, course_id) 
                  VALUES ('{$student_id}', {$course_id})";

        $this->runQuery1();
    }

    public function removeStudent()
    {
        $this->createCourseEnrollTable();
        
        $this->query = "DELETE FROM tbl_course_enroll WHERE {$this->variable_name[1]} = '{$this->student_id}' AND {$this->variable_name[2]} = {$this->course_id}";

        $this->runQuery1();
    }

    public function isEnrolled()
    {
        $this->createCourseEnrollTable();

        $this->query = "SELECT * FROM tbl_course_enroll WHERE {$this->variable_name[1]} = '{$this->student_id}' AND {$this->variable_name[2]} = {$this->course_id}";

        return $this->runQuery2();
    }

    public function getCourseIdList()
    {
        $this->query = "SELECT {$this->variable_name[2]} FROM tbl_course_enroll WHERE {$this->variable_name[1]} = '{$this->student_id}'";

        $this->runQuery1();
        $this->courseIdList = array();
        if ($this->result) {
            while ($this->row = mysqli_fetch_assoc($this->result)) {
                $this->courseIdList[] = $this->row[$this->variable_name[2]];
            }
        }
    }

    public function getStudentIdList()
    {
        $this->studentIdList = array();

        $this->query = "SELECT student_id FROM tbl_course_enroll WHERE course_id = {$this->course_id} ORDER BY student_id ASC";

        $this->runQuery1();
        if ($this->result) {
            while ($this->row = mysqli_fetch_assoc($this->result)) {
                $this->studentIdList[] = $this->row['student_id'];
            }
        }
    }

    public function getTotalStudentNumber()
    {
        $this->query = "SELECT COUNT(DISTINCT student_id) AS total_students FROM tbl_course_enroll WHERE course_id = {$this->course_id}";

        $this->runQuery1();

        $totalStudents = 0;
        if ($this->result) {
            $row = mysqli_fetch_assoc($this->result);
            $totalStudents = $row['total_students'];
        }

        return $totalStudents;
    }


    // public function updateEnrollment($course_id, $student_id)
    // {
    //     $this->query = "UPDATE tbl_course_enroll SET 
    //         course_id = '{$this->course_id}'
    //         WHERE student_id = '{$student_id}'";

    //     $this->runQuery1();
    // }

    public function runQuery1()
    {
        $conn = new Conn();
        $this->result = mysqli_query($conn->conn, $this->query);
        $conn->disconnect();
    }

    public function runQuery2()
    {
        $conn = new Conn();
        $result = mysqli_query($conn->conn, $this->query);
        $conn->disconnect();

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }
    }

    public function runQuery3()
    {
        $conn = new Conn();
        $result = mysqli_query($conn->conn, $this->query);
        $conn->disconnect();
        $this->courseIdList = array();
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->courseIdList[] = $row[$this->variable_name[2]];
            }
        }
    }
}

?>
<!--  -->