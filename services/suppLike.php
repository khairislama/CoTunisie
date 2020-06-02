<?php
session_start();
if (ISSET($_SESSION['id'])){
    include("../Server/Config.php");
    $id_user = $_SESSION['id'];
    $id_corona = $_GET['id'];
    $res = mysqli_query($c, "DELETE FROM `likes` WHERE id_corona='$id_corona'");
    mysqli_close($c);
    header("location:../showcor.php?id=".$id_corona);
}else {
    header("location:../login.php");
}
?>