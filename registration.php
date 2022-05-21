<?php
require_once "BLL/DbHandler.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/registration.css"> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="registration.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1 class="h1str2">Registration</h1>
            <div class="button">
                <?php
                    echo '<a href="login.php" style="text-decoration: none; font-size: 20px; color:white; position:relative; float: right; margin-right: 40px;">LogIn</a>';
                ?>
            </div>
        </header>
       
        <div id="glavni">
            <form action="registration.php" method="post">
                
                First Name: <input type="text" name="fname" id="fname"><br><br>
                Last Name: <input type="text" name="lname" id="lname"><br><br>
                Email: <input type="email" name="email" id="email"><br><br>
                Password: <input type="password" name="password" id="password"><br><br>
                Birthday Date: <input type="date" name="date" id="date"><br><br>
                Gender: 
                <select name="gender" id="gender">
                    <option value="null">--Choose a gender--</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select><br><br>
                Country: 
                <select name="country" id="country" onchange="prikaziDrzavu()">
                    <option value="null">--Choose a country--</option>
                        <?php
                           
                            $query="SELECT * FROM country";
                            if($rez=mysqli_query($connection,$query)){
                                
                                while($red = mysqli_fetch_assoc($rez)){
                                    echo '<option value='.$red['CountryId'].'>'.$red['CountryName'].'</option>';
                                }
                            }
                            else{
                               
                                echo "Error message:".mysqli_error($connection);
                            }     
                        ?>
                </select>
                <br><br>
                City:
                <select name="city" id="city">
                    <option value="null">--Choose a city--</option>
                </select>
                <br><br><br>
                <button name="sing" id="sing">Register</button><br><br><br>
            </form>
        </div>
    </div>
   
</body>
</html>
<?php
 
 if(isset($_POST['sing'])){
    $status=2;
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $date=$_POST['date'];
    $gender=$_POST['gender'];
    $city=$_POST['city'];

    $query_insert_new_user="CALL RegisterNewUser('$fname','$lname','$email','$password','$date','$gender',$city,$status)";
    //$query_insert_new_user="INSERT INTO user(FirstName,LastName,Email,`Password`,BirthDate,Gender,CityId,StatusId) VALUES('$fname','$lname','$email','$password','$date','$gender',$city,$status)";
    if(mysqli_query($connection,$query_insert_new_user)){
        echo '<script>alert("You have successfully registered")</script>';
    }
    else{
        echo '<script>alert("Error message:"'.mysqli_error($connection).'")</script>';
        echo "Error message:".mysqli_error($connection);
    }
 }
?>