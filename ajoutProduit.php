<?php

require_once './utils/functions.php';

require_once './database/db.php';

// requête pour récupérer tout les enregistrements de catégorie
// pour boucler dans le select option
$categories=prepareAndExecute("SELECT * FROM category;")->fetchAll();

//debug($categories);

// obligatoire
if (!empty($_POST)){

    // debug($_POST);
   // die;
    //controle des erreurs, on s'assure que tout les champs aient été saisie.
    // $error a pour but de générer la condition finale de soumission de formulaire
$error=0;

   if (empty($_POST['title']))
   {
    $error++;
    $title="Champs obligatoire";

   }

    if (empty($_POST['price']))
    {
    $error++;
    $price="Champs obligatoire";

    }

    if (empty($_POST['description']))
    {
    $error++;
    $description="Champs obligatoire";

    }

    if (empty($_POST['id_category']))
    {
    $error++;
    $id_category="Champs obligatoire";

    }

    // controle photo
    if (empty($_FILES['picture']['name']))
    {
        $error++;
        $picture="Champs obligatoire";

    }else{// ici on a bien saisie un fichier

        // controle du type
        $types=['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

        // in_array() est une méthode vérifiant une occurence dans un tableau (sur les valeurs mais pas sur les indices. La recherche est passée en 1er param, le tableau en 2nd param)
        if (!in_array($_FILES['picture']['type'], $types))
        {
            $error++;
            $picture="Formats autorisés: 'image/jpeg', 'image/jpg', 'image/png', 'image/webp'";

        }

    }

    // condition finale qui vérifie qu'aucune erreur n'ai été detectée
    if ($error===0)
    {
        // traitement photo
        $picture_name=$_FILES['picture']['name'];
        // explode explose une chaine de caractère par rapport à un séparateur
        // ici on choisi le sparateur . pour trouver les contenus avant et après l'extension du fichier.
        //le résultat est retourné dans un tableau auto indexé. l'indice 0 sera la partie avant l'extension et l'indice 1 l'extension elle même
        $ext=explode('.', $picture_name)[1];

        // on renomme le fichier photo
        // dans le soucis d'un nom de fichier unique on concatène la date complète à l'instant t formatée avec le title du produit puis y ajoutons l'extension à la fin
        $picture_bdd=date_format(new DateTime(), 'd_m_Y_H_i_s').'_'.$_POST['title'].'.'.$ext;

        if (!file_exists('assets/upload'))
        {
            mkdir('assets/upload', 777);
        }
        // upload du fichier temporaire
        copy($_FILES['picture']['tmp_name'], 'assets/upload/'.$picture_bdd);

        // on prepare le tableau associatif des marqueurs
        $data=$_POST;
        // on ajoute la valeur du marqueur manquant pour picture
        $data['picture']=$picture_bdd;
//        debug($data);
//        die;

        $success=prepareAndExecute("INSERT INTO product (title, price, description, id_category, picture) VALUES (:title, :price, :description,:id_category ,:picture);", $data);

        if ($success)
        {
           $_SESSION['messages']['success'][]="Produit ajouté";
//           debug($_SESSION);
//           die;

           header('location:./gestionProduit.php');
           exit();


        }else{
            $_SESSION['messages']['danger'][]="Problème, veuillez réitérer l'ajout";
//            header('location:./ajoutProduit.php');
//            exit();
        }





    }












}// fin de condition de soumission du formulaire






$metadata = [
    'title' => 'Wanted - Ajout Produit',
    'description' => 'Ajouter vos produits',
];

getPartial('header', $metadata);
?>

<h1><?=    $metadata['title']; ?></h1>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label for="" class="form-label">Titre du produit</label>
        <input type="text" name="title" class="form-control">
        <small class="text-danger"><?=    $title ?? ''; ?></small>
    </div>
    <div class="form-group mb-3">
        <label for="" class="form-label">Prix</label>
        <input type="text" name="price" class="form-control">
        <small class="text-danger"><?=    $price ?? ''; ?></small>
    </div>
    <div class="form-group mb-3">
        <label for="" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="" cols="15" rows="5"></textarea>
        <small class="text-danger"><?=    $description ?? ''; ?></small>
    </div>
    <div class="form-group mb-3">
        <label for="" class="form-label">Photo</label>
        <input type="file" name="picture" class="form-control">
        <small class="text-danger"><?=    $picture ?? ''; ?></small>
    </div>
    <div class="form-group mb-3">
        <label for="" class="form-label">Catégorie</label>
        <select name="id_category" id="" class="form-select">
            <option value="">-- Selectionnez une catégorie --</option>
            <?php
            foreach ($categories as $category):
            ?>
            <option value="<?=    $category['id']; ?>"> <?=    $category['title']; ?> </option>
            <?php
            endforeach;
   ?>
        </select>
        <small class="text-danger"><?=    $id_category ?? ''; ?></small>
    </div>
    <button class="btn btn-primary" type="submit">Valider</button>

</form>






<?php
getPartial('footer');

?>
