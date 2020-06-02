<?php
session_start();
if (ISSET($_SESSION['id'])){
    include("../Server/Config.php");
    $id_com = $_GET['id'];
    $id_corona = $_GET['corona'];
    $res = mysqli_query($c, "DELETE FROM `comentaires` WHERE id_com='$id_com'");
    mysqli_close($c);
    header("location:../showcor.php?id=".$id_corona);
}else {
    header("location:../login.php");
}
?>