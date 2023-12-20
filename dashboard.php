<?php

require_once './utils/functions.php';

require_once './database/db.php';

// connexion DB
// $db = getDb();

// requête en insertion
// $query = "INSERT INTO category (title) VALUES ('Test');";

// exécution de la requête
// $db->query($query);

// requête en sélection
// $querySelect = 'SELECT * FROM category;';

// récupération de la réponse
// $results = $db->query($querySelect);

// résultat de la requête sous forme de tableau associatif
// $categories = $results->fetchAll();

// debug affichage
// var_dump($categories);

$metadata = [
    'title' => 'Wanted - Dashboard',
    'description' => 'Wanted - Gestion des entités',
];

getPartial('header', $metadata);
?>
<h1>Gestion des entités</h1>

<?php
getPartial('footer');

?>

<?php

// ici on prépare la requête et on utilise des marqueurs nommés qui vont représenter les valeurs définitives
// $query = 'INSERT INTO category (title) VALUES(:title);';

// $pdoStatement = $db->prepare($query);

// var_dump($pdoStatement);

// on exécute la requête en passant un tableau associatif qui contient les les cles / valeurs associées

// ici le tableau associatif prend comme clé(s) le ou les noms des marqueurs et les valeurs associées
// $category = ['title' => 'test category'];

// $pdoStatement->execute($category);
$db = getDb();

$query = 'SELECT * FROM category;';

$stmt = $db->prepare($query);

$stmt->execute();

$result = $stmt->fetchAll();

// debug($result);

foreach ($result as $category) {
    // code...
    echo "<h3>{$category['title']}</h3><a class='btn btn-warning'>Editer</a><a class='btn btn-danger'>Supprimer</a>";
}
?>