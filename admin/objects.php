<?php include "head.php"; ?>
<style>
     body{
        margin: 0;
    }

    .header{
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 2rem;
        margin-bottom: 0;
        background-color: #706d6d; 
    }

    .header .header-text p{
        font-size: 2rem;
        margin: 0;
    }

    .header .nav a{
        display: flex;
        align-items: center;
        color: #fff;
    }
    .dasboard-container{
        display: flex;
    }

    .wrapper-page{
        padding: 2rem;
        flex-basis: 80%;
        max-width: 80%;
        width: 100%;
    }

    .wrapper-page .dashboard-item{
        flex-basis: 25%;
        max-width: 25%;
        width: 100%;
        padding: 0 15px;
    }

    .dasboard-items{
        display: flex;
    }

    table, tr, td, th{
        border: 1px solid black;
        text-align: center;
    }

    .filter-form{
        display: flex;
    }


</style>
<?php include "navigation.php"; ?>
<div class="dasboard-container">
    <?php include "aside.php"; ?>
    <div class="wrapper-page">
        <?php
        $query_select_users = "SELECT `ObjectId`,`ObjectTypeName`,`ObjectImage`,`ObjectName`,`Address`,`CityName`,`CountryName`,`ObjectLink` from `object` inner join objecttype on `object`.ObjectTypeId=objecttype.ObjectTypeId inner join city on `object`.CityId=city.CityId inner join country on city.CountryId=country.CountryId";
        $query_select_users_result = mysqli_query($connection, $query_select_users);

        if(!$query_select_users_result)
        {
            die("Query failed:" .mysqli_connect_error($connection));
        }
        else
        {
            $sub_obects_total_price = 0;
            $row_counter = mysqli_num_rows($query_select_users_result);

            if($row_counter > 0)
            { 
                ?>
                <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>ObejctId</th>
                        <th>ObjectType</th>
                        <th>ObjectImage</th>
                        <th>ObjectName</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Country</th>
                        
                    </tr>
                </thead>
               
                <?php
                while($row = mysqli_fetch_assoc($query_select_users_result))
                {
                    $id_object=$row["ObjectId"];
                    $object_type=$row["ObjectTypeName"];
                    $object_image=$row["ObjectImage"];
                    $object_name=$row["ObjectName"];
                    $address=$row["Address"];
                    $city_name=$row["CityName"];
                    $country_name=$row["CountryName"];
                    $object_link=$row["ObjectLink"];
                    ?>
                    <tr>
                        <th style="padding: 0.5rem;"><?php echo $id_object;?></th>
                        <th style="padding: 0.5rem;"><?php echo $object_type;?></th>
                        <th><img style="display: block; width: 5.5rem; height: 4rem; object-fit: cover; margin-left: auto; margin-right: auto; padding: 0.5rem;" src="../objekti/<?php echo $object_link.$object_image; ?>" alt=""></th>
                        <th style="padding: 0.5rem;"><?php echo $object_name;?></th>
                        <th style="padding: 0.5rem;"><?php echo $address;?></th>
                        <th style="padding: 0.5rem;"><?php echo $city_name;?></th>
                        <th style="padding: 0.5rem;"><?php echo $country_name;?></th>
                        
                    </tr>
                    <?php
                }
            }
        }
        
        ?>
            </table>
       
    </div>

</div>


<?php include "footer.php"; ?>