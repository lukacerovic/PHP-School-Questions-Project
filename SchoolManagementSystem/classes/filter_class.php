<?php


class Filter
{
    public function find_results($data)
    {
        // Getting selected users from checkboxes
        $selectedUsers = $data['list_of_users'] ?? [];
        $selectedPriority = $data['priority'] ?? [];
        $selectedCategory = $data['category'] ?? [];
        $selectedDates = $data['available_until'] ?? [];

        // Forming a query to retrieve questions that contain selected users
        $query = "SELECT * FROM questions WHERE ";

        // Adding condition for filtered user
        if (!empty($selectedUsers)) {
            foreach ($selectedUsers as $user) {
                
                $query .= "FIND_IN_SET('$user', list_of_users) > 0 OR ";
            }
        }

        // Adding condition for filtered priority
        if (!empty($selectedPriority)) {
            foreach ($selectedPriority as $priority) {
           
                $query .= "priority = '$priority' OR ";
            }
        }

        // Adding condition for filtered category
        if (!empty($selectedCategory)) {
            foreach ($selectedCategory as $category) {
           
                $query .= "category = '$category' OR ";
            }
        }

        // Adding condition for filtered date of ending
        if (!empty($selectedDates)) {
            foreach ($selectedDates as $date) {
         
                $query .= "available_until = '$date' OR ";
            }
        }


        $users = array();
        // Removing last OR from statemant
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
