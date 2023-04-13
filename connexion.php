<?php
session_start();
include("./fonction.php"); // on inclut le fichier des fonctions pour pouvoir les appeler
include("./head.php");

if (isset($_POST["firstName"])) {
    createUser();
}

//var_dump(($_POST["email"]));

?>

<body>

    <?php include("./header.php") ?>

    <main>

        <div class="container-fluid">
            <div class="row">
                <div class="col" id="hero_gamme">
                    <h1 class="title_page mx-auto">Connexion</h1>
                </div>
            </div>
        </div>

        <!-- Titre du formulaire d'inscription -->
        <div class="container">
            <div class="row">
                <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded text-center my-5" style="font-size:2.5rem; font-weight:bold">Créer mon compte</div>
            </div>
        </div>

        <!-- Formulaire de connexion -->
        <div class="container-fluid w-50">
            <form action="./index.php" method="POST">

                <!-- Mail -->
                <div class="row">
                    <label for="email" class="hidden-label">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="email">
                    <div id="email" class="form-text">Nous ne partagerons jamais votre email avec des tiers</div>
                </div>

                <!-- Mot de passe -->
                <div class="row">
                    <label for="password" class="hidden-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>

                <!-- Bouton "Valider" -->
                <input class="button button-full m-auto" id="btn_ajout" type="submit" value="Valider">

            </form>

            <!-- Bouton "Créer son compte" -->
            <div class="container w-50 p-3">
                <h3 class="mb-3 text-center">Pas encore inscrit ?</h3>
                <div class="row justify-content-center">
                    <a href="./inscription.php"><button class="button button-full m-auto">Je crée mon compte</button></a>
                </div>
            </div>
        </div>

    </main>

    <?php include("./footer.php") ?>
</body>

</html>