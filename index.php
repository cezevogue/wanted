<?php

require_once './utils/functions.php';

$metadata = [
    'title' => 'Wanted - Bienvenue',
    'description' => 'Wanted - Votre site de fringues au top !',
];

getPartial('header', $metadata);

?>


<h1>Accueil Wanted</h1>

<?php
getPartial('footer');
?>

<?php
// class User
// {
//     public $firstName;
//     public $lastName;

//     public function __construct($nom, $prenom)
//     {
//         $this->firstName = $prenom;
//         $this->lastName = $nom;
//     }

//     public function greet()
//     {
//         echo "Hello je suis {$this->firstName}  {$this->lastName}";
//     }
// }

// $user = new User('Lafont', 'Lionel');
// // $user->greet();
// $user2 = new User('Bernardes', 'Maycon');
// // $user2->greet();

// var_dump($user);
?>