<?php
session_start();
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if(isset($_GET['id']) && !empty($_GET['id']))
{
    $get_id = htmlspecialchars($_GET['id']);
    $post = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $post->execute(array($get_id));

    if($post->rowCount() == 1 ){
        $post = $post->fetch(); 
        $titre = $post['acteur'];
        $contenu = $post['description'];
        $image = $post ['lien_img'];

        $commentaires = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ?');
        $commentaires->execute(array($get_id));

        if(isset($_POST['submit_commentaire'])) {
            if(isset($_POST['auteur'], $_POST['commentaire']) && !empty($_POST['auteur']) && !empty($_POST['commentaire']))
            {
                $auteur = htmlspecialchars($_POST['auteur']);
                $commentaire = htmlspecialchars($_POST['commentaire']);

                if(strlen($auteur) < 255) {
                    $newcom = $bdd->prepare('INSERT INTO commentaires (id_article, auteur, commentaire) VALUES (?, ?, ?)') ;
                    $newcom->execute(array($get_id, $auteur, $commentaire));
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
    <title><?= $titre; ?></title>
</head>
<body>
<articles>
    <img src="<?= $image;?>"></br>
    <h2><?= $titre; ?><h2>
    <p><?=  $contenu; ?><p>
</articles>
<div class="vote">
    <div class="vote_btns">
        <div class="vote_btns vote_like">12</div>
        <div class="vote_btns vote_dislike">20</div>
    </div>
</div>
    <a href="action.php?t=1&id=<?= $get_id; ?>">J'aime</a>
    <a href="action.php?t=2&id=<?= $get_id; ?>">Je n'aime pas</a>
    </br></br>
    <h4>Commentaires : </h4>
<?php while ($commentaire = $commentaires->fetch()){?>
<b><?= $commentaire['auteur']; ?>: <?= $commentaire['commentaire']; ?></b></br>

<?php
}
?>
    
    <form method="POST" action="">
    <input type="text" name="auteur" placeholder="Votre prénom"/></br>
    <textarea name="commentaire" placeholder="Votre commentaire..."></textarea></br>
    <input type="submit" value="Commenter" name="submit_commentaire"/></br>
   
<?php if(isset($erreur)) { echo '<font color = "red">  '. $erreur . "</font>";} ?>
</br>
</body>
</html>