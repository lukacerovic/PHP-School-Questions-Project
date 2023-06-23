<?php

session_start();

    include("classes/connect.php");
    include("classes/login_class.php");
    include("classes/user_class.php");
    include("classes/question_class.php");

    $login = new Login();
    $user_data = $login->check_login($_SESSION['userid']);

    $user = new User();
    $all_users = $user->get_all_users();
        
    $question = new Question();
    $all_question = $question->get_all_questions();

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
    <style>
        .sidebar {
            background-color: #f8f9fa;
            margin-top:20px;
            min-height: 100vh;
            width: 40%;
            position:absolute;
            left:20px;

        }
        .sidebar-right{
            background-color: #f8f9fa;
            margin-top:20px;
            min-height: 100vh;
            width: 40%;
            position:absolute;
            right:20px;
        }

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

        .edit-btn{
            float:right;
            margin-bottom:10px;

        }
    </style>
    <title>Admin page</title>
</head>

<body>
    <div class="col-md-12">
        <div class="content text-center mt-3" style="margin-bottom:10vh;">
            <h1>Hi, <?php echo $user_data['username']; ?></h1>
            <h1>Welcome</h1>
            <h3>This is an <span style="color:green;font-weight:700;">Admin</span> page</h3>
            <br>

            <a href="logout.php" class="btn btn-secondary bg-danger">Logout</a>
        </div>
        
    </div>
    <div class="container p-5 h-75 col-12 bg-dark text-light d-flex justify-content-center align-items-center" style="border-radius:30px;">
        <form method="get" action="filter.php" style="text-align: center; width: 100%;">
            <h2>Filter questions</h2>
            <hr>
            <div class="mb-3">
                <h3 class="py-3">Subjects</h3>
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
                <h3 class="py-3">Assigned Students</h3>
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
        <div class="row">
            <div class="col-md-4">
                <div class="sidebar">
                    <h3>All Users</h3>
                    <span class="btn btn-primary mb-3" style="float:right;"><a style="text-decoration:none;color:white;font-weight:600;" href="new-user.php">Add New User</a><i class="bi bi-plus-circle ms-3"></i></span>
                    <ul class="user-list">
                        <?php foreach ($all_users as $user) : ?>
                            <hr class="w-100">
                            <li class="user-list-item">
                                <div class="user-info">
                                    <p><strong>Name:</strong> <?php echo $user['first_name']; ?></p>
                                    <p><strong>Last Name:</strong> <?php echo $user['last_name']; ?></p>
                                    <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                                    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                                    <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
                                    <p><strong>User Type:</strong> <?php echo $user['usertype']; ?></p>
                                </div>
                                <a href="edit-user.php?id=<?php echo $user['userid']; ?>" class="btn bg-dark text-light edit-btn">Edit<i class="bi bi-pencil-square ms-3"></i></a>
                            </li>
                          
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="sidebar-right">
                    <h3>All Groups Of Questions</h3>
                    
                    <span class="btn btn-primary mb-3" style="float:right;"><a style="text-decoration:none;color:white;font-weight:600;" href="new-question.php">Add New Question</a><i class="bi bi-plus-circle ms-3"></i></span>
                    <ul class="user-list">
                        <?php foreach ($all_question as $question) : ?>
                            <hr class="w-100">
                            <li class="user-list-item">
                                <div class="user-info w-50">
                                    <p><strong>Title:</strong> <?php echo $question['title']; ?></p>
                                    <p><strong>Availabnle Until:</strong><?php echo $question['available_until']; ?></p>
                                    <p><strong>This question is for:</strong> <?php echo $question['list_of_users']; ?></p>
                                    <p><strong>Author</strong> <?php echo $question['author']; ?></p>
                                    <p><strong>Category</strong> <?php echo $question['category']; ?></p>
                                    
                                </div>
                                <a href="edit-question.php?id=<?php echo $question['question_id']; ?>" class="btn bg-dark text-light edit-btn">Edit<i class="bi bi-pencil-square ms-3"></i></a>
                            </li>
                          
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

