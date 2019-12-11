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
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $questionList = htmlspecialchars($_POST['question']);
        $answers = htmlspecialchars($_POST['reponse']);
    // Vérification des champs
        if(!empty($pseudo) && !empty($questionList)  && !empty($answers))
        {
    // Vérification de l'existance du membre. 
            $reqmember = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ? AND question = ?  AND reponse = ?");
            $reqmember->execute(array($pseudo, $questionList, $answers)); 
            $memberexist = $reqmember->rowCount();
            if($memberexist == 1)
            {
                $memberinfo = $reqmember->fetch();
                $_SESSION['id'] = $memberinfo['id'];
                $_SESSION['nom'] = $memberinfo['nom'];
                $_SESSION['prenom'] = $memberinfo['prenom'];
                $_SESSION['pseudo'] = $memberinfo['pseudo'];
            
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
<form method="POST" action="">
    <div class="os-content">
            <div class="container pt-5">
                        <div class="row">
                            <div class="col-lg-3 col-md-12"></div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body" id="connexionForm">
                                        <img class="img-fluid max-auto d-block pd-4 logo" src="./images/logo_gbaf.png" style="max-height: 150px">
                                            <div class="form-group">
                                            <input type="text" placeholder="Votre Pseudo" id="inputPseudo" class="form-control" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="select">Question Secrète</label>
                                                    <select class="form-control" name="question" value="<?php if(isset($questionList)) { echo $questionList; }?>">
                                                        <option>-Choississez-</option>
                                                        <option>Quel est le nom de votre père ?</option>
                                                        <option>Quel est le nom de votre ville de naissance ?</option>
                                                        <option>Quel est le nom de votre premier animal dosmestique ?</option>
                                                        <option>Quel est votre plat préféré ? </option>
                                                        <option>Quel est le nom de votre meilleur ami ?</option>
                                                </select>                                            
                                            </div>
                                            <div class="form-group">
                                                <label for="answers">Réponse Secrète</label>  
                                                    <input class="form-control" type="text" placeholder="Saisir votre réponse secrète" id="answers" name="reponse" value="<?php if(isset($answers)) { echo $answers; }?>"/>                                            
                                            </div>
                                            <input type="submit" name="connexion" class="btn btn-block btn-danger btn-lg float-right" value="Se connecter"><br>
                                            <br>
                                            <div class="new-account">
                                                <a class="inscription" title="créer un compte" href="inscription.php"> Pas encore de compte ? Créez-en un...</a>
                                            </div>
                                            <div class="identification">
                                                <a class="connexion_bis" title="s'identifier autrement" href="connexion.php"> S'identifier autrement...</a>
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

        </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</form>
</body>
</html>