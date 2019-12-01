<?php
session_start();
// Connexion à la base de donnée.
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_GET['t'], $_GET['id']) && !empty($_GET['t']) && !empty($_GET['id'])){
    $getid= (int) $_GET['id'];
    $gett= (int)$_GET['t'];

    $sessionid = $_SESSION['id'];

    $check= $bdd->prepare('SELECT id FROM articles WHERE id =?');
    $check->execute(array($getid));

    $sessionid = $_SESSION ['id']; 

    if($check->rowCount() == 1) {
        if($gett == 1){         
                $check_like = $bdd->prepare('SELECT id FROM likes WHERE id_article = ? AND id_membre = ? ');
                $check_like->execute(array($getid, $sessionid));

                $del= $bdd->prepare('DELETE FROM dislikes WHERE  id_article = ? AND id_membre = ? ');
                $del->execute(array($getid, $sessionid));

                $check_dislike = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ? AND id_membre = ? ');
                $check_dislike->execute(array($getid, $sessionid));

                if($check_like->rowCount() == 1){ 
                $del= $bdd->prepare('DELETE FROM likes WHERE  id_article = ? AND id_membre = ? ');
                $del->execute(array($getid, $sessionid));
                } else {
                 $ins= $bdd->prepare('INSERT INTO likes (id_article, id_membre) VALUES (?, ?)');
                 $ins->execute(array($getid, $sessionid));
                }
    
        } elseif ($gett == 2) {
            $check_like = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ? AND id_membre = ? ');
            $check_like->execute(array($getid, $sessionid));

            $del= $bdd->prepare('DELETE FROM likes WHERE  id_article = ? AND id_membre = ? ');
            $del->execute(array($getid, $sessionid));


            if($check_like->rowCount() == 1){ 
            $del= $bdd->prepare('DELETE FROM dislikes WHERE  id_article = ? AND id_membre = ? ');
            $del->execute(array($getid, $sessionid));
            } else {
             $ins= $bdd->prepare('INSERT INTO dislikes (id_article, id_membre) VALUES (?, ?)');
             $ins->execute(array($getid, $sessionid));
            }
        } 
        header('Location: http://localhost:8888/le-Groupement-Banque-Assurance-Francais-GBAF-./post.php?id=' .$getid);
    } else {
        exit('Erreur Fatale');
    }
        
} else {
    exit('Erreur Fatale. <a  href="alhost:8888/le-Groupement-Banque-Assurance-Francais-GBAF-./home.php">Revenir à la page précédente</a>');
}

?>