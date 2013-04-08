<?php
    defined("INC") or die("403 restricted access");
	
		echo '
			<a href="index.php">< Retour aux panneaux</a><br/><br/>';
		echo "<fieldset><legend><strong>Gestions des plans</strong></legend>";

if(isset($_POST['supp'])){

mysql_query("DELETE FROM plan WHERE id='".$_POST['idsupp']."'");

}


// Liste des plans
$result = mysql_query("SELECT id, nom, ram_info, proco_info, connexion_info, bp_info FROM plan");

echo '<table width="100%">';
echo '<tr align="center"><td>Id</td><td>Nom</td><td>Ram</td><td>Processeur</td><td>Modifier</td><td>Supprimer</td></tr>';
while($res = mysql_fetch_array($result)){
	echo '<tr align="center">';
	echo '<td>'.$res['id'].'</td><td>'.$res['nom'].'</td><td>'.$res['ram_info'].'</td><td>'.$res['proco_info'].'</td>
	<td><a href="index.php?page=admin/modif_plan&id='.$res['id'].'">Modifier</a></td>
	<td><form method="POST" action="'.$_SERVER['REQUEST_URI'].'"><input type="hidden" name="idsupp" value="'.$res['id'].'" /><input type="submit" name="supp" value="Supprimer"></td>
	</tr>';
}
echo '</table>';

echo '<br /><center><a href="index.php?page=admin/add_plan">Ajouter un plan</a></center>';

?>
