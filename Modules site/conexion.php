<?

$host='localhost';
$base='';				// base de donnée
$blogin='';				// login		
$bpass='';				// mot de passe
$ip = $_SERVER['REMOTE_ADDR'];
$time=time();
//On pr�pare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);

$refer = @$_GET['refer'];
$page_login = "<br /><br /><table border=\"0\">
<tr>
<form action=\"index.php?lang=fr&page=conexion&refer=".$refer."\" method=\"post\">
<td><strong><div align=\"left\">Login : </div></strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" name=\"login\" value=\"-CMD\" ></td>
</tr>
<tr>
<td><strong><div align=\"left\">Password : </div><strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"password\" name=\"password\"></td>
</tr>
<tr>
<td></td><td><br><br><input type=\"submit\" value=\"Connexion\"></td>
</tr>

</table>
</form>
</center>";
$GLOBALS['local_var']['V_CMD_RED'] = "";
include('pages/ctrl_login.php');
if ( @$etat_connxion == 1 )
{
 $GLOBALS['local_var']['V_CMD_RED'] .=  '
										 
										 <style>

.erreur{
  color:#000000;
  font-size:12px;
  font-weight:bold;
  text-align:center;

}
</style>
<div class="erreur">Vous etes deja connect�</div>
										 ';
}
else
{



if ( isset ( $_POST['login'] ) AND isset ( $_POST['password'] ) )
{

$login_post = $_POST['login'];
$password_post = $_POST['password'];
$password_post_md5 = md5($_POST['password']);
			$i=0;
			$reponse = mysql_query("SELECT * FROM client WHERE nikhandle='$login_post' AND password='$password_post_md5' "); // Requ�te SQL
			while ($sql = mysql_fetch_array($reponse) )
			{
			$i++;
			$_SESSION['login'] = $login_post;
			$_SESSION['password'] = $password_post_md5;
						
			$login_post = $_POST['login'];
			$password_post_md5 = md5($_POST['password']);
			$id_client = $sql['id'];
			$date_client_login = date('d/m/y');
			$login_md55 = "00".$ip."00".$id_client."00".$date_client_login."00";
			$login_md5 = md5("00".$ip."00".$id_client."00".$date_client_login."00");
									
			mysql_query("INSERT INTO connexion VALUES(
			'',
			'" . $time . "',
			'".$id_client."',
			'" . $login_post . "',
			'".$ip."',
			'1',
			'".$login_md5."'
			 )") or die(mysql_error());	
			$GLOBALS['local_var']['V_CMD_RED'] .=  ' <style>

.erreur{
  color:#000000;
  font-size:12px;
  font-weight:bold;
  text-align:center;

}
</style>
<div class="erreur">Redirection en cour ....</div>
										 ';
										 
							 $_SESSION['client'] = $login_md5;
		 if ( $refer != NULL )
		{
		$GLOBALS['local_var']['V_CMD_RED'] .=  "<meta http-equiv=\"Refresh\" content=\"1;URL=index.php?lang=fr&page=".$refer."\">";
		}
		else
		{
			$GLOBALS['local_var']['V_CMD_RED'] .=  "<meta http-equiv=\"Refresh\" content=\"1;URL=index.php\">";
		}
								
						
			}

			if ( $i == 0 )
			{
			$GLOBALS['local_var']['V_CMD_RED'] .= "Erreur l'ors de la connexion, merci de réessayer";
			$GLOBALS['local_var']['V_CMD_RED'] .= $page_login; 
			}

}
elseif ( !isset ( $_POST['login'] ) AND !isset ( $_POST['password'] ))
{
$GLOBALS['local_var']['V_CMD_RED'] = $page_login; 
}


}
	print_file("pages/services/login.html");


?>
