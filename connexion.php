<?php

require_once './utils/functions.php';

require_once './database/db.php';

require_once './utils/cart.php';
if (connect()){

    header('location:../');
    exit();

}


if (!empty($_POST)){

    $r=prepareAndExecute("SELECT * FROM user WHERE email=:email", array(':email'=>$_POST['email']));
    $user=$r->fetch(PDO::FETCH_ASSOC);  // requête pour récupérer un user par son email

    if (!$user){ // si il n'y a pas de retour, il y a alors erreur sur l'email
        $_SESSION['messages']['danger'][]='Aucun compte à cette adresse mail';
        header('location:./connexion.php');
        exit();

    }else{ // sinon , on a bien un user et on contrôle si le mot de passe est correct

        if (password_verify($_POST['password'], $user['password'])){ // password_verify permet de verifier la concordance entre un mot de passe en brut et un mot de passe crypté; il attend en paramètre, 1er le mot de passe brut, 2nd le mot de passe haché provenant de la BDD

            $_SESSION['user']=$user;
            $_SESSION['messages']['info'][]='Bienvenue '.$user['username'].' !!!';
            header('location:./');
            exit();

        }else{

            $_SESSION['messages']['danger'][]='Erreur sur le mot de passe';
            header('location:./connexion.php');
            exit();


        }



    }




}

$metadata = [
    'title' => 'Wanted - Connexion',
    'description' => 'Wanted - Votre site de fringues au top !',
];

getPartial('header', $metadata);

?>


<form method="post" action="">

    <section class="vh-100 bg-image" >
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Connexion</h2>

                                <label for="inputEmail">Email</label>
                                <input type="email" value="" name="email" id="inputEmail"
                                       class="form-control" autocomplete="email" required autofocus>
                                <label for="inputPassword" class="mt-3">Mot de passe</label>
                                <input type="password" name="password" id="inputPassword" class="form-control"
                                       autocomplete="current-password" required>


                                <button class="btn mb-2 mt-3 mb-md-0 btn-outline-secondary btn-block" type="submit">
                                    Se connecter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</form>







<?php getPartial('footer');  ?>


