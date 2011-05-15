<?php

// *************************************************************************************************************
// GESTION DES LIENS FAVORIS
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
<script type="text/javascript">
</script>
<div class="emarge">
<p class="titre">Gestion des liens</p>
<div id="liens_content" class="articletview_corps"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; height:350px;">
<div style="padding:10px">
<div style="font-weight:bolder">Ajouter un lien:</div>

		<div>
			<table width="99%">
				<tr>
					<td style="width:95%">
						<table width="100%">
							<tr class="smallheight">
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center">
								Libell&eacute;: 
								</td>
								<td style="text-align:center">Url:
								</td>
								<td style="text-align:center">Description: 
								</td>
								<td style="text-align:center">
								</td>
								<td style="text-align:center">
								</td>
							</tr>
						</table>
					</td>
					<td style="width:55px; text-align:center">
					
					</td>
				</tr>
			</table>
		</div>
		<div class="caract_table">
		<table width="99%">
		<tr>
			<td style="width:95%">
				<form action="planning_liens_add.php" method="post" id="planning_liens_add" name="planning_liens_add" target="formFrame" >
				<table style="width:100%">
					<tr class="smallheight">
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input name="lib_web_link" id="lib_web_link" type="text" value=""  class="classinput_xsize"  />
						</td>
						<td>
						<input name="url_web_link" id="url_web_link" type="text" value=""  class="classinput_xsize"  />
						</td>
						<td>
						<input name="desc_web_link" id="desc_web_link" type="text" value=""  class="classinput_xsize"  />
						</td>
						<td style="text-align:right">&nbsp;
						</td>
						<td style="text-align:center">
						<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</div>
	
	<?php 
	if ($liste_links) {
	?>
	<div style="font-weight:bolder">Vos liens:</div>
	<ul id="vos_liens">
			<div>
			<table width="99%">
				<tr>
					<td style="width:95%">
						<table width="100%">
							<tr class="smallheight">
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center">
								Libell&eacute;: 
								</td>
								<td style="text-align:center">Url:
								</td>
								<td style="text-align:center">Description: 
								</td>
								<td style="text-align:center">
								</td>
								<td style="text-align:center">
								</td>
							</tr>
						</table>
					</td>
					<td style="width:55px; text-align:center">
					
					</td>
				</tr>
			</table>
		</div>
	<?php
	$indentation_contenu = 0;
	foreach ($liste_links as $link) {
		?>
		<li class="caract_table" id="lienliste_<?php echo $indentation_contenu;?>">
		<table width="99%">
		<tr>
			<td style="width:95%">
				<form action="planning_liens_mod.php" method="post" id="planning_liens_mod_<?php echo $indentation_contenu;?>" name="planning_liens_mob_<?php echo $indentation_contenu;?>" target="formFrame" >
				<table style="width:100%">
					<tr class="smallheight">
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input name="ident" id="ident" type="hidden" value="<?php echo $indentation_contenu;?>"   />
						<input name="id_web_link_<?php echo $indentation_contenu;?>" id="id_web_link_<?php echo $indentation_contenu;?>" type="hidden" value="<?php echo $link->id_web_link;?>"  />
						<input name="lib_web_link_<?php echo $indentation_contenu;?>" id="lib_web_link_<?php echo $indentation_contenu;?>" type="text" value="<?php echo $link->lib_web_link;?>"  class="classinput_xsize"  />
						</td>
						<td>
						<input name="url_web_link_<?php echo $indentation_contenu;?>" id="url_web_link_<?php echo $indentation_contenu;?>" type="text" value="<?php echo $link->url_web_link;?>"  class="classinput_xsize"  />
						</td>
						<td>
						<input name="desc_web_link_<?php echo $indentation_contenu;?>" id="desc_web_link_<?php echo $indentation_contenu;?>" type="text" value="<?php echo $link->desc_web_link;?>"  class="classinput_xsize"  />
						</td>
						<td style="text-align:right">
						<div style="width:25px;text-align:right"  class="documents_li_handle" >
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/main.gif" id="move_lien_line_<?php echo $indentation_contenu?>"/>
						</div>
						</td>
						<td style="text-align:center">
						<input name="modifier_<?php echo $indentation_contenu;?>" id="modifier_<?php echo $indentation_contenu;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td>
			
					<form method="post" action="planning_liens_sup.php" id="planning_liens_sup_<?php echo $indentation_contenu; ?>" name="planning_liens_sup_<?php echo $indentation_contenu; ?>" target="formFrame">
						<input name="id_web_link" id="id_web_link" type="hidden" value="<?php echo $link->id_web_link;?>"  />
					</form>
					<a href="#" id="link_planning_liens_sup_<?php echo $indentation_contenu; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
					<script type="text/javascript">
					Event.observe("link_planning_liens_sup_<?php echo $indentation_contenu; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('planning_liens_sup', 'planning_liens_sup_<?php echo $indentation_contenu; ?>');}, false);
					</script>
			</td>
		</tr>
	</table>
	</li>
	<?php 
	$indentation_contenu ++;
	}
	?>
	</ul>
	<?php 
}
?>
	
</div>
</div>

</div>


<SCRIPT type="text/javascript">

function setheight_liens(){
set_tomax_height('liens_content' , -32); 
}
Event.observe(window, "resize", setheight_liens, false);
setheight_liens();


	<?php 
	if ($liste_links) {
	?>
//drag and drop
element_moved = "";
Position.includeScrollOffsets = true;
Sortable.create("vos_liens",{dropOnEmpty:true, ghosting:false, scroll:"liens_content", handle: "documents_li_handle", scrollSensitivity: 55, overlap: "vertical", onChange: function(element){element_moved=element; },  onUpdate: function(){lien_maj_ordre(element_moved)}});
	<?php 
}
?>
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>