<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Courrier : <?php echo $courrier->getObjet();?></title>
	<SCRIPT LANGUAGE="JavaScript">
		function PopupCentrer(page,largeur,hauteur,optionsi) {
		  var top=(screen.height-hauteur)/2;
		  var left=(screen.width-largeur)/2;
		  window.open(page,"","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+optionsi);
		}
	</SCRIPT>
	<style type="text/css">
		body {margin: 5px;}
		img {border:0px;}
	</style>
</head>
<body>
	<table cellpadding="0" border="0" cellspacing="0">
		<tr>
		<?php 
		foreach ($editions_modes as $edition_mode) {
			
			$params_p = "?id_courrier=".$id_courrier;
			$params_p.= "&mode_edition=".$edition_mode->id_edition_mode;
			if (isset($code_pdf_modele))
				$params_p.= "&code_pdf_modele=".$code_pdf_modele;
			if (isset($filigrane)) //@TODO COURRIER : Gestion des filigranes : passage en paramètre de la variable filigrane
				$params_p.="&filigrane=".$filigrane;

			switch ($edition_mode->id_edition_mode) {
				case "1":{ //impression
					$params_p.= "&print=1";
					?>
					<td style="padding-right:10px">
						<a href="courriers_editing_print.php<?php echo $params_p ?>" target="mainediting" >
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" title="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" />
						</a>
					</td>
					<?php break;}
				
				case "2":{ //envois par email
					?>
					<td style="padding-right:10px">
						<a href='javascript:PopupCentrer("courriers_editing_email.php<?php echo $params_p; ?>",800,450,"menubar=no,statusbar=no,scrollbars=yes,resizable=yes")'>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-email.gif" alt="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" title="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" />
						</a>
					</td>
				<?php break;}
				
				//@TODO COURRIER : Gestion du FAX : Emplacement du bouton FAX
				case "3": { //envois par FAX
					?>
					<td style="padding-right:10px">
						<a href='javascript:PopupCentrer("courriers_editing_fax.php<?php echo $params_p; ?>",500,350,"menubar=no,statusbar=no,scrollbars=auto")'>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fax.gif" alt="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" title="<?php echo  htmlentities($edition_mode->lib_edition_mode);?>" />
						</a>
					</td>
				<?php	break; }
			}
		}
		/*
		if (isset($liste_modeles_pdf_courrier_valides) && count($liste_modeles_pdf_courrier_valides) >1) {?>
		<td style="padding-right:10px">
			<form method="post" action="courriers_editing.php" id="change_code_pdf_modele" target="_top" >
				<input type="hidden" name="id_courrier" value="<?php echo $id_courrier; ?>" />
				<select name="code_pdf_modele" onchange="$('change_code_pdf_modele').submit();" >
					<?php
					foreach ($liste_modeles_pdf_courrier_valides as $modele_pdf) { ?>
						<option value="<?php echo $modele_pdf->code_pdf_modele;?>" <?php 	if (isset($code_pdf_modele) && $code_pdf_modele == $modele_pdf->code_pdf_modele) {echo "selected='selected'";}?>><?php echo $modele_pdf->lib_modele;?></option>
					<?php } ?>
				</select>
				<?php if (isset($filigrane)) {?>
				<input type="hidden" name="filigrane" value="<?php echo $filigrane; ?>" />
				<?php } ?>
			</form>
		</td>
		<?php }
		*/
		//@TODO COURRIER : Gestion des filigranes : 
		if (isset($filigrane_pdf) && count($filigrane_pdf) >0) { ?>
		<td style="padding-right:10px">
			<form method="post" action="courriers_editing.php" id="filigrane_pdf" target="_top" >
				<input type="hidden" name="id_courrier" value="<?php echo $id_courrier; ?>" />
				<select name="filigrane" onchange="$('filigrane_pdf').submit();" >
					<option value="" >Pas de filigrane</option>
					<?php foreach ($filigrane_pdf as $fil) { ?>
					<option value="<?php echo addslashes($fil->lib_filigrane);?>" <?php if (isset($filigrane) && $filigrane == addslashes($fil->lib_filigrane)) {echo "selected='selected'";}?> ><?php echo $fil->lib_filigrane;?></option>
					<?php } ?>
				</select>
				<?php if (isset($code_pdf_modele)) { ?>
				<input type="hidden" name="code_pdf_modele" value="<?php echo $code_pdf_modele; ?>" />
				<?php } ?>
			</form>
		</td>
	<?php } ?> 
</tr>
</table>
</body>
</html>
