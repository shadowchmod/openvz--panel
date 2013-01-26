<?

$host='localhost';
$base='';		// base de donnée
$blogin='';		// votre login
$bpass='';		// mot de passe
$ip = $_SERVER['REMOTE_ADDR'];
$time=time();
//On prépare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);
$test_coco =  @strlen($_SESSION['client']);
if ( $test_coco != 0)
{
$login_sessions = $_SESSION['login'];
$password_sessions = $_SESSION['password'];
$login_client = $_SESSION['client'];

			$reponse_verif = mysql_query("SELECT * FROM connexion WHERE md5='$login_client' "); // Requête SQL
			while ($sql_verif = mysql_fetch_array($reponse_verif) )
			{
			$idclient_verif = $sql_verif['id_client'];
		
			$login_sql = $sql_verif['login'];
			$time_verif =  $sql_verif['time'];
			$ip_verif =  $sql_verif['ip'];
			}
	$date_client_login = date('d/m/y');
	$login_md55 = "00".$ip."00".$idclient_verif."00".$date_client_login."00";
	$req_bc = DB:: SQLToArray("SELECT * FROM client WHERE id='$idclient_verif' limit 1");
	$nikhandle = $req_bc[0]['nikhandle'];
	$login_md5 = md5("00".$ip."00".$idclient_verif."00".$date_client_login."00");

	if ( $login_md5 != $login_client )
	{
	$etat_connxion = "0";

	}
	else
	{
	$etat_connxion = "1";
	}
	
	
	
}
else
{
$etat_connxion = "0";
}

?>
