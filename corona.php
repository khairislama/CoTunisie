<?php
include("partials/header.php");

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $res = mysqli_query($c, "select * from corona order by date DESC");
    ?>
    <section id="header2" class="jumbotron text-center">
        <h3 class="display-4 pt-0 text-white kiki">Nouveau 'Covid-19' forum! Dites-nous que vous penser !</h3>
        <hr class="my-3">
        <p class="lead text-white kiki"><strong>ce dont le monde a besoin maintenant, c'est la solidarité! <br>
                Avec la solidarité, nous pouvons vaincre ce virus et construire un monde meilleur</strong></p>
        <a class="btn btn-primary btn-lg" href="newCorona.php">Proposer un nouveau sujet</a>
    </section>
    <div class="article ">
        <?php
        if (mysqli_num_rows($res)== 0) {
            echo "<h1 class=\"text-center\">Il n'y a actuellement aucun sujet disponible</h1>";
        }
        while($l=mysqli_fetch_array($res)) {
            ?>
            <div class="row">
                <div class="col-9">
                    <a href="showcor.php?id=<?= $l[0] ?>"><h5>Sujet : <?= $l[2] ?> </h5></a>
                    <?php
                    $date=date_create($l[4]);
                    $user_info = mysqli_query($c, "select * from user where id_user='$l[1]'");
                    $u = mysqli_fetch_array($user_info)
                    ?>
                    <p class='text-center'><i class="float-left ml-2"><a href="profile.php?profile=<?= $u[0] ?>"><?= $u[2] ?></a> - <?= date_format($date, "D, d M") ?></i>
                <?php
                if ($u[0] == $_SESSION['id']){
                    echo" <a href=\"services/suppCorona.php?id=".$l[0]."\" class='text-danger'>supprimer</a></p></div>";
                }else {echo"</p></div>";}
                ?>
                <div class="col-1">
                    <p>likes</p>
                    <?php
                    $nb_likes=mysqli_query($c,"SELECT COUNT(*) FROM `likes` WHERE id_corona='$l[0]'");
                    $nbl=mysqli_fetch_array($nb_likes);
                    ?>
                    <i><?= $nbl[0] ?></i>
                </div>
                <div class="col-1">
                    <p>Coms</p>
                    <?php
                    $nb_coms=mysqli_query($c,"SELECT COUNT(*) FROM `comentaires` WHERE id_corona='$l[0]'");
                    $nbc=mysqli_fetch_array($nb_coms);
                    ?>
                    <i><?= $nbc[0] ?></i>
                </div>
                <div class="col-1">
                    <a href="showcor.php?id=<?= $l[0] ?>" class="btn btn-primary btn-block mt-3">voir</a>
                </div>
            </div>
            <hr>
                <?php
            }
            ?>
    </div>
<?php }else {
    header("location:login.php");
}

include("partials/footer.php");
?>
