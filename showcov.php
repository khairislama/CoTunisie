<?php include("partials/header.php");
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $id_trajet = $_GET['trajet'];
    $trajet = mysqli_query($c, "select * from trajet where id_trajet = $id_trajet");
    if (mysqli_num_rows($trajet)== 0) {
        echo "<h1 class=\"text-center\">Il n'ya rien a afficher ici </h1>";
    }else {
        $l = mysqli_fetch_array($trajet);
        $user = mysqli_query($c, "select * from user where id_user = $l[10]");
        $u = mysqli_fetch_array($user);
        $date = date_create($l[5]);
        $time = strtotime($l[6]);
        ?>
        <section id="header" class="jumbotron text-center">
            <h3 class="display-4 pt-0">Vous prenez le volant ? Dites-nous où vous allez !</h3>
            <hr class="my-3">
            <p class="lead">Ensemble, permettons à des millions de personnes de se déplacer.</p>
            <a class="btn btn-primary btn-lg" href="newtrajet.php">Proposer un trajet</a>
        </section>
        <div class="article">
            <div class="text-center">
                <h1><?= date_format($date, "D, d F Y") ?></h1>
                <div class="row" style="margin-top: 50px">
                    <div class="col-5">
                        <h3><?= $l[1] ?></h3>
                        <p> <?= $l[2] ?> </p>
                    </div>
                    <div class="col-2">
                        <h3><?= date("H : i", $time) ?></h3>
                        <i class="fas fa-long-arrow-alt-right fa-5x"></i>
                    </div>
                    <div class="col-5">
                        <h3> <?= $l[3] ?> </h3>
                        <p><?= $l[4] ?></p>
                    </div>
                </div>
            </div>
            <p class="text-center">prix totale pour 1 passager : <?= $l[9] ?> Dinar</p>
            <hr>
            <div class="Profile" style="margin-left: 22%">
                <div class="row">
                    <div class="col-8">
                        <p style="margin: 0"><a href="profile.php?profile=<?= $u[0] ?>"><?= $u[2] ?> <?= $u[1] ?></a>
                        </p>
                        <?php
                        $rating = mysqli_query($c, "select avg(note), count(note) from rating where id_a='$u[0]'");
                        $r = mysqli_fetch_array($rating);
                        echo "<p style=\"margin: 0\"><i class=\"far fa-star\"></i> " . number_format($r[0], 1) . "/5 - " . $r[1] . " votes</p>";
                        ?>
                        <div class="row">
                            <div class="col-1">
                                <i class="fas fa-phone mt-2"></i>
                            </div>
                            <div class="div-11">
                                <p style="margin: 0"><?= $l[7] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4"><i class="fas fa-user fa-5x"></i></div>
                </div>
            </div>
            <hr>
            <div class="precotions" style="margin-left: 22%">
                <div class="row">
                    <div class="col-1">
                        <i class="fas fa-people-arrows mt-2 fa-2x"></i>
                    </div>
                    <div class="div-11">
                        <p style="margin: 0" class="text-danger">Un seul à l'arrière</p>
                        <p style="margin: 0">COVID-19 : Vous serez le seul passager à réservez ce trajet</p>
                    </div>
                </div>
                <?php
                $prefs = mysqli_query($c, "SELECT * FROM `preferences` WHERE id_user='$u[0]'");
                while ($p = mysqli_fetch_array($prefs)) {
                    if ($p[3] == 1) {
                        ?>
                        <div class="row mt-4">
                            <div class="col-1">
                                <i class="fas fa-smoking-ban fa-2x"></i>
                            </div>
                            <div class="col-11">
                                <p style="margin: 0">Pas de fumée dans la voiture </p>
                            </div>
                        </div>
                        <?php
                    }
                    if ($p[2] == 1) {
                        ?>
                        <div class="row mt-4">
                            <div class="col-1">
                                <i class="fas fa-baby fa-2x"></i>
                            </div>
                            <div class="col-11">
                                <p style="margin: 0">Pas de bébé dans la voiture </p>
                            </div>
                        </div>
                        <?php
                    }
                    if ($p[6] == 1) {
                        ?>
                        <div class="row mt-4">
                            <div class="col-1">
                                <i class="fas fa-parking fa-2x"></i>
                            </div>
                            <div class="col-11">
                                <p style="margin: 0">Pas d'arrêt sur la route </p>
                            </div>
                        </div>
                        <?php
                    }
                    if ($p[4] == 1) {
                        ?>
                        <div class="row mt-4">
                            <div class="col-1">
                                <i class="fas fa-volume-mute fa-2x"></i>
                            </div>
                            <div class="col-11">
                                <p style="margin: 0">Pas de musique </p>
                            </div>
                        </div>
                        <?php
                    }
                    if ($p[5] == 1) {
                        ?>
                        <div class="row mt-4">
                            <div class="col-1">
                                <i class="fas fa-female fa-2x"></i>
                            </div>
                            <div class="col-11">
                                <p style="margin: 0">Que des filles </p>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="row mt-4">
                    <div class="col-1">
                        <i class="fas fa-car-side mt-2 fa-2x"></i>
                    </div>
                    <div class="col-11 mt-2">
                        <p style="margin: 0"><?= $u[10] ?></p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-1">
                        <i class="fa fa-briefcase mt-2 fa-2x"></i>
                    </div>
                    <div class="col-11 mt-2">
                        <p style="margin: 0"><?= $u[9] ?></p>
                    </div>
                </div>
            </div>
            <?php
            if ($u[0] != $_SESSION['id']) {
                ?>
                <a href="envoyerMessage.php?a=<?= $u[0] ?>" class="btn btn-primary btn-lg btn-block mt-5">Envoyer un
                    message
                    a <?= $u[2] ?></a>
                <?php
                $bookmarks = mysqli_query($c, "select * from bookmark where id_user=$id_user and id_trajet=$id_trajet");
                if (mysqli_num_rows($bookmarks) == 0) {
                    echo '<a href="services/ajoutBookmark.php?trajet=' . $l[0] . '&where=showcov" class="btn btn-secondary btn-lg btn-block">Ajouter Bookmark</a>';
                } else {
                    echo '<a href="services/suppBookmark.php?trajet=' . $l[0] . '&where=showcov" class="btn btn-secondary btn-lg btn-block">Supprimer Bookmark</a>';
                }
                ?>
                <?php
            } else {
                ?>
                <a href="edit_trajet.php?trajet=<?= $l[0] ?>" class="btn btn-primary btn-lg btn-block mt-5"><i
                            class="fas fa-edit"></i> Modifier</a>
                <a href="supprimerTrajet.php?trajet=<?= $l[0] ?>" class="btn btn-danger btn-lg btn-block"><i
                            class="fas fa-trash-alt"></i> Supprimer</a>
                <?php
            }
            ?>
        </div>
        <?php
    }
}else {
    header("location:login.php");
}
include("partials/footer.php"); ?>