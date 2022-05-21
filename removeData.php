<?php

    include "BLL/DbHandler.php";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["photo-id"]))
        {
            $photo_id = $_POST["photo-id"];
            $query_select_photo = "SELECT * FROM photo WHERE PhotoId = $photo_id";
            $query_select_photo_result = mysqli_query($connection, $query_select_photo);

            if(!$query_select_photo_result)
            {
                die("Query failed: ". mysqli_connect_error($connection));
            }
            else
            {
                $row = mysqli_fetch_assoc($query_select_photo_result);
                $sub_object_id_db = $row["SubObjectId"];
                $photo_path_db = $row["PhotoPath"];

                $query_select_subobject = "SELECT * FROM subobject WHERE SubObjectId = $sub_object_id_db";
                $query_select_subobject_result = mysqli_query($connection, $query_select_subobject);

                if(!$query_select_subobject_result)
                {
                    die("Query failed: ". mysqli_connect_error($connection));
                }
                else
                {
                    $rows_number = mysqli_num_rows($query_select_subobject_result);

                    if($rows_number > 0)
                    {
                        $row = mysqli_fetch_assoc($query_select_subobject_result);
                        $id_object = $row["ObjectId"];
                        $sub_object_link = $row["SubObjectLink"];

                        $query_select_object = "SELECT * FROM `object` WHERE ObjectId = $id_object";
                        $query_select_object_result = mysqli_query($connection, $query_select_object);

                        if(!$query_select_object_result)
                        {
                            die("Query failed: ". mysqli_connect_error($connection));
                        }
                        else
                        {
                            $row = mysqli_fetch_assoc($query_select_object_result);
                            $object_link = $row["ObjectLink"];

                            $query_delete_photo = "DELETE FROM photo WHERE PhotoId = $photo_id";
                            $query_delete_photo_result = mysqli_query($connection, $query_delete_photo);

                            if(!$query_delete_photo_result)
                            {
                                die("Query failed: ". mysqli_connect_error($connection));
                            }
                            else
                            {
                                $files = glob("objekti/$object_link$sub_object_link$photo_path_db");
                                $result = "";

                                foreach($files as $file)
                                {
                                    if(is_file($file))
                                    {
                                        unlink($file);

                                        $sub_query_2 = "SELECT * FROM photo WHERE SubObjectId = $sub_object_id_db";
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
                                                $result .= "<div style='margin-bottom: 1rem;' class='display: flex; flex-wrap: wrap;'><img style='display: block; width: 100%; max-width: 300px;' src='objekti/$object_link$sub_object_link$path_photo'><input type='file' id='$id_photo' name='customFile'><button type='button' onclick='changeContent($id_photo);'>Change</button><button type='button' onclick='removeElement($id_photo);'>Delete</button></div>";
                                            }                                    
                                        }
        
                                        echo $result; 
                                    }
                                }
                            }
                        } 
                    }
                    else
                    {
                        
                    }
                }
            }
        }
    }

?>