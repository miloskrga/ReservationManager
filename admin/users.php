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
    <div class="wrapper-page" id="wrapper-page">
        <?php
        $query_select_users = "SELECT * FROM `user` inner join city on `user`.CityId=city.CityId inner join country on city.CountryId=country.CountryId where `user`.StatusId!=3";
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
                            <th>UserId</th>
                            <th>FirstName</th>
                            <th>LastName</th>
                            <th>Email</th>
                            <th>BirthDate</th>
                            <th>Gender</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Status</th>
                        </tr>
                    </thead>
               
                <?php
                while($row = mysqli_fetch_assoc($query_select_users_result))
                {
                    $id_user=$row["UserId"];
                    $first_name=$row["FirstName"];
                    $last_name=$row["LastName"];
                    $email=$row["Email"];
                    $birth_date=$row["BirthDate"];
                    $timestamp = strtotime($birth_date);
                    $date = date("d-m-Y", $timestamp);
                    $gender=$row["Gender"];
                    $city_name=$row["CityName"];
                    $country_name=$row["CountryName"];
                    $status=$row["StatusId"];
                    ?>
                    <tr>
                        <td style="padding: 0.5rem;"><?php echo $id_user;?></td>
                        <td style="padding: 0.5rem;"><?php echo $first_name;?></td>
                        <td style="padding: 0.5rem;"><?php echo $last_name;?></td>
                        <td style="padding: 0.5rem;"><?php echo $email;?></td>
                        <td style="padding: 0.5rem;"><?php echo $date;?></td>
                        <td style="padding: 0.5rem;"><?php echo $gender;?></td>
                        <td style="padding: 0.5rem;"><?php echo $city_name;?></td>
                        <td style="padding: 0.5rem;"><?php echo $country_name;?></td>
                        <td style="padding: 0.5rem;"><?php if($status == 2){ echo "<button onclick='changeStatus($id_user);'>Change to owner</button>"; }else{ echo "Owner"; } ?></td>         
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
<script src="../js/functions.js"></script>