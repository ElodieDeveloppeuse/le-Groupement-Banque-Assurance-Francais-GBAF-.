<?php
    // Démarrage de la session
session_start(); 
    // Connexion à la base de donnée.
    $bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
    // Vérification de l'envoie du formulaire. 
    if(isset($_POST['connexion']))
    {
    // Sécurisation des variables
        $mailconnect = htmlspecialchars($_POST['mailconnect']);
    // Sécurisation du mot de passe. sha1() plus sécurisé que MD5 qui devient obsolète de par les failles de sécurité.
        $mdpconnect = sha1($_POST['mdpconnect']);
    // Vérification des champs
        if(!empty($mailconnect) AND !empty($mdpconnect))
        {
    // Vérification de l'existance du membre. 
            $reqmember = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND password = ?");
            $reqmember->execute(array($mailconnect, $mdpconnect)); 
            $memberexist = $reqmember->rowCount();
            if($memberexist == 1)
            {
                $memberinfo = $reqmember->fetch();
                $_SESSION['id'] = $memberinfo['id'];
                $_SESSION['nom'] = $memberinfo['nom'];
                $_SESSION['prenom'] = $memberinfo['prenom'];
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
</head>
<body>
    <div align="center">
        <h2>Connexion</h2>
        <br/> <br/>
        <form method="POST" action="">
        <table> 
            <tr> 
            <td align="right">
                <label for="mail">Email:</label>
            </td>
            <td>
                <input type="email" placeholder="Votre Email" id="mail" name="mailconnect" value="<?php if(isset($mail)) { echo $mail; }?>"/>
            </td>
            </tr>
            <tr>
            <td align="right">
                <label for="mdp">Mot de passe</label>
            </td>
            <td>
                <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdpconnect"/>
            </td>
            </tr>
            <tr>
                <td></td>
                <td>
                <br/> 
                    <input type="submit" name="connexion" value=" Se connecter"/>
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