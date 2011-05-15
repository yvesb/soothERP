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
	$liste_modeles_ods_valides=charge_modele_export_stat();
	?>
	<form method="post" action="ods_gen.php" id="change_code_ods_modele" target="_top" >
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
<br /><br />
<table cellpadding="0" border="0" cellspacing="0">
<tr>
<td style="text-align:right; padding-right:5px;">
<span>date de debut:</span><br/>
<span>date de fin:</span>
</td>
	
	<td style="padding-right:10px">
	<select name="mois_date_deb"  >
		<?php 
		for($m=1; $m<=12; ++$m){
			$lib_mois = getLib_mois($m);
			echo '<option value="'.$m.'" ' ;
			if($m == 1) {echo "selected='selected'";}
			echo '>'.$lib_mois.'</option>';
		}
		?>
	</select>
	<select name="annee_date_deb"  >
		<?php 
		$annee_actuel = date('Y'); 
		for($a=$annee_actuel-5; $a<=$annee_actuel; ++$a){
			echo '<option value="'.$a.'" ' ;
			if(addslashes($a) == $annee_actuel) {echo "selected='selected'";}
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
			if($m == 12) {echo "selected='selected'";}
			echo '>'.$lib_mois.'</option>';
		}
		?>
	</select>
	<select name="annee_date_fin"  >
		<?php 
		$annee_actuel = date('Y'); 
		for($a=$annee_actuel-5; $a<=$annee_actuel; ++$a){
			echo '<option value="'.$a.'" ' ;
			if(addslashes($a) == $annee_actuel) {echo "selected='selected'";}
			echo '>'.$a.'</option>';
		}
		?>
	</select>
	</td>
	<td>
		<input style="height:40px; align:top;" type="submit" value="valider" name="ok">
	</td>
</tr>
</table>
</form>
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
?>