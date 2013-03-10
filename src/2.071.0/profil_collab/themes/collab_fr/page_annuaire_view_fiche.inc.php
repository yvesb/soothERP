<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ("contact",  "ANNUAIRE_CATEGORIES", "DEFAUT_ID_PAYS" , "listepays", "coordonnees", "sites_web", "civilites", "profils");
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript" language="javascript">
array_menu_v_contact	=	new Array();
array_menu_v_contact[0] 	=	new Array('contactview_general', 'contactview_menu_a');
array_menu_v_contact[1] 	=	new Array('contactview_specifiques', 'contactview_menu_b');
<?php if (isset($profils[$CLIENT_ID_PROFIL] ) || isset($profils[$FOURNISSEUR_ID_PROFIL] )){
	?>
array_menu_v_contact[2] 	=	new Array('contactview_comptabilite', 'contactview_menu_c');
	<?php
}
?>
array_menu_v_contact[3] 	=	new Array('contactview_evenements', 'contactview_menu_d');
array_menu_v_contact[4] 	=	new Array('pieces_content', 'menu_9');
array_menu_v_contact[5] 	=	new Array('contactview_courrier', 'communication');
array_menu_v_contact[6] 	=	new Array('liaison_content', 'menu_liaisons');
<?php
foreach ($_SESSION['profils'] as $profil) {
	if (!$profil->getId_profil()) { continue; }
	if(isset($profils[$profil->getId_profil()]) ) {
		?>
array_menu_v_contact[<?php echo $profil->getId_profil()+5?>] =	new Array( 'x_typeprofil<?php echo $profil->getId_profil();?>', 'typeprofil_menu_<?php echo $profil->getId_profil();?>');
		<?php 
	}
}
?>
</script>
<div class="emarge" id="emarge">
<div id="edition_abonnement" class="edition_abonnement" style="display:none"></div>
<div id="courrier_choix_type" class="courrier_choix_type" style="display:none"></div>
<div id="courrier_options" class="courrier_options" style="display:none"></div>
<div id="edition_consommation" class="edition_consommation" style="display:none">
</div>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>

<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<div style="display:none;">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_nouvelle_fiche_caiu_vide.inc.php" ?>
</div>

<!-- On indique si le contact est archivé -->
<?php $date_archivage = $contact->getDate_archivage(); ?>
<span id="contact_in_arch" style="float:right; font-weight:bolder; color:#FF0000;<?php if ($date_archivage == NULL) {?> display:none;<?php } ?>" >Contact en archive.</span>

<p class="titre"><?php echo ($contact->getNom())?></p>

<div id="contactview_menu" class="menu">
<ul id="menu_ul">
<div style="float:right; width:160px">
	<span id="last_item_menu"><a href="#" id="contactview_menu_b" class="menu_unselect" style="float:right">Options avanc&eacute;es</a>
	<script type="text/javascript">
	Event.observe("contactview_menu_b", "click",  function(evt){
		Event.stop(evt);
		$("tool_uitem_menu").hide();
		if($("tool_uitem_menu_profils")){
			$("tool_uitem_menu_profils").hide();
		}
		view_menu_1('contactview_specifiques', 'contactview_menu_b', array_menu_v_contact);
		set_tomax_height('contactview_specifiques' , -46);
		set_tomax_height('contactview_c' , -52);
		set_tomax_height('annu_edtfiche_u' , -56);
	}, false);
	</script>
	</span>
</div>
<div id="tool_item_menu" style="float:right; width:60px; position:relative; cursor:pointer;">
	<span class="hymenu_unselect" style="float:right;">
	Outils
	</span>
	<span id="tool_uitem_menu" style="position:absolute; top:18px; left:5px; width:160px; text-align:right; display:none" >
		<!--- Comptabilité --->
		<span id="compta_item_menu" <?php if (!isset($profils[$CLIENT_ID_PROFIL] ) && !isset($profils[$FOURNISSEUR_ID_PROFIL] )){	?>style="display:none"<?php } ?>>
			<a href="#" id="contactview_menu_c" class="menu_unselect"  style="text-align: left">Comptabilité</a>
			<script type="text/javascript">
				Event.observe("contactview_menu_c", "click",  function(evt){
					Event.stop(evt);
					$("tool_uitem_menu").hide();
					if($("tool_uitem_menu_profils")){
						$("tool_uitem_menu_profils").hide();
					}
					view_menu_1('contactview_comptabilite', 'contactview_menu_c', array_menu_v_contact);
					set_tomax_height('contactview_comptabilite' , -46);
				}, false);
			</script>
		</span>
		<!--- Evénements --->
		<span id="event_item_menu" >
			<a href="#" id="contactview_menu_d" class="menu_unselect"  style="text-align: left">Evénements</a>
			<script type="text/javascript">
				Event.observe("contactview_menu_d", "click",  function(evt){
					Event.stop(evt); 
					$("tool_uitem_menu").hide();
					if($("tool_uitem_menu_profils")){
						$("tool_uitem_menu_profils").hide();
					}
					view_menu_1('contactview_evenements', 'contactview_menu_d', array_menu_v_contact); 
					set_tomax_height('contactview_event_liste' , -86);
					set_tomax_height('contactview_evenements' , -46); 
				
				}, false);
			</script>
		</span>
		<!--- Pièces jointes --->
		<span id="event_item_menu" >
			<a href="#" id="menu_9" class="menu_unselect"  style="text-align: left">Pièces jointes</a>
			<script type="text/javascript">
				Event.observe("menu_9", "click",  function(evt){
					Event.stop(evt); 
					$("tool_uitem_menu").hide();
					if($("tool_uitem_menu_profils")){
						$("tool_uitem_menu_profils").hide();
					}
					view_menu_1('pieces_content', 'menu_9', array_menu_v_contact); 
					set_tomax_height('pieces_content' , -46); 
					page.traitecontent('pieces_ged','pieces_ged.php?ref_objet=<?php echo $contact->getRef_contact(); ?>&type_objet=contact','true','pieces_content');
				
				}, false);
			</script>
		</span>
		<!--- Relations --->
		<span id="event_item_menu" >
			<a href="#" id="menu_liaisons" class="menu_unselect"  style="text-align: left">Relations</a>
			<script type="text/javascript">
				Event.observe("menu_liaisons", "click",  function(evt){
					Event.stop(evt); 
					$("tool_uitem_menu").hide();
					if($("tool_uitem_menu_profils")){
						$("tool_uitem_menu_profils").hide();
					}
					view_menu_1('liaison_content', 'menu_liaisons', array_menu_v_contact); 
					set_tomax_height('liaison_content' , -46); 
					page.traitecontent('liaison_content','annuaire_view_liaisons.php?ref_contact=<?php echo $contact->getRef_contact(); ?>','true','liaison_content');
				}, false);
			</script>
		</span>
	</span>
</div>
<div style="float:right; width:200px">
	<span id="communication_item_menu">
		<a href="#" id="communication" class="menu_unselect" style="float:right">Communication</a>
	</span>
	<script type="text/javascript">
	Event.observe("communication", "click",  function(evt){Event.stop(evt);
		$("tool_uitem_menu").hide();
		if($("tool_uitem_menu_profils")){
			$("tool_uitem_menu_profils").hide();
		}
		view_menu_1('contactview_courrier', 'communication', array_menu_v_contact); 
			set_tomax_height('contactview_courrier' , -46);
			page.traitecontent('communication_courrier','annuaire_view_courriers.php?ref_contact=<?php echo $contact->getRef_contact(); ?>','true','contactview_courrier');
	}, false);
	</script>
</div>
<script type="text/javascript">
Event.observe("tool_item_menu", "click",  function(evt){
	Event.stop(evt); 
	$("tool_uitem_menu").toggle();
	if($("tool_uitem_menu_profils")){
		$("tool_uitem_menu_profils").hide();
	}
}, false);
</script>
<li><a href="#" id="contactview_menu_a"  class="menu_select">Informations g&eacute;n&eacute;rales</a>
<script type="text/javascript">
Event.observe("contactview_menu_a", "click",  function(evt){
	Event.stop(evt); 
	$("tool_uitem_menu").hide();
	if($("tool_uitem_menu_profils")){
		$("tool_uitem_menu_profils").hide();
	}
	view_menu_1( 'contactview_general', 'contactview_menu_a', array_menu_v_contact); set_tomax_height('contactview_general' , -46);
	set_tomax_height('annu_editon_fiche_form_c' , -46);
	set_tomax_height('annu_edtfiche_caiu' , -52);
}, false);
</script>
</li>
<?php
	$i = 0;
	foreach ($_SESSION['profils'] as $profil) {
		if (!$profil->getId_profil()) { continue; }
		if(isset($profils[$profil->getId_profil()]) ) {
			if($i < 3){
			?>
				<li id="exist_profil_<?php echo $profil->getId_profil();?>">
					<a href="#" id="typeprofil_menu_<?php echo $profil->getId_profil();?>" 
						class="menu_unselect"><?php echo ($profil->getLib_profil());?>
					</a>
					<script type="text/javascript">
						Event.observe("typeprofil_menu_<?php echo $profil->getId_profil();?>", "click",  function(evt){
							Event.stop(evt);
							$("tool_uitem_menu").hide();
							if($("tool_uitem_menu_profils")){
								$("tool_uitem_menu_profils").hide();
							}
							view_menu_1('x_typeprofil<?php echo $profil->getId_profil();?>', 'typeprofil_menu_<?php echo $profil->getId_profil();?>', array_menu_v_contact);
							set_tomax_height('typeprofil<?php echo $profil->getId_profil()?>' , -46);
							set_tomax_height('x_typeprofil<?php echo $profil->getId_profil()?>' , -46);
						}, false);
					</script>
				</li>
			<?php
			}else{
				if($i == 3){
					// On créé le menu supplémentaire
					?>
					<div id="tool_item_menu_profils" style="float: left; position:relative; cursor:pointer;">
						<span class="hymenu_unselect" style="float:right;">Autres profils</span>
						<span id="tool_uitem_menu_profils" style="position:absolute; top:18px; width:160px; text-align:right; display:none">
					<?php 
				}
				// On peuple le menu supplémentaire
				?>
				<span id="compta_item_menu_<?php echo $i; ?>" <?php if (!isset($profils[$CLIENT_ID_PROFIL] ) && !isset($profils[$FOURNISSEUR_ID_PROFIL] )){	?>style="display:none"<?php } ?>>
					<a href="#" id="typeprofil_menu_<?php echo $profil->getId_profil();?>" style="text-align: left;"
						class="menu_unselect"><?php echo ($profil->getLib_profil());?>
					</a>
					<script type="text/javascript">
						Event.observe("typeprofil_menu_<?php echo $profil->getId_profil();?>", "click",  function(evt){
							Event.stop(evt);
							$("tool_uitem_menu").hide();
							$("tool_uitem_menu_profils").hide();
							view_menu_1('x_typeprofil<?php echo $profil->getId_profil();?>', 'typeprofil_menu_<?php echo $profil->getId_profil();?>', array_menu_v_contact);
							set_tomax_height('typeprofil<?php echo $profil->getId_profil()?>' , -46);
							set_tomax_height('x_typeprofil<?php echo $profil->getId_profil()?>' , -46);
						}, false);
					</script>
				</span>
				<?php 
			}
			$i++;
		}
	}
	if($i > 3){
		?>
		</span>
		</div>
		<script type="text/javascript">
			Event.observe("tool_item_menu_profils", "click",  function(evt){
				Event.stop(evt); 
				$("tool_uitem_menu_profils").toggle();
				$("tool_uitem_menu").hide();
			}, false);
		</script>
		<?php 
	}
?>
<div style="width:1px" id="insertprof_before"></div>
</ul>
</div>




<div id="contactview">

<div id="contactview_general" class="menu_link_affichage" >

	<table cellspacing="0" class="minimizetable"><tr><td class="contactview_corps">
		<div id="annu_editon_fiche_form_c"  style="OVERFLOW-Y: auto; OVERFLOW-X: hidden; width:99.8%"> 

		<div style="width:97%; padding:10px"> 
	
		<form id="annu_editon_fiche_form" style="padding:0; margin:0;" method="post" action="annuaire_edition_fiche.php" target="formFrame">
		<input name="compte_info"  id="compte_info" type="hidden" value="0" />
		<input name="modif_contact"  id="modif_contact" type="hidden" value="" />
		<input type="hidden" name="ref_contact" id="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<table cellpadding="0" cellspacing="0" border="0" class="roundedtable"><tr>
	<td>
<table class="minimizetable" id="nom_lib" cellpadding="0" cellspacing="0" border="0">
		<tr class="smallheight">
				<td class="size_strict" style="width:85px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td  style="width:215px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td><span class="labelled" style="width:85px">Nom:</span></td>
			<td><a href="#" id="link_show_nom" class="modif_textarea3"><?php echo nl2br(($contact->getNom())); ?></a>
	<script type="text/javascript">
	Event.observe("link_show_nom", "click",  function(evt){Event.stop(evt); show_edit_form('nom_mask', 'nom_lib','nom');}, false);
	</script>
			
			</td>
			<td><span class="labelled" id="line_siret3"  style="margin-left:50px; display:none;" title="Numéro de Siret">Siret:</span></td>
			<td><a href="#" id="line_siret4" class="modif_textarea3" style="display:none"><?php echo $contact->getSiret ();?></a>
	<script type="text/javascript">
	Event.observe("line_siret4", "click",  function(evt){Event.stop(evt); show_edit_form('nom_mask', 'nom_lib','siret');}, false);
	</script>
			</td>
		</tr>
		<tr>
			<td><span class="labelled" style="width:85px">Cat&eacute;gorie:</span></td>
			<td>
				<a href="#" id="link_show_id_categ" class="modif_select1"><?php echo ($contact->getLib_Categorie()); ?></a>
			<script type="text/javascript">
			Event.observe("link_show_id_categ", "click",  function(evt){Event.stop(evt); show_edit_form('nom_mask', 'nom_lib','id_categorie');}, false);
			</script>
				</td>
			<td><span class="labelled" style="margin-left:50px">Civilit&eacute;:</span></td>
			<td>
				<a href="#" id="link_show_civili" class="modif_select1"><?php echo ($contact->getLib_civ_court()); ?></a>
				<script type="text/javascript">
				Event.observe("link_show_civili", "click",  function(evt){Event.stop(evt); show_edit_form('nom_mask', 'nom_lib','civilite');}, false);
				</script>
			</td>
		</tr>
	</table>
	<table class="minimizetable" id="nom_mask" style="display:none;" cellpadding="0" cellspacing="0" border="0">
		<tr class="smallheight">
				<td class="size_strict" style="width:85px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td  style="width:215px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td><span class="labelled" style="width:85px">Nom:</span></td>
			<td><textarea id="nom" name="nom"  rows="<?php if (stristr($_SERVER["HTTP_USER_AGENT"], "firefox")) { echo "1"; } else { echo "2"; } ?>" class="classinput_xsize"><?php echo $contact->getNom()?></textarea></td>
			
			<td><span class="labelled" id="line_siret"  style="margin-left:50px; display:none;" title="Numéro de Siret">Siret:</span></td>
			<td><span id="line_siret2" style="display:none;">
						<input type="text" id="siret" name="siret" rows="2" value="<?php echo $contact->getSiret ();?>"  class="classinput_xsize"/></span>
			</td>
		</tr>
		<tr>
			<td><span class="labelled" style="width:85px">Cat&eacute;gorie:</span></td>
			<td>
			<select id="id_categorie" name="id_categorie" class="classinput_xsize">
				<?php foreach ($ANNUAIRE_CATEGORIES as $categorie) {
					?>
					<option value="<?php echo  $categorie->id_categorie?>" <?php
	if ( $categorie->id_categorie == $contact->getId_Categorie()) { echo 'selected="selected"'; }
	?>><?php echo ($categorie->lib_categorie)?></option>
					<?php
				}
				?>
			</select>
			</td>
			<td><span class="labelled" style="margin-left:50px">Civilit&eacute;:</span></td>
			<td>
			<select name="civilite" id="civilite" class="classinput_xsize">
				<?php foreach ($civilites as $civ) {
					?>
					<option value="<?php echo  urlencode($civ->id_civilite) ?>"<?php
		if ($civ->id_civilite == $contact->getId_civilite ()) { echo 'selected="selected"'; }
		?>><?php echo ($civ->lib_civ_court)?></option>
					<?php 
				}
				?>
			</select>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	</table><br />
	<div style="text-align:right; margin-right:10px;visibility: hidden;" id="submit">
		<input type="image" name="submit"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" style=""/>
	</div>
	</form>

	  
	<div id="liste_document_client" style="display:<?php if (!isset($profils[$CLIENT_ID_PROFIL] )){echo "none";}?> ">
	<?php if (isset($profils[$FOURNISSEUR_ID_PROFIL] )){?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr >
			<td style="width:35px;"><div style="height:9px; border-bottom:1px solid #00336c">&nbsp;</div></td>
			<td style=" width:255px; font-weight:bolder; color:#00336c; font-size:14px; padding-left:3px; padding-right:3px">Nouveaux documents Client</td>
			<td ><div style="height:9px; border-bottom:1px solid #00336c">&nbsp;</div></td>
		</tr>
	</table>
	<?php }?> 
  

	
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/contact_new_devis.gif" style="padding-left:5%; cursor:pointer;" onclick="page.verify('document_nouveau_dev','documents_nouveau.php?id_type_doc=<?php echo $DEVIS_CLIENT_ID_TYPE_DOC;?>&ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');" />
	
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/contact_new_commande.gif" style="padding-left:5%; cursor:pointer;" onclick="page.verify('document_nouveau_cdc','documents_nouveau.php?id_type_doc=<?php echo $COMMANDE_CLIENT_ID_TYPE_DOC;?>&ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');" />
	
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/contact_new_livraison.gif" style="padding-left:5%; cursor:pointer;" onclick="page.verify('document_nouveau_blc','documents_nouveau.php?id_type_doc=<?php echo $LIVRAISON_CLIENT_ID_TYPE_DOC;?>&ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');" />
	
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/contact_new_facture.gif" style="padding-left:5%; cursor:pointer;" onclick="page.verify('document_nouveau_fac','documents_nouveau.php?id_type_doc=<?php echo $FACTURE_CLIENT_ID_TYPE_DOC;?>&ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');" />
	
	</div><br />

	
	<div id="liste_document_fournisseur" style="display:<?php if (!isset($profils[$FOURNISSEUR_ID_PROFIL] )){echo "none";}?> ">
	<?php if (isset($profils[$CLIENT_ID_PROFIL] )){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr >
					<td style="width:35px;"><div style="height:9px; border-bottom:1px solid #00336c">&nbsp;</div></td>
					<td style=" width:255px; font-weight:bolder; color:#00336c; font-size:14px; padding-left:3px; padding-right:3px">Nouveaux documents Fournisseur</td>
					<td ><div style="height:9px; border-bottom:1px solid #00336c">&nbsp;</div></td>
				</tr>
			</table>
	<?php }?> 
	
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/contact_new_devis.gif" style="padding-left:5%; cursor:pointer;" onclick="page.verify('document_nouveau_def','documents_nouveau.php?id_type_doc=<?php echo $DEVIS_FOURNISSEUR_ID_TYPE_DOC;?>&ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');" />
	
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/contact_new_commande.gif" style="padding-left:5%; cursor:pointer;" onclick="page.verify('document_nouveau_cdf','documents_nouveau.php?id_type_doc=<?php echo $COMMANDE_FOURNISSEUR_ID_TYPE_DOC;?>&ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');" />
	
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/contact_new_reception.gif" style="padding-left:5%; cursor:pointer;" onclick="page.verify('document_nouveau_blf','documents_nouveau.php?id_type_doc=<?php echo $LIVRAISON_FOURNISSEUR_ID_TYPE_DOC;?>&ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');" />
	
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/contact_new_facture.gif" style="padding-left:5%; cursor:pointer;" onclick="page.verify('document_nouveau_faf','documents_nouveau.php?id_type_doc=<?php echo $FACTURE_FOURNISSEUR_ID_TYPE_DOC;?>&ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');" />
	
	</div>
<br />

			<?php
			$first_docs = 0;
			if (count($contact_last_docs )) {
				?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr >
					<td style="width:35px;"><div style="height:9px; border-bottom:1px solid #00336c">&nbsp;</div></td>
					<td style=" width:85px; font-weight:bolder; color:#00336c; font-size:14px; padding-left:3px; padding-right:3px">DOCUMENTS</td>
					<td ><div style="height:9px; border-bottom:1px solid #00336c">&nbsp;</div></td>
				</tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
				<tr class="smallheight" style="">
					<td style="width:85px; "><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					<td style="width:120px; "><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					<td style="width:100px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				</tr>
				<tr style="text-align:left; vertical-align:top; color:#00336c; font-weight:bolder">
					<td style="  text-align:left; padding-left:5px; font-weight:bolder">Date</td>
					<td style=" text-align:left; padding-left:5px; font-weight:bolder">Document</td>
					<td style="  text-align:left; padding-left:5px; font-weight:bolder">Etat</td>
					<td style=" text-align:center; padding-left:5px; font-weight:bolder">Prix</td>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" width="25px"/></td>
				</tr>
				</table>
				<div class="art_new_info" >
				<?php
				foreach ($contact_last_docs as $contact_last_doc) {
					?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
					<tr class="smallheight" style="">
						<td style="width:85px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td style="width:120px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td style="width:100px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					</tr>
					<tr style="cursor:pointer; color:#002673">
						<td style=" border-bottom:1px solid #FFFFFF; text-align:left; padding-left:5px" id="open_doc_<?php echo ($contact_last_doc->ref_doc);?>">
						<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
						</td>
						<td style="  border-bottom:1px solid #FFFFFF; text-align:left; padding-left:5px" id="open_doc_1_<?php echo ($contact_last_doc->ref_doc);?>">
							<?php echo ($contact_last_doc->lib_type_doc);?> - <?php echo ($contact_last_doc->ref_doc);?>
						</td>
						<td style=" border-bottom:1px solid #FFFFFF; text-align:left; padding-left:5px" id="open_doc_2_<?php echo ($contact_last_doc->ref_doc);?>">
							<?php echo ($contact_last_doc->lib_etat_doc);?>
						</td>
						<td style=" border-bottom:1px solid #FFFFFF; text-align:right; padding-right:15px" id="open_doc_3_<?php echo ($contact_last_doc->ref_doc);?>">
						<?php echo (price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
						</td>
						<td style=" border-bottom:1px solid #FFFFFF; text-align:center; ">
						<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
						</td>
					</tr>
					</table>
					<script type="text/javascript">
						Event.observe('open_doc_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
						Event.observe('open_doc_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
						Event.observe('open_doc_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
						Event.observe('open_doc_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
					</script>
					<?php 
					$first_docs ++;
				}
				?>
				</div><br />

				<div id="show_all_docs" class="link_to_doc_fromart" style="float:right">&gt;&gt;Consulter l'ensemble des documents concernant ce contact </div><br />
				<?php 
			}
			?>
	</div><br />
        <img id="print_contact" src ="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" style="cursor:pointer" />
		<form id="annu_editon_fiche_form2" style="padding:0; margin:0;" method="post" action="annuaire_edition_fiche.php" target="formFrame">
		<input name="compte_info"  id="compte_info" type="hidden" value="0" />
		<input name="modif_contact"  id="modif_contact" type="hidden" value="" />
		<input type="hidden" name="ref_contact" id="ref_contact" value="<?php echo $contact->getRef_contact()?>">
	<table class="minimizetable">
		<tr class="smallheight">
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td class="ctpc"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td class="ctpc"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td colspan="4">
			<textarea id="note" name="note" rows="5"  class="classinput_xsize"><?php echo  ($contact->getNote())?></textarea></td>
		</tr>
	</table>
	<div style="text-align:right; margin-right:10px;visibility: hidden;" id="submit2">
		<input type="image" name="submit2"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" style=""/>
	</div>
	</form>
	
	</div>
	</td><td class="infotable_bg">
<div id="menu_caiu" class="menu_sec" style="float:left; width:100%">
<ul>
<li><a href="#" class="menu_sec_select" id="select_menu_caiu1">Coordonn&eacute;es</a></li>
<li><a href="#" class="menu_sec_unselect" id="select_menu_caiu2">Adresses</a></li>
<li><a href="#" class="menu_sec_unselect" id="select_menu_caiu3">Sites Web</a></li>
</ul>
<script type="text/javascript">
Event.observe("select_menu_caiu1", "click",  function(evt){Event.stop(evt); view_menu_sec( 'annu_nvlfiche_coord',  'select_menu_caiu1', 'annu_nvlfiche_adresse', 'select_menu_caiu2','annu_nvlfiche_internet',  'select_menu_caiu3');}, false);
Event.observe("select_menu_caiu2", "click",  function(evt){Event.stop(evt); view_menu_sec( 'annu_nvlfiche_adresse', 'select_menu_caiu2', 'annu_nvlfiche_coord', 'select_menu_caiu1','annu_nvlfiche_internet',  'select_menu_caiu3');}, false);
Event.observe("select_menu_caiu3", "click",  function(evt){Event.stop(evt); view_menu_sec( 'annu_nvlfiche_internet',  'select_menu_caiu3','annu_nvlfiche_adresse', 'select_menu_caiu2', 'annu_nvlfiche_coord', 'select_menu_caiu1');}, false);
</script>
</div>
<br />




<div id="annu_edtfiche_caiu" style=" width:330px; OVERFLOW-Y: scroll; FLOAT: left; OVERFLOW-X: hidden; ">


<div id="annu_nvlfiche_coord">
<ul  id="coordlist2">
<?php 
$ref_user = $_SESSION['user']->getRef_user();
$caiu = 0;
foreach ($coordonnees as $coordonnee) {
	$droitCoord= true;
	
	$droitsVoirCoord = getDroitVoirCoordonnees($ref_user);
	if(count($droitsVoirCoord)>0){
	if($coordonnee->getType() != ""  && $coordonnee->getType() != 0 && $droitsVoirCoord[0] != "ALL"){
		if(!in_array($coordonnee->getType(),$droitsVoirCoord)){$droitCoord= false;}
	}
	if($droitCoord){
		?>
		<li id="coordcontent_li_<?php echo $caiu?>">
		<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_coordonnee.inc.php" ?>
		</li>
		<?php
		$caiu++;
	}
	}else{
		if($coordonnee->getType() == ""  || $coordonnee->getType() == 0){
		?>
		<li id="coordcontent_li_<?php echo $caiu?>">
		<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_coordonnee.inc.php" ?>
		</li>
		<?php
		$caiu++;
		}
	}		
}
?>
</ul>
<ul id="coordlist">
</ul>
<a href="#" class="ajout"  id="link_add_new_coord">Ajouter une nouvelle coordonn&eacute;e</a>
<script type="text/javascript">
Event.observe("link_add_new_coord", "click",  function(evt){Event.stop(evt); createtagmobil('coordlist','li','coordcontent', 'edition_coordonnee_nouvelle');}, false);
</script>
</div>



<div id="annu_nvlfiche_adresse"  style=" display:none;">
<ul id="adresslist2">
<?php
foreach ($adresses as $adresse) {
	$droitAdresse= true;
	
	$droitsVoirAdresses = getDroitVoirAdresse($ref_user);
	if(count($droitsVoirAdresses)>0){
	if($adresse->getType() != ""  && $adresse->getType() != 0 && $droitsVoirAdresses[0] != "ALL"){
		if(!in_array($adresse->getType(),$droitsVoirAdresses)){$droitAdresse= false;}
	}
	if($droitAdresse){
		?>	
		<li id="adressecontent_li_<?php echo $caiu?>">
		<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_adresse.inc.php" ?>
		</li>
		<?php
		$caiu++;
	}
	}else{
		if($adresse->getType() == ""  || $adresse->getType() == 0){
			?>	
			<li id="adressecontent_li_<?php echo $caiu?>">
			<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_adresse.inc.php" ?>
			</li>
			<?php
			$caiu++;
		}		
	}
}
?>
</ul>
<ul id="adresslist">
</ul>
<a href="#" class="ajout" id="link_add_new_adress">Ajouter une nouvelle adresse</a>
<script type="text/javascript">
Event.observe("link_add_new_adress", "click",  function(evt){Event.stop(evt); createtagmobil('adresslist','li','adressecontent', 'edition_adresse_nouvelle');}, false);
</script>
</div>



<div id="annu_nvlfiche_internet" style=" display:none; ">
<ul  id="sitelist2">
<?php 
foreach ($sites_web as $site_web) {
	$droitSite= true;
	
	$droitsVoirsite = getDroitVoirSiteWeb($ref_user);
	if(count($droitsVoirsite)>0){
	if($site_web->getType() != ""  && $site_web->getType() != 0 && $droitsVoirsite[0] != "ALL"){
		if(!in_array($site_web->getType(),$droitsVoirsite)){$droitSite= false;}
	}
	if($droitSite){
		?>
		<li id="sitecontent_li_<?php echo $caiu?>">
		<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_site.inc.php" ?>
		</li>
		<?php
		$caiu++;
	}
	}else{
		if($site_web->getType() == ""  || $site_web->getType() == 0){
			?>
			<li id="sitecontent_li_<?php echo $caiu?>">
			<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_site.inc.php" ?>
			</li>
			<?php
			$caiu++;
		}
	}			
}
?>
</ul>
<ul id="sitelist">
</ul>
<a href="#" class="ajout"  id="link_add_new_site">Ajouter un nouveau site
</a>
<script type="text/javascript">
Event.observe("link_add_new_site", "click",  function(evt){Event.stop(evt); createtagmobil('sitelist','li','sitecontent', 'edition_site_nouvelle');}, false);
</script>
</div>
</div>
</td></tr></table>
</div>



<div id="contactview_evenements" class="menu_link_affichage" style="display:none;">
	<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_evenements.inc.php" ?>
</div>
<div id="edition_event" class="edition_event" style="display:none">
</div>

<div id="contactview_specifiques" class="menu_link_affichage" style="display:none;">
<table class="minimizetable" cellspacing="0"><tr>
	<td class="contactview_corps">
<div id="contactview_c"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; padding:10px ">
<table class="main_table">
	<tr>
		<td style="width:140px"><span class="labelled">R&eacute;f&eacute;rence: </span></td>
		<td><?php echo $contact->getRef_contact()?></td>
	</tr>
	<tr>
		<td><span class="labelled">Cr&eacute;ation : </span></td>
		<td><?php echo $contact->getDate_creation()?></td>
	</tr>
	<tr>
		<td><span class="labelled">Modification : </span></td>
		<td><?php echo $contact->getDate_modification()?></td>
	</tr>
</table>


<div id="type_fiche">
<?php
		include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_check_profil.inc.php";
?>
</div>


<div style=" border-top:1px dashed #002673;">

	
<a href="#" id="fusionner_contact" style="text-decoration:underline; color:#000000">fusionner avec une autre fiche</a>
<form id="annu_fusion" name="annu_fusion" method="post" action="annuaire_fusion.php" target="formFrame">
<input type="hidden" name="old_ref_contact" id="old_ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="new_ref_contact" id="new_ref_contact" value="">
</form>
<br />

<div id="block_suspendre_user" style="display: <?php if (!count($users)) {?>none<?php }?>">
	<a href="#" id="suspendre_user" style="text-decoration:underline; color:#000000">suspendre les utilisateurs de ce contact</a>
	<form id="contact_suspendre_user" name="contact_suspendre_user" method="post" action="annuaire_suspendre_user.php" target="formFrame">
	<input type="hidden" name="users_ref_contact" id="users_ref_contact" value="<?php echo $contact->getRef_contact()?>">
	</form>
	<br />
</div>

<?php if($date_archivage == NULL){ ?>
<a href="#" id="supprimer_contact" style="text-decoration:underline; color:#000000">supprimer ce contact (archiver)</a>
<form id="contact_archivage" name="contact_archivage" method="post" action="annuaire_archivage.php" target="formFrame">
<input type="hidden" name="archivage_ref_contact" id="archivage_ref_contact" value="<?php echo $contact->getRef_contact()?>">
</form>
<?php } ?>

<br />



	</div>
</div>
</td>
<td class="infotable_bg">
<div id="annu_edtfiche_u" style=" width:330px; OVERFLOW-Y: scroll; FLOAT: left; OVERFLOW-X: hidden; ">
<div id="annu_nvlfiche_user">
<ul  id="userlist2">
<?php 
foreach ($users as $user) {
	//permission (7) Gestion des collaborateurs
	if (!$_SESSION['user']->check_permission ("7") && isset($profils[$COLLAB_ID_PROFIL])) {continue;}
	//permission (8) Gestion des Administrateurs
	if (!$_SESSION['user']->check_permission ("8") && isset($profils[$ADMIN_ID_PROFIL])) {continue;}
	?>
	<li id="usercontent_li_<?php echo $caiu?>">
	<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_user.inc.php" ?>
	</li>
	<?php
	$caiu++;
}
?>
</ul>
<ul id="userlist">
</ul>
<a href="#" class="ajout"  id="link_add_new_user" <?php 
									//permission (7) Gestion des collaborateurs
									if (!$_SESSION['user']->check_permission ("7") && isset($profils[$COLLAB_ID_PROFIL])) { echo 'style="display:none"'; }
									//permission (8) Gestion des Administrateurs
									if (!$_SESSION['user']->check_permission ("8") && isset($profils[$ADMIN_ID_PROFIL])) { echo 'style="display:none"'; }?>>Ajouter un nouvel utilisateur</a><br/>

<div><span class="infobulle" id="email_user_creation_info%//%">
					<span>
					<p class="infotext">Proposez &agrave; ce contact de devenir utilisateur</p>
					</span>
					</span>									

<?php  
if(isset($coordonnee)){
$ref_contact = $coordonnee->getRef_contact();
$ref_coord = $coordonnee->getRef_coord();
if($coordonnee->getEmail()){
?>
	<a href="#" class="ajout" id="envoi_mail" name="envoi_mail">Inviter ce contact à créer un compte utilisateur</a>
<script type="text/javascript">
Event.observe('envoi_mail', 'click',  function(evt){
	Event.stop(evt);
				var AppelAjax = new Ajax.Request(
								"annuaire_envoi_mail.php",
								{
								"method": 'post',
								parameters: {ref_coord : "<?php echo $ref_coord ?>",
									ref_contact : "<?php echo $ref_contact ?>" },
								evalScripts:true,
								onLoading:S_loading, onException: function () {S_failure();},
								onSuccess: function (requester){
														requester.responseText.evalScripts();
														H_loading();
														}
								}
								);



	},false);
</script>
    <?php
}
} ?>


</div>
<script type="text/javascript">
Event.observe("link_add_new_user", "click",  function(evt){Event.stop(evt); createtagmobil('userlist','li','usercontent', 'edition_user_nouvelle');}, false);
</script>

<br />
<br />
<br />
<br />
<br />
<br />
<br />

</div>
</div>
</td>
</tr>
</table>
</div>

<div id="zoneprofils">
<?php
ini_set("memory_limit", "50M");
	foreach ($profils as  $id_profil => $profil) {
		?>
		<div id="x_typeprofil<?php echo $id_profil?>" class="menu_link_affichage" style="display:none;">
		<div id="typeprofil<?php echo $id_profil?>" class="contactview_corps" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; ">
		<?php
		//permission (7) (8) Gestion des collaborateurs administrateurs
		if ((!$_SESSION['user']->check_permission ("7") && $id_profil == $COLLAB_ID_PROFIL) || (!$_SESSION['user']->check_permission ("8") && $id_profil == $ADMIN_ID_PROFIL)) { 
			echo "Vos droits d'accès ne vous permettent pas de visionner les informations de ce profil.";
		} else {
			include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_fiche_profil".$id_profil.".inc.php";
		}
		?>
		<br />
		<br />
		</div>
		</div>
		<?php 
	}
?>	
</div>

<!-- ############################################################################################################ -->

<div id="liaison_content" class="contactview_corps" style="display:none; OVERFLOW-Y: auto; OVERFLOW-X: auto; " >
</div>

<!-- ############################################################################################################ -->

<div id="contactview_courrier" class="contactview_corps" style="display:none; OVERFLOW-Y: auto; OVERFLOW-X: auto; " >
</div>

<!-- ############################################################################################################ -->


<div id="pieces_content" class="contactview_corps" style="display:none; OVERFLOW-Y: auto; OVERFLOW-X: auto; " >
</div>

<!-- ############################################################################################################ -->



<div id="contactview_comptabilite" class="contactview_corps" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; display:none ">
<div class="emarge">
<table >
	<tr id="line_tva_intra" style="display:none">
		<td>
			<span class="labelled_ralonger" title="Numéro de TVA intracommunautaire">TVA intra.:</span>
		</td>
		<td>
		<input type="text" id="tva_intra" name="tva_intra" value="<?php echo $contact->getTva_intra();?>"  class="classinput_xsize"/>
		</td>
	</tr>
</table>
<hr />
<script type="text/javascript">

Event.observe('tva_intra', 'blur',  function(evt){
	var AppelAjax = new Ajax.Request(
									"annuaire_maj_tva_intra.php", 
									{
									parameters: {ref_contact: "<?php echo $contact->getRef_contact();?>", tva_intra: $("tva_intra").value},
									evalScripts:true, 
									onLoading:S_loading,
									onSuccess: function (requester){
									requester.responseText.evalScripts();
									H_loading();
									}
									}
									);
	Event.stop(evt);
},false); 
</script>
<?php
if(isset($profils[$FOURNISSEUR_ID_PROFIL] )){
	?>
	<table>
		<tr id="line_compte_comptable" style="">
			<td>
			</td>
			<td style="text-align:center">
				<span class="labelled_ralonger" title="">Numéro de compte:</span>
			</td>
			<td style="text-align:center">
				<span class="labelled_ralonger" >Libellé:</span>
			</td>
		</tr>
		<tr id="line_compte_comptable" style="">
			<td>
				<span class="labelled_ralonger" title="">Informations par défaut pour les factures de ce fournisseur :</span>
			</td>
			<td style="text-align:center">
			<span style=" text-decoration:underline; cursor:pointer" id="numero_compte_compta_fournisseur">
			<?php if ($profils[$FOURNISSEUR_ID_PROFIL]->getDefaut_numero_compte ()) { echo $profils[$FOURNISSEUR_ID_PROFIL]->getDefaut_numero_compte ();} else { echo "...";}?>
			</span>
			</td>
			<td>
			<span id="aff_numero_compte_compta_fournisseur" ><?php $lcpt = new compta_plan_general($profils[$FOURNISSEUR_ID_PROFIL]->getDefaut_numero_compte ()); echo $lcpt->getLib_compte();?></span>
			</td>
		</tr>
	</table>
	<hr />
	<script type="text/javascript">
	
	Event.observe('numero_compte_compta_fournisseur', 'click',  function(evt){
		ouvre_compta_plan_mini_moteur(); 
		charger_compta_plan_mini_moteur ("compte_plan_comptable_search.php?cible=compta_fournisseur&cible_id=<?php echo $contact->getRef_contact();?>&retour_value_id=numero_compte_compta_fournisseur&retour_lib_id=aff_numero_compte_compta_fournisseur&indent=numero_compte_compta_fournisseur&num_compte=<?php echo $profils[$FOURNISSEUR_ID_PROFIL]->getDefaut_numero_compte ();?>");
		Event.stop(evt);
	},false); 
	
	</script>

	<?php
}
?>
<?php
if(isset($profils[$CLIENT_ID_PROFIL] )){
	?>
	<table>
		<tr id="line_compte_comptable" style="">
			<td>
			</td>
			<td style="text-align:center">
				<span class="labelled_ralonger" title="">Numéro de compte:</span>
			</td>
			<td style="text-align:center">
				<span class="labelled_ralonger" >Libellé:</span>
			</td>
		</tr>
		<tr id="line_compte_comptable" style="">
			<td>
				<span class="labelled_ralonger" title="">Informations par défaut pour les factures de ce client :</span>
			</td>
			<td style="text-align:center">
			<span style=" text-decoration:underline; cursor:pointer" id="numero_compte_compta_client">
			<?php if ($profils[$CLIENT_ID_PROFIL]->getDefaut_numero_compte ()) { echo $profils[$CLIENT_ID_PROFIL]->getDefaut_numero_compte ();} else { echo "...";}?>
			</span>
			</td>
			<td>
			<span id="aff_numero_compte_compta_client" ><?php $lcpt = new compta_plan_general($profils[$CLIENT_ID_PROFIL]->getDefaut_numero_compte ()); echo $lcpt->getLib_compte();?></span>
			</td>
		</tr>
	</table>
	<hr />
	<script type="text/javascript">
	
	Event.observe('numero_compte_compta_client', 'click',  function(evt){
		ouvre_compta_plan_mini_moteur(); 
		charger_compta_plan_mini_moteur ("compte_plan_comptable_search.php?cible=compta_client&cible_id=<?php echo $contact->getRef_contact();?>&retour_value_id=numero_compte_compta_client&retour_lib_id=aff_numero_compte_compta_client&indent=numero_compte_compta_client&num_compte=<?php echo $profils[$CLIENT_ID_PROFIL]->getDefaut_numero_compte ();?>");
		Event.stop(evt);
	},false); 
	
	</script>

	<?php
}
?>
<a href="#" id="view_compte_bancaire_contact" class="compta_text_2">Gérer les comptes bancaires</a><br />
<script type="text/javascript">
// <![CDATA[
	Event.observe("view_compte_bancaire_contact", "click", function(evt){
	Event.stop(evt);
	page.verify("compta_compte_bancaire_contact","#compta_compte_bancaire_contact.php?ref_contact=<?php echo $contact->getRef_contact();?>", "true", "_blank");
	});
// ]]>
</script>

<?php if($COMPTA_GEST_PRELEVEMENTS): ?>
<a href="#" id="view_prelevements_contact" class="compta_text_2">Gérer les autorisations de traites et prélèvements</a><br />
<script type="text/javascript">
// <![CDATA[
	Event.observe("view_prelevements_contact", "click", function(evt){
	Event.stop(evt);
	page.verify("compta_gest_prelevements_contact","#compta_gest_prelevements_contact.php?ref_contact=<?php echo $contact->getRef_contact();?>", "true", "_blank");
	});
// ]]>
</script>


<?php endif; ?>

<a href="#" id="view_grand_livre_contact"  class="compta_text_2">Extrait de compte</a><br />
<script type="text/javascript">
// <![CDATA[
	Event.observe("view_grand_livre_contact", "click", function(evt){
	Event.stop(evt);
	page.verify("compta_extrait_compte_contact","#compta_extrait_compte_contact.php?ref_contact=<?php echo $contact->getRef_contact();?>", "true", "_blank");
	});
// ]]>
</script>

<a href="#" id="view_synthese_creances" class="compta_text_2">Synthèse des créances client</a><br />
<script type="text/javascript">
// <![CDATA[
	Event.observe("view_synthese_creances", "click", function(evt){
	Event.stop(evt);
	page.verify("compta_synth_creances_contact","#compta_synth_creances_contact.php?ref_contact=<?php echo $contact->getRef_contact();?>", "true", "_blank");
	});
// ]]>
</script>


<a href="#" id="add_reglement_entrant" class="compta_text_2">Enregistrer un encaissement.</a><br />

<a href="#" id="add_reglement_sortant" class="compta_text_2">Enregistrer un décaissement.</a><br />

<script type="text/javascript">
// <![CDATA[
	Event.observe("add_reglement_entrant", "click", function(evt){
	Event.stop(evt);
	page.verify("contact_add_reglement_entrant","annuaire_compta_reglements.php?ref_contact=<?php echo $contact->getRef_contact();?>&mode=entrant", "true", "contact_add_reglement");
	});
	Event.observe("add_reglement_sortant", "click", function(evt){
	Event.stop(evt);
	page.verify("contact_add_reglement_sortant","annuaire_compta_reglements.php?ref_contact=<?php echo $contact->getRef_contact();?>&mode=sortant", "true", "contact_add_reglement");
	});
// ]]>
</script>

<div id="contact_add_reglement"></div>
</div>
</div>



</div>

</div>
<script type="text/javascript">
// <![CDATA[

//tout les documents du contact
<?php
if (count($contact_last_docs )) {
	?>
	Event.observe('show_all_docs', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	<?php
}
?>

//recuperation des civilites
start_civilite("id_categorie", "civilite", "civilite.php?cat=");


<?php 
if ($caiu >0) {
	?>
	$("compte_info").value=<?php echo $caiu?>-1;
	<?php
}
?>
id_index_contentcoord=<?php echo $caiu?>;

//changements sur le formulaire principal
new Form.EventObserver('annu_editon_fiche_form', function(element, value){formChanged();$("submit").style.visibility="visible";}); 
new Form.EventObserver('annu_editon_fiche_form', function(element, value){formChanged();$("submit2").style.visibility="visible";}); 
Event.observe('nom', 'click',  function(element, value){formChanged();$("submit").style.visibility="visible";},false); 
Event.observe('nom', 'keypress',  function(element, value){formChanged();$("submit").style.visibility="visible";},false); 
Event.observe('note', 'click',  function(element, value){formChanged();$("submit2").style.visibility="visible";},false); 
Event.observe('note', 'keypress',  function(element, value){formChanged();$("submit2").style.visibility="visible";},false); 
Event.observe('line_siret4', 'click',  function(element, value){formChanged();$("submit").style.visibility="visible";},false); 
Event.observe("id_categorie", "change",  function(evt){
	if ($("id_categorie").value != "1") {
		$("line_siret").show();
		$("line_siret2").show(); 
		$("line_siret3").show(); 
		$("line_siret4").show(); 
		$("line_tva_intra").show();
	} else {
		$("line_siret").hide(); 
		$("line_siret2").hide(); 
		$("line_siret3").hide(); 
		$("line_siret4").hide(); 
		$("line_tva_intra").hide();
	}
}, false);

if ($("id_categorie").value != "1") {
	$("line_siret").show();
	$("line_siret2").show(); 
	$("line_siret3").show(); 
	$("line_siret4").show(); 
	$("line_tva_intra").show();
} else {
	$("line_siret").hide(); 
	$("line_siret2").hide(); 
	$("line_siret3").hide(); 
	$("line_siret4").hide(); 
	$("line_tva_intra").hide();
}
//aff_menu_selected = document.getElementsByClassName('menu_link_affichage');

//action de fusion suspension suppression

Event.observe('fusionner_contact', 'click',  function(evt){ show_mini_moteur_contacts ('fusionner_contact', '\'<?php echo $contact->getRef_contact();?>\'');Event.stop(evt);},false); 


Event.observe('suspendre_user', 'click',  function(evt){ alerte.confirm_supprimer('contact_suspendre_user', 'contact_suspendre_user');Event.stop(evt);},false); 

if($("contact_archivage"))
	Event.observe('supprimer_contact', 'click',  function(evt){alerte.confirm_supprimer('contact_archivage', 'contact_archivage');Event.stop(evt);},false); 



	
function setheight_annuaire_view_fiche(){
set_tomax_height("contactview_specifiques" , -46);
set_tomax_height('annu_edtfiche_u' , -56);
set_tomax_height('contactview_c' , -52);
set_tomax_height('contactview_general' , -46);  
set_tomax_height('annu_editon_fiche_form_c' , -46); 
set_tomax_height('annu_edtfiche_caiu' , -52);
set_tomax_height('contactview_comptabilite' , -46); 
set_tomax_height('contactview_event_liste' , -86);
set_tomax_height('contactview_evenements' , -46); 
set_tomax_height('pieces_content' , -46);
set_tomax_height("contactview_courrier" , -46);
set_tomax_height("liaison_content" , -46);

<?php
foreach ($profils as  $id_profil => $profil) {
	?>
	set_tomax_height("typeprofil<?php echo $id_profil?>" , -52);
	set_tomax_height("x_typeprofil<?php echo $id_profil?>" , -46);
	<?php 
}
?>	
}

Event.observe(window, "resize", setheight_annuaire_view_fiche, false);
setheight_annuaire_view_fiche();
//centrage du mini_moteur de recherche d'un contact

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
});

<?php
if (isset($_REQUEST["id_comm_event"])) {
	?>
	view_menu_1('contactview_evenements', 'contactview_menu_d', array_menu_v_contact); 
	set_tomax_height('contactview_event_liste' , -86);
	set_tomax_height('contactview_evenements' , -46); 
	<?php
}
?>

Event.observe('print_contact', "click", function(evt){
  page.verify("annuaire_print_contact","annuaire_print_contact.php?ref_contact=<?php echo $contact->getRef_contact();?>", "true", "_blank");
});

//on masque le chargement
H_loading();

// ]]>
</script>