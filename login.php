<?php

session_start();
require_once "BLL/DbHandler.php";
require_once "funkcije.php";

if(isset($_GET['odjava'])){
    logout();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css"> 

    
</head>
<body>
    <header>
        <h1>Log In</h1>
        <div class="button">
            <?php
                echo '<a href="main.php" style="text-decoration: none; font-size: 20px; color:white; position:relative; float: right; margin-right: 40px;">Reservation Manager</a>';
            ?>
        </div>
    </header>
        
    <main>
        <div class="glavni">
            <div class="forma">
                <h2>Log In</h2>
                <form action="login.php" method="post">
                    <div class="Email">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    </div><br>
                    <div class="Password">
                        <label for="pwd" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
                    </div><br>
                    <div class="Remember">
                        <label class="form-check-label">
                        <input type="checkbox" name="remember" id="remember"> Remember me
                        </label>
                    </div><br>
                    <button  name="submit1" >LogIn</button><br><br>
                    <?php
                        if(isset($_POST['submit1']))
                        {
                            $email=$_POST['email'];
                            $password=$_POST['pwd'];

                            $upit="CALL LoginUser('".$email."','".$password."')";
                            $upit_result = mysqli_query($connection, $upit);
                            $upit_result_count = mysqli_num_rows($upit_result);

                            if($upit_result_count > 0)
                            {
                                if(!$upit_result)
                                {
                                    die("Query failed: ".mysqli_connect_error($connection));
                                }
                                else
                                {
                                    while($row = mysqli_fetch_assoc($upit_result))
                                    {
                                        $id_user = $row["UserId"];
                                        $email = $row["Email"];
                                        $password = $row["Password"];
                                        $status=$row["StatusId"];
                                        $first_name=$row["FirstName"];
                                        $last_name=$row["LastName"];
                                    }

                                    $_SESSION["id_user"] = $id_user;
                                    $_SESSION["FirstName"] = $first_name;
                                    $_SESSION["LastName"] = $last_name;

                                    if($status==3)
                                    {
                                        header("Location: admin/index.php");
                                    }
                                    else
                                    {
                                        
                                        if(isset($_POST['remember'])){
                                            setcookie("id_user",$id_user,time()+8400,"/");
                                        }

                                        header("Location: homemain.php");
                                    }

                                }
                            }
                            else
                            {
                                echo "Email or password is incorrect.";
                            }
                        }
                    ?>
                </form>
            </div>                  
        </div>
    </main>
</body>
</html>

