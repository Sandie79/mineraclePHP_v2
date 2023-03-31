<?php
session_start();
include("./fonction.php"); // on inclut le fichier des fonctions pour pouvoir les appeler
include("./head.php");

// si le panier n'existe pas, on l'initialise en tant que tableau vide. Le créer sur la page index car cette page est le point d'entée de l'utilisateur.
if (!isset($_SESSION["panier"])) { // grâce à isset on vérifie que la clé panier existe dans $_SESSION et si elle est non null
    $_SESSION["panier"] = []; // on crée la clé panier dans $_SESSION en tant que tableau vide
    // $_SESSION["panier"] = array ();
}

// pour déclencher le vidage
if (isset($_POST["videPanier"])) {
    deleteToCart();
}

// var_dump(getArticles());

?>


<body>
    <?php include("./header.php") ?>

    <main>



        <div class="container-fluid">
            <div class="row">
                <div class="col" id="hero_accueil">
                    <h1 class="mx-auto">Bienvenue sur votre boutique bien-être</h1>
                    <a href="#" class="button button-full">Catalogue</a>
                    <a href="#" class="button button-ghost">Contactez-nous</a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row m-5">

                <?php

                // je récupère la liste des articles que je stocke dans une variable
                $articles = getArticles();

                showArticles($articles);
                ?>


            </div>
        </div>

    </main>


    <?php include("./footer.php") ?>
</body>
