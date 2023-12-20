<?php

require_once './utils/functions.php';

$metadata = [
    'title' => 'Wanted - Laissez nous un message',
    'description' => 'Wanted - Envie de discuter ?  Vous êtes au bon endroit',
];

getPartial('header', $metadata);
?>
<h1>Laissez nous un message</h1>

<?php
getPartial('footer');

?>