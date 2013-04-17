<?php
// *************************************************************************************************************
// CHARGEMENT DE LA GESTION DES IMAGES D'UN ARTICLE EN MODE VISUALISATION
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
<div style=" text-align:left; padding:20px">
<table style="width:100%" border="0">
	<tr class="smallheight">
		<td style="width:60%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:38%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td>
		<div class="roundedtable">
		<?php 
		foreach ($images as $image) {
			?>
			<table style="border-top:1px solid #ffffff; width:100%">
			<tr>
			<td style="width:160px">
			<a href="<?php echo $ARTICLES_IMAGES_DIR.$image->lib_file;?>" target="_blank">
			<img src="<?php echo $ARTICLES_MINI_IMAGES_DIR.$image->lib_file;?>" id="<?php echo $image->id_image;?>"/>
			</a>
			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="supp_img_<?php echo $image->id_image;?>" style="cursor:pointer"/>
			</td>
			<td>
				<table>
				<tr>
				<td>
				<?php
				if ($image->ordre!=1) {
					?>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif" style="cursor:pointer" id="up_<?php echo $image->id_image;?>"/>
					<script type="text/javascript">
					Event.observe('up_<?php echo $image->id_image;?>', "click", function(evt){
							page.verify("articles_view_ingo_images","catalogue_articles_view_images_ordre.php?ref_article=<?php echo $article->getRef_article ();?>&id_image=<?php echo $image->id_image;?>&ordre=<?php echo $image->ordre-1;?>", "true", "info_images");
					});
					</script>
					<?php
				}
				?>
				</td>
				</tr>
				<tr>
				<td>
				<?php
				if ($image->ordre != count($images)) {
					?>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif" style="cursor:pointer" id="down_<?php echo $image->id_image;?>"/>
					<script type="text/javascript">
					Event.observe('down_<?php echo $image->id_image;?>', "click", function(evt){
							page.verify("articles_view_ingo_images","catalogue_articles_view_images_ordre.php?ref_article=<?php echo $article->getRef_article ();?>&id_image=<?php echo $image->id_image;?>&ordre=<?php echo $image->ordre+1;?>", "true", "info_images");
					});
					</script>
					<?php
				}
				?>
				</td>
				</tr>
				</table>
			</td>
			</tr>
			</table>
			<script type="text/javascript">
			Event.observe('supp_img_<?php echo $image->id_image;?>', "click", function(evt){
				Event.stop(evt);
				$("titre_alert").innerHTML = "Confirmation";
				$("texte_alert").innerHTML = "Confirmer la suppression de l'image";
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
				page.verify("articles_view_ingo_images","catalogue_articles_view_images_supprime.php?ref_article=<?php echo $article->getRef_article ();?>&id_image=<?php echo $image->id_image;?>", "true", "info_images");
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
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_add_image.gif" id="add_img_form_bt" style="cursor:pointer"/>
		<div id="add_img_form" style="display:none">
		<div class="roundedtable">
		<form name="upload" enctype="multipart/form-data" method="POST" action="catalogue_articles_view_images_upload.php" target="formFrame">
			Indiquez l'emplacement de l'image.
			<input type="hidden" name="ref_article" value="<?php echo $article->getRef_article();?>" />
			<input type="file" size="35" name="image" /><br />
			ou indiquez l'url de l'image (http://www.lesite.com/image.jpg)<br />
			<input type="text" name="url_img" value=""  size="35"/> 
			<br />
			<input type="submit" name="add_picture" value="Ajouter" />
		</form> 
		</div>
		</div>
		<script type="text/javascript">
			Event.observe("add_img_form_bt", "click", function(evt){
				Event.stop(evt);
				$("add_img_form").style.display = "";
				$("add_img_form_bt").style.display = "none";
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