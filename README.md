Ce panel a ete créé pour proxmox des 1er version, je dirais 1 à 1.5 de proxmox.

ce panel a servi dans les années 2000 pour de la production. cependant il comporte encore des bogues.

les modules à ce jour pour le paiement sont : allopass, moneybooker et paypal ( comportent tous des bogues et un niveau de sécurité critiques ). 

ce panel a été uploader dans l'état et donc il faudra 1h minimum pour faire marcher ce panel.

il faudra faire des tests pour les nouvelles versions de promox.

un module vnc a été ajouté. mais ne fonctionne pas.



j'ai pour but d'étendre le panel:
ajout de panneau de control pour openvpn
ajout de panneau pour transmission
ajout d'un panneau de control pour un proxy
systeme d'automatisation
fix des payements et d'en rajouter

debut de modification aout 2013 (aproximation)


pour toutes personnes souhaitant amméliorer ce panel
je vous prie de me contacter.

Merci.




Utilisation

ajouter votre mot de passe crypter md5 dans la table avant de l'ajouter dans votre base de donnée
SQL-file/table-SQL.sql
et modifier la ligne 113 et 114 : votre-mot-de-passe-crypter-md5
le login sera admin


dans  include/constante.php
ajoute de la ligne 7 a 10


ajouter le nom de votre base de donnée dans le fichier suivant : include/data/VPS.class.php
$nom_de_la_base_de_donnee = '';
