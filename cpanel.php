<?php 
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>"; 
echo "<?xml-stylesheet type=\"text/xsl\" href=\"style.xsl\"?>"; 

# cpanel12 - createacct_example.php                Copyright(c) 1997-2009 cPanel, Inc. 
#                                                           All Rights Reserved. 
# copyright@cpanel.net                                         http://cpanel.net 

include("xmlapi.php.inc"); 

$ip = "";							// votre ip - ou nom de domaine
$user= "";							// votre user
$kh3us_pass = ""; 					// votre code d'acces

$xmlapi = new xmlapi($ip); 
$xmlapi->password_auth($user,$kh3us_pass); 

$xmlapi->set_debug(1); 

$acct = array( username => "souser", password => "code", domain => "thdomain.com"); 	// je ne c'est pas ceux que c'est
print $xmlapi->createacct($acct); 
?>
