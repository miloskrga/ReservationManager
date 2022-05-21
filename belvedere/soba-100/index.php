
                                <?php

                                session_start();
                                require_once '../../../BLL/DbHandler.php';
                                $possition = '';
                                $page_name = 'subobject';

                                $from = '';
                                $to = '';

                                if(isset($_SESSION['dolazak']) && isset($_SESSION['odlazak']))
                                {
                                    $from = $_SESSION['dolazak'];
                                    $to = $_SESSION['odlazak'];
                                }

                                //Ovde ispisati proveru za rezervaciju

                                //!!!!!!!!!!!!!!!!!!!!!!!
                            
                                $query_select_sub_object = 'SELECT * FROM `subobject` INNER JOIN `object` ON `subobject`.ObjectId = object.ObjectId INNER JOIN subobjecttype ON subobject.SubObjectTypeId=subobjecttype.SubObjectTypeId INNER JOIN city ON object.CityId=City.CityId INNER JOIN country ON city.CountryId = country.CountryId WHERE SubObjectId = 99';
                                $query_select_sub_object_result = mysqli_query($connection, $query_select_sub_object);
                                $query_select_sub_object_count = mysqli_num_rows($query_select_sub_object_result);
                                
                                if($query_select_sub_object_count > 0)
                                {   
                                    if(!$query_select_sub_object_result)
                                    {
                                        die('Query failed: '. mysqli_connect_error($connection));
                                    }
                                    else
                                    {
                                        while($row = mysqli_fetch_assoc($query_select_sub_object_result))
                                        {
                                            $id_sub_object = $row['SubObjectId'];
                                            $title_sub_object = $row['SubObjectName'];
                                            $link_sub_object = $row['SubObjectLink'];
                                            $address_object = $row['Address'];
                                            $image_sub_object = $row['SubObjectImage'];
                                            $id_city = $row['CityId'];
                                            $id_sub_object_type = $row['SubObjectTypeId'];
                                            $city_name = $row['CityName'];
                                            $country_name = $row['CountryName'];
                                            $sub_object_type = $row['SubObjectTypeName'];
                                            $object_name=$row['ObjectName'];
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
                                    <title><?php echo $title_sub_object; ?></title>
                                    <link rel='stylesheet' href='../../../css/main.css'>
                                    <link rel='stylesheet' href='../../../css/homemain.css'>
                                    <link rel='stylesheet' href='../../../css/current-object.css'>
                                    <script src='../../../js/fontawesome.min.js'></script>
                                </head>
                                <body>
                                    <?php require_once '../../../includes/navigation.php'; ?>
                                    <main>
                                        <section class='container-current-object'>
                                            <div class='container'>
                                                <div class='current-object-content'>
                                                    <div id='reservation-message'>

                                                    </div>
                                                    <div class='content-address-button'>   
                                                        <div>
                                                            <h1><?php echo $title_sub_object.' - '.$sub_object_type; ?></h1>
                                                            <h3><?php echo $object_name;?></h3>
                                                            <p class='address-object'><i class='fas fa-map-marker-alt'></i><?php echo $address_object.', '.$city_name.', '.$country_name; ?></p>
                                                        </div>
                                                        <div class='wrapper-reservation'>
                                                        <?php
                                                            if(isset($_SESSION['id_user']))
                                                            {
                                                                ?>
                                                                <button type='button' onclick='reserved(<?php echo $id_sub_object; ?>);'>Rezerve</button>
                                                                <?php
                                                            }
                                                        ?>
                                                        </div>
                                                    </div>
                                                    <div class='wrapper-object-image'>
                                                        <?php   

                                                        $query_select_photos = 'SELECT * FROM photo INNER JOIN subobject ON photo.SubObjectId = subobject.SubObjectId WHERE subobject.SubObjectId = 99';
                                                        $query_select_photos_result = mysqli_query($connection, $query_select_photos);
                                                        $query_select_photos_count = mysqli_num_rows($query_select_photos_result);
                                                        
                                                        if($query_select_photos_count > 0)
                                                        {
                                                            if(!$query_select_photos_result)
                                                            {
                                                                die('Query failed: '. mysqli_connect_error($connection));
                                                            }
                                                            else
                                                            {
                                                                
                                                                ?>
                                                                <div class='slideshow-container'>
                                                                <?php
                                                                while($row = mysqli_fetch_assoc($query_select_photos_result))
                                                                {
                                                                    $id_photo = $row['PhotoId'];
                                                                    $sub_object_id = $row['SubObjectId'];
                                                                    $image_photo = $row['PhotoPath'];
                                                                    $price_sub_object = $row['Price'];
                                                                    $image_sub_object = $row['SubObjectImage'];
                                                                    $link_sub_object = $row['SubObjectLink'];
                                                                    $id_type_sub_object = $row['SubObjectTypeId'];
                                                                ?>
                                                                    <div class='mySlides1'>
                                                                        <img src='<?php echo $image_photo; ?>' style='width:100%'>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                    <a class='prev' onclick='plusSlides(-1, 0)'>&#10094;</a>
                                                                    <a class='next' onclick='plusSlides(1, 0)'>&#10095;</a>
                                                                </div> 
                                                                <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $query_select_subobject = 'SELECT * FROM subobject WHERE SubObjectId = 99';
                                                            $query_select_subobject_result = mysqli_query($connection, $query_select_subobject);

                                                            if(!$query_select_subobject_result)
                                                            {
                                                                die('Query failed: '. mysqli_connect_error($connection));
                                                            }
                                                            else
                                                            {
                                                                $row = mysqli_fetch_assoc($query_select_subobject_result);
                                                                $subobject_main_image = $row['SubObjectImage'];
                                                                ?>
                                                                <div class='slideshow-container'>
                                                                    <div class='mySlides1'>
                                                                        <img src='<?php echo $subobject_main_image; ?>' style='width:100%'>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    </div>
                                                    <div class='wrapper-object-description'>
                                                        <div class='container'>
                                                            <p class='title-equipment'>Equipment</p>
                                                            <hr class='hr-equipment'>
                                                            <div class='row'>
                                                        <?php
                                                            $query_select_equipment = 'SELECT equipment.EquipmentId, equipment.EquipmentName, equipment.equipment_image FROM equipment  INNER JOIN subobjequipment ON equipment.EquipmentId=subobjequipment.EquipmentId INNER JOIN subobject ON subobjequipment.SubObjectId=subobject.SubObjectId WHERE subobject.SubObjectId= 99';
                                                            $query_select_equipment_result = mysqli_query($connection, $query_select_equipment);
                                                            $query_select_equipment_count = mysqli_num_rows($query_select_equipment_result);
                                                            
                                                            if($query_select_equipment_count > 0)
                                                            {
                                                                if(!$query_select_equipment_result)
                                                                {
                                                                    die('Query failed: '. mysqli_connect_error($connection));
                                                                }
                                                                else
                                                                {
                                                                    while($row = mysqli_fetch_assoc($query_select_equipment_result))
                                                                    {
                                                                        $id_equipment = $row['EquipmentId'];
                                                                        $equipment_name = $row['EquipmentName'];
                                                                        $equipment_image = $row['equipment_image'];
                                                                        ?>
                                                                        <div class='column-equipment'>
                                                                            <div class='column-equipment-item'>
                                                                                <img src='../../../Icons/<?php echo $equipment_image; ?>'>
                                                                                <p><?php echo $equipment_name;?></p>
                                                                            </div>
                                                                        </div>
                                                                        <?php
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
                                            </div>
                                        </section>
                                        <section class='container-user-comments'>
                                            <div class='container'>
                                                <div class='wrapper-user-comments'>
                                                    <?php
                                                    if(isset($_SESSION['id_user']))
                                                    {
                                                        ?>
                                                        <p>Leave a comment</p>
                                                        <div class='form-class'>
                                                            <textarea id='comment' placeholder='Your comment'></textarea>
                                                            <button type='button' onclick='leaveComment(99);'>Send</button>
                                                            <p style='font-size: 1.5rem; color: red;' id='leave-comment-error'></p>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div id='comments' class='comments'>
                                                        <p>Comments:</p>
                                                    <?php

                                                        $query = 'SELECT * FROM userobjectrating INNER JOIN user ON userobjectrating.UserId = user.UserId WHERE SubObjectId = 99';
                                                        $query_result = mysqli_query($connection, $query);

                                                        if(!$query_result)
                                                        {
                                                            die('Query failed: '. mysqli_connect_error($connection));
                                                        }
                                                        else
                                                        {
                                                            $query_result_count = mysqli_num_rows($query_result);
                                                            if($query_result_count > 0)
                                                            {
                                                                while($row = mysqli_fetch_assoc($query_result))
                                                                {                                                            
                                                                    $user_object_rating_id = $row['UserObjectRatingId'];
                                                                    $rating_description = $row['RatingDescription'];
                                                                    $user_name = $row['FirstName'];
                                                                    $user_last_name = $row['LastName'];
                                                                    $user_id = $row['UserId'];
                                                                    $created_date_comment = $row['CreatedDate'];
                                                                    ?>

                                                                    <div class='comment-post'>
                                                                        <div class='comment-about'>
                                                                            <span><?php echo $user_name .' '. $user_last_name; ?></span>
                                                                            <span><?php echo $created_date_comment; ?></span>
                                                                        </div>
                                                                        <div class='comment-description'>
                                                                            <p><?php echo $rating_description; ?></p>
                                                                        </div>
                                                                    </div>

                                                                    <?php
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo '<p>No comments</p>';
                                                            }
                                                        }

                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </main>
                                    <?php require_once '../../../includes/footer.php'; ?>

                                    <script>
                                        var slideIndex = [1,1];
                                        var slideId = ['mySlides1', 'mySlides2']
                                        showSlides(1, 0);
                                        showSlides(1, 1);

                                        function plusSlides(n, no) {
                                        showSlides(slideIndex[no] += n, no);
                                        }

                                        function showSlides(n, no) {
                                        var i;
                                        var x = document.getElementsByClassName(slideId[no]);
                                        if (n > x.length) {slideIndex[no] = 1}    
                                        if (n < 1) {slideIndex[no] = x.length}
                                        for (i = 0; i < x.length; i++) {
                                            x[i].style.display = 'none';  
                                        }
                                        x[slideIndex[no]-1].style.display = 'block';  
                                        }
                                    </script>
                                    <script src='../../../js/functions.js'></script>

                                    <script>
                                    
                                    function reserved(id_sub_object_param)
                                    {
                                        var id_sub_object = id_sub_object_param;
                                        var form_data = new FormData();

                                        form_data.append('id-sub-object', id_sub_object);
                                        
                                        ajax = new XMLHttpRequest();

                                        ajax.onload = function()
                                        {
                                            document.getElementById('reservation-message').innerHTML = this.responseText;
                                        }
                                        ajax.open('POST', '../../../get-reservation.php', true);
                                        ajax.send(form_data);
                                    }    

                                    </script>
                                </body>
                            </html>
                        