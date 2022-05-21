<?php 

session_start();
require_once "BLL/DbHandler.php";
require_once "funkcije.php";
$possition = "";

$id_user = $_SESSION["id_user"];
$query_select_user = "SELECT * FROM user WHERE UserId = $id_user";
$query_select_user_result = mysqli_query($connection, $query_select_user);

if(!$query_select_user_result)
{
    die("Query failed:" .mysqli_connect_error($connection));
}
else
{
    while($row = mysqli_fetch_assoc($query_select_user_result))
    {
        $first_name = $row["FirstName"];
        $last_name = $row["LastName"];
        $status_id = $row["StatusId"];
    }
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
    <link rel="stylesheet" href="css/makeoffer.css">

    <style>

    table, tr, td, th{
        border: 1px solid black;
        text-align: center;
    }

    .filter-form{
        display: flex;
    }

    .filter-form .form-input{
        margin-left: 1.5rem;
    }

    .filter-form .form-input label{
        padding-right: 0.5rem;
    }

    .filter-form .form-input:first-child{
        margin-left: 0;
    }

    </style>
</head>
<body>
    <?php require_once "includes/navigation.php"; ?>
    <main>
        <div class="container">   
            <div style="margin-top: 4rem; margin-bottom: 4rem;" class="owner-informations">
                <h2><?php echo $first_name." ".$last_name; ?></h2>
            </div>
            <div class="filter-objects">
                <div class="filter-form">
                    <div class="form-input">
                        <label for="">From Date</label>
                        <input type="date" id="date-from">
                    </div>
                    <div class="form-input">
                        <label for="">To Date</label>
                        <input type="date" id="date-to">
                    </div>
                    <div class="form-input">
                        <label for="">Object Type</label>
                        <select name="" id="type-objects">
                            <option value="null">Choose</option>
                            <?php 
                            
                            $query_select_object = "SELECT * FROM objecttype";
                            $query_select_object_result = mysqli_query($connection, $query_select_object);

                            if(!$query_select_object_result)
                            {
                                die("Query failed:" .mysqli_connect_error($connection));
                            }
                            else
                            {
                                $row_counter = mysqli_num_rows($query_select_object_result);   

                                if($row_counter > 0)
                                {
                                    while($row = mysqli_fetch_assoc($query_select_object_result))
                                    {
                                        $id_object_type = $row["ObjectTypeId"];
                                        $name_object_type = $row["ObjectTypeName"];
                                        ?>

                                        <option value="<?php echo $id_object_type; ?>"><?php echo $name_object_type; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    echo "<p>There are no sub-items for the selected criteria.</p>";
                                }
                            }
                            
                            ?>
                        </select>
                        <button type="button" onclick="filterInformation();">Submit</button>
                    </div>
                </div>
            </div>
            <div id="wrapper-table-filter" style="margin-bottom: 4rem;">
            <?php 
                if($status_id==1)
                {
                    ?>
               
                <p>Your ads:</p>                
                    
                <?php
                $query_select_object = "SELECT * FROM `object` INNER JOIN objecttype ON `object`.ObjectTypeId = objecttype.ObjectTypeId INNER JOIN city ON `object`.CityId = city.CityId INNER JOIN country ON city.CountryId = country.CountryId WHERE `object`.UserId = $id_user";
                $query_select_object_result = mysqli_query($connection, $query_select_object);

                if(!$query_select_object_result)
                {
                    die("Query failed:" .mysqli_connect_error($connection));
                }
                else
                {
                    $sub_obects_total_price = 0;
                    $row_counter = mysqli_num_rows($query_select_object_result);

                    if($row_counter > 0)
                    {
                        ?>

                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Country</th>
                                </tr>
                            </thead>
                            <tbody>

                        <?php
                        while($row = mysqli_fetch_assoc($query_select_object_result))
                        {
                            $id_object = $row["ObjectId"];
                            $name_object = $row["ObjectName"];
                            $image_object = $row["ObjectImage"];
                            $address = $row["Address"];
                            $type_object_name = $row["ObjectTypeName"];
                            $city_name = $row["CityName"];
                            $country_name = $row["CountryName"];
                            $link_object = $row["ObjectLink"];
                            ?>                            
                            <tr>
                                <th><img style="display: block; width: 5.5rem; height: 4rem; object-fit: cover; margin-left: auto; margin-right: auto; padding: 0.5rem;" src="objekti/<?php echo $link_object.$image_object; ?>" alt=""></th>
                                <th style="padding: 0.5rem;"><?php echo $type_object_name;?></th>
                                <th style="padding: 0.5rem;"><?php echo $name_object;?></th>
                                <th style="padding: 0.5rem;"><?php echo $address;?></th>
                                <th style="padding: 0.5rem;"><?php echo $city_name;?></th>
                                <th style="padding: 0.5rem;"><?php echo $country_name;?></th>
                                <?php 
                                
                                $query_select_subobject = "SELECT * FROM subobject INNER JOIN subobjecttype on subobject.SubObjectTypeId = subobjecttype.SubObjectTypeId WHERE subobject.ObjectId = $id_object";
                                $query_select_subobject_result = mysqli_query($connection, $query_select_subobject);

                                if(!$query_select_subobject_result)
                                {
                                    die("Query failed:" .mysqli_connect_error($connection));
                                }
                                else
                                {
                                    $row_counter = mysqli_num_rows($query_select_subobject_result);

                                    if($row_counter > 0)
                                    {                                           
                                        while($row = mysqli_fetch_assoc($query_select_subobject_result))
                                        {
                                            $image_subobject=$row["SubObjectImage"];
                                            $id_sub_object = $row["SubObjectId"];
                                            $name_sub_object = $row["SubObjectName"];
                                            $price = $row["Price"];
                                            $link_subobject=$row["SubObjectLink"];
                                            $subobject_type=$row["SubObjectTypeName"];

                                            ?>
                                            <tr style='background-color: #a1e2f3;'>
                                                <td><img style="display: block; width: 5.5rem; height: 4rem; object-fit: cover; margin-left: auto; margin-right: auto; padding: 0.5rem;" src="objekti/<?php echo $link_object.$link_subobject.$image_subobject; ?>" alt=""></td>
                                                <td style="padding: 0.5rem;"><?php echo $subobject_type; ?></td>
                                                <td style="padding: 0.5rem;"><?php echo $name_sub_object; ?></td>
                                                <td style="padding: 0.5rem;"></td>
                                                <td style="padding: 0.5rem;"></td>
                                                <td style="padding: 0.5rem;"></td>
                                            <?php
                                                $date=date('Y-m-d');
                                                $query_select_reservation="SELECT * from `reservation` where SubObjectId=$id_sub_object and ToDate < '$date'";
                                                $query_select_reservation_result = mysqli_query($connection, $query_select_reservation);
                                                $row_counters=0;
                                                $day_counters=0;
                                                $date_of_days=0;
                                                

                                                if(!$query_select_reservation_result)
                                                {
                                                    die("Query failed:" .mysqli_connect_error($connection));
                                                }
                                                else
                                                {
                                                    $row_counters=mysqli_num_rows($query_select_reservation_result);

                                                    if($row_counters>0)
                                                    {
                                                        while($row=mysqli_fetch_assoc($query_select_reservation_result))
                                                        {
                                                            $from_date=$row["FromDate"];
                                                            $to_date=$row["ToDate"];
                                                            $date_in_times = strtotime($to_date) - strtotime($from_date);
                                                            $date_of_days += round($date_in_times/86400);
                                                            $total_price=$date_of_days*$price;
                                                            $sub_obects_total_price += $total_price;
                                                        }
                                                    }
                                                }
                                            ?>
                                        
                                                
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                
                                ?>
                            </tr>

                            <?php
                        }
                        ?>

                            </tbody>
                           
                        </table>

                        <?php
                    }
                    else
                    {
                        echo "<p>No ads available.</p>";
                    }
                   
                }
                ?>

            </div>
            <?php 
                }
            ?>
            <div style="margin-bottom: 4rem;">    
            </div>
        </div>
    </main>

    <script src="js/functions.js"></script>
</body>
</html>