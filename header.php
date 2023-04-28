<header>
  <?php
  if (isset($_SESSION['id']) && isset($_SESSION['prenom']) && isset($_SESSION['nom'])) {
    echo "<div class=\"container w-50 pt-3\">
                <div class=\"row justify-content-center text-center\">Connecté en tant que " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . "
                </div>
              </div>";
  }
  ?>

  <!-- Navabr -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">

      <!-- Logo -->
      <a href="./index.php"><img src="./images/logo" id="logo"></a>

      <!-- Menu burger -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"></button>

      <!-- Menu -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto d-flex justify-content-between mt-3 text-center">

          <!-- Accueil -->
          <li class="hover nav-item px-4">
            <a class="nav-link active" aria-current="page" href="./index.php"><i class="icone fa-solid fa-house fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Accueil</span></a>
          </li>

          <!-- Gamme produit -->
          <li class="hover nav-item px-4">
            <a class="nav-link active" aria-current="page" href="./gamme.php"><i class="icone fa-solid fa-shop fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Gamme de produits</span></a>
          </li>

          <!-- Panier -->
          <li class="hover nav-item px-4">
            <a class="nav-link" href="./panier.php"><i class="icone fa-solid fa-cart-shopping fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Mon panier</span>
              <span>
                <?php
                if (isset($_SESSION["panier"])) {
                  echo "(" . count($_SESSION["panier"]) . ")";
                } ?>
              </span>
            </a>
          </li>

          <!-- Menu conditionnel -->

          <?php
          if (!isset($_SESSION["id"])) { ?>

            <li class="hover nav-item px-4">
              <a class="nav-link active" aria-current="page" href="./inscription.php"><i class="icone fa-solid fa-user fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Inscription</span></a>
            </li>";

            <li class="hover nav-item px-4">
              <a class="nav-link active" aria-current="page" href="./connexion.php"><i class="icone fa-solid fa-user fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Connexion</span></a>
            </li>

          <?php
          } else { ?>
            <li class="hover nav-item px-4">
              <a class="nav-link active" aria-current="page" href="./compte.php"><i class="icone fa-solid fa-user fa-2x"></i></br><span class="text_icone" style="font-weight: bold">Mon compte</span></a>
            </li>

            <li class="hover nav-item px-4">
              <form action="./index.php" method="POST" class="nav-link active">
                <input type="hidden" name="deconnexion">
                <i class="icone fa-solid fa-power-off fa-2x"></i></br><span><input name="deconnexion" class="text_icone" style="font-weight: bold; border: none; background-color: transparent" type="submit" value="Déconnexion"></span>
              </form>
            </li>";

          <?php } ?>

        </ul>
      </div>

    </div>
  </nav>
</header>