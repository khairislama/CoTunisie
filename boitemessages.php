<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $message=mysqli_query($c, "select * from message where id_recep='$id_user' order by date desc");
        ?>
        <div style="width: 55%;margin: 25px auto;">
            <h2 class="text-center my-5">Votre Boite de Messagerie</h2>
            <ul class="nav justify-content-around nav-tabs mb-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Réception</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info" href="boiteEnvoye.php">Envoyé</a>
                </li>
            </ul>
            <hr class="mt-0">
            <?php
    if (mysqli_num_rows($message)== 0) {
        echo "<h1 class=\"text-center\">Il n'y a actuellement aucun message</h1>";
    }else {
            while ($m = mysqli_fetch_array($message)) {
                $user_detail = mysqli_query($c, "select * from user where id_user='$m[3]'");
                $u = mysqli_fetch_array($user_detail);
                $date=date_create($m[5]);
                ?>
                <div class="article">
                    <div class="row">
                        <div class="col-4">
                            <p>de : <?= $u[2] ?> <?= $u[1] ?></p>
                        </div>
                        <div class="col-8">
                            <p>OBJET : <?= $m[1] ?></p>
                        </div>
                    </div>
                    <p><?= $m[2] ?></p>
                    <br>
                    <p><i><?= date_format($date, "D, d M") ?></i></p>
                    <hr>
                    <a href="envoyerMessage.php?a=<?= $m[3] ?>" class="btn btn-primary btn-block">répondre</a>
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