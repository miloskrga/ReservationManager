<?php
session_start();
require_once "BLL/DbHandler.php";
require_once "funkcije.php";
$possition = "home";

if(!login()){
    echo "Morate se ulogovati da bi ste videli ovu stranicu!<br>";
    echo '<a href="login.php">LogIn</a>';
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
    <link rel="stylesheet" href="css/homemain.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="registration.js"></script>  
    <script src="homemain.js"></script>
</head>
<body>
    <?php
       include "includes/navigation.php";
    ?>
    <main class="main-objects">
        <div class="container">
            <div class="row row-objects">
                <?php
        
                if(isset($_GET["subobjecttype"]) && isset($_GET["city"]) && isset($_GET["dolazak"]) && isset($_GET["odlazak"]))
                {
                    $object_type = $_GET["objecttype"];
                    $sub_object_type_id = $_GET["subobjecttype"];
                    $object_country = $_GET["country"];
                    $object_city_id = $_GET["city"];
                    $object_departure = $_GET["odlazak"];
                    $object_arrival = $_GET["dolazak"];
                    $date_in_times = strtotime($object_departure) - strtotime($object_arrival);
                    $date_of_days = round($date_in_times/86400);
                    $_SESSION["dolazak"] = $_GET["dolazak"];
                    $_SESSION["odlazak"] = $_GET["odlazak"];

                    if($object_arrival>date('Y-m-d'))
                    {

                        $query="SELECT * from (SELECT `SubObjectId` from subobject where `SubObjectTypeId`= $sub_object_type_id AND `ObjectId` IN (SELECT `ObjectId` from `object` where `CityId`= $object_city_id)) AS `tmp` where SubObjectId not in (select SubObjectId from reservation where reservation.`FromDate` between '$object_arrival' and '$object_departure' OR reservation.`ToDate` between '$object_arrival' and '$object_departure')";
                        $query_result = mysqli_query($connection, $query);
                        $query_result_count = mysqli_num_rows($query_result);
                        
                        if($query_result_count > 0)
                        {
                            if(!$query_result)
                            {
                                die("Query failed:" .mysqli_connect_error($connection));
                            }
                            else
                            {
                                $niz = array();

                                while($row = mysqli_fetch_assoc($query_result))
                                {
                                    $sub_object_id = $row["SubObjectId"];
                                   

                                    $query_2 = "SELECT * from subobject inner join `object` on subobject.ObjectId = `object`.ObjectId where subobject.SubObjectId = $sub_object_id";
                                    $query_result_2 = mysqli_query($connection, $query_2);
                                    $row_2 = mysqli_fetch_assoc($query_result_2);
        
                                    $sub_object_name = $row_2["SubObjectName"];
                                    $sub_object_image = $row_2["SubObjectImage"];
                                    $object_link = $row_2["ObjectLink"];
                                    $sub_object_link = $row_2["SubObjectLink"];
                                    $sub_object_price = $row_2["Price"];
                                    $sub_object_price_per_days = (int)($sub_object_price * $date_of_days);
                                    ?>
        
                                    <div class="glavni">
                                        <div class="gallery1">
                                            <a target="_self" href="objekti/<?php echo $object_link.$sub_object_link; ?>">
                                                <img src="objekti/<?php echo $object_link.$sub_object_link.$sub_object_image; ?>" alt="<?php echo $sub_object_name; ?>">
                                            </a>
                                            <div class="desc">
                                                <p><b><?php echo $sub_object_name; ?></b></p>
                                                <p><?php echo $sub_object_price_per_days; ?>&euro;</p>
                                            </div>
                                        </div>
                                    </div>
        
                                    <?php
                                   
                                }
                            }
                        }
                        else
                        {
        
                        }
                    }
                    else
                    {
                        echo "Date from must be greater than date to";    
                    }
                    
                }
                else
                {
                        echo "Search for rental facilities";
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>