<?php

// Connexion à la base de données

function getConnection()
{

    // try : je tente une connexion
    try {
        $db = new PDO( // PDO est une extension native de php pour se connecter à une base de données, c'est une class (fichier qui permet de représenter un élément du monde réel trop complexe pour être représenté en code avec une simple chaînde de caractère. La classe se compose d'attributs (caractéristiques) et de méthodes (fonction)) / info : sgbd, nom base, adresse (host) + encodage
            "mysql:host=localhost;dbname=mineraclephp_v2;charset=utf8",
            "root", // pseudo utilisateur (root en local)
            "", // mot de passe (aucun en local)
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC) // 
        ); // options PDO : 1)ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION = permet d'afficher les erreurs 2) DO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC = récupération des données simplifiées

        // si ça ne marche pas : je mets fin au code php en affichant l'erreur
    } catch (Exception $erreur) { // je récupère l'erreur en paramètre
        die("Erreur : " . $erreur->getMessage()); // die permet d'arrêter tout le code, je l'affiche et je mets fin au script
    }

    // je retourne la connexion stockée dans une variable
    return $db;
}


// Renvoie la liste des articles

function getArticles()
{
    // je me connecte à la base de données
    $db = getConnection(); // je stocke la connexion dans la variable $db qui est une instance de la class PDO

    // je prépare une requête qui va récupérer tous les articles
    $results = $db->query("SELECT * FROM articles"); // -> permet d'accéder à la fonction query de la class PDO et $db est une instance de la class PDO

    // j'exécute ma requête et je récupère les données et je renvoie les résultats
    return $results->fetchAll(); // quand on fait un SELECT il faut aller chercher les résultats. Le fetchAll permet de récupérer les résultats
}

// Récupérer tous les articles par gammes

function getGammes()
{
    // je me connecte à la base de données
    $db = getConnection();

    // je prépare une requête qui va récupérer toutes les gammes
    $results = $db->query("SELECT * FROM gammes");

    // j'exécute ma requête et je récupère les données et je renvoie les résultats
    return $results->fetchAll();
}

// Récupérer les articles correspondant à la gamme et les renvoyer

function getArticlesByGamme($id_gamme) {
    $db = getConnection();

    // je prépare une requête qui va récupérer tous les articles
    $query = $db->prepare("SELECT * FROM articles WHERE id_gamme = :id_gamme"); // ne jamais mettre de variable php dans une requête SQL brute pour plus de sécurité
    
    // je lance ma requête en indiquant à quoi correspond ma variable SQL
    $query->execute(array(
        "id_gamme" => $id_gamme ));

    // j'exécute ma requête et je récupère les données et je renvoie les résultats
    return $query->fetchAll();
}

// récupérer l'article avec toutes ses infos en fonction de l'ID

function getArticleFromId($id)
{
$db = getConnection();
$query = $db->prepare("SELECT * FROM articles WHERE id = ?"); // ne jamais mettre de variable php dans une requête SQL brute pour plus de sécurité
$query->execute([$id]);
return $query->fetch(); // un seul résultat donc pas fecthAll
}

// je boucle dessus pour les afficher
function showArticles($articles)
{

    foreach ($articles as $article) {

?>

        <!-- Code affiché pour chaque article : CARD Bootstrap -->
        <div class="col-md-4 p-3">
            <div class="card">

                <img src="<?php echo "./images/" . $article["image"] ?>" class="card-img-top w-75 mx-auto" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center" style="font-size:2.25rem; font-weight: bold">
                        <?php echo $article["nom"] ?>
                    </h5>

                    <p class="card-text text-center">
                        <?php echo $article["description"] ?>
                    </p>

                    <p class="card-text text-center">
                        <?php echo $article["prix"] ?> €
                    </p>

                    <div class="card-body">

                        <!-- Bouton voir + -->
                        <form action="./produit.php" method="GET">
                            <input type="hidden" name="idArticle" value="<?php echo $article["id"] ?>">
                            <input class="button button-ghost" id="btn_voir" type="submit" value="Voir +">
                        </form>

                        <!-- Bouton Ajout au panier -->
                        <form action="./panier.php" method="GET">
                            <input type="hidden" name="idArticle" value="<?php echo $article["id"] ?>">
                            <input class="button button-full" id="btn_ajout" type="submit" value="Ajouter au panier">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin de la CARD Bootstrap -->

    <?php
    }
}


// On crée une fonction qui nous permet d'ajouter un produit au panier

function addToCart($articleToAdd)
{
    // on va vérifier que l'article n'est pas déjà présent dans le panier

    // pour cela, on parcourt le panier pour examiner chaque article
    // 1 er élément : index de la boucle = $i
    // 2ème élément : condition de maintien
    // 3ème élément : évolution de $i à la fin de chaque boucle

    for ($i = 0; $i < count($_SESSION["panier"]); $i++) {

        // on vérifie que l'id de l'article du panier correspond à l'id de l'article qu'on veut ajouter
        if ($_SESSION["panier"][$i]["id"] == $articleToAdd["id"]) {

            // si c'est le cas, quantité +1, puis on sort de la fonction avec message
            $_SESSION["panier"][$i]["quantite"] += 1;
            echo "<script> alert(\"Article ajouté au panier !\");</script>";
            return; // le return ici permet de sortir de la fonction entièrement
        }
    }

    // si pas présent, on l'ajoute
    $articleToAdd["quantite"] = 1;
    array_push($_SESSION["panier"], $articleToAdd); // on ajoute l'article dans le panier
    echo "<script> alert(\"Article ajouté au panier !\");</script>";
}

// fonction pour afficher les articles dans la page panier
function showArticlesInCard()
{

    foreach ($_SESSION["panier"] as $article) {
    ?>

        <tr>
            <td><img src="<?php echo "./images/" . $article["image"] ?>" class="img-fluid rounded-start produit" alt="...">
            </td>
            <td>
                <h5 class="card-title">
                    <?php echo $article["nom"] ?>
                </h5>
                <p class="card-text">
                    <?php echo $article["description"] ?>
                </p>
            </td>
            <td>
                <p class="card-text">
                    <?php echo $article["prix"] ?> €
                </p>
            </td>
            <td>
                <!-- <form method="post" action="">
                <button type="button" class="btn" value=""><i class="fa-solid fa-minus"></i></button>
                <input class="quantite"  value="<?php  //echo $article["quantite"] 
                                                ?>" readonly >
                <button type="button" class="btn" value=""><i class="fa-solid fa-plus"></i></button>
                </form> -->

                <!-- Modifier la quantité d'articles dans le panier avec un bouton "modifier" -->
                <form method="POST" action="./panier.php">
                    <input type="number" name="quantite" value="<?php echo $article["quantite"] ?>" min="1" max="15">
                    <input type="hidden" name="idArticleModifie" value="<?php echo $article["id"] ?>">
                    <button type="submit" class="btn btn_modif"><i class="modif fa-solid fa-check"></i></button>
                </form>

                <!-- Supprimer la quantité d'articles dans le panier avec un bouton "Supprimer" -->
                <form method="POST" action="./panier.php">
                    <input type="hidden" name="idArticleSupprime" value="<?php echo $article["id"] ?>">
                    <button type="submit" class="btn btn_modif"><i class="modif fa-solid fa-trash"></i></button>
                </form>
            </td>
            <td>
                <?php
                echo $article["quantite"] * $article["prix"]
                ?> €
            </td>
        </tr>

<?php }
}

// Créer une fonction changeQuantity. Elle prend en paramètre l'id de l'article à modifier et la nouvelle quantité. Elle boucle sur le panier. dès qu'elle trouve l'article qui correspond à l'id en paramètre, elle change sa quantité en la remplaçant par la nouvelle.
function changeQuantity($id, $newQuantity)
{
    for ($i = 0; $i < count($_SESSION["panier"]); $i++) {

        if ($_SESSION["panier"][$i]["id"] == $id) {
            $_SESSION["panier"][$i]["quantite"] = $newQuantity;
            echo "<script> alert(\"Quantité modifiée !\");</script>";
            return;
        }
    }
}

// Créer une fonction removeToCart. Elle prend en paramètre l'id de l'article à supprimer. Elle boucle sur le panier. Dès qu'elle trouve l'article qui correspond à l'id en paramètre, elle le retire du panier avec la fonction array_splice (voir doc php).
function removeToCart($id)
{
    for ($i = 0; $i < count($_SESSION["panier"]); $i++) {

        if ($_SESSION["panier"][$i]["id"] == $id) {
            array_splice($_SESSION["panier"], $i, 1) == $_POST["idArticleSupprime"];
            echo "<script> alert(\"Article supprimé !\");</script>";
            return;
        }
    }
}

// Créer une fonction pour afficher le montant total des articles
function totalPriceArticle()
{
    $total = 0;
    foreach ($_SESSION["panier"] as $article) {
        $total += $article["quantite"] * $article["prix"];
    }
    return $total;
}

// fonction pour vider le panier
function deleteToCart()
{
    $_SESSION["panier"] = [];
    echo "<script> alert(\"Votre panier est vide !\");</script>";
}
