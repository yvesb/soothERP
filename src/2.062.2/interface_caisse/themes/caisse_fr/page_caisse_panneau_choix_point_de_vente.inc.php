<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("magasins");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<div class="panneau_bas">
	<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="panneau_bas_barre_titre">
			<td class="panneau_bas_barre_titre_left"	></td>
			<td class="panneau_bas_barre_titre_coprs"	>Choix du point de vente</td>
			<td class="panneau_bas_barre_titre_right"	></td>
		</tr>
	</table>
	
	<div style="height: 10px"></div>

	<div>
		<table width="100%"  border="0" cellpadding="0" cellspacing="3">
			<tr>
				<?php
				$nb_fiches = count($magasins);
				$i = 0;
				foreach ($magasins as $magasin) { ?>
					<td id="magasin_<?php echo $magasin->getId_magasin();?>" class="panneau_choix_pt_de_vente_cell" align="center">
						<table cellpadding="0" cellspacing="0" border="0" width="100%" class="panneau_choix_pt_de_vente_cell_pt_de_vente">
							<tr>
								<td><?php echo htmlentities($magasin->getLib_enseigne()); ?></td>
							</tr>
							<tr>
								<td><?php echo htmlentities($magasin->getLib_magasin()); ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
						<script type="text/javascript">
							Event.observe("magasin_<?php echo $magasin->getId_magasin();?>", "click", function(evt){
								Event.stop(evt);
								var AppelAjax = new Ajax.Request(
											"<?php echo $DIR."site/__session_change_magasin.php?id_magasin=".$magasin->getId_magasin();?>",
											{
												evalScripts:true, 
												onSuccess: function (requester){
													lib_grille_tarifaire = "<?php echo $magasin->getLib_tarif();?>";
													caisse_reset("choix_caisse");
												}
											}
										);
								
							}, false);
						</script>
					</td>
					<?php if(($i % 6) !=5) {?>
					<td>&nbsp;</td>
					<?php }
					if( $i > 0 && ($i % 6) == 5  ){ ?>
					</tr>
						<td colspan="11" height="8px"></td>
					<tr>
					<?php }
					$i++;
				}
				if($nb_fiches % 6 !=0){
					for($j=0; $j<(6-($nb_fiches % 6)); $j++){?>
						<td style="width:15%;">&nbsp;</td>
						<?php if(($j % 6 !=5) && ($j<(5-($nb_fiches % 6))) ) {?>
						<td><div style="height:60px"></div></td>
						<?php } 
					}
				}
				?>
			</tr>
			<?php if($nb_fiches <= 6){?>
			<tr>
				<td colspan="11" height="8px"></td>
			</tr>
			<tr>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
			</tr>
			<?php }
			if($nb_fiches <= 12){?>
			<tr>
				<td colspan="11" height="8px"></td>
			</tr>
			<tr>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
			</tr>
			<?php }?>
		</table>
	</div>
</div>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>