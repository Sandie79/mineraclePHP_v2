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
                    <h1 class="mx-auto">Mon compte</h1>
                </div>
            </div>
        </div>

          <!-- Titre du formulaire -->
          <div class="container">
            <div class="row">
                <div class="shadow-lg p-3 mb-3 bg-body-tertiary rounded text-center my-5" style="font-size:2.5rem; font-weight:bold">Mon compte</div>
            </div>
        </div>

        <div class="container p-5 text-center">
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

                <div class="col-md-3 hover nav-item px-4">
                    <a class="nav-link active" aria-current="page" href="./commandes.php"><i class="icone fas fa-clipboard-list fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Voir mes commandes</span></a>
                </div>
            </div>
        </div>

    </main>

    <?php include("./footer.php") ?>

</body>