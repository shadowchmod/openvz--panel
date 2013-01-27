<?php
    defined("INC") or die("403 restricted access");
	
		echo "<fieldset><legend><strong>Panneau d'administration</strong></legend>";

$date_today=date('d/m/y');
$moi_today=date('m/y');
$i=0;
$ii=0;
		$req = mysql_query("SELECT * FROM payement");	
while ($sql = mysql_fetch_array($req))	
{
$date=$sql['date'];
$datee=date('d/m/y', $date);
$mois=date('m/y', $date);
	if ( $datee == $date_today )
	{
	$i+=$date=$sql['montant'];
	}
	
	if ( $mois == $moi_today )
	{
	$ii+=$date=$sql['montant'];
	}
	

}
$iii=0;
$req_vps = mysql_query("SELECT * FROM vps WHERE id_plan='1' ");
while ($sql_vps = mysql_fetch_array($req_vps))
{
$iii++;
}

$iiii=0;
$req_vps = mysql_query("SELECT * FROM vps WHERE id_plan='2' ");
while ($sql_vps = mysql_fetch_array($req_vps))
{
$iiii++;
}

$iiiii=0;
$req_vps = mysql_query("SELECT * FROM vps WHERE id_plan='3' ");
while ($sql_vps = mysql_fetch_array($req_vps))
{
$iiiii++;
}

$iiiiii=0;
$req_vps = mysql_query("SELECT * FROM vps  ");
while ($sql_vps = mysql_fetch_array($req_vps))
{
$iiiiii++;
}

$c=0;
$req_client = mysql_query("SELECT * FROM client  ");
while ($sql_client = mysql_fetch_array($req_client))
{
$c++;
}
?>

<center><strong>Today : <?=$i?>€ - This month : <?=$ii?>€<br/><br/>
VPS 0 : <?=$iii?> - VPS 1 : <?=$iiii?> - VPS 2 : <?=$iiiii?> - Total des VPS : <?=$iiiiii?><br /><br/>
Client : <?=$c?>
</strong></center>
<table width="100%" border="0" cellpadding="10">
  <tr>
  	<td width="33%" align="center" valign="middle">
    	<a href="index.php?page=admin/ajouter_client">
        	<img src="images/adduser.png" width="56" height="56" border="0" /><br />
		   	Ajouter un client
		</a>
    </td>
    <td width="33%" align="center" valign="middle">
    	<a href="index.php?page=admin/liste_clients">
        	<img src="images/users.png" width="56" height="56" border="0" /><br />
		   	Liste des clients
		</a>
    </td>
    <td width="33%" align="center" valign="middle">
    	<a href="index.php?page=admin/ajouter_vps">
        	<img src="images/addvps.png" width="56" height="56" border="0" /><br />
		   	Ajouter VPS
		</a>
    </td>
  </tr>
  
  <tr>

    <td width="33%" align="center" valign="middle">
		<a href="index.php?page=admin/liste_vps">
        	<img src="images/vps.png" width="56" height="56" border="0" /><br />
		   	Liste VPS
		</a>
	</td>
  <td width="33%" align="center" valign="middle">
    	<a href="index.php?page=admin/admin_tache">
        	<img src="images/korganizer-todo-icone-6083-64.png" width="56" height="56" border="0" /><br />
			<?
		$count=0;
		$reponse = mysql_query("SELECT * FROM tache_admin WHERE etat='1' "); // Requête SQL
			while ($sql = mysql_fetch_array($reponse) )
								{
								$count+=1;
								}
								?>
   	  Liste des taches  (<?=$count;?>)</a>
    </td>
    <td width="33%" align="center" valign="middle">
		<a href="index.php?page=admin/mes_ticket">
		<?
		$count=0;
		$reponse = mysql_query("SELECT * FROM ticket WHERE etat='5' "); // Requête SQL
			while ($sql = mysql_fetch_array($reponse) )
								{
								$count+=1;
								}
								?>
        	<img src="images/casque-radio-soutien-voicecall-icone-6111-48.png" width="56" height="56" border="0" /><br />
   	  Ticket (<?=$count;?>)</a>
	  </td>
  </tr>
  
  
  <tr>
    <td width="33%" align="center" valign="middle">
    	<a href="index.php?page=admin/facture">
        	<img src="images/facture-icone-7188-64.png" width="56" height="56" border="0" /><br />
   	 Factures</a>
    </td>
    <td width="33%" align="center" valign="middle">
		<a href="index.php?page=admin/create_invoice">
		        	<img src="images/dossier-manille-nouvelles-icone-9149-64.png" width="56" height="56" border="0" /><br />
   	  Crée une facture</a>
	  </td>
	  <td width="33%" align="center" valign="middle">
    	<a href="index.php?page=admin/add_payement">
        	<img src="images/daffaires-monnaies-dolar-metal-argent-paiement-icone-3854-64.png" width="56" height="56" border="0" /><br />
   	Ajouter un payement</a>
   	</tr>
   	<tr>
    <td width="33%" align="center" valign="middle">
    	<a href="index.php?page=admin/gestion_plan">
        	<img src="images/plan.png" width="56" height="56" border="0" /><br />
   	Gestion des plans</a>
    </td>
    <td width="33%" align="center" valign="middle">
    	<a href="index.php?page=admin/gestion_ip">
        	<img src="images/ip.png" width="56" height="56" border="0" /><br />
   	Gestion des IP</a>
    <td width="33%" align="center" valign="middle">
    	<a href="index.php?page=admin/warning">
        	<img src="images/avertissement-icone-9768-64.png" width="56" height="56" border="0" /><br />
   	Historique des alertes</a>

  </tr>

  
  

 
</table>
<?php
		echo "</fieldset>";

?>