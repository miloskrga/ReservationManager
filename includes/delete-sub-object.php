<?php

if(isset($_GET["delete-sub-object"]))
{   
    $id_sub_object = $_GET["delete-sub-object"];

    $query_select_subobject = "SELECT * FROM subobject WHERE SubObjectId = $id_sub_object";
    $query_select_subobject_result = mysqli_query($connection, $query_select_subobject);

    if(!$query_select_subobject_result)
    {
        die("Query failed: " . mysqli_connect_error($query_select_subobject_result));
    }
    else
    {
        $row = mysqli_fetch_assoc($query_select_subobject_result);
        $id_object = $row["ObjectId"];
        $sub_object_link = $row["SubObjectLink"];

        $query_select_object = "SELECT * FROM `object` WHERE ObjectId = $id_object";
        $query_select_object_result = mysqli_query($connection, $query_select_object);

        if(!$query_select_object_result)
        {
            die("Query failed: " . mysqli_connect_error($query_select_object_result));
        }
        else
        {
            $row = mysqli_fetch_assoc($query_select_object_result);
            $object_link = $row["ObjectLink"];
            $today_date = date('Y-m-d');

            $query_select_reservation = "SELECT * FROM reservation WHERE SubObjectId = $id_sub_object AND ToDate > '$today_date'";
            $query_select_reservation_result = mysqli_query($connection, $query_select_reservation);

            if(!$query_select_reservation_result)
            {
                die("Query failed: " . mysqli_connect_error($query_select_reservation_result));
            }
            else
            {
                $counter_rows = mysqli_num_rows($query_select_reservation_result);

                if($counter_rows == 0)
                {
                    $query_delete_reservation = "DELETE FROM reservation WHERE SubObjectId = $id_sub_object";
                    $query_delete_reservation_result = mysqli_query($connection, $query_delete_reservation);

                    if(!$query_delete_reservation_result)
                    {
                        die("Query failed: " .mysqli_connect_error($connection));
                    }
                    else
                    {
                        $query_delete_photo = "DELETE FROM photo WHERE SubObjectId = $id_sub_object";
                        $query_delete_photo_result = mysqli_query($connection, $query_delete_photo);

                        if(!$query_delete_photo_result)
                        {
                            die("Query failed: " . mysqli_connect_error($query_delete_photo_result));
                        }
                        else
                        {
                            $query_delete_EQ = "DELETE FROM subobjequipment WHERE SubObjectId = $id_sub_object";
                            $query_delete_EQ_result = mysqli_query($connection, $query_delete_EQ);

                            if(!$query_delete_EQ_result)
                            {
                                die("Query failed: " . mysqli_connect_error($query_delete_EQ_result));
                            }
                            else
                            {
                                $query_delete_sub_object = "DELETE FROM subobject WHERE SubObjectId = $id_sub_object";
                                $query_delete_sub_object_result = mysqli_query($connection, $query_delete_sub_object);

                                if(!$query_delete_sub_object_result)
                                {
                                    die("Query failed: " . mysqli_connect_error($query_delete_sub_object_result));
                                }
                                else
                                {
                                    $files = glob("objekti/$object_link$sub_object_link*");
                                    $folder_path = "objekti/$object_link$sub_object_link";

                                    foreach($files as $file)
                                    {
                                        unlink($file);
                                    }

                                    if(!$folder_path)
                                    {
                                        echo "Unable to delete folder";
                                    }
                                    else
                                    {
                                        rmdir($folder_path);
                                        header("Location: makeoffer.php?operation=sub-post&id_object=$id_object&action=true");
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    header("Location: makeoffer.php?operation=sub-post&id_object=$id_object&action=false");
                }
            }
        }
    }
}

?>