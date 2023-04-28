<?php
session_start();
include("./fonction.php"); // on inclut le fichier des fonctions pour pouvoir les appeler
include("./head.php");

if (isset($_POST['articleToDisplay'])) {

    $articleToDisplayId = $_POST['articleToDisplay'];
    $articleToDisplay = getArticleFromId($articleToDisplayId);
}

// if (isset($_POST['modifInfos'])) {
//     modifInfos();
// }

// if (isset($_POST['modifAdresse'])) {
//     modifAdresse();
// }

if (isset($_POST['modifMdp'])) {
    modifMdp();
}

?>


<body>
    <?php include("./header.php") ?>

    <main>

        <div class="container-fluid">
            <div class="row">
                <div class="col" id="hero_accueil">
                    <h1 class="mx-auto">Commandes</h1>
                </div>
            </div>
        </div>

        <!-- Titre du formulaire -->
        <div class="container">
            <div class="row">
                <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded text-center my-5" style="font-size:2.5rem; font-weight:bold">Consulter mes commandes</div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="container-fluid w-50">
            <form action="./index.php" method="POST">

                <!-- Mail -->
                <div class="row">
                    <label for="email" class="hidden-label">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="email">
                    <div id="email" class="form-text">Nous ne partagerons jamais votre email avec des tiers</div>
                </div>

                <!-- Mot de passe -->
                <div class="row">
                    <label for="password" class="hidden-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>

                <!-- Bouton "Valider" -->
                <input class="button button-full m-auto mt-5" id="btn_ajout" type="submit" value="Valider">

            </form>

            <div class="container mt-3 p-5 text-center">
                <div class="row p-5">
                    <div class="col-md-3 hover nav-item px-4">
                        <a class="nav-link active" aria-current="page" href="./modifInfos.php"><i class="icone fa-solid fa-user fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Modifier mes informations</span></a>
                    </div>

                    <div class="col-md-3 hover nav-item px-4">
                        <a class="nav-link active" aria-current="page" href="./modifMdp.php"><i class="icone fas fa-key fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Modifier mon mot de passe</span></a>
                    </div>

                    <div class="col-md-3 hover nav-item px-4">
                        <a class="nav-link active" aria-current="page" href="./modifAdresse.php"><i class="icone fas fa-home fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Modifier mon adresse</span></a>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <?php include("./footer.php") ?>

</body>