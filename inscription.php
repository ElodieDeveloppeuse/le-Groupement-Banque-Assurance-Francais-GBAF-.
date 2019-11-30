<?php
session_start();
    // Connexion à la base de donnée.
    $bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Vérification de l'envoie du formulaire. 
    if(isset($_POST['inscription']))
    {
    // Sécurisation des variables. 
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $questionList = htmlspecialchars($_POST['questionList']);
        $answers = htmlspecialchars($_POST['answers']);
    // Sécurisation du mot de passe. sha1() plus sécurisé que MD5 qui devient obsolète de par les failles de sécurité.
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
    // Vérification des champs. 
        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['pseudo']) && !empty($_POST['mail']) &&  !empty($_POST['mail2']) && !empty($_POST['mdp']) &&  !empty($_POST['mdp2']) && !empty($_POST['questionList']) && !empty($_POST['answers']))
        {
    
    // Vérification du nombre de caractère autorisé. 
            $nomlenght = strlen($nom);
            $prenomlenght = strlen($prenom);
            $pseudolenght = strlen($pseudo);
            $answerslenght = strlen($answers);

    // Si le nombre de caractère composant le nom est inférieur ou égale à 255 caractères...
            if($nomlenght <= 255)
            {
                if($prenomlenght <= 255)
                {
                    if($pseudolenght<= 255)
                    {
                    
                    if($mail == $mail2)
                    {
                        if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                        {
                            // Vérifier que l'adresse mail n'existe pas déjà dans la base de donnée. 
                            $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                            $reqmail->execute(array($mail));
                            $mailexist = $reqmail->rowCount();
                            // Si l'email n'existe pas alors on continue
                            if($mailexist == 0)
                            {
                                if($mdp == $mdp2)
                                {
                                    if(!empty($questionList) && !empty($answers))
                                    {
                                        // Si tout est ok : Ajouter le nouveau membre.
                                        $insertmember = $bdd->prepare("INSERT INTO membres (nom, prenom, mail, password, pseudo, question, reponse) VALUES (?, ?, ?, ?, ?, ?, ?)");
                                        $insertmember->execute(array($nom, $prenom, $mail, $mdp, $pseudo, $questionList, $answers));
                                        $_SESSION['id'] = $bdd->lastInsertId();
                                        $_SESSION['nouveaucompte'] = "Votre compte a bien été crée.";
                                        
                                    header("Location: profil.php?id=" .$_SESSION['id']); // Attention page de redirection pour le profil des nouveaux membres. 
                                    } 
                                    else {
                                        $erreur = "Veuillez choisir une question secrète";
                                    }
                                }
                                else
                                {
                                    $erreur = "Vos mot de passes ne correspondent pas";
                                }
                                 
                            }
                            else 
                            {
                                $erreur = "Adresse mail déjà utilisée.";
                            }
                        } 
                      else
                      {
                          $erreur = "Votre adresse mail n'est pas valide";
                        
                      }
                    } 
                    else
                    {
                        $erreur = "Vos adresses mail ne correspondent pas !";
                    }

                   } 
                   else {
                       $erreur = "Votre pseudo n'est pas valide.";
                   }
                }
                else
                {
                    $erreur = "Votre prénom ne doit pas excéder 255 caractères."; 
                }
            }
            else 
            {
                $erreur = "Votre nom ne doit pas excéder 255 caractères.";
            }  
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">  </head>
<body>
<nav class="navbar navbar-light  fixed-top">
  <a class="navbar-brand" href="#">
    <img src="images/logo_gbaf.png" width="50" height="50" alt="">
  </a>
  </nav>
    <form class="form-signup" method="POST" action="">
    <img class="img-fluid mx-auto center-block md-5" src="images/logo_gbaf.png" alt="" width="90" height="90">
    <h1 class="h3 mb-3 font-weigt-normal">Inscription</h1>
  <div class="form-group row">
  <td align="center">
    <div class="col-sm-10" >
        <input class="form-control" type="text" placeholder="Votre Prénom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; }?>"/>
    </div>
    <div class="col-sm-10">
        <input class="form-control" type="text" placeholder="Votre Nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; }?>"/>
    </div>
    <div class="col-sm-10">
        <input class="form-control" type="text" placeholder="Votre Pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; }?>"/>
    </div>
    <div class="col-sm-10">
        <input class="form-control" type="email" placeholder="Votre Email" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; }?>"/>
    </div>
    <div class="col-sm-10">
        <input class="form-control" type="email" placeholder="Saisir à nouveau" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; }?>"/>
    </div>
    <div class="col-sm-10">
        <input class="form-control" type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"/>
    </div>
    <div class="col-sm-10">
        <input class="form-control" type="password" placeholder="Saisir à nouveau" id="mdp2" name="mdp2"/>
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
    <div class="col">
      <button type="submit" name="inscription"  class="btn btn-primary"> Je m'inscris</button>
    </div>
  </div>
</td>
</form>        
        <?php
        if(isset($erreur))
        {
            echo '<font color = "red">'. $erreur . "</font>";
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>