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
<script type="text/javascript" language="javascript">
tableau_smenu[0] = Array("", "" ,"" ,"", "");
tableau_smenu[1] = Array("", "" ,"" ,"", "");
update_menu_arbo();
array_menu_accueil	=	new Array();
array_menu_accueil[0] 	=	new Array('systeme_liste', 'menu_accueil_0');
array_menu_accueil[1] 	=	new Array('taches_liste', 'menu_accueil_1');
array_menu_accueil[2] 	=	new Array('histo_liste', 'menu_accueil_2');

</script>

<div class="emarge" id="accueil_content" >

<?php if (isset($_REQUEST["fc_ad"])) { ?>
<div style="position:absolute; width:580px; height:280px; display:none" id="acc_welcome" class="accueil_block_round4corner">
	<a href="#" id="close_acc_wecome" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
<span class="titre_second">Bienvenue dans l'interface d'administration de SoothERP, un fork du logiciel Lundi Matin Business®.</span><br />
<br />

Pour votre confort, nous avons pré-paramétré votre solution, mais il est important de consulter ces paramétrages afin de les adapter à votre activité.<br />
<br />
Vous trouverez la liste des tâches d'administration sur la page d'accueil.<br />
<br />
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/acc_welcome.jpg" border="0"><br />
<br />

</div>
<?php } ?>

<br />
<br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:420px; height:50px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_tableau_de_bord.gif"/><br />
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="420px" height="50px" id="imgsizeform"/></td>
		<td style="width:40px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="40px" height="20px" id="imgsizeform"/></td>
		<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td style="">
		<div style=" height:310px">
			<div style="height:22px">
				<ul>
				<li class="accueil_onglet" id="menu_accueil_0">Système</li>
				<li class="accueil_onglet_hide" id="menu_accueil_1"><span style="color:#FF0000"><?php echo count($taches_todo);?></span> Tâches</li>
				<li class="accueil_onglet_hide" id="menu_accueil_2">Historique</li>
				</ul>
			</div>
			<div style="height:240px;">
				<div class="accueil_block_round3corner" style="display:none" id="taches_liste" >
				<div style="overflow:auto; height:220px;">
				
				<table width="100%" border="0"  cellspacing="0">
					<tr>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:35px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>
				<?php
				foreach ($taches_todo as $tache) {
					?>
					<tr id="tache_<?php echo $tache->id_tache_admin;?>_l">
						
						
						<td>
							<div style="font-weight:bolder; cursor:pointer" id="go_tache_<?php echo $tache->id_tache_admin;?>_2"><?php echo date_Us_to_Fr($tache->date_creation);?></div>					</td>
						<td>
							<div style="font-weight:bolder; cursor:pointer" id="go_tache_<?php echo $tache->id_tache_admin;?>_3"><?php echo htmlentities($tache->lib_tache_admin);?><br />
							<span class="sbold_ita_text" style="color: #999999" id="go_tache_<?php echo $tache->id_tache_admin;?>_4"><?php echo ($tache->description );?></span>						</div>					</td>
						<td style="text-align:right;">
						<div id="etat_tache_<?php echo $tache->id_tache_admin;?>_l" style="cursor:pointer; width:10px; display:block ">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/actcoch.jpg" alt="Considérer cette tâche comme accomplie" title="Considérer cette tâche comme accomplie" id="etat_tache_<?php echo $tache->id_tache_admin;?>_2" />					</div>
					<script type="text/javascript">
					
						//observateurs pour afficher les taches de l'utilisateur
						Event.observe('go_tache_<?php echo $tache->id_tache_admin;?>_2', "click", function(evt){page.verify('tache','<?php echo $tache->url_action;?>','true','sub_content');  
							Event.stop(evt);});
						Event.observe('go_tache_<?php echo $tache->id_tache_admin;?>_3', "click", function(evt){page.verify('mes_taches','<?php echo $tache->url_action;?>','true','sub_content');  
							Event.stop(evt);});
							
						Event.observe('etat_tache_<?php echo $tache->id_tache_admin;?>_l', "click", function(evt){
							
							Event.stop(evt);
								var AppelAjax = new Ajax.Request(
										"tache_admin_exec.php", 
										{
										parameters: {id_tache_admin: '<?php echo $tache->id_tache_admin;?>'},
										evalScripts:true, 
										onLoading:S_loading, 
										onSuccess: function (requester){
																H_loading();
																requester.responseText.evalScripts();
																}
										}
										);
							});
					</script>					</td>
					</tr>
					<tr>
						<td colspan="5"><div style="height:3px; line-height:3px;"></div></td>
					</tr>
					<?php
				}
				?>
				<?php
				foreach ($taches_last_done as $tache) {
					?>
					<tr id="tache_<?php echo $tache->id_tache_admin;?>_l">
						
						
						<td>
							<div style="font-weight:bolder; cursor:pointer;color: #CCCCCC" id="go_tache_<?php echo $tache->id_tache_admin;?>_2"><?php echo date_Us_to_Fr($tache->date_creation);?></div>					</td>
						<td>
							<div style="font-weight:bolder; cursor:pointer;color: #CCCCCC" id="go_tache_<?php echo $tache->id_tache_admin;?>_3"><?php echo htmlentities($tache->lib_tache_admin);?><br />
							<span class="sbold_ita_text" style="color: #CCCCCC"><?php echo ($tache->description );?></span>						</div>					</td>
						<td style="text-align:right;">&nbsp;
					<script type="text/javascript">
					
						//observateurs pour afficher les taches de l'utilisateur
						Event.observe('go_tache_<?php echo $tache->id_tache_admin;?>_2', "click", function(evt){page.verify('tache','<?php echo $tache->url_action;?>','true','sub_content');  
							Event.stop(evt);});
						Event.observe('go_tache_<?php echo $tache->id_tache_admin;?>_3', "click", function(evt){page.verify('mes_taches','<?php echo $tache->url_action;?>','true','sub_content');  
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
				
				<div class="accueil_block_round3corner" style="" id="systeme_liste" >
				<div style="overflow:auto; height:220px;">
					<div id="test_systeme"></div>
					<br />

					<div>
					<?php 
					//nouvelle maj dispo
					if (0==1 /* Ne jamais proposer de mise à jour, incompatible avec SoothERP. isset($_SESSION['NEW_MAJ_DISPO']) && $_SESSION['NEW_MAJ_DISPO'] != "0" */) {					
						?><span style="float:left; padding-right:20px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>/images/ico_unvalide.png" alt="Nouvelle version de LundiMatin Business disponible !" title="Nouvelle version de LundiMatin Business disponible !"/></span>
						Version actuelle : <?php echo affiche_version ($_SERVER['VERSION']);?> / Dernière version : <?php echo affiche_version ($_SESSION['NEW_MAJ_DISPO']);?>
						<br /><br />
						<span style="float:left; padding-right:20px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>/images/blank.gif" width="22px" /></span>Vous devez mettre à jour LundiMatin Business : <span id="id_new_maj_dispo2" style="cursor:pointer; text-decoration:underline"  >Cliquez ici
						</span>
						<script type="text/javascript">
							Event.observe("id_new_maj_dispo2", "click", function() {	page.verify('import_maj_serveur','import_maj_serveur.php','true','sub_content');}, false);
					
						</script>
						<?php
					}
					?>
					</div>
				</div>
				</div>
				
				
				<div class="accueil_block_round3corner" style="display:none" id="histo_liste" >
				<div style="overflow:auto; height:220px;">			</div>
				</div>
			</div>
		</div>
		<div style="height:55px">
		&nbsp;
		<br />
		<br />
		<?php 
		if (isset($profils_allowed[$COLLAB_ID_PROFIL])) { 
			?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_access_profil_collab.jpg" id="go_profil_collab" style="cursor:pointer" />
			<script type="text/javascript">
				Event.observe('go_profil_collab', 'click',  function(evt){Event.stop(evt); window.open ("<?php echo $DIR;?>site/__user_choix_profil.php?id_profil=<?php echo $COLLAB_ID_PROFIL;?>", "_top");}, false);
			</script>
			<?php 
		}
		?>
		</div>

			</td>
		<td>&nbsp;</td>
		<td style="">
			<div>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_tbdb_parametrage.gif"/><br /><br />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_entreprise_small.jpg" id="osmenu_entreprise" style="cursor:pointer" />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_annuaire_small.jpg" id="osmenu_annuaire" style="cursor:pointer"  />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_catalogue_small.jpg" id="osmenu_catalogue" style="cursor:pointer" />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_comptabilite_small.jpg" id="osmenu_comptabilite" style="cursor:pointer"  />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_affichage_small.jpg" id="osmenu_affichage" style="cursor:pointer" />
				<br /><br />
			</div>
			<div>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_tbdb_gestion.gif"/><br />
				<br />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_utilisateurs_small.jpg"  id="osmenu_utilisateurs" style="cursor:pointer"/>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_site_internet_small.jpg" id="osmenu_site_internet" style="cursor:pointer"/>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_communication_small.jpg" id="osmenu_communication" style="cursor:pointer" />
				<br /><br />
			</div>
			<div>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_tbdb_systeme.gif"/><br />
				<br />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_secusys_small.jpg" id="osmenu_secusys" style="cursor:pointer"/>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_maintenance_small.jpg" id="osmenu_maintenance" style="cursor:pointer" />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_transfert_donnees_small.jpg" id="osmenu_transfert_donnees" style="cursor:pointer" />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_gestion_modules_small.jpg" id="osmenu_gestion_modules" style="cursor:pointer" />
				<!-- Mise à jour incompatible SoothERP, ligne  commentée <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_maj_small.jpg" id="osmenu_maj" style="cursor:pointer" /><br />-->
				<br />
			</div>
		</td>
	</tr>
</table>



</div>
<SCRIPT type="text/javascript">
//observateur pour parametrage
Event.observe("osmenu_entreprise", "click",  function(evt){Event.stop(evt); page.verify('smenu_entreprise', 'smenu_entreprise.php' ,"true" ,"sub_content");}, false);
Event.observe("osmenu_annuaire", "click",  function(evt){Event.stop(evt); page.verify('smenu_annuaire', 'smenu_annuaire.php' ,"true" ,"sub_content");}, false);
Event.observe("osmenu_catalogue", "click",  function(evt){Event.stop(evt); page.verify('smenu_catalogue', 'smenu_catalogue.php' ,"true" ,"sub_content");}, false);
Event.observe("osmenu_comptabilite", "click",  function(evt){Event.stop(evt); page.verify('smenu_comptabilite', 'smenu_comptabilite.php' ,"true" ,"sub_content");}, false);
Event.observe("osmenu_affichage", "click",  function(evt){Event.stop(evt); page.verify('smenu_affichage', 'smenu_affichage.php' ,"true" ,"sub_content");}, false);

//observateurs pour gestion
Event.observe("osmenu_utilisateurs", "click",  function(evt){Event.stop(evt); page.verify('smenu_utilisateurs', 'smenu_utilisateurs.php' ,"true" ,"sub_content");}, false);
Event.observe("osmenu_site_internet", "click",  function(evt){Event.stop(evt); page.verify('smenu_site_internet', 'smenu_site_internet.php' ,"true" ,"sub_content");}, false);
Event.observe("osmenu_communication", "click",  function(evt){Event.stop(evt); page.verify('smenu_communication', 'smenu_communication.php' ,"true" ,"sub_content");}, false);

//observateurs pour systeme
Event.observe("osmenu_secusys", "click",  function(evt){Event.stop(evt); page.verify('smenu_secusys','smenu_secusys.php' ,"true" ,"sub_content");}, false);
Event.observe("osmenu_maintenance", "click",  function(evt){Event.stop(evt); page.verify('smenu_maintenance','smenu_maintenance.php' ,"true" ,"sub_content");}, false);
Event.observe("osmenu_transfert_donnees", "click",  function(evt){Event.stop(evt); page.verify('smenu_transfert_donnees','smenu_transfert_donnees.php' ,"true" ,"sub_content");}, false);
Event.observe("osmenu_gestion_modules", "click",  function(evt){Event.stop(evt); page.verify('smenu_gestion_modules','smenu_gestion_modules.php' ,"true" ,"sub_content");}, false);
// Mise à jour incompatible SoothERP, ligne suivante commentée
//Event.observe("osmenu_maj", "click",  function(evt){Event.stop(evt); page.verify('import_maj_serveur','import_maj_serveur.php' ,"true" ,"sub_content");}, false);


Event.observe("menu_accueil_0", "click",  function(evt){Event.stop(evt); view_menu_accueil('systeme_liste', 'menu_accueil_0', array_menu_accueil ,"accueil_onglet_hide" ,"accueil_onglet");}, false);
Event.observe("menu_accueil_1", "click",  function(evt){Event.stop(evt); view_menu_accueil('taches_liste', 'menu_accueil_1', array_menu_accueil ,"accueil_onglet_hide" ,"accueil_onglet");}, false);
Event.observe("menu_accueil_2", "click",  function(evt){Event.stop(evt); view_menu_accueil('histo_liste', 'menu_accueil_2', array_menu_accueil ,"accueil_onglet_hide" ,"accueil_onglet");}, false);

function setheight_accueil(){
set_tomax_height('accueil_content' , -32); 
}
Event.observe(window, "resize", setheight_accueil, false);
setheight_accueil();

<?php if (isset($_REQUEST["fc_ad"])) { ?>
centrage_element("acc_welcome");
Event.observe("close_acc_wecome", "click",  function(evt){Event.stop(evt);$("acc_welcome").hide();}, false);
$("acc_welcome").show();
<?php } ?>



new Ajax.Updater(
								"test_systeme",
								'test_systeme.php', 
								{
								evalScripts:true, 
								onLoading:S_loading, 
								onComplete:function (originalRequest) {
										H_loading();
								}
								}
								);

//on masque le chargement
H_loading();
</SCRIPT>