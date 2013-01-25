<?php
	defined("INC") or die("403 restricted access");
	
	define("ADMIN_LOGIN","");		// user pour le panel
	define("ADMIN_PASS","");		// code pour le panel
	
	define("DB_HOST","localhost");
	define("DB_USER","user");
	define("DB_PASS","code");
	define("DB_BASE","nomdebase");
	
	define("LOGIN_MAX_TRY",3);
	define("LOGIN_NEXT_TRY",9);
	
	/** Login du server des VPS */
	define("VPS_ACCESS_HOST","ipdédier.com");
	define("VPS_ACCESS_USER","root");
	define("VPS_ACCESS_PASS","code");
	
	/** Définie si le mode debug est activé */
	define("DEBUG",0);
?>
