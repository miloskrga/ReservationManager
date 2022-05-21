<?php

    session_start();
    $_SESSION["id_user"] = null;
    $_SESSION['FirstName'] = null;
    $_SESSION['LastName'] = null;
    header("Location: main.php");

?>