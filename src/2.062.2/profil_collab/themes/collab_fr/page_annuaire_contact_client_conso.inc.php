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
				<td style="width:77%; text-align:left; padding-left:5px; font-weight:bolder">Services prépayés</td>
				<td style="width:15%; text-align:left; padding-right:5px; font-weight:bolder">Echéance</td>
				<td style="width:8%; text-align:center; padding-right:5px; font-weight:bolder">&nbsp;</td>
			</tr>
		</table>
		
		<div class="conso_info" >
			<?php
			$colorise=0; 
			$nb_conso = count($client_conso);
			$nb_conso_max = 5;
			$now = strtotime(date("Y-m-d H:i:s"));
			for ($conso_index = 0; ($conso_index < $nb_conso_max) && ($conso_index < $nb_conso); $conso_index++) {
				$colorise++;
				$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
				<tr style="color:#002673">
					<td style="width:77%; border-bottom:1px solid #FFFFFF; text-align:left">
						&nbsp;&nbsp;<?php echo $client_conso[$conso_index]->lib_article; ?>
					</td>
					<?php 
						$credits_restants = $client_conso[$conso_index]->credits_restants;
					?>				
					<td style=" width:30%; border-bottom:1px solid #FFFFFF; text-align:left<?php if($credits_restants == 1 ) {echo  "; color:red";}?>">
						&nbsp;&nbsp;<?php echo $client_conso[$conso_index]->credits_restants; ?>
					</td>
					<td style="width:8%; border-bottom:1px solid #FFFFFF; text-align:center">
						<div id="link_conso_ref_2_<?php echo $colorise; ?>" style="cursor:pointer">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme(); ?>images/ajouter.gif" />
						</div>
						<script type="text/javascript">
						Event.observe("link_conso_ref_2_<?php echo $colorise; ?>", "click",  function(evt){
							Event.stop(evt);
							if ($('all_conso').style.display == "none") {
								page.traitecontent('catalogue_articles_consommation_edition','catalogue_articles_consommation_edition.php?id_compte_credit=<?php echo $client_conso[$conso_index]->id_compte_credit;?>&ref_article=<?php echo $client_conso[$conso_index]->ref_article;?>&source=annaire_view_fiche_profil4&develop_conso=0','true','edition_consommation');
							}
							else{
								page.traitecontent('catalogue_articles_consommation_edition','catalogue_articles_consommation_edition.php?id_compte_credit=<?php echo $client_conso[$conso_index]->id_compte_credit;?>&ref_article=<?php echo $client_conso[$conso_index]->ref_article;?>&source=annaire_view_fiche_profil4&develop_conso=1','true','edition_consommation');
							}
							$("edition_consommation").show();
						});
						</script>
					</td>
				</tr>
			</table>
			<?php }?>
			
			<?php 
			if( isset($develop_conso) && ($develop_conso == "1")){?>
			<div id="all_conso" style="display:block;">
			<?php }else{?>
			<div id="all_conso" style="display:none;">
			<?php }
			if ($nb_conso > $nb_conso_max) {
			for ($conso_index = $nb_conso_max; $conso_index < $nb_conso; $conso_index++) {
				$colorise++;
				$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
				<tr style="color:#002673">
					<td style="width:77%; border-bottom:1px solid #FFFFFF; text-align:left">
						&nbsp;&nbsp;<?php	echo $client_conso[$conso_index]->lib_article;?>
					</td>
					<?php 
						$date_echeance = strtotime($client_conso[$conso_index]->date_echeance);
					?>				
					<td style=" width:15%; border-bottom:1px solid #FFFFFF; text-align:left<?php if($now > $date_echeance) {echo  "; color:red";}?>">
								<?php echo Date_Us_to_Fr($client_conso[$conso_index]->date_echeance);?>
					</td>
					<td style="width:8%; border-bottom:1px solid #FFFFFF; text-align:center">
						<div id="link_conso_ref_plus_2_<?php echo $colorise;?>" style="cursor:pointer">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" />
						</div>
						<script type="text/javascript">
						Event.observe("link_conso_ref_plus_2_<?php echo $colorise;?>", "click",  function(evt){
							Event.stop(evt);
							if ($('all_conso').style.display == "none") {
								page.traitecontent('catalogue_articles_consommation_edition','catalogue_articles_consommation_edition.php?id_compte_credit=<?php echo $client_conso[$conso_index]->id_compte_credit;?>&ref_article=<?php echo $client_conso[$conso_index]->ref_article;?>&source=annaire_view_fiche_profil4&develop_conso=0','true','edition_consommation');
							}
							else{
								page.traitecontent('catalogue_articles_consommation_edition','catalogue_articles_consommation_edition.php?id_compte_credit=<?php echo $client_conso[$conso_index]->id_compte_credit;?>&ref_article=<?php echo $client_conso[$conso_index]->ref_article;?>&source=annaire_view_fiche_profil4&develop_conso=1','true','edition_consommation');
							}
							$("edition_consommation").show();
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
		if ($nb_conso > $nb_conso_max) {
			if( isset($develop_conso) && ($develop_conso == "1")){?>
				<div id="show_all_conso" class="link_to_conso_fromart" style="float:right;display:none;">&gt;&gt; Consulter l'ensemble des consommations de ce contact </div>
				<?php }else{?>
				<div id="show_all_conso" class="link_to_conso_fromart" style="float:right;display:block;">&gt;&gt; Consulter l'ensemble des consommations de ce contact </div>
			<?php } ?>
			<div style="float:right;width: 350px">&nbsp;</div>
			<script type="text/javascript">
				Event.observe("show_all_conso", "click",  function(evt){
					Event.stop(evt);
					if ($('all_conso').style.display == "none") {
						$('all_conso').style.display = "block";
						$('show_all_conso').style.display = "none";
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