<?php
// session
// if (session_status() == PHP_SESSION_NONE) {
//     // Only start the session if it's not already started
//     session_start();
// }
include_once 'user.php';

class Login
{
    public $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function checkCredential($id, $password)
    {
        // Check if $id is numeric (considered as user ID) or a valid email address
        // echo $id . "<br>";
        if (is_numeric($id)) {
            // echo 'numeric <br>';
            $this->user->user_id = $id;
            $this->user->checkUserById();
        } else {
            // echo 'email <br>';
            $this->user->email = $id;
            // also save the user_id in object
            $this->user->checkUserByEmail();
        }

        // echo $this->user->user_id . "<br>";
        if ($this->user->user_id > 0) {
            $this->user->getAccountType();
            $this->user->getPassword();
            $passwordMatches = password_verify($password, $this->user->password);
            if ($passwordMatches) {
                $this->user->getDeactivated();
                return 1;
            } else {
                $_SESSION['msg01'] = "Incorrect password. Please try again.";
                return 0;
            }
        } else {
            $_SESSION['msg01'] = "Invalid user id. Please try again.";
            return 0;
        }
    }
}

// $login = new Login();

?>
<!--  -->