<?php
	defined("INC") or die("403 restricted access");
	
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	
	if (Session::Ouverte() && Session::$Client!=NULL && isset($_GET['vps']) && VPS::IsClientVPS(Session::$Client->Id,$_GET['vps']))
	{				
		echo '
		<fieldset><legend><strong>Redémarrage du server</strong></legend>
			<div id="rebootzone"><br/>
				<center>
					<form id="form1" name="form1" method="post" action="index.php?page=action&action=reboot&vps='.$_GET['vps'].'">
						<label>
							<input type="button" name="confirm_reboot" id="confirm_reboot" value="Confirmation du redémarrage du Serveur" />
						</label>
					</form>
				</center>
				<br/>
			</div>
		</fieldset><br/>';
		
		echo '<script language="JavaScript" type="text/javascript">
	
		function OnSubmit(event)
		{
			document.getElementById("rebootzone").innerHTML="\
			<br/><center>\
				<img src=\'images/ajax-loader.gif\' />\
				<br/><br/><center>Redémarrage en cours ....\
			</center>";
			
			var text=GetURLPostOutput("index.php?page=action&action=reboot&vps='.$_GET['vps'].'&noredirect");
			if (text==false)
			{		
				document.getElementById("envoyer").submit();
			}else{
				window.location.replace("index.php");
			}
		}
		
		if(navigator.appName == "Microsoft Internet Explorer")
		{
			document.getElementById("confirm_reboot").attachEvent("onclick", OnSubmit);
		}
		else
		{
			document.getElementById("confirm_reboot").addEventListener("click", OnSubmit, false);
		}
	  
	</script>';
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
?>