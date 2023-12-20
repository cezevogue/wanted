<?php

require_once './utils/functions.php';

require_once './database/db.php';

$metadata = [
    'title' => 'Wanted - Gestion des catégories',
    'description' => 'Ajouter, modifier, supprimer vos catégories',
];

getPartial('header', $metadata);
?>
<h1>Gestion des catégories</h1>

<?php

$action='create';
    // debug($_POST);
    if (!empty($_POST)) {
        if (isset($_POST['submit']) && !empty($_POST['title'])) {
            // on extrait les clés du tableau associatif sous forme de variables
            extract($_POST);
          var_dump($_POST);
            // avec trim on supprime les espaces avant et après l'input
            // avec htmlspecialchars on convertit certains caractères spéciaux en entités HTML
            $title = htmlspecialchars(trim($title));

            // construction de la requête
            $query = 'INSERT INTO category (title) VALUES(:title);';
            $data = ['title' => $title];

            if ('update' === $action) {
                $query = 'UPDATE category SET title = :title WHERE id=:id;';
                $data = [
                    'title' => $title,
                    'id' => $id,
                ];
            }

            // tableau associatif contenant les marqueurs / values

            // exécution de la requête
            $lastInsertedId = prepareAndExecute($query, $data, true);

            // debug($lastInsertedId);
            header('Location:./categories.php');
        }
    }

    if (isset($_GET['action'], $_GET['id'])) {
        extract($_GET);
        $action=$_GET['action'];
        if ('update' === $action) {
            $query = 'SELECT * FROM category WHERE id=:id';
            $cat = prepareAndExecute($query, ['id' => $id])->fetch();
        }

        if ('delete' === $action) {
            $query = 'DELETE FROM category WHERE id = :id;';
            $data = [
                'id' => $id,
            ];
            prepareAndExecute($query, $data);
            header('Location:./categories.php');
        }

        // debug($cat);
    }

?>

<div class="container">
    <form action="" method="POST">
        <div class="mb-3">
            <label for="categoryTitle" class="form-label">Nom de la catégorie</label>
            <input type="text" class="form-control" name="title" id="categoryTitle" aria-describedby="categoryHelp"
                value="<?php echo $cat['title'] ?? ''; ?>">
            <div id="categoryHelp" class="form-text">Entrez le nom de la catégorie à ajouter</div>
        </div>

        <input type="hidden" name="action"
            value="<?php echo $action ?? ''; ?>">
        <input type="hidden" name="id"
            value="<?php echo $id ?? ''; ?>">


        <input type="submit" name="submit" class="btn btn-primary"
            value="<?php echo 'update' === $action ? 'Modifier' : 'Ajouter'; ?>">
    </form>
</div>

<?php
// test d'une requête en SELECT
    $results = prepareAndExecute('SELECT * FROM category')->fetchAll();

// debug($results);

?>


<div class="container mt-5">
    <h2>Liste des catégories</h2>
    <ul class="list-group">
        <?php
            foreach ($results as $category) {
                echo "
                <li class='list-group-item d-flex justify-content-between'>{$category['title']}
                    <div class='d-flex gap-3' role='group' aria-label='Liste des catégories'>
                        <a href='".BASE."categories.php?action=update&id={$category['id']}' class='btn btn-warning'>Modifier</a>
                        <a id='deleteBtn' href='".BASE."categories.php?action=delete&id={$category['id']}' class='btn btn-danger'>Supprimer</a>
                    </div>
                </li>
                ";
            }
?>
    </ul>
</div>

<?php
getPartial('footer');

?>