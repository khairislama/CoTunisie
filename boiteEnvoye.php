<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $message=mysqli_query($c, "select * from message where id_envoye='$id_user' order by date desc");
        ?>
        <div style="width: 55%;margin: 25px auto;">
            <h2 class="text-center my-5">Votre Boite de Messagerie</h2>
            <ul class="nav justify-content-around nav-tabs mb-0">
                <li class="nav-item">
                    <a class="nav-link" href="boitemessages.php">Réception</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info active" href="#">Envoyé</a>
                </li>
            </ul>
            <hr class="mt-0">
            <?php
    if (mysqli_num_rows($message)== 0) {
        echo "<h1 class=\"text-center\">Il n'y a actuellement aucun message</h1>";
    }else {
            while ($m = mysqli_fetch_array($message)) {
                $user_detail = mysqli_query($c, "select * from user where id_user='$m[4]'");
                $u = mysqli_fetch_array($user_detail);
                $date=date_create($m[5]);
                ?>
                <div class="article">
                    <div class="row">
                        <div class="col-4">
                            <p>A : <a href="profile.php?profile=<?=$u[0]?>"><?= $u[2] ?> <?= $u[1] ?></a></p>
                        </div>
                        <div class="col-8">
                            <p>OBJET : <?= $m[1] ?></p>
                        </div>
                    </div>
                    <p><?= $m[2] ?></p>
                    <br>
                    <p><i><?= date_format($date, "D, d M") ?></i></p>
                    <hr>
                    <a href="supprimerMessage.php?message=<?= $m[0] ?>" class="btn btn-danger btn-block">supprimer</a>
                </div>

                <?php
            } ?>
        </div>
        <?php
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>