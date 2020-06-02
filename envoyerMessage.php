<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    $id_a = $_GET['a'];
    $a_info=mysqli_query($c, "select * from user where id_user='$id_a'");
    if (mysqli_num_rows($a_info)== 0) {
        echo "<h1 class=\"text-center\">Il n'ya rien a afficher ici </h1>";
    }else {
        $a = mysqli_fetch_array($a_info);
        ?>
        <div style="width: 55%;margin: 25px auto;">
            <h2>Envoyee un message a <?= $a[2] ?></h2>
            <hr>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="objet">Objet</label>
                    <input name="objet" type="text" class="form-control" id="objet"
                           placeholder="(Covoiturage, corona, demande...)">
                </div>
                <div class="form-group">
                    <label for="message">Votre message </label>
                    <textarea name="message" class="form-control" id="message" rows="5"></textarea>
                </div>
                <button name="submit" class="btn btn-success btn-lg"><i class="fas fa-share-square"></i> Envoyer
                </button>
            </form>
        </div>
        <?php
        if (ISSET($_POST['submit'])) {
            $objet = htmlspecialchars(str_replace(array("'", "\""), "", 
            htmlspecialchars($_POST['objet'])));
            $message = htmlspecialchars(str_replace(array("'", "\""), "", 
            htmlspecialchars($_POST['message'])));
            $req = "INSERT INTO `message`(`objet`, `message`, `id_envoye`, `id_recep`) 
                VALUES ('$objet','$message','$id_user','$id_a')";
            $res = mysqli_query($c, $req);
            header("Location:boitemessages.php");
        }
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>