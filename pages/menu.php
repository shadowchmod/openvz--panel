<?php
    defined("INC") or die("403 restricted access");
	
	if (Session::Ouverte())// && @Session::$Client->NikHandle!='admin')
	{
    //Regarde si nouveau message
    $nb_new_mail=Messagerie::GetNewMessage(Session::$Client->Id);
    $message="";
    if(($nb_new_mail!=false)&&($nb_new_mail>0)){
      if($nb_new_mail==1)
        $message=" (1 message)";
      else
        $message=" ($nb_new_mail messages)";
    }
    
		echo '
			<a href="index.php?page=action&amp;action=logout">
				<img src="images/logout.png" border="0" alt=""/> 
				<strong>Se déconnecter</strong>
			</a>&nbsp;
						
			<a href="index.php?page=messagerie">
        <img src="images/email_ico.png" border="0" alt=""/> 
        <strong>Messagerie'.$message.'</strong>
      </a>
			<br/><br/>';		
	}
?>