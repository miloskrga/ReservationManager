<?php

$id_object = $_POST["id_object"];
$id_sub_object = $_POST["id_sub_object"];
$name_sub_object = $_POST["edit-name-sub-object"];
$price_sub_object = $_POST["edit-price-sub-object"];
$image_sub_object = $_FILES["edit-image-sub-object"]["name"];
$type_sub_object = $_POST["edit-type-sub-object"];
//Privremena putanja
$image_tmp_sub_object = $_FILES["edit-image-sub-object"]["tmp_name"];

$query_select = "SELECT * FROM `object` WHERE ObjectId = $id_object";
$query_select_result = mysqli_query($connection, $query_select);

if(!$query_select_result)
{
    die("Query failed:" .mysqli_connect_error($connection));
}
else
{
    $row = mysqli_fetch_assoc($query_select_result);
    $link_object = $row["ObjectLink"];

    $query_select_sub_object = "SELECT * FROM subobject WHERE SubObjectId = $id_sub_object";
    $query_select_sub_object_result = mysqli_query($connection, $query_select_sub_object);

    if(!$query_select_sub_object_result)
    {
        die("Query failed:" .mysqli_connect_error($connection));
    }
    else
    {
        $row = mysqli_fetch_assoc($query_select_sub_object_result);
        $db_name_sub_object = $row["SubObjectName"];
        $db_link_sub_object = $row["SubObjectLink"];
        $db_image_sub_object = $row["SubObjectImage"];
        $old_dir_sub_name = $db_link_sub_object;

        if($name_sub_object !== $db_name_sub_object)
        {
            $name_sub_object_convert = str_replace(array("č", "Č", "ć", "Ć", "š", "Š", "đ", "Đ", "ž", "Ž"), array("&#269;", "&#268;", "&#263;", "&#262;", "&#353;", "&#352;", "&#273;", "&#272;", "&#382;", "&#381;"), $name_sub_object);
            $name_sub_object_link = str_replace(array(" ", "č", "Č", "ć", "Ć", "š", "Š", "đ", "Đ", "ž", "Ž"), array("-", "c", "C", "c", "C", "s", "S", "dj", "Dj", "z", "Z"), $name_sub_object);
            $name_sub_object_link_to_lower = strtolower($name_sub_object_link);
            $name_sub_object_link_to_lower_slash = $name_sub_object_link_to_lower . "/";
            $new_dir_sub_name = $name_sub_object_link_to_lower_slash;
        }
        else
        {
            $name_sub_object_convert = $db_name_sub_object;
            $new_dir_sub_name = $old_dir_sub_name;
        }

        if($image_sub_object !== $db_image_sub_object)
        {
            $files = glob("objekti/$link_object$db_link_sub_object$db_image_sub_object");

            foreach($files as $file)
            {
                if(is_file($file))
                {
                    unlink($file);
                }
            }
            $image_sub_object_update = $image_sub_object;
        }
        else
        {
            $image_sub_object_update = $db_image_sub_object;
        }

        $query_update = "UPDATE subobject SET SubObjectName = '$name_sub_object_convert', SubObjectLink = '$new_dir_sub_name', SubObjectImage = '$image_sub_object_update', Price = $price_sub_object, SubObjectTypeId = $type_sub_object, ObjectId = '$id_object' WHERE SubObjectId = $id_sub_object";
        $query_update_result = mysqli_query($connection, $query_update);

        if(!$query_update_result)
        {
            die("Query failed:" .mysqli_connect_error($connection));
        }
        else
        {
            if($name_sub_object !== $db_name_sub_object)
            {
                rename("objekti/".$link_object.$old_dir_sub_name, "objekti/".$link_object.$new_dir_sub_name);
                move_uploaded_file($image_tmp_sub_object, "objekti/".$link_object.$new_dir_sub_name.$image_sub_object_update);
            }
            else
            {
                move_uploaded_file($image_tmp_sub_object, "objekti/".$link_object.$new_dir_sub_name.$image_sub_object_update);
            }

            header("Location: http://localhost/Hotel/makeoffer.php?operation=sub-post&id_object=$id_object");
        }
    }
}

?>