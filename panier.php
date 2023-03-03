<?php 
session_start();
include("./head.php");
include("./fonction.php");

// si le panier n'existe pas, on l'initialise en tant que tableau vide. Le créer sur la page index car cette page est le point d'entée de l'utilisateur.
if(!isset($_SESSION["panier"])) { // grâce à isset on vérifie que la clé panier existe dans $_SESSION et si elle est non null
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

// var_dump($_SESSION["panier"]);

 ?>


<body>
    <?php include("./header.php") ?>

<main>
    <h1>Panier</h1>
</main>

    <?php include("./footer.php") ?>
</body>
</html>