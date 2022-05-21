<?php 

$id_object = $_GET['id_object'];
$query_select_object = "SELECT ObjectLink FROM `object` WHERE ObjectId = $id_object";
$query_select_object_result = mysqli_query($connection, $query_select_object);

if(!$query_select_object_result)
{
    die("Query failed: ".mysqli_connect_error($connection));
}
else
{
    $row = mysqli_fetch_assoc($query_select_object_result);
    $link_object = $row["ObjectLink"];
}

?>

<?php

    if(isset($_GET["action"]))
    {
        if($_GET["action"] == 'false')
        {
            echo "<p style='margin-bottom: 2rem; font-size: 1.3rem;'>Unable to delete reserved sub-object. Probably the reservation has not expired yet or there are some comments for that accommodation.</p>";
        }

        if($_GET["action"] == 'true')
        {
            echo "<p style='margin-bottom: 2rem; font-size: 1.3rem;'>You have successfully deleted a sub-object.</p>";
        }
    }

?>

<table class="view-all-sub-posts">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Picture</th>
            <th>Subobject type</th>
            <th>Price</th>
            <th>Link</th>
        </tr>
    </thead>
    <tbody>

    <?php

  
    $query_select_sub_object = "SELECT * FROM `subobject` INNER JOIN subobjecttype ON subobject.SubObjectTypeId = subobjecttype.SubObjectTypeId WHERE ObjectId = $id_object";
    $query_select_sub_object_result = mysqli_query($connection, $query_select_sub_object);

    if(!$query_select_sub_object_result)
    {
        die("Query failed: ".mysqli_connect_error($connection));
    }
    else
    {
        while($row = mysqli_fetch_assoc($query_select_sub_object_result))
        {   
            $id_sub_object = $row["SubObjectId"];
            $name_sub_object = $row["SubObjectName"];
            $image_sub_object = $row["SubObjectImage"];
            $type_name_sub_object = $row["SubObjectTypeName"];
            $price_sub_object = $row["Price"];
            $link_sub_object = $row["SubObjectLink"];
            ?>

            <tr>
                <td><?php echo $id_sub_object; ?></td>
                <td><?php echo $name_sub_object; ?></td>
                <td>
                    <img style="width: 6rem; height: 4rem;" src="objekti/<?php echo $link_object.$link_sub_object.$image_sub_object; ?>" alt="<?php echo $name_sub_object; ?>">
                </td>
                <td><?php echo $type_name_sub_object; ?></td>
                <td><?php echo $price_sub_object; ?>&euro; </td>
                <td><?php echo $link_sub_object; ?></td>  
                <td>
                    <a style="text-decoration:none;" href="?operation=edit-sub-post&id_sub_object=<?php echo $id_sub_object; ?>">Edit</a>
                </td>
                <td>
                    <a style="text-decoration:none;" href="?delete-sub-object=<?php echo $id_sub_object; ?>">Delete</a>
                </td> 
                
            </tr>

            <?php
        }
    }

    ?>
    
    </tbody>
</table>
<a style="text-decoration:none;" href="?operation=add-sub-post&id_object=<?php echo $id_object; ?>">Add new</a>