<?php
require_once("BLL/DbHandler.php");
require_once("funkcije.php");
session_start();
$possition ="";

if(isset($_GET['odjava'])){
    logout();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main page</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/homemain.css">

    <style>

    header{
        margin-bottom: 0;
    }

    .container-main-part{
        margin-bottom: 5rem;
        background-image: url("objekti/london-grange-white-hall/london-grange-white-hall.jpg");
        background-repeat: no-repeat;
        background-size: cover;
    }

    .container-main-part .wrapper-main-title{
        padding: 10rem 0;
        text-align: center;
    }

    .container-main-part .wrapper-main-title h1{
        margin: 0;
        color: #fff;
        font-size: 4rem;
    }

    .container-main-part .wrapper-main-title p{
        max-width: 800px;
        width: 100%;
        color: #fff;
        margin-top: 2rem;
        margin-left: auto;
        margin-right: auto;
        font-size: 1.7rem;
    }

    .title-recomended-objects{
        max-width: 100%;
        flex-basis: 100%;
        width: 100%;
        position: relative;
        padding-left: 15px;
        padding-right: 15px;
        margin-bottom: 2rem;
    }

    .title-recomended-objects h2{
        text-align: center;
        font-size: 2.7rem;
    }

    .glavni .gallery1{
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 12px 2px #a9a9d9;
    }

    .glavni .gallery1 .desc p b{
        font-size: 1.5rem
    }

    </style>
    
</head>
<body>
    <?php require_once "includes/navigation.php"; ?>
    <main>
        <div class="container-main-part">
            <div class="container">
                <div class="wrapper-main-title">
                    <h1>Rent ideal accommodation</h1>
                    <p>Reservation manager is site for register users and booking ideal accommodation. Also, users have the opportunity to post their offers. Register and book your favorite accommodation!</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="title-recomended-objects">
                    <h2>We single out from the offer</h2>
                </div>
            <?php 
            
            $query_select_objects = "SELECT * FROM `object`";
            $query_select_objects_result = mysqli_query($connection, $query_select_objects);
            $query_select_objects_num_rows = mysqli_num_rows($query_select_objects_result);
    
            if($query_select_objects_num_rows > 0)
            {
                if(!$query_select_objects_result)
                {
                    die("Query failed: " . mysqli_connect_error($connection));
                }
                else
                {
                    while($row = mysqli_fetch_assoc($query_select_objects_result))
                    {
                        $object_id = $row["ObjectId"];
                        $object_name = $row["ObjectName"];
                        $object_image = $row["ObjectImage"];
                        $object_link = $row["ObjectLink"];
                        ?>
    
                        <div class="glavni">
                            <div class="gallery1">
                                <a target="_self" href="objekti/<?php echo $object_link; ?>">
                                    <img src="objekti/<?php echo $object_link.$object_image; ?>" alt="<?php echo $object_name; ?>">
                                </a>
                                <div class="desc">
                                    <p><b><?php echo $object_name; ?></b></p>
                                </div>
                            </div>
                        </div>
    
                        <?php
                    }
                }
            }
            else
            {
                ?>
    
                <p style="font-size: 1.5rem;">There are currently no rental facilities.</p>
    
                <?php
            }
            ?>
            </div>

        </div>
    </main>
    <?php require_once "includes/footer.php"; ?>
</body>
</html>