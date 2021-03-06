<?php
 //   define('db_server', 'localhost');
  //  define('db_name1', 'root');
   // define('db_pass', '');
    //define('db_studentnumber1', 'attendance');

  //  $link = mysqli_connect(db_server, db_name1, db_pass, db_studentnumber1);

 //   if ($link === false) {
 //       die('Error: Could not connect . ' . mysqli_connect_error());
 //   }
//     $dbhost = "localhost: 3306";
//     $dbuser = "root";
//     $dbpass = "";
//     $dbname = "login";
    

//     if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname))
//     {

//         die("failed to connect!");
//     }
 


	$link = new mysqli('localhost', 'root', '', 'attendance') or die(mysqli_error());