<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
tableau_smenu[0] = Array('smenu_communication', 'smenu_communication.php' ,'true' , 'sub_content', 'Communication');
tableau_smenu[1] = Array('communication_newsletters','communication_newsletters.php','true','sub_content', 'Newsletters');
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des newsletters</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">
			<span class="titre_smenu_page" id="smenu_nouvelle_newsletter"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" align="absmiddle" />Ajouter une newsletter</span><br /><br />

<SCRIPT type="text/javascript">
Event.observe('smenu_nouvelle_newsletter', "click", function(evt){
	page.verify('communication_nouvelle_newsletter','communication_nouvelle_newsletter.php','true','sub_content');
	Event.stop(evt);}
);
</SCRIPT>

<?php
if (!$newsletters) {
	?>
	<table>
		<tr>
			<td style="width:95%">
				<table>
					<tr class="smallheight">
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>Aucune newsletter n&apos;a été créée
						</td>
						<td>
						<a href="#" id="link_communication_newsletter_add"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif"/></a>
						<script type="text/javascript">
						Event.observe("link_communication_newsletter_add", "click",  function(evt){
							Event.stop(evt);
							page.verify('communication_nouvelle_newsletter','communication_nouvelle_newsletter.php','true','sub_content');
						}, false);
						</script>
						</td>
						<td/>
						<td>
						<td/>
						<td>
						<td/>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php
} else {
	?>
	<p>Newsletters</p>
	<div>
		<table>
			<tr>
				<td style="width:95%">
					<table>
						<tr class="smallheight">
							<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>	
						<tr>
							<td>Libell&eacute;:
							</td>
							<td>Description interne:
							</td>
							<td/>
							<td/>
						</tr>
					</table>
				</td>
				<td style="width:55px; text-align:center">
				
				</td>
			</tr>
		</table>
	</div>
	<?php
	foreach ($newsletters as $newsletter) {
		?>
		<div class="caract_table">
		<table>
			<tr>
				<td style="width:95%">
				<table>
						<tr class="smallheight">
							<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>	
						<tr>
							<td>
									<?php echo ($newsletter->nom_newsletter);?>
							</td>
							<td>
								<?php echo ($newsletter->description_interne);?>
							</td>
							<td style="text-align:right">
								<a href="#" id="link_communication_newsletter_mod_<?php echo $newsletter->id_newsletter; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif"/></a>
								<script type="text/javascript">
								Event.observe("link_communication_newsletter_mod_<?php echo $newsletter->id_newsletter; ?>", "click",  function(evt){
								Event.stop(evt);
								page.verify('communication_edition_newsletter','communication_edition_newsletter.php?id_newsletter=<?php echo $newsletter->id_newsletter;?>','true','sub_content');
								
								}, false);
								</script>
							</td>
							<td style="text-align:right">
								<a href="#" id="link_communication_newsletter_sup_<?php echo $newsletter->id_newsletter; ?>" style="display:none"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-supprimer.gif"/></a>
							</td>
						</tr>
					</table>
				</td>
				<td style="width:55px; text-align:center">
				<form method="post" action="communication_newsletters_sup.php" id="communication_newsletters_sup<?php echo $newsletter->id_newsletter; ?>" name="communication_newsletters_sup<?php echo $newsletter->id_newsletter; ?>" target="formFrame">
					<input name="id_newsletter" id="id_newsletter" type="hidden" value="<?php echo $newsletter->id_newsletter; ?>" />
				</form>
				<script type="text/javascript">
				Event.observe("link_communication_newsletter_sup_<?php echo $newsletter->id_newsletter; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('communication_newsletters_sup', 'communication_newsletters_sup<?php echo $newsletter->id_newsletter; ?>');}, false);
				</script>

				</td>
			</tr>
		</table>
		</div>
		<?php 
	}

}
?>
<br/>
</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>