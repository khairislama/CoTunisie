<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $id_message = $_GET['message'];
    $message_info = mysqli_query($c, "select * from message where id_message=$id_message");
    $m=mysqli_fetch_array($message_info);

    if ($id_user != $m[3] && $id_user != $m[4]){echo "erreur! suppression impossible.";}else {
        $res = mysqli_query($c, "delete from message where id_message='$id_message'");
        mysqli_close($c);
        header("location:boitemessages.php");
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>
