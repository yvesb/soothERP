<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<!-- Script pour gérer la pop-up "courrier_options" pour gérer les option d'un courrier -->
<script type="text/javascript">
	centrage_element("courrier_options");
	Event.observe(window, "resize", function(evt){centrage_element("courrier_options");});
</script>
<div style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%;" >
	<table width="100%" border="0" style="OVERFLOW-Y: auto; OVERFLOW-X: auto;">
		<tr>
			<td>
				<table class="courrierview_corps" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; height:100%; " border="0" >
					<tr>
						<td style="width:3%" ></td>
						<td style="width:7%"></td>
						<td style="width:40%"></td>
						<td style="width:7%"></td>
						<td style="width:40%"></td>
						<td style="width:3%"></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3">
							<span style="font-weight:bolder; color:#97bf0d;">&gt;&gt;&nbsp;Rédaction du Message</span> 
						</td>
						<td style="text-align:right; color:#012772;font-size:9pt;">
							(<span id="lib_etat_courrier"><?php echo $courrier->getLib_etat_courrier(); ?></span>)
						</td>
						<td></td>
					</tr>
						<tr>
						<td height="15px" colspan="6"></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<span id="courrier_objet">Objet :</span>
						</td>
						<td><input type="text" name="objet_courrier_tmp" id="objet_courrier_tmp" value="<?php echo $courrier->getObjet(); ?>"  class="classinput_xsize" width="100%"/>
							<script type="text/javascript">
								Event.observe("objet_courrier_tmp", "blur", function(evt){
									Event.stop(evt); 
									editeur.HTML_save();
									$("contenu_courrier").value = $("contenu_courrier_tmp").value;
									$("objet_courrier").value = $("objet_courrier_tmp").value;
									$("cmd").value = 'save';
									$("courrier_edition_save").submit();
								});
							</script>
						</td>
						<td>
							<span style="cursor:pointer; color:#012674;font-weight:bold; font-size:9pt;" id="options_courrier_bt"><u>Options</u></span>
							<script type="text/javascript">
								Event.observe("options_courrier_bt", "click", function(evt){
									Event.stop(evt);
									page.traitecontent('options_courrier','courriers_options.php?'+
																											'page_source=courriers_edition'+
																											'&page_cible=none'+
																											'&cible=none'+
																											'&id_courrier=<?php echo $courrier->getId_courrier(); ?>'+
																											'&ref_destinataire=<?php $dest = $courrier->getDestinataires(); echo $dest[0]->getRef_contact(); ?>'
																											,'true','courrier_options');	
									$("courrier_options").show();
								});
							</script>
						</td>
						<td style="text-align:right;">
							<img id="courrier_apercu"  style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_apercu.gif" />
							<img id="courrier_valider" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_valider2.gif" />
							<img id="courrier_envoyer" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_envoyer.gif" />
							<div id="choix_send_courrier"  class="choix_send_courrier" style="display:none;text-align:left;background-color:transparent;">
								<table>
								  <tr>
								    <td><img id="courrier_print" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" /></td>
								  </tr>
								  <tr style="display:none"> 
								  <?php 
									  //@TODO COURRIER : Gestion du FAX : emplacement du bouton FAX
								  ?>
								    <td><img id="courrier_fax" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fax.gif" /></td>
								  </tr>
								  <tr>
								  	<td><img id="courrier_email" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-email.gif" /></td>
								  </tr>
								</table>
							</div>			
							<SCRIPT type="text/javascript">
							Event.observe("courrier_apercu", "click",  function(evt){
								Event.stop(evt); 
								editeur.HTML_save();
								$("contenu_courrier").value = $("contenu_courrier_tmp").value;
								$("objet_courrier").value = $("objet_courrier_tmp").value;
								$("cmd").value = 'apercu';
								$("courrier_edition_save").submit();
							}, false);
							<?php //@TODO COURRIER : Gestion de la VALIDATION : javascript gérant le bouton VALIDER ?>
							<?php 
							if($courrier->getId_etat_courrier() == Courrier::ETAT_REDIGE()){ ?>
								var etatCanChange = false;
							<?php }else{ ?>
								var etatCanChange = true;
							<?php } ?>
							Event.observe("courrier_valider", "click",  function(evt){
								Event.stop(evt);
								if(etatCanChange){
									etatCanChange = false;
									editeur.HTML_save();
									$("contenu_courrier").value = $("contenu_courrier_tmp").value;
									$("objet_courrier").value = $("objet_courrier_tmp").value;
									$("cmd").value = 'valider';
									$("courrier_edition_save").submit();
								}
							}, false);
							Event.observe("courrier_envoyer", "click",  function(evt){
								Event.stop(evt);
	
								if ($("choix_send_courrier").style.display=="none") {
									$("choix_send_courrier").style.left = (getOffsetLeft($("courrier_envoyer"))-3)+"px";
									$("choix_send_courrier").style.top =  (getOffsetTop( $("courrier_envoyer"))+25)+"px";
									$("choix_send_courrier").style.display="block";
								} else {
									$("choix_send_courrier").style.display="none";
								}
							}, false);
	
							Event.observe("courrier_print", "click",  function(evt){
								Event.stop(evt); 
								editeur.HTML_save();
								$("choix_send_courrier").style.display="none";
								$("contenu_courrier").value = $("contenu_courrier_tmp").value;
								$("objet_courrier").value = $("objet_courrier_tmp").value;
								$("cmd").value = 'print';
								$("courrier_edition_save").submit();
							}, false);
							<?php 
								//@TODO COURRIER : Gestion du FAX : javascript gérant l'évènement du bouton FAX
							?>
							Event.observe("courrier_fax", "click",  function(evt){
								Event.stop(evt); 
								$("choix_send_courrier").style.display="none";
								editeur.HTML_save();
								$("contenu_courrier").value = $("contenu_courrier_tmp").value;
								$("objet_courrier").value = $("objet_courrier_tmp").value;
								$("cmd").value = 'fax';
								$("courrier_edition_save").submit();
							}, false);
							
							Event.observe("courrier_email", "click",  function(evt){
								Event.stop(evt); 
								$("choix_send_courrier").style.display="none";
								editeur.HTML_save();
								$("contenu_courrier").value = $("contenu_courrier_tmp").value;
								$("objet_courrier").value = $("objet_courrier_tmp").value;
								$("cmd").value = 'email';
								$("courrier_edition_save").submit();
							 	<?php
							 		//@TODO COURRIER : MODES_EDITIONS : gérer porprement le paramètre mode_edition -> Voir table editions_modes 
							 	?>
								PopupCentrer("courriers_editing_email.php<?php echo "?id_courrier=".$courrier->getId_courrier()."&mode_edition=2&code_pdf_modele=".$courrier->getCode_pdf_modele(); ?>",800,450,"menubar=no,statusbar=no,scrollbars=yes,resizable=yes");
							}, false);
							</SCRIPT>
						</td>
						<td></td>
					</tr>
					<tr height="15px">
						<td colspan="6"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							<div id="editeur_descript_long">
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
												</select>
											</td>
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
												</select>
											</td>
											<td align="center">
												<a href="#" id="editeur_bold" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/bold.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_italic" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/italic.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_souligner" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/underline.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_align_left" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyleft.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_align_center" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifycenter.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_align_right" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyright.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_align_justify" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyfull.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_outdent" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/outdent.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_indent" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/indent.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_insertorderedlist" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/insertorderedlist.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_insertunorderedlist" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/insertunorderedlist.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_forecolor" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/forecolor.gif" />	
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_hilitecolor" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/hilitecolor.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_link" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/createlink.gif" />
												</a>
											</td>
											<td align="center">
												<a href="#" id="editeur_unlink" class="bt_wysiwyg">
													<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/unlink.gif" />
												</a>
											</td>
										</tr>
									</table>
								</div>
								<iframe name="contenu_courrier_html" id="contenu_courrier_html" class="classinput_xsize" style="height:360px; display:block; width:100%" frameborder="1">
								</iframe>
								<iframe width="161" height="113" id="colorpalette" src="colors.php?proto=editeur&ifr=contenu_courrier_html" style="display:none; position:absolute; border:1px solid #000000; OVERFLOW: hidden;" frameborder="1" scrolling="no">
								</iframe>
								<textarea name="contenu_courrier_tmp" rows="6" style="display:none;" id="contenu_courrier_tmp">
										<?php if(isset($courrier)){echo $courrier->getContenu();} ?>
								</textarea>
							</div>
						</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" colspan="4" height="15px">
							<form action="courriers_edition_save.php" target="formFrame" method="post" name="courrier_edition_save" id="courrier_edition_save">
								<input type="hidden" id="id_courrier" name="id_courrier" value="<?php if(isset($courrier)){echo $courrier->getId_courrier();} ?>"  />
								<input type="hidden" id="ref_destinataire" name="ref_destinataire" value="<?php echo $destinataire->getRef_contact();?>"  />
								<input type="hidden" id="id_type_courrier" name="id_type_courrier" value="<?php if(isset($courrier)){echo $courrier->getId_type_courrier();} ?>" />
								<input type="hidden" id="objet_courrier" name="objet_courrier"/>
								<input type="hidden" id="cmd" name="cmd" value="save"/>
								<textarea id="contenu_courrier" name="contenu_courrier" rows="6" style="display:none;" ></textarea>
							</form>
						</td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<SCRIPT type="text/javascript">
	//---------------------------------------------------------------
	//debut d'intialisation de l'éditeur
	//---------------------------------------------------------------	
	editeur.HTML_editor("contenu_courrier_tmp", "contenu_courrier_html", "editeur");
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
	Event.observe('editeur_unlink', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("unlink", null);});
	
	
	//Event.observe(document, "mousedown", function(evt){editeur.dismisscolorpalette();});
	Event.observe($("contenu_courrier_html").contentWindow.document, "mousedown", function(evt){editeur.dismisscolorpalette();});
	//Event.observe(document, "keypress", function(evt){editeur.dismisscolorpalette();});
	Event.observe($("contenu_courrier_html").contentWindow.document, "keypress", function(evt){editeur.dismisscolorpalette();});
	
	Event.observe($("contenu_courrier_html").contentWindow.document, "mouseup", function(evt){editeur.HTML_getstyle_delay(200);});
	Event.observe($("contenu_courrier_html").contentWindow.document, "dblclick", function(evt){editeur.HTML_getstyle();});
	Event.observe($("contenu_courrier_html").contentWindow.document, "keyup", function(evt){editeur.HTML_getstyle_delay(400);});
	Event.observe($("contenu_courrier_html").contentWindow.document, "blur", function(evt){
		editeur.HTML_save();
		$("contenu_courrier").value = $("contenu_courrier_tmp").value;
		$("objet_courrier").value = $("objet_courrier_tmp").value;
		$("cmd").value = 'save';
		$("courrier_edition_save").submit();
	});
	Event.observe($("contenu_courrier_html"), "blur", function(evt){editeur.HTML_save();});
	//---------------------------------------------------------------
	//fin d'intialisation de l'éditeur
	//---------------------------------------------------------------	
	
	//on masque le chargement
	H_loading();
</SCRIPT>