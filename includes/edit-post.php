<?php

    if(isset($_GET["operation"]) && isset($_GET["id_object"]))
    {
        if($_GET["operation"] == "edit-post")
        {
            $id_object = $_GET["id_object"];
            
            $query_select_object = "SELECT * FROM `object` INNER JOIN city ON `object`.CityId = city.CityId INNER JOIN country ON city.CountryId = country.CountryId INNER JOIN objecttype ON `object`.ObjectTypeId = objecttype.ObjectTypeId WHERE ObjectId = $id_object";
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
                        $id_object = $row['ObjectId'];
                        $title_object = $row['ObjectName'];
                        $link_object = $row['ObjectLink'];
                        $description_object = $row['ObjectDescription'];
                        $address_object = $row['Address'];
                        $image_object = $row['ObjectImage'];
                        $id_city = $row['CityId'];
                        $id_object_type = $row['ObjectTypeId'];
                        $city_name = $row['CityName'];
                        $country_name = $row['CountryName'];
                        $object_type = $row['ObjectTypeName'];

                        ?>

                        <div class="container-edit-post">
                            <h1 style="color: blue;">Edit post</h1>
                            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
                                <input type="text" name="id_object" value="<?php echo $id_object; ?>" style="display: none;">
                                <div class="form-group">
                                    <label for="name-object">Object Name</label>
                                    <input id="name-object" name="edit-name-object" type="text" placeholder="Object Name" value="<?php echo $title_object; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="address-object">Address</label>
                                    <input id="address-object" name="edit-address-object" type="text" placeholder="Address" value="<?php echo $address_object; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="image-object">Object Image</label>
                                    <img src="objekti/<?php echo $link_object.$image_object; ?>" alt="">
                                    <input id="image-object" name="edit-image-object" type="file" value="<?php echo $image_object; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="city-object">City</label>
                                    <select name="edit-city-object" id="city-object">
                                        <?php
                                        
                                        $query_select_city = "SELECT * FROM city";
                                        $query_select_city_result = mysqli_query($connection, $query_select_city);

                                        if(!$query_select_city_result)
                                        {
                                            die("Query failed: ". mysqli_connect_error($connection));
                                        }
                                        else
                                        {
                                            while($row = mysqli_fetch_assoc($query_select_city_result))
                                            {
                                                $id_city_data = $row["CityId"];
                                                $name_city = $row["CityName"];

                                                ?>

                                                <option value="<?php echo $id_city_data ?>" <?php if($id_city_data == $id_city){ echo "selected"; } ?>><?php echo $name_city ?></option>

                                                <?php
                                            }
                                        }
                                        
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type-object">Object Type</label>
                                    <select name="edit-type-object" id="type-object">
                                        <?php
                                        
                                        $query_select_type_object = "SELECT * FROM objecttype";
                                        $query_select_type_object_result = mysqli_query($connection, $query_select_type_object);

                                        if(!$query_select_type_object_result)
                                        {
                                            die("Query failed: ". mysqli_connect_error($connection));
                                        }
                                        else
                                        {
                                            while($row = mysqli_fetch_assoc($query_select_type_object_result))
                                            {
                                                $id_type_object_data = $row["ObjectTypeId"];
                                                $name_type_object = $row["ObjectTypeName"];

                                                ?>

                                                <option value="<?php echo $id_type_object_data ?>" <?php if($id_type_object_data == $id_object_type){ echo "selected"; } ?>><?php echo $name_type_object ?></option>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="description-object">Object Description</label>
                                    <textarea id="description-object" name="edit-description-object" type="text" placeholder="Unesite opis objekta" required><?php echo $description_object ?></textarea>
                                </div>
                                <button $type="submit">Change</button>
                            </form>
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