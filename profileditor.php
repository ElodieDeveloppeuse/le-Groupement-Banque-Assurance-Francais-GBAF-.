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

    if(isset($_POST['newpseudo']) && !empty($_POST['newpseudo']) && $_POST['newpseudo'] != $member['pseudo'])
    {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE ID = ? ");
        $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
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
            if(isset($_SESSION['id']) && $member['id'] == $_SESSION['id'])
            {
            ?>
            <?php 
            }
            ?>

</header>
<div class="os-content">
            <div class="container pt-5">
                        <div class="row">
                            <div class="col-lg-3 col-md-12"></div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body" id="inscriptionForm">
                                        <img class="img-fluid max-auto d-block pd-4 logo" src="./images/logo_gbaf.png" style="max-height: 150px">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Votre Prénom" id="prenom" name="newprenom" value="<?php echo $member['prenom']; ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Votre Nom" id="nom" name="newnom" value="<?php echo $member['nom']; ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" placeholder="Votre Pseudo" id="inputPseudo" class="form-control"name="newpseudo" value="<?php echo $member['pseudo']; ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="email" placeholder="Votre Email" id="mail" name="mail" value="<?php echo $member['mail']; ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"/>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" placeholder="Saisir à nouveau" id="mdp2" name="mdp2"/>
                                            </div>
                <br/> 

                    <input type="submit" name="update" class="btn btn-block btn-danger btn-lg float-right"  value=" Mettre à jour"/>
                    <input type="submit" name="back" class="btn btn-block btn-danger btn-lg float-right" value=" Annuler"/>
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
    header("Location: connexion.php");
}
?>