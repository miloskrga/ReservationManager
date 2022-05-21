<style>

    #elementi form > select{
        padding: 0.2rem 0.3rem;
        border: 1px solid lightgrey;
        outline: 0;
        border-radius: 3px;
        cursor: pointer;
    }

    #elementi form > input[type="date"]{
        padding: 0.2rem 0.3rem;
        border: 1px solid lightgrey;
        outline: 0;
        border-radius: 3px;
        cursor: pointer;
    }

    #elementi form > input[type="submit"]{
        padding: 0.2rem 1rem;
        border: 1px solid lightgrey;
        outline: 0;
        border-radius: 3px;
        font-size: 0.9rem;
        cursor: pointer;
    }

</style>

<header>
    <div class="container">
        <div class="wrapper-navigation">
            <h1>Reservation Manager</h1>
            <div class="log">
                <?php
                if(isset($_SESSION["id_user"]))
                {
                    $id_user=$_SESSION["id_user"];
                    $query="SELECT StatusId from `user` where UserId=$id_user";
                    $query_result = mysqli_query($connection, $query);
                    $query_result_count = mysqli_num_rows($query_result);

                    if($query_result_count > 0)
                    {
                        if(!$query_result)
                        {
                            die("Query failed:" .mysqli_connect_error($connection));
                        }
                        else
                        {
                            $row = mysqli_fetch_assoc($query_result);
                            if($row['StatusId']==1){
                                echo '<a href="http://localhost/Hotel/makeoffer.php" style="text-decoration: none; font-size: 20px; color:white;">Makeoffer</a>';
                                echo '<a href="http://localhost/Hotel/information.php" style="text-decoration: none; font-size: 20px; color:white;">Information</a>';
                            }
                        }
                    }
                    if($possition !== "subobject")
                    {
                        echo '<a href="http://localhost/Hotel/profile.php" style="text-decoration: none; font-size: 20px; color:white;">Profile</a>';
                    }
                    echo '<a href="http://localhost/Hotel/logout.php" style="text-decoration: none; font-size: 20px; color:white;">LogOut</a>';
                    
                }
                else
                {
                    echo '<a href="http://localhost/Hotel/registration.php" style="text-decoration: none; font-size: 20px; color:white; position:relative; float: right; margin-left: 20px;">SignUp</a>';
                    echo '<a href="http://localhost/Hotel/login.php" style="text-decoration: none; font-size: 20px; color:white; position:relative; float: right;">LogIn</a>';
                }

                ?>
            </div>
        </div>
    </div>

    <?php 
    
        if($possition == "home")
        {
            ?>

            <div class="meni">
                <div class="container">
                    <div id="navigacija">
                        <div id="elementi">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                            Object:&nbsp;&nbsp;<select name="objecttype" id="objecttype" onchange="prikaziObjekat()" style="margin-right: 20px;">
                                    <option value="null">--Choose Object--</option>
                                    <?php
                                        $query="SELECT ObjectTypeId, ObjectTypeName from objecttype";
                                        if($rez=mysqli_query($connection,$query)){
                                            while($red = mysqli_fetch_array($rez,MYSQLI_BOTH)){
                                                echo '<option value='.$red['ObjectTypeId'].'>'.$red['ObjectTypeName'].'</option>';
                                            }
                                        }
                                        else{
                                            
                                            echo "Poruka o gresci:".mysqli_error($connection);
                                        }   
                                    ?>
                                </select>
                            SubObject:&nbsp;&nbsp;<select name="subobjecttype" id="subobjecttype" style="margin-right: 20px;">
                                    <option value="null">--Choose SubObject--</option>
                                </select>
                                Arrival:&nbsp;&nbsp;<input type="date" name="dolazak" id="dolazak" style="margin-right: 20px;">
                                Departure:&nbsp;&nbsp;<input type="date" name="odlazak" id="odlazak" style="margin-right: 20px;">

                                Country:&nbsp;&nbsp;<select name="country" id="country" onchange="prikaziDrzavu()" style="margin-right: 20px;">
                                    <option value="null">--Choose Country--</option>
                                    <?php
                                        
                                        $query="SELECT CountryId, CountryName from country";
                                        if($rez=mysqli_query($connection,$query)){
                                            
                                            while($red = mysqli_fetch_array($rez,MYSQLI_BOTH)){
                                                echo '<option value='.$red['CountryId'].'>'.$red['CountryName'].'</option>';
                                            }
                                        }
                                        else{
                                        
                                            echo "Poruka o gresci:".mysqli_error($connection);
                                        }
                                           
                                    ?>
                                </select>
                                City:&nbsp;&nbsp;<select name="city" id="city">
                                    <option value="null">--Choose City--</option>
                                </select>
                                <input type="submit" id="submit" style="margin-left: 10px;">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }

    ?>
</header>