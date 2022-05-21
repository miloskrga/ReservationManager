<?php

    session_start();
    require_once "BLL/DbHandler.php";
    require_once "funkcije.php";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["id-comment"]) AND isset($_POST["id-sub-object"]))
        {
            $id_sub_object = $_POST["id-sub-object"];
            $id_comment = $_POST["id-comment"];
            $user_id = $_SESSION["id_user"];
            $query_delete_comment = "DELETE FROM userobjectrating WHERE UserObjectRatingId = $id_comment";
            $query_delete_comment_result = mysqli_query($connection, $query_delete_comment);

            if(!$query_delete_comment_result)
            {
                die("Query failed: ". mysqli_connect_error($connection));
            }
            else
            {
                $result = "";

                $query_select_comments = "SELECT * FROM userobjectrating INNER JOIN `user` ON userobjectrating.UserId = `user`.UserId INNER JOIN subobject ON userobjectrating.SubObjectId = subobject.SubObjectId WHERE userobjectrating.UserId = $user_id AND userobjectrating.SubObjectId = $id_sub_object";
                $query_select_comments_result = mysqli_query($connection, $query_select_comments);

                if(!$query_select_comments_result)
                {
                    die("Query failed: ". mysqli_connect_error($connection));
                }
                else
                {
                    while($row = mysqli_fetch_assoc($query_select_comments_result))
                    {
                        $user_object_rating_id = $row["UserObjectRatingId"];
                        $created_date = $row["CreatedDate"];
                        $rating_description = $row["RatingDescription"];
                        $first_name = $row["FirstName"];
                        $last_name = $row["LastName"];
                        $sub_object_name = $row["SubObjectName"];

                        $result .= "<tr>
                                        <td>$user_object_rating_id</td>
                                        <td>$first_name</td>
                                        <td>$last_name</td>
                                        <td>$rating_description</td>
                                        <td>$created_date</td>
                                        <td>$sub_object_name</td>
                                        <td><button type='button' onclick='deleteComment($user_object_rating_id, $id_sub_object);'>DELETE</button></td>
                                    </tr>";
                    }
                    echo $result;
                }
            }
        }
    }

?>