<?php

session_start();
include "BLL/DbHandler.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["id-reservation"]))
    {   
        $summary_number=0;
        $id_reservation = $_POST["id-reservation"];
        $query_delete_reservation = "DELETE FROM reservation WHERE ReservationId = $id_reservation";
        $query_delete_reservation_result = mysqli_query($connection, $query_delete_reservation);

        if(!$query_delete_reservation_result)
        {
            die("Query failed: " .mysqli_connect_error($connection));
        }
        else
        {
            $id_user = $_SESSION["id_user"];
            $result = "";
            $result2 = "";
            $query_select_reservation = "SELECT * FROM reservation INNER JOIN subobject ON reservation.SubObjectId = subobject.SubObjectId INNER JOIN `object` ON subobject.ObjectId = `object`.ObjectId WHERE reservation.UserId = $id_user";
            $query_select_reservation_result = mysqli_query($connection, $query_select_reservation);        

            if(!$query_select_reservation_result)
            {
                die('Query failed: ' . mysqli_connect_error($connection));
            }
            else
            {
                $current_date = date('Y-m-d');
                while($row = mysqli_fetch_assoc($query_select_reservation_result))
                {
                    $id_reservation = $row['ReservationId'];
                    $sub_object_name = $row['SubObjectName'];
                    $object_name = $row['ObjectName'];
                    $date_from = $row['FromDate'];
                    $date_to = $row['ToDate'];
                    $price = $row['Price'];
                    $date_in_times = strtotime($date_to) - strtotime($date_from);
                    $date_of_days = round($date_in_times/86400);
                    $complet_result = $date_of_days * $price;
                    $summary_number+=$complet_result;

                    $result .= "<tr>
                        <td>$id_reservation</td>
                        <td>$object_name</td>
                        <td>$sub_object_name</td>
                        <td>$date_from</td>
                        <td>$date_to</td>
                        <td>$date_of_days</td>
                        <td>$complet_result €</td>";
                        
                        if($date_to > $current_date)
                        {  
                            $result .= "<td><button onclick='delay($id_reservation);'>Delete</button></td>";
                        }
                        else
                        {
                            $result .= "<td><b>Run out</b></td>";
                        }
                    $result .= "</tr>";
                }
                $result2.="<tr style='background-color: #605f5f;'>
                        <td style='padding: 0.5rem;' colspan='5'></td>
                        <td style='padding: 0.5rem;'><b style='color: #fff;'>SUM</b></td>
                        <td style='padding: 0.5rem; color: #fff;'>$summary_number €</td>
                 </tr>";
               
                echo $result;
                echo $result2;
                echo "~";
                echo "<p style='margin-top: 2rem; padding: 0.6rem 1.3rem; color: red; border-radius: 5px; font-size: 1.3rem; display: inline-block; background-color: #e3e3e3;'>Reservation canceled.</p>";
            }
        }
    }
}

?>