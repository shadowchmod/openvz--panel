<?
 mysql_connect("localhost", "", ""); // Connexion ? MySQL // user // login
mysql_select_db(""); // S?lection de la base coursphp

	$GLOBALS['local_var']['V_MON_PRIX'] = "Choix du domiane";
if ( isset ( $_POST['domaine'] ) )
{


}
else
{
$GLOBALS['local_var']['ETX'] = "";
	$req_ext = mysql_query("SELECT * FROM plan_domaine");
	while ( $sql_domaine = mysql_fetch_array($req_ext))
	{
	$ext = $sql_domaine['extension'];
	$GLOBALS['local_var']['ETX'] .=  '<option value="'.$ext.'" >'.$ext.'</option>';
	}

print_file("pages/services/domaine_choix.html");

}


?>
