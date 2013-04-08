<?php
    defined("INC") or die("403 restricted access");
	
	
		echo '
			<a href="index.php">< Retour au panneaux</a><br/><br/>';
		echo "
			<fieldset><legend><strong>Liste des VPS</strong></legend>";
		
		$page=1;
		$sort=0;
		$parpage=25;
		if (isset($_GET["pagenum"]))
			$page=$_GET["pagenum"];
		if (isset($_GET["sort"]))
			$sort=$_GET["sort"];
		$vpscount=VPS::GetVPSCount();
		$pagecount=ceil($vpscount/$parpage);
		if ($page>$pagecount)
			$page=$pagecount;
		?>
    <table width="100%" border="0">
      <tr class="tabletitle">
        <td><a href="index.php?page=admin/liste_vps&sort=0" class="tablelink">Id</a></td>
        <td><a href="index.php?page=admin/liste_vps&sort=1" class="tablelink">IP</a></td>
        <td><a href="index.php?page=admin/liste_vps&sort=2" class="tablelink">DNS</a></td>
        <td><a href="index.php?page=admin/liste_vps&sort=3" class="tablelink">OS</a></td>
        <td><a href="index.php?page=admin/liste_vps&sort=4" class="tablelink">Plan</a></td>
      <td><a href="index.php?page=admin/liste_vps&sort=5" class="tablelink">Status</a></td>
      <td><a href="index.php?page=admin/liste_vps&sort=6" class="tablelink">Etat</a></td>
	  <td>Etat</td>
      </tr>
<?php
  		$listevps = VPS::GetVPSList($page,$parpage,$sort);
		$i=0;
		foreach ($listevps as $vps)
		{
			$vpsid=$vps["id"];
			$vpsip=$vps["ip"];
			$vpsdns=$vps["reverse_original"];
			$vpsos=$vps["nom_os"];
			$vpsplan=$vps["nom"];
			$vpsetat=$vps["etat"];
			$vpsstatus=$vps["status"];
			if ($vpsstatus==1){
				$vpsstatus="vert";
			}else{
        if($vpsstatus==2){
          $vpsstatus="orange";
        }else{			
          $vpsstatus="rouge";
        }
			}
			
			if($vpsetat==1){
        $vpsetat="ok";
			}else{
        $vpsetat="bad";
			}
//			print_r($vps);
			if ($i%2==0)
			{
				echo '
		<tr class="tableimpair">';
			}else{
				echo '
		<tr class="tablepair">';
			}
			
			$link="index.php?page=admin/detail_vps&amp;vps=$vpsid";
			echo "
			<td><a href=\"$link\" class=\"linkblack\">$vpsid</a></td>
			<td><a href=\"$link\" class=\"linkblack\">$vpsip</a></td>
			<td><a href=\"$link\" class=\"linkblack\">$vpsdns</a></td>
			<td><a href=\"$link\" class=\"linkblack\">$vpsos</a></td>
			<td><a href=\"$link\" class=\"linkblack\">$vpsplan</a></td>
			<td align=\"center\"><a href=\"$link\" class=\"linkblack\"><img src=\"images/feux_$vpsstatus.png\" border=\"0\" /></a></td>
			<td align=\"center\"><a href=\"$link\" class=\"linkblack\"><img src=\"images/$vpsetat.png\" border=\"0\" /></a></td>
			<td align=\"center\"><a href=\"index.php?page=admin/edit_vps&id=".$vpsid."\" class=\"linkblack\">Editer</a></td>
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
				echo "<a href=\"index.php?page=admin/liste_vps&amp;sort=$sort&amp;pagenum=$i\" class=\"tablelink\">$i</a>&nbsp;";
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
						window.location.replace("index.php?page=admin/liste_vps&sort='.$sort.'&pagenum="+('.$page.'-1));
					if (e.keyCode==39 && '.$page.'<'.$pagecount.')
						window.location.replace("index.php?page=admin/liste_vps&sort='.$sort.'&pagenum="+('.$page.'+1));
				}
			</script>';
	
?>
