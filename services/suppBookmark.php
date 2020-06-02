<?php
session_start();
if (ISSET($_SESSION['id'])){
    include("../Server/Config.php");
    $id_user = $_SESSION['id'];
    $id_trajet = $_GET['trajet'];
    $where = $_GET['where'];
    $res = mysqli_query($c, "DELETE FROM `bookmark` WHERE id_user='$id_user' and id_trajet='$id_trajet'");
    mysqli_close($c);
    header("location:../".$where.".php?trajet=".$id_trajet);
}else {
    header("location:../login.php");
}
?>