<?php 

session_start(); // ovo koristimo da bi mogli da koristimo global varijablu $_SESSION koja ce da sadrzi id ulogovanog korisnika

    include("classes/connect.php");
    include("classes/login_class.php");

   
   $email = "";
   $password = "";
   
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $login = new Login();
        $result = $login->evaluate($_POST);

        if($result != ""){

            echo "<div style='width:100%;position:absolute;top:5px;text-align:center;font-size:16px;color:white;background-color:brown;z-index:99999999999999999999;'>";
            echo "<br>The following error occured<br>";
            echo $result;
            echo "</div>";
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        
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
    <title>Admin page</title>
    <style>
        

    </style>

</head>
<body>
    <div class="container text-dark mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">

                <form method="post">
                    <h2>Login.</h2>
                    <hr />
                    
                    <div class="mb-3">
                        <label class="form-label">
                            Email
                        </label>
                        <input value="<?php echo $email ?>" type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Password
                        </label>
                        <input value="<?php echo $password ?>" type="password" name="password" class="form-control" />
                    </div>
                    
                    <button value="Login" type="submit" class="btn btn-primary w-50 mt-3" style="float:right;">Login</button>
                </form>
            </div>
        </div>
</body>
</html>