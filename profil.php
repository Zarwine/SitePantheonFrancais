<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=pfmembre', 'root', '');

if(isset($_GET['id']) AND $_GET['id'] > 0)
{

    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

?>


<!DOCTYPE html>
<html>
  <head>
  	<link rel="stylesheet" href="fixed.css">
    <meta charset="utf-8">
    <title>Profil</title>
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
              <h2>Profil de <?php echo $userinfo ['pseudo'];?></h2>
              <br />
              <br />
              Pseudo = <?php echo $userinfo ['pseudo'];?>
              <br />
              Mail = <?php echo $userinfo ['mail'];?>
              <br />
            <?php 			
                if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
                {
                    ?>
                    <a href="#">Editer mon profil</a>
                    <br />
                    <a href="deconnexion.php">Se déconnecter</a>
                    <?php
                }    
                
            ?>
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

}


?>