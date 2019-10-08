<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=pfmembre', 'root', '');

if(isset($_POST['forminscription']))
{
	$pseudo = htmlspecialchars($_POST['pseudo']);
	$mail = htmlspecialchars($_POST['mail']);
	$mail2 = htmlspecialchars($_POST['mail2']);
	$mdp = sha1($_POST['mdp']);
	$mdp2 = sha1($_POST['mdp2']);

	if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
	{


		$pseudolenght = strlen($pseudo);
		if($pseudolenght <= 255)
		{
			
				if($mail == $mail2)
				{
					if(filter_var($mail, FILTER_VALIDATE_EMAIL))
					{
						$reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
						$reqmail->execute(array($mail));
						$mailexist = $reqmail->rowCount();
						if($mailexist == 0)
						{
							if($mdp == $mdp2)
							{
								$insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, mdp)  VALUES(?, ?, ?)");
								$insertmbr->execute(array($pseudo, $mail, $mdp));
								$erreur = "Votre compte a bien été créé";
							}
							else
							{
								$erreur = "Vos mots de passe sont différents.";
							}
						}
						else
						{
							$erreur = "Adresse mail déja utilisée.";
						}	

					}	
					else
					{
						$erreur = "Votre adresse mail n'est pas valide.";
					}	
				}
				else
				{
					$erreur = "Vos adresses mails ne correspondent pas.";
				}
		}
		else
		{
			$erreur = "Votre pseudo ne doit pas dépasser 255 caractères.";
		}
	}
	else{
		$erreur = "Tous les champs doivent être complétés";
	}
}

?>

<!DOCTYPE html>
<html>
  <head>
  	<link rel="stylesheet" href="fixed.css">
    <meta charset="utf-8">
    <title>Pantheon Francais</title>
  </head>

  <body>
  	<div class="topbar">
  		<img src="logopti.png" >
  	</div>

  	<div class="menu">
  		<a href="#">Actualité</a>
  		<a href="#">Nos Jeux</a>
  		<a href="#">Notre histoire</a>
  		<a href="#">F.A.Q.</a>
  		<a href="#">Règlement</a>			
  	</div>
  	<div class="content">
		  <div class="main">
			  <h1>Titre</h1>
			<div class="formulaire">
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right">
							<label for="pseudo">Pseudo :</label>
						</td>	
						<td>	
							<input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mail">E-Mail :</label>
						</td>	
						<td>	
							<input type="email" placeholder="Votre e-mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mail2">Confirmez votre e-mail :</label>
						</td>	
						<td>	
							<input type="email2" placeholder="Votre e-mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mdp">Mot de passe :</label>
						</td>	
						<td>	
							<input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mdp2">Confirmez votre mot de passe :</label>
						</td>	
						<td>	
							<input type="password2" placeholder="Votre mot de passe" id="mdp2" name="mdp2">
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<br />
							<input type="submit" name="forminscription" value="S'inscrire"	>
						</td>
					</tr>
				</table>
			</form>	
			<?php 

			if(isset($erreur)){
				echo $erreur;
			}


			?>
					
			</div>
		  </div>
		  <div class="sidebar">
			<iframe src="https://discordapp.com/widget?id=382533200028631041&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0"></iframe>
		  </div>
	  </div>
	
	

	  <script src="fixed.js"></script>
  </body>
</html>