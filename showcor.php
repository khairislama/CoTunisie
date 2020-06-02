<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $id_corona = $_GET['id'];
    $corona = mysqli_query($c, "select * from corona where id_corona = $id_corona");
    if (mysqli_num_rows($corona)== 0) {
        echo "<h1 class=\"text-center\">Il n'ya rien a afficher ici </h1>";
    }else {
        $l = mysqli_fetch_array($corona);
        $user = mysqli_query($c, "select * from user where id_user = $l[1]");
        $u = mysqli_fetch_array($user);
        $date_sujet = date_create($l[4]);
        $date_user = date_create($u[8]);
        $nb_sujet = mysqli_query($c, "select count(id_corona) from corona where id_user='$u[0]'");
        $nb = mysqli_fetch_array($nb_sujet);
        ?>

        <section id="header2" class="jumbotron text-center">
            <h3 class="display-4 pt-0 text-white kiki">Nouveau 'Covid-19' forum! Dites-nous que vous penser !</h3>
            <hr class="my-3">
            <p class="lead text-white kiki"><strong>ce dont le monde a besoin maintenant, c'est la solidarité! <br>
                    Avec la solidarité, nous pouvons vaincre ce virus et construire un monde meilleur</strong></p>
            <a class="btn btn-primary btn-lg" href="newCorona.php">Proposer un nouveau sujet</a>
        </section>

        <div class="text-center my-4">
            <h1> <?= $l[2] ?> </h1>
        </div>
        <div class="article p-0">
            <div class="row">
                <div class="col-2 infoProfile ">
                    <p><i class="fas fa-user-circle fa-7x mt-3 ml-5"></i></p>
                    <p class="text-center mb-1"><strong><?= $u[2] ?> <?= $u[1] ?></strong></p>
                    <?php
                    $rating = mysqli_query($c, "select avg(note), count(note) from rating where id_a='$u[0]'");
                    $r = mysqli_fetch_array($rating);
                    echo "<p class=\"text-center\"><i class=\"far fa-star\"></i><strong> " . number_format($r[0], 1) . "/5 - " . $r[1] . " votes</strong></p>";
                    ?>
                    <p class="mt-5 mb-2"><i>depuis : <?= date_format($date_user, "D, d M") ?></i></p>
                    <p class="mb-2"><i>profession: <?= $u[9] ?></i></p>
                    <p><i>Nombre de sujets: <?= $nb[0] ?></i></p>
                </div>
                <div class="col-10">
                    <p><i><?= date_format($date_sujet, "D, d M") ?></i><span
                                class="float-right mr-4 "> #<?= $l[0] ?></span> <span
                                class="badge badge-danger float-right mr-5 mt-2">New</span></p>
                    <hr>
                    <p class="m-4"><span class="container"><?= $l[3] ?></span></p>
                    <p class="float-right bottom"><span><a href="#commentCreate"><i class="far fa-comment"></i> Commenter</a></span>
                        .
                        <span>
                        <?php
                        $likes = mysqli_query($c, "SELECT * FROM `likes` WHERE id_user='$id_user' and id_corona='$id_corona'");
                        $nb_likes = mysqli_query($c, "SELECT COUNT(*) FROM `likes` where id_corona='$id_corona'");
                        $nb = mysqli_fetch_array($nb_likes);
                        if (mysqli_num_rows($likes) != 0) {
                            echo '<a href="services/suppLike.php?id=' . $id_corona . '"><i class="fas fa-thumbs-up"></i> j\'aime (' . $nb[0] . ')</a>';
                        } else {
                            echo '<a href="services/ajoutLike.php?id=' . $id_corona . '"><i class="far fa-thumbs-up"></i> j\'aime (' . $nb[0] . ')</a>';
                        }
                        ?>
                    </span>
                    </p>
                </div>
            </div>
        </div>

        <!--    PARTIE COMMENTAIRES -->
        <?php
        $lescoms = mysqli_query($c, "SELECT * FROM `comentaires` WHERE id_corona='$id_corona'");
        if (mysqli_num_rows($lescoms) != 0) {
            echo '<section class="article" id="commentShow">';
            while ($com = mysqli_fetch_array($lescoms)) {
                $user_info = mysqli_query($c, "SELECT * FROM `user` WHERE id_user='$com[2]'");
                $u_com = mysqli_fetch_array($user_info);
                $date_com = date_create($com[4]);
                ?>
                <div class="row">
                    <div class="col-2">
                        <h6><?= $u_com[2] ?> <?= $u_com[1] ?></h6>
                        <p><i><?= date_format($date_com, "d M, H:i") ?></i></p>
                    </div>
                    <div class="col-9">
                        <p class="text-center"><?= $com[3] ?></p>
                    </div>
                    <?php
                    if ($com[2] == $id_user || $id_user == $u[0]) {
                        echo '<div class="col-1"><a href="services/supprimerCommentaire.php?id=' . $com[0] . '&corona=' . $id_corona . '" class="text-danger">Supprimer</a></div>';
                    }
                    ?>
                </div>
                <hr>
                <?php
            }
            echo "</section>";
        }
        ?>

        <!--    PARTIE CREER COMMENTAIRES   -->
        <section class="article p-0" id="commentCreate">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-1">
                        <i class="fas fa-user-circle fa-2x mt-4 ml-3"></i>
                    </div>
                    <div class="col-11">
                        <div class="article mx-0 mt-2 mb-0 p-0">
                            <div class="input-group">
                                <textarea name="com" class="form-control" placeholder="Ecrivez votre commentaire ... "
                                          rows="2"></textarea>
                                <div class="input-group-append">
                                    <button name="submit" class="btn btn-outline-secondary">Envoyer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <?php
        $comment = "";
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $comment = test_input(htmlspecialchars(str_replace(array("'", "\""), "", 
            htmlspecialchars($_POST['com']))));
            $res = mysqli_query($c, "INSERT INTO `comentaires`(`id_corona`, `id_user`, `com`) VALUES ('$id_corona','$id_user','$comment')");
            mysqli_close($c);
            header("location:showcor.php?id=" . $id_corona);
            ob_end_flush();
        }
    }
}else {
    header("location:login.php");
}
include("partials/footer.php"); ?>