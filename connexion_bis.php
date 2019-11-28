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
                <td></td>
                <td align="right">
                    <div class="box">
                    <label for="select">Question Secrète</label>
                        <select name="questionList">
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
                    <input type="text" placeholder="Saisir votre réponse secrète" id="answers" name="answers" value="<?php if(isset($answers)) { echo $answers; }?>"/>
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