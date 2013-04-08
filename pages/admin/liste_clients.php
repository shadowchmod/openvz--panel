<?php
    defined("INC") or die("403 restricted access");
	
	
		echo '
			<a href="index.php">< Retour aux panneaux</a><br/><br/>';
		echo "
			<fieldset><legend><strong>Liste des clients</strong></legend>";
		
		$page=1;
		$sort=0;
		$parpage=25;
		if (isset($_GET["pagenum"]))
			$page=$_GET["pagenum"];
		if (isset($_GET["sort"]))
			$sort=$_GET["sort"];
		$clientcount=Client::GetClientCount();		
		$pagecount=ceil($clientcount/$parpage);
		if ($page>$pagecount)
			$page=$pagecount;
		?>
    <table width="100%" border="0">
      <tr class="tabletitle">
        <td><a href="index.php?page=admin/liste_clients&sort=0" class="tablelink">Id</a></td>
        <td><a href="index.php?page=admin/liste_clients&sort=1" class="tablelink">Nik-Handle</a></td>
        <td><a href="index.php?page=admin/liste_clients&sort=2" class="tablelink">Nom</a></td>
        <td><a href="index.php?page=admin/liste_clients&sort=3" class="tablelink">Prénom</a></td>
        <td><a href="index.php?page=admin/liste_clients&sort=4" class="tablelink">E-mail</a></td>
		<td><a href="index.php?page=admin/liste_clients&sort=5" class="tablelink">Status</a></td>
      </tr>
<?php
  		$clients = Client::GetClientList($page,$parpage,$sort);
		$i=0;
		foreach ($clients as $client)
		{
			$clientid=$client["id"];
			$clientnik=$client["nikhandle"];
			$clientnom=$client["nom"];
			$clientprenom=$client["prenom"];
			$clientmail=$client["email"];
			$clientetat=$client["etat"];
			if ($clientetat==1)
				$clientetat="ok";
			else
				$clientetat="bad";
			
			if ($i%2==0)
			{
				echo '
		<tr class="tableimpair">';
			}else{
				echo '
		<tr class="tablepair">';
			}
			
			$link="index.php?page=admin/detail_client&client=$clientid";
			echo "
			<td><a href=\"$link\" class=\"linkblack\">$clientid</a></td>
			<td><a href=\"$link\" class=\"linkblack\">$clientnik</a></td>
			<td><a href=\"$link\" class=\"linkblack\">$clientnom</a></td>
			<td><a href=\"$link\" class=\"linkblack\">$clientprenom</a></td>
			<td><a href=\"$link\" class=\"linkblack\">$clientmail</a></td>
			<td align=\"center\"><a href=\"$link\" class=\"linkblack\"><img src=\"images/$clientetat.png\" border=\"0\" /></a></td>
			
		  </tr>";
			$i++;
		}
		echo "</table>";

		echo "<center>";
		for ($i=1;$i<=$pagecount;$i++)
		{
			if ($i==$page)
				echo "<strong>$i</strong>&nbsp;";
			else
				echo "<a href=\"index.php?page=admin/liste_clients&sort=$sort&pagenum=$i\" class=\"tablelink\">$i</a>&nbsp;";
		}
		echo "</center>";
		
		/*echo '<select name="parpage" id="parpage" onSelect="javascript">
		<option value="25" selected="selected">25</option>
		<option value="50">50</option>
		<option value="100">100</option>
		</select>';*/
		
		echo "</fieldset>";
		
		echo '
			<script language="JavaScript" type="text/javascript">
				document.onkeydown = toucheEnfoncee;
				function toucheEnfoncee(e) 
				{
					if (e==null)
						e=window.event;
					if (e.keyCode==37 && '.$page.'>1)
						window.location.replace("index.php?page=admin/liste_clients&sort='.$sort.'&pagenum="+('.$page.'-1));
					if (e.keyCode==39 && '.$page.'<'.$pagecount.')
						window.location.replace("index.php?page=admin/liste_clients&sort='.$sort.'&pagenum="+('.$page.'+1));
				}
			</script>';
	  
	
?>
