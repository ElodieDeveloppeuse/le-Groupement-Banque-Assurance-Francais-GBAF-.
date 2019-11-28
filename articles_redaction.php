<?php
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');

if(isset($_POST['name_partenaire'], $_POST['description']))
{
    if(!empty($_POST['name_partenaire']) AND !empty($_POST['description']))
    {
        $name_partenaire = htmlspecialchars($_POST['name_partenaire']);
        $description = htmlspecialchars($_POST['description']);
        $logo_img = htmlspecialchars($_POST['logo_img']);

        $insertarticle = $bdd->prepare('INSERT INTO articles (name_partenaire, description, date_time_publication, logo_img) VALUES (?, ?, NOW()), ?');
        $insertarticle->exectute(array($name_partenaire, $description, ));
    } else {
        $erreur = "Veuillez remplir tous les champs";
    }
}

if(isset($_FILES['logo_img']) && !empty ($_FILES['logo_img']['name']))
{
    $tailleMax =  3000000;
    $formatValides = array('jpg', 'jpeg', 'png');
    if($_FILES['logo_img']['size'] <= $tailleMax)
    {
        $extension_loaded =  ;
    }
    else
    {
        $erreur = "Votre image est trop lourde.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Publier un article</title>
</head>
<body>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="text"  name="name_partenaire" placeholder=" Nom du Partenaire"><br/>
        <input type="textarea"  name="description" placeholder=" Description du partenaire"><br/> 
        <input type="files"  name="logo_img"><br/> 
        <input type="submit"  name="publish" value=" Mettre en ligne "><br/> 
    </form>
    <br/> 
    <?php
    if(isset($erreur))
        {
            echo '<font color = "red">'. $erreur . "</font>";
        }
    ?>
</body>
</html>
