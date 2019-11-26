<?php
    // Connexion à la base de donnée.
    $bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');

    // Vérification de l'envoie du formulaire. 
    if(isset($_POST['inscription']))
    {
    // Sécurisation des variables. 
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
    // Sécurisation du mot de passe. sha1() plus sécurisé que MD5 qui devient obsolète de par les failles de sécurité.
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
    // Vérification des champs. 
        if(!empty($_POST['nom'])AND !empty($_POST['prenom'])AND !empty($_POST['mail'])AND !empty($_POST['mail2'])AND !empty($_POST['mdp'])AND !empty($_POST['mdp2']))
        {
    
    // Vérification du nombre de caractère autorisé. 
            $nomlenght = strlen($nom);
            $prenomlenght = strlen($prenom);
    // Si le nombre de caractère composant le nom est inférieur ou égale à 255 caractères...
            if($nomlenght <= 255)
            {
                if($prenomlenght <= 255)
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
                                    // Si tout est ok : Ajouter le nouveau membre.
                                    $insertmember = $bdd->prepare("INSERT INTO membres (nom, prenom, mail, password) VALUES (?, ?, ?, ?)");
                                    $insertmember->execute(array($nom, $prenom, $mail, $mdp));
                                    $_SESSION['nouveaucompte'] = "Votre compte a bien été crée.";
                                    header('Location: '); // Attention page de redirection pour le profil des nouveaux membres. 
                                }
                                else
                                {
                                    $erreur = "Vos mot de passes ne correspondent pas";
                                }
                            }
                            else 
                            {
                                $erreur = "Adresse mail déjà utilisé.";
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
                else
                {
                    $erreur = "Votre prénom ne doit pas excéder 255 caractéres."; 
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
</head>
<body>
    <div align="center">
        <h2>Inscription</h2>
        <br/> <br/>
        <form method="POST" action="">
            <table>
             <tr>
                <td align="right">
                    <label for="nom">Nom:</label>
                </td>
                <td>
                    <input type="text" placeholder="Votre Nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; }?>"/>
                </td>
             </tr>
             <tr>
                <td align="right">
                    <label for="prenom">Prénom:</label>
                </td>
                <td>
                    <input type="text" placeholder="Votre Prénom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; }?>"/>
                </td>
             </tr>
             <tr>
                <td align="right">
                    <label for="mail">Email:</label>
                </td>
                <td>
                    <input type="email" placeholder="Votre Email" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; }?>"/>
                </td>
             </tr>
             <tr>
                <td align="right">
                    <label for="mail2">Confirmation</label>
                </td>
                <td>
                    <input type="email" placeholder="Saisir à nouveau" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; }?>"/>
                </td>
             </tr>
             <tr>
                <td align="right">
                    <label for="mdp">Mot de passe</label>
                </td>
                <td>
                    <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"/>
                </td>
             </tr>
             <tr>
                <td align="right">
                    <label for="mdp2">Confirmation</label>
                </td>
                <td>
                    <input type="password" placeholder="Saisir à nouveau" id="mdp2" name="mdp2"/>
                </td>
             </tr>
             <tr>
                <td></td>
                <td>
                <br/> 
                    <input type="submit" name="inscription" value=" Je m'inscris"/>
                </td>
             </tr>
            </table>
        </form>
        <?php
        if(isset($erreur))
        {
            echo '<font color = "red">'. $erreur . "</font>";
        }
        ?>
    </div>
</body>
</html>