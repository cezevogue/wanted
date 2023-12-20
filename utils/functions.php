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
