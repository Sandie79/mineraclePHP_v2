<?php
session_start();
include("./fonction.php"); // on inclut le fichier des fonctions pour pouvoir les appeler
include("./head.php");

// var_dump(getArticlesByGamme(1));

?>

<body>

    <?php include("./header.php") ?>

    <main>

        <div class="container-fluid">
            <div class="row">
                <div class="col" id="hero_gamme">
                    <h1 class="title_page mx-auto">Inscription</h1>
                </div>
            </div>
        </div>

        <!-- Titre du formulaire d'inscription -->
        <div class="container">
            <div class="row">
                <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded text-center my-5" style="font-size:2.5rem; font-weight:bold">Créer mon compte</div>
            </div>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="container-fluid w-50">
            <form action="./connexion.php" method="POST">

                <div class="row">
                    <!-- Prénom -->
                    <div class="col-6 mb-3">
                        <label for="firstName" class="hidden-label">Prénom</label>
                        <input type="text" name="firstName" class="form-control" id="firstName" aria-describedby="firstName">
                    </div>
                    <!-- Nom -->
                    <div class="col-6 mb-3">
                        <label for="lastName" class="hidden-label">Nom</label>
                        <input type="text" name="lastName" class="form-control" id="lastName" aria-describedby="lastName">
                    </div>
                </div>

                <div class="row">
                    <!-- Mail -->
                    <div class="col-6 mb-3">
                        <label for="email" class="hidden-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="email">
                    </div>
                    <!-- Mot de passe -->
                    <div class="col-6 mb-3">
                        <label for="password" class="hidden-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                </div>

                <!-- Adresse -->
                <div class="mb-3">
                    <label for="adresse" class="hidden-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control" id="adresse" aria-describedby="adresse">
                </div>

                <div class="row">
                    <!-- Code postal -->
                    <div class="col-6 mb-3">
                        <label for="codePostal" class="hidden-label">Code postal</label>
                        <input type="text" name="codePostal" class="form-control" id="codePostal" aria-describedby="codePostal">
                    </div>
                    <!-- Ville -->
                    <div class="col-6 mb-3">
                        <label for="ville" class="hidden-label">Ville</label>
                        <input type="text" name="ville" class="form-control" id="ville" aria-describedby="ville">
                    </div>
                </div>

                <!-- Case à cocher : "Se souvenir de moi" -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
                </div>

                <!-- Bouton "Valider" -->
                    <input class="button button-full m-auto" id="btn_ajout" type="submit" value="Valider">

            </form>
        </div>

    </main>

    <?php include("./footer.php") ?>
</body>

</html>