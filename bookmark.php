<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $bookmark=mysqli_query($c, "select * from bookmark where id_user='$id_user'");
    ?>
    <section id="header" class="jumbotron text-center">
        <h3 class="display-4 pt-0">Vous prenez le volant ? Dites-nous où vous allez !</h3>
        <hr class="my-3">
        <p class="lead">Ensemble, permettons à des millions de personnes de se déplacer.</p>
        <a class="btn btn-primary btn-lg" href="newtrajet.php">Proposer un trajet</a>
    </section>
    <div class="article">
    <h2 class="text-center">Vos trajets enregistré</h2>
    <hr>
    <?php
    if (mysqli_num_rows($bookmark)== 0) {
        echo "<h1 class=\"text-center\">Il n'y a actuellement aucun enregistrement</h1>";
    }else {
        ?>
            <div class="row">
            <?php
            while ($b = mysqli_fetch_array($bookmark)) {
                $trajet_detail = mysqli_query($c, "select * from trajet where id_trajet='$b[2]'");
                $l = mysqli_fetch_array($trajet_detail);
                ?>
                    <div class="col-md-5 article">
                        <h6 class='text-center'><span class="float-left">DE : <?=$l[1]?></span>  <span>A : <?=$l[3]?></span></h6>
                        <hr>
                        <?php
                        $date=date_create($l[5]);
                        $time=strtotime($l[6]);
                        ?>
                        <p class='text-center'><span class="float-left">DATE: <?= date_format($date, "D, d M") ?></span> <span>HEURE: <?= date("H:i", $time) ?></span></p>
                        <p class='text-center'><span class="float-left">Nombre Place : <?=$l[8]?></span> <span>Prix: <?=$l[9]?>Dt</span></p>
                        <div class="article-foot">
                            <?php
                            $user_info = mysqli_query($c, "select * from user where id_user='$l[10]'");
                            $u=mysqli_fetch_array($user_info)
                            ?>
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-user-circle fa-3x"></i>
                                </div>
                                <div class="col-10">
                                    <p><a href="profile.php?profile=<?= $u[0] ?>"><?= $u[2] ?> <?= $u[1] ?></a>
                                        <a href="showcov.php?trajet=<?= $l[0] ?>" class="btn btn-primary float-right">More info</a>
                                    </p>
                                    <?php
                                    $rating = mysqli_query($c, "select avg(note), count(note) from rating where id_a='$u[0]'");
                                    $r = mysqli_fetch_array($rating);
                                    echo "<p><i class=\"far fa-star\"></i> ".number_format($r[0], 1)."/5 - ".$r[1]." votes</p>";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            } ?>
            </div>
        </div>
        <?php
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>