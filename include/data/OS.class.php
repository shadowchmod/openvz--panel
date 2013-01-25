<?php

class OS
{
	public static function GetOS($id)
	{
		$osarray=DB::SqlToArray("SELECT * FROM os WHERE `id`=$id");	
		if (count($osarray)==1)
			return $osarray[0];
	}
	
	public static function GetOSList()
	{
		return DB::SqlToArray("SELECT id,nom_os,etat FROM os WHERE etat=1");		
	}
}

?>