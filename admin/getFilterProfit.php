<?php

    session_start();
    require_once "../BLL/DbHandler.php";
    require_once "../funkcije.php";
    $possition = "";
    $sub_obects_total_price = 0;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["date-from"]) && isset($_POST["date-to"]))
        {
            $date_from = $_POST["date-from"];
            $date_to = $_POST["date-to"];

            $query_select_reservation_objects = "SELECT subobject.`SubObjectId`,subobject.`SubObjectImage`, subobjecttype.`SubObjectTypeName`,subobject.`SubObjectName`, reservation.`FromDate`,reservation.`ToDate`, `object`.`ObjectLink`, subobject.`SubObjectLink`, subobject.Price  from subobject inner join subobjecttype on subobject.SubObjectTypeId=subobjecttype.SubObjectTypeId inner join reservation on subobject.SubObjectId=reservation.SubObjectId INNER join `object` on subobject.ObjectId=`object`.ObjectId where reservation.FromDate and reservation.ToDate BETWEEN '$date_from' and '$date_to'";
            $query_select_reservation_objects_result = mysqli_query($connection, $query_select_reservation_objects);
            

            if(!$query_select_reservation_objects_result)
            {
                die("Query failed:" .mysqli_connect_error($connection));
            }
            else
            {
                $row_counter = mysqli_num_rows($query_select_reservation_objects_result);

                if($row_counter > 0)
                {          
                    ?>      
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subobject image</th>
                                <th>Subobject type</th>
                                <th>Number of days</th>
                                <th>Sum price</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                  
                    while($row = mysqli_fetch_assoc($query_select_reservation_objects_result))
                    {
                        $date_of_days=0;
                        $id_sub_object = $row["SubObjectId"];
                        $image_subobject=$row["SubObjectImage"];
                        $subobject_type=$row["SubObjectTypeName"];
                        $name_sub_object = $row["SubObjectName"];
                        $price = $row["Price"];
                        $object_link=$row["ObjectLink"];
                        $sub_object_link=$row["SubObjectLink"];
                        $from_date=$row["FromDate"];
                        $to_date=$row["ToDate"];
                        $date_in_times = strtotime($to_date) - strtotime($from_date);
                        $date_of_days += round($date_in_times/86400);
                        $total_price= $date_of_days * $price;
                        $sub_obects_total_price += $total_price;
                        ?>
                        <tr style='background-color: #a1e2f3;'>
                            <td style="padding: 0.5rem;"><?php echo $id_sub_object;?></td>
                            <td><img style="display: block; width: 5.5rem; height: 4rem; object-fit: cover; margin-left: auto; margin-right: auto; padding: 0.5rem;" src="../objekti/<?php echo $object_link.$sub_object_link.$image_subobject; ?>" alt=""></td>
                            <td style="padding: 0.5rem;"><?php echo $subobject_type; ?></td>
                            <td style="padding: 0.5rem;"><?php echo $date_of_days; ?></td>
                            <td style="padding: 0.5rem;"><?php echo $total_price;?>&euro;</td>
                        </tr>
                      <?php

                    }
                    ?>
                    </tbody>
                        <tfoot>
                            <tr style="background-color: #605f5f;">
                                <td style="padding: 0.5rem;" colspan="3"></td>
                                <td style="padding: 0.5rem;"><b style="color: #fff;">SUM</b></td>
                                <td style="padding: 0.5rem; color: #fff;"><b><?php echo $sub_obects_total_price?>&euro;</b></td>
                            </tr>
                            <tr style="background-color: #605f5f;">
                            <td style="padding: 0.5rem;" colspan="3"></td>
                            <td style="padding: 0.5rem;"><b style="color: #fff;">PROFIT</b></td>
                            <td style="padding: 0.5rem; color: #fff;"><b><?php echo ($sub_obects_total_price*20)/100?>&euro;</b></td>
                        </tr>
                        </tfoot>
                    </table>
                    <?php
                }
            }            
        }
    }

?>