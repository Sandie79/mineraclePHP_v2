<?php

// Renvoie la liste des articles

function getArticles() {
    return [
        [
            "id" => 1,
            "name" => "Améthyste",
            "price" => 7.99,
            "description" => "Pierre naturelle pour le calme",
            "detailed_description" => "De nos jours, quand on porte cette pierre sur soi, elle aide à combattre les émotions négatives telle que la colère, la rancœur, le ressentiment, et les addictions comme le tabagisme et l'alcoolisme. Elle calme les personnes colérique ou impulsif. L'améthyste est très utiliser pas les personnes désireuse de développer leurs capacités extrasensorielles. Elle aide essentiellement à trouver le calme, la paix et la sérénité ainsi qu\'a se recentrer. Selon la taille et le volume, optez pour la fleur de vie ou le nettoyage à la mains.",
            "image" => "amethyste.jpg"
        ],

        [
            "id" => 2,
            "name" => "Quartz Rose",
            "price" => 7.99,
            "description" => "Pierre naturelle apaisante",
            "detailed_description" => "Cette pierre contribue à l\'amour de soi. Il permet à celui qui le porte de se retrouver, d\'apprendre à aimer profondément  ses qualités et ses imperfections, d\'être patient, doux et attentif avec lui-même. Le Quartz Rose est aussi une très bonne pierre pour les nouveau-nés. Les enfants de tous âges l\'apprécient beaucoup car il a un effet très calmant et est également apaisant. Elle s\'adapte au champ énergétique du porteur. La pierre vous aideras à prendre soin de vous et à vous connecteras avec votre côté féminin.",
            "image" => "quartz.jpg"
        ],

        [
            "id" => 3,
            "name" => "Aventurine",
            "price" => 6.99,
            "description" => "Pierre naturelle contre le stress",
            "detailed_description" => "L\'aventurine est une pierre qui soulage tout stress et toute anxiété face à l\'avenir. Il sera un allié de poids pendant la période des examens. Ce minéral est idéal pour les enfants et les adolescents car il contribue à la croissance physique et au développement intellectuel. Cette pierre permet d\'augmenter la patience avec soi-même, les autres, les choses et le temps. Si vous avez un tempérament nerveux ou des approches brusques, l\'aventurine affaiblit votre nature, elle vous est donc très utile.",
            "image" => "aventurine.jpg"
        ],
    ];
}

// récupérer l'article avec toutes ses infos en fonction de l'ID

function getArticleFromId($id) {
    // on récupère la liste des articles via getArticles et on la stock dans une variable
    $articles = getArticles();

    // boucler sur la liste des articles avec un foreach
    foreach ($articles as $article) {
        // dès que l'article comporte l'ID en paramètre, on le renvoie
        if ($article["id"] == $id) {
            return $article;
        }
    }
}

// On crée une fonction qui nous permet d'ajouter un produit au panier

function addToCart($articleToAdd) {
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
function showArticles() {
    foreach ($_SESSION["panier"] as $cartArticles) {
       echo $cartArticles["name"];
       echo $cartArticles["price"];
       echo $cartArticles["description"];
       echo $cartArticles["quantite"];
}
}

