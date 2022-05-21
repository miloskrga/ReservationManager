<?php
session_start();
require_once "BLL/DbHandler.php";
require_once("funkcije.php");
$possition = "";

if(isset($_GET['odjava'])){
    logout(); 
}

if(!login()){
    echo "Morate se prijaviti da bi ste videli ovu stranicu!<br>";
    echo '<a href="login.php">Prijavi se</a>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/profile.css"> 


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="registration.js"></script>
</head>
<body>
    <?php
       include "includes/navigation.php";
    ?>
    <main>
        <div class="container">
            <div class="glavni" >
                <div style="width: 70%; position: relative; margin-left: auto; margin-right: auto; ">
                    <div class="personal-information">
                        <?php
                        $query_select_user_inf="SELECT * from `user` Where UserId=$id_user";
                        $query_select_user_inf_result=mysqli_query($connection, $query_select_user_inf);
                        $query_select_user_inf_result_count = mysqli_num_rows($query_select_user_inf_result);

                        if($query_select_user_inf_result_count > 0)
                        {
                            if(!$query_select_user_inf_result)
                            {
                                die("Query failed: ". mysqli_connect_error($connection));
                            }
                            else
                            {
                                $row = mysqli_fetch_assoc($query_select_user_inf_result);
                                $user_first_name=$row['FirstName'];
                                $user_last_name=$row['LastName'];
                                $user_email=$row['Email'];
                                $user_password=$row['Password'];    
                            }
                        }
                        ?>
                        <br><br>
                        <h2 style="color: blue;">Personal Information</h2>
                        <br><br>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" >
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" id="fname" placeholder="Unesite ime" value="<?php echo $user_first_name; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" id="lname" placeholder="Unesite prezime" value="<?php echo $user_last_name; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="fname">Email</label>
                                <input type="email" name="email" id="email" placeholder="Unesite email" value="<?php echo $user_email; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="Unesite lozinku" value="<?php echo $user_password; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <select name="edit-city" id="city">
                                    <?php
                                    //enctype="multipart/form-data" kada saljem sliku
                                    $query_select_city = "SELECT * FROM city";
                                    $query_select_city_result = mysqli_query($connection, $query_select_city);

                                    if(!$query_select_city_result)
                                    {
                                        die("Query failed: ". mysqli_connect_error($connection));
                                    }
                                    else
                                    {
                                        while($row = mysqli_fetch_assoc($query_select_city_result))
                                        {
                                            $id_city = $row["CityId"];
                                            $name_city = $row["CityName"];
                                            ?>

                                            <option value="<?php echo $id_city ?>" <?php if($id_city == $id_city){ echo "selected"; } ?>><?php echo $name_city ?></option>

                                            <?php
                                        }
                                    }
                                    
                                    ?>
                                </select>
                            </div>
                                <button type="submit" name="submit">Change</button>
                        </form>
                    </div>
                </div>
                <?php
                if(isset($_POST['submit'])){

                    $fname=$_POST['fname'];
                    $lname=$_POST['lname'];
                    $email=$_POST['email'];
                    $password=$_POST['password'];
                    $city=$_POST['edit-city'];

                    "UPDATE user SET FirstName=$fname, LastName=$lname, Email=$email, `Password`=$password, CityId=$city WHERE UserId=$id_user";
                    $query=mysqli_query($connection,$query);

                    if(!$query)
                    {
                        die('Query failed: ' . mysqli_connect_error($connection));
                    }
                    else
                    { 
                        echo"<p style='text-align: center;'><b>Uspesno ste promenili podatke!</b></p>";
                    }
                }    
            ?>
            </div>
        </div>
     <!--  <div class="container">
            <div style="max-width: 1100px; margin-left: auto; margin-right: auto; margin-top: 4rem;">
                <h2 style="color: blue; text-align: center;">My Reservation</h2>
                <table class="table-reservation">
                    <thead>
                        <tr>
                            <th>Reservation number</th>
                            <th>Object</th>
                            <th>Subobject</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Number of days</th>
                            <th>Price</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody id="delay-reservation-result">
                    <?php
                       /* $query_select_reservation = "SELECT * FROM reservation INNER JOIN subobject ON reservation.SubObjectId = subobject.SubObjectId INNER JOIN `object` ON subobject.ObjectId = `object`.ObjectId WHERE reservation.UserId = $id_user";
                        $query_select_reservation_result = mysqli_query($connection, $query_select_reservation);        
                        $summary_number=0;
                        if(!$query_select_reservation_result)
                        {
                            die("Query failed: " . mysqli_connect_error($connection));
                        }
                        else
                        {
                            while($row = mysqli_fetch_assoc($query_select_reservation_result))
                            {
                                $id_reservation = $row["ReservationId"];
                                $sub_object_name = $row["SubObjectName"];
                                $object_name = $row["ObjectName"];
                                $date_from = $row["FromDate"];
                                $date_to = $row["ToDate"];
                                $price = $row["Price"];
                                $date_in_times = strtotime($date_to) - strtotime($date_from);
                                $date_of_days = round($date_in_times/86400);
                                ?>

                                <tr>
                                    <td><?php echo $id_reservation; ?></td>
                                    <td><?php echo $object_name; ?></td>
                                    <td><?php echo $sub_object_name; ?></td>
                                    <td><?php echo $date_from; ?></td>
                                    <td><?php echo $date_to; ?></td>
                                    <td><?php echo $date_of_days; ?></td>
                                    <td><?php echo (int)($total_price=$date_of_days * $price); ?></td>
                                    <?php
                                    $summary_number+=$total_price;
                                    if($date_to > date("Y-m-d"))
                                    {
                                        echo "<td><button onclick='delay($id_reservation);'>Delete</button></td>";
                                    }
                                    else
                                    {
                                        echo "<td><b>Run out</b></td>";
                                    }

                                    ?>
                                </tr>
                               

                                <?php
                            }
                        }
                        
                */
                    ?>
                        <tr style="background-color: #605f5f;">
                            <td style="padding: 0.5rem;" colspan="5"></td>
                            <td style="padding: 0.5rem;"><b style="color: #fff;">SUM</b></td>
                            <td style="padding: 0.5rem; color: #fff;"><?php //echo $summary_number;?></td>
                        </tr>
                    </tbody>
                </table>
                <div id="reservation-result-message"></div>
            </div>
        </div>--> 
    </main>
        
    <script>
             /*  
    function delay(e)
    {
        var id_reservation = e;
        var form_data = new FormData();
        form_data.append("id-reservation", id_reservation);
        
        var ajax = new XMLHttpRequest();

        ajax.onload = function()
        {
            var array_result = this.responseText.split("~");
            document.getElementById("delay-reservation-result").innerHTML = array_result[0];
            document.getElementById("reservation-result-message").innerHTML = array_result[1];
        }
        ajax.open("POST", "delay-reservation.php", true);
        ajax.send(form_data);
    }
*/
    </script>
</body>
</html>
