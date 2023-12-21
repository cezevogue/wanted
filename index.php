<?php

require_once './utils/functions.php';

require_once './database/db.php';

require_once './utils/cart.php';

//session_destroy();

$metadata = [
    'title' => 'Wanted - Bienvenue',
    'description' => 'Wanted - Votre site de fringues au top !',
];

if (connect() && isset($_GET['a']) && !empty($_GET['a']) && $_GET['a']==='dec')
{
    unset($_SESSION['user']);
    $_SESSION['messages']['info'][]="A bientôt";
    header('location:./');
    exit();


}


if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && !empty($_GET['a']) && $_GET['a']==='add')
{

    add($_GET['id']);
    $_SESSION['messages']['success'][]="Félicitation, ton produit est à présent dans le panier";
    header('location:./');
    exit();


}
//debug(getFullCart());




getPartial('header', $metadata);

// SELECT p.*, c.title as category FROM product p INNER JOIN category c ON c.id=p.id_category;
$products=prepareAndExecute("SELECT p.*, c.title as category FROM product p INNER JOIN category c ON c.id=p.id_category;")->fetchAll();

//debug($products);

?>


<h1>Accueil Wanted</h1>

    <div class="row justify-content-evenly">


        <?php
      foreach ($products as $product):
        ?>
        <div class="col-md-3 card">
            <div class="card-header">
                <img src="<?=    'assets/upload/'.$product['picture']; ?>" alt="" class="card-img-top">

            </div>
            <div class="card-body">
                <h3 class="card-title"><?=    $product['title']; ?></h3>
                <h2 class="card-title"><?=    $product['price']."€"; ?></h2>
                <h2 class="card-title"><?=    $product['category']; ?></h2>
            </div>
            <a href="?a=add&id=<?=    $product['id']; ?>" class="btn btn-info">ajouter au panier</a>
        </div>
        <?php
      endforeach;
        ?>


    </div>






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