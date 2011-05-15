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
	<a href="stats_editing_print.php?mode_edition=<?php echo $edition_mode->id_edition_mode;?>&print=1
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["annee_date_deb"])) {echo "&annee_date_deb=".$_REQUEST["annee_date_deb"];}else{echo "&annee_date_deb=".date('Y');}?>
	<?php 	if (isset($_REQUEST["mois_date_deb"])) {echo "&mois_date_deb=".$_REQUEST["mois_date_deb"];}else{echo "&mois_date_deb=1";}?>
	<?php 	if (isset($_REQUEST["annee_date_fin"])) {echo "&annee_date_fin=".$_REQUEST["annee_date_fin"];}else{echo "&annee_date_fin=".date('Y');}?>
	<?php 	if (isset($_REQUEST["mois_date_fin"])) {echo "&mois_date_fin=".$_REQUEST["mois_date_fin"];}else{echo "&mois_date_fin=12";}?>
	" target="mainediting" >
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" title="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" />	</a>
	</td>
	<?php
	break;
	
	//envois par email
	/*case "2":?>
	<td style="padding-right:10px">
	<a href='javascript:PopupCentrer("stats_editing_email.php?
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?>
	<?php 	if (isset($_REQUEST["annee_date_deb"])) {echo "&annee_date_deb=".$_REQUEST["annee_date_deb"];}else{echo "&annee_date_deb=".date('Y');}?>
	<?php 	if (isset($_REQUEST["mois_date_deb"])) {echo "&mois_date_deb=".$_REQUEST["mois_date_deb"];}else{echo "&mois_date_deb=1";}?>
	<?php 	if (isset($_REQUEST["annee_date_fin"])) {echo "&annee_date_fin=".$_REQUEST["annee_date_fin"];}else{echo "&annee_date_fin=".date('Y');}?>
	<?php 	if (isset($_REQUEST["mois_date_fin"])) {echo "&mois_date_fin=".$_REQUEST["mois_date_fin"];}else{echo "&mois_date_fin=12";}?>
	",580,450,"menubar=no,statusbar=no,scrollbars=yes,resizable=yes")'  >
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-email.gif" alt="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" title="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" />	</a>
	</td>
	<?php
	break;
	*/

	}
	
	
}

if (isset($liste_modeles_pdf_valides) && count($liste_modeles_pdf_valides) >1) {
	?>
	<td style="padding-right:10px">
	<form method="post" action="stats_editing.php" id="change_code_pdf_modele" target="_top" >
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
<td style="text-align:right; padding-right:5px;">
<span>date de debut:</span><br/>
<span>date de fin: </span>
</td>

	<form method="post" action="stats_editing.php" id="date_stat" target="_top" >
	<td style="padding-right:10px">
	<select name="mois_date_deb"  >
		<?php 
		for($m=1; $m<=12; ++$m){
			$lib_mois = getLib_mois($m);
			echo '<option value="'.$m.'" ' ;
			if(isset($_REQUEST["mois_date_deb"]) && $_REQUEST["mois_date_deb"] == $m) {echo "selected='selected'";}
			echo '>'.$lib_mois.'</option>';
		}
		?>
	</select>
	<select name="annee_date_deb"  >
		<?php 
		$annee_actuel = date('Y'); 
		for($a=$annee_actuel-5; $a<=$annee_actuel; ++$a){
			echo '<option value="'.$a.'" ' ;
			if(isset($_REQUEST["annee_date_deb"]) && $_REQUEST["annee_date_deb"] == addslashes($a)) {echo "selected='selected'";}
			echo '>'.$a.'</option>';
		}
		?>
	</select>
	
	<br/>
	
	<select name="mois_date_fin"  >
		<?php 
		for($m=1; $m<=12; ++$m){
			$lib_mois = getLib_mois($m);
			echo '<option value="'.$m.'" ' ;
			if(isset($_REQUEST["mois_date_fin"]) && $_REQUEST["mois_date_fin"] == $m) {echo "selected='selected'";}
			echo '>'.$lib_mois.'</option>';
		}
		?>
	</select>
	<select name="annee_date_fin"  >
		<?php 
		$annee_actuel = date('Y'); 
		for($a=$annee_actuel-5; $a<=$annee_actuel; ++$a){
			echo '<option value="'.$a.'" ' ;
			if(isset($_REQUEST["annee_date_fin"]) && $_REQUEST["annee_date_fin"] == addslashes($a)) {echo "selected='selected'";}
			echo '>'.$a.'</option>';
		}
		?>
	</select>
	<?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo '<input type="hidden" name="code_pdf_modele" value="'.$_REQUEST["code_pdf_modele"].'" />';}?>
	</td>
	<td>
		<button style="height:40px; align:top;">valider</button>
	</td>
	</form>


</tr>
</table>
</body>
</html>

<?php 
function getLib_mois($i){
	switch ($i){
		case 1 : return "janvier"; break;
		case 2 : return "février"; break;
		case 3 : return "mars"; break;
		case 4 : return "avril"; break;
		case 5 : return "mai"; break;
		case 6 : return "juin"; break;
		case 7 : return "juillet"; break;
		case 8 : return "août"; break;
		case 9 : return "septembre"; break;
		case 10 : return "octobre"; break;
		case 11 : return "novembre"; break;
		case 12 : return "décembre"; break;
		default : return false; 
	}
}
