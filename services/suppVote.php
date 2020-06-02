<?php
session_start();
if (ISSET($_SESSION['id'])){
    include("../Server/Config.php");
    $id_de = $_GET['de'];
    $id_a = $_GET['a'];
    $res = mysqli_query($c, "DELETE FROM `rating` WHERE id_de='$id_de' and id_a='$id_a'");
    mysqli_close($c);
    header("location:../profile.php?profile=".$id_a);
}else {
    header("location:../login.php");
}
?>