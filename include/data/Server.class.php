<?php

class Server
{
	public static function GetServerList()
	{
		return DB::SqlToArray("SELECT * FROM serveur");
	}
}

?>