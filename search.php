<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $clear=mysqli_query($c, "DELETE FROM trajet WHERE ddp < CURRENT_DATE()");
    $id = $_SESSION['id'];
    $villeDep = $_GET['villeDep'];
    $villeArr = $_GET['villeArr'];
    $dateDep = $_GET['ddp'];
    $res = mysqli_query($c, "SELECT * FROM `trajet` WHERE villeDep LIKE'%$villeDep%' AND villeArr LIKE '%$villeArr%' AND ddp LIKE '%$dateDep%'");
    $date = date_create($dateDep);
    ?>
    <section id="header" class="jumbotron text-center">
        <h3 class="display-4 pt-0">Tout les trajets de <?= date_format($date, "D, d M") ?></h3>
        <hr class="my-3">
        <p class="lead">Ensemble, permettons à des millions de personnes de se déplacer.</p>
        <a class="btn btn-primary btn-lg" href="newtrajet.php">Proposer un trajet</a>
    </section>
    <div class="article">
        <?php
        if (mysqli_num_rows($res) == 0) {
            echo "<h1 class=\"text-center\">Il n'y a actuellement aucun trajet disponible a cette date</h1>";
        }
        ?>
        <div class="row">
            <?php
            while ($l = mysqli_fetch_array($res)) {
                ?>
                <div class="col-md-5 article">
                    <h6 class='text-center'><span class="float-left">DE : <?= $l[1] ?></span>
                        <span>A : <?= $l[3] ?></span></h6>
                    <hr>
                    <?php
                    $date=date_create($l[5]);
                    $time=strtotime($l[6]);
                    ?>
                    <p class='text-center'><span class="float-left">DATE: <?= date_format($date, "D, d M") ?></span>
                        <span>HEURE: <?= date("H:i", $time) ?></span></p>
                    <p class='text-center'><span class="float-left">Nombre Place : <?= $l[8] ?></span>
                        <span>Prix: <?= $l[9] ?>Dt</span></p>
                    <div class="article-foot">
                        <a href="showcov.php?trajet=<?= $l[0] ?>" class="btn btn-primary">More Info</a><br>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>
