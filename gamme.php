<?php
session_start();
include("./fonction.php"); // on inclut le fichier des fonctions pour pouvoir les appeler
include("./head.php");

// var_dump(getArticlesByGamme(1));

?>

<body>

    <?php include("./header.php") ?>

    <main>

        <div class="container-fluid">
            <div class="row">
                <div class="col" id="hero_gamme">
                    <h1 class="title_page mx-auto">Nos gammes de produits</h1>
                </div>
            </div>
        </div>



        <?php
        // je récupère la liste des gammes que je stocke dans une variable
        $gammes = getGammes();
        foreach ($gammes as $gamme) { ?>
            <div class="container">
                <div class="row">
                    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded text-center my-5" style="font-size:2.5rem; font-weight:bold"><?php echo $gamme["nom"] ?></div>
                </div>

                <div class="row">
                    <?php $articles_gamme = getArticlesByGamme($gamme["id"]);
                    showArticles($articles_gamme)
                    ?>
                </div>
            <?php
        }
            ?>

            </div>
    </main>

    <?php include("./footer.php") ?>
</body>

</html>