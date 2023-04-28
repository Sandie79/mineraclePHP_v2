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

function getArticlesByGamme($id_gamme)
{
    $db = getConnection();

    // je prépare une requête qui va récupérer tous les articles
    $query = $db->prepare("SELECT * FROM articles WHERE id_gamme = :id_gamme"); // ne jamais mettre de variable php dans une requête SQL brute pour plus de sécurité

    // je lance ma requête en indiquant à quoi correspond ma variable SQL
    $query->execute(array(
        "id_gamme" => $id_gamme
    ));

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


// ******************************************* UTILISATEURS (INSCRIPTION ET CONNEXION) ****************************************************

// ***************** vérifier la présence de champs vides ************************

function checkEmptyFields()
{
    foreach ($_POST as $field) {
        if (empty($field)) {
            return true;
        }
    }
    return false;
}


// ***************** vérifier la longueur des champs ************************

function checkInputsLenght()
{
    $inputsLenghtOk = true;

    if (strlen($_POST['firstName']) > 25 || strlen($_POST['firstName']) < 3) {
        $inputsLenghtOk = false;
    }

    if (strlen($_POST['lastName']) > 25 || strlen($_POST['lastName']) < 3) {
        $inputsLenghtOk = false;
    }

    if (strlen($_POST['email']) > 25 || strlen($_POST['email']) < 5) {
        $inputsLenghtOk = false;
    }

    if (strlen($_POST['adresse']) > 40 || strlen($_POST['adresse']) < 5) {
        $inputsLenghtOk = false;
    }

    if (strlen($_POST['codePostal']) !== 5) {
        $inputsLenghtOk = false;
    }

    if (strlen($_POST['ville']) > 25 || strlen($_POST['ville']) < 3) {
        $inputsLenghtOk = false;
    }

    return $inputsLenghtOk;
}


// ***************** vérifier que le mot de passe réunit tous les critères demandés ************************

function checkPassword($password)
{
    // minimum 8 caractères et maximum 15, minimum 1 lettre, 1 chiffre et 1 caractère spécial
    $regex = "^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@$!%*?/&])(?=\S+$).{8,15}$^";
    return preg_match($regex, $password);
}


// ***************** vérifier que l'e-mail est déjà utilisé ************************

// function checkEmail($email)
// {
//     $db = getConnection();

//     $query = $db->prepare("SELECT * FROM clients WHERE email = ?");
//     $user = $query->execute([$email]);

//     if ($user) {
//         return true;
//     } else {
//         return false;
//     }
// }

// ***************** créer un utilisateur ************************

function createUser()
{
    $db = getConnection();  // on se connecte à la bdd

    if (checkEmptyFields()) {  // vérif si champs vides => message d'erreur si c'est le cas
        echo "<div class=\"container w-50 text-center p-3 mt-2 bg-danger text-white\"> Attention : un ou plusieurs champs vides !</div>";
    } else {

        if (checkInputsLenght() == false) {  // vérif si longeur des champs correcte
            echo "<div class=\"container w-50 text-center p-3 mt-2 bg-danger text-white\"> Attention : longueur incorrecte d'un ou plusieurs champs !</div>";
        } else {

            // if (checkEmail($_POST['email'])) { // vérif si email déjà utilisé
            //     echo "<div class=\"container w-50 text-center p-3 mt-2 bg-danger text-white\"> Attention : e-mail déjà utilisé !</div>";
            // } else {

            if (!checkPassword(strip_tags($_POST['password']))) { // vérif si mdp réunit les critères requis
                echo "<div class=\"container w-50 text-center p-3 mt-2 bg-danger text-white\"> Attention : sécurité du mot de passe insuffisante !</div>";
            } else {

                // hâchage du mot de passe
                echo '<script>alert(\longueur champs ok!\')</script>';
                $hashedPassword = password_hash(strip_tags($_POST['password']), PASSWORD_DEFAULT);

                // insertion de l'utilisateur en base de données
                $query = $db->prepare('INSERT INTO clients (nom, prenom, email, mot_de_passe) VALUES(:nom, :prenom, :email, :mot_de_passe)');
                $query->execute(array(
                    'nom' =>  strip_tags($_POST['lastName']),
                    'prenom' => strip_tags($_POST['firstName']),
                    'email' =>  strip_tags($_POST['email']),
                    'mot_de_passe' => $hashedPassword,
                ));

                // récupération de l'id de l'utilisateur créé
                $id = $db->lastInsertId();

                // insertion de son adresse dans la table adresses
                createAdresse($id);

                // on renvoie un message de succès 
                echo '<script>alert(\'Le compte a bien été créé !\')</script>';
            }
        }
    }
}

function createAdresse($user_id) {

    $db = getConnection();

    $query = $db->prepare('INSERT INTO adresses (id_client, adresse, code_postal, ville) VALUES(:id_client, :adresse, :code_postal, :ville)');
    $query->execute(array(
        'id_client' =>  $user_id,
        'adresse' => strip_tags($_POST['adresse']),
        'code_postal' =>  strip_tags($_POST['codePostal']),
        'ville' => strip_tags($_POST['ville']),
    ));
}

// ***************** récupérer l'adresse du client en bdd ************************

function getUserAddresses()
{
    $db = getConnection();

    $query = $db->prepare('SELECT * FROM adresses WHERE id_client = ?');
    $query->execute([$_SESSION['id']]);
    return $query->fetchAll();
}


// ***************** définir / mettre à jour l'adresse de la session ************************

function setSessionAddresses()
{
    $_SESSION['adresses'] = getUserAddresses();
}

// Vérifier sir l'utilisateur existe bien dans la base de données
// ***************** se connecter  ************************

function logIn()
{
    // connexion à la base de données
    $db = getConnection();

    // on nettoie l'email saisi avec strip tags, et on le stocke dans la variable $userEmail
    // pour le manipuler plus facilement
    $userEmail = strip_tags($_POST['email']);

    // on fait une requête SQL pour vérifier si le client existe, grâce à son email
    $query = $db->prepare('SELECT * FROM clients WHERE email = ?');
    $query->execute([$userEmail]);
    // on récupère le résultat de la requête (soit un utilisateur, soit rien)
    $result = $query->fetch();

    // si la requête n'a rien récupéré => l'utilisateur n'existe pas
    if (!$result) {
        // on renvoie un message d'erreur en JS via la fonction alert() (volontairement imprécis pour ne pas aider les hackers)
        echo '<script>alert(\'E-mail ou mot de passe incorrect !\')</script>';

        // sinon => l'utilisateur existe
    } else {
        // on vérifie que son mot de passe saisi (en clair) correspond à son mot de passe en base de données (hashé)
        // pour cela, on utilise la fonction password_verify, qui compare un mdp en clair (1er paramètre) et un mdp hashé (2è p.)
        // elle renvoie true si les deux correspondent (le mpd hashé contient des informations qui permettent de faire ça)
        $isPasswordCorrect = password_verify($_POST['password'], $result['mot_de_passe']);

        // si les deux correspondent => mot de passe ok => on stocke les infos de l'utilisateur dans la session
        // on stocke aussi son adresse g^râce à la fonction setSessionAdress()
        // et on renvoie un message de succès
        if ($isPasswordCorrect) {
            $_SESSION['id'] = $result['id'];
            $_SESSION['nom'] = $result['nom'];
            $_SESSION['prenom'] = $result['prenom'];
            $_SESSION['email'] = $userEmail;
            setSessionAddresses();
            echo '<script>alert(\'Vous êtes connecté(e) !\')</script>';
            // sinon, on renvoie un message d'erreur (volontairement imprécis pour ne pas aider les hackers)
        } else {
            echo '<script>alert(\'E-mail ou mot de passe incorrect !\')</script>';
        }
    }
}

// fonction se déconnecter
function deconnexion() {
    $_SESSION=[];
    echo '<script>alert(\'Vous êtes déconnecté(e) !\')</script>';
}


// Récupérer les données saisies dans le formulaire d'inscription et les stocker en BDD

// function createUser()
// {
//     $db = getConnection();

//     // Vérifie qu'il provient d'un formulaire
//     if ($_SERVER["REQUEST_METHOD"] == "POST") {

//         $firstName = $_POST["firstName"];
//         $lastName = $_POST["lastName"];
//         $email = $_POST["email"];
//         $password = $_POST["password"];
//         $adresse = $_POST["adresse"];
//         $codePostal = $_POST["codePostal"];
//         $ville = $_POST["ville"];

//         if (!isset($firstName)) {
//             die("S'il vous plaît renseignez votre prénom");
//         }
//         if (!isset($lastName)) {
//             die("S'il vous plaît renseignez votre nom");
//         }
//         if (!isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             die("S'il vous plaît renseignez votre adresse e-mail");
//         }
//         if (!isset($password)) {
//             die("S'il vous plaît renseignez votre mot de passe");
//         }
//         if (!isset($adresse)) {
//             die("S'il vous plaît renseignez votre adresse");
//         }
//         if (!isset($codePostal)) {
//             die("S'il vous plaît renseignez votre code postal");
//         }
//         if (!isset($ville)) {
//             die("S'il vous plaît renseignez votre ville");
//         }

//         //Afficher toute erreur de connexion
//         if ($db->connect_error) {
//             die('Error : (' . $db->connect_errno . ') ' . $db->connect_error);
//         }

//         // insertion de l'utilisateur en base de données
//         $query = $db->prepare('INSERT INTO clients (nom, prenom, email, mot_de_passe) VALUES(:nom, :prenom, :email, :mot_de_passe)');
//         $query->execute(array(
//             'prenom' => strip_tags($_POST['firstName']),
//             'nom' =>  strip_tags($_POST['lastName']),
//             'email' =>  strip_tags($_POST['email']),
//             'mot_de_passe' => $hashedPassword,
//         ));

//         // récupération de l'id de l'utilisateur créé
//         $id = $db->lastInsertId();


//         if ($query->execute()) {
//             print "Bonjour " . $name . "!, votre adresse e-mail est " . $email;
//         } else {
//             print $db->error;
//         }
//     }
// }


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

// fonction modifier le mot de passe
function modifMdp()
{
    if (!checkEmptyFields()) {  // on vérifie d'abord si il n'y a pas de champs vides. Si oui, message d'erreur et fin de la fonction.

        $oldPassword = getUserPassword();   // on récupère le mdp actuel en base
        $oldPassword = $oldPassword['mot_de_passe'];

        // on vérifie le mdp actuel saisi par rapport à l'actuel en base
        $isPasswordCorrect = password_verify(strip_tags($_POST['oldPassword']), $oldPassword);

        // si mdp actuel saisi = mdp actuel en base, on passe à la suite. Sinon fin de la fonction et message d'erreur
        if ($isPasswordCorrect) {

            // on nettoie le nouveau mdp choisi
            $newPassword = strip_tags($_POST['newPassword']);

            // on vérifie que le nouveau mdp choisi respecte la regex. Si pas bon => sortie et message d'erreur
            if (checkPassword($newPassword)) {

                //si nouveau mdp ok => on le sauvegarde en le hâchant avec password_hash()
                $db = getConnection();
                $query = $db->prepare('UPDATE clients SET mot_de_passe = :newPassword WHERE id = :id');
                $query->execute(array(
                    'newPassword' => password_hash($newPassword, PASSWORD_DEFAULT),
                    'id' => $_SESSION['id']
                ));

                echo "<script>alert(\"Mot de passe modifié avec succès\")</script>";
            } else {
                echo "<script>alert(\"Attention : sécurité du mot de passe insuffisante ! \")</script>";
            };
        } else {
            echo "<script>alert(\"Erreur : l'ancien mot de passe saisi est incorrect\")</script>";
        }
    } else {
        echo "<script>alert(\"Attention : un ou plusieurs champs vides ! \")</script>";
    }
}

// fonction pour récupérer le mot de passe de l'utilisateur
function getUserPassword() {
    $db = getConnection();

   $query = $db->prepare('SELECT mot_de_passe FROM clients WHERE id = ?');
    $query->execute([$_SESSION['id']]);
    return $query->fetch();
}

