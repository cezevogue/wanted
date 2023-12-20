<?php

require_once './utils/functions.php';

require_once './database/db.php';

$metadata = [
    'title' => 'Wanted - GModification produit',
    'description' => 'Modifiez vos produits',
];

getPartial('header', $metadata);
?>

<h1><?=    $metadata['title']; ?></h1>





<?php
getPartial('footer');

?>
