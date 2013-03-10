<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edition du document</title>
</head>



<frameset rows="104,*" frameborder="no" border="0" framespacing="0" >
	<!-- Barre de boutons -->
	<frame src="situation_commerciaux_result_editing_button.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["date_debut"])) {echo "&date_debut=".$_REQUEST["date_debut"];}else{echo "&date_debut=".date('Y');}?>
	<?php 	if (isset($_REQUEST["date_fin"])) {echo "&date_fin=".$_REQUEST["date_fin"];}else{echo "&date_fin=1";}?>
	<?php 	if (isset($_REQUEST["date_exercice"])) {echo "&date_exercice=".$_REQUEST["date_exercice"];}else{echo "&date_exercice=".date('Y');}?>
	<?php 	if (isset($_REQUEST["print"])) {echo "&print=".$_REQUEST["print"];}else{echo "&print=2";}?>
		" name="topediting" scrolling="no noresize="noresize" id="topediting" title="topediting" />
	<!-- page pdf -->
	<frame src="situation_commerciaux_result_editing_print.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["date_debut"])) {echo "&date_debut=".$_REQUEST["date_debut"];}else{echo "&date_debut=".date('Y');}?>
	<?php 	if (isset($_REQUEST["date_fin"])) {echo "&date_fin=".$_REQUEST["date_fin"];}else{echo "&date_fin=1";}?>
	<?php 	if (isset($_REQUEST["date_exercice"])) {echo "&date_exercice=".$_REQUEST["date_exercice"];}else{echo "&date_exercice=".date('Y');}?>
	<?php 	if (isset($_REQUEST["print"])) {echo "&print=".$_REQUEST["print"];}else{echo "&print=2";}?>
	" name="mainediting" id="mainediting" title="mainediting" />
</frameset>
<noframes><body>
</body>
</noframes></html>