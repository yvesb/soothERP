<?php

// *************************************************************************************************************
// AFFICHAGE gestion des abonnements
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
<div class="emarge"><br />

<div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Gestion des abonnements 
</div>
<div class="emarge" style="text-align:right" >
<div id="corps_listes_abo">
	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
		<tr>
			<td rowspan="2" style="width:120px; height:50px">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_abo.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:90%">
			<br />
<br />
<br />

			<div style="width:90%; height:50px; padding:25px">
			<table width="100%" border="0" cellspacing="4" cellpadding="2">
				<tr>
					<td style=" font-weight:bolder; text-align: left; padding-left:10px">Libellé de l'article</td>
					<td style="width:17%; font-weight:bolder; text-align:center">Abonnements en cours</td>
					<td style="width:17%; font-weight:bolder; text-align:center">Abonnements à renouveler</td>
					<td style="width:16%;font-weight:bolder; text-align:center" colspan="3">Options</td>
				</tr>
			<?php 
			$ref_art_categ = "";
			$solde_total = 0;

			for($i=0; $i<count($liste_abonnements); $i++) {
				if ($ref_art_categ != $liste_abonnements[$i]->ref_art_categ) {
					?>
					<tr>
						<td colspan="6" style=""></td>
					</tr>
					<tr>
						<td colspan="6" style="font-weight:bolder; text-align:left; border-bottom:1px solid #999999"><?php echo ($liste_abonnements[$i]->lib_art_categ); ?>&nbsp;</td>
					</tr>
					<?php
					$ref_art_categ = $liste_abonnements[$i]->ref_art_categ;
				}
				
				?>
				<tr id="choix_caisse_<?php echo $liste_abonnements[$i]->ref_article; ?>">
					<td style="font-weight:bolder; text-align: left; color:#999999; padding-left:5px"><?php echo $liste_abonnements[$i]->lib_article;?></td>
					<td style="font-weight:bolder; text-align:center; color:#999999;">
						<span style="cursor:pointer;" id="ab_en_cours_<?php echo $liste_abonnements[$i]->ref_article;?>"><?php echo $liste_abonnements[$i]->nb_abo_en_cours;?></span></td>
					<td style="font-weight:bolder; text-align:center; color:#999999;">
						<span style="cursor:pointer;" id="ab_a_renouv_<?php echo $liste_abonnements[$i]->ref_article;?>"><?php echo $liste_abonnements[$i]->nb_abo_a_renouv;?></span>
						</td>
					<td style="width:6%; text-align:center">
						<span class="green_underlined" id="ge_<?php echo $liste_abonnements[$i]->ref_article; ?>" >Gestion</span>
						</td>
					<td style="width:5%; text-align:center; color:#97bf0d">-</td>
					<td style="width:6%; text-align:center">
						<span class="green_underlined" id="ab_<?php echo $liste_abonnements[$i]->ref_article; ?>">Clients</span>
					</td>
				</tr>
				<?php
			}?>
				<tr>
					<td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td>
				</tr>
				</tr>
			</table>
			</div>
			</td>
		</tr>
</table>
</div>
</div>

</div>


<SCRIPT type="text/javascript">

function setheight_choix_caisse(){
set_tomax_height("corps_listes_abo" , -32);
}
Event.observe(window, "resize", setheight_choix_caisse, false);
setheight_choix_caisse();


<?php 
foreach ($liste_abonnements as $abonnement) {
	?>
	Event.observe("ge_<?php echo $abonnement->ref_article; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("catalogue_articles_view", "catalogue_articles_view.php?service_abo=1&ref_article=<?php echo $abonnement->ref_article; ?>", "true", "sub_content");
	}, false);
	
	
	Event.observe("ab_<?php echo  $abonnement->ref_article; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("catalogue_articles_service_abo_recherche", "catalogue_articles_service_abo_recherche.php?ref_article=<?php echo  $abonnement->ref_article; ?>&type_recherche=1", "true", "sub_content");
	}, false);

	Event.observe("ab_en_cours_<?php echo  $abonnement->ref_article; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("catalogue_articles_service_abo_recherche", "catalogue_articles_service_abo_recherche.php?ref_article=<?php echo  $abonnement->ref_article; ?>&type_recherche=1", "true", "sub_content");
	}, false);

	Event.observe("ab_a_renouv_<?php echo  $abonnement->ref_article; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("catalogue_articles_service_abo_recherche", "catalogue_articles_service_abo_recherche.php?ref_article=<?php echo  $abonnement->ref_article; ?>&type_recherche=2", "true", "sub_content");
	}, false);
	<?php
}
?>
	
//on masque le chargement
H_loading();
</SCRIPT>