<?php

// *************************************************************************************************************
// 
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
<!-- Bouton pour fermer la page sans sauvegarder -->
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fermer.gif" id="close_courrier_options" class="bt_fermer_popup" alt="Fermer" title="Fermer" />
<SCRIPT type="text/javascript">
	Event.observe("close_courrier_options", "click", function(evt){
		$("courrier_options").innerHTML="";
		$("courrier_options").hide();
		}, false);
</script>

<script type="text/javascript" language="javascript">
	array_menu_r_contact	=	new Array();
	array_menu_r_contact[0] 	=	new Array('type_de_courrier', 'menu_1');
	array_menu_r_contact[1] 	=	new Array('options_avancees', 'menu_2');
</script>

<div class="div_titre_popup" >
	<table width="100%">
			<tr>
				<td style="width:3%"></td>
				<td style="width:94%;" class="label_titre_popup" >Options</td>
				<td style="width:3%"></td>
			</tr>
	</table>
</div>
<br />
<br />
<div>
	<ul id="menu_options" class="menu">
	<li><a href="#" id="menu_1" class="menu_select">Type de courrier</a></li>
	<?php 
	//@TODO COURRIER : option d'un courrier : bouton [Options avancées] si besoin
	//<li><a href="#" id="menu_2" class="menu_unselect">Options avancées</a></li>
	?>
	</ul>
</div>

<div id="options">
	<!-- Ongelt : Type de courrier -->
	<div id="type_de_courrier">
		<br/>
		<table width="100%" border="0">
			<tr>
				<td style="width:3%"></td>
				<td class="labelled_text">Choix du type de Contenu :</td>
				<td>
					<select id="id_type_courrier_selected" style="width:300px">
					<?php 
					$i = 0;
					foreach (	$infos_types_courrier_actifs as $infos_type ) { ?>
						<option value="<?php echo $infos_type->id_type_courrier; ?>" <?php if($infos_type->id_type_courrier == $id_type_courrier_selected) {echo 'selected="selected"';}?> >
							[<?php echo $infos_type->code_courrier."] - ".$infos_type->lib_type_courrier; ?>
						</option>
					<?php $i++; } ?>
					</select>
					<script type="text/javascript">
						Event.observe("id_type_courrier_selected", "change",  function(evt){
							Event.stop(evt);
							$("choix_modele_pdf").innerHTML="";
							page.traitecontent('gestion_courrier_type','courriers_choix_type_result.php?'+
									'page_source=<?php echo $page_source;?>'+
									'&page_cible=<?php echo $page_cible;?>'+
									'&cible=<?php echo $cible;?>'+
									'&id_courrier=<?php echo $courrier->getId_courrier();?>'+
									'&id_type_courrier='+$("id_type_courrier_selected").options[$("id_type_courrier_selected").selectedIndex].value+
									'&ref_destinataire=<?php echo $ref_destinataire; ?>','true','choix_modele_pdf');
						});
					</script>
				</td>
				<td style="width:3%"></td>
			</tr>
		</table>
		<br/>
		<div class="div_titre_popup" >
			<table width="100%">
				<tr>
					<td style="width:3%"></td>
					<td style="width:94%;" class="label_titre_popup" >Choix du Modèle de mise en page</td>
					<td style="width:3%"></td>
				</tr>
			</table>
		</div>
		<br/>
		<!-- C'est dans cette div que nous affichons la page pour choisir un model de pdf en fonction du type qu'on a choisi plus haut -->
		<!-- par défaut on affiche le 1er type que l'on trouve -->
		<div id="choix_modele_pdf"></div>
		<script type="text/javascript">
			//page.traitecontent.changed = false;
			page.traitecontent('gestion_courrier_type','courriers_choix_type_result.php?'+
																									'page_source=<?php echo $page_source;?>'+
																									'&page_cible=<?php echo $page_cible;?>'+
																									'&cible=<?php echo $cible;?>'+
																									'&id_courrier=<?php echo $courrier->getId_courrier();?>'+
																									'&id_type_courrier=<?php echo $id_type_courrier_selected;?>'+
																									'&ref_destinataire=<?php echo $ref_destinataire; ?>','true','choix_modele_pdf');
			
		</script>
	</div>
	
	<?php 
	//@TODO COURRIER : option d'un courrier : onglet [Options avancées] si besoin
	/*
	<!-- Onglet : Options avancées -->
	<div id="options_avancees"  style="display:none;" class="menu_link_affichage">
		<span>Changer le courrier d'état</span><br/>
		<span>Supprimer le courrier</span>
	</div>
	*/?>
</div>

<SCRIPT type="text/javascript">
Event.observe("menu_1", "click",  function(evt){Event.stop(evt); view_menu_1('type_de_courrier', 'menu_1', array_menu_r_contact );}, false);

<?php
	//@TODO COURRIER : option d'un courrier : script du bouton [Options avancées] si besoin
	//Event.observe("menu_2", "click",  function(evt){Event.stop(evt); view_menu_1('options_avancees', 'menu_2', array_menu_r_contact );}, false);
?>

//on masque le chargement
H_loading();
</SCRIPT>