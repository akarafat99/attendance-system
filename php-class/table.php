<?php
// Specify the directory where your PHP files are located
$directory = __DIR__;

// Get all PHP files in the directory
$phpFiles = glob($directory . '/*.php');

// Include each PHP file
foreach ($phpFiles as $file) {
    include_once $file;
}


class TableName
{
    public $allTableName = array();

    public $tbl_user = "tbl_user";
    public $tbl_student = "tbl_student";
    public $tbl_course_details = "tbl_course_details";
    public $tbl_course_enroll = "tbl_course_enroll";
    public $tbl_attendance = "tbl_attendance";

    public function __construct()
    {
        $this->addTableNameInOne();
    }

    public function addTableNameInOne()
    {
        $this->allTableName[] = $this->tbl_user;
        $this->allTableName[] = $this->tbl_student;
        $this->allTableName[] = $this->tbl_course_details;
        $this->allTableName[] = $this->tbl_course_enroll;
        $this->allTableName[] = $this->tbl_attendance;
    }
}

class TableCreate extends TableName
{
    public $table;

    public function createTable($tbl_name)
    {
        if ($tbl_name == $this->tbl_user) {
            $this->table = new User();
            $this->table->createUserTable();
        } elseif ($tbl_name == $this->tbl_student) {
            $this->table = new Student();
            $this->table->createStudentTable();
        } elseif ($tbl_name == $this->tbl_course_details) {
            $this->table = new CourseDetails();
            $this->table->createCourseDetailsTable();
        } elseif ($tbl_name == $this->tbl_course_enroll) {
            $this->table = new CourseEnroll();
            $this->table->createCourseEnrollTable();
        } elseif ($tbl_name == $this->tbl_attendance) {
            $this->table = new Attendance();
            $this->table->createAttendanceTable();
        } elseif ($tbl_name == "-1") {
            $this->table = new User();
            $this->table->createUserTable();

            $this->table = new Student();
            $this->table->createStudentTable();

            $this->table = new CourseDetails();
            $this->table->createCourseDetailsTable();

            $this->table = new CourseEnroll();
            $this->table->createCourseEnrollTable();

            $this->table = new Attendance();
            $this->table->createAttendanceTable();
        }
    }
}

// $v = new TableCreate();
// $v->createTable("-1");

?>
<!--  -->