<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/login.css">
    <title>Login/UP Form</title>
</head>
<body>
<h2 class="text-light display-4 mt-4">Bienvenu à Co-Tunisie</h2>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="" method="POST">
            <h1>Creer un compte</h1>
            <span>Utiliser votre e-mail pour la création du compte</span>
            <input type="text" placeholder="Prènom" name="prenom"/>
            <input type="text" placeholder="Nom" name="nom"/>
            <input type="email" placeholder="Email" name="email"/>
            <input type="password" placeholder="Mot de passe" name="mdp"/>
            <input type="number" placeholder="num" name="num"/>
            <select name="ville" required>
            <?php
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            include("Server/Config.php");
            $villes=mysqli_query($c, "select * from villes");
            $v=mysqli_fetch_array($villes);
            echo "<option selected>".$v[1]."</option>";
            while($v=mysqli_fetch_array($villes)){
                echo "<option>".$v[1]."</option>";
            }
            ?>
            </select>
            <button name="up">Inscripton</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="" method="POST">
            <h3><a href="index.php"><= BACK</a></h3>
            <h1>Connexion</h1>
            <span>Utiliser votre compte pour vous connecter</span>
            <input type="email" placeholder="Email" name="email"/>
            <input type="password" placeholder="Password" name="mdp"/>
            <p>Si vous avez oublier votre mot de passe veillez contacter un administrateur</p>
            <button name="in">Connexion</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h3><a href="index.php"><= BACK</a></h3>
                <h1>Bienvenu une autre foi !</h1>
                <p>Veillez vous connecter en utilisant vos informations personnels</p>
                <button class="ghost" id="signIn">Connexion</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Bienvenu</h1>
                <p>Entrer vos informations personnels pour commancer votre journée avec nous</p>
                <button class="ghost" id="signUp">Inscription</button>
            </div>
        </div>
    </div>
</div>

<script>
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});
</script>

<?php
    if (ISSET($_POST['in'])){
        include('server/Config.php');
        $email = mysqli_real_escape_string($c, $_POST['email']);
        $mdp = mysqli_real_escape_string($c, $_POST['mdp']);

        $res = mysqli_query($c, "select * from user where email='$email' and mdp='$mdp'");
        if ($l=mysqli_fetch_array($res)){
            session_start();
            $_SESSION['id']=$l[0];
            header("location:index.php");
        }else {
            print("erreur login mdp");
        }
        mysqli_close($c);
    } elseif(ISSET($_POST['up'])){
        include('server/Config.php');
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        $num = $_POST['num'];
        $ville = $_POST['ville'];
        $test = mysqli_query($c,"SELECT * FROM `user` WHERE email='$email'");
        if (mysqli_num_rows($test) == 0){
            $req = "INSERT INTO `user`(`id_user`,`nom`, `prenom`, `email`, `mdp`, `num`, `sexe`, `ville`) VALUES 
                                                        ('','$nom','$prenom','$email','$mdp','$num','undefined','$ville')";
            if ($c->query($req) === TRUE) {
                $last_id = $c->insert_id;
                $res = mysqli_query($c, "INSERT INTO `preferences`(`id_preferences`, `id_user`, `kids`, `smoke`, `music`, `girl`, `stop`) VALUES 
                                                        ('','$last_id','0','0','0','0','0')");
            } else {
                echo "Error: " . $req . "<br>" . $c->error;
            }
            mysqli_close($c);
            header("location:login.php");
        }else {
            echo "<p class='text-white text-center'>Cet email existe déjà, Si vous avez oublier votre mot de passe veillez contacter un <br><a class='text-white' href=\"https://www.facebook.com/khairi.slama/\">administrateur</a></p>";
        }
    } 

?>