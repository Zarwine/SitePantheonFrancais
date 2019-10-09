<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=pfmembre', 'root', '');

if(isset($_SESSION['id'])) 
{
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ? ");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();

    if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo'])
    {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
        $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }
    if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail'])
    {
        $newmail = htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }
    if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
    {
        $mdp1 = sha1($_POST['newmdp1']);
        $mdp2 = sha1($_POST['newmdp2']);

        if($mdp1 == $mdp2)
        {
            $insertmdp = $bdd->prepare("UPDATE membres SET mdp = ? WHERE id = ?");
            $insertmdp->execute(array($mdp1, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);

        }
        else
        {
            $msg = "Vos mots de passe ne correspondent pas.";
        }


    }

?>



    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="fixed.css">
        <meta charset="utf-8">
        <title>Edition de profil</title>
    </head>

    <body>
        <div class="topbar">
        <a href="index"><img src="logopti.png" ></a>
        </div>

        <div class="menu">
            <a href="index.php">Actualité</a>
            <a href="#">Notre équipe</a>
            <a href="#">Notre histoire</a>
            <a href="#">F.A.Q.</a>
            <a href="#">Galerie</a>
            <a href="inscription.php">S'inscrire</a>		
        </div>
        <div class="content">
                <div class="main">
                <h1>Titre</h1>
                <h2>Edition de mon profil</h2>
                <form method="POST" action="">
                <label>Pseudo :</label>
                <input type="text" name="newpseudo" placeholder="Pseudo"  value="<?php echo $user['pseudo']?>"/><br />
                <label>Mail :</label>
                <input type="email" name="newmail" placeholder="Mail" value="<?php echo $user['mail']?>"/><br />
                <label>Mot de passe :</label>
                <input type="password" name="newmdp1" placeholder="Mot de passe" /><br />
                <label>Confirmation du mot de passe :</label>
                <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br />
                <input type="submit" value="Mettre à jour mon profil." />
                </form>
                <?php if(isset($msg)) { echo $msg;} ?>

                
                </div>
            <div class="sidebar">
                <iframe src="https://discordapp.com/widget?id=382533200028631041&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0"></iframe>
            </div>
        </div>
        
        

        <script src="fixed.js"></script>
    </body>
    </html>
<?php

}

else
{
 header("Location: connexion.php");
}


?>