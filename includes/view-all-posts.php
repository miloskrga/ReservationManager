<?php 

if(isset($_GET["action"]))
{
    if($_GET["action"] == 'false')
    {
        echo "<p style='margin-bottom: 2rem; font-size: 1.3rem;'>It is not possible to delete an object if its sub-objects exist.</p>";
    }

    if($_GET["action"] == 'true')
    {
        echo "<p style='margin-bottom: 2rem; font-size: 1.3rem;'>You have successfully deleted the object.</p>";
    }
}

?>

<table class="view-all-posts">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Picture</th>
            <th>Address</th>
            <th>Description</th>
            <th>Link</th>
        </tr>
    </thead>
    <tbody>

    <?php

    $id_user = $_SESSION['id_user'];
    $query_select_objects = "SELECT * FROM `object` WHERE UserId = $id_user";
    $query_select_objects_result = mysqli_query($connection, $query_select_objects);

    if(!$query_select_objects_result)
    {
        die("Query failed: ".mysqli_connect_error($connection));
    }
    else
    {
        while($row = mysqli_fetch_assoc($query_select_objects_result))
        {   
            $id_object = $row["ObjectId"];
            $name_object = $row["ObjectName"];
            $image_object = $row["ObjectImage"];
            $address_object = $row["Address"];
            $description_object = $row["ObjectDescription"];
            $link_object = $row["ObjectLink"];
            ?>

            <tr>
                <td><?php echo $id_object; ?></td>
                <td><?php echo $name_object; ?></td>
                <td>
                    <img style="width: 6rem; height: 4rem;" src="objekti/<?php echo $link_object.$image_object; ?>" alt="<?php echo $name_object; ?>">
                </td>
                <td><?php echo $address_object; ?></td>
                <td><?php echo substr($description_object, 0, 50); ?></td>
                <td><?php echo $link_object; ?></td>  
                <td>
                    <a style="text-decoration:none;" href="?operation=edit-post&id_object=<?php echo $id_object; ?>">Edit</a>
                </td>
                <td>
                    <a style="text-decoration:none;" href="?delete-object=<?php echo $id_object; ?>">Delete</a>
                </td> 
                <td>
                    <a style="text-decoration:none;" href="?operation=sub-post&id_object=<?php echo $id_object; ?>">SubObjects</a>
                </td>  
            </tr>

            <?php
        }
    }

    ?>
    
    </tbody>
</table>
<a style="text-decoration:none;" href="?operation=add-post">Add new</a>