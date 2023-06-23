<?php
session_start();

include("connect.php");
include("login_class.php");
include("user_class.php");
include("question_class.php");

class Comments {
    public function addComment() {
        if (isset($_POST["senderUsername"]) && isset($_POST["comment"]) && isset($_POST["questionId"])) {
           
            $senderUsername = $_POST["senderUsername"];
            $comment = $_POST["comment"];
            $questionId = $_POST["questionId"];
            $comment_id = $this->create_commentid();
            echo "Sender Username: " . $senderUsername . "<br>";
            echo "Comment: " . $comment . "<br>";
            echo "Question ID: " . $questionId . "<br>";
            $query = "INSERT INTO comments (question_id, comment_id, comment_content, sender_username) 
                                    VALUES ('$questionId', '$comment_id', '$comment', '$senderUsername')";
            
            $DB = new Database();
            $result = $DB->save($query);
            
            // Returning response from AJAX request
            echo "Comment added successfully!";
        }
    }

    public function getAllComments() {
        $query = "SELECT * FROM comments";
        
        $DB = new Database();
        $result = $DB->read($query);
        
        // Returning result as JSON format
        echo json_encode($result);
    }
    
    private function create_commentid() {
        $length = rand(4, 19); // random length that PHP will choose between numbers 4 and 19.
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number = $number . $new_rand;
        }
        return $number;
    }

    // deleting comments
    public function deleteComment($commentId) {
            
        $query = "DELETE FROM comments WHERE comment_id = $commentId LIMIT 1";
        $DB = new Database();
        $result = $DB->save($query);

        echo "Comment deleted successfully!";
    }

}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["action"]) && $_GET["action"] == "getAllComments") {
        $comments = new Comments();
        $comments->getAllComments();
        exit; // Terminating script execution after receiving comments
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"]) && $_POST["action"] == "deleteComment") {
        //check if the deleteComment Post method is called
        $comments = new Comments();
        $comments->deleteComment($_POST["commentId"]);
        exit; // Terminating script execution after deleting comment
    } else {
        $comments = new Comments();
        $comments->addComment();
    }
}

?>
