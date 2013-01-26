<?php
	defined("INC") or die("403 restricted access");

	vider_variables_formulaire();
	
	$lang=$GLOBALS['currentlang'];
	
	switch (@$_GET['action'])
	{
		case "contactmail":
			$Error=false;
			if (!ValidMail($_POST['email']))
			{
				$Error=true;
				passer_message_info("E-mail invalide",ALERTE);
			}
			if (strlen($_POST['subject'])==0)
			{
				$Error=true;
				passer_message_info("Sujet trop court",ALERTE);
			}
			if (strlen($_POST['message'])==0)
			{
				$Error=true;
				passer_message_info("Message trop court",ALERTE);
			}	
			
			if ($Error==false)
			{
				$from_mail = $_POST['email'];
				$dest_name = "Support your-domaine.fr"; //Nom du receveur
				$dest_mail = "support@hyour-domaine.fr"; //Email du receveur
				$sujet = $_POST['subject'];
				
				//Message :
				$message = "Message FROM : ".$_POST['email']."\n";
				$message .= $_POST['message'];
				
				/** Envoi du mail **/
				$entete = "MIME-Version: 1.0\r\n";
				$entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$entete .= "To: $dest_name <$dest_mail>\r\n";
				$entete .= "From: <$from_mail>\r\n";
				if (mail($dest_mail, $_POST['subject'], $message, $entete))				
					passer_message_info("E-mail envoyé",OK);
				else{
					passer_message_info("Erreur lors de l'envoie de l'e-mail",ALERTE);
					stocker_variables_formulaire($_POST);
				}
			}else{
				stocker_variables_formulaire($_POST);
			}
			header("Location: index.php?lang=$lang&page=contact");
			break;
		default:
			header("Location: index.php?lang=$lang");
	}
	
?>
