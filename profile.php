<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (ISSET($_SESSION['id'])) {
    include("Server/Config.php");
    $id_user = $_GET['profile'];
    $id_de=$_SESSION['id'];
    $user = mysqli_query($c, "select * from user where id_user = $id_user");
    if (mysqli_num_rows($user)== 0) {
        echo "<h1 class=\"text-center\">Il n'ya rien a afficher ici </h1>";
    }else {
        $u = mysqli_fetch_array($user);
        $date=date_create($u[8]);?>
        <div class="profile-card">
            <div class="image-container">
                <!--            <img src="assets/imgs/bg.png" style="width: 100%">-->
                <i class="fas fa-user-circle fa-10x"></i>
                <div class="title mt-3">
                    <h2><?= $u[2] ?> <?= $u[1] ?></h2>
                    <?php
                    $rating = mysqli_query($c, "select avg(note), count(note) from rating where id_a='$u[0]'");
                    $r = mysqli_fetch_array($rating);
                    echo "<p><i class=\"far fa-star\"></i> ".number_format($r[0], 1)."/5 - ".$r[1]." votes</p>";
                    ?>
                </div>
            </div>
            <div class="main-container">
                <p><i class="fa fa-briefcase info"></i><?= $u[9] ?></p>
                <p><i class="fa fa-home info"></i><?= $u[7] ?>, TN</p>
                <p><i class="fa fa-envelope info"></i><?= $u[3] ?></p>
                <p><i class="fa fa-phone info"></i><?= $u[5] ?></p>
                <p><i class="fas fa-car-side info"></i><?= $u[10] ?></p>
                <p><i class="fas fa-calendar-alt info"></i>Depuis : <?= date_format($date, "D, d M") ?></p>
                <hr>

                <p><b><i class="fa fa-asterisk info"></i>Preferences</b></p>
                <?php
                $prefs=mysqli_query($c, "SELECT * FROM `preferences` WHERE id_user='$u[0]'");
                while($p=mysqli_fetch_array($prefs)) {
                    if ($p[3]==1){echo '<p><i class="fas fa-smoking-ban info"></i>Pas de fumée dans la voiture</p>';}
                    if ($p[2]==1){echo '<p><i class="fas fa-baby info"></i>Pas de bébé dans la voiture</p>';}
                    if ($p[6]==1){echo '<p><i class="fas fa-parking info"></i>Pas d\'arrêt sur la route</p>';}
                    if ($p[4]==1){echo '<p><i class="fas fa-volume-mute info"></i>Pas de musique </p>';}
                    if ($p[5]==1){echo '<p><i class="fas fa-female info"></i>Que des filles </p>';}
                    if ($p[2]==0 && $p[3]==0 && $p[4]==0 && $p[5]==0 && $p[6]==0){echo '<p class="text-center">Aucune préférence selectionné</p>';}
                }
                if ($id_user == $_SESSION['id']){
                    echo'<a class="btn btn-primary mr-3" href="trajets.php?id_user='.$id_user.'">Mes trajets</a>';
                    echo'<a href="bookmark.php" class="btn btn-primary mr-3">enregistré</a>';
                    echo'<a href="edit_profile.php" class="btn btn-primary"><i class="fas fa-user-edit"></i>Modifier</a>';
                }else {
                    $avote = mysqli_query($c, "select * from rating where id_de='$id_de' and id_a='$id_user'");
                    if (mysqli_num_rows($avote)== 0) {
                        ?>
                        <form action="" method="post">
                            <input type="number" min='0' max='5' class='mb-3' aria-describedby="addon-wrapping"
                                   name='note'>
                            <i class="far fa-star"></i>
                            <button class=' btn btn-success btn-sm' name="vote"> voter</button>
                        </form>
                        <?php
                    } else {?>
                        <a href="services/suppVote.php?de=<?= $id_de ?>&a=<?= $id_user ?>" class="text-success">supprimer mon vote</a>
                        <br><br>
                    <?php
                    }
                    echo'<a href="trajets.php?id_user='.$id_user.'" class="btn btn-primary btn-block">Les trajet de '.$u[2].'</a>';
                    echo'<a href="envoyerMessage.php?a='.$id_user.'" class="btn btn-primary btn-block">Envoyer un message</a>';
                }?>
            </div>
        </div>
        <?php
        if (ISSET($_POST['vote'])){
            $note = $_POST['note'];
            $res = mysqli_query($c, "INSERT INTO `rating`(`id_de`, `id_a`, `note`) VALUES ('$id_de', '$id_user', '$note')");
            mysqli_close($c);
            header("Location:profile.php?profile=".$id_user);
            ob_end_flush();
        }
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>
