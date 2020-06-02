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
    if (mysqli_num_rows($trajet)== 0) {
        echo "<h1 class=\"text-center\">Il n'ya rien a afficher ici </h1>";
    }else {
        $l = mysqli_fetch_array($trajet);
        if ($id_user != $l[10]) {
            echo "Erreur! vous ne pouvez pas modifier ce trajet";
        } else {
            ?>
            <div style="width: 55%;margin: 25px auto;">
                <h2>Modifier votre trajet du <?= $l[5] ?></h2>
                <hr>
                <form action="" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="inputCity">Emplacement de départ</label>
                            <input value="<?= $l[2] ?>" type="text" class="form-control" id="inputCity" name="empDep"
                                   required>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputState">Ville</label>
                            <select id="inputState" class="form-control" name="villeDep" required>
                                <?php
                                $villes = mysqli_query($c, "select * from villes");
                                while ($v = mysqli_fetch_array($villes)) {
                                    if ($v[1] == $l[1]) {
                                        echo "<option selected>" . $v[1] . "</option>";
                                    } else {
                                        echo "<option>" . $v[1] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="inputCity">Emplacement d'arrtivé</label>
                            <input value="<?= $l[4] ?>" type="text" class="form-control" id="inputCity" name="empArr"
                                   required>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputState">Ville</label>
                            <select id="inputState" class="form-control" name="villeArr" required>
                                <?php
                                $villes = mysqli_query($c, "select * from villes");
                                while ($v = mysqli_fetch_array($villes)) {
                                    if ($v[1] == $l[3]) {
                                        echo "<option selected>" . $v[1] . "</option>";
                                    } else {
                                        echo "<option>" . $v[1] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="dateDep">Date de dépare</label>
                            <input value="<?= $l[5] ?>" type="date" name="ddp" id="dateDep" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="timeDep">Heure de dépare</label>
                            <input value="<?= $l[6] ?>" type="time" name="tdp" id="timeDep"
                                   placeholder="temps de départ"
                                   required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="numtel">Num telf</label>
                            <input value="<?= $l[7] ?>" type="number" class="form-control" id="numtel" name="num"
                                   required>
                        </div>
                        <div class="form-group col-4">
                            <label for="places">Places</label>
                            <input value="1" type="number" class="form-control" id="places" name="place"
                                   required disabled>
                        </div>
                        <div class="form-group col-4">
                            <label for="prix">Prix en dinar</label>
                            <input value="<?= $l[9] ?>" type="number" class="form-control" id="prix" name="prix"
                                   required>
                        </div>
                    </div>
                    <button name="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-edit"></i>
                        Modifier ce
                        trajet >
                    </button>
                </form>
            </div>
            <?php
        }
        if (ISSET($_POST['submit'])) {
            $empDep = $_POST['empDep'];
            $villeDep = $_POST['villeDep'];
            $empArr = $_POST['empArr'];
            $villeArr = $_POST['villeArr'];
            $ddp = $_POST['ddp'];
            $tdp = $_POST['tdp'];
            $num = $_POST['num'];
            $place = $_POST['place'];
            $prix = $_POST['prix'];
            $req = "UPDATE `trajet` SET `villeDep`='$villeDep',`empDep`='$empDep',
                        `villeArr`='$villeArr',`empArr`='$empArr',`ddp`='$ddp',
                        `tdp`='$tdp',`num`='$num',`place`='$place',
                        `prix`='$prix' WHERE id_trajet='$id_trajet'";
            $res = mysqli_query($c, $req);
            header("Location:showcov.php?trajet=$id_trajet");
            ob_end_flush();
        }
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>