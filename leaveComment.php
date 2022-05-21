<?php

    session_start();
    require_once "BLL/DbHandler.php";
    require_once "funkcije.php";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["comment"]) && isset($_POST["id-sub-object"]))
        {
            $bit = 0;
            $comment = $_POST["comment"];
            $user_id = $_SESSION["id_user"];
            $sub_object_id = $_POST["id-sub-object"];
            $date_of_comment = date("Y-m-d");

            if(empty($comment))
            {
                echo "Field is required.";
                echo "~";
                echo $bit;
            }
            else
            {
                $query_insert_comment = "INSERT INTO userobjectrating (UserId, SubObjectId, RatingDescription, CreatedDate) VALUES ($user_id, $sub_object_id, '$comment', '$date_of_comment')";
                $query_insert_comment_result = mysqli_query($connection, $query_insert_comment);
    
                if(!$query_insert_comment_result)
                {
                    die("Query failed: ". mysqli_connect_error($connection));
                }
                else
                {
                    $result = "";
    
                    $query_select_comments = "SELECT * FROM userobjectrating INNER JOIN `user` ON userobjectrating.UserId = `user`.UserId WHERE userobjectrating.SubObjectId = $sub_object_id AND userobjectrating.UserId = $user_id";
                    $query_select_comments_result = mysqli_query($connection, $query_select_comments);
    
                    if(!$query_select_comments_result)
                    {
                        die("Query failed: ". mysqli_connect_error($connection));
                    }
                    else
                    {
                        $result .= "<p>Comments:</p>";
    
                        while($row = mysqli_fetch_assoc($query_select_comments_result))
                        {
                            $comment_db = $row["RatingDescription"];
                            $first_name_db = $row["FirstName"];
                            $last_name_db = $row["LastName"];
                            $date_of_comment_db = $row["CreatedDate"];
    
                            $result .= "<div class='comment-post'>
                                            <div class='comment-about'>
                                                <span>$first_name_db $last_name_db</span>
                                                <span>$date_of_comment_db</span>
                                            </div>
                                            <div class='comment-description'>
                                                <p>$comment_db</p>
                                            </div>
                                        </div>";
                        }
    
                        echo $result;   
                        echo "~";
                        $bit = 1;
                        echo $bit;
                    }
                }
            }

        }
    }

?>