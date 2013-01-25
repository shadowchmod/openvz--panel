<?php

class Plan
{
	public static function GetPlanList()
	{
		return DB::SqlToArray("SELECT * FROM plan");
	}
}

?>