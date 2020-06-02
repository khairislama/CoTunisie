<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $user = mysqli_query($c, "select * from user where id_user = $id_user");
    $u = mysqli_fetch_array($user);
    ?>
    <div class="profile-card">
        <div class="image-container">
            <!--            <img src="assets/imgs/bg.png" style="width: 100%">-->
            <i class="fas fa-user-circle fa-10x"></i>
            <div class="title mt-3">
                <h2>Modifier votre mot de passe </h2>
            </div>
        </div>
        <div class="main-container">
            <form action="" method="POST">
                <div class="input-group mb-3">
                    <input type="password" name="amdp" placeholder="ancien mot de passe" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="nmdp1" placeholder="nouveau mot de passe" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="nmdp2" placeholder="retaper nouveau mot de passe" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <button name="submit" type="submit" class="btn btn-primary mt-3 btn-lg btn-block">Submit</button>
            </form>
        </div>
    </div>
<?php
    if (ISSET($_POST['submit'])){
        $amdp = $_POST['amdp'];
        $nmdp1 =$_POST['nmdp1'];
        $nmdp2 = $_POST['nmdp2'];
        if ($amdp == $u[4]){
            if ($nmdp1==$nmdp2){
                $req = "UPDATE user SET mdp='$nmdp1' WHERE id_user='$id_user'";
                $res = mysqli_query($c, $req);
                mysqli_close($c);
                header("location:profile.php?profile=".$id_user);
                ob_end_flush();
            }else {
                echo"veillez vérifier votre nouveau mot de passe";
            }
        }else{
            echo"mot de passe invalide";
        }
    }
}else {
header("location:login.php");
}

include("partials/footer.php"); ?>
