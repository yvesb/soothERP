<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "ANNUAIRE_CATEGORIES", "DEFAUT_ID_PAYS", "listepays", "civilites", "onglet");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************	



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

///////////// for delete /////////////////
// pour l'instant
$debut = 1;
///////////// for delete /////////////////


 /* $cfg_nb_pages = 10;
  $barre_nav = "";
  $debut =(($form['page_to_show']-1)*$form['fiches_par_page']);
  
  $barre_nav .= barre_navigation($nb_fiches, $form['page_to_show'], 
                                       $form['fiches_par_page'], 
                                       $debut, $cfg_nb_pages,
                                       'page_to_show_s',
  																		 'page.annuaire_recherche_simple()');

*/

?>
<?php if (!isset($_REQUEST['val_mail'])) {?>
<div id="popup_more_infos" class="mini_moteur_doc" style="display:none;" ></div>
<div class="emarge">
	<p class="titre">
	<?php 
	//onglet : inscriptions_confirmees
	//onglet : inscriptions_non_confirmees
	//onglet : modification_confirmees
	//onglet : modification_non_confirmees
	switch($onglet){ 
	case "modification_confirmees" : 
	case "modification_non_confirmees" : { ?>
		Validation des modifications en attentes
	<?php break;}
	case "inscriptions_confirmees" : 
	case "inscriptions_non_confirmees" : 
	default : { ?>
		Validation des inscriptions en attentes
	<?php break;}
	}?>
	</p>
	<div  class="contactview_corps">
		<div id="valid_inscription"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; padding:10px ">
		
			<div class="mt_size_optimise">
				<div id="affresult">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					  <tr>
					    <td style="text-align:center;">
					    	<span id="inscriptions_confirmees" style="<?php if($onglet == "inscriptions_confirmees"){echo 'font-weight:bold;';}else{echo 'cursor: pointer;';}?>" >
					    		Inscriptions confirmées
					    	</span>
					    </td>
					    <td style="text-align:center;">
					    	<span id="inscriptions_non_confirmees" style="<?php if($onglet == "inscriptions_non_confirmees"){echo 'font-weight:bold;';}else{echo 'cursor: pointer;';}?>" >
					    		Inscriptions non confirmées
					    	</span>
					    </td>
					    <td style="text-align:center;">
					    	<span id="modification_confirmees" style="<?php if($onglet == "modification_confirmees"){echo 'font-weight:bold;';}else{echo 'cursor: pointer;';}?>" >
					    		Modifications confirmées
					    	</span>
					    </td>
					    <td style="text-align:center;">
					    	<span id="modification_non_confirmees" style="<?php if($onglet == "modification_non_confirmees"){echo 'font-weight:bold;';}else{echo 'cursor: pointer;';}?>" >
					    		Modifications non confirmées
					    	</span>
					    </td>
					  </tr>
					</table>
					<script type="text/javascript">
						//onglet : inscriptions_confirmees
						//onglet : inscriptions_non_confirmees
						//onglet : modification_confirmees
						//onglet : modification_non_confirmees
						<?php
						if($onglet != "inscriptions_confirmees") { ?>
							Event.observe("inscriptions_confirmees", "click", function (evt){
								page.traitecontent('inscriptions_confirmees','annuaire_valider_inscriptions.php?onglet=inscriptions_confirmees','true','sub_content');
							},false);
						<?php }
						if($onglet != "inscriptions_non_confirmees") { ?>
							Event.observe("inscriptions_non_confirmees", "click", function (evt){
								page.traitecontent('inscriptions_non_confirmees','annuaire_valider_inscriptions.php?onglet=inscriptions_non_confirmees','true','sub_content');
							},false);
						<?php }
						if($onglet != "modification_confirmees") { ?>
							Event.observe("modification_confirmees", "click", function (evt){
								page.traitecontent('modification_confirmees','annuaire_valider_inscriptions.php?onglet=modification_confirmees','true','sub_content');
							},false);
						<?php }
						if($onglet != "modification_non_confirmees") { ?>
							Event.observe("modification_non_confirmees", "click", function (evt){
								page.traitecontent('modification_non_confirmees','annuaire_valider_inscriptions.php?onglet=modification_non_confirmees','true','sub_content');
							},false);
						<?php } ?>
					</script>
				</div>
				
				<table id="tableresult" border="0" cellspacing="0" cellpadding="0" width="100%">
				  <tr class="colorise0">
				    <td width="35%">Nom (Civilité)</td>
				    <td width="15%">Profil / Interface</td>
				    <td width="15%">Catégorie</td>
				    <td width="15%">+ de détails</td>
				    <td width="10%">&nbsp;</td>
				    <td width="10%">&nbsp;</td>
				  </tr>
					
					<?php $colorise=0;
					//$inscriptions[]["id_contact_tmp"]
					//$inscriptions[]["date_demande"]
					//$inscriptions[]["infos"]
					//$inscriptions[]["id_civilite"]
					//$inscriptions[]["nom"]
					//$inscriptions[]["id_profil"]
					//$inscriptions[]["lib_profil"]
					//$inscriptions[]["id_interface"]
					//$inscriptions[]["lib_interface"]
					//$inscriptions[]["ref_contact"]
					//$inscriptions[]["id_categorie"]
					//$inscriptions[]["lib_categorie"]
					
				  foreach ($inscriptions as &$inscription) {
				    $colorise++;
				    $class_colorise = ($colorise % 2)? 'colorise1' : 'colorise2'; ?>
				    <tr id="id_ins_<?php echo $inscription["id_contact_tmp"]; ?>" class="<?php echo $class_colorise?>">
				      <td>
				        <a href="#" id="nom_<?php echo $inscription["id_contact_tmp"]; ?>" style="width:100%;">
				        	<?php echo $inscription['nom']; ?>
				        </a>
				        <script type="text/javascript">
				        <?php if($inscription["ref_contact"] != ""){?>
				        Event.observe("nom_<?php echo $inscription["id_contact_tmp"]; ?>", "click",  function(evt){
				            Event.stop(evt);
				            page.verify('affaires_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo($inscription["ref_contact"])?>','true','sub_content');
				        }, false);
				        <?php } ?>
				        </script>
				      </td>
				      <td>
				        <a href="#" id="categorie_<?php echo $inscription["id_contact_tmp"]; ?>" style="width:100%;">
				        	<?php echo $inscription["lib_profil"]." / ".$inscription["lib_interface"]; ?>
				        </a>
				      </td>
				      <td>
				        &nbsp;
				      </td>
				      <td style="width:20%; text-align:left">
				        <a href="#" id="more_<?php echo $inscription["id_contact_tmp"]; ?>" style="width:100%;">
				        	+ de détails
				        </a>
				        <script type="text/javascript">
				        Event.observe("more_<?php echo $inscription["id_contact_tmp"]; ?>", "click",  function(evt){
					        Event.stop(evt);
					        //chargerInfValIns(<?php echo $inscription["id_contact_tmp"]; ?>, <?php echo $inscription["id_interface"]; ?>);
					        //$('popup_more_infos').style.display = "block";
					       }, false);
				        </script>
				      </td>
				      <td style="text-align:left">
				        <a  href="#" id="valider_<?php echo $inscription["id_contact_tmp"]; ?>" style="width:100%;">
				        	Valider
				        </a>
				        <script type="text/javascript">
					        Event.observe("valider_<?php echo $inscription["id_contact_tmp"]; ?>", "click",  function(evt){
						        Event.stop(evt);
						        inscription_valider_refuser("<?php echo $inscription["id_contact_tmp"]; ?>", "valider", "<?php echo $onglet;?>");
						        }, false);
				        </script>
				      </td>
				      <td style="width:20%; text-align:left">
				        <a  href="#" id="refuser_<?php echo $inscription["id_contact_tmp"]; ?>" style="width:100%;">
				        	Refuser
				        </a>
				        <script type="text/javascript">
					        Event.observe("refuser_<?php echo $inscription["id_contact_tmp"]; ?>", "click",  function(evt){
						        Event.stop(evt);
						        inscription_valider_refuser("<?php echo $inscription["id_contact_tmp"]; ?>", "refuser", "<?php echo $onglet;?>");
									}, false);
				        </script>
				      </td>
				    </tr>
				    <?php
			  	}
				  ?>
				</table>
				
			</div>
			
		</div>
	</div>
</div>
<script type="text/javascript" language="javascript">
	//centrage du mini_moteur de recherche d'un contact
	centrage_element("popup_more_infos");
	centrage_element("pop_up_mini_moteur");
	centrage_element("pop_up_mini_moteur_iframe");
	
	Event.observe(window, "resize", function(evt){
		centrage_element("pop_up_mini_moteur_iframe");
		centrage_element("pop_up_mini_moteur");
		centrage_element("popup_more_infos");
	});

//Event.observe("order_nom", "click",  function(evt){Event.stop(evt);$('orderby_s').value='nom'; $('orderorder_s').value='<?php //if ($form['orderorder']=="ASC" && $form['orderby']=="nom") {echo "DESC";} else {echo "ASC";}?>'; page.annuaire_recherche_simple();}, false);
//centrage du mini_moteur de recherche d'un contact
centrage_element("popup_more_infos");
centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
centrage_element("popup_more_infos");
});
//on masque le chargement
H_loading();

// ]]>
</script>
<?php } ?>
