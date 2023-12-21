<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $description; ?>">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="./assets/js/app.js" defer></script>
</head>
<?php

require_once './config/sample.init.php';


?>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= BASE; ?>">Wanted</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= BASE; ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE . 'contact.php'; ?>">Contact</a>
                </li>
                <?php
                // voir function.php: fonction qui vérifie qu'un utilisateur soit en session et que son role soit admin.
                //Donc le dropdown n'apparait que si on est connecté et admin
                if (admin()): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Back Ofice
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= BASE . 'categories.php'; ?>">Catégories</a></li>
                        <li><a class="dropdown-item" href="<?= BASE . 'gestionProduit.php'; ?>">Gestion des produits</a>
                        </li>
                        <li><a class="dropdown-item" href="<?= BASE . 'ajoutProduit.php'; ?>">Ajouter un produit</a>
                        </li>

                    </ul>
                </li>
                <?php endif;?>
            </ul>
            <a href="<?= BASE . 'fullCart.php'; ?>" class="btn btn-warning">Mon panier <span
                        class="badge bg-danger text-white"><?= getQuantity(); ?></span> </a>
            <?php
            // voir function.php: fonction qui vérifie qu'un utilisateur soit en session .
            //Donc les bouton inscription et connexion n'apparaissent que si il n'est pas connecté, dans le else on affiche le bouton de déconnexion qui vera sont action passée en get appelée dans index.php (voir index.php pur la deco qui consiste simplement à faite un unset($_SESSION['user']))

            if (!connect()):?>
            <div>

                <a href="<?=    BASE.'connexion.php'; ?>" class="btn btn-info text-white">Connexion</a>
                  <a href="<?=    BASE.'inscription.php'; ?>" class="btn btn-success text-white">Inscription</a>
            </div>
            <?php else: ?>
            <a href="<?=    BASE.'?a=dec'; ?>" class="btn btn-dark text-white">Déconnexion</a>
            <?php endif;?>
            <!-- <form class="d-flex" role="search">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form> -->
        </div>
    </div>
</nav>

<div class="container mt-3">
    <?php
    if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])):
        foreach ($_SESSION['messages'] as $type => $messages):
            foreach ($messages as $key => $message):
                ?>

                <div class="text-center w-50 mx-auto alert alert-<?= $type; ?> mb-3">

                    <p><?= $message; ?></p>
                </div>


                <?php
                unset($_SESSION['messages'][$type][$key]);
            endforeach; endforeach; endif;
    ?>
