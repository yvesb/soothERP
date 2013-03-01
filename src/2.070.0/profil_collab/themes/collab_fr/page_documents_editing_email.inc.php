<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Envois du document par email</title>

<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_common_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_small_wysiwyg.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/prototype.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_small_wysiwyg.js"></script>
<script type="text/javascript">
var editeur= new HTML_wysiwyg();
var line_num = 0;
function add_destline (mail_insert) {

	var zone= $("liste_dest");
        if(zone.innerHTML.replace(/^\s\s*/, '').replace(/\s\s*$/, '')=='Choisir destinataire(s)'){
            zone.innerHTML='';
        }
	var addiv= document.createElement("div");
		addiv.setAttribute ("id", "dest_"+line_num);
                addiv.setAttribute ("class", "dest_entitie");
	var image= document.createElement("img");
		image.setAttribute ("id", "sup_list_dest_"+line_num);
		image.setAttribute ("src", "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif");
	zone.appendChild(addiv);
	$("dest_"+line_num).innerHTML=mail_insert;
	$("dest_"+line_num).appendChild(image);
	
	sup_line_observer (line_num, mail_insert);
	line_num++;
}

function sup_line_observer (line_num, mail_insert) {
	
	new Event.observe('sup_list_dest_'+line_num, 'click',  function(evt){
						Event.stop(evt); 
						$("new_dest_insert").value = "";
						$("destinataires").value = $("destinataires").value.replace(mail_insert+";", "");
						$("destinataires").value = $("destinataires").value.replace(mail_insert, "");
						Element.remove($("dest_"+line_num));
                                                var zone= $("liste_dest");
                       if(zone.innerHTML.replace(/^\s\s*/, '').replace(/\s\s*$/, '')==''){
                            zone.innerHTML='Choisir destinataire(s)';
                        }
					}, false);
}
</script>
<style type="text/css">
<!--
body {
font:12px Arial, Helvetica, sans-serif;
}
img {
border:0px;
}
h2 {
    margin-top: 0;
    background: #809EB6;
    font-weight: normal;
    padding: 3px 10px;
}
label {
    width: 100px;
    float: left;
    font-weight: bold;
}
span#add_new_dest_insert {
    cursor: pointer;
    text-decoration: underline;
}
div.dest_entitie {
    margin-left: 100px;
    margin-bottom: 4px;
    max-width: 200px;
}
div.dest_entitie img {
    float: right;
}
-->
</style>
</head>

<body style="overflow:auto; width:780px; height:550px">
<div style="margin:5px">
<h2>Envoi du document par email</h2>

<div style="visibility:block; float:left; position:relative; top:-67px; right:-645px; z-index:500"><br /><a href="http://www.lundimatin.fr" target="_blank" rel="noreferrer"><img src="../fichiers/images/powered_by_lundimatin.png" width="110"/></a>
</div>
        <div style="color:#FF0000; font-weight:bolder"><?php if (isset($msg)) {echo $msg;}?></div>

        <form id="form1" name="form1" method="post" action="documents_editing_email_submit.php" >
            
            <div style="float:right;">
          <label>Externe</label>
          <select name="new_dest_ex" id="new_dest_ex" style="width:220px">
              <option value="">Sélectionnez..</option>
		<?php foreach ($liste_email as $email): ?>
                    <?php if(!empty($email->email)): ?>
			<option value="<?php echo $email->email;?>"><?php echo $email->email;?></option>
                    <?php endif; ?>
		<?php endforeach; ?>
	</select>
          <br />
          <label>Interne</label>
          <select name="new_dest_in" id="new_dest_in" style="width:220px">
              <option value="">Sélectionnez..</option>
		<?php foreach ($emails_collaborateurs as $email): ?>
			<option value="<?php echo $email; ?>"><?php echo $email; ?></option>
		<?php endforeach; ?>
	</select>
          <br />
          <label>Autres</label>
          <input  type="text" id="new_dest_insert" name="new_dest_insert" style="width:220px" placeholder="email@exemple.com" /> 
	<span id="add_new_dest_insert">Ajouter</span>
          
      </div>
            
            
            <label>Destinataires</label>
	<div id="liste_dest">
            Choisir destinataire(s)
            
        <?php
        $i = 0;
        if (isset($_REQUEST["destinataires"])) {
             $tmp = explode(";",  $_REQUEST["destinataires"]);
             foreach ($tmp as $linedest) {
        ?>
            <div id="dest_<?php echo $i;?>" class="dest_entitie"><?php echo $linedest;?>
                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" alt="Vider la liste des destinataires" id="sup_list_dest_<?php echo $i;?>" title="Vider la liste des destinataires" style="cursor:pointer; float:right">
            </div>

            <script type="text/javascript">
                 Event.observe('sup_list_dest_<?php echo $i;?>', 'click',  function(evt){
                       Event.stop(evt); 
                       $("new_dest_insert").value = "";
                       $("destinataires").value = $("destinataires").value.replace("<?php echo $linedest;?>;", "");
                       $("destinataires").value = $("destinataires").value.replace("<?php echo $linedest;?>", "");
                       Element.remove($("dest_<?php echo $i;?>"));
                       var zone= $("liste_dest");
                       if(zone.innerHTML.replace(/^\s\s*/, '').replace(/\s\s*$/, '')==''){
                            zone.innerHTML='Choisir destinataire(s)';
                        }
                   }, false);
               </script>
            <?php
               $i++;
               }
            }
           ?>
        </div>
			
	<?php	if (isset($_REQUEST["code_pdf_modele"])) { ?>
            <input name="code_pdf_modele" id="code_pdf_modele" type="hidden" value="<?php echo $_REQUEST["code_pdf_modele"];?>" />	
	<?php } ?>
	<?php	if (isset($_REQUEST["filigrane"])) { ?>
            <input name="filigrane" id="filigrane" type="hidden" value="<?php echo $_REQUEST["filigrane"];?>" />	
	<?php } ?>
	<input name="destinataires" id="destinataires" type="hidden" value="<?php if (isset($_REQUEST["destinataires"])) {echo $_REQUEST["destinataires"];}?>" />	
	<input name="ref_doc" id="ref_doc" type="hidden" value="<?php echo $document->getRef_doc ();?>" />	
			 
			
      <br style="clear:right;" /><br />            
			
	<label>Titre</label>
        <input name="titre" id="titre" type="text" value="<?php if (isset($_REQUEST["titre"])) {echo $_REQUEST["titre"];} else { echo $document->getLib_type_printed ()." ".$document->getRef_doc ();}?>" style="width:220px;" />
	<br /><br />
        <label>Message</label>
                       
        <div id="editeur_descript_long" style="margin-left:100px;">
            <div id="editeur_bt_barre" class="barre_editeur" style="width:95%;">

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
								<iframe name="contenu_courrier_html" id="contenu_courrier_html" class="classinput_xsize" style="height:360px; display:block; width:95%" frameborder="1">
								</iframe>
								<iframe width="161" height="113" id="colorpalette" src="colors.php?proto=editeur&ifr=contenu_courrier_html" style="display:none; position:absolute; border:1px solid #000000; OVERFLOW: hidden;" frameborder="1" scrolling="no">
								</iframe>
								<textarea name="contenu_courrier_tmp" rows="6" style="display:none;" id="contenu_courrier_tmp">
									<?php if (isset($_REQUEST["message"])) {echo $_REQUEST["message"];}
                                                                        global $LIVRAISON_CLIENT_ID_TYPE_DOC;
                                                                        if ($document->getId_type_doc() == $LIVRAISON_CLIENT_ID_TYPE_DOC){
                                                                            $modele = new msg_modele_blc(2);
                                                                        }else{
                                                                            $modele = new msg_modele_doc_standard(1);
                                                                        }
                                                                        $modele->initvars($document->getRef_doc());
                                                                        echo $modele->get_html();
                                                                        ?>
								</textarea>
							</div>
        <label>&nbsp;</label><textarea id="contenu_courrier" name="message" rows="6" style="display:none;" ></textarea>
        <br />
	<label>&nbsp;</label><input type="submit" name="Submit" value="Envoyer" />
			
</form>
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
	$("contenu_courrier").value = $("contenu_courrier_tmp").value;

line_num = <?php echo $i;?>;


Event.observe('new_dest_ex', 'change',  function(evt){
	Event.stop(evt); 
	if ($("new_dest_ex").value != "") {
		if ($("destinataires").value.indexOf($("new_dest_ex").value) < 0) {
			if ($("destinataires").value == "" ) {
				$("destinataires").value = $("new_dest_ex").value;
			} else {
				$("destinataires").value = $("destinataires").value +";"+ $("new_dest_ex").value;
			}
			add_destline ($("new_dest_ex").value);
			$("new_dest_insert").value = "";
			$("new_dest_ex").selectedIndex="0";
                }
	}
}, false);


Event.observe('new_dest_in', 'change',  function(evt){
	Event.stop(evt); 
	if ($("new_dest_in").value != "") {
		if ($("destinataires").value.indexOf($("new_dest_in").value) < 0) {
			if ($("destinataires").value == "" ) {
				$("destinataires").value = $("new_dest_in").value;
			} else {
				$("destinataires").value = $("destinataires").value +";"+ $("new_dest_in").value;
			}
			add_destline ($("new_dest_in").value);
			$("new_dest_insert").value = "";
			$("new_dest_in").selectedIndex="0";
                }
	}
}, false);


Event.observe('add_new_dest_insert', 'click',  function(evt){
	Event.stop(evt); 
	if ($("new_dest_insert").value != "") {
		mail = $("new_dest_insert").value;
		if ((mail.indexOf("@")>=0)&&(mail.indexOf(".")>=0)) {
			if ($("destinataires").value.indexOf(mail) < 0) {
				if ($("destinataires").value == "" ) {
					$("destinataires").value = mail;
				} else {
					$("destinataires").value = $("destinataires").value +";"+ mail;
				}
				add_destline (mail);
				$("insert_dest").hide();
				$("new_dest").selectedIndex="0";
			}
     } else {
         alert("Mail invalide !");
         
     }
	}
}, false);



Event.observe('form1', 'submit',  function(evt){
	Event.stop(evt); 
	if ($("new_dest_insert").value != "") {
		mail = $("new_dest_insert").value;
		if ((mail.indexOf("@")>=0)&&(mail.indexOf(".")>=0)) {
			if ($("destinataires").value.indexOf(mail) < 0) {
				if ($("destinataires").value == "" ) {
					$("destinataires").value = mail;
				} else {
					$("destinataires").value = $("destinataires").value +";"+ mail;
				}
				add_destline (mail);
				$("insert_dest").hide();
				$("new_dest").selectedIndex="0";
			}
		}
	}
	if ($("destinataires").value == "" ) {
		if ($("new_dest").value != "" && $("new_dest").value != "autre") {
			$("destinataires").value = $("new_dest").value;
				add_destline ($("new_dest").value);
				$("new_dest_insert").value = "";
				$("new_dest").selectedIndex="0";
			$("form1").submit();
		} else {
    	alert("La liste des destinataire est vide");
		}
	} else {
		$("form1").submit();
	}
}, false);

</script>
</body>
</html>
