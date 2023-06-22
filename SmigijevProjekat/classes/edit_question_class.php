<?php

class EditQuestion
{
    private $error = "";

    public function evaluate($data, $id)
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->error = $this->error . $key . " is empty<br>";
            }
            
        }
        if ($this->error == "") {
            $this->update_question($data, $id);
        } else {
            return $this->error;
        }
    }

    public function update_question($data, $id)
    {
        $question_id = $id;
        $title = ucfirst($data['title']);
        $description = ucfirst($data['description']);
        $author = $data['author'];
        $available_until = $data['available_until'];
        $priority = $data['priority'];
        $category = $data['category'];
        $created_date = date('Y-m-d H:i:s');
        $list_of_users = implode(',', $data['list_of_users']);

        $query = "UPDATE questions SET 
        title = '$title', 
        description = '$description', 
        author = '$author', 
        available_until = '$available_until', 
        priority = '$priority', 
        category = '$category', 
        created_date = '$created_date', 
        list_of_users = '$list_of_users'
        WHERE question_id = '$question_id'";

        $DB = new Database();
        $DB->save($query);
    }
}
