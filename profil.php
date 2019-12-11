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
<body class="b-connexion">
<header>
    <div class="os-content bg-light">
    <img class="img-fluid" src="./images/logo_gbaf.png" style="max-height: 45px">  
        <nav class="navbar navbar-expand-lg  ">
            <a class="navbar-brand navbar-mobile" href="profil.php">  
                       
                        <?php echo $_SESSION['prenom'] . " " .$_SESSION['nom']?>
                        <a href="profileditor.php"> Modifier mon profil</a>
                        <a href="deconnexion.php"> Se déconnecter</a>
        </nav>
            <?php 
            if(isset($_SESSION['id']) && $memberinfo['id'] == $_SESSION['id'])
            {
            ?>
            <?php 
            }
            ?>

</header>
<section>
<div class="gbaf-presentation">
    <h2>GBAF: Groupement Banque-Assurance Français</h2>
    <p id="gbaf-description"> Le Groupement Banque Assurance Français (GBAF) est une fédération
représentant les 6 grands groupes français : BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Générale, La Banque Postale.</p>
    <img alt="" src="images/logo_gbaf.png">
</div>
    <div class="newpost">
    <h2 class="title_section">Acteurs et Partenaires</h2>
    <?php
    while ($posts = $post->fetch()) 
{
?>

<div class="card mb-3" style="max-width: 75%;">
<div class="col-lg-3 col-md-12"></div>
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="<?php echo $posts['lien_img'];?>" class="card-img" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h3 class="card-title"><?php echo $posts['acteur'];?></h3>
        <p class="card-text"><?php echo $posts['description'];?></p>
        <a href="post.php?id=<?php  echo $posts['id']?>" class="btn btn-danger reading" title="<?php echo $posts['acteur'];?>">Lire la suite</a>
      </div>
    </div>
  </div>
</div>
</div>
    </div>
  <div class="col-lg-3 col-md-12"></div>
</div>
<?php
}
?>
</section>

        
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
<?php
}
?>