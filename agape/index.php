
                            <?php

                            session_start();
                            require_once '../../BLL/DbHandler.php';
                            $possition = '';
                        
                            $query_select_object = 'SELECT * FROM `object` INNER JOIN city ON `object`.CityId = city.CityId INNER JOIN country ON city.CountryId = country.CountryId INNER JOIN objecttype ON `object`.ObjectTypeId = objecttype.ObjectTypeId WHERE ObjectId = 45';
                            $query_select_object_result = mysqli_query($connection, $query_select_object);
                            $query_select_object_count = mysqli_num_rows($query_select_object_result);
                            
                            if($query_select_object_count > 0)
                            {
                                if(!$query_select_object_result)
                                {
                                    die('Query failed: '. mysqli_connect_error($connection));
                                }
                                else
                                {
                                    while($row = mysqli_fetch_assoc($query_select_object_result))
                                    {
                                        $id_object = $row['ObjectId'];
                                        $title_object = $row['ObjectName'];
                                        $link_object = $row['ObjectLink'];
                                        $description_object = $row['ObjectDescription'];
                                        $address_object = $row['Address'];
                                        $image_object = $row['ObjectImage'];
                                        $id_city = $row['CityId'];
                                        $id_object_type = $row['ObjectTypeId'];
                                        $city_name = $row['CityName'];
                                        $country_name = $row['CountryName'];
                                        $object_type = $row['ObjectTypeName'];
                                    }
                                }
                            }
                            else
                            {
                        
                            }
                        
                            ?>
                            
                            <!DOCTYPE html>
                            <html lang='en'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <title><?php echo $title_object; ?></title>
                                <link rel='stylesheet' href='../../css/main.css'>
                                <link rel='stylesheet' href='../../css/homemain.css'>
                                <link rel='stylesheet' href='../../css/current-object.css'>
                                <script src='../../js/fontawesome.min.js'></script>
                            </head>
                            <body>
                                <?php require_once '../../includes/navigation.php'; ?>
                                <main>
                                    <section class='container-current-object'>
                                        <div class='container'>
                                            <div class='current-object-content'>
                                                <div class='content-address-button'>   
                                                    <div>
                                                        <h1><?php echo $title_object.' - '.$object_type; ?></h1>
                                                        <p class='address-object'><i class='fas fa-map-marker-alt'></i><?php echo $address_object.', '.$city_name.', '.$country_name; ?></p>
                                                    </div>
                                                    <!--<div class='wrapper-reservation'>
                            
                                                    </div>-->
                                                </div>
                                                <div class='wrapper-object-image'>
                                                    <img src='<?php echo $image_object; ?>' alt=''>
                                                </div>
                                                <div class='wrapper-object-description'>
                                                    <h4>Object Description</h4>
                                                    <hr>
                                                    <p><?php echo $description_object; ?></p>
                                                </div>
                                                <div class='wrapper-sub-objects'>
                                                    <div class='row'>
                                                    <?php
                                                
                                                        $query_select_sub_object = 'SELECT * FROM `subobject` INNER JOIN object ON `subobject`.ObjectId = `object`.ObjectId WHERE subobject.ObjectId = 45';
                                                        $query_select_sub_object_result = mysqli_query($connection, $query_select_sub_object);
                                                        $query_select_sub_object_result_count = mysqli_num_rows($query_select_sub_object_result);
                                                        
                                                        if($query_select_sub_object_result_count > 0)
                                                        {
                                                            if(!$query_select_sub_object_result)
                                                            {
                                                                die('Query failed: '. mysqli_connect_error($connection));
                                                            }
                                                            else
                                                            {
                                                                $counter = 0;
                                                                while($row = mysqli_fetch_assoc($query_select_sub_object_result))
                                                                {
                                                                    $id_sub_object = $row['SubObjectId'];
                                                                    $title_sub_object = $row['SubObjectName'];
                                                                    $image_sub_object = $row['SubObjectImage'];
                                                                    $link_sub_object = $row['SubObjectLink'];
                                                                    $price_sub_object = $row['Price'];
                            
                                                                    if($counter == 0)  
                                                                    {
                                                                        echo '<h4 style="width: 100%; padding: 0 15px;">Look offers:</h4>';
                                                                    }
                                                                    
                                                                    ?>

                                                                    <div class='column-sub-object'>
                                                                        <div class='sub-object-item'>
                                                                            <a href='<?php echo $link_sub_object; ?>'>
                                                                                <img src='<?php echo $link_sub_object.$image_sub_object; ?>' alt='<?php echo $title_sub_object; ?>'>
                                                                            </a>
                                                                            <p><?php echo $title_sub_object; ?></p>
                                                                        </div>
                                                                    </div>
                            
                                                                    <?php
                                                                    $counter++;
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                            
                                                        }
                                                        ?>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </main>
                                <?php require_once '../../includes/footer.php'; ?>
                            </body>
                        </html>
                    