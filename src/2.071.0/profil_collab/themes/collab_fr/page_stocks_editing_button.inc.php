<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Document sans titre</title>
<SCRIPT LANGUAGE="JavaScript">

function PopupCentrer(page,largeur,hauteur,optionsi) {
  var top=(screen.height-hauteur)/2;
  var left=(screen.width-largeur)/2;
  window.open(page,"","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+optionsi);
}
</SCRIPT>
<style type="text/css">
<!--
body {
margin: 5px;
}
img {
border:0px;
}
-->
</style>
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
	<a href="stocks_editing_print.php?mode_edition=<?php echo $edition_mode->id_edition_mode;?>&print=1
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["id_stocks"])) {echo "&id_stocks=".$_REQUEST["id_stocks"];}?>
	<?php 	if (isset($_REQUEST["aff_pa"])) {echo "&aff_pa=".$_REQUEST["aff_pa"];}?>
	<?php 	if (isset($_REQUEST["ref_constructeur"])) {echo "&ref_constructeur=".$_REQUEST["ref_constructeur"];}?>
	<?php 	if (isset($_REQUEST["ref_art_categ"])) {echo "&ref_art_categ=".$_REQUEST["ref_art_categ"];}?>
	<?php 	if (isset($_REQUEST['aff_info_tracab'])){echo "&aff_info_tracab=".$_REQUEST['aff_info_tracab'];}?>
	<?php 	if (isset($_REQUEST["in_stock"])) {echo "&in_stock=".$_REQUEST["in_stock"];}?>" target="mainediting" >
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" title="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" />	</a>
	</td>
	<?php
	break;
	
	

	}
	
	
}

if (isset($liste_modeles_pdf_valides) && count($liste_modeles_pdf_valides)>1 ) {
	?>
	<td style="padding-right:10px">
	<form method="post" action="stocks_editing.php?
		<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
		<?php 	if (isset($_REQUEST["id_stocks"])) {echo "&id_stocks=".$_REQUEST["id_stocks"];}?>
		<?php 	if (isset($_REQUEST["aff_pa"])) {echo "&aff_pa=".$_REQUEST["aff_pa"];}?>
		<?php 	if (isset($_REQUEST["ref_constructeur"])) {echo "&ref_constructeur=".$_REQUEST["ref_constructeur"];}?>
		<?php 	if (isset($_REQUEST["ref_art_categ"])) {echo "&ref_art_categ=".$_REQUEST["ref_art_categ"];}?>
		<?php 	if (isset($_REQUEST['aff_info_tracab'])){echo "&aff_info_tracab=".$_REQUEST['aff_info_tracab'];}?>
		<?php 	if (isset($_REQUEST["in_stock"])) {echo "&in_stock=".$_REQUEST["in_stock"];}?>
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


