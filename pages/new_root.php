<?php
	defined("INC") or die("403 restricted access");
	
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	
	if (Session::Ouverte() && Session::$Client!=NULL && isset($_GET['vps']) && VPS::IsClientVPS(Session::$Client->Id,$_GET['vps']))
	{
		$vps=$_GET['vps'];
		$oslist=OS::GetOsList();//index.php?page=action&action=reinstall&vps='.$_GET['vps'].'
		echo '<div id="repassword">
		<fieldset><legend><strong>Changement du mot de pass ROOT</strong></legend>
			<form id="form1" onsubmit="return afficheMessage();" name="form1" method="post" action="index.php?page=action&action=newpassroot&vps='.$_GET['vps'].'">
			  <table>			  
			  <tr><td>Mot de passe root : </td>
			  <td><label>
			  <input type="password" name="passroot" id="passroot" />
			  </label></td></tr>
			  <tr><td>Confirmation mot de passe root : </td>
			  <td><label>
			  <input type="password" name="passrootconf" id="passrootconf" />
			  </label></td></tr>
			  <p><tr><td></td><td>
				<label>
				<input type="submit" name="envoyer" id="envoyer" value="Lancer le changement du mot de pass" />
				</label></td></tr>
			  </p>
			</form></table>
			<div id="repasswordzone" style="display:none;">
		      <br/><center>
					<img src=\'images/ajax-loader.gif\' />
					<br/><br/><center>Changement en cours ....
				</center>
      </div>
		</fieldset></div><br/>';
		
		
		
		echo '<script language="JavaScript" type="text/javascript">
	
    function afficheMessage()
		{
			
				document.getElementById(\'repasswordzone\').style.display = \'block\';
				document.getElementById(\'envoyer\').style.display = \'none\';

			
					
				
		}
		

	  
	</script>';
			
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
	
	/*
		if(navigator.appName == "Microsoft Internet Explorer")
		{
			document.getElementById("envoyer").attachEvent("onclick", OnSubmit);
		}
		else
		{
			document.getElementById("envoyer").addEventListener("click", OnSubmit, false);
		}
		
		document.getElementById("passroot").onkeyup=ChangeColorPassword;
		document.getElementById("passrootconf").onkeyup=ChangeColorPassword;
		function ChangeColorPassword()
		{
			document.getElementById("passroot").type="password";
			document.getElementById("passrootconf").type="password";
			var color="FFFFFF";
			if (document.getElementById("passroot").value==document.getElementById("passrootconf").value &&
				document.getElementById("passroot").value!="")
				color="#A4FFA4";
			else
				color="#FFA4A4";
			document.getElementById("passroot").style.backgroundColor=color;
			document.getElementById("passrootconf").style.backgroundColor=color;
		}
		
		if (document.getElementById("passroot").value!="" || document.getElementById("passrootconf").value!="")
			ChangeColorPassword();
	
	
	*/
	
	
	
	
	
	
	
	
	
	
?>