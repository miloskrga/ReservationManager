<?php

    if(isset($_GET["operation"]) && isset($_GET["id_sub_object"]))
    {
        if($_GET["operation"] == "edit-sub-post")
        {
            $id_sub_object = $_GET["id_sub_object"];
            $id_user = $_SESSION["id_user"];
            
            $query_select_object = "SELECT * FROM `subobject` INNER JOIN subobjecttype ON subobject.SubObjectTypeId=subobjecttype.SubObjectTypeId INNER JOIN `object` ON  subobject.ObjectId=`object`.ObjectId INNER JOIN objecttype ON `object`.ObjectTypeId=objecttype.ObjectTypeId  WHERE SubObjectId= $id_sub_object";
            $query_select_object_result = mysqli_query($connection, $query_select_object);
            $query_select_object_count = mysqli_num_rows($query_select_object_result);

            if($query_select_object_count > 0)
            {
                if(!$query_select_object_result)
                {
                    die("Query failed: ". mysqli_connect_error($connection));
                }
                else
                {
                    while($row = mysqli_fetch_assoc($query_select_object_result))
                    {
                        $id_sub_object = $row['SubObjectId'];
                        $link_object = $row['ObjectLink'];
                        $id_object = $row['ObjectId'];
                        $title_sub_object = $row['SubObjectName'];
                        $link_sub_object = $row['SubObjectLink'];
                        $id_object_type = $row['ObjectTypeId'];
                        $object_type = $row['ObjectTypeName'];
                        $image_sub_object = $row['SubObjectImage'];
                        $price_sub_object = $row['Price'];
                        $id_sub_object_type = $row['SubObjectTypeId'];
                        $sub_object_type = $row['SubObjectTypeName'];

                        ?>

                        <div class="container-edit-post">
                            <h1 style="color: blue;">Edit sub post</h1>
                            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
                                <input type="text" name="id_object" value="<?php echo $id_object; ?>" style="display: none;">
                                <input type="text" name="id_sub_object" value="<?php echo $id_sub_object; ?>" style="display: none;">
                                <div class="form-group">
                                    <label for="name-object">SubObject Name</label>
                                    <input id="name-object" name="edit-name-sub-object" type="text" placeholder="SubObject Name" value="<?php echo $title_sub_object; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="price-object">SubObject Price</label>
                                    <input id="price-object" name="edit-price-sub-object" type="number" placeholder="SubObject Price" value="<?php echo $price_sub_object; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="image-object">SubObject Image</label>
                                    <img src="objekti/<?php echo $link_object.$link_sub_object.$image_sub_object; ?>" alt="">
                                    <input id="image-object" name="edit-image-sub-object" type="file" value="<?php echo $image_sub_object; ?>" required>
                                </div>
                                <div class="form-group">
                                    <p>Object Type: <?php echo $object_type?></p>
                                    <label for="type-object">SubObject Type</label>
                                    <select name="edit-type-sub-object" id="type-object">
                                        <?php
                                        
                                        $query_select_type_object = "SELECT * FROM subobjecttype WHERE ObjectTypeId = $id_object_type";
                                        $query_select_type_object_result = mysqli_query($connection, $query_select_type_object);

                                        if(!$query_select_type_object_result)
                                        {
                                            die("Query failed: ". mysqli_connect_error($connection));
                                        }
                                        else
                                        {
                                            while($row = mysqli_fetch_assoc($query_select_type_object_result))
                                            {
                                                $id_type_object_data = $row["SubObjectTypeId"];
                                                $name_type_object = $row["SubObjectTypeName"];

                                                ?>

                                                <option value="<?php echo $id_type_object_data ?>" <?php if($id_type_object_data == $id_sub_object_type){ echo "selected"; } ?>><?php echo $name_type_object ?></option>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit">Change</button>
                            </form>
                        </div>
                        <div class="container-comments">
                            <h2>Comments:</h2>
                            <table class="table-comments">
                                <thead>
                                    <tr>
                                        <th>ID Comment</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Comment</th>
                                        <th>Date of Comment</th>
                                        <th>Sub Object Name</th>
                                    </tr>
                                </thead>
                                <tbody id="body-comments">
                            <?php
                                        
                                $query_select_comments = "SELECT * FROM userobjectrating INNER JOIN `user` on userobjectrating.UserId=`user`.UserId INNER JOIN subobject ON userobjectrating.SubObjectId = subobject.SubObjectId  WHERE userobjectrating.SubObjectId = $id_sub_object";
                                $query_select_comments_result = mysqli_query($connection, $query_select_comments);

                                if(!$query_select_comments_result)
                                {
                                    die("Query failed: ". mysqli_connect_error($connection));
                                }
                                else
                                {
                                    while($row = mysqli_fetch_assoc($query_select_comments_result))
                                    {
                                        $sub_object_id = $row["SubObjectId"];
                                        $user_object_rating_id = $row["UserObjectRatingId"];
                                        $created_date = $row["CreatedDate"];
                                        $rating_description = $row["RatingDescription"];
                                        $first_name = $row["FirstName"];
                                        $last_name = $row["LastName"];
                                        $sub_object_name = $row["SubObjectName"];
                                        ?>

                                        <tr>
                                            <td><?php echo $user_object_rating_id ?></td>
                                            <td><?php echo $first_name ?></td>
                                            <td><?php echo $last_name ?></td>
                                            <td><?php echo $rating_description ?></td>
                                            <td><?php echo $created_date ?></td>
                                            <td><?php echo $sub_object_name ?></td>
                                            <td><button type="button" onclick="deleteComment(<?php echo $user_object_rating_id; ?>, <?php echo $sub_object_id; ?>);">DELETE</button></td>
                                        </tr>

                                        <?php
                                    }
                                }
                            ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="container-edit-other-content">
                            <h2>Additional content</h2>
                            <div id="wrapper-other-content-post">
                                        
                            <?php
                                        
                                $query_select_photo = "SELECT * FROM photo WHERE SubObjectId = $id_sub_object";
                                $query_select_photo_result = mysqli_query($connection, $query_select_photo);

                                if(!$query_select_photo_result)
                                {
                                    die("Query failed: ". mysqli_connect_error($connection));
                                }
                                else
                                {
                                    while($row = mysqli_fetch_assoc($query_select_photo_result))
                                    {
                                        $name_image = $row["PhotoPath"];
                                        $id_photo = $row["PhotoId"];
                                        ?>
                                       
                                        <div style='margin-bottom: 1rem;'>
                                            <img style='display: block; width: 100%; max-width: 300px;' src='objekti/<?php echo $link_object.$link_sub_object.$name_image; ?>'>
                                            <input type='file' id='<?php echo $id_photo; ?>'>
                                            <button type='button' onclick='changeContent(<?php echo $id_photo; ?>);'>Change</button>
                                            <button type='button' onclick='removeElement(<?php echo $id_photo; ?>);'>Delete</button>
                                        </div>

                                        <?php
                                    }
                                }

                            ?>

                            </div>
                            <div class="other-content" style="margin-bottom: 2rem;">
                                    <hr>
                                    <button id="img" type="button" class="btn" onclick="createTagElement(this)">Add Image</button>
                            </div>
                        </div>

                        <?php
                    }
                }
            }
            else
            {
        
            }
        }
    }

?>