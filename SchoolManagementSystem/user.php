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
            
            //Regular users can only see the questions intended for them. They cannot see all the questions or other users.
            //Additionally, they cannot make any changes.
            
            $question = new Question();
            $all_question = $question->get_all_questions_for_user($user_data['username']);
    
            if(!$user_data)
            {
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $set_finished = $question->set_finished($_POST['question_id'], $user_data['username']);

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
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
                    <p>this is an user page</p>
                    
                    <a href="logout.php" class="btn btn-secondary bg-danger mb-3">Logout</a>
                </div>
            </div>
            <div class="container p-5 h-75 col-12 bg-dark text-light d-flex justify-content-center align-items-center" style="border-radius:30px;">
                <form method="get" action="filter.php" style="text-align: center; width: 100%;">
                    <h2>Filter questions</h2>
                    <hr>
                    <div class="mb-3">
                        <h3 class="py-3">Subject</h3>
                        <div class="filter" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                        <?php foreach ($all_question as $question) : ?>
                                <label>
                                    <input type="checkbox" name="category[]" value="<?php echo $question['category']; ?>">
                                    <p><?php echo $question['category']; ?></p>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h3 class="py-3">Priority</h3>
                        <div class="filter" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                            <?php foreach ($all_question as $question) : ?>
                                <label>
                                    <input type="checkbox" name="priority[]" value="<?php echo $question['priority']; ?>">
                                    <p><?php echo $question['priority']; ?></p>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h3 class="py-3">Date of Ending</h3>
                        <div class="filter" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                            <?php foreach ($all_question as $question) : ?>
                                <label>
                                    <input type="checkbox" name="available_until[]" value="<?php echo $question['available_until']; ?>">
                                    <p><?php echo $question['available_until']; ?></p>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h3 class="py-3">Assigned Users</h3>
                        <div class="filter" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                        <?php foreach ($all_question as $question) : ?>
                                <label>
                                    <input type="checkbox" name="list_of_users[]" value="<?php echo $question['list_of_users']; ?>">
                                    <p><?php echo $question['list_of_users']; ?></p>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <hr>
                    <div style="text-align: center;">
                        <input id="post-button" type="submit" value="Submit Results" style="background: gray; border: 1px solid gray; border-radius: 10px; padding: 5px 8px; color: white; cursor: pointer;">
                    </div>
                </form>
            </div>

            <div class="container">
                <div class="col-md-12">
                    <div class="mt-5">
                        <h3>All Questions Related To You: </h3>
                        <ul class="user-list">
                            <?php foreach ($all_question as $question) : ?>
                                <hr class="w-100">
                                <li class="user-list-item d-flex justify-content-center">
                                    <div class="user-info text-end w-75">
                                        <p><strong>Title:</strong> <?php echo $question['title']; ?></p>
                                        <p><strong>Availabnle Until:</strong><?php echo $question['available_until']; ?></p>
                                        <p><strong>Author</strong> <?php echo $question['author']; ?></p>
                                        <p><strong>Category</strong> <?php echo $question['category']; ?></p>
                                        <form method="post">
                                            <?php
                                                $isFinishedBy = json_decode($question['is_finished_by'], true);
                                                if (isset($isFinishedBy[$user_data['username']]) && $isFinishedBy[$user_data['username']] === false) {
                                            ?>
                                                <button class="btn btn-primary my-3" type="submit" name="question_id" value="<?php echo $question['question_id']; ?>" style="margin-left: 10px;">Kliknite dugme ako ste zavrsili zadatak</button>
                                            <?php } else { ?>
                                                <button class="btn btn-success" style="margin-left: 10px;">Čestitam, uradili ste ovaj zadatak <i class="bi bi-hand-thumbs-up-fill px-3"></i></button>
                                            <?php } ?>
                                        </form>
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
                                
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       
    </div>

    <script>
$(document).ready(function() {
    // Click on send button for sending comment
    $(".user-list").on("click", ".comment-send-btn", function() {
        var comment = $(this).prev(".comment-input").val(); // Taking input value from right input tag
        var questionId = $(this).data("question-id"); // Taking Id from right question
        var senderUsername = "<?php echo $user_data['username']; ?>";
        console.log(questionId);
        console.log(comment);
        
        var currentElement = $(this);

        // Sending AJAX request for adding a comment
        $.ajax({
            url: "classes/comments_class.php",
            method: "POST",
            data: { senderUsername: senderUsername, comment: comment, questionId: questionId },
           
            success: function(response) {
                // Ispisujemo odgovor koji smo dobili od comments.php
                console.log(response);

                // Comment successfully added, update the display of comments for the current element.
                currentElement.closest(".user-list-item").next().find(".comments-list").append("<li>" + senderUsername + " said: " + comment + "</li>");
                currentElement.prev(".comment-input").val(""); // Restarting input field (setting blank)
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
            // Parsing JSON response into a JavaScript object. (changing data from JSON to JS)
            var comments = JSON.parse(response);

            //Showing comments foreach question
            $(".comments-section").each(function() {
                var questionId = $(this).find("#comments-list").data("question-id");

                // Filtering right comments for right question
                var postComments = comments.filter(function(comment) {
                    return comment.question_id == questionId;
                });

                // Showing (Displaying) right comments for right question
                var commentsList = $(this).find("#comments-list");
                commentsList.empty(); // 
                postComments.forEach(function(comment) {
                    commentsList.append("<li class='py-3'>" + comment.sender_username + " : " + comment.comment_content + "</li>");
                });

                
            });
        }
    });
}

//Parsing JSON response into a JavaScript object
loadComments();


});

</script>

</body>
<html>
