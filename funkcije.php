<?php

function logout(){
    session_unset();
    session_destroy();
    setcookie("id_user","",time()-1,"/");
}

function login(){
    if(isset($_SESSION['id_user'])){
        return true;
    }
    else{
        if(isset($_COOKIE['id_user'])){
            $_SESSION['id_user']=$_COOKIE['id_user'];
            
            return true;
        }
        else{
            return false;
        }
    }
}
?>