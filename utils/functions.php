<?php

/**
 * récupère et affiche un template HTML.
 *
 * @param string $partial
 * @param array  $metadata
 */
function getPartial($partial, $metadata = null)
{
    ob_start();
    if ($metadata) {
        extract($metadata);
    }

    require_once "./inc/{$partial}.php";
    ob_flush();
    ob_clean();
}

/**
 * debugs value.
 *
 * @param mixed $value
 */
function debug($value)
{
    if (is_array($value)) {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    } else {
        var_dump($value);
    }
}

function connect()
{
    if (isset($_SESSION['user'])){

        return true;
    }else{
        return false;
    }
}

function admin()
{
    if (connect() && $_SESSION['user']['role']=='ROLE_ADMIN'){

        return true;
    }else{

        return false;
    }

}





require_once './config/sample.init.php';

require_once './utils/cart.php';