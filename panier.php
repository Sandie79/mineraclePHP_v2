<?php
session_start();
include("./head.php");
include("./fonction.php");

// si le panier n'existe pas, on l'initialise en tant que tableau vide. Le créer sur la page index car cette page est le point d'entée de l'utilisateur.
if (!isset($_SESSION["panier"])) { // grâce à isset on vérifie que la clé panier existe dans $_SESSION et si elle est non null
    $_SESSION["panier"] = []; // on crée la clé panier dans $_SESSION en tant que tableau vide
    // $_SESSION["panier"] = array ();
}

// si je viens du bouton ajouter au panier 
if (isset($_GET["idArticle"])) {

    // on récupère l'article dans le panier avec toutes ses infos en fonction de l'id
    $article = getArticleFromId($_GET["idArticle"]);

    // on l'ajoute au panier avec la fonction addToCart
    addToCart($article);
}

// mettre en place une structure en if isset pour vérifier l'existence d'un des deux inputs créés à l'étape précédente (en clair, on vérifie si on a transmis ce formulaire de modif quantité).
if (isset($_POST["idArticleModifie"])) {
    changeQuantity($_POST["idArticleModifie"], $_POST["quantite"]);
}

// mettre en place une structure en if isset pour vérifier l'existence de cet input (on vérifie si on a transmis ce formulaire de suppression).
if (isset($_POST["idArticleSupprime"])) {
    removeToCart($_POST["idArticleSupprime"]);
}

// pour vérifier que le panier est bien vidé
if (isset($_POST["videPanier"])) {
    deleteToCart();
}


?>


<body>
    <?php include("./header.php") ?>

    <main>

        <div class="container-fluid">
            <div class="row">
                <div class="col" id="hero_panier">
                    <h1 class="mx-auto">Votre panier</h1>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="col-md-12 mt-5">
                <table class="table text-center">
                    <tr>
                        <th>Produit</th>
                        <th>Description</th>
                        <th>Prix unitaire HT</th>
                        <th>Quantité</th>
                        <th>Sous-total HT</th>
                    </tr>
                    <?php showArticlesInCard(); ?>
                </table>

                <table class="table text-center">
                    <th>Total</th>
                    <th><?php echo totalPriceArticle(); ?> €</th>
                </table>
            </div>

        </div>



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Félicitations !</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Montant total HT : <?php echo totalPriceArticle(); ?> € <br />
                        Montant total TTC : <?php echo number_format(totalPriceArticle() * 1.2, 2, ",") ?> € <br />
                        Frais de port : 5,00 € <br />
                        Montant total : <?php echo number_format(5 + (totalPriceArticle() * 1.2), 2, ","); ?> €
                    </div>
                    <div class="modal-footer">

                        <!-- Supprimer tout le contenu du panier avec le bouton "retour à l'accueil" -->
                        <form method="POST" action="./index.php">
                            <input type="hidden" name="videPanier" value="true">
                            <button type="submit" class="btn btn_modif">Retour à l'accueil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Button trigger modal -->
            <div class="col-md-6 text-center">
                <button type="button" class="button button-full" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn_valider">Valider ma commande</button>
            </div>
            <!-- Supprimer tout le contenu du panier avec un bouton "Vider le panier" -->
            <div class="col-md-6 text-center">
                <form method="POST" action="./panier.php">
                    <input type="hidden" name="videPanier" value="true">
                    <button type="submit" class="button button-ghost" id="btn_vider">Vider le panier</button>
                </form>
            </div>
        </div>
    </main>

    <?php include("./footer.php") ?>
</body>

</html>