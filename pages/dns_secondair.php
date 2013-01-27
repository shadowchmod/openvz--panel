<?

$domaine = $_GET['id'];
$id_client=@Session::$Client->Id;

$sql_user = DB:: SQLToArray("SELECT * FROM vps WHERE id='$domaine' AND id_client='$id_client' LIMIT 1");

if ( !isset ( $sql_user[0]['id_ip'] ) )
{
echo "Erreur : VPS introuvable.";
}
else
{
$id_ip=$sql_user[0]['id_ip'] ;

$sql_ip = DB:: SQLToArray("SELECT * FROM ip WHERE id='$id_ip'  LIMIT 1");
$ip=$sql_ip[0]['ip'];
try {
 $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.8.wsdl");

 //login
 $session = $soap->login("AS18509-ovh", "ddlkA6JA","fr", false);


 //dedicatedSecondaryDNSGetAll
 $result = $soap->dedicatedSecondaryDNSGetAll($session, "ns207930.ovh.net");

echo '<center><table>';
echo '<tr>';
echo '<td><font size="2"><b>Domaine</b></font></td>';
echo '<td><font size="2"><b>Dns Secondaire</b></font></td>';
echo '<td><font size="2"><b>IP Declare</b></font></td>';
echo '</tr>';

$iii=0;


$i=0;
while(@$result[$i]){

	$ii=0;

	while(@$result[$i]->secondary[$ii]){
	$zone = $result[$i]->ip;
	if ( $zone==$ip )
	{
	$iii++;
	echo '<tr>';
	echo '<td><font size="2">'.$result[$i]->secondary[$ii]->zone.'<font></td>';
	echo '<td><font size="2">ns1.cmd-web.be<font></td>';
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
}
?>
