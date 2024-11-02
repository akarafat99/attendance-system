<?php
class Conn
{
  public $servername = "localhost";
  public $username = "root";
  public $password = "";
  public $dbname = "sias";
  public $conn;

  public function __construct()
  {
    $this->connect();
  }

  public function connect()
  {
    $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
    if (!($this->conn)) {
      // die("Connection failed: " . mysqli_connect_error());
    } else {
      // echo "Connected\n";
    }
  }

  public function disconnect()
  {
    mysqli_close($this->conn);
    // echo "Disconnected <br>";
  }
}

?>
<!--  -->