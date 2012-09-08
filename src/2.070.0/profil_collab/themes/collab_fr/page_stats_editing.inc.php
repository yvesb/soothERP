<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edition du document</title>
</head>

<?php 
//Test date_fin - date_debut <= 12mois
if(isset($_REQUEST["annee_date_fin"]) && isset($_REQUEST["annee_date_deb"]) && isset($_REQUEST["mois_date_fin"]) && isset($_REQUEST["mois_date_deb"])){
	if($_REQUEST["annee_date_fin"]-$_REQUEST["annee_date_deb"]>1){
		if($_REQUEST["mois_date_fin"]!=12){
			$_REQUEST["annee_date_deb"]=$_REQUEST["annee_date_fin"]-1;
			$_REQUEST["mois_date_deb"]=$_REQUEST["mois_date_fin"]+1;
		}else{
			$_REQUEST["annee_date_deb"]=$_REQUEST["annee_date_fin"];
			$_REQUEST["mois_date_deb"]=1;
		}
	}else if($_REQUEST["annee_date_fin"]-$_REQUEST["annee_date_deb"]==1){
		if($_REQUEST["mois_date_fin"]==12){
			$_REQUEST["annee_date_deb"]=$_REQUEST["annee_date_fin"];
			$_REQUEST["mois_date_deb"]=1;
		}else if($_REQUEST["mois_date_deb"]<=$_REQUEST["mois_date_fin"]){
			$_REQUEST["mois_date_deb"]=$_REQUEST["mois_date_fin"]+1;
		}
		
	}
}
?>

<frameset rows="52,*" frameborder="no" border="0" framespacing="0" >
	<!-- Barre de boutons -->
	<frame src="stats_editing_button.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["annee_date_deb"])) {echo "&annee_date_deb=".$_REQUEST["annee_date_deb"];}else{echo "&annee_date_deb=".date('Y');}?>
	<?php 	if (isset($_REQUEST["mois_date_deb"])) {echo "&mois_date_deb=".$_REQUEST["mois_date_deb"];}else{echo "&mois_date_deb=1";}?>
	<?php 	if (isset($_REQUEST["annee_date_fin"])) {echo "&annee_date_fin=".$_REQUEST["annee_date_fin"];}else{echo "&annee_date_fin=".date('Y');}?>
	<?php 	if (isset($_REQUEST["mois_date_fin"])) {echo "&mois_date_fin=".$_REQUEST["mois_date_fin"];}else{echo "&mois_date_fin=12";}?>
		" name="topediting" scrolling="no noresize="noresize" id="topediting" title="topediting" />
	<!-- page pdf -->
	<frame src="stats_editing_print.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["annee_date_deb"])) {echo "&annee_date_deb=".$_REQUEST["annee_date_deb"];}else{echo "&annee_date_deb=".date('Y');}?>
	<?php 	if (isset($_REQUEST["mois_date_deb"])) {echo "&mois_date_deb=".$_REQUEST["mois_date_deb"];}else{echo "&mois_date_deb=1";}?>
	<?php 	if (isset($_REQUEST["annee_date_fin"])) {echo "&annee_date_fin=".$_REQUEST["annee_date_fin"];}else{echo "&annee_date_fin=".date('Y');}?>
	<?php 	if (isset($_REQUEST["mois_date_fin"])) {echo "&mois_date_fin=".$_REQUEST["mois_date_fin"];}else{echo "&mois_date_fin=12";}?>
	" name="mainediting" id="mainediting" title="mainediting" />
</frameset>
<noframes><body>
</body>
</noframes></html>