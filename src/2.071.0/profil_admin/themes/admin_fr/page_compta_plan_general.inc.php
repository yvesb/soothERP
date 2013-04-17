<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_comptabilite", "smenu_comptabilite.php" ,"true" ,"sub_content", "Comptabilité");
tableau_smenu[1] = Array('compta_plan_general','compta_plan_general.php','true','sub_content', "Plan comptable général");
update_menu_arbo();
</script>
<div class="emarge">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>

<p class="titre">Plan comptable général</p>
<div style="height:50px">

<span id="ouvre_compta_plan_mini_moteur" style="cursor:pointer; text-decoration:underline">Ajouter un compte</span><br /><br />

<script type="text/javascript">
Event.observe("ouvre_compta_plan_mini_moteur", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compta_plan_general_create.php");}, false);
</script>
<table class="minimizetable">
<tr>
<td class="contactview_corps">

<?php 
if ($comptes_plan_general) {
	?>
	<p>Comptes du plan comptable général</p>
	<div class="caract_table">
	<table>
		<tr class="smallheight">
			<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:55%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
	<?php
	$i = 0;
	foreach ($comptes_plan_general as $compte_pg) {
		?>
		<tr>
			<td style="text-align:left">
			<?php for ($y = 0; $y < strlen($compte_pg->numero_compte)-1; $y++) { echo "-";}?>
			<?php echo $compte_pg->numero_compte;?>
			</td>
			<td style="text-align:left">
			<span style="<?php if (strlen($compte_pg->numero_compte) == 1) { ?>font-weight:bolder;<?php } ?><?php if (strlen($compte_pg->numero_compte) == 2) { ?> font-style:italic; <?php } ?>">
			<?php echo $compte_pg->lib_compte;?>
			</span>
			</td>
			<td style="text-align:center">
			<span id="edit<?php echo $i;?>" style="cursor:pointer; text-decoration:underline" >Modifier</span>
			
			<script type="text/javascript">
			Event.observe("edit<?php echo $i;?>", "click",  function(evt){Event.stop(evt); ouvre_compta_plan_mini_moteur(); charger_compta_plan_mini_moteur ("compta_plan_general_edit.php?numero_compte=<?php echo $compte_pg->numero_compte;?>");}, false);
			</script>
			</td>
			<td style="text-align:center">
			<form method="post" action="compta_plan_general_sup.php" id="compta_plan_general_sup_<?php echo $i;?>" name="compta_plan_general_sup_<?php echo $i;?>" target="formFrame">
				<input name="numero_compte" id="numero_compte" type="hidden" value="<?php echo $compte_pg->numero_compte;?>" />
			</form>
			<a href="#" id="plan_compta_plan_general_sup_<?php echo $i; ?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
			<script type="text/javascript">
			Event.observe("plan_compta_plan_general_sup_<?php echo $i; ?>", "click",  function(evt){
				Event.stop(evt);
				alerte.confirm_supprimer('compta_plan_general_sup', 'compta_plan_general_sup_<?php echo $i;?>');
			}, false);
			</script>
			</td>
		</tr>
		<?php 
		$i++;
		}
		?>
	</table>
	</div>
	<?php
	}
?>

</td>
</tr>
</table>

<SCRIPT type="text/javascript">


	
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>