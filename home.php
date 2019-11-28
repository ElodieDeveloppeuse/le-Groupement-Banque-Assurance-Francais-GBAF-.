<?php
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

</head>
<body>
    <h2>GBAF: Groupement Banque-Assurance Français</h2>
    <p> Le Groupement Banque Assurance Français (GBAF) est une fédération
représentant les 6 grands groupes français : BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Générale, La Banque Postale.</p>
    <img alt="" src="images/logo_gbaf.png">
    <div class="newpost">
    <?php
    while ($posts = $post->fetch()) 
{
?>
       <h3>
       <?php echo $posts['acteur'];?>
       </h3>
       <p><?php echo $posts['description'];?></p>
       <img src="<?php echo $posts['lien_img'];?>">
<?php
}
?>
    </div>


</body>
</html>