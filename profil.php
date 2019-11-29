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

    $post = $bdd->query('SELECT id, acteur, description, date_add, lien_img FROM articles ORDER BY date_add DESC LIMIT 0, 10');


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
<body>
    
    <div align="enter">
        <h2>Profil de <?php  echo $memberinfo['prenom'] ;?></h2>
        <br/> <br/>
        <p><?php  echo $memberinfo['mail'] ;?> </p>
        <?php 
            if(isset($_SESSION['id']) && $memberinfo['id'] == $_SESSION['id'])
            {
        ?>
            <a href="home.php"> Accueil</a>    
            <a href="profileditor.php"> Modifier mon profil</a>
            <a href="deconnexion.php"> Se déconnecter</a>
        <?php 
            }
        ?>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
<?php
}

?>