<?php
	defined("INC") or die("403 restricted access");
	
	if (!Session::Ouverte())
	{
?>
<center>
	<table width="619" border="0" >
		<tr> 
			<th width="96">
				<img src="images/manager.png" alt=""/>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</th>
			<th width="300">
			<center>	
				<form id="form1" name="form1" method="post" action="index.php?page=action&amp;action=newclient">
                    <table width="100%" border="0">
                        <tr>
                            <td><strong>Login :</strong></td>
                            <td><input type="text" name="login" id="login" value="<?if(isset($_SESSION["var_formulaires"]['login']))echo $_SESSION["var_formulaires"]['login'];?>"></td>
                        </tr>
                        <tr>
                            <td><strong>Mot de passe :</strong></td>
                            <td><input type="password" name="pass" id="pass" /></td>
                        </tr>
                        <tr>
                          <td><strong>Resaisir le mot de passe :</strong></td>
                          <td><input type="password" name="passconf" id="passconf" /></td>
                        </tr>
                        <tr>
                          <td><strong>T&eacute;l&eacute;phone fixe :</strong></td>
                          <td><input type="text" name="tel_fixe" id="tel_fixe" value="<?if(isset($_SESSION["var_formulaires"]['tel_fixe']))echo $_SESSION["var_formulaires"]['tel_fixe'];?>"/></td>
                        </tr>
                        <tr>
                          <td><strong>T&eacute;l&eacute;phone mobile :</strong></td>
                          <td><input type="text" name="tel_mobile" id="tel_mobile" value="<?if(isset($_SESSION["var_formulaires"]['tel_mobile']))echo $_SESSION["var_formulaires"]['tel_mobile'];?>"/></td>
                        </tr>
                        <tr>
                          <td><strong>Email :</strong></td>
                          <td><input type="text" name="mail" id="mail" value="<?if(isset($_SESSION["var_formulaires"]['mail']))echo $_SESSION["var_formulaires"]['mail'];?>"/></td>
                        </tr>
                        <tr>
                          <td><strong>Resaisir l'Email :</strong></td>
                          <td><input type="text" name="mailconf" id="mailconf" value="<?if(isset($_SESSION["var_formulaires"]['mailconf']))echo $_SESSION["var_formulaires"]['mailconf'];?>"/></td>
                        </tr>
                        <tr>
                          <td><strong>Nom :</strong></td>
                          <td><input type="text" name="nom" id="nom" value="<?if(isset($_SESSION["var_formulaires"]['nom']))echo $_SESSION["var_formulaires"]['nom'];?>"/></td>
                        </tr>
                        <tr>
                          <td><strong>Pr&eacute;nom :</strong></td>
                          <td><input type="text" name="prenom" id="prenom" value="<?if(isset($_SESSION["var_formulaires"]['prenom']))echo $_SESSION["var_formulaires"]['prenom'];?>"/></td>
                        </tr>
                        <tr>
                          <td><strong>Adresse :</strong></td>
                          <td><textarea name="adresse" rows="5" id="adresse"><?if(isset($_SESSION["var_formulaires"]['adresse']))echo $_SESSION["var_formulaires"]['adresse'];?></textarea></td>
                        </tr>
                        <tr>
                          <td><strong>Code postal :</strong></td>
                          <td><input type="text" name="codezip" id="codezip" maxlength="5" value="<?if(isset($_SESSION["var_formulaires"]['codezip']))echo $_SESSION["var_formulaires"]['codezip'];?>"/></td>
                        </tr>
                        <tr>
                          <td><strong>Ville :</strong></td>
                          <td><input type="text" name="ville" id="ville" value="<?if(isset($_SESSION["var_formulaires"]['ville']))echo $_SESSION["var_formulaires"]['ville'];?>"/></td>
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
</center>
<?php
	}else{
		Message("Impossible de s'incrire vous etes deja connecter",ALERTE);
	}