<?php

// *************************************************************************************************************
// PAGE POUR CHOISIR LE TYPE ET LE MODELE PDF D'UN COURRIER
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
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fermer.gif" id="close_courrier_choix_type" class="bt_fermer_popup" alt="Fermer" title="Fermer" />
<SCRIPT type="text/javascript">
	Event.observe("close_courrier_choix_type", "click", function(evt){
		$("courrier_choix_type").innerHTML="";
		$("courrier_choix_type").hide();
		}, false);
</script>

<div class="div_titre_popup" >
	<table width="100%">
			<tr>
				<td style="width:3%"></td>
				<td style="width:94%;" class="label_titre_popup" >Rédaction d'un nouveau Messaget</td>
				<td style="width:3%"></td>
			</tr>
	</table>
</div>
<br />
<div id="type_de_courrier" >
	<table width="100%">
		<tr>
			<td style="width:3%"></td>
			<td class="labelled_text" style="vertical-align:middle">Choix du type de Contenu :</td>
			<td>
				<select id="id_type_courrier_selected" style="width:300px">
				<?php 
				$i = 0;
				foreach (	$infos_types_courrier_actifs as $infos_type ) { ?>
					<option value="<?php echo $infos_type->id_type_courrier; ?>" <?php if($i==0) {echo 'selected="selected"';}?> >
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
								<?php if(isset($id_courrier)){echo "'&id_courrier=".$id_courrier."'+";}?>
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

	<br />
	<br />

	<!-- C'est dans cette div que nous affichons la page pour choisir un model de pdf en fonction du type qu'on a choisi plus haut -->
	<!-- par défaut on affiche le 1er type que l'on trouve -->
	<div id="choix_modele_pdf"></div>
	<script type="text/javascript">
		//page.traitecontent.changed = false;
		page.traitecontent('gestion_courrier_type','courriers_choix_type_result.php?'+
																								'page_source=<?php echo $page_source;?>'+
																								'&page_cible=<?php echo $page_cible;?>'+
																								'&cible=<?php echo $cible;?>'+
																								<?php if(isset($id_courrier)){echo "'&id_courrier=".$id_courrier."'+";}?>
																								'&id_type_courrier=<?php echo $id_type_courrier_selected;?>'+
																								'&ref_destinataire=<?php echo $ref_destinataire; ?>','true','choix_modele_pdf');
		
	</script>

</div>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>