<?php
session_start();
include("./fonction.php"); // on inclut le fichier des fonctions pour pouvoir les appeler
include("./head.php");

// si le panier n'existe pas, on l'initialise en tant que tableau vide. Le créer sur la page index car cette page est le point d'entée de l'utilisateur.
if (!isset($_SESSION["panier"])) { // grâce à isset on vérifie que la clé panier existe dans $_SESSION et si elle est non null
    $_SESSION["panier"] = []; // on crée la clé panier dans $_SESSION en tant que tableau vide
    // $_SESSION["panier"] = array ();
}

?>


<body>
    <?php include("./header.php") ?>

    <main>



        <div class="container-fluid">
            <div class="row">
                <div class="col" id="hero">
                    <h1 class="mx-auto">Bienvenue</h1>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">

                <?php

                // je récupère la liste des articles que je stocke dans une variable
                $articles = getArticles();

                // je boucle dessus pour les afficher
                foreach ($articles as $article) {

                    ?>

                    <!-- Code affiché pour chaque article : CARD Bootstrap -->
                    <div class="card col-md-4">
                        <img src="<?php echo "./images/" . $article["image"] ?>" class="card-img-top w-75 mx-auto"
                            alt="...">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $article["name"] ?>
                            </h5>
                            <p class="card-text">
                                <?php echo $article["price"] ?> €
                            </p>
                            <p class="card-text">
                                <?php echo $article["description"] ?>
                            </p>

                            <div class="card-body">

                                <!-- Bouton voir + -->
                                <form action="./produit.php" method="GET">
                                    <input type="hidden" name="idArticle" value="<?php echo $article["id"] ?>">
                                    <button class="btn btn-outline-secondary mb-2" id="btn_voir" type="submit">Voir
                                        +</button>
                                </form>

                                <!-- Bouton Ajout au panier -->
                                <form action="./panier.php" method="GET">
                                    <input type="hidden" name="idArticle" value="<?php echo $article["id"] ?>">
                                    <button class="btn btn_ajout" type="submit">Ajouter au panier</button>
                                </form>

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