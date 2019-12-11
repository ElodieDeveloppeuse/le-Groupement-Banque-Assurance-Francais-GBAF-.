<?php
session_start();
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_SESSION['id']) && !empty($_SESSION['id']))
{
   
    $reqmember = $bdd->prepare("SELECT * FROM membres WHERE id = ? ");
    $reqmember->execute(array($_SESSION['id'])); 
    $memberinfo = $reqmember->fetch();

    $post = $bdd->query('SELECT id, acteur, description, date_add, lien_img FROM articles ORDER BY date_add DESC LIMIT 0, 10');


if(isset($_GET['id']) && !empty($_GET['id']))
{
    $id = htmlspecialchars($_GET['id']);
    $post = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $post->execute(array($id));

    if($post->rowCount() == 1 ){
        $post = $post->fetch(); 
        $titre = $post['acteur'];
        $contenu = $post['description'];
        $image = $post ['lien_img'];

        $likes = $bdd->prepare('SELECT id FROM likes WHERE id_article = ?');
        $likes->execute(array($id));
        $likes = $likes->rowCount();

        $dislikes = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ?');
        $dislikes->execute(array($id));
        $dislikes = $dislikes->rowCount();


        if(isset($_POST['submit_commentaire'])) {
            if(isset($_POST['auteur'], $_POST['commentaire']) && !empty($_POST['auteur']) && !empty($_POST['commentaire']))
            {
                $auteur = htmlspecialchars($_POST['auteur']);
                $commentaire = htmlspecialchars($_POST['commentaire']);
                

                if(strlen($auteur) < 255) {
                    $newcom = $bdd->prepare('INSERT INTO commentaires (id_article, auteur, commentaire, date_commentaire) VALUES (?, ?, ?, NOW())') ;
                    $newcom->execute(array($id, $auteur, $commentaire));
                    $erreur = "<span style ='color:green'> Votre commentaire a bien été pris en compte.";
                } else {
                    $erreur = "Erreur :Votre prénom ne doit pas excéder 255 caractères.</span>"; 
                }
            } else {
                $erreur = "Erreur :Tous les champs doivent être compléter.";
            }
        }

    } else {
        die(" Cet article n'existe pas.");
    }
}
else 
{
    header('Location: home.php');
}

$commentaires = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ? ORDER BY id DESC');
$commentaires->execute(array($id));
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GBAF</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">  
</head>
<body>
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
<article>

<div class="card">
  <div class="card-body">
  <img src="<?= $image;?>"></br>
    <h2><?= $titre; ?></h2>
    <p><?=  $contenu; ?></p>  </div>
</div>
</article>
<div class="vote">
    <div class="vote_btns">
    <a href="action.php?t=1&id=<?= $id; ?>">J'aime</a> (<?= $likes; ?>)
    <a href="action.php?t=2&id=<?= $id; ?>">Je n'aime pas</a>(<?= $dislikes; ?>)
    </div>
</div>
    
    </br></br>
<div class="card">
<div class="card-body">
        
<?php while ($commentaire = $commentaires->fetch()){?>
<b><?= $commentaire['auteur']; ?>: <?= $commentaire['commentaire']; ?>  <?= $commentaire['date_commentaire']; ?></b></br>

<?php
}
?>
  </div>
</div>
<form class="commentaire" method="POST" action="">
<div class="card mb-3" style="max-width: 75%;">
<div class="col-lg-3 col-md-12"></div>
  <div class="row no-gutters"> 
    <div class="col-md-8">
      <div class="card-body">
      <div class="card-title-header">
      <h3 class="card-title"><h4>Commentaires : </h4>
      
      </div> 
      <div class="card-text">
        <div class="form-group">
            <input type="text" class="form-control" name="auteur" placeholder="Votre prénom"/></br>
        </div> 
        <div class="form-group">
            <textarea name="commentaire" class="form-control" placeholder="Votre commentaire..."></textarea></br>
        </div> 
        <div class="form-group">
        <button type="submit" class="btn btn-danger" value="Commenter" name="submit_commentaire">Commenter</button></br>    
        </div>  
        </div>
    </div>
    </div>
  </div>
</div>
</div>
    
    
    
   
   
    
   
<?php if(isset($erreur)) { echo '<font color = "red">  '. $erreur . "</font>";} ?>
</br>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
?>