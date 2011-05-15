<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="97%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr >
				<td style="width:100%"><div style="height:9px; border-bottom:1px solid #00336c">&nbsp;</div></td>
			</tr>
			<tr>
				<td >&nbsp;</td>
			</tr>
		</table>
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
			<tr style="text-align:left; vertical-align:top; color:#00336c; font-weight:bolder">
				<td style="width:77%; text-align:left; padding-left:5px; font-weight:bolder">Abonnements</td>
				<td style="width:15%; text-align:left; padding-right:5px; font-weight:bolder">Echéance</td>
				<td style="width:8%; text-align:center; padding-right:5px; font-weight:bolder">&nbsp;</td>
			</tr>
		</table>
		
		<div class="abo_info" >
			<?php
			$colorise=0;
			$nb_abo = count($client_abo);
			$nb_abo_max = 5;
			for ($abo_index = 0; ($abo_index < $nb_abo_max) && ($abo_index < $nb_abo); $abo_index++) {
				$colorise++;
				$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
				<tr style="color:#002673">
					<td style="width:77%; border-bottom:1px solid #FFFFFF; text-align:left">
						&nbsp;&nbsp;<?php	echo $client_abo[$abo_index]->lib_article;?>
					</td>
					<td style=" width:15%; border-bottom:1px solid #FFFFFF; text-align:left">
						<?php	if ($client_abo[$abo_index]->date_echeance) { echo Date_Us_to_Fr($client_abo[$abo_index]->date_echeance);}?>
					</td>
					<td style="width:8%; border-bottom:1px solid #FFFFFF; text-align:center">
						<div id="link_abo_ref_2_<?php echo $colorise;?>" style="cursor:pointer">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" />
						</div>
											
						<script type="text/javascript">
						Event.observe("link_abo_ref_2_<?php echo $colorise;?>", "click",  function(evt){
							Event.stop(evt);
							if ($('all_abo').style.display == "none") {
								page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $client_abo[$abo_index]->id_abo;?>&ref_article=<?php echo $client_abo[$abo_index]->ref_article;?>&source=annaire_view_fiche_profil4&develop_abo=0','true','edition_abonnement');
							}
							else{
								page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $client_abo[$abo_index]->id_abo;?>&ref_article=<?php echo $client_abo[$abo_index]->ref_article;?>&source=annaire_view_fiche_profil4&develop_abo=1','true','edition_abonnement');
							}
							$("edition_abonnement").show();
						});
						</script>
					</td>
				</tr>
			</table>
			<?php
			}
			if( isset($develop_abo) && ($develop_abo == "1")){?>
			<div id="all_abo" style="display:block;">
			<?php }else{?>
			<div id="all_abo" style="display:none;">
			<?php }
			if ($nb_abo > $nb_abo_max) {
			for ($abo_index = $nb_abo_max; $abo_index < $nb_abo; $abo_index++) {
				$colorise++;
				$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
				<tr style="color:#002673">
					<td style="width:77%; border-bottom:1px solid #FFFFFF; text-align:left">
						&nbsp;&nbsp;<?php	echo $client_abo[$abo_index]->lib_article;?>
					</td>
					<td style=" width:15%; border-bottom:1px solid #FFFFFF; text-align:left">
						<?php	if ($client_abo[$abo_index]->date_echeance) { echo Date_Us_to_Fr($client_abo[$abo_index]->date_echeance);}?>
					</td>
					<td style="width:8%; border-bottom:1px solid #FFFFFF; text-align:center">
						<div id="link_abo_ref_plus_2_<?php echo $colorise;?>" style="cursor:pointer">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" />
						</div>
						<script type="text/javascript">
						Event.observe("link_abo_ref_plus_2_<?php echo $colorise;?>", "click",  function(evt){
							Event.stop(evt);
							if ($('all_abo').style.display == "none") {
								page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $client_abo[$abo_index]->id_abo;?>&ref_article=<?php echo $client_abo[$abo_index]->ref_article;?>&source=annaire_view_fiche_profil4&develop_abo=0','true','edition_abonnement');
							}
							else{
								page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $client_abo[$abo_index]->id_abo;?>&ref_article=<?php echo $client_abo[$abo_index]->ref_article;?>&source=annaire_view_fiche_profil4&develop_abo=1','true','edition_abonnement');
							}
							$("edition_abonnement").show();
						});
						</script>
					</td>
				</tr>
			</table>
				<?php
				}
			}
			?>
			</div>
		</div>
		<br />
		<?php
		if ($nb_abo > $nb_abo_max) {
			if( isset($develop_abo) && ($develop_abo == "1")){?>
				<div id="show_all_abos" class="link_to_abo_fromart" style="float:right;display:none;">&gt;&gt; Consulter l'ensemble des abonnements de ce contact </div>
				<?php }else{?>
				<div id="show_all_abos" class="link_to_abo_fromart" style="float:right;display:block;">&gt;&gt; Consulter l'ensemble des abonnements de ce contact </div>
			<?php } ?>
			<div style="float:right;width: 350px">&nbsp;</div>
			<script type="text/javascript">
				Event.observe("show_all_abos", "click",  function(evt){
					Event.stop(evt);
					if ($('all_abo').style.display == "none") {
						$('all_abo').style.display = "block";
						$('show_all_abos').style.display = "none";
					}
				});
			</script>
		<?php
		}
		?>
		<div style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="350px" height="1px" /></div>
		</td>
		<td width="3%">&nbsp;&nbsp;</td>
	</tr>
</table>