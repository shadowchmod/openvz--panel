<?php
	defined("INC") or die("403 restricted access");
	
	if (Session::Ouverte() && Session::$Client!=NULL)
	{
		echo '
			<a href="index.php">< Retour aux vps</a><br/><br/>';
	
		$infoClient = Client::GetClient(Session::$Client->Id);
		echo '
			
			<fieldset><legend><strong>Edition du profil</strong></legend><center>
				<form id="form1" name="form1" method="post" action="index.php?page=action&action=edit_profil">
					<table>	
					<tr>
							<td>Nom : </td>
							<td>
								<label>
									<input type="text" name="nom" id="nom" value="'.$infoClient['nom'].'" maxlength="30" size="50"/>
								</label>
							</td>
						</tr>
						<tr>
							<td>Prénom : </td>
							<td>
								<label>
									<input type="text" name="prenom" id="prenom" value="'.$infoClient['prenom'].'" maxlength="30" size="50"/>
								</label>
							</td>
						</tr>
						<tr>
							<td>Adresse e-mail : </td>
							<td>
								<label>
									<input type="text" name="mail" id="mail" value="'.Session::$Client->Email.'" maxlength="50" size="50"/>
								</label>
							</td>
						</tr>
						<tr>
							<td>Confirmation adresse e-mail : </td>
							<td>
								<label>
									<input type="text" name="mailconf" id="mailconf" value="'.Session::$Client->Email.'" maxlength="50" size="50"/>
								</label>
							</td>
						</tr>
						<tr>
							<td>Mot de passe : </td>
							<td>
								<label>
									<input type="password" name="pass" id="pass" value="'.recupere("pass").'" size="50"/>
								</label>
							</td>
						</tr>
						<tr>
							<td>Confirmation mot de passe : </td>
							<td>
								<label>
									<input type="password" name="passconf" id="passconf" value="'.recupere("passconf").'" size="50"/>
								</label>
							</td>
						</tr>
						<tr>
							<td>Adresse : </td>
							<td>
								<label>
									<input type="text" name="adresse" id="adresse" value="'.$infoClient['adresse'].'" maxlength="30" size="50"/>
								</label>
							</td>
						</tr>
						<tr>
							<td>Ville : </td>
							<td>
								<label>
									<input type="text" name="ville" id="ville" value="'.$infoClient['ville'].'" maxlength="50" size="50"/>
								</label>
							</td>
						</tr>
						<tr>
							<td>Code Postal : </td>
							<td>
								<label>
									<input type="text" name="cp" id="cp" value="'.$infoClient['cp'].'" maxlength="5" size="50"/>
								</label>
							</td>
						</tr>
						<tr>
							<td>Pays : </td>
							<td>
								<label>
									<input type="text" name="pays" id="pays" value="'.$infoClient['pays'].'" maxlength="50" size="50"/>
								</label>
							</td>
						</tr>
						
						<p><tr><td></td><td>
						<label>
						<input type="submit" name="envoyer" id="envoyer" value="Modifier" />
						</label></td></tr>
						</p>
					</table>
				</form>
			</center></fieldset><br/>';
		
		echo '
			<script language="JavaScript" type="text/javascript">
	
				document.getElementById("pass").onkeyup=ChangeColorPassword;
				document.getElementById("passconf").onkeyup=ChangeColorPassword;
				document.getElementById("pass").onchange=ChangeColorPassword;
				document.getElementById("passconf").onchange=ChangeColorPassword;
				function ChangeColorPassword()
				{
					document.getElementById("pass").type="password";
					document.getElementById("passconf").type="password";
					var color="FFFFFF";
					if (document.getElementById("pass").value==document.getElementById("passconf").value &&
						document.getElementById("pass").value!="")
						color="#A4FFA4";
					else
						color="#FFA4A4";
					document.getElementById("pass").style.backgroundColor=color;
					document.getElementById("passconf").style.backgroundColor=color;
				}
				
				document.getElementById("mail").onkeyup=ChangeColorMail;
				document.getElementById("mailconf").onkeyup=ChangeColorMail;
				document.getElementById("mail").onchange=ChangeColorMail;
				document.getElementById("mailconf").onchange=ChangeColorMail;
				function ChangeColorMail()
				{
					var color="FFFFFF";
					if (document.getElementById("mail").value==document.getElementById("mailconf").value &&
						GetURLOutput("index.php?page=action&action=validemail&email="+document.getElementById("mail").value)=="true")
						color="#A4FFA4";
					else
						color="#FFA4A4";
					document.getElementById("mail").style.backgroundColor=color;
					document.getElementById("mailconf").style.backgroundColor=color;
				}
				
				if (document.getElementById("pass").value!="" || document.getElementById("passconf").value!="")
					ChangeColorPassword();
	  
			</script>';
			
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
?>