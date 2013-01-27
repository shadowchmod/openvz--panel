<?
$id_service = $_GET['id'];
$cat_service = $_GET['cd'];

if ( $cat_service == "VPS" )
{

		$facture_denriere = "0900000";
				//On recupere le nuémro de la denrier facture pour en crée un superieur
		$reponsee = mysql_query("SELECT * FROM commande ORDER BY number_cmd  ASC "); // Requête SQL
		 while ($sqll = mysql_fetch_array($reponsee) )
		{
				$facture_denriere = $sqll['number_cmd'];
		}
	$facture_denriere = $facture_denriere+1;
$ip = $_SERVER['REMOTE_ADDR'];
		$req_plan = DB:: SQLToArray("SELECT * FROM plan WHERE id='$id_service' limit 1");
	mysql_query ("INSERT INTO `panel`.`commande` (
`id` ,
`id_client` ,
`number_cmd` ,
`id_service` ,
`cat_service` ,
`nbr_service` ,
`ip_client`
)
VALUES (
NULL , '', '".$facture_denriere."', '".$id_service."', '".$cat_service."', '1', '".$ip."'
)");
echo '
<link rel="stylesheet" type="text/css" href="pages/table_order.css">

<h1 qtlid="58734">Etape 1  - Commande du '.$req_plan[0]['nom'].' </h1>

<table style="margin-top: 10px; width: 80%; margin-left: 10%;  padding: 0;" class="price" cellpadding="3" cellspacing="1">

<tr class="price"><th class="left blue" qtlid="58833">Type de VPS</th>
<td qtlid="58844">'.$req_plan[0]['nom'].'</td></tr>


<tr class="light"><th class="bold blue left" qtlid="58855">Disque dur</th>
<td qtlid="12438">'.$req_plan[0]['dd_info'].'</td></tr>


<tr class="price"><th class="left blue" qtlid="58833">Mémoire vive </th>
<td qtlid="58844">'.$req_plan[0]['ram_info'].'</td></tr>

<tr class="light"><th class="bold blue left" qtlid="58855">Poceseur</th>
<td qtlid="12438">'.$req_plan[0]['proco_info'].'</td></tr>

<tr class="price"><th class="left blue" qtlid="58833">Connexion</th>
<td qtlid="58844">'.$req_plan[0]['connexion_info'].'</td></tr>

<tr class="light"><th class="bold blue left" qtlid="58855">Bande passante</th>
<td qtlid="12438">'.$req_plan[0]['bp_info'].'</td></tr>




</table><br />

<strong><center><a href="index.php?page=commande_etape_2&id='.$facture_denriere.'">Poursuivre ma commande</a></center></strong>';
$_SESSION['BC'] = $facture_denriere;
}

?>