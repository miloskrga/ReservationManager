<?php
session_start();
require_once "BLL/DbHandler.php";
require_once "funkcije.php";
$possition = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["name-object"]) && isset($_POST["address-object"]) && isset($_FILES["image-object"]) && isset($_POST["city-object"]) && isset($_POST["type-object"]) && isset($_POST["description-object"]))
    {
        include "includes/create-post.php";
    }

    if(isset($_POST["edit-name-object"]) && isset($_POST["edit-address-object"]) && isset($_FILES["edit-image-object"]) && isset($_POST["edit-city-object"]) && isset($_POST["edit-type-object"]) && isset($_POST["edit-description-object"]))
    {
        include "includes/update-post.php";
    }

    if(isset($_POST["edit-name-sub-object"]) && isset($_POST["edit-price-sub-object"]) && isset($_FILES["edit-image-sub-object"]) && isset($_POST["edit-type-sub-object"]))
    {
        include "includes/update-sub-post.php";
    }

    if(isset($_POST["name-sub-object"]) && isset($_POST["price-object"]) && isset($_FILES["image-sub-object"]) && isset($_POST["type-sub-object"]))
    {   
        include "includes/create-sub-object.php";
    }
}

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET["delete-sub-object"]))
    {   
        include "includes/delete-sub-object.php";
    }

    if(isset($_GET["delete-object"]))
    {   
        include "includes/delete-object.php";
    }
}


if(!login()){
    echo "You must be logged in to view this page!<br>";
    echo '<a href="login.php">Prijavi se</a>';
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/homemain.css">
    <link rel="stylesheet" href="css/makeoffer.css">
</head>
<body>
    <?php require_once "includes/navigation.php"; ?>
    <div class="container">
    <?php
    
    if(isset($_GET["operation"]))
    {
        $operation = $_GET["operation"];
    }
    else
    {
        $operation = "";
    }

    switch($operation)
    {
        case "add-post":
            include "includes/add-post.php";
            break;

        case "edit-post":
            include "includes/edit-post.php";
            break;

        case "edit-sub-post":
            include "includes/edit-sub-post.php";
            break;

        case "add-sub-post":
            include "includes/add-sub-post.php";
            break;

        case "sub-post":
            include "includes/view-all-sub-posts.php";
            break;

        default:
            include "includes/view-all-posts.php";
            break;
    }
    ?>
    </div>
    <?php
        include "includes/footer.php";
    ?>

<script>

    <?php
    
    if(isset($_GET["operation"]))
    {
        $operation = $_GET["operation"];
        if($operation == "edit-sub-post")
        {
            ?>

            function createTagElement(e)
            {
                var id = e.id;
                var wrapper_other_content_post = document.getElementById("wrapper-other-content-post");

                switch(id)
                {
                    case "img":
                        wrapper_other_content_post.innerHTML += "<div class='display: flex; flex-wrap: wrap;'><input required type='file' id='customFile' name='customFile'><button type='button' onclick='<?php echo "saveChanges($id_sub_object);" ?>'>Save</button><button type='button' onclick='closeElement(this);'>JustLetItGo</button></div>";
                        break;
                }
            }

            <?php
        }
    }
    
    ?>

    function saveChanges(sub_object_id_param)
    {
        var sub_object_id = sub_object_id_param;
        var name_image = document.getElementById("customFile").files[0];

        var form_data = new FormData();
        form_data.append("Sub-Object-Id", sub_object_id);
        form_data.append("Name-Image", name_image);

        var ajax = new XMLHttpRequest();
        ajax.onload = function()
        {
            document.getElementById("wrapper-other-content-post").innerHTML = this.responseText;
        }
        ajax.open("POST", "saveData.php", true);
        ajax.send(form_data);
    }

    function changeContent(id_photo_param)
    {
        var id_photo = id_photo_param;
        var image_array = document.getElementById(id_photo).files[0];
        var form_data = new FormData();
        form_data.append("id-photo", id_photo);
        form_data.append("image-array", image_array);
        var ajax = new XMLHttpRequest();

        ajax.onload = function()
        {
            document.getElementById("wrapper-other-content-post").innerHTML = this.responseText;
        }
        ajax.open("POST", "updateData.php", true);
        ajax.send(form_data);
    }

    function removeElement(e)
    {
        var sub_object_id = e;
        form_data = new FormData();
        form_data.append("photo-id", sub_object_id);
        var ajax = new XMLHttpRequest();

        ajax.onload = function()
        {
            document.getElementById("wrapper-other-content-post").innerHTML = this.responseText;
        }
        ajax.open("POST", "removeData.php", true);
        ajax.send(form_data);
    }

    function closeElement(e)
    {
        var parentElement = e.parentElement;
        parentElement.remove();
    }

</script>
<script src="js/functions.js"></script>

</body>
</html>

