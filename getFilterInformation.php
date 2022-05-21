<?php

    session_start();
    require_once "BLL/DbHandler.php";
    require_once "funkcije.php";
    $possition = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["date-from"]) && isset($_POST["date-to"]) && isset($_POST["type-object"]))
        {
            
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

            $d_from = $_POST["date-from"];
            $d_to = $_POST["date-to"];
            $type_object = $_POST["type-object"];

            $condition = "";
            if($type_object != "*")
            {
                $condition = "AND objecttype.ObjectTypeId = $type_object";
            }




            ?>
            <div id="wrapper-table-filter" style="margin-bottom: 4rem;">
            <?php 
            if($status_id==1)
            {
                ?>
               
                <p>Your ads:</p>                
                    
                <?php
                $query_select_object = "SELECT DISTINCT `object`.ObjectId, `object`.ObjectImage, `object`.ObjectName, objecttype.ObjectTypeName, `object`.`Address`, `object`.ObjectLink ,CityName, CountryName from `object` RIGHT join subobject on `object`.ObjectId=subobject.ObjectId inner join city on `object`.CityId=city.CityId inner join country on city.CountryId=country.CountryId inner join objecttype on `object`.ObjectTypeId=objecttype.ObjectTypeId where subobject.SubObjectId in(select reservation.SubObjectId from reservation where reservation.FromDate and reservation.ToDate BETWEEN '$d_from' and '$d_to') and objecttype.ObjectTypeId=$type_object and object.UserId=$id_user ORDER BY `object`.ObjectId";
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
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Reserve days</th>
                                    <th>Total price</th>
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
                                <th></th>
                                <th></th>
                                <?php 
                                
                                $query_select_subobject = "SELECT * from reservation inner join subobject on reservation.SubObjectId=subobject.SubObjectId inner join subobjecttype on subobject.SubObjectTypeId=subobjecttype.SubObjectTypeId where reservation.FromDate and reservation.ToDate BETWEEN '$d_from' and '$d_to' and subobject.ObjectId=$id_object";
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
                                            $id_reservation=$row["ReservationId"];

                                            ?>
                                            <tr style='background-color: #a1e2f3;'>
                                                <td><img style="display: block; width: 5.5rem; height: 4rem; object-fit: cover; margin-left: auto; margin-right: auto; padding: 0.5rem;" src="objekti/<?php echo $link_object.$link_subobject.$image_subobject; ?>" alt=""></td>
                                                <td style="padding: 0.5rem;"><?php echo $subobject_type; ?></td>
                                                <td style="padding: 0.5rem;"><?php echo $name_sub_object; ?></td>
                                                <td style="padding: 0.5rem;"></td>
                                                <td style="padding: 0.5rem;"></td>
                                                <td style="padding: 0.5rem;"></td>
                                            <?php
                                                $query_select_reservation="SELECT * from `reservation` where Reservationid=$id_reservation";
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
                                                            $tmp_date1=strtotime($from_date);
                                                            $date_from=date("d-m-Y",$tmp_date1);
                                                            $to_date=$row["ToDate"];
                                                            $tmp_date2=strtotime($to_date);
                                                            $date_to=date("d-m-Y",$tmp_date2);
                                                            $date_in_times = strtotime($to_date) - strtotime($from_date);
                                                            $date_of_days += round($date_in_times/86400);
                                                            $total_price=$date_of_days*$price;
                                                            $sub_obects_total_price += $total_price;
                                                        }
                                                    }
                                                }
                                            ?>
                                                <td><?php echo $date_from;?></td>
                                                <td><?php echo $date_to;?></td>
                                                <td><?php echo $date_of_days;?></td>
                                                <td><?php echo $date_of_days * $price;?>&euro;</td>
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
                            <tfoot>
                                <tr style="background-color: #605f5f;">
                                    <td style="padding: 0.5rem;" colspan="8"></td>
                                    <td style="padding: 0.5rem;"><b style="color: #fff;">SUM</b></td>
                                    <td style="padding: 0.5rem; color: #fff;"><b><?php echo $sub_obects_total_price?>&euro;</b></td>
                                </tr>
                                <tr style="background-color: #605f5f;">
                                    <td style="padding: 0.5rem;" colspan="8"></td>
                                    <td style="padding: 0.5rem;"><b style="color: #fff;">PROFIT</b></td>
                                    <td style="padding: 0.5rem; color: #fff;"><b><?php echo ($sub_obects_total_price*80)/100?>&euro;</b></td>
                                </tr>
                            </tfoot>
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
        }
    }

?>