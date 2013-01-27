<?php
    defined("INC") or die("403 restricted access");
	
		echo '
			<a href="index.php">< Retour au panneau</a><br/><br/>';
		echo "<fieldset><legend><strong>Gestions des plans</strong></legend>";

if(isset($_POST['supp'])){

//mysql_query("DELETE FROM ip WHERE id='".$_POST['idsupp']."'");

}
?>

<script>
function confirmation(){
    choix = confirm("Êtes-vous sûr de vouloir supprimer ?");
    if (choix == true)
      {
      document.formulaire.submit();
      }
    else
      {
      return false;
      }
}

</script>

<?

// Liste des plans
$result = mysql_query("SELECT id, ip, reverse_original, dispo FROM ip ORDER BY ip");

echo '<center>
<b>IP Disponibles :</b> '.mysql_num_rows(mysql_query('SELECT id FROM ip WHERE dispo="1"')).'<br />
<b>IP Utilisées :</b> '.mysql_num_rows(mysql_query('SELECT id FROM ip WHERE dispo="0"')).'<br />
<b>IP Totale :</b> '.mysql_num_rows(mysql_query('SELECT id FROM ip')).'<br /><br />

</center>';

echo '<table width="100%">';
echo '<tr align="center"><td><b>IP</b></td><td><b>Reverse</b></td><td><b>Dispo</b></td><td><b>Supprimer</b></td></tr>';
while($res = mysql_fetch_array($result)){
	if($res['dispo'] == 0)
		$dispo = "Non";
	else
		$dispo = "Oui";

	echo '<tr align="center">';
	echo '<td>'.$res['ip'].'</td><td>'.$res['reverse_original'].'</td><td>'.$dispo.'</td></td><td><form method="POST" action="'.$_SERVER['REQUEST_URI'].'" onSubmit="return confirmation();"><input type="hidden" name="idsupp" value="'.$res['id'].'" /><input type="submit" name="supp" value="Supprimer"></td>
	</tr>';
}
echo '</table>';

echo '<br /><center><a href="index.php?page=admin/add_ip">Ajouter une ip</a></center>';

?>