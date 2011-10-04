<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>EDITION <?php echo $article->getLib_article();?></title>
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_common_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_annuaire_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_formulaire.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/mini_moteur.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_articles.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_documents.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/annuaire_modif_fiche.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_small_wysiwyg.css" rel="stylesheet" type="text/css" />

<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/prototype.js"/></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/scriptaculous/scriptaculous.js?load=effects,dragdrop"/></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/selectupdater.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_tab_alerte.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_row_menu.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_main_menu.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_mini_moteur.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_articles.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_documents.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_bancaire.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_caisse.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_tpe.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_cb.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_taches.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compta.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_stock.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_tarifs.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_small_wysiwyg.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_annuaire.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_formulaire.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/swfobject.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_general.js"></script>
<SCRIPT LANGUAGE="JavaScript">

function PopupCentrer(page,largeur,hauteur,optionsi) {
  var top=(screen.height-hauteur)/2;
  var left=(screen.width-largeur)/2;
  window.open(page,"","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+optionsi);
}


	//lancement proto de chargement de contenu
	//require _general.js	
	var page= new appelpage("sub_content");
	
	//lancement proto des alertes
	//require _general.js
	var alerte= new alerte_message();
	var editeur= new HTML_wysiwyg();
	
</SCRIPT>
<style type="text/css">
<!--
body {
margin: 5px;
}
img {
border:0px;
}
-->
</style>
<style media="print" type="text/css">
#menu_barre_
{
	display:none;
}
</style>
</head>

<body>
<div id="menu_barre_">
<div style="">
<span style=" text-align:right">
<a href="catalogue_articles_view_description.php?ref_article=<?php echo $article->getRef_article();?><?php 
				if (isset($_REQUEST["aff_ht"])) { echo "&aff_ht=1"; }?><?php 
				if (isset($_REQUEST["id_tarif"])) { echo "&id_tarif=".$_REQUEST["id_tarif"]; }?><?php 
				if (isset($_REQUEST["autre_prix"])) { echo "&autre_prix=".$_REQUEST["autre_prix"]; }?>" target="_top">Retour fiche article</a>
</span>
</div>
</div>
<table style="width:100%">
<tr>
	<td style=" width:5%">&nbsp;</td>
	<td>
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
	</tr>
</table>
</div>
	<iframe name="desc_longue_html" id="desc_longue_html" class="classinput_xsize" style="height:220px; display:block; width:100%" frameborder="0"></iframe><br />
	<iframe width="161" height="113" id="colorpalette" src="colors.php?proto=editeur&ifr=desc_longue_html" style="display:none; position:absolute; border:1px solid #000000; OVERFLOW: hidden;" frameborder="0" scrolling="no"></iframe><br />
	<textarea name="desc_longue" rows="6" style="display:none;" id="desc_longue"><?php echo str_replace("&curren;", "&euro;", htmlentities($article->getDesc_longue ()));?></textarea>
	<a href="#" id="article_description"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" /></a>
	</div>
			</td>
			<td style=" width:5%">&nbsp;</td>
		</tr>
	</table>
	<input type="hidden" id="back_to_description" name="back_to_description" value="catalogue_articles_view_description.php?ref_article=<?php echo $article->getRef_article();?><?php 
				if (isset($_REQUEST["aff_ht"])) { echo "&aff_ht=".$_REQUEST["aff_ht"]; }?><?php 
				if (isset($_REQUEST["id_tarif"])) { echo "&id_tarif=".$_REQUEST["id_tarif"]; }?><?php 
				if (isset($_REQUEST["autre_prix"])) { echo "&autre_prix=".$_REQUEST["autre_prix"]; }?>"/>

<SCRIPT type="text/javascript">


//initialisation de l'éditeur de texte
editeur.HTML_editor("desc_longue", "desc_longue_html", "editeur");
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
Event.observe($("desc_longue_html").contentWindow.document, "mousedown", function(evt){editeur.dismisscolorpalette();});
//Event.observe(document, "keypress", function(evt){editeur.dismisscolorpalette();});
Event.observe($("desc_longue_html").contentWindow.document, "keypress", function(evt){editeur.dismisscolorpalette();});


Event.observe($("desc_longue_html").contentWindow.document, "mouseup", function(evt){editeur.HTML_getstyle_delay(200);});
Event.observe($("desc_longue_html").contentWindow.document, "dblclick", function(evt){editeur.HTML_getstyle();});
Event.observe($("desc_longue_html").contentWindow.document, "keyup", function(evt){editeur.HTML_getstyle_delay(400);});
Event.observe($("desc_longue_html").contentWindow.document, "blur", function(evt){editeur.HTML_save();});
Event.observe($("desc_longue_html"), "blur", function(evt){editeur.HTML_save();});
//---------------------------------------------------------------
//fin d'intialisation de l'éditeur
//---------------------------------------------------------------	


//actions de validation
Event.observe('article_description', "click", function(evt){
	editeur.HTML_save();
	maj_article_description("desc_longue", "<?php echo $article->getRef_article();?>");  
});


set_tomax_height('desc_longue_html' , -112);

Event.observe(window, "resize",  function(evt){
	set_tomax_height('desc_longue_html' , -112);
}, false);

</SCRIPT>
</body>
</html>
