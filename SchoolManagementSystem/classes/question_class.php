<?php 

class Question
{
    private $error = ""; // Private variable for collecting errors during registration
    
    public function evaluate($data)
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->error .= $key . " is empty<br>"; 
            }
            // Add other validations......
        }

        if ($this->error == "") {
            
            $this->create_question($data);
        } else {
            return $this->error;
        }
    }

    public function create_question($data)
    {
        
        $question_id = $this->create_questionid();
        $author = $data['author'];
        $title = $data['title'];	
        $description = $data['description'];		
        $available_until = $data['available_until'];
        $priority = $data['priority'];
        $category = $data['category'];
        $created_date = date('Y-m-d H:i:s');
        
        $list_of_users = implode(',', $data['list_of_users']);
        // Creating dictionary for variable is_finished_by and adding default values of false foreach
        $is_finished_by = array();
        foreach ($data['list_of_users'] as $user) {
            $is_finished_by[$user] = false;
        }
        $is_finished_by_json = json_encode($is_finished_by);

        $query = "INSERT INTO questions 
        (question_id, author, title, description, list_of_users, is_finished_by, available_until, priority, category, created_date)
        VALUES 
        ('$question_id', '$author', '$title', '$description', '$list_of_users', '$is_finished_by_json', '$available_until', '$priority', '$category', '$created_date')";

        $DB = new Database();
        $DB->save($query);
    }

    private function create_questionid()
    {
        $length = rand(4, 19);
        $number = "";
        for ($i=0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }
        return $number;
    }
    public function get_all_questions()
    {
        $users = array(); // Empty array for collecting users
        $query = "SELECT * FROM questions";
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
    public function get_all_questions_for_user($username)
    {
        $query = "SELECT * FROM questions WHERE FIND_IN_SET('$username', list_of_users) > 0";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function get_current_question($id)
    {
        $query = "SELECT * FROM questions WHERE question_id = '$id' LIMIT 1";
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
    public function set_finished($question_id, $username)
    {
       
        $query = "SELECT is_finished_by FROM questions WHERE question_id = '$question_id' LIMIT 1";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            $is_finished_by = json_decode($result[0]['is_finished_by'], true);
            if (isset($is_finished_by[$username])) {
                $is_finished_by[$username] = true;
                $is_finished_by_json = json_encode($is_finished_by);
                
                $update_query = "UPDATE questions SET is_finished_by = '$is_finished_by_json' WHERE question_id = '$question_id'";
                $DB->save($update_query);

                header("Location: user.php");
                exit();
            } else {
                return "User '$username' is not found as an assigned user for this question.";
            }
        } else {
            return "Question with this Id '$question_id' is not found.";
        }
    }
}
