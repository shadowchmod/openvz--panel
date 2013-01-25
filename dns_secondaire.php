<?

defined("INC") or die("403 restricted access");
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';

$i=0;

echo '<center><b>Recupatilatif Zone DNS Secondaire</b></center>';
echo '<br><br>';
//dedicatedSecondaryDNSGetAll
try {
$soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.8.wsdl");		// API OVH

 //login
 $session = $soap->login("-ovh", "","fr", false);							// nikeendle OVH - et votre code d'acces ovh
 $result = $soap->dedicatedSecondaryDNSGetAll($session,  "");				// ip ou nomp de domaine de votre machine

//  echo "dedicatedSecondaryDNSGetAll successfull<br/>";
//  print_r($result); // place your code here ...
   echo "<br/>";

   }
   catch(SoapFault $fault) {
   // echo "Error : ".$fault;
  }
echo '<center><table>';
echo '<tr>';
echo '<td><font size="2"><b>Domaine</b></font></td>';
echo '<td><font size="2"><b>Dns Secondaire</b></font></td>';
echo '<td><font size="2"><b>IP Declare</b></font></td>';
echo '<td><font size="2"><b>Creation</b></font></td>';
echo '</tr>';




$i=0;
while($result[$i]){

	$ii=0;

	while($result[$i]->secondary[$ii]){
	echo '<tr>';
	echo '<td><font size="2">'.$result[$i]->secondary[$ii]->zone.'<font></td>';
	echo '<td><font size="2">'.$result[$i]->secondary[$ii]->nameserver.'<font></td>';
	echo '<td><font size="2">'.$result[$i]->ip.'<font></td>';
	echo '<td><font size="2">'.$result[$i]->secondary[$ii]->creation.'<font></td>';
	$ii++;
	
	}
//echo '<td><font size="2">'.$result[$i]->secondary[$ii]->nameserver.'<font></td>';
//echo '<td><font size="2">'.$result[$i]->secondary[$ii]->ip.'<font></td>';
//echo '<td><font size="2">'.$result[$i]->type.'<font></td>';
//echo '<td><font size="2">'.$result[$i]->expirationDate.'<font></td>';
echo '</tr>';
$i++;

}
echo '</table></center>';

include ('include/bas.php');
?>

