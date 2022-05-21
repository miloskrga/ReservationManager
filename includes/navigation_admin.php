<header>
    <div class="container">
        <div class="wrapper-navigation">
            <h1>Reservation Manager Admin</h1>
            <div class="log">
                <?php
                if(isset($_SESSION["id_user"]))
                {
                    
                    echo '<a href="http://localhost/Hotel/profile_admin.php" style="text-decoration: none; font-size: 20px; color:white;">Profile</a>';
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
                            Object <select name="objecttype" id="objecttype" onchange="prikaziObjekat()" style="margin-right: 20px;">
                                    <option value="null">Object Type</option>
                                    <?php
                                        $query="SELECT ObjectTypeId, ObjectTypeName from objecttype";
                                        if($rez=mysqli_query($connection,$query)){
                                            while($red = mysqli_fetch_assoc($rez)){
                                                echo '<option value='.$red['ObjectTypeId'].'>'.$red['ObjectTypeName'].'</option>';
                                            }
                                        }
                                        else{
                                            
                                            echo "Poruka o gresci:".mysqli_error($connection);
                                        }   
                                    ?>
                                </select>
                            SubObject <select name="subobjecttype" id="subobjecttype" style="margin-right: 10px;">
                                    <option value="null">SubObject Type</option>
                                </select>
                                Date From:<input type="date" name="dolazak" id="dolazak" style="margin-right: 10px;">
                                Date To: <input type="date" name="odlazak" id="odlazak" style="margin-right: 10px;">

                                Country: <select name="country" id="country" onchange="prikaziDrzavu()" style="margin-right: 10px;">
                                    <option value="null">--Choose a country--</option>
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
                                City: <select name="city" id="city">
                                    <option value="null">--Choose a city--</option>
                                </select>
                                <input type="submit" id="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }

    ?>
</header>