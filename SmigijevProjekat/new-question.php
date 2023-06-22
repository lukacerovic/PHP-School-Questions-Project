<?php
    session_start();
    include("classes/connect.php");
    include("classes/login_class.php");
    include("classes/user_class.php");
    include("classes/question_class.php");

    $login = new Login();
    $user_data = $login->check_login($_SESSION['userid']);
    $user = new User();
    $users = $user->get_type_user();
       
    if (!$user_data || ($user_data['usertype'] != 'Manager' && $user_data['usertype'] != 'Admin')) {
        header("Location: login.php");
        die;
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['list_of_users']) && is_array($_POST['list_of_users'])) {
        $list_of_users = $_POST['list_of_users'];
    } else {
        $list_of_users = [];
    }
    
    $question = new Question();
    $result = $question->evaluate($_POST);

    if ($result != "") {
        echo "<div style='width:100%;position:absolute;top:5px;text-align:center;font-size:12px;color:white;background-color:brown;'>";
        echo "<br>The following error occured<br>";
        echo $result;
        echo "<br></div>";
    } 

    $title = $_POST['title'];
    $description = $_POST['description'];
    $available_until = $_POST['available_until'];
    $author = $_POST['author'];
    $priority = $_POST['priority'];
    $category = $_POST['category'];
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
    <title>New User</title>
    <style>
        

    </style>

</head>
<body>
    <div class="container text-dark mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">

                <form method="post" action="">
                    <h2>Create New Question</h2>
                    <hr />
                    <div class="mb-3">
                    <label for="title">Title</label>
                            <input type="text" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                            <label for="description" class="form-label">Question Description</label>
                            <textarea name="description" class="form-control" style="height:40vh;"></textarea>
                        </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            List of Users
                        </label>
                        <?php foreach ($users as $user) { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="list_of_users[]" value="<?php echo $user['username']; ?>">
                                <label class="form-check-label">
                                    <?php echo $user['username']; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Author:
                        </label>
                        <input type="text " name="author" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Available until
                        </label>
                        <input type="datetime-local" name="available_until" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Priority
                        </label>
                        <input type="number" name="priority" class="form-control" max="10"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Type of Subject:
                        </label>
                        <input type="text" name="category" class="form-control" />
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-50 mt-3" style="float:right;">Create a Question</button>
                </form>
            </div>
        </div>
</body>
</html>
