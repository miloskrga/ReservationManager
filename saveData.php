<?php

    include "BLL/DbHandler.php";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["Sub-Object-Id"]) && isset($_FILES["Name-Image"]))
        {
            $id_sub_object = $_POST["Sub-Object-Id"];
            $name_image = $_FILES["Name-Image"]["name"];
            $name_image_path = $_FILES["Name-Image"]["tmp_name"];

            $query_select = "SELECT * FROM subobject WHERE SubObjectId = $id_sub_object";
            $query_select_result = mysqli_query($connection, $query_select);

            if(!$query_select_result)
            {
                die("Query failed: ". mysqli_connect_error($connection));
            }
            else
            {
                $row = mysqli_fetch_assoc($query_select_result);
                $link_sub_object_db = $row["SubObjectLink"];
                $object_id_db = $row["ObjectId"];

                $query_photos = "SELECT * FROM photo WHERE SubObjectId = $id_sub_object AND PhotoPath = '$name_image'";
                $query_photos_result = mysqli_query($connection, $query_photos);

                if(!$query_photos_result)
                {
                    die("Query failed: ". mysqli_connect_error($connection));
                }
                else
                {
                    $rows_number = mysqli_num_rows($query_photos_result);

                    if($rows_number > 0)
                    {
                        echo "The image for the selected accommodation already exists";
                    }
                    else
                    {
                        $query_insert = "INSERT INTO photo (SubObjectId, PhotoPath) VALUES ($id_sub_object, '$name_image')";
                        $query_insert_result = mysqli_query($connection, $query_insert);

                        if(!$query_insert_result)
                        {
                            die("Query failed: ". mysqli_connect_error($connection));
                        }
                        else
                        {
                            $sub_query = "SELECT * FROM `object` WHERE ObjectId = $object_id_db";
                            $sub_query_result = mysqli_query($connection, $sub_query);

                            if(!$sub_query_result)
                            {
                                die("Query failed: ". mysqli_connect_error($connection));
                            }
                            else
                            {
                                $result = "";
                                $row = mysqli_fetch_assoc($sub_query_result);
                                $link_object = $row["ObjectLink"];

                                move_uploaded_file($name_image_path, "objekti/$link_object$link_sub_object_db$name_image");

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
                                        $result .= "<div class='display: flex; flex-wrap: wrap;'><img style='display: block; width: 100%; max-width: 300px;' src='objekti/$link_object$link_sub_object_db$path_photo'><input type='file' id='$id_photo' name='customFile'><button type='button' onclick='changeContent($id_photo);'>Change</button><button type='button' onclick='removeElement($id_photo);'>Delete</button></div>";
                                    }                                    
                                }

                                echo $result;
                            }
                        }
                    }
                }
            }
        }
    }

?>