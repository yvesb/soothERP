<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("comptes_caisses", "magasin");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<div class="panneau_bas">
	<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="panneau_bas_barre_titre">
			<td class="panneau_bas_barre_titre_left"	></td>
			<td class="panneau_bas_barre_titre_coprs"	>Choix de la caisse du magasin : <?php echo $magasin->getLib_magasin()." / ".$magasin->getLib_enseigne(); ?></td>
			<td class="panneau_bas_barre_titre_right"	></td>
		</tr>
	</table>
	
	<div style="height: 10px"></div>
	
	<div>
		<table width="100%"  border="0" cellpadding="0" cellspacing="3">
			<tr height="58px">
				<?php
				$nb_fiches = count($comptes_caisses);
				$i = 0;
				foreach ($comptes_caisses as $compte_caisse) { ?>
					<td id="caisse_<?php echo $compte_caisse->id_compte_caisse;?>" class="panneau_choix_caisse_cell" align="center">
						<?php echo htmlentities($compte_caisse->lib_caisse); ?>
						<script type="text/javascript">
							Event.observe("caisse_<?php echo $compte_caisse->id_compte_caisse;?>", "click", function(evt){
								Event.stop(evt);
								var AppelAjax = new Ajax.Request(
										"caisse_maj_compte_caisse.php",
										{
											parameters		: {id_compte_caisse: <?php echo $compte_caisse->id_compte_caisse;?>},
											onLoading			:S_loading,
											onSuccess			: function (requester){}
										}
								);
				   			change_panneau_bas("recherche_article");
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
