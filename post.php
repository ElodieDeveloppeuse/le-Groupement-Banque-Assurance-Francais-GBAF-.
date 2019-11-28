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
    <title>Document</title>
</head>
<body>
    <img src="<?= $image;?>"></br>
    <h2><?= $titre; ?><h2>
    <p><?=  $contenu; ?><p>
</body>
</html>