<?php

// *************************************************************************************************************
// EDITION D'UN ABONNEMENT
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
</script>
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_abonnement_edit" style="cursor:pointer; float:right" alt="Fermer" title="Fermer" />
<span style="font-weight:bolder">Edition d'un abonnement</span><br />
<br />
<span class="bolder"><?php echo htmlentities($article->getLib_article ()); ?></span>

<table width="100%" border="0">
	<tr>
		<td style="border:1px solid #d2d2d2;">	
		
		<form action="catalogue_articles_abonnement_edition_valid.php" method="post" id="catalogue_articles_abonnement_edition_valid" name="catalogue_articles_abonnement_edition_valid" target="formFrame" >
		
		<?php if(isset($source)){?>
			<input type="hidden" name="source" id="source" value="<?php echo $source;?>"/>
		<?php }?>
		<?php if(isset($develop_abo)){?>
			<input type="hidden" name="develop_abo" id="develop_abo" value="<?php echo $develop_abo;?>"/>
		<?php }?>
		<input type="hidden" name="abo_id_abo" id="abo_id_abo" value="<?php echo ($abonnement->id_abo); ?>"/>
		<input type="hidden" name="abo_ref_article" id="abo_ref_article" value="<?php echo ($abonnement->ref_article); ?>"/>
		<input type="hidden" name="abo_ref_contact" id="abo_ref_contact" value="<?php echo ($abonnement->ref_contact); ?>"/>
			<table width="100%" border="0" class="roundedtable">
				<tr>
					<td >
					<span class="labelled">Abonné:</span>
					</td>
					<td >
					<?php echo ($abonnement->nom); ?>					
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Souscription:</span>
					</td>
					<td >
						<input type="text" name="abo_date_souscription" id="abo_date_souscription" value="<?php echo date_Us_to_Fr($abonnement->date_souscription); ?><?php if ($ARTICLE_ABO_TIME) { echo " ".getTime_from_date($abonnement->date_souscription);} ?>"/>
					
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Echéance:</span>
					</td>
					<td >
						<input type="text" name="abo_date_echeance" id="abo_date_echeance" value="<?php echo date_Us_to_Fr($abonnement->date_echeance); ?><?php if ($ARTICLE_ABO_TIME) { echo " ".getTime_from_date($abonnement->date_echeance);} ?>"/>
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Fin d'engagement:</span>
					</td>
					<td >
						<input type="text" name="abo_fin_engagement" id="abo_fin_engagement" value="<?php echo date_Us_to_Fr($abonnement->fin_engagement); ?><?php if ($ARTICLE_ABO_TIME) { echo " ".getTime_from_date($abonnement->fin_engagement);} ?>"/>
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Préavis déposé le:</span>
					</td>
					<td >
						<input type="text" name="abo_date_preavis" id="abo_date_preavis" value="<?php if ($abonnement->date_preavis != "0000-00-00 00:00:00") {echo date_Us_to_Fr($abonnement->date_preavis); ?><?php if ($ARTICLE_ABO_TIME) { echo " ".getTime_from_date($abonnement->date_preavis);} }?>"/>
					
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Fin de l'abonnement:</span>
					</td>
					<td >
						<input type="text" name="abo_fin_abonnement" id="abo_fin_abonnement" value="<?php if ($abonnement->fin_abonnement != "0000-00-00 00:00:00") { echo date_Us_to_Fr($abonnement->fin_abonnement); ?><?php if ($ARTICLE_ABO_TIME) { echo " ".getTime_from_date($abonnement->fin_abonnement);} }?>"/>
					</td>
				</tr>
		</table><br />

		<div style="text-align:right">
		<input name="abonnement_mod_valid" id="abonnement_mod_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
		</div>
		</form>
		
		<form  action="catalogue_articles_service_abo_renouveller.php" id="service_renouveller_<?php echo $abonnement->id_abo;?>" name="service_renouveller_<?php echo $abonnement->id_abo;?>" method="post" target="formFrame">

			<input type="hidden" name="ref_article_service_renouveller_<?php echo $abonnement->id_abo;?>" value="<?php echo $abonnement->ref_article;?>"/>
			<input type="hidden" name="ref_contact_service_renouveller_<?php echo $abonnement->id_abo;?>" value="<?php echo $abonnement->ref_contact;?>"/>
			<input type="hidden" name="reconduction_service_renouveller_<?php echo $abonnement->id_abo;?>" value="1"/>
			<input type="hidden" name="id_abo" value="<?php echo $abonnement->id_abo;?>"/>
			
			<div style="text-align:right">
			<input name="abonnement_renouvellement" id="abonnement_renouvellement" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_renouveller.gif" />
			</div>
		</form>
		
		<?php /*
		<script type="text/javascript">
		Event.observe("renouveller", "click",  function(evt){
			Event.stop(evt);
			 
			$("titre_alert").innerHTML = 'Confirmer';
			$("texte_alert").innerHTML = 'Confirmer le renouvellement de cet abonnement';
			$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
			
			$("alert_pop_up_tab").style.display = "block";
			$("framealert").style.display = "block";
			$("alert_pop_up").style.display = "block";
			
			$("bouton0").onclick= function () {
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
			$("service_renouveller_<?php echo $abonnement->id_abo;?>").submit();
			}
			
			$("bouton1").onclick= function () {
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
			} 
		}, false);
		</script>
		*/?>
		
	<br />
	
		<form action="catalogue_articles_abonnement_edition_preavis.php" method="post" id="catalogue_articles_abonnement_edition_preavis" name="catalogue_articles_abonnement_edition_preavis" target="formFrame" >
		<input type="hidden" name="preavis_id_abo" id="preavis_id_abo" value="<?php echo ($abonnement->id_abo); ?>"/>
		<input type="hidden" name="preavis_ref_article" id="preavis_ref_article" value="<?php echo ($abonnement->ref_article); ?>"/>
		<input type="hidden" name="preavis_date_preavis" id="preavis_date_preavis" value=""/>
		</form>
		
		<SCRIPT type="text/javascript">
		<?php if ($ARTICLE_ABO_TIME) { ?>
			Event.observe("abo_date_souscription", "blur", datetimemask, false);
			Event.observe("abo_date_echeance", "blur", datetimemask, false);
			Event.observe("abo_date_preavis", "blur", function (evt) {
				datetimemask(evt);
				if ($("abo_date_preavis").value != "") {
					$("preavis_date_preavis").value = $("abo_date_preavis").value;
					$("titre_alert").innerHTML = 'Mise à jour de l\'abonnement';
					$("texte_alert").innerHTML = 'Mettre à jour la date de fin de l\'abonnement en fonction de la date de préavis';
					$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Oui" /><input type="submit" id="bouton1" name="bouton1" value="Non" />';
					
					$("alert_pop_up_tab").style.display = "block";
					$("framealert").style.display = "block";
					$("alert_pop_up").style.display = "block";
					
					$("bouton0").onclick= function () {
						$("framealert").style.display = "none";
						$("alert_pop_up").style.display = "none";
						$("alert_pop_up_tab").style.display = "none";
						$("catalogue_articles_abonnement_edition_preavis").submit();
					}
					
					$("bouton1").onclick= function () {
						$("framealert").style.display = "none";
						$("alert_pop_up").style.display = "none";
						$("alert_pop_up_tab").style.display = "none";
					} 
				}
			}, false);
			Event.observe("abo_fin_engagement", "blur", datetimemask, false);
			Event.observe("abo_fin_abonnement", "blur", datetimemask, false);
		<?php } else { ?>
			Event.observe("abo_date_souscription", "blur", datemask, false);
			Event.observe("abo_date_echeance", "blur", datemask, false);
			Event.observe("abo_date_preavis", "blur", function (evt) {datemask(evt);
				if ($("abo_date_preavis").value != "") {
					$("preavis_date_preavis").value = $("abo_date_preavis").value;
					$("titre_alert").innerHTML = 'Mise à jour de l\'abonnement';
					$("texte_alert").innerHTML = 'Mettre à jour la date de fin de l\'abonnement en fonction de la date de préavis';
					$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Oui" /><input type="submit" id="bouton1" name="bouton1" value="Non" />';
					
					$("alert_pop_up_tab").style.display = "block";
					$("framealert").style.display = "block";
					$("alert_pop_up").style.display = "block";
					
					$("bouton0").onclick= function () {
						$("framealert").style.display = "none";
						$("alert_pop_up").style.display = "none";
						$("alert_pop_up_tab").style.display = "none";
						$("catalogue_articles_abonnement_edition_preavis").submit();
					}
					
					$("bouton1").onclick= function () {
						$("framealert").style.display = "none";
						$("alert_pop_up").style.display = "none";
						$("alert_pop_up_tab").style.display = "none";
					} 
				}
			}, false);
			Event.observe("abo_fin_engagement", "blur", datemask, false);
			Event.observe("abo_fin_abonnement", "blur", datemask, false);
		<?php } ?>
		</SCRIPT>

		<span style=" font-weight:bolder">Liste des livraisons liées à cet abonnement</span>
		<div style=" background-color:#FFFFFF; border:1px solid #d6d6d6;">
		
		<?php
		$indentation_doc = 0;
		foreach ($abonnement->docs as $doc) {
		?>
		<table width="100%" border="0"  cellspacing="0" id="view_doc_<?php echo $indentation_doc;?>_<?php echo $doc->ref_doc;?>">
			<tr>
				<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:45%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td style="font-size:10px; cursor:pointer" id="doc1_<?php echo $indentation_doc;?>_<?php echo $doc->ref_doc;?>">
				
				</td>
				<td style="font-size:10px; cursor:pointer; " id="doc2_<?php echo $indentation_doc;?>_<?php echo $doc->ref_doc;?>">
				<?php echo $doc->ref_doc;?>
				</td>
				<td style="text-align:right; font-size:11px; padding-right:10px;  cursor:pointer" id="doc3_<?php echo $indentation_doc;?>_<?php echo $doc->ref_doc;?>">
				<?php	if ($doc->montant) { echo number_format($doc->montant, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }?>
				</td>
				<td style="padding-left:11px">
				</td>
			</tr>
			<tr>
				<td colspan="4"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
					<script type="text/javascript">
					Event.observe('doc1_<?php echo $indentation_doc;?>_<?php echo $doc->ref_doc;?>', "click", function(evt){
						page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $doc->ref_doc; ?>'),'true','_blank');
					});
					Event.observe('doc2_<?php echo $indentation_doc;?>_<?php echo $doc->ref_doc;?>', "click", function(evt){
						page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $doc->ref_doc; ?>'),'true','_blank');
					});
					Event.observe('doc3_<?php echo $indentation_doc;?>_<?php echo $doc->ref_doc;?>', "click", function(evt){
						page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $doc->ref_doc; ?>'),'true','_blank');
					});
					
					</script>
				</td>
			</tr>
		</table>
		<?php
		$indentation_doc++;
		}
		?>
		</div>
		</td>
	</tr>
</table>

<SCRIPT type="text/javascript">
Event.observe("close_abonnement_edit", "click", function(evt){
$("edition_abonnement").innerHTML="";
$("edition_abonnement").hide();
}, false);
//on masque le chargement
H_loading();
</SCRIPT>