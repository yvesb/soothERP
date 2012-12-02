<?php

// *************************************************************************************************************
// PAGE INDEX DU PROFIL COLLAB
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************

//modules

if (isset($modules)) {
	foreach ($modules as $module) {
		if (isset(${$module}['menu_caisse'])) {
			if (!isset($menu_modules))
			{		$menu_modules = array('modules','','false','','Modules', array ());}
			foreach (${$module}['menu_caisse'] as $menu_mod)
			{		array_push($menu_modules[5], $menu_mod);}
		}
	}
}
	
// recherche de la page retour (si existe) ou affichage page default [0]
$default_page = array('default_content','accueil.php','true','sub_content','Caisse');

if (isset ($_REQUEST['page_from']) && !substr_count($_REQUEST['page_from'], "profil_admin/") && $_REQUEST['page_from'] != "interface_caisse/" ) {
	$default_page= array('page_depart', str_replace("&page_from=","", str_replace("&uncache=1","", str_replace("?","",str_replace ( $_SESSION['user']->getProfil_dir() , "" , $_REQUEST['page_from']  )))),'true','sub_content');
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <title>Caisse</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
		<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_common_style.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_caisse_style.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_small_wysiwyg.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_formulaire.css" rel="stylesheet" type="text/css" />
		<?php 
		if (isset($modules)) {
			foreach ($modules as $module) {
				if (isset(${$module}['css_collab'])) {
					foreach (${$module}['css_collab'] as $css_mod) { ?>
		<link href="<?php echo $DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/".$css_mod;?>" rel="stylesheet" type="text/css" /><?php 
					}
				}
			}
		} ?>

		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/prototype.js"></script>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_helper.js"></script>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/scriptaculous/scriptaculous.js?load=effects,dragdrop"></script>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/selectupdater.js"></script>
		<?php 
		if (isset($modules)) {
			foreach ($modules as $module) {
				if (isset(${$module}['js_collab'])) {
					foreach (${$module}['js_collab'] as $js_mod) { ?>
		<script type="text/javascript" src="<?php echo $DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/".$js_mod;?>"></script><?php 
					}
				}
			}
		} ?>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_tab_alerte.js"></script>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_row_menu.js"></script>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_main_menu.js"></script>
		
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_tpe.js"></script>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_cb.js"></script>
		
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_small_wysiwyg.js"></script>
		
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/swfobject.js"></script>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_general.js"></script>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_caisse.js"></script>
		<script type="text/javascript" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_calculette.js"></script>

		<script type="text/javascript"> 
			TARIFS_NB_DECIMALES = parseInt(<?php echo $TARIFS_NB_DECIMALES;?>);
			PRICES_DECIMAL_SEPARATOR = "<?php echo $PRICES_DECIMAL_SEPARATOR;?>";
			PRICES_MILLIER_SEPARATOR = "<?php echo $PRICES_MILLIER_SEPARATOR;?>";
		</script>

		<script type="text/javascript"> //vérif d'état du log de session
		
		function verif_session() {
			$("code_relogin").value="";
			var AppelAjax = new Ajax.Request(
														"<?php echo $DIR; ?>session_test.php", 
														{
														evalScripts:true, 
														onSuccess: function (requester){
															if (requester.responseText!="ok") {
															ask_login(requester.responseText);
															} else  {
															setTimeout ("verif_session()", tempo_session);
															}
														}
														}
														);
		}
		
		function close_ask_login() {
			var AppelAjax = new Ajax.Request(
														"<?php echo $DIR; ?>session_test.php", 
														{
														evalScripts:true, 
														onSuccess: function (requester){
															if (requester.responseText=="ok") {
																restart_session();
															}
														}
														}
														);
		}
		
		function ask_login(requete) {
		
				$("alert_pop_up").style.display = "block";
				$("framealert").style.display = "block";
				$("alert_fin_session").style.display = "block";
		var AppelAjax = new Ajax.Updater(
										"alert_fin_session_content",
										"<?php echo $DIR;?>session_user_login.php", 
										{								
										evalScripts:true, 
										onLoading:S_loading, onException: function () {S_failure();}, 
										onComplete:showResponse
										}
										);
		}
		
		function restart_session() {
				$("alert_pop_up").style.display = "none";
				$("framealert").style.display = "none";
				$("alert_fin_session").style.display = "none";
				verif_session();
		
		}
		
		
		//changement de magasin
		function session_change_magasin (id_magasin) {
			var AppelAjax = new Ajax.Request(
										"<?php echo $DIR;?>site/__session_change_magasin.php?id_magasin="+id_magasin,
										{
											evalScripts:true, 
											onSuccess: function (requester){}
										}
										);
			
			<?php foreach ($_SESSION['magasins'] as $magasin) { ?>
				if (id_magasin == <?php echo $magasin->getId_magasin ();?>)
				{		$("img_option_info_magasin_<?php echo $magasin->getId_magasin ();?>").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/actuel.gif"; } 
				else { $("img_option_info_magasin_<?php echo $magasin->getId_magasin ();?>").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif"; }
				<?php } ?>
		}
		
		//------------------------------------
		// initialisation
		//------------------------------------
		
		var default_show_id = "<?php echo $default_page[0]?>";
		var default_show_url = "<?php echo $default_page[1]?>";
		var default_show_refresh = "<?php echo $default_page[2]?>";
		var default_show_target = "<?php echo $default_page[3]?>";
		var changed = false;
		var global_tab = new Array();
		var menu_id =  new Array();
		var last_parent_doc_line = "";
		var tarifs_nb_decimales = <?php echo $TARIFS_NB_DECIMALES;?>;
		var calcul_tarifs_nb_decimales = <?php echo $CALCUL_TARIFS_NB_DECIMALS;?>;
		var monnaie_html = "<?php echo $MONNAIE[1];?>";
		//var pour limiter le nombre de caracteres par ligne et le nombre de lignes dans un champ textarea
		var limite_car = 38;
		var limite_line_a = 2;
		var limite_line_b = 3;
		var limite_line_c = 5;
		//variable indiquant la recherche rapide d'article pour un document pour retour si un seul résultat trouve
		var from_rapide_search = "";
		//blocage de modification à certains champs d'un document
		var quantite_locked = false;
		//passage par un règlement rapide (pour retourner à l'onglet principale du document aprés un règlement rapide
		var reglement_rapide = false;
		//directories
		var dirtheme = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>";
		//historique
		var historique = new Array();
		var historique_request = new Array();
		historique_request[0] = new Array();
		historique_request[1] = new Array();
		historique_request[2] = new Array();
		historique_request[3] = new Array();
		historique_request[4] = new Array();
		historique_request[5] = new Array();
		historique_request[6] = new Array();
		historique_request[7] = new Array();
		historique_request[8] = new Array();
		//total d'un document négatif ?
		var montant_total_neg = false;
		//variable d'attente du nombre de ligne à inserer depuis un document
		var wait_for_x_line_doc = 0;
		//nombre de lignes chargées
		var loaded_line_doc = 0;
		//nombre maximale de ligne de sn affichées
		var doc_aff_qte_sn = <?php echo $DOC_AFF_QTE_SN;?>;
		//gestion des stocks
		var gestion_stock = <?php echo $GESTION_STOCK;?>;
		//page de retour aprés création d'un contact (si vide ouverture de la visualisation du contact)
		return_to_page = "";
		//dernière_ref_doc_line insérée dans un doc par recher rapide
		var last_ssearch_ref_doc_line = "";
		
		var uncache = false;

		//lancement proto de chargement de contenu
		//require _general.js	
		var page= new appelpage("sub_content");
		
		//lancement proto des alertes
		//require _general.js
		var alerte= new alerte_message();
		var editeur= new HTML_wysiwyg();

		function initEventHandlers() {
			<?php if (!strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') && !strpos($_SERVER['HTTP_USER_AGENT'], 'Iceweasel') && !strpos($_SERVER['HTTP_USER_AGENT'], 'Epiphany')) { ?>
			alerte.confirm_supprimer("alert_nav","");
			<?php } ?>
			hashListener.init();
			//observateurs du menu principal
			//require _general.js
			//Construction et placement des éléments du menu principal
			//require _general.js
			construct_menu ();
			
			//bouton refresh
			Event.observe('refresh_content_alert_onException', 'click',  function(evt){ Event.stop(evt); refresh_sub_content ();
				$("alert_pop_up").style.display = "none";
				$("framealert").style.display = "none";
				$("alert_onException").style.display = "none";
				return_to_page = "";
			}, false);
			Event.observe('norefresh_content_alert_onException', 'click',  function(evt){ Event.stop(evt);
				$("alert_pop_up").style.display = "none";
				$("framealert").style.display = "none";
				$("alert_onException").style.display = "none";
			}, false);
			
			//mise à hauteur des éléments principaux
			//require _general.js
			setsize_to_element ();
			set_tomax_height('sub_content' , 0);
			// mise à la bonne largeur du sub_content
			set_size_to_sub_content ();
			
			//waiting..fermeture au clic
			
			Event.observe($("wait_calcul_content"), "click", function() {
				$("wait_calcul_content").style.display= "none";
			}, false);
			//observateur de resize pour mise à hauteur des éléments principaux
			Event.observe(window, "resize", function() {
				setsize_to_element();
				set_tomax_height('sub_content' , 0);
				set_size_to_sub_content ();
			}, false);
			
			//lancement de la page par défaut
			//require _general.js
			
			page.verify('<?php echo $default_page[0]?>','<?php echo $default_page[1]?>','<?php echo $default_page[2]?>','<?php echo $default_page[3]?>');
		}
		
		var tempo_session=<?php echo $USER_SESSION_LT / $TEST_SESSION_TIMER;?>000;
		// verif de validité session
		setTimeout ("verif_session()", tempo_session);

		Event.observe(window, "load", initEventHandlers, false);
	</script>
</head>
<!-- IMAGE DE FOND ICI <?php /*<body style="background-image: url(<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/main_content_bg.gif); background-repeat:repeat-x; background-attachment:fixed"> */?>-->
<body style="background-repeat:repeat-x; background-attachment:fixed">
	<div id="grand_contener">
		<iframe id="framealert" frameborder="0" scrolling="no" src="about:blank"></iframe>
		<div id="menu" style="z-index:300; display:none;">
			<?php //nouvelle maj dispo
			if (isset($_SESSION['NEW_MAJ_DISPO']) && $_SESSION['NEW_MAJ_DISPO'] != "0") {	?>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>/images/maj_dispo.gif" alt="Nouvelle version de LundiMatin Business disponible !" title="Nouvelle version de LundiMatin Business disponible !" />
			<?php }?>
		</div>
		<div id="right_content" style="display:none">
			<div id="user"><?php echo $_SESSION['user']->getRef_user() ?></div>
			<div id="deco"><a href="<?php echo $DIR?>site/__session_stop.php">D&eacute;connexion</a></div>
			<div></div>
		</div>

		<table cellspacing="0" cellpadding="0" border="0" style="position:absolute; left:0px; height:100%">
			<tr>
				<td style="width:50%">&nbsp;</td>
				<td>
				<div id="sub_content"></div>
				</td>
				<td style="width:50%">&nbsp;</td>
			</tr>
		</table>

		<?php if ($AFFICHE_DEBUG) { ?>
		<div  style="visibility:block; float:right; position:absolute; top:0px; left:30px; z-index:500; width:10px">
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
				<tr>
					<td>
						<a id="toggle_debug_iframe"  href="#">D</a>
					</td>
				</tr>
			</table>
			<script type="text/javascript">
				Event.observe('toggle_debug_iframe', 'click',  function(evt){
					Event.stop(evt);
					$('formFrame').toggle();
				}, false);
			</script>
		</div>
		<?php } ?>

		<div id="load_show" style=" visibility:hidden; line-height:22px; height:22px;">
			<div id="boxcontent">
				<strong>Chargement en cours</strong>
			</div>
			<script type="text/javascript">
				swfobject.embedSWF("<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/waiting.swf", "boxcontent", "142", "15", "9.0.0", "expressInstall.swf", false,{wmode: "transparent", quality: "high", allowScriptAccess: "always"}, {id: "swf_waiting"});
			</script>
		</div>

		<iframe id="framemenu" frameborder="0" scrolling="no" src="about:blank"></iframe>

		<div id="wait_calcul_content" style="display:none" class="alert_wait_calcul">
			<div style="text-align:center; font:16px bolder Arial, Helvetica, sans-serif">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/wait_calcul.gif" alt="" />
			</div>
		</div>
		
		<div id="alert_pop_up"></div>

		<div id="alert_pop_up_tab" class="alert_pop_up_tab">
			<div id="titre_alert"></div>
			<div id="texte_alert"></div>		
			<div id="bouton_alert">
				<input type="submit" name="bouton1" id="bouton1" value="Supprimer" />
				<input type="submit" id="bouton0" name="bouton0" value="Retour" />
			</div>
		</div>
		
		<div id="alert_pop_up_tab_custom" class="alert_pop_up_tab_custom">
			<div id="titre_alert_custom"></div>
			<div id="texte_alert_custom"></div>		
			<div id="bouton_alert_custom"></div>
		</div>
		
		<div id="alert_fin_session" class="alert_pop_up_tab">
			<div  id="alert_fin_session_content">
				<table cellpadding=0 cellspacing=0 border=0 style="width:100%; text-align:center">
					<tr>
						<td>
							<form action ="<?php echo $_ENV['CHEMIN_ABSOLU']; ?>session_user_valid.php" method="post"  target="formFrame" name="form_login_inc" >
								<input type="hidden" name="page_from" value="" />
								<input type="hidden" name="id_profil" value="<?php echo $_SESSION['user']->getId_profil ();?>" />
								<input type="hidden" name="try" id="try" value="1" />
								<table width="100%" cellpadding=0 cellspacing=0 border=0 align="center">
									<tr>
										<td colspan="2" style="text-align:center; font-weight:bolder; line-height:20px; height:20px; border-bottom:1px solid #000000;">
											<a href="#" id="close_ask_login"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0" style="float:right"></a>
											Veuillez vous r&eacute;identifier
										</td>
									</tr>
									<tr>
										<td style="text-align: right"><?php echo ""?></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td style="text-align: right">
											Utilisateur :
										</td>
										<td>
											<?php echo  htmlentities($_SESSION['user']->getContactName ()); ?>
											<br />
											<?php echo  htmlentities($_SESSION['user']->getPseudo ()); ?>
											<input type="hidden" name='login' size=25 value="<?php echo $_SESSION['user']->getRef_user ()?>"/>
										</td>
									</tr>
									<tr>
										<td style="text-align: right">
											Mot de passe :
											</td>
										<td>
											<input type=password name="code"  id="code_relogin" size=25 value="" />
										</td>
									</tr>
									<tr>
										<td colspan=2 align="center">
											<div id="session_user_message" style="font:1em Arial, Helvetica, sans-serif; color:#FF0000; font-weight:bolder"></div>
											<br/>
											<input type="submit" name="submit" value="Valider" />
										</td>
									</tr>
									<tr>
										<td colspan=2 align="right">	
											<a href="#" onclick="window.open ('../<?php echo $DIR;?>site/__session_stop.php', '_top');" style="text-decoration:none">Quitter</a>
											<script type="text/javascript">
												Event.observe("close_ask_login", "click",  function(evt){
													Event.stop(evt);
													close_ask_login();
												}, false);
											</script>
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div id="alert_onException" class="alert_pop_up__exception_tab">
			<div  id="alert_onException_content">
				<table cellpadding=0 cellspacing=0 border=0 style="width:100%; text-align:center">
					<tr>
						<td>
							<table width="100%" cellpadding=0 cellspacing=0 border=0 align="center">
								<tr>
									<td colspan="2" style="text-align:center; font-weight:bolder; line-height:20px; height:20px;  border-bottom:1px solid #000000;">
										Erreur de connexion au serveur
									</td>
									</tr>
								<tr>
									<td style="text-align: right">&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2" style="text-align: center; font-size:10px">
										<p>
											La connexion au serveur semble interrompue. <br />
											Il se peut que  votre derni&egrave;re action n&rsquo;ait pas &eacute;t&eacute; enregistr&eacute;e. <br /><br />
											Nous vous recommandons de rafra&icirc;chir la page sur laquelle  vous travaillez ou de revalider votre derni&egrave;re action, afin de v&eacute;rifier si  toutes les donn&eacute;es ont bien &eacute;t&eacute; transmises.
										</p>
									</td>
								</tr>
								<tr>
									<td style="text-align: right">&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan=2 align="center">
										<input type="submit" name="refresh_content_alert_onException" id="refresh_content_alert_onException" value="Rafra&icirc;chir la page" />
										<input type="button" name="norefresh_content_alert_onException" id="norefresh_content_alert_onException" value="Continuer sans rafra&icirc;chir" />
									</td>
								</tr>
								<tr>
									<td colspan=2 align="right"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php if($magasin_changed == Icaisse::MAGASIN_CHANGED){ ?>
		<script type="text/javascript">
			alert("Vous avez été redirigé dans le magasin : <?php echo $_SESSION['magasin']->getLib_enseigne().' / '.$_SESSION['magasin']->getLib_magasin(); ?>");
		</script>
		<?php }elseif($magasin_changed == Icaisse::MAGASIN_CAN_NOT_CHANGED){ ?>
		<script type="text/javascript">
			alert("Erreur : Il n'existe aucun magasin de type Vente Au Comptoir");
		</script>
		<?php } ?>
		<iframe src="about:blank" style="display: none; right: 0px; position: absolute; top: 0px; height:0px;z-index:231;width:0;"0 id="historiqueFrame" name="historiqueFrame"></iframe>
		<iframe src="about:blank" style="display: none; right: 0px; position: absolute; top:50px; height:450px;z-index:231;width:50%;" scrolling="auto" id="formFrame" name="formFrame"></iframe>
	</div>
</body>
</html>
