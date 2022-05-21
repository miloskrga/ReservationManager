<?php

$id_object = $_POST["id_object"];
$name_object = $_POST["edit-name-object"];
$address_object = $_POST["edit-address-object"];
$id_city = $_POST["edit-city-object"];
$type_object = $_POST["edit-type-object"];
$description_object = $_POST["edit-description-object"];
$image_object = $_FILES["edit-image-object"]["name"];
//Privremena putanja
$image_tmp_object = $_FILES["edit-image-object"]["tmp_name"];

$query_select = "SELECT * FROM `object` WHERE ObjectId = $id_object";
$query_select_result = mysqli_query($connection, $query_select);

if(!$query_select_result)
{
    die("Query failed:" .mysqli_connect_error($connection));
}
else
{
    $row = mysqli_fetch_assoc($query_select_result);
    $db_name_object = $row["ObjectName"];
    $db_link_object = $row["ObjectLink"];
    $db_image_object = $row["ObjectImage"];
    $old_dir_name = $db_link_object;

    if($name_object !== $db_name_object)
    {
        $name_object_convert = str_replace(array("č", "Č", "ć", "Ć", "š", "Š", "đ", "Đ", "ž", "Ž"), array("&#269;", "&#268;", "&#263;", "&#262;", "&#353;", "&#352;", "&#273;", "&#272;", "&#382;", "&#381;"), $name_object);
        $name_object_link = str_replace(array(" ", "č", "Č", "ć", "Ć", "š", "Š", "đ", "Đ", "ž", "Ž"), array("-", "c", "C", "c", "C", "s", "S", "dj", "Dj", "z", "Z"), $name_object);
        $name_object_link_to_lower = strtolower($name_object_link);
        $name_object_link_to_lower_slash = $name_object_link_to_lower . "/";
        $new_dir_name = $name_object_link_to_lower_slash;
    }
    else
    {
        $name_object_convert = $db_name_object;
        $new_dir_name = $old_dir_name;
    }

    if($image_object !== $db_image_object)
    {
        $files = glob("objekti/$db_link_object$db_image_object");

        foreach($files as $file)
        {
            if(is_file($file))
            {
                unlink($file);
            }
        }
        $image_object_update = $image_object;
    }
    else
    {
        $image_object_update = $db_image_object;
    }

    $query_update = "UPDATE `object` SET ObjectName = '$name_object_convert', ObjectLink = '$new_dir_name', ObjectImage = '$image_object_update', `Address` = '$address_object', CityId = $id_city, ObjectTypeId = $type_object, ObjectDescription = '$description_object' WHERE ObjectId = $id_object";
    $query_update_result = mysqli_query($connection, $query_update);

    if(!$query_update_result)
    {
        die("Query failed:" .mysqli_connect_error($connection));
    }
    else
    {
        if($name_object !== $db_name_object)
        {
            rename("objekti/".$old_dir_name, "objekti/".$new_dir_name);
            move_uploaded_file($image_tmp_object, "objekti/$new_dir_name$image_object_update");
        }
        else
        {
            move_uploaded_file($image_tmp_object, "objekti/$new_dir_name$image_object_update");
        }
    }
}


?>