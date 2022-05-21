<?php

include "BLL/DbHandler.php";
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["id-sub-object"]))
    {
        $id_sub_object = $_POST["id-sub-object"];
        $date_from = $_SESSION["dolazak"];
        $date_to = $_SESSION["odlazak"];
        $id_user = $_SESSION["id_user"];

        //$query_insert = "INSERT INTO reservation (UserId, SubObjectId, FromDate, ToDate) VALUES ($id_user, $id_sub_object, '$date_from', '$date_to')";
        $query_insert="CALL AddNewReservation('".$id_user."','".$id_sub_object."','".$date_from."','".$date_to."')";
        $query_insert_result = mysqli_query($connection, $query_insert);

        if(!$query_insert_result)
        {
            die("Query failed:". mysqli_connect_error($connection));
        }
        else
        {
            echo "<p>You have successfully booked accommodation.</p>";
            $_SESSION["dolazak"] = null;
            $_SESSION["odlazak"] = null;
        }
    }
}

?>