<?php
	defined("INC") or die("403 restricted access");
	
	if (Session::Ouverte() && Session::$Admin)
	{
		echo '
			<a href="index.php">< Retour au panneau</a><br/><br/>';
	
    
		echo '<fieldset><legend><strong>Messagerie</strong></legend><center>';
		
		if(isset($_GET['objet'])){
      affiche_messages_admin($_GET['objet']);
      effacer_message_info();	
		}else{
      affiche_objets_admin();
		}
		echo '</fieldset><br/>';
		
		
			
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
?>