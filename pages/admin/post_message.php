<?php
	defined("INC") or die("403 restricted access");
	
		echo '
			<a href="index.php">< Retour au panneau</a><br/><br/>';
	
    
		echo '<fieldset><legend><strong>Messagerie</strong></legend><center>';
		
		if(isset($_GET['objet'])){
      echo '
		<form id="form1" name="form1" method="post" action="index.php?page=action&amp;action=post_message_admin&titre='.$_GET['objet'].'">
      <table width="100%" border="0">
        <tr>
          <td><strong>Message :</strong></td>
          <td><textarea name="message" cols="60" rows="10" id="message"></textarea></td>
        </tr>
      </table>
      <p><label>
        <input type="submit" name="Envoyer" id="Envoyer" value="Envoyer" />
      </label></p>
    </form>';
    }
		echo '</fieldset><br/>';
		
		

?>