<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (ISSET($_SESSION['id'])) {
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $user = mysqli_query($c, "select * from user where id_user = $id_user");
    $u = mysqli_fetch_array($user);?>
    <div class="profile-card">
        <div class="image-container">
            <!--            <img src="assets/imgs/bg.png" style="width: 100%">-->
            <i class="fas fa-user-circle fa-10x"></i>
            <div class="title mt-3">
                <h2>Modifier profile</h2>
            </div>
        </div>
        <div class="main-container">
            <form action="" method="POST">
                <div class="form-row mb-3">
                    <div class="col">
                        <input type="text" class="form-control" value="<?=$u[2]?>" name="prenom" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" value="<?=$u[1]?>" name="nom" required>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa fa-briefcase"></i></span>
                    </div>
                    <input type="text" name="job" value="<?= $u[9] ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <div class="input-group mb-3">
<!--                    <div class="input-group-prepend">-->
<!--                        <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa fa-home"></i></span>-->
<!--                    </div>-->
<!--                    <input type="text" name="ville" value="--><?//= $u[7] ?><!--" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>-->
                    <select name="ville" id="inputState" class="form-control" >
                        <?php
                        $villes=mysqli_query($c, "select * from villes");
                        while($v=mysqli_fetch_array($villes)){
                            if ($v[1] == $u[7]){
                                echo "<option selected>".$v[1]."</option>";
                            }else {
                                echo "<option>".$v[1]."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" value="<?= $u[3] ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa fa-phone"></i></span>
                    </div>
                    <input type="number" name="num" value="<?= $u[5] ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default"><i class="fas fa-car-side"></i></span>
                    </div>
                    <input type="text" name="car" value="<?= $u[10] ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <hr>
                <p><b><i class="fa fa-asterisk info"></i>Preferences</b></p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" aria-label="Checkbox for following text input" name="smoke" value="1">
                        </div>
                    </div>
                    <p class="form-control" aria-label="Text with checkbox">Pas de fumée dans la voiture</p>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" aria-label="Checkbox for following text input" name="kids" value="1">
                        </div>
                    </div>
                    <p class="form-control" aria-label="Text with checkbox">Pas de bébé</p>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" aria-label="Checkbox for following text input" name="stop" value="1">
                        </div>
                    </div>
                    <p class="form-control" aria-label="Text with checkbox">Pas d'arrêt sur la route</p>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" aria-label="Checkbox for following text input" name="music" value="1">
                        </div>
                    </div>
                    <p class="form-control" aria-label="Text with checkbox">Pas de musique</p>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" aria-label="Checkbox for following text input" name="girl" value="1">
                        </div>
                    </div>
                    <p class="form-control" aria-label="Text with checkbox">Que des filles</p>
                </div>
                <button name="submit" type="submit" class="btn btn-primary mt-3 btn-lg btn-block">Submit</button>
            </form>
            <a href="modifiermdp.php" class="btn btn-primary btn-block">modifier mot de passe</a>
            <a href="supprimerProfile.php" class="btn btn-danger btn-block">supprimer compte</a>
        </div>
    </div>

    <?php
    if (ISSET($_POST['submit'])){
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $job = $_POST['job'];
        $ville = $_POST['ville'];
        $email = $_POST['email'];
        $num = $_POST['num'];
        $car = $_POST['car'];
        $_POST['smoke'] == '1'?$smoke=1:$smoke=0;
        $_POST['kids'] == '1'?$kids=1:$kids=0;
        $_POST['music'] == '1'?$music=1:$music=0;
        $_POST['girl'] == '1'?$girl=1:$girl=0;
        $_POST['stop'] == '1'?$stop=1:$stop=0;
        $req = "UPDATE user SET nom='$nom',
                prenom='$prenom',email='$email',
                num='$num',ville='$ville', job='$job', voiture='$car' WHERE id_user='$id_user'";
        $req2 = "UPDATE `preferences` SET `kids`='$kids',`smoke`='$smoke',`music`='$music',`girl`='$girl',`stop`='$stop' WHERE id_user='$id_user'";
        $res = mysqli_query($c, $req);
        $res2 = mysqli_query($c, $req2);
        mysqli_close($c);
        header("location:profile.php?profile=".$id_user);
        ob_end_flush();
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>
