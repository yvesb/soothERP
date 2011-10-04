<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edition du document</title>
</head>


<frameset rows="52,*" frameborder="no" border="0" framespacing="0" >
	<!-- Barre de boutons -->
	<frame src="stocks_editing_button.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["id_stocks"])) {echo "&id_stocks=".$_REQUEST["id_stocks"];}?>
	<?php 	if (isset($_REQUEST["aff_pa"])) {echo "&aff_pa=".$_REQUEST["aff_pa"];}?>
	<?php 	if (isset($_REQUEST["ref_constructeur"])) {echo "&ref_constructeur=".$_REQUEST["ref_constructeur"];}?>
	<?php 	if (isset($_REQUEST["ref_art_categ"])) {echo "&ref_art_categ=".$_REQUEST["ref_art_categ"];}?>
	<?php 	if (isset($_REQUEST['aff_info_tracab'])){echo "&aff_info_tracab=".$_REQUEST['aff_info_tracab'];}?>
	<?php 	if (isset($_REQUEST["in_stock"])) {echo "&in_stock=".$_REQUEST["in_stock"];}?>
	
	" name="topediting" scrolling="no noresize="noresize" id="topediting" title="topediting" />
	<!-- page pdf -->
	<frame src="stocks_editing_print.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["id_stocks"])) {echo "&id_stocks=".$_REQUEST["id_stocks"];}?>
	<?php 	if (isset($_REQUEST["aff_pa"])) {echo "&aff_pa=".$_REQUEST["aff_pa"];}?>
	<?php 	if (isset($_REQUEST["ref_constructeur"])) {echo "&ref_constructeur=".$_REQUEST["ref_constructeur"];}?>
	<?php 	if (isset($_REQUEST["ref_art_categ"])) {echo "&ref_art_categ=".$_REQUEST["ref_art_categ"];}?>
	<?php 	if (isset($_REQUEST['aff_info_tracab'])){echo "&aff_info_tracab=".$_REQUEST['aff_info_tracab'];}?>
	<?php 	if (isset($_REQUEST["in_stock"])) {echo "&in_stock=".$_REQUEST["in_stock"];}?>
	
	" name="mainediting" id="mainediting" title="mainediting" />
</frameset>
<noframes><body>
</body>
</noframes></html>
