<?php
$date = date_Fr_to_Us($_REQUEST['collab_date_naissance']);
$infos_profils[$id_profil]['numero_secu'] 				=  $_REQUEST['collab_numero_secu'];
$infos_profils[$id_profil]['date_naissance'] 			=  $date;
$infos_profils[$id_profil]['lieu_naissance'] 			=  $_REQUEST['collab_lieu_naissance'];
$infos_profils[$id_profil]['id_pays_nationalite'] 		=  $_REQUEST['collab_id_pays'];
$infos_profils[$id_profil]['situation_famille'] 		=  $_REQUEST['collab_situation_famille'];
$infos_profils[$id_profil]['nbre_enfants'] 				=  $_REQUEST['collab_nbre_enfants'];
if(isset($_REQUEST['chk_agenda_collab'])){
	$infos_profils[$id_profil]['chk_agenda_collab'] 	=  "on";
}
else{
	$infos_profils[$id_profil]['chk_agenda_collab'] 	=  "off";
}
if(isset($_REQUEST['chk_messagerie_collab'])){
	$infos_profils[$id_profil]['chk_messagerie_collab'] =  "on";
}
else{
	$infos_profils[$id_profil]['chk_messagerie_collab'] =  "off";
}
if(isset($_REQUEST['chk_creer_agenda'])){
	$infos_profils[$id_profil]['chk_creer_agenda'] 	=  "on";
}
else{
	$infos_profils[$id_profil]['chk_creer_agenda'] 	=  "off";
}
if(isset($_REQUEST['chk_creer_messagerie'])){
	$infos_profils[$id_profil]['chk_creer_messagerie'] =  "on";
}
else{
	$infos_profils[$id_profil]['chk_creer_messagerie'] =  "off";
}
?>