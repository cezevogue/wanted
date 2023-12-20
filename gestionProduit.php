<?php

require_once './utils/functions.php';

require_once './database/db.php';

$products=prepareAndExecute("SELECT p.*, c.title as category FROM product p INNER JOIN category c ON p.id_category=c.id;")->fetchAll();

//ebug($products);





$metadata = [
    'title' => 'Wanted - Gestion des produits',
    'description' => 'Gérez vos produits',
];

getPartial('header', $metadata);
?>

<h1><?=    $metadata['title']; ?></h1>

<table class="table table-dark table-striped mt-5">
    <thead>
    <tr>
        <th>Titre</th>
        <th>Prix</th>
        <th>Catégorie</th>
        <th>Photo</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>

    <?php
     foreach ($products as $product):
    ?>
    <tr>
        <td><?=    $product['title']; ?></td>
        <td><?=    $product['price']; ?>€</td>
        <td><?=    $product['category']; ?></td>
        <td><img src="assets/upload/<?=    $product['picture']; ?>" width="90" alt=""></td>
        <td>
            <a href="<?=    BASE.'modificationProduit.php?id='.$product['id']; ?>" class="btn btn-info">Modifier</a>
            <a href="" onclick="return confirm('Etes-vous sûr?')" class="btn btn-danger">Supprimer</a>
        </td>
    </tr>
    <?php
   endforeach;
    ?>


    </tbody>
</table>


<?php
getPartial('footer');

?>
