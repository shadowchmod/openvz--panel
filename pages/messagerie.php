<?php
	defined("INC") or die("403 restricted access");
	
	if (Session::Ouverte() && Session::$Client!=NULL)
	{
		include('pages/menu.php');
	
    
		echo '<fieldset><legend><strong>Messagerie</strong></legend><center>';
		
		if(isset($_GET['objet'])){
      affiche_messages(Session::$Client->Id,$_GET['objet']);
      effacer_message_info();	
		}else{
      affiche_objets(Session::$Client->Id);
		}
		echo '</fieldset><br/>';
		
		
			
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
?>