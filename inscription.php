<?php
define("INC",1);
// Inclut toutes les sources du dossier inclut
require("include/all.php");
// Initialise la base de donn�e
$active=DB::Init();

if ( isset ( $_GET["page"] ) )
{
          $var = $_SERVER["REQUEST_URI"];
     }
else
{
          $var = "/index.php";
}

$var_encoer = rawurlencode($var);
// Si on appelle la page action alors on l'inclut avant pour pouvoir utiliser les header("Location: ...")
if (@$_GET['page']=="action")
{
include("pages/action.php");
}else{

include('pages/entete.php');

// on ajoute la page inscription 
include('pages/inscription.php');

include('pages/piedpage.php');
}
?>
