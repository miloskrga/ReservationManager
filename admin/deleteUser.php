<?php

    session_start();
    require_once "../BLL/DbHandler.php";
    require_once "../funkcije.php";
    $possition = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        if(isset($_POST["id_user"]))
        {
            $id_user = $_POST["id_user"];

            $query_update_status = "DELETE user SET StatusId = 1 WHERE UserId = $id_user";
            $query_update_status_result = mysqli_query($connection, $query_update_status);

            if(!$query_update_status_result)
            {
                die("Query failed:" .mysqli_connect_error($connection));
            }
            else
            {   
                $query_select_users = "SELECT * FROM `user` inner join city on `user`.CityId=city.CityId inner join country on city.CountryId=country.CountryId where `user`.StatusId!=3";
                $query_select_users_result = mysqli_query($connection, $query_select_users);

                if(!$query_select_users_result)
                {
                    die("Query failed:" .mysqli_connect_error($connection));
                }
                else
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
                        <tbody>
                    <?php

                    $result = "";
                    $string = "";

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

                        if($status == 2)
                        { 
                            $string = "<button onclick='changeStatus($id_user);'>Change to owner</button>";
                        }
                        else
                        {
                            $string = "Owner";
                        }
                
                        $result .="<tr>
                            <td style='padding: 0.5rem;'>$id_user</td>
                            <td style='padding: 0.5rem;'>$first_name</td>
                            <td style='padding: 0.5rem;'>$last_name</td>
                            <td style='padding: 0.5rem;'>$email</td>
                            <td style='padding: 0.5rem;'>$date</td>
                            <td style='padding: 0.5rem;'>$gender</td>
                            <td style='padding: 0.5rem;'>$city_name</td>
                            <td style='padding: 0.5rem;'>$country_name</td>
                            <td style='padding: 0.5rem;'>$string</td>
                            <td style='padding: 0.5rem;'><button onclick='deleteUser($id_user);'>Delete</button></td>
                        </tr>";
                    }

                    echo $result;
                    ?>
                        </tbody>
                    </table>
                    <?php
                }
            }
        }
    }

?>