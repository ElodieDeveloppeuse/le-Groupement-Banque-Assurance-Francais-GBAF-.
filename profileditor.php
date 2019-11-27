<?php
session_start();
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
// Retourner les informations du membre. 
if(isset($_SESSION['id']))
{
    $reqmember = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $reqmember->execute(array($_SESSION['id'])); 
    $member = $reqmember->fetch();

    if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $member['nom'])
    {
        $newnom = htmlspecialchars($_POST['newnom']);
        $insertnom = $bdd->prepare("UPDATE membres SET nom = ? WHERE ID = ? ");
        $insertnom->execute(array($newnom, $_SESSION['id']));
        header("Location: profil.php?id=" .$_SESSION['id']);
    }

    if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $member['prenom'])
    {
        $newprenom = htmlspecialchars($_POST['newprenom']);
        $insertprenom = $bdd->prepare("UPDATE membres SET prenom = ? WHERE ID = ? ");
        $insertprenom->execute(array($newprenom, $_SESSION['id']));
        header("Location: profil.php?id=" .$_SESSION['id']);
    }
    if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $member['mail'])
    {
        $newmail= htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE ID = ? ");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header("Location: profil.php?id=" .$_SESSION['id']);
    }
    if(isset($_POST['newmdp']) AND !empty($_POST['newmdp']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])  )
    {
        $mdp = sha1($_POST['newmdp']);
        $mdp2 = sha1($_POST['newmdp2']);

        if($mdp == $mdp2)
        {
            $insertmdp = $bdd->prepare("UPDATE membres SET password = ? WHERE ID = ? ");
            $insertmdp->execute(array($mdp, $_SESSION['id']));
            header("Location: profil.php?id=" .$_SESSION['id']);
        }
        else 
        {
            $erreur = "Les mot de passes ne correspondent pas.";
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
    <div align="enter">
    <table>
        <h2>Modifier de mon profil</h2>
        <form method="POST" action="">
        <tr>
            <td align="right">
                <label for="nom">Nom:</label>
            </td>
            <td>
                <input type="text" placeholder="Votre Nom" id="nom" name="newnom" value="<?php echo $member['nom'];?>"/>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="prenom">Prénom:</label>
            </td>
            <td>
                <input type="text" placeholder="Votre Prénom" id="prenom" name="newprenom" value="<?php echo $member['prenom']; ?>"/>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="mail">Mail:</label>
            </td>
            <td>
                <input type="mail" placeholder="Votre adresse mail" id="mail" name="newmail" value="<?php  echo $member['mail']; ?>"/>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="mdp">Mot de passe</label>
            </td>
            <td>
                <input type="password" placeholder="Votre mot de passe" id="mdp" name="newmdp">
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="mdp2"></label>
            </td>
            <td>
                <input type="password" placeholder="Saisir à nouveau" id="mdp2" name="newmdp2"/>
            </td>
        </tr>
        <tr>
                <td></td>
                <td>
                <br/> 
                    <input type="submit" name="updade" value=" Mettre à jour"/>
                </td>
             </tr>
        </form>
    </table>
    </div>
    <?php
        if(isset($erreur))
        {
            echo '<font color = "red">'. $erreur . "</font>";
        }
        ?>
</body>
</html>
<?php
}
else
{
    header("Location: connexion.php");
}
?>