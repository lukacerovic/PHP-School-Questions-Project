<?php


class Database
{

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "stefanov_projekat_db";

    function connect()
    {

        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);
        return $connection;
    }

    function read($query)
    {
        $conn = $this->connect(); //ukljucujes connect funkciju u read funkciju
        $result = mysqli_query($conn, $query);

        if(!$result)
        {
            return false;
        }
        else
        {
            $data = false; 
            while($row = mysqli_fetch_assoc($result))
            {
                $data[] = $row; // ovde sam stavio ako bude bilo vise rezultata da se onda belezi u varijabli data koja ce biti 'array';
            }
            return $data;
        }
    }

    function save($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if(!$result)
        {
            return false;
        }
        else
        {
            return true;
        }
        
    }
}



//Ne znam da li treba da se admin napravi manualno u bazi podataka ili treba da se namesti inicijalno kroz kod
//ili da se in on moze napraviti klasicnom registracijom


//Postavljanje admina:
//$first_name = "stefan";
//$last_name = "suvajcevic";
//$user_name = "stefan-admin1";
//$email = "stefanadmin@gmail.com";
//$password = "admin12345";
//$phone = "+381 60 6016420";
//$date_of_birth = "2000-04-16";
//$usertype = "admin";

//proveri da li si u kreiranju baze u phpmyadminu stavio za polje id da bude autoincrement (AI checkbox da selektujes)

//formiranje upita za ubacivanje admina u bazu:
//vrednosti varijabli stavljas da budu pod navodnicima (stavljas jedne navodnike a ne duple jer duple vec koristis za sql upit) jer su vrednostni reci a ne brojevi)
//$admin = "INSERT INTO users (first_name, last_name, username, email, password, phone, date_of_birth, usertype) 
          //VALUES ('$first_name', '$last_name', '$username', '$email', '$password', '$phone', '$date_of_birth', '$usertype') limit 1";

//izvrsavanje funkcije:
//mysqli_query($connection, $admin);
