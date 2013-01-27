<?


$req = mysql_query("SELECT * FROM invoice_corp");


while ( $sql = mysql_fetch_array($req) )
{
$id =  $sql['id'];
$id_prix = $sql['id_prix'];
echo $sql['id'];
echo "==>";

	$sql_vps = DB:: SQLToArray("SELECT * FROM prix_service WHERE id='$id_prix' LIMIT 1");
		$prix = $sql_vps[0]['prix'];
		
			mysql_query("UPDATE invoice_corp SET prix=' " . $prix . " ' WHERE id='$id' ");
			
			
	echo $prix;
	echo "<br />";

}
?>