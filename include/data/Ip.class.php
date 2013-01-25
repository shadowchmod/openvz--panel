<?php

class Ip
{
	public static function GetIpDispoList()
	{
		return DB::SqlToArray("SELECT * FROM ip WHERE dispo=1");
	}
	
	public static function BlockIP($ipid,$serverid)
	{
		$ipid=ProtectSQL($ipid);
		$serverid=ProtectSQL($serverid);
		$requete = "UPDATE ip SET dispo=0, id_server=$serverid WHERE id=$ipid LIMIT 1";
				
		if (DB::Sql($requete))
		{
      $infoip=DB::SqlToArray("SELECT * FROM ip WHERE id=$ipid LIMIT 1");
      //On s'occupe du vmid vpsXXXX.cmd-web.info
      $supp = array("vps", ".your-domaine.fr");
      $vmid=str_replace($supp,"",$infoip[0]['reverse_original']);
      $vmid=intval($vmid);
			return $vmid;
		}else{
			return false;
		}
	}
}

?>
