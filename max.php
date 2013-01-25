<?php

mysql_connect("localhost","","");			// votre user et votre mot de passe
mysql_select_db("");						// Votre base de donnée

try {
 $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.8.wsdl");		// OVH API

 //login
 $session = $soap->login("-OVH", "","fr", false);							// votre nikeendle, votre mot de passe

 //dedicatedFailoverList
 $result = $soap->dedicatedFailoverList($session, "");						// votre ip ou votre nom de domaine de votre serveur
 $i = 0;
 foreach($result as $objet){
	if(mysql_num_rows(mysql_query("SELECT * FROM ip where ip ='".$objet->ip."'")) == 0)
	echo "<b>".$objet->ip."</b><br />";
	else
	echo $objet->ip."<br />";
	$i++;
 }
 echo "<br /><b>Nb IP : $i</b><br />";

 //logout
 $soap->logout($session);


} catch(SoapFault $fault) {
 echo $fault;
}

?>
