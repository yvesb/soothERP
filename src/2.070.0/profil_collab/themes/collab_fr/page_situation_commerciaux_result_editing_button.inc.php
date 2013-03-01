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
	<a href="situation_commerciaux_result_editing_print.php?mode_edition=<?php echo $edition_mode->id_edition_mode;?>&print=2
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["date_debut"])) {echo "&date_debut=".$_REQUEST["date_debut"];}else{echo "&date_debut=".date('Y');}?>
	<?php 	if (isset($_REQUEST["date_fin"])) {echo "&date_fin=".$_REQUEST["date_fin"];}else{echo "&date_fin=1";}?>
	<?php 	if (isset($_REQUEST["date_exercice"])) {echo "&date_exercice=".$_REQUEST["date_exercice"];}else{echo "&date_exercice=".date('Y');}?>
	<?php 	if (isset($_REQUEST["impress"])) {echo "&impress=".$_REQUEST["impress"];}else{echo "&impress=1";}?>" target="mainediting" >
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" title="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" />	</a>
	</td>
	<?php
	break;
	
	//envois par email
case "2":?>
<td style="padding-right:10px">
<a href='javascript:PopupCentrer("situation_commerciaux_result_editing_email.php?
<?php if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
<?php if (isset($_REQUEST["date_debut"])) {echo "&date_debut=".$_REQUEST["date_debut"];}else{echo "&date_debut=".date('Y');}?>
<?php if (isset($_REQUEST["date_fin"])) {echo "&date_fin=".$_REQUEST["date_fin"];}else{echo "&date_fin=1";}?>
<?php if (isset($_REQUEST["date_exercice"])) {echo "&date_exercice=".$_REQUEST["date_exercice"];}else{echo "&date_exercice=".date('Y');}?>
<?php 	if (isset($_REQUEST["print"])) {echo "&print=".$_REQUEST["print"];}else{echo "&print=2";}?>
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
	<form method="post" action="situation_commerciaux_result_editing.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["date_debut"])) {echo "&date_debut=".$_REQUEST["date_debut"];}else{echo "&date_debut=".date('Y');}?>
	<?php 	if (isset($_REQUEST["date_fin"])) {echo "&date_fin=".$_REQUEST["date_fin"];}else{echo "&date_fin=1";}?>
	<?php 	if (isset($_REQUEST["date_exercice"])) {echo "&date_exercice=".$_REQUEST["date_exercice"];}else{echo "&date_exercice=".date('Y');}?>
	<?php 	if (isset($_REQUEST["print"])) {echo "&print=".$_REQUEST["print"];}else{echo "&print=2";}?>
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
<td style="padding-right:10px"><span class="labelled">Commerciaux : </span></td>
<td style="padding-right:10px">

<form method="post" action="situation_commerciaux_result_editing_print.php?print=2
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["date_debut"])) {echo "&date_debut=".$_REQUEST["date_debut"];}else{echo "&date_debut=".date('Y');}?>
	<?php 	if (isset($_REQUEST["date_fin"])) {echo "&date_fin=".$_REQUEST["date_fin"];}else{echo "&date_fin=1";}?>
	<?php 	if (isset($_REQUEST["date_exercice"])) {echo "&date_exercice=".$_REQUEST["date_exercice"];}else{echo "&date_exercice=".date('Y');}?>
    " id="form_liste_commerciaux" target="mainediting">



<div id="comm" class="choix_commercial"> 
<?php

// on crée la liste de commerciaux
$i=0;
$liste = charger_liste_commerciaux ();

			echo '<ul class="complete_commercial" style="width:250px">'; 
			foreach ($liste as $commercial) {
			$ref = $commercial->ref_contact;
				echo ' <li class="complete_commercial" id="choix_commercial'.'_'.$i.'"><input type="checkbox" name="com[]" id="c'.$i.'" value="'.$ref.'"/>'. htmlentities( substr($commercial->nom,0,30)).'</li>'; 
			$i++;
		} 
		echo '</ul>';

?>
</div>

</td>
	<td style="padding-right:10px">
	<input type="submit" value="valider" name="ok">
	</form>
	</td>
	
				
	