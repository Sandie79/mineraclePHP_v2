<?php
session_start();
include("./head.php");
include("./fonction.php");

// je récupère l'article avec toutes ses infos en fonction de l'ID (la fonction renvoie l'article qui correspond)
$article = getArticleFromId($_GET["idArticle"]); // GET renvoie l'ID de l'article

// si le panier n'existe pas, on l'initialise en tant que tableau vide. Le créer sur la page index car cette page est le point d'entée de l'utilisateur.
if (!isset($_SESSION["panier"])) { // grâce à isset on vérifie que la clé panier existe dans $_SESSION et si elle est non null
    $_SESSION["panier"] = []; // on crée la clé panier dans $_SESSION en tant que tableau vide
    // $_SESSION["panier"] = array ();
}

?>


<body>
    <?php include("./header.php") ?>

    <main>
        <!-- après je vais afficher les infos de l'article récupéré -->
        <h1>Détail produit</h1>

        <div class="container">
            <div class="row">
                <div class="card col-md-8 offset-md-2 text-center">
                    <img src="<?php echo "./images/" . $article["image"] ?>" class="card-img-top w-50 mx-auto" alt="<?php $article["nom"] ?>">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size:1.75rem; font-weight: bold"><?php echo $article["nom"] ?></h5>
                        <p class="card-text"><?php echo $article["prix"] ?> €</p>
                        <p class="card-text"><?php echo $article["description"] ?></p>
                        <p class="card-text"><?php echo $article["description_detaillee"] ?></p>

                        <div class="card-body">

                            <!-- Bouton Ajout au panier -->
                            <form action="./panier.php" method="GET">
                                <input type="hidden" name="idArticle" value="<?php echo $article["id"] ?>">
                                <input class="button button-full m-auto" id="btn_ajout" type="submit" value="Ajouter au panier">
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include("./footer.php") ?>
</body>

</html>