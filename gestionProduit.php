<?php

require_once './utils/functions.php';

require_once './database/db.php';

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
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <a href="" class="btn btn-info">Modifier</a>
            <a href="" onclick="return confirm('Etes-vous sûr?')" class="btn btn-danger">Supprimer</a>
        </td>
    </tr>
    </tbody>
</table>


<?php
getPartial('footer');

?>
