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
        $query_select_users = "SELECT `UserObjectRatingId`, `FirstName`,`LastName`,`RatingDescription`,`CreatedDate`,`SubObjectTypeName`,`SubObjectName`,`ObjectName`,`CityName`,`CountryName` from userobjectrating inner join `user` on userobjectrating.UserId=`user`.`UserId` inner join subobject on userobjectrating.SubObjectId=subobject.SubObjectId inner join subobjecttype on subobject.SubObjectTypeId=subobjecttype.SubObjectTypeId inner join `object` on subobject.ObjectId=`object`.ObjectId inner join city on `object`.CityId=city.CityId inner join country on city.CountryId=country.CountryId";
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
                        <th>UserObjectRatingId</th>
                        <th>UserFirstName</th>
                        <th>UserLastName</th>
                        <th>RatingDescription</th>
                        <th>CreatedDate</th>
                        <th>SubObjectTypeName</th>
                        <th>SubObjectName</th>
                        <th>ObjectName</th>
                        <th>City</th>
                        <th>Country</th>
                    </tr>
                </thead>
               
                <?php
                while($row = mysqli_fetch_assoc($query_select_users_result))
                {
                    $user_object_rating_id=$row["UserObjectRatingId"];
                    $first_name=$row["FirstName"];
                    $last_name=$row["LastName"];
                    $rating_description=$row["RatingDescription"];
                    $created_date=$row["CreatedDate"];
                    $tmp_date=strtotime($created_date);
                    $date=date("d-m-Y",$tmp_date);
                    $subobject_type_name=$row["SubObjectTypeName"];
                    $subobject_name=$row["SubObjectName"];
                    $object_name=$row["ObjectName"];
                    $city_name=$row["CityName"];
                    $country_name=$row["CountryName"];
                    ?>
                    <tr>
                        <th style="padding: 0.5rem;"><?php echo $user_object_rating_id;?></th>
                        <th style="padding: 0.5rem;"><?php echo $first_name;?></th>
                        <th style="padding: 0.5rem;"><?php echo $last_name;?></th>
                        <th style="padding: 0.5rem;"><?php echo $rating_description;?></th>
                        <th style="padding: 0.5rem;"><?php echo $date;?></th>
                        <th style="padding: 0.5rem;"><?php echo $subobject_type_name;?></th>
                        <th style="padding: 0.5rem;"><?php echo $subobject_name;?></th>
                        <th style="padding: 0.5rem;"><?php echo $object_name;?></th>
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