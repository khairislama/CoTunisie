<?php
session_start();
if (ISSET($_SESSION['id'])){
    include("../Server/Config.php");
    $id_corona = $_GET['id'];
    $res = mysqli_query($c, "DELETE FROM `corona` WHERE id_corona='$id_corona'");
    mysqli_close($c);
    header("location:../corona.php?id=".$id_corona);
}else {
    header("location:../login.php");
}
?>