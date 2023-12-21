<?php

if (!isset($_SESSION['cart'])):
$_SESSION['cart'] = [];
endif;

function add(int $id): void
{
    // on stock le tableau dans une variable pour pouvoir travailler dessus
    $panier = $_SESSION['cart'];

    // $panier=['id'=> 'quantite' ]

    // si on a l'id chargé en session
    if (isset($panier[$id]) && !empty($panier[$id])) {
        $panier[$id]++;
        // alors on incrémente sa quantité
    } else { //sinon on initialise sa quantité à 1
        $panier[$id] = 1;

    }

    // après avoir réaffecter la quantité sur l'entrée on réaffecte le tableau
    // modifié à la session
    $_SESSION['cart'] = $panier;


}

function remove(int $id): void
{
    // on stock le tableau dans une variable pour pouvoir travailler dessus
    $panier = $_SESSION['cart'];

    // $panier=['id'=> 'quantite' ]

    // si on a l'id chargé en session et que la quantité est suprérieur à 1
    if (isset($panier[$id]) && !empty($panier[$id]) && $panier[$id] > 1) {
        $panier[$id]--;
        // alors on incrémente sa quantité
    } else { //sinon on supprime totalement l'entrée du tableau
        unset($panier[$id]);

    }

    // après avoir réaffecter la quantité sur l'entrée on réaffecte le tableau
    // modifié à la session
    $_SESSION['cart'] = $panier;


}

function delete(int $id): void
{
    // on stock le tableau dans une variable pour pouvoir travailler dessus
    $panier = $_SESSION['cart'];

    // $panier=['id'=> 'quantite' ]

    // si on a l'id chargé en session et que la quantité est suprérieur à 1
    if (isset($panier[$id]) && !empty($panier[$id])) {

        unset($panier[$id]);

    }

    // après avoir réaffecter la quantité sur l'entrée on réaffecte le tableau
    // modifié à la session
    $_SESSION['cart'] = $panier;


}

function destroy(): void
{
    unset($_SESSION['cart']);

}

function getFullCart(): array
{
    $panier = $_SESSION['cart'];

    $panierDetail = [];

    foreach ($panier as $id => $quantite) {
        $panierDetail[] = [
            'product' => prepareAndExecute("SELECT p.*, c.title as category FROM product p INNER JOIN category c ON c.id=p.id_category WHERE p.id=:id;", ['id' => $id])->fetch(),
            'quantity' => $quantite
        ];

    }

    return $panierDetail;


}

function getTotal(): float
{
    $total = 0;
    foreach (getFullCart() as $item) {

        $total += $item['quantity'] * $item['product']['price'];
    }

    return $total;

}

function getQuantity()
{
   $quantity=0;
    foreach (getFullCart() as $item) {

        $quantity += $item['quantity'] ;
    }

    return $quantity;

}

