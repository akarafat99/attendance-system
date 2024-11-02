<?php
include_once 'course-details.php';
include_once 'conn.php';

class Teacher extends CourseDetails
{
    public $rows;

    public function __construct()
    {
        parent::__construct();
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
}

?>
<!--  -->