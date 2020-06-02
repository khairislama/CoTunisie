<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $id_trajet = $_GET['trajet'];
    $trajet = mysqli_query($c, "select * from trajet where id_trajet=$id_trajet");
    $l = mysqli_fetch_array($trajet);
    if ($id_user != $l[10]){echo "erreur! suppression impossible.";}else {
        $user = mysqli_query($c, "select * from user where id_user = $id_user");
        $u = mysqli_fetch_array($user);
        ?>
        <div class="profile-card">
            <div class="image-container">
                <!--            <img src="assets/imgs/bg.png" style="width: 100%">-->
                <i class="fas fa-user-circle fa-10x"></i>
                <div class="title mt-3">
                    <h2>Supprimer le trajet du <?= $l[5] ?>?</h2>
                </div>
            </div>
            <div class="main-container">
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <input type="password" name="mdp" placeholder="mot de passe" class="form-control"
                               aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                    </div>
                    <button name="submit" type="supprimer" class="btn btn-danger mt-3 btn-lg btn-block">Submit</button>
                </form>
            </div>
        </div>
        <?php
    }
    if (ISSET($_POST['submit'])){
        $mdp = $_POST['mdp'];
        if ($mdp == $u[4]){
            $res=mysqli_query($c, "delete from trajet where id_trajet='$id_trajet'");
            mysqli_close($c);
            header("location:trajets.php?id_user=".$id_user);
        }else {
            echo"Mot de passe invalide";
        }
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>
