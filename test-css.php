<?php
    // Démarrage de la session
session_start(); 
    // Connexion à la base de donnée.
    $bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Vérification de l'envoie du formulaire. 
    if(isset($_POST['connexion']))
    {
    // Sécurisation des variables
        $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']);
    // Sécurisation du mot de passe. sha1() plus sécurisé que MD5 qui devient obsolète de par les failles de sécurité.
        $mdpconnect = sha1($_POST['mdpconnect']);
    // Vérification des champs
        if(!empty($pseudoconnect) && !empty($mdpconnect))
        {
    // Vérification de l'existance du membre. 
            $reqmember = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ? AND password = ?");
            $reqmember->execute(array($pseudoconnect, $mdpconnect)); 
            $memberexist = $reqmember->rowCount();
            if($memberexist == 1)
            {
                $memberinfo = $reqmember->fetch();
                $_SESSION['id'] = $memberinfo['id'];
                $_SESSION['nom'] = $memberinfo['nom'];
                $_SESSION['prenom'] = $memberinfo['prenom'];
                $_SESSION['pseudo'] = $memberinfo['pseudo'];
                $_SESSION['mail'] = $memberinfo['mail'];
                header("Location: profil.php?id=" .$_SESSION['id']);
            }
            else
            {
                $erreur = "Identifiants incorrects";
            }
        }
        else
        {
            $erreur = "Tous les champs doivent être remplis."; 
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GBAF</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">  
    

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
</head>
<body class="b-connexion">
    <div class="os-content">
            <div class="container pt-5">
                        <div class="row">
                            <div class="col-lg-3 col-md-12"></div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body" id="inscriptionForm">
                                        <img class="img-fluid max-auto d-block pd-4" src="./images/logo_gbaf.png" style="max-height: 150px">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Votre Prénom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Votre Nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" placeholder="Votre Pseudo" id="inputPseudo" class="form-control"name="pseudoconnect" value="<?php if(isset($pseudo)) { echo $pseudo; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="email" placeholder="Votre Email" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="email" placeholder="Saisir à nouveau" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" placeholder="Saisir à nouveau" id="mdp2" name="mdp2"/>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="update-account">
                                                <a href="profil.php" class="btn btn-block btn-danger btn-lg float-right" role="button" aria-pressed="true">Mettre à jour</a><br><br>                                         <br>
                                                <a href="profil.php" class="btn btn-block btn-danger btn-lg float-right" role="button" aria-pressed="true">Annuler</a><br>
                                            </div>
                    <?php
                    if(isset($erreur))
                    {
                    echo '<font color = "red">'. $erreur . "</font>";
                    }
                    ?>  
                                            
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            <div class="col-lg-3 col-md-12"></div>
        </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>