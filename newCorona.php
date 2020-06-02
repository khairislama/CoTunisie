<?php include("partials/header.php");
ob_start();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (ISSET($_SESSION['id'])){
    include("Server/Config.php");
    $id_user = $_SESSION['id'];
    ?>
    <div class="article">
        <a href="corona.php">< Retour</a>
        <h2>Proster un nouveau Sujet</h2>
        <hr>
        <div class="article">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Sujet: </span>
                    </div>
                    <input type="text" name="sujet" class="form-control" aria-describedby="basic-addon1" pattern=".{10,80}" title="entre 10 et 80 lettre">
                </div>
                <div class="row">
                    <div class="col align-self-center">
                        <div class="input-group">
                            <textarea name="com" class="form-control editor" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <button name="submit" class="btn btn-success btn-lg float-right">Poster ce sujet ></button>
            </form>
        </div>
    </div>
    <script>
        CKEDITOR.replace( 'com' );
    </script>
    <?php
    if (ISSET($_POST['submit'])){
        $sujet = $_POST['sujet'];
        $com = $_POST['com'];
        $req= "INSERT INTO `corona`(`id_corona`, `id_user`, `objet`, `text`) VALUES
                                    ('','$id_user','$sujet','<div class=\'text-center\'>$com</div>')";
        if ($c->query($req) === TRUE) {
            $last_id = $c->insert_id;
            header("Location:showcor.php?id=$last_id");
            ob_end_flush();
        }   else {
            echo "Error: " . $req . "<br>" . $c->error;
        }
    }
}else {
    header("location:login.php");
}

include("partials/footer.php"); ?>