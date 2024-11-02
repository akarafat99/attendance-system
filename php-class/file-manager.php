<?php
include_once 'conn.php';

class FileManager
{
    public $file_id, $file_name, $file_deleted, $creation_date, $last_modified;

    public $variable_name = array();

    public $conn, $query, $result, $row, $fileList;

    public function __construct()
    {
        $this->listVName();
        $this->resetVariable();
        $this->checkFileTableExistence();
    }

    public function setValue($file_id, $file_name, $file_deleted)
    {
        $this->file_id = $file_id;
        $this->file_name = $file_name;
        $this->file_deleted = $file_deleted;
        // $this->creation_date = $creation_date;
        // $this->last_modified = $last_modified;
    }

    public function listVName()
    {
        $this->variable_name = array(
            'file_id', 'file_name', 'file_deleted', 'creation_date', 'last_modified'
        );
    }

    public function resetVariable()
    {
        $this->file_id = 0;
        $this->file_name = "0.jpg";
        $this->file_deleted = 0;
        $this->creation_date = "";
        $this->last_modified = "";
    }

    public function createFileTable()
    {
        $this->query = "CREATE TABLE IF NOT EXISTS tbl_file (
            file_id INT AUTO_INCREMENT PRIMARY KEY,
            file_name VARCHAR(255),
            file_deleted INT DEFAULT 0,
            creation_date DATE DEFAULT CURRENT_DATE,
            last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->runQuery1();
    }

    public function checkFileTableExistence()
    {
        $this->query = "SHOW TABLES LIKE 'tbl_file'";
        $this->runQuery1();

        if ($this->result) {
            // Check if the result set has at least one row
            if (mysqli_num_rows($this->result) > 0) {
                // Table exists
                // echo "Table tbl_file exists!";
            } else {
                // Table does not exist
                // echo "Table tbl_file does not exist.";
                // Create the table
                $this->createFileTable();
            }
        } else {
            // Handle the query execution error
        }
    }

    public function insertFile()
    {
        $this->query = "INSERT INTO tbl_file (file_name, file_deleted) 
                  VALUES ('{$this->file_name}', {$this->file_deleted})";

        // the inserted id will saved in file_id var
        $this->runQuery2();
    }

    public function updateFile()
    {
        $this->query = "UPDATE tbl_file SET 
            file_name = '{$this->file_name}',
            file_deleted = {$this->file_deleted}
            WHERE file_id = {$this->file_id}";

        $this->runQuery1();
    }

    public function updateFileName($file_name)
    {
        $this->query = "UPDATE tbl_file SET 
            file_name = '{$file_name}'
            WHERE file_id = {$this->file_id}";

        $this->runQuery1();
    }

    private function deleteFile()
    {
        $this->query = "DELETE FROM tbl_file WHERE file_id = {$this->file_id}";
        $this->runQuery1();
    }

    public function getFileList()
    {
        $this->query = "SELECT * FROM tbl_file";
        $this->runQuery1();
        $this->fileList = array();

        if ($this->result) {
            while ($this->row = mysqli_fetch_assoc($this->result)) {
                $this->fileList[] = $this->row;
            }
        }
    }

    public function getFileName($file_id)
    {
        $this->query = "SELECT file_name FROM tbl_file WHERE file_id = {$file_id}";

        $this->runQuery1();

        if ($this->result) {
            $this->row = mysqli_fetch_assoc($this->result);
            if ($this->row) {
                $this->file_name = $this->row['file_name'];
            }
        } else {
            $this->file_name = "0.jpg";
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
        $this->result = mysqli_query($conn->conn, $this->query);
        // set the last inserted ID
        $this->file_id = mysqli_insert_id($conn->conn);
        $conn->disconnect();
    }
}

// $f = new File();
// $f->insertFile();
// $file_name = $f->file_id . ".jpg";
// $f->setFileName($file_name);

?>

<!--  -->