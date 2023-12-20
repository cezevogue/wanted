<?php

require_once './utils/functions.php';

require_once './database/db.php';

// requête pour récupérer tout les enregistrements de catégorie
// pour boucler dans le select option
$categories = prepareAndExecute("SELECT * FROM category;")->fetchAll();

// condition de validation de la page modification
if (!empty($_GET) && isset($_GET['id'])) {
    // si ok on va récupérer le produit en question
    $product = prepareAndExecute("SELECT * FROM product WHERE id=:id;", ['id' => $_GET['id']])->fetch();
    debug($product);


} else {

    header('location:./');
    exit();
}
//debug($categories);

// obligatoire
if (!empty($_POST)) {

    // debug($_POST);
    // die;
    //controle des erreurs, on s'assure que tout les champs aient été saisie.
    // $error a pour but de générer la condition finale de soumission de formulaire
    $error = 0;

    if (empty($_POST['title'])) {
        $error++;
        $title = "Champs obligatoire";

    }

    if (empty($_POST['price'])) {
        $error++;
        $price = "Champs obligatoire";

    }

    if (empty($_POST['description'])) {
        $error++;
        $description = "Champs obligatoire";

    }

    if (empty($_POST['id_category'])) {
        $error++;
        $id_category = "Champs obligatoire";

    }

    // controle photo // si l'input de modification photo a été saisi
    if (!empty($_FILES['picture_edit']['name'])) {
      // ici on a bien saisie un fichier pour modification


        // controle du type
        $types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

        // in_array() est une méthode vérifiant une occurence dans un tableau (sur les valeurs mais pas sur les indices. La recherche est passée en 1er param, le tableau en 2nd param)
        if (!in_array($_FILES['picture_edit']['type'], $types)) {
            $error++;
            $picture = "Formats autorisés: 'image/jpeg', 'image/jpg', 'image/png', 'image/webp'";

        }else{// pas d'erreur on entame le renommage et l'upload ainsi que la suppression du précédent fichier
            // traitement photo
            $picture_name = $_FILES['picture_edit']['name'];
            // explode explose une chaine de caractère par rapport à un séparateur
            // ici on choisi le sparateur . pour trouver les contenus avant et après l'extension du fichier.
            //le résultat est retourné dans un tableau auto indexé. l'indice 0 sera la partie avant l'extension et l'indice 1 l'extension elle même
            $ext = explode('.', $picture_name)[1];

            // on renomme le fichier photo
            // dans le soucis d'un nom de fichier unique on concatène la date complète à l'instant t formatée avec le title du produit puis y ajoutons l'extension à la fin
            $picture_bdd = date_format(new DateTime(), 'd_m_Y_H_i_s') . '_' . $_POST['title'] . '.' . $ext;


            // upload du fichier temporaire
            copy($_FILES['picture_edit']['tmp_name'], 'assets/upload/' . $picture_bdd);

            // on supprime l'ancien,  unlink attend le nom du fichier et son emplacement en argument
            unlink('assets/upload/'.$product['picture']);


        }// fin else de error sur fichier

    }else{ // si on est ici c'est l'input type file picture edit n'a pas été saisie
        $picture_bdd=$product['picture'];

    }

    // condition finale qui vérifie qu'aucune erreur n'ai été detectée
    if ($error === 0) {

        // on prepare le tableau associatif des marqueurs
        $data = $_POST;
        // on ajoute la valeur du marqueur manquant pour picture
        $data['picture'] = $picture_bdd;
//        debug($data);
//        die;

        $success = prepareAndExecute("UPDATE product SET title=:title, description=:description, price=:price, picture=:picture, id_category=:id_category WHERE id=:id;", $data);

        if ($success) {
            $_SESSION['messages']['success'][] = "Produit modifié";
//           debug($_SESSION);
//           die;

            header('location:./gestionProduit.php');
            exit();


        } else {
            $_SESSION['messages']['danger'][] = "Problème, veuillez réitérer l'ajout";
//            header('location:./ajoutProduit.php');
//            exit();
        }


    }


}// fin de condition de soumission du formulaire


$metadata = [
    'title' => 'Wanted - Modification Produit',
    'description' => 'Ajouter vos produits',
];

getPartial('header', $metadata);
?>

<h1><?= $metadata['title']; ?></h1>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label for="" class="form-label">Titre du produit</label>
        <input type="text" name="title" value="<?= $product['title'] ?? ''; ?>" class="form-control">
        <small class="text-danger"><?= $title ?? ''; ?></small>
    </div>
    <div class="form-group mb-3">
        <label for="" class="form-label">Prix</label>
        <input type="text" name="price" value="<?= $product['price'] ?? ''; ?>" class="form-control">
        <small class="text-danger"><?= $price ?? ''; ?></small>
    </div>
    <div class="form-group mb-3">
        <label for="" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="" cols="15" rows="5"><?= $product['description'] ?? ''; ?>"
        </textarea>
        <small class="text-danger"><?= $description ?? ''; ?></small>
    </div>
    <div class="d-flex">
        <div class="form-group mb-3  me-5">

            <label for="" class="form-label">Photo</label>
            <input type="file" name="picture_edit" class="form-control">
            <small class="text-danger"><?= $picture ?? ''; ?></small>
        </div>
        <div class="text-center ms-5">
            <img src="assets/upload/<?=    $product['picture']; ?>" width="150" alt="">
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="" class="form-label">Catégorie</label>
        <select name="id_category" id="" class="form-select">
            <option value="">-- Selectionnez une catégorie --</option>
            <?php
            foreach ($categories as $category):
                ?>
                <option  <?php if ($category['id']== $product['id_category']):  echo 'selected';  endif;  ?>   value="<?= $category['id']; ?>"> <?= $category['title']; ?> </option>
            <?php
            endforeach;
            ?>
        </select>
        <input type="hidden" name="id" value="<?=    $product['id']  ?? 0; ?>">
        <small class="text-danger"><?= $id_category ?? ''; ?></small>
    </div>
    <button class="btn btn-primary" type="submit">Valider</button>

</form>


<?php
getPartial('footer');

?>
