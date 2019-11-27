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
    <link href="connexion.css" rel="stylesheet">
</head>
<body class="text-center">
    <div>
        <h2>Connexion</h2>
        <br/> <br/>
        <form class="form-signin" method="POST" action="">
        <img class="mb-4" src="images/logo_gbaf.png" alt="" width="72" height="72">
        <table> 
            <tr> 
            <td align="right">
                <label for="pseudo">Pseudo:</label>
            </td>
            <td>
                <input type="text" placeholder="Votre Pseudo" id="pseudo" name="pseudoconnect" value="<?php if(isset($pseudo)) { echo $pseudo; }?>"/>
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