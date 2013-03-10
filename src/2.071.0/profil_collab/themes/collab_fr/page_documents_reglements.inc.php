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
<div style="width:100%;">
<div style="padding:5px;">



<table style="width:100%">
		
			<tr>
			
			<td style="width: 50%; padding-left: 30px; padding-right: 30px; " >
				
				 <table style="width:98%; margin-top: 10px; " class="doc_reglement_toto" cellpadding="0" cellspacing="0">

					<?php 
						if (!isset($liste_reglements) || !$liste_reglements) {?>
							<tr>
								<td colspan="5" style="text-align:left; background-color:#809eb6 " class="doc_bold2">
								<span style="font-size:12px; padding-left:10px">R&egrave;glements d&eacute;j&agrave; effectu&eacute;s</span>
								</td>
							</tr>
							<tr>
								<td colspan="5" style="text-align:center">
								<span style="font-size:11px; font-style:italic;">Aucun r&egrave;glement enregistr&eacute;</span>
								</td>
							</tr>
							<?php
						} else {?>
							<tr>
								<td colspan="5" style="text-align:left; background-color:#809eb6 " class="doc_bold2">
								<span style="font-size:12px; padding-left:10px">R&egrave;glements d&eacute;j&agrave; effectu&eacute;s</span>
								</td>
							</tr>
						<?php
						foreach ($liste_reglements as $liste_reglement) {
						?>
						<tr id="ligne_reglement_<?php echo $liste_reglement->ref_reglement;?>" class="<?php if ($liste_reglement->valide) {echo "reglement_line_valide";} else {echo "reglement_line_unvalide";}?>" style="cursor:pointer">
							<td style=" padding-left:10px; font-size:11px; border-bottom:1px solid #d2d2d2;  width:20%"> 
							<?php 
							if ($liste_reglement->date_reglement!= 0000-00-00) {
								echo htmlentities ( date_Us_to_Fr ($liste_reglement->date_reglement));
							}
							?>
							</td>
							<td style="  padding-left:10px; font-size:11px; width:30%;border-bottom:1px solid #d2d2d2;">
							<?php echo htmlentities($liste_reglement->lib_reglement_mode); ?>
							</td>
							<td style=" text-align:right; padding-right:0px; font-size:11px; border-bottom:1px solid #d2d2d2; width:15%;" >
							<span class="doc_bold3"><?php echo htmlentities(number_format($liste_reglement->montant_on_doc, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]; ?></span> / 
							</td>
							<td style=" text-align:right; padding-right:10px; font-size:11px; border-bottom:1px solid #d2d2d2; width:12%;" >
							<?php echo htmlentities(number_format($liste_reglement->montant_reglement, $TARIFS_NB_DECIMALES, ".", ""	)); ?> 
							</td>
							
							
							<td style=" text-align:right; padding-right:10px; font-size:11px; width:23%;  border-bottom:1px solid #d2d2d2; ">
								<form method="post" action="documents_reglements_sup.php" id="documents_reglements_sup_<?php echo $liste_reglement->ref_reglement; ?>" name="documents_reglements_sup_<?php echo $liste_reglement->ref_reglement; ?>" target="formFrame">
								<input name="ref_reglement" id="ref_reglement" type="hidden" value="<?php echo $liste_reglement->ref_reglement; ?>" />
								<input name="ref_doc_<?php echo $liste_reglement->ref_reglement; ?>" id="ref_doc_<?php echo $liste_reglement->ref_reglement; ?>" type="hidden" value="<?php echo $document->getRef_doc () ?>" />
								</form>
								<a href="#" id="link_documents_reglements_delier_<?php echo $liste_reglement->ref_reglement; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/unlink.gif" border="0"></a>
								<a href="#" id="link_documents_reglements_sup_<?php echo $liste_reglement->ref_reglement; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
								<script type="text/javascript">
								Event.observe("link_documents_reglements_sup_<?php echo $liste_reglement->ref_reglement; ?>", "click",  function(evt){
									Event.stop(evt); alerte.confirm_supprimer('documents_reglements_sup', 'documents_reglements_sup_<?php echo $liste_reglement->ref_reglement; ?>');
									}, false);
								Event.observe("link_documents_reglements_delier_<?php echo $liste_reglement->ref_reglement; ?>", "click",  function(evt){
									Event.stop(evt);
									delier_doc_reglement ('<?php echo $document->getRef_doc();?>', '<?php echo $liste_reglement->ref_reglement;?>', '', '');
									 }, false);
								</script>
							
					</td>
							
						</tr>
                                                <script type="text/javascript">
                                                                    Event.observe("ligne_reglement_<?php echo $liste_reglement->ref_reglement;?>", "click", function(evt){
                                                                    page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $liste_reglement->ref_reglement;?>&ref_doc=<?php echo $document->getRef_doc();?>','true','edition_reglement');
                                                                    $("edition_reglement").show();
                                                                    $("edition_reglement_iframe").show();
                                                                    }, false);
                                                </script>
						<?php
					}
					?>
							<tr id="reglement_done2" style="display:none">
								<td colspan="4" style="text-align:left; border-left:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2; width:35%;">
									<span style="font-size:11px; font-style:italic; padding-left:10px; color:#FF0000">R&egrave;glement complet effectu&eacute;</span>
								</td>
								<td style=" text-align:right; padding-right:10px; font-size:11px; color:#FF0000; border-right:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2; width:15%;">
								</td>
							</tr>
							<?php
						}
						?>
							<tr id="reglement_partiel2" style="display:none">
								<td colspan="2" style="text-align:left;  width:50%;">
									<span style="font-size:11px; font-style:italic; padding-left:10px; color:#FF0000">Montant restant &agrave; r&eacute;gler:</span>						
								</td>
								<td style=" padding-right:8px; text-align:right; font-size:11px; color:#FF0000; ">
									<span id="montant_due2" class="doc_bold3" style="color:#FF0000;"> </span> <?php echo $MONNAIE[1]; ?>
								</td>	
								<td >
								</td>
								<td>
						<span id="montant_acquite2" style="display:none"><?php echo $montant_acquite; ?></span>
								</td>
							</tr>
				</table>
				</td>
				
				<td style="width: 50%; padding-left: 30px; padding-right: 30px;" >

                                 <?php
                                 $nb_echeances_aff = 0;
                                 if ($document->getId_type_groupe() == 1){
                                 ?>
				 <table id="table_echeanciers" name="table_echeanciers" style="width:98%; margin-top: 10px; " class="doc_reglement_toto" cellpadding="0" cellspacing="0">
                                 
					<?php //écheancier
						$montant_terme = 0;
						$nb_echeances_aff = 0;
						if (!isset($echeances) || !$echeances) {
						?>
							<tr>
								<td colspan="6" style="text-align:left; background-color:#809eb6 " class="doc_bold2">
								<span style="font-size:12px; padding-left:10px">Ech&eacute;ancier</span>
								<?php
                                                                if ($document->getRef_contact() != ""){
                                                                ?>
                                                                <input name="bt_ajouter" id="bt_ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" style="position:relative;left: 60%;width: 55px;padding-top:2px" />
								<script type="text/javascript">
								Event.observe('bt_ajouter', "click", function(evt){
										Event.stop(evt);
										doc_modifier_echeance("<?php echo $document->getRef_doc(); ?>", "<?php echo $montant_acquite ?>");
								});
								</script>
                                                                <?php
                                                                }
                                                                ?>
								</td>
							</tr>
							<tr>
								<td colspan="6" style="text-align:center">
				 				<span style="font-size:11px; font-style:italic;">Aucune &eacute;ch&eacute;ance enregistr&eacute;e.</span>
								</td>
							</tr>
							<?php
						} else {
						?>
							<tr>
								<td colspan="6" style="text-align:left; background-color:#809eb6 " class="doc_bold2">
								<span style="font-size:12px; padding-left:10px">Ech&eacute;ancier</span>
                                                                </td>
							</tr>
						<?php
                                                $nb_echeances_aff=0;
                                                foreach ($echeances as $echeance) {
						?> 
						<tr id="ligne_reglement_">
							<td style="padding-left:5px;font-size:11px; border-bottom:1px solid #d2d2d2;  width:20%;">
							<!-- ici les codes couleurs --> 
							<span ><img width="8px" height="8px" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_<?php echo $echeance->etat; ?>.png"/></span>&nbsp;
							<?php 
							if ($echeance->date!= 0000-00-00) {
								echo htmlentities ( date_Us_to_Fr ($echeance->date));
							}
                                                        else
                                                        {
                                                            if($echeance->jour == 0 || $echeance->jour == 1)
                                                                echo htmlentities ( $echeance->jour." jour");
                                                            else if($echeance->jour > 1)
                                                                echo htmlentities ( $echeance->jour." jours");
                                                        }
							?>
							</td>
							<td style=" text-align:left; padding-left:10px; font-size:11px; width:25%;border-bottom:1px solid #d2d2d2;">
							<?php echo htmlentities($echeance->type_reglement); ?>
							</td>
							<td style=" text-align:left; padding-left:10px; font-size:11px; width:35%;border-bottom:1px solid #d2d2d2;">
							<?php
                                                        /**************************/

                                                            //Récupération du contact
                                                            if(!empty($document)){

                                                                $contact_document = $document->getRef_contact();
                                                                $contact = new contact($contact_document);
                                                                //Récupération du mode préféré de paiement
                                                                if(!empty($contact))
                                                                {
                                                                    $profils = $contact->getProfils ();
                                                                    if(!empty($profils[4]))
                                                                    {
                                                                        $id_reglement_mode_favori = $profils[4]->getId_reglement_mode_favori (false);
                                                                        //Si pas de mode de reglement favori trouvé on va dans la categ
                                                                        if(empty($id_reglement_mode_favori))
                                                                        {
                                                                            $id_client_categ = $contact->getId_Categorie();
                                                                            //Charger la liste des catégories de client
                                                                            $liste_categories_client = contact_client::charger_clients_categories ();
                                                                            if(!empty($id_client_categ) && !empty($id_client_categ))
                                                                            {
                                                                                foreach ($liste_categories_client as $liste_categorie_client)
                                                                                {	if ( $id_client_categ == $liste_categorie_client->id_client_categ )
                                                                                        {
                                                                                                $categorie_client = $liste_categorie_client;
                                                                                        }
                                                                                }

                                                                                if(!empty($categorie_client)){
                                                                                    $id_reglement_mode_favori = $categorie_client->id_reglement_mode_favori;
                                                                                }

                                                                                //Si on a pas de reglement favoris alors on met choix du client
                                                                                if(empty($id_reglement_mode_favori))
                                                                                {
                                                                                    //rien
                                                                                }

                                                                            }

                                                                        }
                                                                    }


                                                                }


                                                            }

                                                        /**************************/
                                                        if ($echeance->mode_reglement == ""){
                                                            if(!empty($id_reglement_mode_favori))
                                                            {
                                                                global $bdd;
                                                                $query = "SELECT `lib_reglement_mode` FROM `reglements_modes` WHERE `id_reglement_mode` = '".$id_reglement_mode_favori."' ";
                                                                $retour = $bdd->query($query);

                                                                if($res = $retour->fetchObject()){
                                                                        echo htmlentities($res->lib_reglement_mode);
                                                                }

                                                            }
                                                            else
                                                            {
                                                                echo "Au choix du client";
                                                            }
                                                        }else{
                                                        global $bdd;
                                                        $query = "SELECT `lib_reglement_mode` FROM `reglements_modes` WHERE `id_reglement_mode` = '".$echeance->mode_reglement."' ";
                                                        $retour = $bdd->query($query);

                                                        if($res = $retour->fetchObject()){
                                                                echo htmlentities($res->lib_reglement_mode);
							}} ?>
							</td>
							<td style=" text-align:right; padding-right:0px; font-size:11px; border-bottom:1px solid #d2d2d2; width:25%">
							<?php echo htmlentities(number_format($echeance->montant, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]; ?> 
							</td>
							
							<?php if($nb_echeances_aff<0){ ?>
							<td style=" text-align:center; font-size:11px; width:15%;  border-bottom:1px solid #d2d2d2;vertical-align: middle">
							<input name="bt_modifier" id="bt_modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="width: 55px;padding-top: 2px" />	
							</td>
							<td style=" text-align:center; font-size:11px; width:15%;  border-bottom:1px solid #d2d2d2;vertical-align: middle">
							<input name="bt_supprimer" id="bt_supprimer" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-supprimer.gif" style="width: 55px;padding-top: 2px" />	
							</td>
							<?php } $nb_echeances_aff++;?>

								
							
						</tr>
							
						
						<?php
						if ($echeance->etat == 3){
							$montant_terme += $echeance->montant;
						}
					}
					?>
							<tr id="reglement_done2" style="display:none">
								<td colspan="4" style="text-align:left; border-left:1px solid #d2d2d2; ">
									<span style="font-size:11px; font-style:italic; padding-left:10px; color:#FF0000">R&egrave;glement complet effectu&eacute;</span>								</td>
								<td style=" text-align:right; padding-right:10px; font-size:11px; color:#FF0000; border-right:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;">
								</td>
							</tr>
							<tr id="reglement_partiel2" >
								<td colspan="3" style="text-align:left;  ">
									<span style="font-size:11px; font-style:italic; padding-left:10px; color:#FF0000">Montant des &eacute;ch&eacute;ances arriv&eacute;es &agrave; terme :</span>
									<span  class="doc_bold3" style="color:#FF0000;"> <?php echo htmlentities(number_format(($montant_terme-$montant_acquite)>=0 ? ($montant_terme-$montant_acquite):0, $TARIFS_NB_DECIMALES, ".", ""	)); ?>  <?php echo $MONNAIE[1]; ?></span>
                                                                </td>
								<td style=" text-align:right; font-size:11px; color:#FF0000;">
									<input name="bt_modifier" id="bt_modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="padding-top:2px" />
								</td>
								<td style="width:15%">
                                                                
                                                                <!-- ici espace pour s'aligner au niveau des codes couleurs du dessus -->
								</td>
							</tr>
							<?php
						}
						?>							
				</table>
                                <?php
                                 }
				if($nb_echeances_aff>0){ 
									?>
                                <script type="text/javascript">
                                //FKV
                                Event.observe('bt_modifier', "click", function(evt){
                                        Event.stop(evt);
                                        divPrinc = document.getElementById('id_body');
                                        divPrinc.setAttribute('id', 'id_body_princ');
                                        doc_modifier_echeance("<?php echo $document->getRef_doc(); ?>", "<?php echo $montant_acquite ?>");
                                });
                                /*Event.observe('bt_supprimer', "click", function(evt){
                                        Event.stop(evt);
                                        $("titre_alert").innerHTML = "<div style='width:100%; text-align:center'>Suppression de	l'&eacute;ch&eacute;ance</div>";
                                        $("texte_alert").innerHTML = "&Ecirc;tes-vous s&ucirc;r de bien	vouloir supprimer cette &eacute;ch&eacute;ance ?";
                                        $("bouton_alert").innerHTML = "<input type=\"submit\" id=\"bouton1\" name=\"bouton1\" value=\"Valider\" /><input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Annuler\" />";
                                        show_pop_alerte();
                                        $("bouton0").focus();
                                        $("bouton0").onclick= function () {
                                                hide_pop_alerte ();
                                        }
                                        $("bouton1").onclick= function () {
                                                hide_pop_alerte ();
                                                doc_supprimer_echeance("<?php //echo $document->getRef_doc(); ?>", "<?php //echo $montant_acquite ?>");
                                        }
                                });*/
                                </script>
                                    <?php } ?>
                                </td>
				
				
				
				<td style="width:10%">
				
				</td>
			</tr>
		</table>
		<table style="width:100%; margin-top: 10px;" id="reglements_types">
		<tr>
		<td style="text-align:center">
		<form action="documents_reglements_mode_valid.php" method="post" id="new_reglement" name="new_reglement" target="formFrame" >
		<input id="docs_<?php echo $document->getRef_doc(); ?>" name="docs_<?php echo $document->getRef_doc(); ?>" value="<?php echo $document->getRef_doc(); ?>" type="hidden" />
		<input id="doc_ACCEPT_REGMT" name="doc_ACCEPT_REGMT" value="<?php echo $document->getACCEPT_REGMT(); ?>" type="hidden" />
		<div style="display:none" id="docs_liste"></div>
		<div style="display:block; text-align:center;" id="reglement_choix_type">
			<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_reglements_choix.inc.php" ?>
		</div>
		</form>
		<?php if ($document->getId_type_doc() == $FACTURE_CLIENT_ID_TYPE_DOC || $document->getId_type_doc() == $FACTURE_FOURNISSEUR_ID_TYPE_DOC) { ?>
		<a href="#" id="cree_avoir" style="display:none; cursor:pointer; text-decoration:none">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_generer_bdachat.gif" border="0" style="padding:5px"/>
		</a>
		<script type="text/javascript">
		Event.observe('cree_avoir', "click", function(evt){
			Event.stop(evt);
			cree_avoir("<?php echo $document->getRef_doc(); ?>");
		});
		</script>
		<?php } ?>
		</td>
		</tr>
		</table>
		<div style="display:block; text-align:center;" id="liste_docs_nonreglees">
<?php if (!isset($load)) {?>
			<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_reglements_liste_docs_nonreglees.inc.php" ?>
<?php } ?>
		</div>
		
					
<script type="text/javascript">

<?php 
if (!isset($load)) {?>
montant_total_neg = false;
document_calcul_tarif ();
//on masque le chargement
H_loading();
<?php } ?>

</script>
</div>
</div>