<?php

require_once './config/sample.init.php';

/**
 * retourne une instance de la classe PDO.
 *
 * @return PDO
 */
function getDb()
{
    try {
        // on va essayer de se connecter à la BDD

        return new PDO('mysql:host='.CONFIG['db']['HOST'].';dbname='.CONFIG['db']['DBNAME'].';port='.CONFIG['db']['PORT']."'", CONFIG['db']['USER'], CONFIG['db']['PWD'], CONFIG['options']);
    } catch (\PDOException $error) {
        // si erreur de connexion on la capte ici

        exit($error->getMessage());
    }
}

// new PDO('mysql:host=localhost;dbname=wanted;port=3306', 'root', '');

/**
 * prépare et exécute une requête passée à paramètre.
 *
 * @param string $query
 * @param array  $values
 * @param bool   $lastId
 *
 * @return mixed
 */
function prepareAndExecute($query, $values = [], $lastId = false)
{
    // on se connecte à la BDD
    $pdo = getDb();

    // on prépare la requête
    $pdoStatement = $pdo->prepare($query);
    foreach ($values as $index =>$value)
    {
        $values[$index]=htmlspecialchars(trim($value));

    }

    // on exécute la requête
    // si l'exécution est ok on retourne le résultat
    if ($pdoStatement->execute($values)) {
        // si lastId vaut true on retourne l'id du dernier élément inséré
        if (true === $lastId) {
            return $pdo->lastInsertId();
        }

        // sinon on retourne l'instance de PDOStatement
        return $pdoStatement;
    }
}
