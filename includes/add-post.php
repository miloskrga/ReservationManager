<div class="container-add-post">
    <h1 style="color: blue;">Add new post</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name-object">Object Name</label>
            <input id="name-object" name="name-object" type="text" placeholder="Object Name:" required>
        </div>
        <div class="form-group">
            <label for="address-object">Address</label>
            <input id="address-object" name="address-object" type="text" placeholder="Address:" required>
        </div>
        <div class="form-group">
            <label for="image-object">Object Image</label>
            <input id="image-object" name="image-object" type="file" required>
        </div>
        <div class="form-group">
            <label for="city-object">City</label>
            <select name="city-object" id="city-object">
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
                        $id_city = $row["CityId"];
                        $name_city = $row["CityName"];

                        ?>

                        <option value="<?php echo $id_city ?>"><?php echo $name_city ?></option>

                        <?php
                    }
                }
                
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="type-object">Object Type</label>
            <select name="type-object" id="type-object">
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
                        $id_type_object = $row["ObjectTypeId"];
                        $name_type_object = $row["ObjectTypeName"];
                        ?>

                        <option value="<?php echo $id_type_object ?>"><?php echo $name_type_object ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description-object">Object Description</label>
            <input id="description-object" name="description-object" type="text" placeholder="Opis objekta:" required>
        </div>
        <button $type="submit">Add</button>
    </form>
</div>