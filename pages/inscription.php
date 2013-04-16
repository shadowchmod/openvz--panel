
		<a href="index.php">< Retour login</a><br/>

			<br/>
			<script language="JavaScript" type="text/javascript">
				function GenerateNik()
				{
					var fl=document.getElementById("nom").value.substring(0,1).toUpperCase();
					var sl=document.getElementById("prenom").value.substring(0,1).toUpperCase();
					if (fl=="")
						fl="A";
					if (sl=="")
						sl="B";
					var letters=fl+sl;
					var text=GetURLOutput("index.php?page=action&action=generatenik&letters="+letters);
										
					document.getElementById("nik").value=text;
				}
				function GeneratePass()
				{
					var text=GetURLOutput("index.php?page=action&action=generatepass");
					document.getElementById("pass").value=text;
					document.getElementById("passconf").value=text;
					ChangeColorPassword();
					document.getElementById("pass").type="text";
					document.getElementById("passconf").type="text";
				}
			</script>
			<fieldset><legend><strong>Inscription d'un nouveau client</strong></legend>
				<table border="\&quot;0\&quot;" align="center" >
					<tr>
						<th> 
							<center>
								<form id="form1" name="form1" method="post" action="index.php?page=action&amp;action=inscription">
									<table width="100%" border="0">
										<tr>
										<td>
											<font color="#FF0000">*</font><strong>Nik-handle :</strong>
										</td>
										<td>
											<input type="text" name="nik" id="nik" value="<?php echo recupere("nik")?>" size="50"/>
											<a href="javascript:GenerateNik();">
												<img src="images/reload.png" border="0" align="top" title="Généré Nik"/>
											</a>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Nom</strong>
										</td>
										<td>
											<input type="text" name="nom" id="nom" value="<?php echo recupere("nom") ?>" maxlength="30" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Prénom</strong>
										</td>
										<td>
											<input type="text" name="prenom" id="prenom" value="<?php echo recupere("prenom") ?>" maxlength="30" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<strong>Téléphone fixe</strong>
										</td>
										<td>
											<input type="text" name="telfixe" id="telfixe" value="<?php echo recupere("telfixe") ?>" maxlength="14" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<strong>Téléphone mobile</strong>
										</td>
										<td>
											<input type="text" name="telmobile" id="telmobile" value="<?php echo recupere("telmobile") ?>" maxlength="14" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Adresse</strong>
										</td>
										<td>
											<input type="text" name="adresse" id="adresse" value="<?php echo recupere("adresse") ?>" maxlength="60" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Code postal</strong>
										</td>
										<td>
											<input type="text" name="cp" id="cp" value="<?php echo recupere("cp") ?>" maxlength="14" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Ville</strong>
										</td>
										<td>
											<input type="text" name="ville" id="ville" value="<?php echo recupere("ville") ?>" maxlength="14" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Pays</strong>
										</td>
										<td>
											<input type="text" name="pays" id="pays" value="<?php echo recupere("pays") ?>" maxlength="14" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Adresse e-mail :</strong>
										</td>
										<td>
											<input type="text" name="mail" id="mail" value="<?php echo recupere("mail") ?>" maxlength="50" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Confirmation de l'adresse e-mail :</strong>
										</td>
										<td>
											<input type="text" name="mailconf" id="mailconf" value="<?php echo recupere("mailconf") ?>" maxlength="50" size="50"/>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Mot de passe :</strong>
										</td>
										<td>
											<input type="password" name="pass" id="pass" value="<?php echo recupere("pass") ?>" size="50"/>
											<a href="javascript:GeneratePass();">
												<img src="images/reload.png" border="0" align="top" title="Généré Password"/>
											</a>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000">*</font><strong>Confirmation du mot de passe :</strong>
										</td>
										<td>
											<input type="password" name="passconf" id="passconf" value="<?php echo recupere("passconf") ?>" size="50"/>
										</td>
									</tr>
									</table>
									<p>
										<label>
											<input type="submit" name="Envoyer" id="Envoyer" value="Envoyer" />
										</label>
									</p>
								</form>
							</center>
						</th>
					</tr>
				</table>
			</fieldset>
			
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
						color='#A4FFA4';
					else
						color='#FFA4A4';
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
						color='#A4FFA4';
					else
						color='#FFA4A4';
					document.getElementById("mail").style.backgroundColor=color;
					document.getElementById("mailconf").style.backgroundColor=color;
				}

				if (document.getElementById("pass").value!="" || document.getElementById("passconf").value!="")
					ChangeColorPassword();

				if (document.getElementById("mail").value!="" || document.getElementById("mailconf").value!="")
					ChangeColorMail();	
					

			</script>


