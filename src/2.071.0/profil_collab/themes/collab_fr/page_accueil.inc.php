<?php

// *************************************************************************************************************
// ACCUEIL DU PROFIL COLLAB
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array();
check_page_variables($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript" language="javascript">
	array_menu_accueil	=	new Array();
	array_menu_accueil[0] 	=	new Array('fast_search', 'menu_accueil_1');
	array_menu_accueil[1] 	=	new Array('opened_docs_list', 'menu_accueil_2');
	array_menu_accueil[2] 	=	new Array('taches_liste', 'menu_accueil_3');
	array_menu_accueil[3] 	=	new Array('favor_liste', 'menu_accueil_4');
</script>
<div class="mini_pop_up_fav" style="display:none" id="add_fav_pop" >
	<a href="#" id="close_fav_pop" style="float:right">
		<img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/supprime.gif" border="0">
	</a>
</div>
<div class="emarge" id="accueil_content" style="background-image: url(<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/accueil.gif); background-position:bottom center; background-repeat:no-repeat; height:97%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td style="width:47%; height:50px"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="50px" id="imgsizeform"/></td>
			<td style="width:20px"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/></td>
			<td style="width:47%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="20px" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td style="">
				<div style="">
					<div style="height:22px">
						<ul>
							<li class="accueil_onglet" id="menu_accueil_1">Recherche rapide</li>
							<li class="accueil_onglet_hide" id="menu_accueil_2">Documents ouverts</li>
							<li class="accueil_onglet_hide" id="menu_accueil_3">Tâches</li>
							<li class="accueil_onglet_hide" id="menu_accueil_4">Mes Liens</li>
						</ul>
					</div>
					<div style="height:240px;">
						<div class="accueil_block_round3corner" id="fast_search">
							<br />

							<div id="acc_recherche_contact_block" style="width:350px">
								<form>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td  width="180px">Rechercher un Contact </td>
											<td><label>
													<input type="text" name="acc_find_contact" id="acc_find_contact" class="classinput_nsize"  />
												</label></td>
											<td>&nbsp;</td>
											<td><input name="acc_find_contact_submit" id="acc_find_contact_submit" type="image" src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/ico_recherche.gif"  /></td>
										</tr>
									</table>
								</form>
							</div>
							<div style="height:18px; line-height:18px;"></div>

							<div id="acc_recherche_article_block" style="width:350px">
								<form>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td  width="180px">Rechercher un Article </td>
											<td><label>
													<input type="text" name="acc_find_article" id="acc_find_article" class="classinput_nsize"  />
												</label></td>
											<td>&nbsp;</td>
											<td><input name="acc_find_article_submit" id="acc_find_article_submit" type="image" src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/ico_recherche.gif"  /></td>
										</tr>
									</table>
								</form>
							</div>
							<div style="height:18px; line-height:18px;"></div>

							<div id="acc_recherche_article_block" style="width:350px">
								<form>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="180px">Rechercher un document </td>
											<td><label>
													<input type="text" name="acc_find_document" id="acc_find_document" class="classinput_nsize" />
												</label></td>
											<td>&nbsp;</td>
											<td><input name="acc_find_document_submit" id="acc_find_document_submit" type="image" src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/ico_recherche.gif"  /></td>
										</tr>
									</table>
								</form>
							</div>
							<div style="height:48px; line-height:48px;">&nbsp;</div>
							<div style="font:11px Arial, Helvetica, sans-serif; text-decoration:underline; text-align:center">
								Veuillez remplir tout ou partie du nom recherché puis valider.			</div>
						</div>

						<div class="accueil_block_round3corner" style="display:none" id="opened_docs_list">
							<br />


							<div style="width:100%; overflow:auto; height:220px;">

								<table width="100%" border="0"  cellspacing="0">
									<tr>
										<td style="width:25%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:35%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:20%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:20%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									</tr>
<?php
foreach ($liste_open_docs as $open_doc) {
//				Test permission acces aux inventaires
//				if($open_doc->id_type_doc == 11 && !$_SESSION['user']->check_permission ("21")){continue;}
	?>
										<tr id="open_doc_<?php echo $open_doc->ref_doc; ?>" style="cursor:pointer">
											<td style="font-size:10px;">
										<?php echo $open_doc->ref_doc; ?>					</td>
											<td style="padding-left:10px">
										<?php echo htmlentities($open_doc->lib_type_doc); ?><br />
												<span style="font-style:italic"><?php echo htmlentities($open_doc->lib_etat_doc); ?></span>					</td>
											<td style="text-align:right; padding-right:10px">
												<?php if ($open_doc->montant_ttc) {
													echo number_format($open_doc->montant_ttc, $TARIFS_NB_DECIMALES, ".", "") . " " . $MONNAIE[1];
												} ?>					</td>
											<td>
												<?php echo date_Us_to_Fr($open_doc->date_doc); ?>					</td>
										</tr>
										<tr>
											<td colspan="4"><div style="height:3px; line-height:3px;"></div>
												<script type="text/javascript">
													Event.observe('open_doc_<?php echo $open_doc->ref_doc; ?>', "click", function(evt){
														page.verify('index','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $open_doc->ref_doc; ?>'),'true','_blank');
														Event.stop(evt);
													});

												</script>					</td>
										</tr>
	<?php
}
?>
								</table>
							</div>
						</div>

						<div class="accueil_block_round3corner" style="display:none" id="taches_liste" >
							<div style="overflow:auto; height:220px;">

								<table width="100%" border="0"  cellspacing="0">
									<tr>
										<td style="width:25px"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:25px"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:20%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style=""><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:20%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									</tr>
<?php
foreach ($liste_taches as $tache) {
	?>
										<tr id="tache_<?php echo $tache->getId_tache(); ?>_l">
											<td>
												<div style="font-weight:bolder; cursor:pointer" id="go_tache_<?php echo $tache->getId_tache(); ?>_0">
	<?php if ($tache->getUrgence()) { ?>
														<img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/tache_urgente.gif" width="25px" height="20px" alt="Urgent"/>
													<?php } else { ?>
														<img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="25px" height="20px" />
													<?php } ?>
												</div>					</td>
											<td>
												<div style="font-weight:bolder; cursor:pointer" id="go_tache_<?php echo $tache->getId_tache(); ?>_1">
	<?php if ($tache->getImportance()) { ?>
														<img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/tache_important.gif" width="25px" height="20px" alt="Important"/>
													<?php } else { ?>
														<img src="<?php echo $DIR . $_SESSION['theme']->getDir_theme() ?>images/blank.gif" width="25px" height="20px" />
													<?php } ?>
												</div>					</td>
											<td>
												<div style="font-weight:bolder; cursor:pointer" id="go_tache_<?php echo $tache->getId_tache(); ?>_2"><?php echo date_Us_to_Fr($tache->getDate_creation()); ?></div>					</td>
											<td>
												<div style="font-weight:bolder; cursor:pointer" id="go_tache_<?php echo $tache->getId_tache(); ?>_3"><?php echo htmlentities($tache->getLib_tache()); ?></div>					</td>
											<td style="text-align:right;">
												<div id="etat_tache_<?php echo $tache->getId_tache(); ?>_l" style="cursor:pointer">
	<?php
	if ($tache->getEtat_tache() == 0) {
		?>
														A effectuer
														<?php
													}
													if ($tache->getEtat_tache() == 1) {
														?>
														En cours
														<?php
													}
													if ($tache->getEtat_tache() == 2) {
														?>
														Effectu&eacute;e
														<?php
													}
													?>
												</div>
												<div style="position:relative;top:0px; left:0px; width:100%;">
													<div id="choix_etat_tache_<?php echo $tache->getId_tache(); ?>_l" style="display:none; text-align: left; border:1px solid #000000; background-color:#FFFFFF; position: absolute; left:0px; width:95px">
														<a class="choix_etat" id="choix_etat_0_tache_<?php echo $tache->getId_tache(); ?>_l">A effectuer</a>
														<a class="choix_etat" id="choix_etat_1_tache_<?php echo $tache->getId_tache(); ?>_l">En cours</a>
														<a class="choix_etat" id="choix_etat_2_tache_<?php echo $tache->getId_tache(); ?>_l">Effectu&eacute;e</a>						</div>
												</div>
												<script type="text/javascript">
													Event.observe("etat_tache_<?php echo $tache->getId_tache(); ?>_l", "click", function(evt){
														$("choix_etat_tache_<?php echo $tache->getId_tache(); ?>_l").toggle();
													}, false);
													Event.observe("choix_etat_0_tache_<?php echo $tache->getId_tache(); ?>_l", "click", function(evt){
														Event.stop(evt);
														maj_etat_tache ("0", "<?php echo $tache->getId_tache(); ?>");
														$("etat_tache_<?php echo $tache->getId_tache(); ?>_l").innerHTML = "A effectuer";
														$("choix_etat_tache_<?php echo $tache->getId_tache(); ?>_l").toggle();
													}, false);
													Event.observe("choix_etat_1_tache_<?php echo $tache->getId_tache(); ?>_l", "click", function(evt){
														Event.stop(evt);
														maj_etat_tache ("1", "<?php echo $tache->getId_tache(); ?>");
														$("etat_tache_<?php echo $tache->getId_tache(); ?>_l").innerHTML = "En cours";
														$("choix_etat_tache_<?php echo $tache->getId_tache(); ?>_l").toggle();
													}, false);
													Event.observe("choix_etat_2_tache_<?php echo $tache->getId_tache(); ?>_l", "click", function(evt){
														Event.stop(evt);
														maj_etat_tache ("2", "<?php echo $tache->getId_tache(); ?>");
														$("etat_tache_<?php echo $tache->getId_tache(); ?>_l").innerHTML = "Effectu&eacute;e";
														$("choix_etat_tache_<?php echo $tache->getId_tache(); ?>_l").toggle();
													}, false);

													//observateurs pour afficher les taches de l'utilisateur
													Event.observe('go_tache_<?php echo $tache->getId_tache(); ?>_0', "click", function(evt){page.verify('mes_taches','planning_taches_user.php','true','sub_content');
														Event.stop(evt);});
													Event.observe('go_tache_<?php echo $tache->getId_tache(); ?>_1', "click", function(evt){page.verify('mes_taches','planning_taches_user.php','true','sub_content');
														Event.stop(evt);});
													Event.observe('go_tache_<?php echo $tache->getId_tache(); ?>_2', "click", function(evt){page.verify('mes_taches','planning_taches_user.php','true','sub_content');
														Event.stop(evt);});
													Event.observe('go_tache_<?php echo $tache->getId_tache(); ?>_3', "click", function(evt){page.verify('mes_taches','planning_taches_user.php','true','sub_content');
														Event.stop(evt);});
												</script>					</td>
										</tr>
										<tr>
											<td colspan="5"><div style="height:3px; line-height:3px;"></div></td>
										</tr>
	<?php
}
?>
								</table>
							</div>
						</div>
						<div class="accueil_block_round3corner" style="display:none" id="favor_liste">
							<?php
								foreach ($liste_links as $link) {
									?>
														<a href="<?php if (!preg_match("#^((http|https|ftp)://)#", $link->url_web_link)) {
										echo "http://";
									} ?><?php echo $link->url_web_link; ?>" target="_blank" class="link_fav">
							<table width="100%" >
								<tr>
									<td class="fav_content_col">
										<span class="fav_lib"><?php echo $link->lib_web_link; ?></span><br />
										<span class="fav_desc"><?php echo $link->desc_web_link; ?></span>&nbsp;
									</td>
									<td>
										<div class="fav_url"><?php echo $link->url_web_link; ?></div>
									</td>
								</tr>
							</table>
						</a>
						<div style="height:12px"></div>

						<?php
					}
					?>
						</div>
					</div>
				</div>
				<!--     -->
				<br /><br /><br /><br />
				<div style="text-align:center">
				</div>

				<!--	 -->

			</td>
			<td>&nbsp;</td>
			<td style="">
				<div class="titre_accueil_news" style="display: none;">
					Les News Sooth ERP
				</div>

				<div id="new_content" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; " class="flux_accueil">
					<div id="slider">

					</div>
				</div>


			</td>
		</tr>
	</table>



</div>
<SCRIPT type="text/javascript">
	//observateurs pour la recherche d'un contact
	new Event.observe($("acc_find_contact_submit"), "click", function(evt){ page.verify('annuaire_recherche','annuaire_recherche.php?acc_ref_contact='+escape($("acc_find_contact").value),'true','sub_content');
		Event.stop(evt);});
	Event.observe('acc_find_contact', "keypress", function(evt){submit_search_contact_if_Key_RETURN(evt)});

	//observer le retour chariot lors de la saisie de recherche contact pour lancer la recherche
	function submit_search_contact_if_Key_RETURN (event) {

		var key = event.which || event.keyCode;
		switch (key) {
			case Event.KEY_RETURN:
				page.verify('annuaire_recherche','annuaire_recherche.php?acc_ref_contact='+escape($("acc_find_contact").value),'true','sub_content');
				Event.stop(event);
				break;
		}
	}

	//observateurs pour la recherche d'un article
	Event.observe('acc_find_article_submit', "click", function(evt){ page.verify('catalogue_recherche','catalogue_recherche.php?acc_ref_article='+escape($("acc_find_article").value),'true','sub_content');
		Event.stop(evt);});
	Event.observe('acc_find_article', "keypress", function(evt){ submit_search_article_if_Key_RETURN(evt)});

	//observer le retour chariot lors de la saisie de recherche article pour lancer la recherche
	function submit_search_article_if_Key_RETURN (event) {

		var key = event.which || event.keyCode;
		switch (key) {
			case Event.KEY_RETURN:
				page.verify('catalogue_recherche','catalogue_recherche.php?acc_ref_article='+escape($("acc_find_article").value),'true','sub_content');
				Event.stop(event);
				break;
		}
	}

	//observateurs pour la recherche d'un document
	Event.observe('acc_find_document_submit', "click", function(evt){page.verify('document_recherche','documents_recherche.php?acc_ref_document='+escape($("acc_find_document").value),'true','sub_content');
		Event.stop(evt);});
	Event.observe('acc_find_document', "keypress", function(evt){submit_search_document_if_Key_RETURN(evt)});

	//observer le retour chariot lors de la saisie de recherche document pour lancer la recherche
	function submit_search_document_if_Key_RETURN (event) {

		var key = event.which || event.keyCode;
		switch (key) {
			case Event.KEY_RETURN:
				page.verify('document_recherche','documents_recherche.php?acc_ref_document='+escape($("acc_find_document").value),'true','sub_content');
				Event.stop(event);
				break;
		}
	}

	Event.observe("menu_accueil_1", "click",  function(evt){Event.stop(evt); view_menu_accueil('fast_search', 'menu_accueil_1', array_menu_accueil ,"accueil_onglet_hide" ,"accueil_onglet");}, false);
	Event.observe("menu_accueil_2", "click",  function(evt){Event.stop(evt); view_menu_accueil('opened_docs_list', 'menu_accueil_2', array_menu_accueil ,"accueil_onglet_hide" ,"accueil_onglet");}, false);
	Event.observe("menu_accueil_3", "click",  function(evt){Event.stop(evt); view_menu_accueil('taches_liste', 'menu_accueil_3', array_menu_accueil ,"accueil_onglet_hide" ,"accueil_onglet");}, false);
	Event.observe("menu_accueil_4", "click",  function(evt){Event.stop(evt); view_menu_accueil('favor_liste', 'menu_accueil_4', array_menu_accueil ,"accueil_onglet_hide" ,"accueil_onglet");}, false);

	//observateurs pour afficher les taches de l'utilisateur
	//Event.observe('go_to_taches', "click", function(evt){page.verify('mes_taches','planning_taches_user.php','true','sub_content');   Event.stop(evt);});

	//observateurs pour la recherche d'un article
	//Event.observe('add_fav', "click", function(evt){
	//	$("add_fav_pop").show()
	//	page.verify('catalogue_recherche','catalogue_recherche.php?acc_ref_article='+escape($("acc_find_article").value),'true','sub_content');
	//	Event.stop(evt);}
	//);

	function setheight_accueil(){
		set_tomax_height('accueil_content' , -32);
	}
	Event.observe(window, "resize", setheight_accueil, false);
	setheight_accueil();


	var AppelAjax = new Ajax.Updater("new_content",
					"news_lmb.php",
					{
					evalScripts:true,
					}
					);
	//on masque le chargement
	H_loading();
</SCRIPT>