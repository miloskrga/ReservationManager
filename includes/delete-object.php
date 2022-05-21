<?php

if(isset($_GET["delete-object"]))
{   
    $id_object = $_GET["delete-object"];

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

        $query_select_sub_object = "SELECT * FROM subobject WHERE ObjectId = $id_object";
        $query_select_sub_object_result = mysqli_query($connection, $query_select_sub_object);

        if(!$query_select_sub_object_result)
        {
            die("Query failed: " . mysqli_connect_error($query_select_sub_object_result));
        }
        else
        {
            $counter_rows = mysqli_num_rows($query_select_sub_object_result);

            if($counter_rows == 0)
            {
                $query_delete_object = "DELETE FROM `object` WHERE ObjectId = $id_object";
                $query_delete_object_result = mysqli_query($connection, $query_delete_object);

                if(!$query_delete_object_result)
                {
                    die("Query failed: " . mysqli_connect_error($query_delete_object_result));
                }
                else
                {
                    $files = glob("objekti/$object_link*");
                    $folder_path = "objekti/$object_link";

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
                        header("Location: makeoffer.php?action=true");
                    }
                }
            }
            else
            {
                header("Location: makeoffer.php?action=false");
            }
        }
    }
}

?>