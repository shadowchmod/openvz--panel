<?
    defined("INC") or die("403 restricted access");
    echo '<a href="index.php"> Retour aux panneau</a><br/><br/>';

if ( isset ( $_GET['modif'] ) )
{
	if ( $_GET['modif'] == "OK" )
	{
	$id = $_GET['id'];
	mysql_query("UPDATE tache_admin SET etat='2' WHERE id='$id'");
	}
}
echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>ID</td>
								<td>Date</td>
								<td>Sujet</td>
								
								<td>Texte</td>
								<td>CMD</td>
								
								
								
								</tr>';
								
						$i=0;		
						$tache_admin_req = mysql_query("SELECT * FROM tache_admin WHERE etat='1' ");
						while ($rep_message = mysql_fetch_array($tache_admin_req) )
						{
									if ($i%2==0)
									{
									echo '
									<tr class="tableimpair">';
									}else{
									echo '
								<tr class="tablepair">';
									}
									
									echo '<td>'.$rep_message['id'].'</td>
								<td>'.date('d/m/Y - H:i:s', $rep_message['date']).'</td>
								<td>'.$rep_message['sujet'].'</td>
								
								<td>'.$rep_message['texte'].'</td>
							<td><a href="index.php?page=admin/admin_tache&id='.$rep_message['id'].'&modif=OK">Effectuer ?</a></td>
								
								
								</tr>';

						}
						
						echo '</table>';

?>
