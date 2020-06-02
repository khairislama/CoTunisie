<?php
    session_start();
    if (ISSET($_SESSION['id'])){
        session_destroy();
        unset($_SESSION['id']);
        header("location:../index.php");
    }
?>