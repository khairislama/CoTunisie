<?php include("partials/main-header.php");
include("Server/Config.php");
?>
<section id="header-main" class="jumbotron text-center">
    <h3 class="display-2 pt-0 text-white">Bienvenue A CO-TUNISIE</h3>
    <h3 class="display-4 pt-0 text-white">Le premier site pour la covoiturage tunisienne</h3>
    <h3 class="pt-0 text-white">Nouveau 'Covid-19' forum! Dites-nous que vous penser !</h3>
    <hr class="my-3">
    <form action="search.php" method="GET">
        <div class="kiki-special">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputState"></label>
                    <select id="inputState" class="form-control" name="villeDep" required>
                        <?php
                        $villes=mysqli_query($c, "select * from villes");
                        echo "<option selected>choisir lieu départ...</option>";
                        while($v=mysqli_fetch_array($villes)){
                            echo "<option>".$v[1]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState"></label>
                    <select id="inputState" class="form-control" name="villeArr" required>
                        <?php
                        $villes=mysqli_query($c, "select * from villes");
                        echo "<option selected>choisir lieu Arriver...</option>";
                        while($v=mysqli_fetch_array($villes)){
                            echo "<option>".$v[1]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="dateDep"></label>
                    <input class="form-control" type="date" name="ddp" id="dateDep" required>
                </div>
                <div class="form-group col-md-2">
                    <button name="recherche" class="btn btn-primary ml-5 mt-2 rounded-pill" id="btn-round">Recherche</button>
                </div>
            </div>
        </div>
    </form>
</section>
<br><br><br>
<section id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="about-img">
                    <img class="shape" src="assets/imgs/about_tringle.png" alt="">

                    <img class="man" src="assets/imgs/about_man.png" alt="">
                </div>
            </div>
            <br>
            <div class="col-md-7 about-right">

                <h2 class="color-3"><b>About Me</b>
                </h2>

                <p class="p-first text-white">
                    Dans le cadre de la matière "développement WEB", ont a été invité à réaliser un mini-projet de développement d'un site web dynamique
                    avec BOOTSTRAP et PHP dans le cadre d'un blog de covoiturage et d'un blog corona ou les membres de notre site
                    peuvent partager des informations et débattre sur ce sujet.
                </p>
                <p class="text-white">
                    Je suis SLAMA Khairi, une élève ingénieur à l'université de Polytechnique de Sousse. <br>
                    Vous êtes inviter a me contacter en cas de problem par l'un des moyens socials en dessous. C'est mon
                    premier projet web et je serai en attente de votre Feedback.
                </p>
                <h6 class="text-uppercase mb-4 font-weight-bold mt-5 text-white">Contact</h6>
                <p><i class="fas fa-home mr-3"></i> Sousse, TN</p>
                <p><i class="fas fa-envelope mr-3"></i> khairi.slama@polytechnicien.tn</p>
                <p><i class="fas fa-phone mr-3"></i> + 216 54 007 387</p>
                <p><i class="fas fa-university mr-3"></i><a href="https://polytecsousse.tn/"> Polytechnique de Sousse</a></p>

                <ul class="about-link mt-5">

                    <li><a class="btn btn-dark btn-social mx-2" href="https://twitter.com/khairislama"><i class="fab fa-twitter"></i></a></li>

                    <li><a class="btn btn-dark btn-social mx-2" href="https://www.facebook.com/khairi.slama/"><i class="fab fa-facebook-f"></i></a></li>

                    <li><a class="btn btn-dark btn-social mx-2" href="https://www.linkedin.com/in/khairi-slama-808514187/"><i class="fab fa-linkedin-in"></i></a></li>

                </ul>
            </div>
        </div>
    </div>
</section>
<?php
if (ISSET($_GET['recherche'])){
    $villeDep = $_GET['villeDep'];
    $villeArr = $_GET['villeArr'];
    $dateDep = $_GET['ddp'];
    header("location:search.php?villeDep=".$villeDep."&villeArr=".$villeArr."&ddp=".$dateDep);
}?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
