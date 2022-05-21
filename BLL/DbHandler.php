<?php

  $db['db_host'] = "127.0.0.1";
  $db['db_user'] = "milos_krga";
  $db['db_password'] = "123456";
  $db['db_name'] = "reservation";

  foreach($db as $key => $value)
  {
    define(strtoupper($key), $value);
  }

  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if(!$connection)
  {
    die("Connection failed: " . mysqli_connect_error($connection));
  }
  
/* 
  $connection=mysqli_connect("127.0.0.1","root","","reservation");
  //provera ako ima gresaka prilikom konekcije
  if(mysqli_connect_errno()){
      die ("Neuspela connection sa bazom <br>Poruka o gresci:".mysqli_connect_error());
  } 
*/
    
?>