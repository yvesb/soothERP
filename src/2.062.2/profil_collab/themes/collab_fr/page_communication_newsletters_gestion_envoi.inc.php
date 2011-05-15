<?php

// *************************************************************************************************************
// AFFICHAGE DU CHOIX DES CAISSES
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

<div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Nouvel envoi
</div>
<div class="emarge" style="text-align:right" >
<div>
	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
		<tr>
			<td rowspan="2" style="width:120px; height:50px">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_newsletters.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:90%">
			<div id="corps_choix_newsletter" style="width:90%; height:50px; padding:25px">
			<span class="green_underlined" style="font-weight:bolder; text-decoration:none; font-size:14px;">&gt;&gt; <?php echo $newsletter->getNom_newsletter() ?></span><br />
<br />Titre de l'envoi: 
<input type="text" id="titre" name="titre" class="classinput_hsize" value="<?php echo $newsletter->getTitre_brouillon();;?>"/>
			<br /><br />
		
			<div id="editeur_descript_long"  >
			<div id="editeur_bt_barre" class="barre_editeur">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center">
						<select name="editeur_fontname" id="editeur_fontname" class="" >
							<option value="">Police</option>
							<option value="Arial, Helvetica, sans-serif">Arial</option>
							<option value="Times New Roman, Times, serif">Times New Roman</option>
							<option value="Courier New, Courier, mono">Courrier New</option>
							<option value="Verdana, sans-serif">Verdana</option>
						</select>		</td>
					<td align="center">
						<select name="editeur_size" id="editeur_size" class="" >
							<option value="">Taille</option>
							<option value="1">1 (8 pt)</option>
							<option value="2">2 (10 pt)</option>
							<option value="3">3 (12 pt)</option>
							<option value="4">4 (14 pt)</option>
							<option value="5">5 (18 pt)</option>
							<option value="6">6 (24 pt)</option>
							<option value="7">7 (36 pt)</option>
						</select>		</td>
					<td align="center">
						<a href="#" id="editeur_bold" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/bold.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_italic" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/italic.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_souligner" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/underline.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_align_left" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyleft.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_align_center" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifycenter.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_align_right" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyright.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_align_justify" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyfull.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_outdent" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/outdent.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_indent" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/indent.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_insertorderedlist" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/insertorderedlist.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_insertunorderedlist" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/insertunorderedlist.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_forecolor" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/forecolor.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_hilitecolor" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/hilitecolor.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_link" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/createlink.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_unlink" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/unlink.gif" />			</a>		</td>
					<td align="center">
						<a href="#" id="editeur_img" class="bt_wysiwyg">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/img.gif" />			</a>		</td>
				</tr>
			</table>
		</div>
			<iframe name="description_html" id="description_html" class="classinput_xsize" style="height:250px; display:block; width:100%" frameborder="0"></iframe><br />
			<iframe width="161" height="113" id="colorpalette" src="colors.php?proto=editeur&ifr=description_html" style="display:none; position:absolute; border:1px solid #000000; OVERFLOW: hidden;" frameborder="0" scrolling="no"></iframe><br />
			<iframe width="280" height="100" id="image_choix_editor" src="" style="display:none; position:absolute; border:1px solid #000000; OVERFLOW: hidden;; background-color:#FFFFFF; padding:0px" frameborder="0" scrolling="no"></iframe><br />
			<form action="communication_newsletters_gestion_envoi_valide0.php" target="formFrame" method="post" name="communication_newsletters_gestion_envoi_valide" id="communication_newsletters_gestion_envoi_valide">
				<input type="hidden" value="<?php echo $newsletter->getId_newsletter();?>" id="id_newsletter" name="id_newsletter" />
				<input type="hidden" value="" id="titre_newsletter" name="titre_newsletter" />
			<textarea name="description" rows="6" style="display:none;" id="description"><?php echo $newsletter->getBrouillon();?></textarea>
			</form>
			<div style="text-align:right">
				<a href="#" id="doc_brouillon"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_enregistrer.gif" /></a>
				<a href="#" id="doc_tester"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_tester.gif" /></a>
				<a href="#" id="doc_apercu"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_apercu.gif" /></a>
				<a href="#" id="doc_description"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_envoyer.gif" /></a>
			</div>
			</div>
			
			
			<form action="communication_newsletters_gestion_envoi_preview.php" target="_blank" method="post" name="communication_newsletters_gestion_envoi_preview" id="communication_newsletters_gestion_envoi_preview">
				<input type="hidden" value="<?php echo $newsletter->getId_newsletter();?>" id="id_newsletter_preview" name="id_newsletter_preview" />
				<input type="hidden" value="" id="titre_preview" name="titre_preview" />
				<textarea name="description_preview" rows="6" style="display:none;" id="description_preview"></textarea>
			</form>
			
			<form action="communication_newsletters_gestion_envoi_brouillon.php" target="formFrame" method="post" name="communication_newsletters_gestion_envoi_brouillon" id="communication_newsletters_gestion_envoi_brouillon">
				<input type="hidden" value="<?php echo $newsletter->getId_newsletter();?>" id="id_newsletter_brouillon" name="id_newsletter_brouillon" />
				<input type="hidden" value="" id="titre_brouillon" name="titre_brouillon" />
				<textarea name="description_brouillon" rows="6" style="display:none;" id="description_brouillon"></textarea>
			</form>
			
			<form action="communication_newsletters_gestion_envoi_tester.php" target="formFrame" method="post" name="communication_newsletters_gestion_envoi_tester" id="communication_newsletters_gestion_envoi_tester">
				<input type="hidden" value="<?php echo $newsletter->getId_newsletter();?>" id="id_newsletter_tester" name="id_newsletter_tester" />
				<input type="hidden" value="" id="titre_tester"" name="titre_tester"" />
				<textarea name="description_tester" rows="6" style="display:none;" id="description_tester"></textarea>
			</form>
			
		</div>
		</td>
	</tr>
</table>


</div>
</div>

</div>


<SCRIPT type="text/javascript">
//initialisation de l'éditeur de texte
Event.observe('editeur_bold', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("bold", null);});
Event.observe('editeur_italic', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("italic", null);});
Event.observe('editeur_souligner', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("underline", null);});
Event.observe('editeur_align_left', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("justifyleft", null);});
Event.observe('editeur_align_center', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("justifycenter", null);});
Event.observe('editeur_align_right', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("justifyright", null);});
Event.observe('editeur_align_justify', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("JustifyFull", null);});
Event.observe('editeur_outdent', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("outdent", null);});
Event.observe('editeur_indent', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("indent", null);});
Event.observe('editeur_insertorderedlist', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("insertorderedlist", null);});
Event.observe('editeur_insertunorderedlist', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("insertunorderedlist", null);});
Event.observe('editeur_fontname', "change", function(evt){ if ($("editeur_fontname").value!="") { editeur.HTML_exeCmd("FontName", $("editeur_fontname").value); $("editeur_fontname").selectedIndex=0; };});
Event.observe('editeur_size', "change", function(evt){ if ($("editeur_size").value!="") { editeur.HTML_exeCmd("FontSize", $("editeur_size").value); $("editeur_size").selectedIndex=0;};});

Event.observe('editeur_forecolor', "click", function(evt){Event.stop(evt); editeur.recordRange(2); parent.command = "forecolor"; $("colorpalette").style.left = getOffsetLeft($("editeur_forecolor"))+"px"; $("colorpalette").style.top = (getOffsetTop($("editeur_forecolor")))+"px"; $("colorpalette").style.display=""; });

Event.observe('editeur_hilitecolor', "click", function(evt){Event.stop(evt); editeur.recordRange(2); editeur.HTML_surlignage(); $("colorpalette").style.left = getOffsetLeft($("editeur_hilitecolor"))+"px"; $("colorpalette").style.top = (getOffsetTop($("editeur_hilitecolor")))+"px"; $("colorpalette").style.display=""; });

Event.observe('editeur_link', "click", function(evt){Event.stop(evt); var szURL = prompt("Entrez l'adresse url:", "http://");   if ((szURL != null) && (szURL != "")) { editeur.HTML_exeCmd("CreateLink", szURL)};});
Event.observe('editeur_unlink', "click", function(evt){editeur.HTML_exeCmd("unlink", null);});


Event.observe('editeur_img', "click", function(evt){Event.stop(evt); parent.command = "InsertImage"; $("image_choix_editor").style.left = getOffsetLeft($("editeur_hilitecolor"))+"px"; $("image_choix_editor").style.top = (getOffsetTop($("editeur_hilitecolor"))+24)+"px";$("image_choix_editor").src="image_editor.php?proto=editeur&ifr=description_html&folder_stock=<?php echo $MAIL_TEMPLATES_IMAGES_DIR;?>"; $("image_choix_editor").style.display = ""; });


//Event.observe(document, "mousedown", function(evt){editeur.dismisscolorpalette();});
Event.observe($("description_html").contentWindow.document, "mousedown", function(evt){editeur.dismisscolorpalette();});
//Event.observe(document, "keypress", function(evt){editeur.dismisscolorpalette();});
Event.observe($("description_html").contentWindow.document, "keypress", function(evt){editeur.dismisscolorpalette();});


Event.observe($("description_html").contentWindow.document, "mouseup", function(evt){editeur.HTML_getstyle_delay(200);});
Event.observe($("description_html").contentWindow.document, "dblclick", function(evt){editeur.HTML_getstyle();});
Event.observe($("description_html").contentWindow.document, "keyup", function(evt){editeur.HTML_getstyle_delay(400);});
Event.observe($("description_html").contentWindow.document, "blur", function(evt){editeur.HTML_save();});
Event.observe($("description_html"), "blur", function(evt){editeur.HTML_save();});
//---------------------------------------------------------------
//fin d'intialisation de l'éditeur
//---------------------------------------------------------------	

function setheight_choix_newsletter(){
set_tomax_height("corps_choix_newsletter" , -75);
}
Event.observe(window, "resize", setheight_choix_newsletter, false);
setheight_choix_newsletter();


editeur.HTML_editor("description", "description_html", "editeur");


Event.observe("doc_apercu", "click",  function(evt){
	Event.stop(evt); 
	editeur.HTML_save();
	$("description_preview").value = $("description").value;
	$("titre_preview").value = $("titre").value;
	$("communication_newsletters_gestion_envoi_preview").submit();
}, false);

Event.observe("doc_brouillon", "click",  function(evt){
	Event.stop(evt); 
	editeur.HTML_save();
	$("description_brouillon").value = $("description").value;
	$("titre_brouillon").value = $("titre").value;
	$("communication_newsletters_gestion_envoi_brouillon").submit();
}, false);

Event.observe("doc_tester", "click",  function(evt){
	Event.stop(evt); 
	editeur.HTML_save();
	$("description_tester").value = $("description").value;
	$("titre_tester").value = $("titre").value;
	$("communication_newsletters_gestion_envoi_tester").submit();
}, false);

Event.observe("doc_description", "click",  function(evt){
	Event.stop(evt); 
	$("titre_newsletter").value = $("titre").value;
	editeur.HTML_save();

		$("titre_alert").innerHTML = 'Confirmer';
		$("texte_alert").innerHTML = 'Confirmer l\'envoi de la newsletter.';
		$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
		
		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";
		
		$("bouton0").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
//		var AppelAjax = new Ajax.Updater(
//									"sub_content", 
//									"communication_newsletters_gestion_envoi_valide.php", {
//									method: 'post',
//									asynchronous: true,
//									parameters: { id_newsletter : "<?php echo $newsletter->getId_newsletter();?>", description: $("description").value},
//									evalScripts:true, 
//									onLoading:S_loading, onException: function () {S_failure();}, 
//									onComplete:function () {
//											H_loading();
//										}
//									}
//									);
		$("communication_newsletters_gestion_envoi_valide").submit();
		}
		
		$("bouton1").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		}
}, false);
//on masque le chargement
H_loading();
</SCRIPT>