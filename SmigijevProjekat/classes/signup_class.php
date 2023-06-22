<?php 

class Signup
{
    private $error = ""; //private variable za vracanje ako je napravljena greska prilikom registracije.
    
    public function evaluate($data) //$data ce biti tip array jer je $_POST koji prosledjujemo iz registracije tipa array.Zato dole i mozes da koristis foreach
    {
        foreach ($data as $key => $value) //radis foreach petlju da proveris svaki kljuc i njenu vrednost iz registracije
        {
            if(empty($value))
            {
                $this->error = $this->error . $key . " is empty<br>"; 
                
            }
            if($key == "email"){
                    
                if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)){
                    $this->error = $this->error . "Please enter a valid email adress<br>";
                }

                $DB=new Database();
                $email = $_POST['email'];
                $query = "SELECT email FROM users WHERE email = '$email' ";
                $check = $DB->read($query);
                
                if($check > 0){
                    $this->error = $this->error . "This email is already in use<br>";
                }

               
            }
            if($key == "username"){
               
                $DB=new Database();
                $username = $_POST['username'];
                $query = "SELECT username FROM users WHERE username = '$username' ";
                $check = $DB->read($query);
                
                if($check > 0){
                    $this->error = $this->error . "This username is already in use<br>";
                }

               
            }
            if($key == "first_name"){
                if (is_numeric($value)){
                    $this->error = $this->error . "first name cant be number<br>";
                }
                if (strstr($value, " ")){
                    $this->error = $this->error . "first name cant have spaces<br>";
                }
            }
            if($key == "last_name"){
                if (is_numeric($value)){
                    $this->error = $this->error . "last name cant be number<br>";
                }
                if (strstr($value, " ")){
                    $this->error = $this->error . "last name cant have spaces<br>";
                }
            }
            if($key == "password"){
                if($_POST['password'] != $_POST['password2']){
                    $this->error = $this->error . "Your password are not same<br>";
                }
            }
        }
        if($this->error == "")
        {
            //bez greske je registracija
            $this->create_user($data); // pozivamo funkciju create_user
        }
        else
        {
            return $this->error;
        }
    }

    public function create_user($data)
    {
        $first_name = ucfirst($data['first_name']); // stavlja da prvo slovo uvek bude Veliko
        $last_name = ucfirst($data['last_name']);
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];
        $phone = $data['phone'];
        $date_of_birth = $data['date_of_birth'];
        if($data['usertype'] == "") //ovo se ubacilo da bi mogao da koristis isti ovaj kod i za adminovu funkciju dodavanja korisnika
        {
            //jedina razlika obicne reg i adminovog dodavanja je sto admin moze da postavlja user type.Zato si ubacio ovu proveru z apostavljanja vrednosti usertype

            //Na obicnoj registraciji nema mogucnost da se postavlja usertype tako da ce biti ucek user postavljena vrednost.
            $usertype = "User";
        }
        else
        {
            $usertype = $data['usertype'];
        }
        

        //pravimo nasu kreiranu funkciju za postavljanje random selekcije brojeva, kao sto je u asp.net postoji Guid ID
        $userid = $this->create_userid(); //koristis $this-> jer je create_userid private funkcija


        $query = "INSERT INTO users 
        (userid, first_name, last_name, username, email, password, phone, date_of_birth, usertype)
        VALUES 
        ('$userid', '$first_name', '$last_name', '$username', '$email', '$password', '$phone', '$date_of_birth', '$usertype')";

       
        $DB = new Database(); //kreiramo instancu Database klase iz connect.php
        $DB->save($query); // preko instance pozivamo metodu save iz Databse klase i prosledjujemo joj $query koji ona ocekuje u klasi Database
    }

    private function create_userid()
    {
        $length = rand(4, 19); //random duzina koju ce php da izabere izmedju brojeva 4 i 19;
        $number = "";
        for ($i=0; $i < $length; $i++)  
        {
            $new_rand = rand(0,9);
            $number = $number . $new_rand;
        }
        return $number;
    }
}