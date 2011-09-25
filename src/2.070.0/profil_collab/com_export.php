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

?>	<td style="text-align:left">
	<a href="#" id="link_close_pop_up_export_com" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
	<script type="text/javascript">
	Event.observe("link_close_pop_up_export_com", "click",  function(evt){Event.stop(evt); $("pop_up_export_com").hide();}, false);
	</script><br />
<?php
	$liste_modeles_ods_valides=charge_modele_export_result_commerciaux();
	?>
	<form method="post" action="ods_gen.php" id="change_code_ods_modele" target="_top" >
	<input type="hidden"  name="date_debut"  value="<?echo $_REQUEST["date_debut"];?>">
	<input type="hidden"  name="date_fin"  value="<?echo $_REQUEST["date_fin"];?>">
	<input type="hidden"  name="date_exercice"  value="<?echo $_REQUEST["date_exercice"];?>">
	<input type="hidden"  name="print"  value="<?echo $_REQUEST["print"];?>">
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
<div id="comm" class="choix_commercial"> 
<?php
// on crée la liste de commerciaux
$i=0;
$liste = charger_liste_commerciaux ();

			echo '<ul class="complete_commercial" style="width:250px">'; 
			foreach ($liste as $commercial) {
			$ref = $commercial->ref_contact;
				echo ' <li class="complete_commercial" id="choix_commercial'.'_'.$i.'"><input type="checkbox" name="com[]" id="c'.$i.'" value="'.$ref.'"checked/>'. htmlentities( substr($commercial->nom,0,30)).'</li>'; 
			$i++;
		} 
		echo '</ul>';

?>
</div>
<br />
<table cellpadding="0" border="0" cellspacing="0">
<tr>
<td style="text-align:right; padding-right:5px;">
<?php if($_REQUEST["date_debut"]!='' && $_REQUEST["date_fin"]!=''){?>
<span>date de debut: <?echo $_REQUEST["date_debut"];?></span><br/>
<span>date de fin: <?echo $_REQUEST["date_fin"];?></span>
<?php }else{
	$form['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$deb = date_Us_to_Fr($search['date_exercice'][0]);
	$fin = date_Us_to_Fr($search['date_exercice'][1]);
?>
<span>date de debut: <?echo $deb;?></span><br/>
<span>date de fin: <?echo $fin;?></span>
<?php }?>
</td>
	
	<td style="padding-right:10px">



	</td>
	<td>
		<input style="height:40px; align:top;" type="submit" value="valider" name="ok">
	</td>
</tr>
</table>
</form>
</td>
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