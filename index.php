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

// var_dump($_SESSION).

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

                // je boucle dessus pour les afficher
                foreach ($articles as $article) {

                    ?>

                    <!-- Code affiché pour chaque article : CARD Bootstrap -->
                    <div class="col-md-4 p-3">
                    <div class="card">

                        <img src="<?php echo "./images/" . $article["image"] ?>" class="card-img-top w-75 mx-auto"
                            alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-center" style="font-size:2.25rem">
                                <?php echo $article["name"] ?>
                            </h5>
                            
                            <p class="card-text text-center">
                                <?php echo $article["description"] ?>
                            </p>

                            <p class="card-text text-center">
                                <?php echo $article["price"] ?> €
                            </p>

                            <div class="card-body">

                                <!-- Bouton voir + -->
                                <form action="./produit.php" method="GET">
                                    <input type="hidden" name="idArticle" value="<?php echo $article["id"] ?>">
                                    <a href="#" class="button button-ghost" id="btn_voir" type="submit">Voir +</a>
                                </form>

                                <!-- Bouton Ajout au panier -->
                                <form action="./panier.php" method="GET">
                                    <input type="hidden" name="idArticle" value="<?php echo $article["id"] ?>">
                                    <a href="./panier.php" class="button button-full" id="btn_ajout" type="submit">Ajouter au panier</a>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin de la CARD Bootstrap -->
                <?php } ?>


            </div>
        </div>

    </main>


    <?php include("./footer.php") ?>
</body>

</html>