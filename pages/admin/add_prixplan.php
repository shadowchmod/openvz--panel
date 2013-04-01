<?php
    defined("INC") or die("403 restricted access");
	
		echo '
			<a href="index.php">< Retour au panneaux</a><br/><br/>';
		echo "<fieldset><legend><strong>Modification d'un plan</strong></legend>";

if(isset($_GET['id'])){
$requete = "SELECT id FROM plan WHERE id = '".$_GET['id']."'";
$query = mysql_query($requete);
}
$error = 0;
$msg= "";

if(isset($_GET['id']) && is_numeric($_GET['id']) && (mysql_num_rows($query) == 1)){
$error = 0;
$msg= "";
$succes = 0;

if(isset($_POST['add'])){
$nbjour = $_POST['nbjour'];
$jour = $_POST['jour'];
$prix = $_POST['prix'];

if(!is_numeric($nbjour)){
	$error = 1;
	$msg .= "Jour doit être un nombre <br />";
}
if(!is_numeric($prix)){
	$error = 1;
	$msg .= "Prix doit être un nombre <br />";
}


if($error == 0){
	$jourtime = $nbjour * 24 * 60 * 60;
	if(!mysql_query("INSERT INTO prix_service (service_type, service_id, jour_time, jour_nbr, jour_texte, prix) VALUES('VPS', '".$_GET['id']."', '$jourtime', '$nbjour', '$jour', '$prix')")){
		$error = 1;
		$msg .= "Erreur : Problème au niveau de la requête SQL <br />";
	}
	else
	$succes = 1;
}


}

if($succes == 1){
				echo '<p><center><b>Prix Ajouté</b></center>
				<br />
				<br />
				<META http-equiv="Refresh" content="2; URL=index.php?page=admin/modif_plan&id='.$_GET['id'].'">
				</p>';
}
else{
if($error != 0)
echo "<center>$msg</center>";

?>


 <form method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
	<table>
		<tr>
			<td>Nombre de Jours</td>
			<td><input type="text" name="nbjour" value="<?if(isset($_POST['nbjour'])) echo $_POST['nbjour'];?>"></td>
		</tr>
		<tr>
			<td>Nombre de Jours (Textuelle)</td>
			<td><input type="text" name="jour" value="<?if(isset($_POST['ram'])) echo $_POST['jour'];?>"></td>
		</tr>
		<tr>
			<td>Prix</td>
			<td><input type="text" name="prix" value="<?if(isset($_POST['prix'])) echo $_POST['prix'];?>"></td>
		</tr>
	</table>
<center><input type="submit" name="add" value="Ajouter" /></center>
</form>

<?
}
}
else{
	echo "Erreur : Plan inexistant";
}

?>
