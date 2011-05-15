<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("sens_mouvement");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<div class="panneau_bas">
	<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="panneau_bas_barre_titre">
			<td class="panneau_bas_barre_titre_left"	></td>
			<td class="panneau_bas_barre_titre_coprs"	>
				<?php if($sens_mouvement == "ajout")
							{			echo "Ajout dans la caisse";}
							else{	echo "Retrait dans la caisse";}?>
			</td>
			<td class="panneau_bas_barre_titre_right"	></td>
		</tr>
	</table>
	
	<div style="height: 40px"></div>
	<div align="center">
		<table cellpadding="0" cellspacing="0" border="0" width="400px" align="center">
			<tr>
				<td align="center" style="font-weight: bolder;">
					<?php if($sens_mouvement == "ajout")
					{			echo "Ajout ";}
					else{	echo "Retrait ";}?>
					dans la caisse effectué
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">
					<img id="mouvement_caisse_valider" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.png" style="cursor:pointer"/>
					<script type="text/javascript">
						Event.observe("mouvement_caisse_valider", "click", function(evt){
							Event.stop(evt);
							change_panneau_bas("recherche_article");
						}, false);
					</script>
				</td>
			</tr>
		</table>
	</div>
</div>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>