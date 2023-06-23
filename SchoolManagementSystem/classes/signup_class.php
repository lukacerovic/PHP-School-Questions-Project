<?php 

class Signup
{
    private $error = ""; 
    
    public function evaluate($data) //$data will be of type array because $_POST that we pass from registration is of type array. That's why you can use foreach below
    {
        foreach ($data as $key => $value)
        {
            if(empty($value))
            {
                $this->error = $this->error . $key . " is empty<br>"; 
                
            }
            if($key == "email"){
                    
                if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)){
                    $this->error = $this->error . "Please enter a valid email adress<br>";
                }

                $DB=new Database();
                $email = $_POST['email'];
                $query = "SELECT email FROM users WHERE email = '$email' ";
                $check = $DB->read($query);
                
                if($check > 0){
                    $this->error = $this->error . "This email is already in use<br>";
                }

               
            }
            if($key == "username"){
               
                $DB=new Database();
                $username = $_POST['username'];
                $query = "SELECT username FROM users WHERE username = '$username' ";
                $check = $DB->read($query);
                
                if($check > 0){
                    $this->error = $this->error . "This username is already in use<br>";
                }

               
            }
            if($key == "first_name"){
                if (is_numeric($value)){
                    $this->error = $this->error . "first name cant be number<br>";
                }
                if (strstr($value, " ")){
                    $this->error = $this->error . "first name cant have spaces<br>";
                }
            }
            if($key == "last_name"){
                if (is_numeric($value)){
                    $this->error = $this->error . "last name cant be number<br>";
                }
                if (strstr($value, " ")){
                    $this->error = $this->error . "last name cant have spaces<br>";
                }
            }
            if($key == "password"){
                if($_POST['password'] != $_POST['password2']){
                    $this->error = $this->error . "Your password are not same<br>";
                }
            }
        }
        if($this->error == "")
        {
        
            $this->create_user($data); // calling create_user function
        }
        else
        {
            return $this->error;
        }
    }

    public function create_user($data)
    {
        $first_name = ucfirst($data['first_name']); // setting first letter to be uppercase
        $last_name = ucfirst($data['last_name']);
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];
        $phone = $data['phone'];
        $date_of_birth = $data['date_of_birth'];
        if($data['usertype'] == "")
        {
            //The only difference between regular registration and admin's addition is that the admin can set the user type. 
            //That's why you added this check for setting the usertype value.
            //In regular registration, there is no option to set the usertype, so the value will always be set as user."
            $usertype = "User";
        }
        else
        {
            $usertype = $data['usertype'];
        }
        

        //We are creating our custom function for generating a random selection of numbers
        $userid = $this->create_userid(); //using '$this->' because create_userid is a private function


        $query = "INSERT INTO users 
        (userid, first_name, last_name, username, email, password, phone, date_of_birth, usertype)
        VALUES 
        ('$userid', '$first_name', '$last_name', '$username', '$email', '$password', '$phone', '$date_of_birth', '$usertype')";

       
        $DB = new Database(); //creating an instance of Database class
        $DB->save($query); 
    }

    private function create_userid()
    {
        $length = rand(4, 19); 
        $number = "";
        for ($i=0; $i < $length; $i++)  
        {
            $new_rand = rand(0,9);
            $number = $number . $new_rand;
        }
        return $number;
    }
}
