<?php
	defined("INC") or die("403 restricted access");
	
	if (Session::Ouverte() && Session::$Client!=NULL)
	{
		include('pages/menu.php');
	
    
		echo '<fieldset><legend><strong>Messagerie</strong></legend><center>';
		
		if(!isset($_GET['objet'])){
      echo '
		<form id="form1" name="form1" method="post" action="index.php?page=action&amp;action=post_message">
      <table width="100%" border="0">
        <tr>
          <td><strong>Objet :</strong></td>
          <td><input name="objet" type="text" id="titre" size="60" /></td>
        </tr>';
		}else{
      echo '
		<form id="form1" name="form1" method="post" action="index.php?page=action&amp;action=post_message&titre='.$_GET['objet'].'">
      <table width="100%" border="0">';
    }
    echo '
        <tr>
          <td><strong>Message :</strong></td>
          <td><textarea name="message" cols="60" rows="10" id="message"></textarea></td>
        </tr>
      </table>
      <p><label>
        <input type="submit" name="Envoyer" id="Envoyer" value="Envoyer" />
      </label></p>
    </form>';
	
		echo '</fieldset><br/>';
		
		
			
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
?>