<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edition du document</title>
</head>



<frameset rows="52,*" frameborder="no" border="0" framespacing="0" >
	<!-- Barre de boutons -->
	<frame src="commande_client_editing_button.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["id_name_mag"])) {echo "&id_name_mag=".$_REQUEST["id_name_mag"];}else{echo "&id_name_mag=''";}?>
	<?php 	if (isset($_REQUEST["ref_fournisseur"])) {echo "&ref_fournisseur=".$_REQUEST["ref_fournisseur"];}else{echo "&ref_fournisseur=''";}?>
	<?php 	if (isset($_REQUEST["ref_client"])) {echo "&ref_client=".$_REQUEST["ref_client"];}else{echo "&ref_client=''";}?>
	<?php 	if (isset($_REQUEST["ref_constructeur"])) {echo "&ref_constructeur=".$_REQUEST["ref_constructeur"];}else{echo "&ref_constructeur=''";}?>
	<?php 	if (isset($_REQUEST["id_name_categ_art"])) {echo "&id_name_categ_art=".$_REQUEST["id_name_categ_art"];}else{echo "&id_name_categ_art=''";}?>
	<?php 	if (isset($_REQUEST["id_name_stock"])) {echo "&id_name_stock=".$_REQUEST["id_name_stock"];}else{echo "&id_name_stock=''";}?>
	<?php 	if (isset($_REQUEST["id_type_doc"])) {echo "&id_type_doc=".$_REQUEST["id_type_doc"];}else{echo "&id_type_doc=''";}?>
	<?php 	if (isset($_REQUEST["page_to_show"])) {echo "&page_to_show=".$_REQUEST["page_to_show"];}?>
	<?php 	if (isset($_REQUEST["cmdeavalid"])) {echo "&cmdeavalid=".$_REQUEST["cmdeavalid"];}else{echo "&cmdeavalid='0'";}?>
	<?php 	if (isset($_REQUEST["cmdeaprep"])) {echo "&cmdeaprep=".$_REQUEST["cmdeaprep"];}else{echo "&cmdeaprep='0'";}?>
	<?php 	if (isset($_REQUEST["cmderetard"])) {echo "&cmderetard=".$_REQUEST["cmderetard"];}else{echo "&cmderetard='0'";}?>
	<?php 	if (isset($_REQUEST["cmderec"])) {echo "&cmderec=".$_REQUEST["cmderec"];}else{echo "&cmderec='0'";}?>
	<?php 	if (isset($_REQUEST["cmdecours"])) {echo "&cmdecours=".$_REQUEST["cmdecours"];}else{echo "&cmdecours='0'";}?>
		" name="topediting" scrolling="no noresize="noresize" id="topediting" title="topediting" />
	<!-- page pdf -->
	<frame src="commande_client_editing_print.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["id_name_mag"])) {echo "&id_name_mag=".$_REQUEST["id_name_mag"];}else{echo "&id_name_mag=''";}?>
	<?php 	if (isset($_REQUEST["ref_fournisseur"])) {echo "&ref_fournisseur=".$_REQUEST["ref_fournisseur"];}else{echo "&ref_fournisseur=''";}?>
	<?php 	if (isset($_REQUEST["ref_client"])) {echo "&ref_client=".$_REQUEST["ref_client"];}else{echo "&ref_client=''";}?>
	<?php 	if (isset($_REQUEST["ref_constructeur"])) {echo "&ref_constructeur=".$_REQUEST["ref_constructeur"];}else{echo "&ref_constructeur=''";}?>
	<?php 	if (isset($_REQUEST["id_name_categ_art"])) {echo "&id_name_categ_art=".$_REQUEST["id_name_categ_art"];}else{echo "&id_name_categ_art=''";}?>
	<?php 	if (isset($_REQUEST["id_name_stock"])) {echo "&id_name_stock=".$_REQUEST["id_name_stock"];}else{echo "&id_name_stock=''";}?>
	<?php 	if (isset($_REQUEST["id_type_doc"])) {echo "&id_type_doc=".$_REQUEST["id_type_doc"];}else{echo "&id_type_doc=''";}?>
	<?php 	if (isset($_REQUEST["page_to_show"])) {echo "&page_to_show=".$_REQUEST["page_to_show"];}?>
	<?php 	if (isset($_REQUEST["cmdeavalid"])) {echo "&cmdeavalid=".$_REQUEST["cmdeavalid"];}else{echo "&cmdeavalid='0'";}?>
	<?php 	if (isset($_REQUEST["cmdeaprep"])) {echo "&cmdeaprep=".$_REQUEST["cmdeaprep"];}else{echo "&cmdeaprep='0'";}?>
	<?php 	if (isset($_REQUEST["cmderetard"])) {echo "&cmderetard=".$_REQUEST["cmderetard"];}else{echo "&cmderetard='0'";}?>
	<?php 	if (isset($_REQUEST["cmderec"])) {echo "&cmderec=".$_REQUEST["cmderec"];}else{echo "&cmderec='0'";}?>
	<?php 	if (isset($_REQUEST["cmdecours"])) {echo "&cmdecours=".$_REQUEST["cmdecours"];}else{echo "&cmdecours='0'";}?>
	" name="mainediting" id="mainediting" title="mainediting" />
</frameset>
<noframes><body>
</body>
</noframes></html>