<?php
    session_start();
    include("classes/connect.php");
    include("classes/signup_class.php");
    include("classes/login_class.php");
    include("classes/user_class.php");
    include("classes/edit_user_class.php");
    
    // Provera da li je korisnik ulogovan
    if (isset($_SESSION['userid']) && is_numeric($_SESSION['userid'])) {
        $id = $_SESSION['userid'];
        $login = new Login();

        $user_data = $login->check_login($id);

        if ($user_data) {
            // Ako je sve u redu, nastavljamo sa prikazom
            //instanciramo klasu User koju smo napravili da prikupi infromacije

            $user = new User();
            $user_info = $user->get_user_current_info($_GET['id']);

            
            if(!$user_data || $user_data['usertype'] != 'Admin')
            {
                header("Location: login.php");
                die;
            }

        } else {
            header('Location: login.php');
            die;
        }
    } 
    else {
        header('Location: login.php');
        die;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        
        $edit = new EditUser(); // kreiranje instance za klasu Signup da bi joj pristupili
        $result = $edit->evaluate($_POST, $_GET['id']); //metoda iz klase Signup
        if($result != "")
        {

            echo "<br><div style='text-align:center; font-size:15px; color:white; background-color:red;'>";
            echo "The following error occured:<br><br>";
            echo $result;
            echo "</div>";
        }
        else
        {

            //ako je sve okej, radi se preusmeravanje
            header('Location: admin.php');
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
    <title>New User</title>
    <style>
        

    </style>

</head>
<body>
    <div class="container text-dark mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">

                <form method="post" action="">
                    <h2>Edit <span class="bg-danger text-light" style="padding:3px 8px; border-radius:5px;"><?php echo $user_info['username'];?></span></h2>
                    <hr />
                    <div class="mb-3">
                        <label class="form-label">Select User Type</label>
                        <select name="usertype" class="form-control text-dark">
                            <option><?php echo $user_info['usertype']; ?></option>
                            <option>User</option>
                            <option>Manager</option>
                            <option>Admin</option>
                       
                        </select>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="first-name">First name:</label>
                            <input value="<?php echo $user_info['first_name']; ?>" type="text" name="first_name" class="form-control" id="first-name" asp-for="Input.Name">
                        </div>
                        <div class="col">
                            <label for="last-name">Last name:</label>
                            <input value="<?php echo $user_info['last_name']; ?>" type="text" name="last_name" class="form-control" id="last-name" asp-for="Input.LastName">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            User Name
                        </label>
                        <input value="<?php echo $user_info['username']; ?>" type="text" name="username" id="username" class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Email
                        </label>
                        <input value="<?php echo $user_info['email']; ?>" type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Password
                        </label>
                        <input type="password" value="<?php echo $user_info['password']; ?>" name="password" id="password" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Retype Password
                        </label>
                        <input type="password" value="<?php echo $user_info['password']; ?>" name="password2" id="password" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Phone Number
                        </label>
                        <input value="<?php echo $user_info['phone']; ?>" type="number" name="phone" id="phone" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Date of Birth
                        </label>
                        <input value="<?php echo $user_info['date_of_birth']; ?>" type="date" name="date_of_birth" id="date" class="form-control"  />
                    </div>
                    <button type="submit" class="btn btn-primary w-50 mt-3" style="background:green;float:right;">Update</button>
                </form>
            </div>
        </div>
</body>
</html>
