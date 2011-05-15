<?php

// *************************************************************************************************************
// ABONNEMENT D'UN ARTICLE 
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript">


</script>
<div style=" text-align:left; padding:20px">

<table style="width:100%">
	<tr class="smallheight">
		<td style="width:57%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="art_new_info" style="padding:10px">
		<form action="catalogue_articles_view_valide.php?ref_article=<?php echo $article->getRef_article();?>&step=3" target="formFrame" method="post" name="article_view_3" id="article_view_3">
			<input type="hidden" name="modele" id="modele" value="<?php echo $art_categs->getModele()?>" />
			<table style="width:100%" cellspacing="4">
				<tr>
					<td style="width:55%; font-weight:bolder; border-bottom:1px solid #FFFFFF; line-height:36px;" >Durée de l'abonnement:  </td>
					<td style="width:45%">
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
						<td style="line-height:36px;font-weight:bolder">
						<input type="text" name="duree_abo_mois" id="duree_abo_mois" value="<?php echo floor($article->getDuree()/ (30*24*3600)); $reste = $article->getDuree() - (floor($article->getDuree()/ (30*24*3600)) * (30*24*3600));?>" size="5"  class="classinput_nsize"/>&nbsp;mois 
						</td>
						<td style="line-height:36px; font-weight:bolder">
						<input type="text" name="duree_abo_jour" id="duree_abo_jour" value="<?php echo floor($reste/ (24*3600));?>" size="5"  class="classinput_nsize"/>&nbsp;jours
						</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bolder; border-bottom:1px solid #FFFFFF; line-height:36px;">Engagement initial:</td>
					<td style="line-height:36px; font-weight:bolder">
						<input type="text" name="engagement" id="engagement" value="<?php echo $article->getEngagement();?>" size="5" class="classinput_nsize"/> x durée de l'abonnement
					</td>
				</tr>
				<tr>
					<td style="font-weight:bolder; border-bottom:1px solid #FFFFFF; line-height:36px;">Reconduction automatique: </td>
					<td style="line-height:36px; font-weight:bolder">
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
						<td style="line-height:36px;font-weight:bolder">
						<input type="radio" name="reconduc" id="reconduc_1" value="1" <?php if ($article->getReconduction()) {?> checked="checked"<?php }?> />&nbsp;oui 
						</td>
						<td style="line-height:36px;font-weight:bolder">
						<input type="radio" name="reconduc" id="reconduc_0" value="0" <?php if (!$article->getReconduction()) {?> checked="checked"<?php }?> />&nbsp;non
						</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr <?php if (!$article->getReconduction()) {?>style="display:none"<?php }?> id="choix_reconduc">
					<td style="font-weight:bolder; border-bottom:1px solid #FFFFFF; line-height:36px;">Durée de réengagement: </td>
					<td style="line-height:36px;font-weight:bolder">
						<input type="text" name="reconduction" id="reconduction" value="<?php echo $article->getReconduction();?>" size="5" class="classinput_nsize"/> x durée de l'abonnement
					</td>
				</tr>
				<tr>
					<td style="font-weight:bolder; border-bottom:1px solid #FFFFFF; line-height:36px;">Délai du préavis avant résiliation: </td>
					<td style="line-height:36px;">
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
						<td style="line-height:36px; font-weight:bolder">
						<input type="text" name="preavis_abo_mois" id="preavis_abo_mois" value="<?php echo floor($article->getPreavis()/ (30*24*3600)); $reste = $article->getPreavis() - (floor($article->getPreavis()/ (30*24*3600)) * (30*24*3600));?>" size="5"  class="classinput_nsize"/>&nbsp;mois </td>
						<td style="line-height:36px; font-weight:bolder">
						<input type="text" name="preavis_abo_jour" id="preavis_abo_jour" value="<?php echo floor($reste/ (24*3600));?>" size="5"  class="classinput_nsize"/>&nbsp;jours
						</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="labelled_text"></td>
					<td >
					<div style="text-align:right; padding-right:5px">
					<a href="#" id="bt_etape_3b" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" /></a>
					</div>
					</td>
				</tr>
			</table>

			</form>
		</td>
		<td >
		</td>
		<td class="art_new_info" style="padding:10px">
		<table style="width:100%" cellspacing="4">
				<tr>
					<td  style=" font-weight:bolder; border-bottom:1px solid #FFFFFF; line-height:36px;" >Informations sur les abonnés </td>
				</tr>
				<tr>
					<td style="font-weight:bolder; border-bottom:1px solid #FFFFFF; line-height:36px;" >
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
						<td style="line-height:36px;font-weight:bolder; width:60%">Abonnements en cours
						</td>
						<td style="line-height:36px;font-weight:bolder; width:20%">
						<?php echo $article->compte_service_abo_nb_abonnes ();?>
						</td>
						<td style="line-height:36px; font-weight:bolder; width:20%" class="green_underlined" >
						<span id="search_type_abo_1">voir</span>
						</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bolder; border-bottom:1px solid #FFFFFF; line-height:36px;" >
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
						<td style="line-height:36px;font-weight:bolder; width:60%">Abonnements à renouveler
						</td>
						<td style="line-height:36px;font-weight:bolder; width:20%">
						<?php echo $article->compte_service_abo_a_renouveller ();?>
						
						</td>
						<td style="line-height:36px; font-weight:bolder; width:20%" class="green_underlined" >
						<span id="search_type_abo_2">voir</span>
						</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bolder; border-bottom:1px solid #FFFFFF; line-height:36px;" >
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
						<td style="line-height:36px;font-weight:bolder; width:60%">Abonnements expirés
						</td>
						<td style="line-height:36px;font-weight:bolder; width:20%">
						<?php echo $article->compte_service_abo_echu ();?>
						</td>
						<td style="line-height:36px; font-weight:bolder; width:20%" class="green_underlined" >
						<span id="search_type_abo_3">voir</span>
						</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td colspan="3"><br />

		<table style="width:100%">
		<tr>
		<td style="width:48%">
		<table border="0" cellspacing="0" cellpadding="0" class="main_aff_ca">
				<tr>
					<td style="padding:10px"><span style=" font-weight:bolder; color:#999999">Evolution du nombre de souscriptions sur 12 mois</span><br />
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td>
										</td>
										<td>
										</td>
										<td style="height:5px">
										</td>
										<td valign="bottom" style="vertical-align:bottom; width:75px;border-left:1px solid #999999; color:#999999;" rowspan="3">
										<table border="0" cellpadding="0" cellspacing="0" height="54px">
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo round($max_evo_sousc_12,0);?></td></tr>
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo number_format($max_evo_sousc_12/2,1,".","");?></td></tr>
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;">0</td></tr>
										</table>
										</td>
									</tr>
									<tr>
										<td style="width:25px;">
										<div style="height:40px">&nbsp;</div>
										</td>
										<td valign="bottom" style="vertical-align:bottom">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php 
										$o = 0;
										foreach ($evo_sousc_12 as $s_12) { ?>
										<td style="padding-right:23px; vertical-align: bottom;" valign="bottom">
										<div id="s1p1_histo_<?php echo $o;?>" <?php
										if ($s_12 > 0) {
											?> style=" width:10px; background-color:<?php
										if (isset($degrader_12_pos[$o])) { echo $degrader_12_pos[$o]; }?>;height:0px" title="<?php echo $s_12;?>" <?php }
											else {
											?>	style=" width:10px" <?php }
											?> >&nbsp;</div>
											<?php if ($s_12 > 0 && $max_evo_sousc_12>0) {?>
											<script>rise_height("s1p1_histo_<?php echo $o;?>", <?php echo ($s_12* 40) /$max_evo_sousc_12;?>);</script>
											<?php }?>
											</td>
											<?php
											$o++;
										}
										?>
										</tr>
										</table>
										</td>
										<td style="width:25px;">
										</td>
									</tr>
									<tr>
										<td style="border-top:1px solid #999999;">
										</td>
										<td style="border-top:1px solid #999999;">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php 
										
										setlocale(LC_TIME, $INFO_LOCALE);
										for ($j = 11; $j >=0 ; $j--) {
											?>
											<td style="padding:1px; vertical-align: top; font-size:8px; color:#999999 " valign="bottom">
											<div style="width:31px;" ><span style="width:10px; text-align:center"><?php  echo date("M y", mktime(0, 0, 0, date("m" ,time())-$j , 1, date ("Y", time()) ) );?></span></div>
											</td>
											<?php
										}
										?>
										</tr>
										</table>
										</td>
										<td  style="border-top:1px solid #999999;">
										</td>
									</tr>
								</table>
					</td>
				</tr>
			</table>
			</td>
			<td>
			</td>
			<td style="width:48%">
			
		<table border="0" cellspacing="0" cellpadding="0" class="main_aff_ca">
				<tr>
					<td style="padding:10px"><span style=" font-weight:bolder; color:#999999">Evolution du nombre d'abonnés sur 12 mois</span><br />
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td>
										</td>
										<td>
										</td>
										<td style="height:5px">
										</td>
										<td valign="bottom" style="vertical-align:bottom; width:75px;border-left:1px solid #999999; color:#999999;" rowspan="3">
										<table border="0" cellpadding="0" cellspacing="0" height="54px">
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo round($max_evo_abo_12,0);?></td></tr>
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo number_format($max_evo_abo_12/2,1,".","");?></td></tr>
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;">0</td></tr>
										</table>
										</td>
									</tr>
									<tr>
										<td style="width:25px;">
										<div style="height:40px">&nbsp;</div>
										</td>
										<td valign="bottom" style="vertical-align:bottom">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php 
										$o = 0;
										foreach ($evo_abo_12 as $s_12) { ?>
										<td style="padding-right:23px; vertical-align: bottom;" valign="bottom">
										<div id="s1p2_histo_<?php echo $o;?>" <?php
										if ($s_12 > 0) {
											?> style=" width:10px; background-color:<?php
										if (isset($degrader_12_pos[$o])) { echo $degrader_12_pos[$o]; }?>;height:0px" title="<?php echo $s_12;?>" <?php }
											else {
											?>	style=" width:10px" <?php }
											?> >&nbsp;</div>
											<?php if ($s_12 > 0 && $max_evo_abo_12>0) {?>
											<script>rise_height("s1p2_histo_<?php echo $o;?>", <?php echo ($s_12* 40) /$max_evo_abo_12;?>);</script>
											<?php }?>
											</td>
											<?php
											$o++;
										}
										?>
										</tr>
										</table>
										</td>
										<td style="width:25px;">
										</td>
									</tr>
									<tr>
										<td style="border-top:1px solid #999999;">
										</td>
										<td style="border-top:1px solid #999999;">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php 
										
										setlocale(LC_TIME, $INFO_LOCALE);
										for ($j = 11; $j >=0 ; $j--) {
											?>
											<td style="padding:1px; vertical-align: top; font-size:8px; color:#999999 " valign="bottom">
											<div style="width:31px;" ><span style="width:10px; text-align:center"><?php  echo date("M y", mktime(0, 0, 0, date("m" ,time())-$j , 1, date ("Y", time()) ) );?></span></div>
											</td>
											<?php
										}
										?>
										</tr>
										</table>
										</td>
										<td  style="border-top:1px solid #999999;">
										</td>
									</tr>
								</table>
					</td>
				</tr>
			</table>
			</td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<br />
<br />
<br />

<SCRIPT type="text/javascript">
 Event.observe("duree_abo_mois", "blur", function(evt){
 	nummask(evt,"0", "X");
 }, false);
 Event.observe("duree_abo_jour", "blur", function(evt){nummask(evt,"0", "X");
 }, false);
 Event.observe("engagement", "blur", function(evt){nummask(evt,"0", "X");}, false);
 Event.observe("reconduc_1", "click", function(evt){
 	if ($("reconduc_1").checked) {$("choix_reconduc").style.display = "";$("reconduction").focus();}
 }, false);
 Event.observe("reconduc_0", "click", function(evt){
 	if ($("reconduc_0").checked) {$("choix_reconduc").style.display = "none";$("reconduction").value = "0"}
 }, false);
 Event.observe("reconduction", "blur", function(evt){nummask(evt,"", "X");
 	if ($("reconduction").value=="0") {$("choix_reconduc").style.display = "none"; $("reconduc_0").checked = "checked";}
 }, false);
 Event.observe("preavis_abo_mois", "blur", function(evt){nummask(evt,"0", "X");}, false);
 Event.observe("preavis_abo_jour", "blur", function(evt){nummask(evt,"0", "X");}, false);

//fonction de validation de l'étape 3
function valide_etape_3() {
		submitform ("article_view_3"); 
}


Event.observe("search_type_abo_1", "click", function(evt){
	Event.stop(evt);
	page.verify("catalogue_articles_service_abo_recherche", "catalogue_articles_service_abo_recherche.php?ref_article=<?php echo  $article->getRef_article(); ?>&type_recherche=1", "true", "sub_content");
}, false);

Event.observe("search_type_abo_2", "click", function(evt){
	Event.stop(evt);
	page.verify("catalogue_articles_service_abo_recherche", "catalogue_articles_service_abo_recherche.php?ref_article=<?php echo  $article->getRef_article(); ?>&type_recherche=2", "true", "sub_content");
}, false);

Event.observe("search_type_abo_3", "click", function(evt){
	Event.stop(evt);
	page.verify("catalogue_articles_service_abo_recherche", "catalogue_articles_service_abo_recherche.php?ref_article=<?php echo  $article->getRef_article(); ?>&type_recherche=3", "true", "sub_content");
}, false);

Event.observe($("bt_etape_3b"), "click", function(evt){Event.stop(evt); valide_etape_3 ();});
 
//on masque le chargement
H_loading();
</SCRIPT>
</div>