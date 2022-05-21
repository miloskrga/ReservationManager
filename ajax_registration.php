<?php
include "BLL/DbHandler.php";

if(isset($_GET['funkcija'])){

    $funkcija=$_GET['funkcija'];

    if($funkcija="popuniSelectCity"){

        $p1 = $_POST['id'];
        $call = 'CALL CityByCountryGet('.$p1.')';
        $arr=array();

        if($rez=mysqli_query($connection,$call)){
            while($red = mysqli_fetch_assoc($rez)){
                array_push($arr, array("CityId"=>$red['CityId'], "CityName"=>$red['CityName']));

            }
            echo JSON_encode($arr);
        }
        else{
            echo "Error message:".mysqli_error($connection);
        }
    }
}
?>