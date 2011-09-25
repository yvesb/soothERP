<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK rel="stylesheet" type="text/css" href="themes/collab_fr/css/_resultats_commerciaux.css">
<title>Document sans titre</title>
<SCRIPT LANGUAGE="JavaScript">

function PopupCentrer(page,largeur,hauteur,optionsi) {
  var top=(screen.height-hauteur)/2;
  var left=(screen.width-largeur)/2;
  window.open(page,"","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+optionsi);
}
</SCRIPT>
</head>

<body>
<table cellpadding="0" border="0" cellspacing="0">
<tr>
	<?php 
foreach ($editions_modes as $edition_mode) {
	
	switch ($edition_mode->id_edition_mode) {
	
	//impression
	case "1":?>
	<td style="padding-right:10px">
	<a href="commande_client_editing_print.php?mode_edition=<?php echo $edition_mode->id_edition_mode;?>
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
	<?php 	if (isset($_REQUEST["impress"])) {echo "&impress=".$_REQUEST["impress"];}else{echo "&impress=1";}?>" target="mainediting" >
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" title="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" />	</a>
	</td>
	<?php
	break;
	
	//envois par email
case "2":?>
<td style="padding-right:10px">
<a href='javascript:PopupCentrer("commande_client_editing_email.php?
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
",580,450,"menubar=no,statusbar=no,scrollbars=yes,resizable=yes")' >
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-email.gif" alt="<?php echo htmlentities($edition_mode->lib_edition_mode);?>" title="<?php echo htmlentities($edition_mode->lib_edition_mode);?>" /> </a>
</td>
<?php
break;

	}
	
	
}

if (isset($liste_modeles_pdf_valides) && count($liste_modeles_pdf_valides)>1 ) {
	?>
	<td style="padding-right:10px">
	<form method="post" action="commande_client_editing.php?
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
	" id="change_code_pdf_modele" target="_top" >
	<select name="code_pdf_modele" onchange="document.getElementById('change_code_pdf_modele').submit();" >
	<?php
	foreach ($liste_modeles_pdf_valides as $modele_pdf) {
		?>
		<option value="<?php echo $modele_pdf->code_pdf_modele;?>" <?php 	if (isset($_REQUEST["code_pdf_modele"]) && $_REQUEST["code_pdf_modele"] == $modele_pdf->code_pdf_modele) {echo "selected='selected'";}?>><?php echo $modele_pdf->lib_modele;?></option>
		<?php
	}
	?>
	</select>
	</form>
	</td>
	<?php
}
 
?> 

				
	