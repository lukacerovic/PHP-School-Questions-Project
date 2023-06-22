<?php
// Povezivanje sa bazom podataka i ostale potrebne konfiguracije
session_start();

    include("classes/connect.php");
    include("classes/login_class.php");
    include("classes/user_class.php");
    include("classes/question_class.php");
    include("classes/filter_class.php");


    // Provera da li je forma submitovana i da li su odabrani korisnici
    if (isset($_GET)) {
        
        $filter = new Filter();
        $results = $filter->find_results($_GET);
      
        if(!$results)
        {
            echo "<div style='width:100%;position:absolute;top:40%;text-align:center;font-size:24px;color:black;z-index:99999999999999999999;'>";
            echo "<br>There is no records of that filter<br>";
            echo "</div>";
            die;
        }
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
                    <h1>Welcome</h1>
                    <h3>This is your filtered result</h3>
                    <br>
                </div>
            </div>
            <div class="container">
                <div class="col-md-12">
                    <div class="mt-5">
                        <h3>Filtered Questions: </h3>
                        <ul class="user-list">
                            <?php foreach ($results as $question) : ?>
                                <hr class="w-100">
                                <li class="user-list-item d-flex justify-content-center">
                                    <div class="user-info text-end w-75">
                                        <p><strong>Title:</strong> <?php echo $question['title']; ?></p>
                                        <p><strong>Availabnle Until:</strong><?php echo $question['available_until']; ?></p>
                                        <p><strong>This question is for:</strong> <?php echo $question['list_of_users']; ?></p>
                                        <p><strong>Priority:</strong> <?php echo $question['priority']; ?></p>
                                        <p><strong>Author: </strong> <?php echo $question['author']; ?></p>
                                        <p><strong>Category: </strong> <?php echo $question['category']; ?></p>
                                        <p><strong>Created Date and Time:</strong> <?php echo $question['created_date']; ?></p>
                                        
                                    </div>
                                    
                                </li>
                                <a href="edit-question.php?id=<?php echo $question['question_id']; ?>" class="btn bg-dark text-light edit-btn">Edit<i class="bi bi-pencil-square ms-3"></i></a>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</body>
<html>

