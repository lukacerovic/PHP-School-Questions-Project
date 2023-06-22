<?php

//prikupljanje informacija o korisniku
class User
{
    //zaduzena za izvlacenje tacno ulogovanog korisnika
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
    //izvlacimo sve korisnike iz tabele users
    public function get_all_users()
    {
        // Dobijanje liste korisnika iz baze podataka
        $users = array(); // Prazan niz za čuvanje korisnika
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
    //ovde izvlacimo sve korisnike koji su tipa 'user' ili 'User'
    public function get_type_user()
    {
        $users = array(); // Prazan niz za čuvanje korisnika
        $query = "SELECT * FROM users WHERE usertype = 'user' or usertype = 'User'";
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