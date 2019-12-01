<?php
session_start();
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


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

        $commentaires = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ?');
        $commentaires->execute(array($id));

        if(isset($_POST['submit_commentaire'])) {
            if(isset($_POST['auteur'], $_POST['commentaire']) && !empty($_POST['auteur']) && !empty($_POST['commentaire']))
            {
                $auteur = htmlspecialchars($_POST['auteur']);
                $commentaire = htmlspecialchars($_POST['commentaire']);

                if(strlen($auteur) < 255) {
                    $newcom = $bdd->prepare('INSERT INTO commentaires (id_article, auteur, commentaire) VALUES (?, ?, ?)') ;
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
<nav class="navbar navbar-light ">
  <a class="navbar-brand" href="home.php">
    <img src="images/logo_gbaf.png" width="50" height="50" alt="">
  </a>
  <a href="phofil.php"><?php echo $_SESSION['prenom'] . " " .$_SESSION['nom']?></a>

</nav>
<articles>
    <img src="<?= $image;?>"></br>
    <h2><?= $titre; ?></h2>
    <p><?=  $contenu; ?></p>
</articles>
<div class="vote">
    <div class="vote_btns">
    <a href="action.php?t=1&id=<?= $id; ?>">J'aime</a> (<?= $likes; ?>)
    <a href="action.php?t=2&id=<?= $id; ?>">Je n'aime pas</a>(<?= $dislikes; ?>)
    </div>
</div>
    
    </br></br>


    
<?php while ($commentaire = $commentaires->fetch()){?>
<b><?= $commentaire['auteur']; ?>: <?= $commentaire['commentaire']; ?></b></br>

<?php
}
?>
    
    <form class="commentaire" method="POST" action="">
    <h4>Commentaires : </h4>
    <div class="form-group">
    <input type="text" class="form-control" name="auteur" placeholder="Votre prénom"/></br>
    </div>
    <div class="form-group">
    <textarea name="commentaire" class="form-control" placeholder="Votre commentaire..."></textarea></br>
    </div>
    <button type="submit" class="btn btn-danger" value="Commenter" name="submit_commentaire">Commenter</button></br>
   
<?php if(isset($erreur)) { echo '<font color = "red">  '. $erreur . "</font>";} ?>
</br>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>