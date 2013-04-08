<?

    defined("INC") or die("403 restricted access");
    echo '<a href="index.php">< Retour aux panneaux</a><br/><br/>';

		echo "<fieldset><legend><strong>Panneau d'administration</strong></legend>";
		$req_warning = mysql_query("SELECT * FROM warning ORDER by time LIMIT 0,50");
		
		echo '<table width="100%" border="1">
		<tr align="center">
		
			<td><b>Id - Type</b></td>
			<td><b>Ip</b></td>
			<td><b>Date</b></td>
			<td><b>Type Warning</b></td>
			<td><b>Message</b></td>
		</tr>';
		while ( $sql_warning = mysql_fetch_array($req_warning))
		{
		echo '<tr>
					<td>';
			if ( $sql_warning['TYPE_W'] == "CLIENT" )
			{
			$id_cleint = $sql_warning['id_client'];
					if ( $id_cleint == "0" )
					{
					echo "Guest - ";
					}
					else
					{
					echo '<a href="index.php?page=admin/detail_client&client='.$sql_warning['id_client'].'">'.$sql_warning['id_client'].'</a> - ';
					}
			
		
			}
			elseif ( $sql_warning['TYPE_W'] == "VPS" )
			{
			$id = $sql_warning['id_client'];
			$req_plan = DB:: SQLToArray("SELECT * FROM vps WHERE vmid='$id' ") or die(mysql_error());
			$iddd = $req_plan[0]['id'];
			echo '<a href="index.php?page=admin/edit_vps&id='.$iddd .'">'.$sql_warning['id_client'].'</a> - ';
			}
			else
			{
			echo ''.$sql_warning['id_client'].' - ';
			}
			
			
			echo ''.$sql_warning['TYPE_W'].' </td>
			<td>'.$sql_warning['ip'].'</td>
			<td>'.date('d/m/y H:i:s', $sql_warning['time']).'</td>
			<td>'.$sql_warning['type'].'</td>
			<td>'.$sql_warning['message'].'</td>
		</tr>';
		}
echo '  </table> 

	</fieldset>';
		
	

?>
