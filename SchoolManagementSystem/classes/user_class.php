<?php

class User
{
    //finding logged in user data
    public function get_data($id)
    {

        $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
        
        $DB = new Database();
        $result = $DB->read($query);

        if($result)
        {

            $row = $result[0];
            return $row;
        }
        else
        {
            return false;
        }
    }
    //Getting all users from user table
    public function get_all_users()
    {
        //Adding users in a list
        $users = array(); // empty array for collecting users
        $query = "SELECT * FROM users";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $users = $result;
        }
        else
        {
            return false;
        }

    }
    //Getting all profiles with usertype == 'User'
    public function get_type_user()
    {
        $users = array(); // Prazan niz za čuvanje korisnika
        $query = "SELECT * FROM users WHERE usertype = 'User'";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $users = $result;
        }
        else
        {
            return false;
        }
    }
    public function get_user_current_info($id)
    {

        $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";

        $DB = new Database();
        $result = $DB->read($query);

        if($result)
        {

            $row = $result[0];
            return $row;
        }
        else
        {
            return false;
        }
    }
}
