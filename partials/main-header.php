<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="https://kit.fontawesome.com/feeac1c106.js" crossorigin="anonymous"></script>
    <title>Co-tunisie | Bienvenue dans le premier site covoiturage en tunisie</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand mr-5" href="index.php">Co-Tunisie</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" id="navheader">
                <li class="nav-item mr-4">
                    <a class="nav-link" href="covoiturage.php">Covoiturage</a>
                </li>
                <li class="nav-item mr-4">
                    <a class="nav-link" href="corona.php">Corona <span class="badge badge-secondary">New</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ">
                <?php
                session_start();
                if (ISSET($_SESSION['id'])){
                    include("Server/Config.php");
                    $id_user = $_SESSION['id'];
                    echo'<li><div class="dropdown"><button class="dropbtn" style="padding: 8px"><i class="fas fa-user-circle"></i> Mon compte</button>';
                    echo'<div class="dropdown-content"><a href="profile.php?profile='.$id_user.'">mon profile</a><a href="boitemessages.php">Messages</a>';
                    echo'<a href="trajets.php?id_user='.$id_user.'">mes trajets</a><a href="bookmark.php">enregistré</a><a href="services/logout.php">deconnexion</a></div></div></li>';
                } else {
                    echo'<li class="nav-item "><a class="nav-link" href="login.php">Connexion</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>


