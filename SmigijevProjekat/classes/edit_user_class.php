<?php

class EditUser
{
    private $error = "";

    public function evaluate($data, $id)
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->error = $this->error . $key . " is empty<br>";
            }
            if ($key == "email") {
                if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
                    $this->error = $this->error . "Please enter a valid email address<br>";
                }
                $id_owner_of_email = $id;
                $DB = new Database();
                $email = $_POST['email'];
                $query = "SELECT email FROM users WHERE email = '$email' AND userid != '$id_owner_of_email'";
                $check = $DB->read($query);

                if ($check > 0) {
                    $this->error = $this->error . "This email is already in use<br>";
                }
            }
            if ($key == "username") {
                $id_owner_of_username = $id;
                $DB = new Database();
                $username = $_POST['username'];
                $query = "SELECT username FROM users WHERE username = '$username' AND userid != '$id_owner_of_username'";
                $check = $DB->read($query);

                if ($check > 0) {
                    $this->error = $this->error . "This username is already in use<br>";
                }
            }
            if ($key == "first_name") {
                if (is_numeric($value)) {
                    $this->error = $this->error . "First name cannot be a number<br>";
                }
                if (strstr($value, " ")) {
                    $this->error = $this->error . "First name cannot have spaces<br>";
                }
            }
            if ($key == "last_name") {
                if (is_numeric($value)) {
                    $this->error = $this->error . "Last name cannot be a number<br>";
                }
                if (strstr($value, " ")) {
                    $this->error = $this->error . "Last name cannot have spaces<br>";
                }
            }
            if ($key == "password") {
                if ($_POST['password'] != $_POST['password2']) {
                    $this->error = $this->error . "Your passwords do not match<br>";
                }
            }
        }
        if ($this->error == "") {
            $this->update_user($data, $id);
        } else {
            return $this->error;
        }
    }

    public function update_user($data, $id)
    {
        $userid = $id;
        $first_name = ucfirst($data['first_name']);
        $last_name = ucfirst($data['last_name']);
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];
        $phone = $data['phone'];
        $date_of_birth = $data['date_of_birth'];
        if ($data['usertype'] == "") {
            $usertype = "User";
        } else {
            $usertype = $data['usertype'];
        }

        $query = "UPDATE users SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        username = '$username', 
        email = '$email', 
        password = '$password', 
        phone = '$phone', 
        date_of_birth = '$date_of_birth', 
        usertype = '$usertype'
        WHERE userid = '$userid'";

        $DB = new Database();
        $DB->save($query);
    }
}
