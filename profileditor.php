<?php
session_start();
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
// Retourner les informations du membre. 
if(isset($_SESSION['id']))
{
    $reqmember = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $reqmember->execute(array($_SESSION['id'])); 
    $member = $reqmember->fetch();

    if(isset($_POST['newnom']) && !empty($_POST['newnom']) && $_POST['newnom'] != $member['nom'])
    {
        $newnom = htmlspecialchars($_POST['newnom']);
        $insertnom = $bdd->prepare("UPDATE membres SET nom = ? WHERE ID = ? ");
        $insertnom->execute(array($newnom, $_SESSION['id']));
        header("Location: profil.php?id=" .$_SESSION['id']);
    }

    if(isset($_POST['newprenom']) && !empty($_POST['newprenom']) && $_POST['newprenom'] != $member['prenom'])
    {
        $newprenom = htmlspecialchars($_POST['newprenom']);
        $insertprenom = $bdd->prepare("UPDATE membres SET prenom = ? WHERE ID = ? ");
        $insertprenom->execute(array($newprenom, $_SESSION['id']));
        header("Location: profil.php?id=" .$_SESSION['id']);
    }
    if(isset($_POST['newmail']) && !empty($_POST['newmail']) && $_POST['newmail'] != $member['mail'])
    {
        $newmail= htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE ID = ? ");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header("Location: profil.php?id=" .$_SESSION['id']);
    }
    if(isset($_POST['newmdp']) && !empty($_POST['newmdp']) && isset($_POST['newmdp2']) && !empty($_POST['newmdp2'])  )
    {
        $mdp = sha1($_POST['newmdp']);
        $mdp2 = sha1($_POST['newmdp2']);

        if($mdp == $mdp2)
        {
            $insertmdp = $bdd->prepare("UPDATE membres SET password = ? WHERE ID = ? ");
            $insertmdp->execute(array($mdp, $_SESSION['id']));
            header("Location: profil.php?id=" .$_SESSION['id']);
        }
        else 
        {
            $erreur = "Les mot de passes ne correspondent pas.";
        }
    }
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
<div class="os-content">
            <div class="container pt-5">
                        <div class="row">
                            <div class="col-lg-3 col-md-12"></div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body" id="inscriptionForm">
                                        <img class="img-fluid max-auto d-block pd-4" src="./images/logo_gbaf.png" style="max-height: 150px">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Votre Prénom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Votre Nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" placeholder="Votre Pseudo" id="inputPseudo" class="form-control"name="pseudoconnect" value="<?php if(isset($pseudo)) { echo $pseudo; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="email" placeholder="Votre Email" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="email" placeholder="Saisir à nouveau" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; }?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" placeholder="Saisir à nouveau" id="mdp2" name="mdp2"/>
                                            </div>











                <br/> 
                    <a class="btn btn-block btn-danger btn-lg float-right" href=<?php "profil.php?id=" .$_SESSION['id']?>>Mettre à jour</a>
                    <a class="btn btn-block btn-danger btn-lg float-right" href=<?php "profil.php?id=" .$_SESSION['id']?>>Annuler</a>
                    var_dump
                    
            
   
    </div>
    <?php
                    if(isset($erreur))
                    {
                    echo '<font color = "red">'. $erreur . "</font>";
                    }
                    ?>  
                                            
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            <div class="col-lg-3 col-md-12"></div>
        </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
else
{
    header("Location: profil.php");
}
?>