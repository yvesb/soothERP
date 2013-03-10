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
<?php 
if (($contact->getRef_contact()) == $REF_CONTACT_ENTREPRISE) {
	?>
	tableau_smenu[0] = Array("smenu_entreprise", "smenu_entreprise.php" ,"true" ,"sub_content", "Entreprise");
	tableau_smenu[1] = Array("annuaire_contact", "annuaire_view_fiche.php?ref_contact=<?php echo $REF_CONTACT_ENTREPRISE;?>" ,"true" ,"sub_content", "Renseignements généraux");
	<?php
} else {
	?>
	tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
	tableau_smenu[1] = Array("annuaire_contact", "annuaire_view_fiche.php?ref_contact=<?php echo $contact->getRef_contact();?>" ,"true" ,"sub_content", "Edition d'un contact");
	<?php
}
?>
update_menu_arbo();

array_menu_v_contact	=	new Array();
array_menu_v_contact[0] 	=	new Array('contactview_general', 'contactview_menu_a');
array_menu_v_contact[1] 	=	new Array('contactview_specifiques', 'contactview_menu_b');
<?php
foreach ($_SESSION['profils'] as $profil) {
	if (!$profil->getId_profil()) { continue; }
	if(isset($profils[$profil->getId_profil()]) ) {
		?>
array_menu_v_contact[<?php echo $profil->getId_profil()+1?>] =	new Array( 'x_typeprofil<?php echo $profil->getId_profil();?>', 'typeprofil_menu_<?php echo $profil->getId_profil();?>');
		<?php 
	}
}
?>
</script>
<div class="emarge" id="emarge">

<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<div style="display:none;">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_nouvelle_fiche_caiu_vide.inc.php" ?>
</div>
<p class="titre"><?php echo htmlentities($contact->getNom())?></p>

<div id="contactview_menu" class="menu">
<ul id="menu_ul">

<div style="float:right; text-align:right; width:170px" ><span id="last_item_menu"><a href="#" id="contactview_menu_b" class="menu_unselect">Options avanc&eacute;es</a>
<script type="text/javascript">
Event.observe("contactview_menu_b", "click",  function(evt){Event.stop(evt); view_menu_1('contactview_specifiques', 'contactview_menu_b', array_menu_v_contact); set_tomax_height('contactview_specifiques' , -46); set_tomax_height('contactview_c' , -52); set_tomax_height('annu_edtfiche_u' , -56);}, false);
</script>
</span>
</div>
<li><a href="#" id="contactview_menu_a"  class="menu_select">Informations g&eacute;n&eacute;rales</a>
<script type="text/javascript">
Event.observe("contactview_menu_a", "click",  function(evt){Event.stop(evt); view_menu_1( 'contactview_general', 'contactview_menu_a', array_menu_v_contact); set_tomax_height('contactview_general' , -46);  set_tomax_height('annu_editon_fiche_form_c' , -46); set_tomax_height('annu_edtfiche_caiu' , -52);}, false);
</script>
</li>
<?php
	foreach ($_SESSION['profils'] as $profil) {
		if (!$profil->getId_profil()) { continue; }
		if(isset($profils[$profil->getId_profil()]) ) {
		?>
			<li id="exist_profil_<?php echo $profil->getId_profil();?>"><a href="#" id="typeprofil_menu_<?php echo $profil->getId_profil();?>" class="menu_unselect"><?php echo htmlentities($profil->getLib_profil());?></a>
			<script type="text/javascript">
			Event.observe("typeprofil_menu_<?php echo $profil->getId_profil();?>", "click",  function(evt){Event.stop(evt); view_menu_1( 'x_typeprofil<?php echo $profil->getId_profil();?>', 'typeprofil_menu_<?php echo $profil->getId_profil();?>', array_menu_v_contact);  set_tomax_height('typeprofil<?php echo $profil->getId_profil()?>' , -46); set_tomax_height('x_typeprofil<?php echo $profil->getId_profil()?>' , -46);}, false);
			</script>
			</li>
			<?php
		}
	}
?>
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
<table cellpadding="0" cellspacing="0" border="0" class="minimizetable"><tr>
	<td>
<table class="minimizetable" id="nom_lib" cellpadding="0" cellspacing="0" border="0">
		<tr class="smallheight">
				<td class="size_strict" style="width:85px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td style="width:215px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td style="85px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td><span class="labelled" style="width:85px">Nom:</span></td>
			<td><a href="#" id="link_show_nom" class="modif_textarea3"><?php echo nl2br(htmlentities($contact->getNom())); ?></a>
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
				<a href="#" id="link_show_id_categ" class="modif_select1"><?php echo htmlentities($contact->getLib_Categorie()); ?></a>
			<script type="text/javascript">
			Event.observe("link_show_id_categ", "click",  function(evt){Event.stop(evt); show_edit_form('nom_mask', 'nom_lib','id_categorie');}, false);
			</script>
				</td>
			<td><span class="labelled" style="margin-left:50px">Civilit&eacute;:</span></td>
			<td>
				<a href="#" id="link_show_civili" class="modif_select1"><?php echo htmlentities($contact->getLib_civ_court()); ?></a>
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
			<td ><textarea id="nom" name="nom"  rows="<?php if (stristr($_SERVER["HTTP_USER_AGENT"], "firefox")) { echo "1"; } else { echo "2"; } ?>" class="classinput_xsize"><?php echo htmlentities($contact->getNom())?></textarea></td>
			
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
	?>><?php echo htmlentities($categorie->lib_categorie)?></option>
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
		?>><?php echo htmlentities($civ->lib_civ_court)?></option>
					<?php 
				}
				?>
			</select>
			</td>
		</tr>
	</table>
	<table class="minimizetable">
		<tr class="smallheight">
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td class="ctpc"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				<td class="ctpc"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td colspan="4">
			<textarea id="note" name="note" rows="5"  class="classinput_xsize"><?php echo  htmlentities($contact->getNote())?></textarea></td>
		</tr>
	</table>
	</td>
	</tr>
	</table>
	  
	<p style="text-align:right; margin-right:10px">
		<input type="image" name="submit" id="submit" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" style="visibility: hidden;"/>
	</p>
	</form>

			<?php
			$first_docs = 0;
			if (count($contact_last_docs )) {
				?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #cccccc; border-top:1px solid #cccccc; border-right:1px solid #cccccc;">
				<tr class="smallheight" style="background-color:#cccccc;">
					<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
				</tr>
				<tr style="background-color:#cccccc;">
					<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
					<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
					<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
					<td style="text-align:center; padding-left:5px">Prix</td>
				</tr>
				</table>
				<?php
				foreach ($contact_last_docs as $contact_last_doc) {
					?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #cccccc; border-right:1px solid #cccccc;">
					<tr class="smallheight" style="background-color:#FFFFFF;">
						<td style="width:85px; border-right:1px solid #cccccc;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td style=" border-right:1px solid #cccccc;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td style="width:120px; border-right:1px solid #cccccc;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td style="width:100px; border-right:1px solid #cccccc;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					</tr>
					<tr id="open_doc_<?php echo ($contact_last_doc->ref_doc);?>" style=" background-color:#FFFFFF; color:#000000">
						<td style=" border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; text-align:left; padding-left:5px">
						<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
						</td>
						<td style=" border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; text-align:left; padding-left:5px">
							<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
						</td>
						<td style=" border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; text-align:left; padding-left:5px">
							<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
						</td>
						<td style=" border-bottom:1px solid #cccccc; text-align:center; padding-left:5px">
						<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
						</td>
					</tr>
					</table>
					<?php 
					$first_docs ++;
				}
				?>
					<div id="show_all_docs" style="cursor:pointer; font-size:11px; color:#000000">&gt;&gt;Consulter l'ensemble des documents concernant ce contact </div><br />
				<?php 
			}
			?>
	</div>
	<div id="liste_document_client" style=";display:<?php if (!isset($profils[$CLIENT_ID_PROFIL] )){echo "none";}?> ">
	</div>
	
	<div id="liste_document_fournisseur" style=";display:<?php if (!isset($profils[$FOURNISSEUR_ID_PROFIL] )){echo "none";}?> ">
	</div>
	
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
$caiu = 0;
foreach ($coordonnees as $coordonnee) {
	?>
	<li id="coordcontent_li_<?php echo $caiu?>">
	<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_coordonnee.inc.php" ?>
	</li>
	<?php
	$caiu++;
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
	?>
	<li id="adressecontent_li_<?php echo $caiu?>">
	<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_adresse.inc.php" ?>
	</li>
	<?php 
	$caiu++;
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
	?>
	<li id="sitecontent_li_<?php echo $caiu?>">
	<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_edition_site.inc.php" ?>
	</li>
	<?php
	$caiu++;
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


<div style=" border-top:1px dashed #000000;">

	
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

<a href="#" id="supprimer_contact" style="text-decoration:underline; color:#000000">supprimer ce contact (archiver)</a>
<form id="contact_archivage" name="contact_archivage" method="post" action="annuaire_archivage.php" target="formFrame">
<input type="hidden" name="archivage_ref_contact" id="archivage_ref_contact" value="<?php echo $contact->getRef_contact()?>">
</form>
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
<a href="#" class="ajout"  id="link_add_new_user">Ajouter un nouvel utilisateur</a>
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
	foreach ($profils as  $id_profil => $profil) {
		?>
		<div id="x_typeprofil<?php echo $id_profil?>" class="menu_link_affichage" style="display:none;">
		<div id="typeprofil<?php echo $id_profil?>" class="contactview_corps" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; ">
		<?php
			include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_fiche_profil".$id_profil.".inc.php";
		?>
		<br />
		<br />
		</div>
		</div>
		<?php 
	}
?>	
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
		$("unshow_docs").toggle();
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
Event.observe('nom', 'click',  function(element, value){formChanged();$("submit").style.visibility="visible";},false); 
Event.observe('nom', 'keypress',  function(element, value){formChanged();$("submit").style.visibility="visible";},false); 
Event.observe('note', 'click',  function(element, value){formChanged();$("submit").style.visibility="visible";},false); 
Event.observe('note', 'keypress',  function(element, value){formChanged();$("submit").style.visibility="visible";},false); 
Event.observe('line_siret4', 'click',  function(element, value){formChanged();$("submit").style.visibility="visible";},false); 
Event.observe("id_categorie", "change",  function(evt){
	if ($("id_categorie").value != "1") {
		$("line_siret").show();
		$("line_siret2").show(); 
		$("line_siret3").show(); 
		$("line_siret4").show(); 
	} else {
		$("line_siret").hide(); 
		$("line_siret2").hide(); 
		$("line_siret3").hide(); 
		$("line_siret4").hide(); 
	}
}, false);

if ($("id_categorie").value != "1") {
	$("line_siret").show();
	$("line_siret2").show(); 
	$("line_siret3").show(); 
	$("line_siret4").show(); 
} else {
	$("line_siret").hide(); 
	$("line_siret2").hide(); 
	$("line_siret3").hide(); 
	$("line_siret4").hide(); 
}

//aff_menu_selected = document.getElementsByClassName('menu_link_affichage');

//action de fusion suspension suppression

Event.observe('fusionner_contact', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ('fusionner_contact', '\'<?php echo $contact->getRef_contact();?>\'');},false); 


Event.observe('suspendre_user', 'click',  function(evt){Event.stop(evt); alerte.confirm_supprimer('contact_suspendre_user', 'contact_suspendre_user');},false); 


Event.observe('supprimer_contact', 'click',  function(evt){Event.stop(evt); alerte.confirm_supprimer('contact_archivage', 'contact_archivage');},false); 



	
function setheight_annuaire_view_fiche(){
set_tomax_height("contactview_specifiques" , -46);
set_tomax_height('annu_edtfiche_u' , -56);
set_tomax_height('contactview_c' , -52);
set_tomax_height('contactview_general' , -46);  
set_tomax_height('annu_editon_fiche_form_c' , -46); 
set_tomax_height('annu_edtfiche_caiu' , -52);
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

//on masque le chargement
H_loading();

// ]]>
</script>