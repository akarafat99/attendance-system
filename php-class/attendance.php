<?php
include_once 'conn.php';

class Attendance
{
    public $student_id, $course_id, $date1, $attendance, $creation_date, $last_modified;
    public $variable_name = array();

    public $studentIdList, $present, $absent, $attendanceList, $dateForAttendanceList,  $attendanceRate, $totalClasses;

    public $conn, $query, $result, $row, $rows;

    public $dateList;

    public function __construct()
    {
        $this->listVName();
        $this->resetVariable();
        $this->createAttendanceTable();
    }

    public function setValue($student_id, $course_id, $date1, $attendance)
    {
        $this->student_id = $student_id;
        $this->course_id = $course_id;
        $this->date1 = $date1;
        $this->attendance = $attendance;
    }

    public function listVName()
    {
        $this->variable_name[] = "id";
        $this->variable_name[] = "student_id";
        $this->variable_name[] = "course_id";
        $this->variable_name[] = "date1";
        $this->variable_name[] = "attendance";
        $this->variable_name[] = "creation_date";
        $this->variable_name[] = "last_modified";
    }

    public function resetVariable()
    {
        $this->id = 0;
        $this->student_id = "";
        $this->course_id = 0;
        $this->date1 = "";
        $this->attendance = 0;
        // $this->creation_date = "";
        // $this->last_modified = "";
    }


    public function createAttendanceTable()
    {
        $this->query = "CREATE TABLE IF NOT EXISTS tbl_attendance (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id VARCHAR(255),
            course_id INT,
            date1 DATE,
            attendance INT,
            creation_date DATE DEFAULT CURRENT_DATE,
            last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->runQuery1();
    }

    public function insertSingleAttendance()
    {
        $this->createAttendanceTable();

        $this->query = "INSERT INTO tbl_attendance (student_id, course_id, date1, attendance) 
              VALUES ('{$this->student_id}', {$this->course_id}, '{$this->date1}',{$this->attendance})";

        return $this->runQuery2();
    }

    public function insertMultipleAttendance($query)
    {
        $this->query = "INSERT INTO tbl_attendance (student_id, course_id, date1, attendance) VALUES ";
        $this->query .= $query;

        $this->runQuery1();
    }

    public function updateDate($oldDate)
    {
        $this->query = "UPDATE tbl_attendance 
              SET date1 = '{$this->date1}' 
              WHERE course_id = {$this->course_id} 
              AND date1 = '{$oldDate}'";

        $this->runQuery1();
    }


    public function updateMultipleAttendance($query)
    {
        $this->query = "UPDATE tbl_attendance SET attendance = CASE ";
        $this->query .= $query;
        $this->runQuery1();
    }

    public function updateAttendance()
    {
        $this->query = "UPDATE tbl_attendance SET 
            attendance = {$this->attendance}
            WHERE student_id = '{$this->student_id}' AND course_id = {$this->course_id} AND date1 = '{$this->date1}'";

        $this->runQuery1();
    }

    public function isDateExist()
    {
        $this->query = "SELECT * FROM tbl_attendance 
                    WHERE course_id = {$this->course_id} 
                    AND date1 = '{$this->date1}'";

        return $this->runQuery3();
    }

    public function getAllDate()
    {
        $this->query = "SELECT DISTINCT date1 FROM tbl_attendance WHERE 
        course_id = {$this->course_id} 
        ORDER BY date1 DESC";

        $this->runQuery1();

        $this->dateList = array();
        if ($this->result) {
            while ($this->row = mysqli_fetch_assoc($this->result)) {
                $this->dateList[] = $this->row['date1'];
            }
        }
    }

    public function getAttendanceOfStudent($student_id)
    {
        $this->query = "SELECT attendance FROM tbl_attendance 
                    WHERE student_id = {$student_id} 
                    AND course_id = {$this->course_id} 
                    AND date1 = '{$this->date1}'";

        $this->runQuery1();
        if ($this->result) {
            $row = mysqli_fetch_assoc($this->result);
            if ($row) {
                return $row['attendance'];
            }
        }
    }

    public function getAttendanceListOfAStudent()
    {
        $this->query = "SELECT attendance, date1 FROM tbl_attendance
                    WHERE student_id = {$this->student_id} 
                    AND course_id = {$this->course_id}
                    ORDER BY date1 ASC";

        $this->runQuery1();
        $this->attendanceList = array();
        $this->dateForAttendanceList = array();
        if ($this->result) {
            while ($this->row = mysqli_fetch_assoc($this->result)) {
                $this->attendanceList[] = $this->row['attendance'];
                $this->dateForAttendanceList[] = $this->row['date1'];
            }
        }
    }

    public function getTotalAttendanceRatePresentAbsentOfAStudent()
    {
        $this->getAttendanceListOfAStudent();

        $this->present = 0;
        $this->absent = 0;
        $this->totalClasses = 0;

        if (empty($this->attendanceList)) {
            $this->attendanceRate = 0;
        } else {
            foreach ($this->attendanceList as $attendance) {
                if ($attendance == 1) {
                    $this->present++;
                } elseif ($attendance == 0) {
                    $this->absent++;
                }
            }

            $this->totalClasses = count($this->attendanceList);
            $this->attendanceRate = round(($this->totalClasses > 0) ? ($this->present / $this->totalClasses) * 100 : 0, 3);
        }
    }

    public function setSomeAttendanceOfAStudent()
    {
        $this->getAllDate();

        if (count($this->dateList) > 0) {
            $this->getAttendanceListOfAStudent();

            $remainingDates = array_diff($this->dateList, $this->dateForAttendanceList);

            if (count($remainingDates) > 0) {
                $this->attendance = 0;
                foreach ($remainingDates as $d) {
                    $this->date1 = $d;
                    $this->insertSingleAttendance();
                }
            }
        }
    }


    public function runQuery1()
    {
        $conn = new Conn();
        $this->result = mysqli_query($conn->conn, $this->query);
        $conn->disconnect();
    }

    public function runQuery2()
    {
        $conn = new Conn();
        $insertKey = 0;
        if (mysqli_query($conn->conn, $this->query)) {
            // echo "Query executed successfully <br>";
            $insertKey = mysqli_insert_id($conn->conn);
        } else {
            // echo "Error: " . mysqli_error($conn->conn);
        }
        $conn->disconnect();
        return $insertKey;
    }

    public function runQuery3()
    {
        $conn = new Conn();
        $result = mysqli_query($conn->conn, $this->query);
        $conn->disconnect();

        if ($result) {
            $row_count = mysqli_num_rows($result);
            return $row_count; // If there is at least one record, the date exists
        } else {
            return -2; // Query execution failed
        }
    }
}

?>

<!--  -->