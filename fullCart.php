<?php

require_once './utils/functions.php';

require_once './database/db.php';

require_once './utils/cart.php';


if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && !empty($_GET['a']) && $_GET['a']==='add')
{

    add($_GET['id']);
   
    header('location:./fullCart.php');
    exit();


}

if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && !empty($_GET['a']) && $_GET['a']==='rem')
{

    remove($_GET['id']);

    header('location:./fullCart.php');
    exit();


}

if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && !empty($_GET['a']) && $_GET['a']==='del')
{

    delete($_GET['id']);
  
    header('location:./fullCart.php');
    exit();


}

if (!empty($_GET) && isset($_GET['a']) && !empty($_GET['a']) && $_GET['a']==='dest')
{

    destroy();
    header('location:./');
    exit();


}


if (!empty($_GET) && isset($_GET['a']) && !empty($_GET['a']) && $_GET['a']==='com')
{
    $id_commande=prepareAndExecute("INSERT INTO order_purchase (id_user, date, status) VALUES (3, NOW(), 0);", [], 'nana');

//    debug($id_commande);
//    die();
    foreach (getFullCart() as $item)
    {
        prepareAndExecute("INSERT INTO purchase (id_product, id_order, quantity) VALUES (:id_product, :id_order, :quantity);", ['id_product'=>$item['product']['id'],'id_order'=> $id_commande,'quantity'=>$item['quantity']]);



    }
    $_SESSION['messages']['success'][]='Merci pour votre confiance';
    destroy();
    header('location:./');
    exit();


}

//session_destroy();

$metadata = [
    'title' => 'Wanted - Panier',
    'description' => 'Wanted - Votre site de fringues au top !',
];

getPartial('header', $metadata);

?>
<table class="table table-dark table-striped mt-5">
    <thead>
    <tr>
        <th>Titre</th>
        <th>Prix</th>
        <th>Catégorie</th>
        <th>Photo</th>
        <th><button class="btn btn-light text-dark text-center fs-2">-</button></th>
        <th class="text-center">Quantité</th>
        <th><button class="btn btn-light text-dark text-center fs-2">+</button></th>
        <th>Annuler</th>
    </tr>
    </thead>
    <tbody>

    <?php
    foreach (getFullCart() as $item):
        ?>
        <tr>
            <td><?=    $item['product']['title']; ?></td>
            <td><?=    $item['product']['price']; ?>€</td>
            <td><?=    $item['product']['category']; ?></td>
            <td><img src="assets/upload/<?=    $item['product']['picture']; ?>" width="90" alt=""></td>
            <td>
                <a href="?a=rem&id=<?=    $item['product']['id']; ?>" class="btn btn-light text-dark text-center fs-2">-</a>
            </td>
            <td class="text-center pt-4 fs-4" ><?=    $item['quantity']; ?></td>

            <td >
                <a href="?a=add&id=<?=    $item['product']['id']; ?>" class="btn btn-light text-dark text-center fs-2">+</a>
            </td>
            <td>
                <a href="?a=del&id=<?=    $item['product']['id']; ?>" class="btn btn-info text-white text-center">Annuler</a>
            </td>
        </tr>
    <?php
    endforeach;
    ?>


    </tbody>
</table>
<h3><?=    getTotal().'€'; ?></h3>

<a href="?a=dest" class="btn btn-danger">Vider le panier</a>
<a href="?a=com" class="btn btn-info">Passer la commande </a>






<?php
getPartial('footer');
?>
