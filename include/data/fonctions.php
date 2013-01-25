<?php

/** Est appelé lors d'un probléme ou d'un  erreur*/
define("ALERTE",1);
/** Est appelé pour afficher l'erreur en detail*/
define("ERREUR",2);
/** Est appelé  quand une action est réussie*/
define("OK",4);
/** Est appelé pour prevevenir l'utilisateur*/
define("INFO",8);


/**
* affiche un message utilisateur
*
* $message : message affiché
* $type : type du message (défaut INFO)
*/
function message($message, $type=INFO){

	switch($type){
		case INFO: $class='info';break;
		case ERREUR: $class='erreur';
			$message="<b>$message</b><pre>\n".trace(debug_backtrace())."</pre>";
			break;
		case OK: $class='ok';break;
		case ALERTE: $class='alerte';break;
		default:$class='info';
	}

	print <<< ENDOFMESSAGE

		<div class='$class'>
			$message
		</div>

ENDOFMESSAGE;
}

/**
* affiche un message de debug, avec la trace d'exécution
*
* $message : chaine, tableau, etc...
*/
function debug($message){
	// Si le mode debug est activé alors on affiche le message
	if (DEBUG)
	{
		echo "<pre class='debug'>";

		echo "<b>";
		print_r($message);
		echo "</b>\n";

		echo trace(debug_backtrace());

		echo "</pre>";
	}
	return $message;
}

/**
* affiche la trace d'exécution courante
*
* $backtrace : retour d'un debug_backtrace lors de l'appel à debug
* si NULL, inclus l'appel de debug dans la trace d'exécution
*/
function trace($backtrace){

	$chaine='';
	if($backtrace)
		$trace=array_reverse($backtrace);
	else
		$trace=array_reverse(debug_backtrace());
	$fonction=NULL;
	$decalage='';
	foreach($trace as $appel){

		$chaine.= $decalage.$appel['file'].', ligne '.$appel['line'];
		if($fonction){
			$chaine.=" : $fonction()\n";
			$decalage="  ".$decalage;
		}else{
			$decalage="  +--";
			$chaine.= "\n";
		}

		$fonction=$appel['function'];

	}
	return $chaine;


}

/**
* redirige l'utilisateur vers une URL
* A UTILISER AVANT UN AFFICHAGE 
*
* $url : page de redirection
* $message : message à passer dans la nouvelle page
* $type : type de message
*/
function redirection($url,$message=NULL,$type=NULL){
	if($message)
		passer_message_info($message,$type);
	header("Location: $url");
}

/**
* vérifie si un message d'info existe
*/
function existe_message_info(){
	debug($_SESSION);
	return isset($_SESSION["messages"]);
}
/**
* affiche les éventuels messages d'infos stockés
* et les supprime
*/
function message_info(){
	debug($_SESSION);
	foreach($_SESSION["messages"] as $message=>$type){
		message($message,$type);
	}
	effacer_message_info();
}
/**
*  stocke un message d'info
* 
* message : message d'info à stocker
* type : type du message (INFO, OK, ERREUR, ALERTE)
*/
function passer_message_info($message,$type){
	$_SESSION["messages"][$message]=$type;
}
/**
* Supprime les message d'info stocker
*/
function effacer_message_info(){
	unset($_SESSION["messages"]);
}

/**
* supprime les variables de formulaires stockées en SESSION
*/
function vider_variables_formulaire(){
	$_SESSION["var_stocked"]=false;
	unset($_SESSION["var_formulaires"]);
}

/**
* stocke les variables GET POST dans la session
* 
* $tab = tableau de variables à stocker, par défaut : GET et POST
*/
function stocker_variables_formulaire($tab=NULL){
	if($tab==NULL)
		$tab=$_REQUEST;
	$_SESSION["var_formulaires"]=$tab;
	$_SESSION["var_stocked"]=true;
}

/**
* recupère une variable de formulaire stockée en SESSION
* 
* variable : nom de la variable
* retourne "" si la variable n'existe pas
*/
function recupere($variable){
	if(!empty($_SESSION['var_formulaires'][$variable]))
		return($_SESSION['var_formulaires'][$variable]);
	else
		return false;
}

/**
* Permet de savoir si des variables sont stocker en SESSION
*/
function variables_stocker()
{
	if ($_SESSION["var_stocked"]==true)
		return true;
	else 
		return false;
}

/**
* Permet d'afficher une date formater à partir d'une date stocker dans une base de données
* 
* $date : date et heure issus d'une base de donnée
*/
function FormatDate($date)
{
	// Permet d'écrir la date en français
	setlocale(LC_TIME, 'fr_FR', 'FR');
	return strftime("%d %B %Y", strtotime($date));
}

/**
* Permet d'afficher une heure formater à partir d'une heure stocker dans une base de données
* 
* $date : date et heure issus d'une base de donnée
*/
function FormatTime($date)
{
	return strftime("%H:%M", strtotime($date));
}

/**
* Permet de convertir les tags html en texte affichable 
* 
* string : chaine de caractére à traiter
*/
function NormalText($string)
{
	// Convertis les tags HTML en texte affichable
	return nl2br(htmlentities($string));
}

/**
* Permet de convertir les quotes pour résoudre le probléme de l'injection SQL
* 
* string : chaine de caractére à traiter
*/
function NoQuote($string)
{
	// Remplace les ' par des \' et \\' par des \'
	$string=str_replace("'","\'",$string);
	$string=str_replace("\\'","\'",$string);
	return $string;
}

/**
* Permet de transformer un quote pour qu'il puisse étre afficher dans une zone de saisie
*
* text : text auquel on va convertir les quote
*/
function CodingQuote($text)
{
	// Convertis les quote &#039
	return htmlspecialchars($text,ENT_QUOTES);
}

function LinkURL($link,$text)
{
	echo '<a href="'.$link.'">'.NormalText($text).'</a>';
}

function LinkImageURL($link,$image)
{
	echo '<a href="'.$link.'"><img src="'.($image).'" border="0" alt=""/></a>';
}

function ProtectSQL($value)
{
	return str_replace("'","\\'",str_replace("\\","\\\\'",$value));
}

function ValidMail($mail)
{
	$atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';   // caractères autorisés avant l'arobase
	$domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)'; // caractères autorisés après l'arobase (nom de domaine)
								   
	$regex = '/^' . $atom . '+' .   // Une ou plusieurs fois les caractères autorisés avant l'arobase
	'(\.' . $atom . '+)*' .         // Suivis par zéro point ou plus
									// séparés par des caractères autorisés avant l'arobase
	'@' .                           // Suivis d'un arobase
	'(' . $domain . '{1,63}\.)+' .  // Suivis par 1 à 63 caractères autorisés pour le nom de domaine
									// séparés par des points
	$domain . '{2,63}$/i';          // Suivi de 2 à 63 caractères autorisés pour le nom de domaine
	
	// test de l'adresse e-mail
	if (preg_match($regex, $mail)) {
		return true;
	} else {
		return false;
	}
}

function SizeToText($size)
{
	if($size>=1024)
	{
		$size/=1024;
		if($size>=1024)
		{
			//$string=sprintf("%.2f Go",$size/1024.0);
			$size/=1024;			
			$string=number_format($size, 2, ',', ' ').' Go';
		}else{
			//$string=sprintf("%.2f Mo",$size);
			$string=number_format($size, 2, ',', ' ').' Mo';
		}
	}else{
		$string=number_format($size, 2, ',', ' ').' ko';
		//$string=sprintf("%.2f Ko",$size);
	}
	return $string;
}

function ShowNewVPS($vps)
{
	$id=$vps['id'];
	$info=VPS::GetIP($id);	
	$dns=$info['reverse_original'];
?>
			<form name="form1" method="post" action="index.php?page=reinstall&vps=<?php echo $id;?>">
				<table width="700" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="127" align="center">
							<img src="./images/attention.png" width="74" height="62" alt=""/>
						</td>
						<td width="366">
							<p>Votre nouveau VPS <?php echo $dns; ?> est près à être utilisé.
								<br/>
							Pour lancer l'installation cliquer sur continuer
							</p>
						</td>
						<td width="207" align="right">
							<input type="submit" name="continuer" id="continuer" value="Continuer">
						</td>
					</tr>
				</table>
			</form>
<?php
}

function ShowDetailVPS($vps)
{
	$info=VPS::GetIP($vps['id']);
	$dns=$info['reverse_original'];
	
?>
			<br/><br/>
			<fieldset style="width:680px;">
				<legend>
					<strong>
						<?php echo strtoupper($dns);?>
					</strong>
				</legend>
<?php
				ShowLightDetailVPS($vps['id']);
?>
				<center>
				<hr>
					<table border="0" cellpadding="20" width="680">
						<tr>
							<th> 
								<a href="index.php?page=reboot&vps=<?php echo $vps['id'];?>">
								<img src="images/reboot.png" border="0" height="32" width="32" alt=""/> <br/>
								<strong>Reboot hard</strong>
							</a>
							</th>
							<th>
								<a href="index.php?page=reinstall&vps=<?php echo $vps['id'];?>">
									<img border="0" src="images/package.png" height="32" width="32" alt=""/><br/> 
									<strong>Ré-Installation</strong>
								</a>
							</th>
							<th>
								<a href="index.php?page=new_root&vps=<?php echo $vps['id'];?>">
									<img border="0" src="images/cadena.PNG" height="32" width="32" alt=""/><br/> 
									<strong>Pass root</strong>
								</a>
							</th>
							<th> 
								<img src="images/dns.png" height="32" width="32" alt=""/>
								<br/> <strong>Serveur DNS Secondaire</strong><br/><i>Bientot</i>
							</th>
							<th> 
								<a href="index.php?page=ftpbackup&vps=<?php echo $vps['id'];?>">
									<img border="0" src="images/compte_ftp.png" height="32" width="32" alt=""/> <br/>
									<strong>FTP backup</strong>
								</a>
							</th>
							<th> 
								<a href="index.php?page=vnc&vps=<?php echo $vps['id'];?>">
									<img border="0" src="images/vnc.png" height="32" width="32" alt=""/> <br/>
									<strong>VNC console</strong>
								</a>
							</th>
						</tr>    
					</TABLE>     
				</center>
			</fieldset>
			<p>&nbsp;</p>
<?php
}

function ShowLightDetailVPS($vpsid)
{
	$vpsinfo=VPS::GetVPS($vpsid);
	
	// on recupere la date d'expiration et de création && commenatir client
	
	$reponse_vps = mysql_query("SELECT * FROM vps WHERE id='$vpsinfo' LIMIT 1 ") or die(mysql_error());
			while ($sql_vps = mysql_fetch_array($reponse_vps) )
			{
			$date_expiration = $sql_vps['expiration'];
			$date_creation =  $sql_vps['creation'];
			$commentair_client =  $sql_vps['commentaire'];
			}
			
	//On la convertie 
	$date_expirationn = $date_expiration;
	$date_creationn = $date_creation;
	$date_expiration = date('d/m/Y', $date_expiration);
	$date_creation = date('d/m/Y', $date_creation);
	//Fin de la recup
	$info=VPS::GetIP($vpsid);	
	$ip=strtoupper($info['ip']);
	$dns=$info['reverse_original'];
	$info=VPS::GetPlan($vpsid);
	
	$info=VPS::GetOS($vpsid);
	
	$OSName=$info['nom_os'];
	
	$TX=($vpsinfo['TX_total']+$vpsinfo['TX_temp'])/1024;
	$RX=($vpsinfo['RX_total']+$vpsinfo['RX_temp'])/1024;
	$TX=SizeToText($TX);
	$RX=SizeToText($RX);
	
	if($vpsinfo['status']==1){
		$img='feux_vert';
	}else{
    if($vpsinfo['status']==2){
      $img='feux_orange';
    }else{
      $img='feux_rouge';
    }
	}
	echo "
				<table border=\"0\" width=\"680\">
					<tr>
						<td> 
							<b>VPS</b> : $vpsid
						</td>
						<td>
              <b>Adresse IP</b> :  $ip<br/>
						</td>
						<td>
						  <b>Os : $OSName</b>
						</td>
					</tr>
					
					<tr>
            <td> 
							<b>Status</b> : <img src=\"images/$img.png\" width=\"37\" height=\"20\" align=\"absmiddle\" alt=\"\"/>
						</td>
						<td>
              <b>Adresse IP</b> :  $ip<br/>
						</td>
						<td>
						  <b>Os : $OSName</b>
						</td>
					</tr>
					
					<tr>
            <td> <b>Date de Création </b> : ";
							if ( $date_creation != "0000-00-00" && $date_creation != "NULL" && !empty($date_creation))
                echo $date_creation;
							else
                echo " - ";
            echo "
            </td>
            <td> <b>Date d'Expiration</b> : ";
							if ( $date_expiration != "0000-00-00" && $date_expiration != "NULL" && !empty($date_expiration))
                echo $date_expiration;
							else
                echo " - ";
            echo "
            </td>
						<td></td>
					</tr>
					</table>
					
					<table style=\"margin-top:10px;\">
					<tr>
            <td>
            <b>Traffic (Mois en cours)</b> :
						</td>
            <td>
							<img src=\"images/upload.png\" align=\"absmiddle\" alt=\"\"/>Transmis : $TX
						</td>
						<td> 
							<img src=\"images/download.png\" align=\"absmiddle\" alt=\"\"/>Reçus : $RX
						</td>
					</tr>
					<tr>
            <td>
            <b>Débit (Actuel)</b> :
						</td>
            <td>
							<img src=\"images/upload.png\" align=\"absmiddle\" alt=\"\"/>Transmis : ".$vpsinfo['deb_TX']."
						</td>
						<td> 
							<img src=\"images/download.png\" align=\"absmiddle\" alt=\"\"/>Reçus : ".$vpsinfo['deb_RX']."
						</td>
					</tr>	
				</table>";
				include("affiche_dd.php");
}
function OctetToString($koctet){
  	if($koctet<1024){
		$string=number_format($koctet, 2, ',', ' ').' Ko';
	}else{
		$koctet/=1024;
		if($koctet<1024){
			$string=number_format($koctet, 2, ',', ' ').' Mo';
		}else{
			$koctet/=1024;
			$string=number_format($koctet, 2, ',', ' ').' Go';
		}
	}
	return $string;
	
}


//Affichage du menu
function affichage_menu($client){
    $nb_new_mail=Messagerie::GetNewMessage($client);
    $message="";
    if(($nb_new_mail!=false)&&($nb_new_mail>0)){
      if($nb_new_mail==1)
        $message=" (1 message)";
      else
        $message=" ($nb_new_mail messages)";
    }
		echo '
      <table border="0" cellspacing="0" cellpadding="0" class="table_menu">
        <tr >
          <td class="menu"><a href="index.php?page=action&amp;action=logout"><div><img src="images/logout.png" border="0" alt=""/> Se déconnecter</div></a></td>
          <td class="menu"><a href="index.php?page=edit_profil"><div><img src="images/profil.png" border="0" alt=""/> Profil</div></a></td>
          <td class="menu"><a href="index.php?page=produit"><div>Produits</div></a></td>
          <td class="menu">Commande</td>
          <td class="menu"><a href="index.php?page=messagerie"><div>Messagerie'.$message.'</div></a></td>
        </tr>
      </table>
		
			<br/><br/>';
}

?>