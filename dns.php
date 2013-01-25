<?php


// remplacer your-domaine par votre nom de domaine

try {
 $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.8.wsdl"); 	// OVH API

 //login
 $session = $soap->login("-ovh", "","fr", false);							// votre nikendle et code mot de 


 //dedicatedSecondaryDNSGetAll
 $result = $soap->dedicatedSecondaryDNSGetAll($session, "");				// votre ip ou nom de domaine de votre machine

echo '<center><table>';
echo '<tr>';
echo '<td><font size="2"><b>Domaine</b></font></td>';
echo '<td><font size="2"><b>Dns Secondaire</b></font></td>';
echo '<td><font size="2"><b>IP Declare</b></font></td>';
echo '</tr>';




$i=0;
while(@$result[$i]){
$iii=0;
	$ii=0;

	while(@$result[$i]->secondary[$ii]){
	$zone = $result[$i]->ip;
	if ( $zone=="91.121.224.83" )
	{
	$iii++;
	echo '<tr>';
	echo '<td><font size="2">'.$result[$i]->secondary[$ii]->zone.'<font></td>';
	echo '<td><font size="2">ns1.your-domaine.be<font></td>';
	echo '<td><font size="2">'.$result[$i]->ip.'<font></td>';
	}
	$ii++;
	
	}

echo '</tr>';
$i++;

}
echo '</table></center>';
if ( $iii == 0 )
{
echo "Vous n'avez aucun domaine enregistré sur le serveur de DNS";
}
 //logout
 $soap->logout($session);


} catch(SoapFault $fault) {
 echo $fault;
}

?>
