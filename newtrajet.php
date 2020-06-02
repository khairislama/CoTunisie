<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $num_user = mysqli_query($c, "select num from user where id_user='$id_user'");
    $l=mysqli_fetch_array($num_user);
?>

    <div class="article">
        <a href="covoiturage.php">< Retour</a>
        <h2>Proposer un nouveau trajet</h2>
        <hr>
        <div class="article">
            <form action="" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-7">
                        <label for="inputCity">Emplacement de départ</label>
                        <input type="text" class="form-control" id="inputCity" name="empDep" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="inputState">Ville</label>
                        <select id="inputState" class="form-control" name="villeDep" required>
                            <?php
                            $villes=mysqli_query($c, "select * from villes");
                            $v=mysqli_fetch_array($villes);
                            echo "<option selected>".$v[1]."</option>";
                            while($v=mysqli_fetch_array($villes)){
                                echo "<option>".$v[1]."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-7">
                        <label for="inputCity">Emplacement d'arrtivé</label>
                        <input type="text" class="form-control" id="inputCity" name="empArr" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="inputState">Ville</label>
                        <select id="inputState" class="form-control" name="villeArr" required>
                            <?php
                            $villes=mysqli_query($c, "select * from villes");
                            $v=mysqli_fetch_array($villes);
                            echo "<option selected>".$v[1]."</option>";
                            while($v=mysqli_fetch_array($villes)){
                                echo "<option>".$v[1]."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="dateDep">Date de dépare</label>
                        <input type="date" name="ddp" id="dateDep" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="timeDep">Heure de dépare</label>
                        <input type="time" name="tdp" id="timeDep" placeholder="temps de départ" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="numtel">Num telf</label>
                        <input type="number" class="form-control" id="numtel" name="num" value="<?=$l[0]?>" required>
                    </div>
                    <div class="form-group col-4">
                        <label for="places">Places</label>
                        <input type="number" class="form-control" id="places" name="place" required value="1" disabled>
                    </div>
                    <div class="form-group col-4">
                        <label for="prix">Prix en dinar</label>
                        <input type="number" class="form-control" id="prix" name="prix" step=".01" required>
                    </div>
                </div>
                <button name="submit" class="btn btn-success btn-lg float-right">Proposer ce trajet ></button>
            </form>
        </div>
    </div>
    <?php
    if (ISSET($_POST['submit'])){
        $empDep = htmlspecialchars(str_replace(array("'", "\""), "", 
        htmlspecialchars($_POST['empDep'])));
        $villeDep = $_POST['villeDep'];
        $empArr = htmlspecialchars(str_replace(array("'", "\""), "", 
        htmlspecialchars($_POST['empArr'])));
        $villeArr = $_POST['villeArr'];
        $ddp = $_POST['ddp'];
        $tdp = $_POST['tdp'];
        $num = $_POST['num'];
        $prix = $_POST['prix'];
        $req= "INSERT INTO `trajet`(`id_trajet`,`villeDep`, `empDep`, `villeArr`, `empArr`, `ddp`, `tdp`, `num`, `place`, `prix`, `id_user`) VALUES 
		                        ('','$villeDep','$empDep','$villeArr','$empArr','$ddp','$tdp','$num','1','$prix','$id_user')";
        if ($c->query($req) === TRUE) {
            $last_id = $c->insert_id;
            header("Location:showcov.php?trajet=$last_id");
            ob_end_flush();
        }   else {
            echo "Error: " . $req . "<br>" . $c->error;
        }
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>