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
        $questionList = htmlspecialchars($_POST['questionList']);
        $answers = htmlspecialchars($_POST['answers']);

    // Vérification des champs
        if(!empty($pseudoconnect) && !empty($questionList)&& !empty($answers))
        {
    // Vérification de l'existance du membre. 
            $reqmember = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ?  AND question = ? AND reponse = ?");
            $reqmember->execute(array($pseudoconnect, $questionList, $answers)); 
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
</head>
<body class="text-center">
<nav class="navbar navbar-light  fixed-top">
  <a class="navbar-brand" href="#">
    <img src="images/logo_gbaf.png" width="60" height="60" alt="">
    GBAF
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="inscription.php"> S'inscrire</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="connexion.php">Se connecter <span class="sr-only">(current)</span></a>
      </li>
    </div>
  </nav>
<div class="bloc_connexion">
     <form class="form-signin" method="POST" action="">
        <img class="img-fluid mx-auto center-block md-5" src="images/logo_gbaf.png" alt="" width="90" height="90">
        <h1 class="h3 mb-3 font-weigt-normal">Connexion</h1>
        <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" placeholder="Votre Pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; }?>"/>
                </div>
    <div class="col-sm-10">
    <label for="select">Question Secrète</label>
                        <select class="form-control" name="questionList">
                            <option>-Choississez-</option>
                            <option>Quel est le nom de votre père ?</option>
                            <option>Quel est le nom de votre ville de naissance ?</option>
                            <option>Quel est le nom de votre premier animal dosmestique ?</option>
                            <option>Quel est votre plat préféré ? </option>
                            <option>Quel est le nom de votre meilleur ami ?</option>
    </select>
    </div>
    <div class="col-sm-10">
    <label for="answers">Réponse Secrète</label>  
    <input class="form-control" type="text" placeholder="Saisir votre réponse secrète" id="answers" name="answers" value="<?php if(isset($answers)) { echo $answers; }?>"/>
    </div>
    <div class="col-sm-10">
      <button type="submit" name="inscription"  class="btn btn-primary"> Je m'inscris</button>
    </div>         
    </div>
</div>  
        </form>
        <?php
        if(isset($erreur))
        {
            echo '<font color = "red">'. $erreur . "</font>";
        }
        ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>