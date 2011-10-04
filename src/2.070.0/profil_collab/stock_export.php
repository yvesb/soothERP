<?php

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>	
	<a href="#" id="link_close_pop_up_export_det" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
	<script type="text/javascript">
	Event.observe("link_close_pop_up_export_det", "click",  function(evt){Event.stop(evt); $("pop_up_export_det").hide();}, false);
	</script><br />
	
<?php
	$liste_modeles_ods_valides=charge_modele_export_etat_stocks();
	?>
	<form method="post" action="ods_gen.php" id="change_code_ods_modele" target="_top" >
	<input type="hidden"  name="ref_art_categ"  value="<?php echo $_REQUEST["ref_art_categ"];?>">
	<input type="hidden"  name="ref_constructeur"  value="<?php echo $_REQUEST["ref_constructeur"];?>">
	<input type="hidden"  name="aff_pa"  value="<?php echo $_REQUEST["aff_pa"];?>">
	<input type="hidden"  name="aff_info_tracab"  value="<?php echo $_REQUEST["aff_info_tracab"];?>">
	<input type="hidden"  name="orderby"  value="<?php echo $_REQUEST["orderby"];?>">
	<input type="hidden"  name="id_stock"  value="<?php echo $_REQUEST["id_stock"];?>">
	<input type="hidden"  name="in_stock"  value="<?php echo $_REQUEST["in_stock"];?>">
	<input type="hidden"  name="emplacement_s"  value="<?php echo $_REQUEST["emplacement_s"];?>">
	<select name="code_ods_modele" >
	<?php
	foreach ($liste_modeles_ods_valides as $modele_ods) {
		?>
		<option value="<?php echo $modele_ods->code_export_modele;?>"><?php echo $modele_ods->lib_modele;?></option>
		<?php
	}
	?>
	</select>
	<?php

?>
<br /><br /><br />
<table width=100% cellpadding="0" border="0" cellspacing="0">
<tr>
	<td style="text-align:center">
		<span><input style="height:40px; align:top;" type="submit" value="valider" name="ok"></span>
	</td>
</tr>
</table>
</form>
</body>
</html>