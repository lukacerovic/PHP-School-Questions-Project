<?php

    session_start();

    include("classes/connect.php");
    include("classes/login_class.php");
    include("classes/user_class.php");
    include("classes/question_class.php");

    if (isset($_SESSION['userid']) && is_numeric($_SESSION['userid'])) {
        $id = $_SESSION['userid'];
        $login = new Login();
    
        $result = $login->check_login($id);
    
        if ($result) {
            $user = new User();
            $user_data = $user->get_data($id);
           
            $question = new Question();
            $all_question = $question->get_all_questions();
    
            if (!$user_data || $user_data['usertype'] != 'Manager') {
                header("Location: login.php");
                die;
            }
        
    
        } else {
            header('Location: login.php');
            die;
        }
    } else {
        header('Location: login.php');
        die;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=egde">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>User Page</title>
    <style>
        .user-list {
            list-style-type: none;
            padding: 0;
            margin-bottom: 20px;
           
        }

        .user-list-item {
           
            margin-bottom: 10px;
            
        }

        .user-list-item .user-info {
            margin-left: 10px;
        }
        .user-info strong{
            float:left;
        }

    </style>

</head>
<body>
    <div class="container text-center">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="content">
                    <h3>hi, <span><?php echo $user_data['username'] ?></span></h3>
                    <h1>Welcome</h1>
                    <h3>this is an <span style="color:cyan;font-weight:700;">Manager</span> page</h3>
                    <br>
                    <a href="logout.php" class="btn btn-secondary bg-danger">Logout</a>
                </div>
            </div>
            <div class="container">
                <div class="col-md-12">
                    <div class="mt-5">
                        <h3>All Questions: </h3>
                        <ul class="user-list">
                            <?php foreach ($all_question as $question) : ?>
                                <hr class="w-100">
                                <li class="user-list-item d-flex justify-content-center">
                                    <div class="user-info text-end w-75">
                                        <p><strong>Title:</strong> <?php echo $question['title']; ?></p>
                                        <p><strong>Availabnle Until:</strong><?php echo $question['available_until']; ?></p>
                                        <p><strong>This question is for:</strong> <?php echo $question['list_of_users']; ?></p>
                                        <p><strong>Priority:</strong> <?php echo $question['priority']; ?></p>
                                        <p><strong>Author: </strong> <?php echo $question['author']; ?></p>
                                        <p><strong>Category: </strong> <?php echo $question['category']; ?></p>
                                        
                                    </div>
                                    
                                </li>
                                <div class="comments-section d-flex justify-content-center w-100">
                                    <div class="w-75 py-3 mb-3" style="height: 43vh; background: #f2f3f4; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                                        <h4>Comments section</h4>
                                        <hr>
                                        <ul id="comments-list" style="max-height: 190px; overflow-y: auto;" class="list-unstyled text-start" data-question-id="<?php echo $question['question_id']; ?>">
                                    
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center w-100 mt-3 mb-5">
                                    <input class="comment-input" type="text" style="width: 60%; border-radius: 10px; padding-left: 8px;" placeholder="Type here...">
                                    <button  type="button" class="comment-send-btn btn btn-primary ms-5" style="width: 10%;" data-question-id="<?php echo $question['question_id']; ?>">Send</button>
                                </div>
                                <a href="edit-question.php?id=<?php echo $question['question_id']; ?>" class="btn bg-dark text-light edit-btn">Edit<i class="bi bi-pencil-square ms-3"></i></a>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    <script>
$(document).ready(function() {
    // click on send button to start the script
    $(".user-list").on("click", ".comment-send-btn", function() {
        var comment = $(this).prev(".comment-input").val(); // taking comment from right input field
        var questionId = $(this).data("question-id"); // taking Id from right question on which user is commenting
        var senderUsername = "<?php echo $user_data['username']; ?>";
        console.log(questionId);
        console.log(comment);
        // Save a reference to the current element
        var currentElement = $(this);

        // Sending AJAX request for adding comment 
        $.ajax({
            url: "classes/comments_class.php",
            method: "POST",
            data: { senderUsername: senderUsername, comment: comment, questionId: questionId },
           
            success: function(response) {
                // presenting response from comments.php
                console.log(response);

                //Comment successfully added, update the display of comments for the current element.
                currentElement.closest(".user-list-item").next().find(".comments-list").append("<li>" + senderUsername + " said: " + comment + "</li>");
                currentElement.prev(".comment-input").val(""); // Restart input field (set it blank again)
                location.reload();
            },
            error: function() {
                alert("Request got an error.");
            }
        });
    });

    function loadComments() {
    $.ajax({
        type: "GET",
        url: "classes/comments_class.php",
        data: { action: "getAllComments" },
        success: function(response) {
            // Parsing JSON response into a JavaScript object (changing data from JSON into JS)
            var comments = JSON.parse(response);

            // Showing comments foreach post
            $(".comments-section").each(function() {
                var questionId = $(this).find("#comments-list").data("question-id");

                // Filtering comments for right posts
                var postComments = comments.filter(function(comment) {
                    return comment.question_id == questionId;
                });

                // Showing (Displaying) comments for right posts
                var commentsList = $(this).find("#comments-list");
                commentsList.empty(); // Deleting existing comments
                postComments.forEach(function(comment) {
                    commentsList.append("<li class='py-3'>" + comment.sender_username + " : " + comment.comment_content + "<i class='bi bi-trash' data-comment-id='" + comment.comment_id + "' style='float:right;padding-right:10px;color:red;'></i>" + "</li>");
                });

                // Creating click event on trash icon
                commentsList.find("i.bi-trash").on("click", function() {
                    var commentId = $(this).data("comment-id");

                    // Sending AJAX request for deleting a comment
                    $.ajax({
                        url: "classes/comments_class.php",
                        method: "POST",
                        data: { action: "deleteComment", commentId: commentId },
                        success: function(response) {
                            // Displaying response fromcomments_class.php
                            console.log(response);

                            // Removing deleted comment from the post
                            $(this).closest("li").remove();
                            location.reload();
                        },
                        error: function() {
                            alert("Request got an error");
                        }
                    });
                });
            });
        }
    });
}

// "Call the function to load comments when the page is loaded.
loadComments();


});

</script>
</body>
<html>
