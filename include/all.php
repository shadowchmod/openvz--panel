<?php
	setlocale(LC_TIME, 'fr_FR', 'FR');
	require_once("constante.php");
	require_once("fonctions.php");	
	require_once("fonctions_vps.php");	
	require_once("fonctions_messagerie.php");	

	require_once("data/Client.class.php");
	
	require_once("Sessions.class.php");
	require_once("SQL.class.php");
	
	require_once("data/VPS.class.php");
	require_once("data/OS.class.php");
	require_once("data/Plan.class.php");
	require_once("data/Server.class.php");
	require_once("data/Ip.class.php");
	require_once("data/Messagerie.class.php");
	
	defined("INC") or die("403 restricted access");
?>