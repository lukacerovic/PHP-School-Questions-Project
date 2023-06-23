<?php

class Login{

    private $error = "";
    
    public function evaluate($data){

        $email = addsLashes($data['email']);
        $password = addsLashes($data['password']);
        
        $query = "SELECT * FROM users WHERE email = '$email' limit 1";

        
        $DB = new Database();
        $result = $DB->read($query);

        if($result){

            $row = $result[0];

            if($password == $row['password']){

                $_SESSION['userid'] = $row['userid'];
                // Redirecting to the appropriate page based on usertype
                if ($row['usertype'] == 'admin' or $row['usertype'] == 'Admin') {
                    header("Location: admin.php");
                    die;
                } elseif ($row['usertype'] == 'User' or $row['usertype'] == 'user') {
                    header("Location: user.php");
                    die;
                } elseif ($row['usertype'] == 'Manager') {
                    header("Location: manager.php");
                    die;
                }

            }else{
                $this->error .= "Wrong password or email<br>";
            }

        }else{

            $this->error .= "Wrong password or email<br>";
        }

        return $this->error;
        
    }

    //Creating method which will check if the user is loged in or not
    public function check_login($id){
        if(is_numeric($id)){

            $query = "select * from users where userid = '$id' limit 1";

            
            $DB = new Database();
            $result = $DB->read($query);

            if($result){

                $user_data = $result[0];
                return $user_data;
    
            }
            else{
                header("Location: login.php");
                die;
                
            }
        }
        else{
            header("Location: login.php");
            die;
        }
        //$login = new Login();
        //$user_data = $login->check_login($_SESSION['userid']);
    }
}
