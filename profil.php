<?php
session_start();
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
// Retourner les informations du membre. 
if(isset($_SESSION['id']) && !empty($_SESSION['id']))
{
   
    $reqmember = $bdd->prepare("SELECT * FROM membres WHERE id = ? ");
    $reqmember->execute(array($_SESSION['id'])); 
    $memberinfo = $reqmember->fetch();

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
        <h2>Profil de <?php  echo $memberinfo['prenom'] ;?></h2>
        <br/> <br/>
        <p><?php  echo $memberinfo['mail'] ;?> </p>
        <?php 
            if(isset($_SESSION['id']) && $memberinfo['id'] == $_SESSION['id'])
            {
        ?>
            <a href="profileditor.php"> Modifier mon profil</a>
            <a href="deconnexion.php"> Se déconnecter</a>
        <?php 
            }
        ?>
    </div>
</body>
</html>
<?php
}

?>