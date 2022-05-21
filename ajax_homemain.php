<?php
include "BLL/DbHandler.php";

if(isset($_GET['funkcija'])){

    $funkcija=$_GET['funkcija'];
    
    if($funkcija="popuniSelectSubObject"){

        $p1 = $_POST['id'];
        $call = "CALL SubObjByObj('".$p1."')";
        $arr=array();

        if($rez=mysqli_query($connection,$call)){
            while($red = mysqli_fetch_array($rez,MYSQLI_BOTH)){
                array_push($arr, array("SubObjectTypeId"=>$red['SubObjectTypeId'], "SubObjectTypeName"=>$red['SubObjectTypeName']));

            }
            echo JSON_encode($arr);
        }
        else{
            echo "Error message:".mysqli_error($connection);
        }
    }
}
?>