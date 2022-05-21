<?php 

include "BLL/DbHandler.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $image_name = "";
    if(isset($_POST["id-photo"]))
    {
        $id_photo = $_POST["id-photo"];
        $select_photos = "SELECT * FROM photo WHERE PhotoId = $id_photo";
        $query_select_photos_results = mysqli_query($connection, $select_photos);

        if(!$query_select_photos_results)
        {
            die("Query failed: ". mysqli_connect_error($connection));   
        }
        else
        {
            $row = mysqli_fetch_assoc($query_select_photos_results);
            $id_sub_object = $row["SubObjectId"];
            $name_photo_db = $row["PhotoPath"];

            $select_subobject = "SELECT * FROM subobject WHERE SubObjectId = $id_sub_object";
            $select_subobject_results = mysqli_query($connection, $select_subobject);

            if(!$select_subobject_results)
            {
                die("Query failed: ". mysqli_connect_error($connection));
            }
            else
            {
                $row = mysqli_fetch_assoc($select_subobject_results);
                $id_object = $row["ObjectId"];
                $subobject_link = $row["SubObjectLink"];

                $select_object = "SELECT * FROM `object` WHERE ObjectId = $id_object";
                $select_object_results = mysqli_query($connection, $select_object);

                if(!$select_object_results)
                {
                    die("Query failed: ". mysqli_connect_error($connection));
                }
                else
                {
                    $row = mysqli_fetch_assoc($select_object_results);
                    $object_link = $row["ObjectLink"];
                }
            }
        }
    }

    if(isset($_FILES["image-array"]))
    {
        $image_name = $_FILES["image-array"]["name"];
        $image_path = $_FILES["image-array"]["tmp_name"];

        if($name_photo_db !== $image_name)
        {
            $files = glob("objekti/$object_link$subobject_link$name_photo_db");

            foreach($files as $file)
            {
                if(is_file($file))
                {
                    unlink($file);
                }
            }
        }

        move_uploaded_file($image_path, "objekti/$object_link$subobject_link$image_name");
    }
    else
    {
        $image_name = $name_photo_db;
        echo $image_name;
    }

    $query_update_image = "UPDATE photo SET PhotoPath = '$image_name' WHERE PhotoId = $id_photo";
    $query_update_image_results = mysqli_query($connection, $query_update_image);

    if(!$query_update_image_results)
    {
        die("Query failed: ". mysqli_connect_error($connection));                    
    }
    else
    {
        $result = "";
        $sub_query_2 = "SELECT * FROM photo WHERE SubObjectId = $id_sub_object";
        $sub_query_result_2 = mysqli_query($connection, $sub_query_2);

        if(!$sub_query_result_2)
        {
            die("Query failed: ". mysqli_connect_error($connection));
        }
        else
        {
            while($row = mysqli_fetch_assoc($sub_query_result_2))
            {
                $id_photo = $row["PhotoId"];
                $path_photo = $row["PhotoPath"];
                $result .= "<div style='margin-bottom: 1rem;' class='display: flex; flex-wrap: wrap;'><img style='display: block; width: 100%; max-width: 300px;' src='objekti/$object_link$subobject_link$path_photo'><input type='file' id='$id_photo' name='customFile'><button type='button' onclick='changeContent($id_photo);'>Change</button><button type='button' onclick='removeElement($id_photo);'>Delete</button></div>";
            }                                    

            echo $result;
        }
    }
}

?>