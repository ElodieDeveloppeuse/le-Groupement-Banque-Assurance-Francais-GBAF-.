<?php
session_start();
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$post = $bdd->query('SELECT id, acteur, description, date_add, lien_img FROM articles ORDER BY date_add DESC LIMIT 0, 10');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GBAF</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    

</head>
<body>
<nav class="navbar navbar-light ">
  <a class="navbar-brand" href="#">
    <img src="images/logo_gbaf.png" width="50" height="50" alt="">
  </a>
  <a href="phofil.php"><?php echo $_SESSION['prenom'] . " " .$_SESSION['nom']?></a>

</nav>
<div class="gbaf-presentation">
    <h2>GBAF: Groupement Banque-Assurance Français</h2>
    <p id="gbaf-description"> Le Groupement Banque Assurance Français (GBAF) est une fédération
représentant les 6 grands groupes français : BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Générale, La Banque Postale.</p>
    <img alt="" src="images/logo_gbaf.png">
</div>
    <div class="newpost">
    <?php
    while ($posts = $post->fetch()) 
{
?>
<h2 class="title section">Acteurs et Partenaires</h2>
<div class="card mb" style="max-width: 100%;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="<?php echo $posts['lien_img'];?>" class="card-img" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h3 class="card-title"><?php echo $posts['acteur'];?></h3>
        <p class="card-text"><?php echo $posts['description'];?></p>
        <a href="post.php?id=<?php  echo $posts['id']?>" class="btn btn-danger btn-flex" title="<?php echo $posts['acteur'];?>">Lire la suite</a>
      </div>
    </div>
  </div>
</div>
<?php
}
?>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>