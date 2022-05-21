<?php
    
    $id_object = $_GET['id_object'];
    $query_select_object = "SELECT ObjectTypeId FROM `object` WHERE ObjectId = $id_object";
    $query_select_object_result = mysqli_query($connection, $query_select_object);

    if(!$query_select_object_result)
    {
        die("Query failed: ". mysqli_connect_error($connection));
    }
    else
    {
        $row = mysqli_fetch_assoc($query_select_object_result);
        $id_object_type = $row["ObjectTypeId"];
    }
    
?>

<div class="container-add-post">
    <h1 style="color: blue;">Add new sub post</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
        <input type="text" name="id_object" value="<?php echo $id_object; ?>" style="display: none;">
        <div class="form-group">
            <label for="name-sub-object">SubObject Name</label>
            <input id="name-sub-object" name="name-sub-object" type="text" placeholder="SubObject Name:" required>
        </div>
        <div class="form-group">
            <label for="price-object">SubObject Price</label>
            <input id="price-object" name="price-object" type="number" placeholder="SubObject Price:" required>
        </div>
        <div class="form-group">
            <label for="image-sub-object">SubObject Image</label>
            <input id="image-sub-object" name="image-sub-object" type="file" required>
        </div>
        <div class="form-group">
        <label for="type-sub-object">SubObject Type</label>
            <select name="type-sub-object" id="type-sub-object">
                <?php
                
                $query_select_type_object = "SELECT DISTINCT SubObjectTypeId, SubObjectTypeName FROM subobjecttype WHERE ObjectTypeId = $id_object_type";
                $query_select_type_object_result = mysqli_query($connection, $query_select_type_object);

                if(!$query_select_type_object_result)
                {
                    die("Query failed: ". mysqli_connect_error($connection));
                }
                else
                {
                    while($row = mysqli_fetch_assoc($query_select_type_object_result))
                    {
                        $id_type_sub_object = $row["SubObjectTypeId"];
                        $name_type_sub_object = $row["SubObjectTypeName"];

                        ?>

                        <option value="<?php echo $id_type_sub_object ?>"><?php echo $name_type_sub_object ?></option>

                        <?php
                    }
                }
                
                ?>
            </select>
        </div>
        <div class="form-group">
            <div class="wrapper-equipment">
                <p>Equipment</p>
                <?php 
                
                $query_select_equipment = "SELECT EquipmentId, EquipmentName FROM equipment";
                $query_select_equipment_result = mysqli_query($connection, $query_select_equipment);

                if(!$query_select_equipment_result)
                {
                    die("Query failed: ". mysqli_connect_error($connection));
                }
                else
                {
                    while($row = mysqli_fetch_assoc($query_select_equipment_result))
                    {
                        $id_equipment = $row["EquipmentId"];
                        $name_equipment = $row["EquipmentName"];

                        ?>

                        <div class="equipment-item">
                            <label for="<?php echo $id_equipment.'-equipment'; ?>"><?php echo $name_equipment; ?></label>
                            <input type="checkbox" id="<?php echo $id_equipment.'-equipment'; ?>" name="<?php echo $id_equipment.'-equipment'; ?>" value="<?php echo $id_equipment; ?>">
                        </div>

                        <?php
                    }
                }
                
                ?>
            </div>
        </div>
        <button type="submit">Add</button>
    </form>
</div>