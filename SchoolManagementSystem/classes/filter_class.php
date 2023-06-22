<?php


class Filter
{
    public function find_results($data)
    {
        // Dobijanje odabranih korisnika iz checkboxova
        $selectedUsers = $data['list_of_users'] ?? [];
        $selectedPriority = $data['priority'] ?? [];
        $selectedCategory = $data['category'] ?? [];
        $selectedDates = $data['available_until'] ?? [];

        // Formiranje upita za dohvatanje pitanja koja sadrže odabrane korisnike
        $query = "SELECT * FROM questions WHERE ";

        // Dodavanje uslova za svakog odabranih korisnika
        if (!empty($selectedUsers)) {
            foreach ($selectedUsers as $user) {
                
                $query .= "FIND_IN_SET('$user', list_of_users) > 0 OR ";
            }
        }

        // Dodavanje uslova za svaki odabrani prioritet
        if (!empty($selectedPriority)) {
            foreach ($selectedPriority as $priority) {
           
                $query .= "priority = '$priority' OR ";
            }
        }

        // Dodavanje uslova za svaku odabranu kategoriju
        if (!empty($selectedCategory)) {
            foreach ($selectedCategory as $category) {
           
                $query .= "category = '$category' OR ";
            }
        }

        // Dodavanje uslova za svaki odabrani rok završetka
        if (!empty($selectedDates)) {
            foreach ($selectedDates as $date) {
         
                $query .= "available_until = '$date' OR ";
            }
        }


        $users = array();
        // Uklanjanje poslednjeg "OR" iz upita
        $query = rtrim($query, "OR ");
       
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
}
