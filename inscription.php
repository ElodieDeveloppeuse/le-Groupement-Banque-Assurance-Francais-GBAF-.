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

        $questionList=htmlspecialchars($_POST['question']);
        $answers=htmlspecialchars($_POST['answers']);
    // Sécurisation du mot de passe. sha1() plus sécurisé que MD5 qui devient obsolète de par les failles de sécurité.
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
    // Vérification des champs. 
        if(!empty($_POST['nom'])AND !empty($_POST['prenom'])AND !empty($_POST['pseudo'])AND !empty($_POST['mail'])AND !empty($_POST['mail2'])AND !empty($_POST['mdp'])AND !empty($_POST['mdp2']) AND !empty($_POST['question'] AND !empty($_POST['answers'])))
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
                                            <div class="form-group">
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
                                            <div class="form-group">
                                                <label for="answers">Réponse Secrète</label>  
                                                    <input class="form-control" type="text" placeholder="Saisir votre réponse secrète" id="answers" name="answers" value="<?php if(isset($answers)) { echo $answers; }?>"/>                                            
                                            </div>
                                            <a href="profil.php" class="btn btn-block btn-danger btn-lg float-right" role="button" aria-pressed="true">S'inscrire</a>                                            <br>
                                            <br>
                                            <br>
                                            <div class="new-account">
                                                <a class="connexion" title="Me connecter" href="connexion.php"> Vous avez un compte? Connectez-vous...</a>
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