<?php
    defined("INC") or die("403 restricted access");
	
		echo '
			<a href="index.php">< Retour au panneaux</a><br/><br/>';
		echo "<fieldset><legend><strong>Ajouter une ip</strong></legend>";

$error = 0;
$msg= "";
$succes = 0;

if(isset($_POST['add'])){
$ip = $_POST['ip'];
$reverse = $_POST['reverse'];

if($error == 0){
	if(!mysql_query("INSERT INTO ip (ip, reverse_original, dispo, id_server) VALUES('$ip', '$reverse', '1', '2')")){
		$error = 1;
		$msg .= "Erreur : Problème au niveau de la requête SQL <br />";
	}
	else
	$succes = 1;
}


}

if($succes == 1){
				echo '<p><center><b>IP Ajoutée</b></center>
				<br />
				<br />
				<META http-equiv="Refresh" content="2; URL=index.php?page=admin/gestion_ip">
				</p>';
}
else{
if($error != 0)
echo "<center>$msg</center>";

?>

 <form method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
	<table>
		<tr>
			<td>Adresse IP</td>
			<td><input type="text" name="ip" value="<?if(isset($_POST['ip'])) echo $_POST['ip'];?>"></td>
		</tr>
		<tr>
			<td>Reverse</td>
			<td><input type="text" name="reverse" value="<?if(isset($_POST['reverse'])) echo $_POST['reverse'];?>"></td>
		</tr>

	</table>
<center><input type="submit" name="add" value="Ajouter" /></center>
</form>
<?
}

?>
