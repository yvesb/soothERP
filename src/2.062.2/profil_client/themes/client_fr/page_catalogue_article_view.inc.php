<?php
// *************************************************************************************************************
// ACCUEIL DU VISITEUR
// *************************************************************************************************************

?>

<?php include("header.php"); ?>

<?php include("top.php"); ?>

<?php include("menu.php"); ?>

<?php include("content_before.php"); ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
			<tr>
				<td>
				<div class="para">
				<?php 
				for ($i = count($catalogue_client_dir_parents)-1; $i >= 0; $i--) {
					?>
					-- <span style=" <?php if (!$i) {?>font-weight:bolder<?php } ?>" class="catalogue">
					<a href="catalogue_liste_articles.php?id_catalogue_client_dir=<?php echo $catalogue_client_dir_parents[$i]->id_catalogue_client_dir;?>">
					<?php echo ($catalogue_client_dir_parents[$i]->lib_catalogue_client_dir);?>
					</a>
					</span>
		
					<?php
				}
				?>
				</div>
		<br />
		<br />
		<div class="para"  style="text-align:center; margin:20px 0px;">
		<br />
		<br />

		<div style="width:830px;	margin:0px auto;">
		<div class="title_contact"></div>
		<table border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF">
			<tr>
				<td class="lightbg_liste1">&nbsp;</td>
				<td class="lightbg_liste"></td>
				<td class="lightbg_liste2">&nbsp;</td>
			</tr>
			<tr>
				<td class="lightbg_liste">&nbsp;</td>
				<td class="lightbg_liste">
				<div class="catalogue" style=" width: 780px;">
				<table width="100%"  border="0" cellspacing="3" cellpadding="0" class="catalogue">
					<tr>
						<td width="5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td width=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td width="5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>
					<tr>
						<td colspan="3">
						
					<p class="titre" id="titre_view_art">
					<?php echo  nl2br($article->getLib_article ());?>
					</p>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top: 20px;">
							<tr>
								<td style="width:10px;">&nbsp;</td>
								<td rowspan="2" >
								<input type="hidden" name="ref_art_categ" id="ref_art_categ" value="<?php echo $article->getRef_art_categ ();?>" />
								<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
									<tr class="smallheight">
										<td style="width:45%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
										<td style="width:50%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
										<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
									</tr>
									<tr>
										<?php if ($GESTION_REF_INTERNE) { ?>
										<td class="labelled_text">R&eacute;f&eacute;rence Interne: </td>
										<td><?php echo htmlentities($article->getRef_interne ());?> </td>
										<?php } else { ?>
										<td>
										</td>
										<td>&nbsp;</td>
										<?php } ?>
										<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td>
												<input name="qte_art" id="qte_art" type="text" size="4" value="" style="text-align:center" />
												</td>
												<td style=" width:30px; text-align:right">
												<a  href="#" id="link_art_add_panier_<?php echo htmlentities($article->getRef_article())?>" style="display:block; width:35px; text-decoration:underline"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier.gif" title="Ajouter au panier" alt="Ajouter au panier" /></a>
												</td>
											</tr>
										</table>

										
							
										<script type="text/javascript">
									Event.observe('link_art_add_panier_<?php echo htmlentities($article->getRef_article())?>', 'click',  function(evt){
										Event.stop(evt);
										if  (parseFloat($("qte_art").value) != "" || !isNaN(parseFloat($("qte_art").value))) {
											$("qte_art").value = parseFloat($("qte_art").value)+1;
										}
										if  (parseFloat($("qte_art").value) == "" || isNaN(parseFloat($("qte_art").value))) {
											$("qte_art").value = "1";
										}
										
										var AppelAjax = new Ajax.Updater(
															"panier", 
															"catalogue_panier_add_article.php", 
															{
															method: 'post',
															asynchronous: true,
															contentType:  'application/x-www-form-urlencoded',
															encoding:     'UTF-8',
															parameters: { ref_article: '<?php echo htmlentities($article->getRef_article())?>', qte_article: $("qte_art").value },
															evalScripts:true
															}
															);
									}, false);
										</script>	
										</td>
									</tr>
									<tr>
										<?php if($GESTION_CONSTRUCTEUR){?>
										<td class="labelled_text">Constructeur:</td>
										<td><?php foreach ($constructeurs_liste as $constructeur_liste) {
								 if ($article->getRef_constructeur() == $constructeur_liste->ref_contact) {echo htmlentities ($constructeur_liste->nom);}
									}?>					</td>
										<?php }else{ ?>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<?php }?>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<?php if($GESTION_CONSTRUCTEUR){?>
										<td class="labelled_text">R&eacute;f&eacute;rence constructeur:</td>
										<td><?php echo htmlentities($article->getRef_eom ());?> </td>
										<?php }else{ ?>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<?php }?>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td class="labelled_text">Description:</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" class="labelled_text">
										<?php 
										if (!$article->getDesc_longue ())  {
										echo (nl2br($article->getDesc_courte ()));
										} else {
										echo $article->getDesc_longue ();
										}
										?>								</td>
										<td>&nbsp;</td>
									</tr>
								</table>
								<br />
								<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
									<tr class="smallheight" >
										<td style="width:45%; border-top:1px dashed #002673;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
										<td style="width:50%; border-top:1px dashed #002673;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
										<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
									</tr>
									<tr>
										<td class="labelled_bold">Caract&eacute;ristiques:</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" class="labelled_text">
										<table style="width:100%;">
						<?php 
							$ref_carac_groupe=NULL;
							$ligne_general	=	1;
							$serialisation_carac	=	0;
							foreach ($caracs as $carac) {
								if ($ref_carac_groupe!=$carac->ref_carac_groupe) {
									$ligne_general	=	0;
									$ref_carac_groupe	=	$carac->ref_carac_groupe;
									?>
						</table>
						<table style="width:100%;" border="0" cellspacing="0" cellpadding="0">
							<tr class="row_color_0">
								<td colspan="2">
								<?php echo htmlentities($carac->lib_carac_groupe); ?>						</td>
							</tr>
						</table>
						<table style="width:100%;">
									<?php
								} else if ($ligne_general) {
											$ligne_general	=	0;
									?>
						</table>
						<table style="width:100%;" border="0" cellspacing="0" cellpadding="0">	
						<tr class="row_color_0">
						<td colspan="2">
						G&eacute;n&eacute;ral				</td>
						</tr>
						</table>
						<table style="width:100%;" border="0" cellspacing="0" cellpadding="0">
									<?php
								}
							?>
						<tr>
						<td style="width:20%;">
						<?php echo htmlentities($carac->lib_carac); ?>				</td>
						
								<td style="width:30%;" class="col_color_2">
								<?php 
								
									foreach ($art_caracs as $art_carac) { 
										if ($art_carac->ref_carac==$carac->ref_carac){echo htmlentities($art_carac->valeur);}
									}
								?> <?php echo htmlentities($carac->unite); ?>						</td>
							</tr>
							<?php
							$serialisation_carac	+=	1;
							}
							?>
						</table>								</td>
										<td>&nbsp;</td>
									</tr>
								</table>
								<div>
								<br />
								<br />
								</div>						</td>
								<td style="width:10px;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
								<?php 
								if (isset($images)) {
									foreach ($images as $image) {
									?>
									<a href='javascript:PopupCentrer("<?php echo $ARTICLES_IMAGES_DIR.$image->lib_file;?>",500,350,"menubar=no,statusbar=no,scrollbars=auto")'  >
									<img src="<?php echo $ARTICLES_MINI_IMAGES_DIR.$image->lib_file;?>" border="0" />
									</a><br /><br />
									<?php
									}
								}
								?>
								</td>
							</tr>
						</table>
						
					<SCRIPT type="text/javascript">
					
					
					</SCRIPT>
		
						</td>
					</tr>
				</table>
				</div>
				</td>
				<td class="lightbg_liste">&nbsp;</td>
			</tr>
			<tr>
				<td class="lightbg_liste4"></td>
				<td class="lightbg_liste">&nbsp;</td>
				<td class="lightbg_liste3">&nbsp;</td>
			</tr>
		</table>
		<br />
		<br />
		</div>
				
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
