<?php
// *************************************************************************************************************
// CHARGEMENTS DES PIECES JOINTES D'UN OBJET
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
<p class="sous_titre1">Pi&egrave;ces jointes </p>
<div style=" text-align:left; padding:0 20px">

<table style="width:100%">
	<tr class="smallheight">
		<td style="width:60%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:38%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td>
		<div class="roundedtable">
		<?php 
		foreach ($pieces as $piece) {
			?>
			<table style="border-top:1px solid #FFFFFF; width:100%">
			<tr>
			<td style="width:450px">
			<a href="pieces_ged_open.php?id_piece=<?php echo $piece->id_piece;?>" target="_blank" class="common_link">
			<?php echo $piece->lib_piece;?>
			</a>
			<div>
			Type : 
			<?php
			if(!isset($piece->lib_piece_type)){
				echo "Non d&eacute;fini/Autre";
			}
			?>
			<?php echo nl2br($piece->lib_piece_type);
			?>
			</div>
			<div>
			<b><?php echo nl2br($piece->nom);?></b>
			</div>
			<div>
			<?php echo nl2br($piece->note);?>
			</div>
			</td>
			<td style="text-align:right">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="supp_img_<?php echo $piece->id_piece;?>" style="cursor:pointer"/>
			</td>
			<td>
				
			</td>
			</tr>
			</table>
			<script type="text/javascript">
			Event.observe('supp_img_<?php echo $piece->id_piece;?>', "click", function(evt){
				Event.stop(evt);
				$("titre_alert").innerHTML = "Confirmation";
				$("texte_alert").innerHTML = "Confirmer la suppression de la pièce jointe";
				$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
			
				$("alert_pop_up_tab").style.display = "block";
				$("framealert").style.display = "block";
				$("alert_pop_up").style.display = "block";
				
				$("bouton0").onclick= function () {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
				}
				$("bouton1").onclick= function () {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
				page.verify("pieces_ged_supprime","pieces_ged_supprime.php?ref_objet=<?php echo $ref_objet;?>&id_piece=<?php echo $piece->id_piece;?>&type_objet=<?php echo $type_objet;?>&fichier=<?php echo $piece->fichier;?>", "true", "pieces_content");
				}
			});
			</script>
			<?php
		}
		?>
		</div>
		</td>
		<td>
			
		</td>
		<td>
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_add_piece.gif" id="add_pie_form_bt" style="cursor:pointer"/>
		<div id="add_pie_form" style="display:none">
			<div class="roundedtable">
			<form name="upload" enctype="multipart/form-data" method="POST" action="pieces_ged_upload.php" target="formFrame">
				Indiquez l'emplacement de la pi&egrave;ce &agrave; joindre
				<input type="hidden" name="type_objet" value="<?php echo $type_objet;?>" />
				<input type="hidden" name="ref_objet" value="<?php echo $ref_objet;?>" />
				<input type="file" size="35" name="pie" /><br />
				ou<br />
				indiquez l'url de la pi&egrave;ce &agrave; joindre<br />
				<input type="text" name="url_pie" value="" size="35" /><br />
				ou<br />
				joignez un fichier d&eacute;j&agrave; sur le serveur<br />
				<input type="text" id="url_pie2" name="url_pie2" value="" size="35" /><input type="submit" id="btn_transfert" name="btn_transfert" value="Parcourir..." />
				<br />
				<br />
				Indiquez le type de la pi&egrave;ce &agrave; joindre<br />
				<select id="type_pie" name="type_pie">
					<option value="0" selected>Autre</option>
					<?php
					foreach($types as $type){
						echo "<option value='".$type->id_piece_type."' />".$type->lib_piece_type."</option>";
					}
					?>
				</select>
				<br />
				<br />
				Nom de la pi&egrave;ce jointe<br />
				<input type="text" name="nom_pie" value="" />
				<br />
				Description de la pi&egrave;ce jointe<br />
				<textarea class="classinput_xsize" name="desc_pie"></textarea>
				<br />
				<input type="submit" name="add_pie" value="Ajouter" />
			</form> 
			</div>
		</div>
		<script type="text/javascript">
			Event.observe("add_pie_form_bt", "click", function(evt){
				Event.stop(evt);
				$("add_pie_form").style.display = "";
				$("add_pie_form_bt").style.display = "none";
			});
			Event.observe("btn_transfert", "click", function(evt){
				Event.stop(evt);
				$("titre_alert").innerHTML = "Liste des fichiers";
				$("texte_alert").innerHTML = "Choisissez le fichier à joindre";
				$("texte_alert").innerHTML += "<form action='' name='form_btn'>";
				<?php
				foreach($fichiers_tmp as $fichier_tmp){ ?>
					$("texte_alert").innerHTML += "<br /><input type='radio' value='<?php echo $fichier_tmp; ?>' id='test_radio' name='test_radio' /><?php echo $fichier_tmp; ?>";
				<?php
				}
				?>
				$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Joindre" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" /></form>';
			
				$("alert_pop_up_tab").style.display = "block";
				$("framealert").style.display = "block";
				$("alert_pop_up").style.display = "block";
				
				$("bouton1").onclick= function () {
					Event.stop(evt);
					var radioFichier = document.getElementsByName("test_radio");
					for (var i = 0 ; (i < radioFichier.length); i++) {
						if(radioFichier[i].checked){
							$("url_pie2").value = radioFichier[i].value;
							$("framealert").style.display = "none";
							$("alert_pop_up").style.display = "none";
							$("alert_pop_up_tab").style.display = "none";
							break;
						}
					}
				}
				
				$("bouton0").onclick= function () {
					$("framealert").style.display = "none";
					$("alert_pop_up").style.display = "none";
					$("alert_pop_up_tab").style.display = "none";
				}
			});
		</script>
		</td>
	</tr>
</table>
</div>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>