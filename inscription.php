<?php

require_once './utils/functions.php';

require_once './database/db.php';

require_once './utils/cart.php';

// fonction dans functions qui vérifie si on est déjà connecté, dans ce cas on redirige directement sur l'accueil (encore une fois pour les joueurs dans l'url)
if (connect()){
// optionnel:
// $_SESSION['messages']['info'][]='Tu es définitivement trop con de jouer avec l\'url, on t\'*** à sec';
    header('location:../');
    exit();

}


//
     if (!empty($_POST)){
         $error=0;
       // on fais une requete avec email en clause where pour vérifier si il y a déjà un utilisateur avec cet email
         $r=prepareAndExecute("SELECT * FROM user WHERE email=:email", array(':email'=>$_POST['email']));
         //$r est toujours un objet PDOStatement (pas de ->fetch()) on peut donc appeler la méthode rowCount() qui compte le nombre de résultats obtenu
         if ($r->rowCount() !==0){ // si il est différent de 0 alors l'utilisateur existe ou tente d'usuper une identité
             $error++;
             $email='Un compte existe existe déjà à cette adresse mail';

         }

         // filter_var() est une fonction de PHP qui peut vérifier pas mal de choses dont la validité des emails et renvoie un booléen. (c'est le second paramètre qui défini quel filtre on souhaite appliquer)
          if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
                $error++;
                $email='Champs invalide';

         }

          // nous avons un champs de confirmation de mot de passe, on s'assure qu'il concorde avec le champs de mot de passe
         if ($_POST['password'] !== $_POST['confirmPassword'] || empty($_POST['password'])  || empty($_POST['confirmPassword'])){
             $error++;
             $password='Champs invalide';

         }

         // on en reparlera à la rentrée, c'est pour vérifier la complexité des mots de passes grace à des regex...
//         if (!password_strength_check($_POST['password'])){
//             $error++;
//             $password='Le mot de passe doit contenir une majuscule, une minuscule, un caractère spécial, un caractère numérique et doit comporter un minimum de 6 caractères et un maximum de 10 caractères';
//
//         }

         if (empty($_POST['username'])){

             $error++;
             $username='Champs obligatoire';

         }


         // si pas d'erreur
         if ($error==0){

             // password_hash() => fonction de php qui attend en 1er argument le mot de passe en brut saisi dans le formulaire et par consequent récupérer dans $_POST, le 2nd argument est le type d'encryptage souhaité (default utilise l'algo bcrypt)
             $password=password_hash($_POST['password'], PASSWORD_DEFAULT); //

             prepareAndExecute("INSERT INTO user (username, email, password, role) VALUES (:username, :email, :password, :role)", array(
                  ':username'=>$_POST['username'],
                 ':email'=>$_POST['email'],
                  ':password'=>$password,
                 ':role'=>'ROLE_USER'


             ));

         }

         $_SESSION['messages']['info'][]='Félicitation, vous êtes inscrit, connectez vous à présent';
         header('location:./connexion.php');
         exit();







     }
$metadata = [
    'title' => 'Wanted - Inscription',
    'description' => 'Wanted - Votre site de fringues au top !',
];

getPartial('header', $metadata);

?>

<form method="post" action="">

    <section class="vh-100 " >
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Inscription</h2>

                                <label for="inputEmail">Email</label>
                                <input type="text" value="" name="email" id="inputEmail"
                                       class="form-control" autocomplete="email">
                                <small class="text-danger"><?=  $email ?? '' ; ?></small><br>
                                <label for="inputPassword" class="mt-3">Mot de passe</label>
                                <input type="password" name="password" id="inputPassword" class="form-control"
                                       autocomplete="current-password">
                                <small class="text-danger"><?=  $password ?? '' ; ?></small><br>
                                <label for="inputPassword1" class="mt-3">Confirmation de mot de passe</label>
                                <input type="password" name="confirmPassword" id="inputPassword1" class="form-control"
                                       autocomplete="current-password">
                                <small class="text-danger"><?=  $password ?? '' ; ?></small><br>
                                <label for="inputPassword2" class="mt-3">Pseudo</label>
                                <input type="text" name="username" id="inputPassword2" class="form-control"
                                       autocomplete="current-password">
                                <small class="text-danger"><?=  $username ?? '' ; ?></small><br>



                                <button class="btn mb-2 mt-3 mb-md-0 btn-outline-secondary btn-block" type="submit">
                                    Valider
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</form>







<?php getPartial('footer', $metadata);  ?>

