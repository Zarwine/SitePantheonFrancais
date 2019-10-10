<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=pfmembre', 'root', '');

if(isset($_POST['formconnexion']))
{
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);

   if(!empty($mailconnect) AND !empty($mdpconnect))
   {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND mdp = ? ");
        $requser->execute(array($mailconnect, $mdpconnect))  ;
        $userexist = $requser->rowCount();

        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("location: profil.php?id=".$_SESSION['id']);

        }
        else
        {
            $erreur = "Mauvais mail ou mot de passe.";
        }
    }
   else
   {
        $erreur = "Tous les champs doivent être complétés.";
   }
}

?>


<!DOCTYPE html>
<html>
  <head>
  	<link rel="stylesheet" href="fixed.css">
    <meta charset="utf-8">
    <title>Connexion</title>
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
			<div class="formulaire">
			<form method="POST" action="">
				<input type="email" name="mailconnect" placeholder="Mail"/>
                <input type="password" name="mdpconnect" placeholder="Mot de passe"/>
                <input type="submit" name="formconnexion" value="Se connecter.">
			</form>	
			<?php 

			if(isset($erreur)){
				echo $erreur;
			}


			?>
					
			</div>
		  </div>
		  <div class="sidebar">
			<iframe src="https://discordapp.com/widget?id=382533200028631041&theme=dark" height="500" allowtransparency="true" frameborder="0"></iframe>
		  </div>
	  </div>
	
	

	  <script src="fixed.js"></script>
  </body>
</html>