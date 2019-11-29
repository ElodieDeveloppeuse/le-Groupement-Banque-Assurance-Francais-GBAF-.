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
    <img src="images/logo_gbaf.png" width="50" height="50" alt="">
  </a>
  </nav>
<div class="bloc_connexion">
        <form class="form-signin" method="POST" action="">
        <div class="row">
        <img class="img-fluid mx-auto center-block md-5" src="images/logo_gbaf.png" alt="" width="90" height="90">
        <h1 class="h3 mb-3 font-weigt-normal">Connexion</h1>
        <table class=container> 
        <div class="col">
            <tr> 
            <td align="center">
                <label for="inputPseudo" class="sr-only">Pseudo</label>
            </td>
            </div>
            <td>
            <input type="text" placeholder="Votre Pseudo" id="inputPseudo" class="form-control" name="pseudoconnect" value="<?php if(isset($pseudo)) { echo $pseudo; }?>"/>
            </td>
            </tr>
            <tr>
                <td></td>
                <td align="right">
                    <div class="box">
                    <label for="select" >Question Secrète</label>
                        <select name="questionList" class="box-option">
                            <option>-Choississez-</option>
                            <option>Quel est le nom de votre père ?</option>
                            <option>Quel est le nom de votre ville de naissance ?</option>
                            <option>Quel est le nom de votre premier animal dosmestique ?</option>
                            <option>Quel est votre plat préféré ? </option>
                            <option>Quel est le nom de votre meilleur ami ?</option>
                        </select>
                    </div>
                </td>
             </tr>
             <tr>
                <td align="right">
                    <label for="answers">Réponse Secrète</label>
                </td>
                <td>
                    <input type="text" class="box-answers" placeholder="Saisir votre réponse secrète" id="answers" name="answers" value="<?php if(isset($answers)) { echo $answers; }?>"/>
                </td>
             </tr>
            <tr>
                <td></td>
                <td>
                <br/> 
                <input type="submit" name="connexion" class=" btn btn-lg btn-danger btn-block" value=" Se connecter"/><br/> 
                </td>
             </tr>
        </table> 
        </div>        
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