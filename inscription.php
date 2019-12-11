<?php
session_start();
    // Connexion à la base de donnée.
    $bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // var_dump($_POST['inscription']);die;
    // Vérification de l'envoie du formulaire. 
    if(isset($_POST['inscription']))
    {
    // Sécurisation des variables. 
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $pseudo = htmlspecialchars($_POST['pseudoconnect']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $questionList = htmlspecialchars($_POST['questionList']);
        $answers = htmlspecialchars($_POST['reponse']);
    // Sécurisation du mot de passe. sha1() plus sécurisé que MD5 qui devient obsolète de par les failles de sécurité.
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
    // Vérification des champs. 
  // var_dump($nom);var_dump($prenom);var_dump($pseudo);var_dump($mail);var_dump($mail2);var_dump($questionList);var_dump($answers);var_dump($mdp);var_dump($mdp2);die;
        if(!empty($prenom) &&  !empty($nom) &&!empty($pseudo) && !empty($mail) &&  !empty($mail2)&& !empty($questionList) && !empty($mdp) && !empty($mdp2)&&   !empty($answers))
        { 
    
    // Vérification du nombre de caractère autorisé. 
            $nomlenght = strlen($nom);
            $prenomlenght = strlen($prenom);
            $pseudolenght = strlen($pseudo);
            $answerslenght = strlen($answers);

    // Si le nombre de caractère composant le nom est inférieur ou égale à 255 caractères...
           if($nomlenght <= 255){
                if($prenomlenght <= 255){
                    if($mail == $mail2){
                        if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                        {
                            $reqmail = $bdd->prepare('SELECT * FROM membres WHERE mail = ?');
                            $reqmail->execute(array($mail));
                            if($mailexist == 0){
                                if($mdp == $mdp2){
                                    if(!empty($questionList) && !empty($answers))
                                    {
                                        $insertmember = $bdd->prepare("INSERT INTO membres (nom, prenom, mail, password, pseudo, question, reponse) VALUES (?, ?, ?, ?, ?, ?, ?)");
                                        $insertmember->execute(array($nom, $prenom, $mail, $mdp, $pseudo, $questionList, $answers));
                                        $_SESSION['id'] = $bdd->lastInsertId();
                                        $_SESSION['nouveaucompte'] = "Votre compte a bien été crée.";

                                        header("Location: profil.php?id=" .$_SESSION['id']); // Attention page de redirection pour le profil des nouveaux membres. 

                                    } else {
                                        $erreur = " Veuillez répondre à au moins une question secrète.";
                                    }
                                } else {
                                    $erreur = "Vos mot de passes ne correspondent pas.";
                                }
                            } else {
                                $erreur ="Adresse mail déjà utilisée.";
                            }
                        }
                    } else {
                        $erreur = "Vos adresses mails ne correspondent pas.";
                    }
                } else {
                    $erreur = "Votre prénom ne doit pas excéder 255 caractère.";
                }
           } else {
               $erreur = "Votre nom ne doit pas excéder 255 caratères.";
           }
        } else {
            $erreur = " Pas de connexion";
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
<body class="b-connexion">
<form method="POST" action="">
    <div class="os-content">
            <div class="container pt-5">
                        <div class="row">
                           <div class="col-lg-3 col-md-12"></div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body" id="inscriptionForm">
                                        <img class="img-fluid max-auto d-block pd-4 logo" src="./images/logo_gbaf.png" style="max-height: 150px">
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
                                                    <select class="form-control" name="questionList" value="<?php if(isset($questionList)) { echo $questionList; }?>">
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
                                            <input type="submit" name="inscription" class="btn btn-block btn-danger btn-lg float-right" value="Je m'inscris">                                            <br>
                                            <br>
                                            <div class="new-account">
                                                <a class="connexion" title="Me connecter" href="connexion.php"> Vous avez un compte? Connectez-vous...</a>
                                                
</div>
       
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<?php
        if(isset($erreur))
        {
            echo '<font color = "red">'. $erreur . "</font>";
        }
        ?>

</form>
</body>
</html>