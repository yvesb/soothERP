<table class="main_table" cellspacing="0"><tr>
	<td class="main_td">
	<table class="size_strict" cellspacing="0">
		<tr>
			<td class="size_strict">
		<tr>
			<td class="size_strict"><span class="labelled">Profil de la fiche:</span></td>
			<td><div id="divprofil">
					<table cellspacing="0">
						<tr>
							<td>
							<?php
							foreach ($_SESSION['profils'] as $exist_profil) {
								if (!$exist_profil->getId_profil()) { continue; }
								if(isset($profils[$exist_profil->getId_profil()])) {
									?>
									<span>
									<input onclick="alerte.confirm_supprimer_profil('contact_profil<?php echo $exist_profil->getId_profil();?>_supprime', 'annu_edition_profil<?php echo $exist_profil->getId_profil();?>_suppression', 'profils<?php echo $exist_profil->getId_profil();?>');" <?php 
									
									//permission (7) Gestion des collaborateurs
									if (!$_SESSION['user']->check_permission ("7") && $exist_profil->getId_profil() == $COLLAB_ID_PROFIL) { echo 'disabled="disabled"'; }
									//permission (8) Gestion des Administrateurs
									if (!$_SESSION['user']->check_permission ("8") && $exist_profil->getId_profil() == $ADMIN_ID_PROFIL) { echo 'disabled="disabled"'; }
									
									
									?> type=checkbox value="<?php echo $exist_profil->getId_profil();?>" id="profils<?php echo $exist_profil->getId_profil();?>" name="profils[<?php echo $exist_profil->getId_profil();?>]" checked="checked" />
									<?php echo htmlentities($exist_profil->getLib_profil());?></span><br />
									<?php
								}
							}
							?>	
							<?php
							foreach ($_SESSION['profils'] as $profil) {
								if (!$profil->getId_profil()) { continue; }
								if ($profil->getActif() != 1) { continue; }
								if(!isset($profils[$profil->getId_profil()]) ) {
									?>
									<span>
									<input <?php 
									
									//permission (7) Gestion des collaborateurs
									if (!$_SESSION['user']->check_permission ("7") && $profil->getId_profil() == $COLLAB_ID_PROFIL) { echo 'disabled="disabled"'; }
									//permission (8) Gestion des Administrateurs
									if (!$_SESSION['user']->check_permission ("8") && $profil->getId_profil() == $ADMIN_ID_PROFIL) { echo 'disabled="disabled"'; }
									
									
									?> onclick=" array_menu_v_contact[<?php echo $profil->getId_profil()+2;?>] 	=	new Array( 'x_typeprofil<?php echo $profil->getId_profil();?>', 'typeprofil_menu_<?php echo $profil->getId_profil();?>'); affiche_annu_edif_profil('<?php echo $profil->getId_profil();?>', '<?php echo htmlentities($profil->getLib_profil());?>');" type="checkbox" value="<?php echo $profil->getId_profil();?>" id="profils<?php echo $profil->getId_profil();?>" name="profils[<?php echo $profil->getId_profil();?>]" />
									<?php echo htmlentities($profil->getLib_profil());?></span><br />
									<?php
								}
							}
							?>	
				
							<div id="divprofil_sec">
							<?php
							$more_profil=0;
							foreach ($_SESSION['profils'] as $profil) {
								if (!$profil->getId_profil()) { continue; }
								if ($profil->getActif() != 2) { continue; }
								if(!isset($profils[$profil->getId_profil()]) ) {
									$more_profil=1;
									?>
										<span><input onclick=" array_menu_v_contact[<?php echo $profil->getId_profil()+2;?>] 	=	new Array( 'x_typeprofil<?php echo $profil->getId_profil();?>', 'typeprofil_menu_<?php echo $profil->getId_profil();?>'); affiche_annu_edif_profil('<?php echo $profil->getId_profil();?>', '<?php echo htmlentities($profil->getLib_profil());?>');" type="checkbox" value="<?php echo $profil->getId_profil();?>" id="profils<?php echo $profil->getId_profil();?>" <?php 
									
									//permission (7) Gestion des collaborateurs
									if (!$_SESSION['user']->check_permission ("7") && $profil->getId_profil() == $COLLAB_ID_PROFIL) { echo 'disabled="disabled"'; }
									//permission (8) Gestion des Administrateurs
									if (!$_SESSION['user']->check_permission ("8") && $profil->getId_profil() == $ADMIN_ID_PROFIL) { echo 'disabled="disabled"'; }
									
									
									?> name="profils[<?php echo $profil->getId_profil();?>]"><?php echo htmlentities($profil->getLib_profil());?></span><br />
									<?php
								}
							}
							?>
							<?php 
							if ($more_profil==1) {
								?>	
								<div id="moins_profil"><a href="#" id="moins_profil_link"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/moins.gif" />Moins de profils</a></div>
								</div>
								<script type="text/javascript">
								Event.observe("moins_profil_link", "click",  function(evt){Event.stop(evt); showform ('plus_profil', 'divprofil_sec');}, false);
								</script>
								<?php
							}
							?>	
					
							<div id="plus_profil"><a href="#" id="plus_profil_link"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" />Plus de profils</a></div>
								<script type="text/javascript">
								Event.observe("plus_profil_link", "click",  function(evt){Event.stop(evt); showform ('divprofil_sec', 'plus_profil');}, false);
								</script>
						</td>
						</tr>
					</table>
					</div>
			</td>
		</tr>
	</table>
		</td></tr></table>
<br />
<script type="text/javascript">
<?php
if (isset($profils[$CLIENT_ID_PROFIL] ) || isset($profils[$FOURNISSEUR_ID_PROFIL] )){
	?>
	$("compta_item_menu").show();
	array_menu_v_contact[2] 	=	new Array('contactview_comptabilite', 'contactview_menu_c');
	<?php
} else {
	?>
	$("compta_item_menu").hide();
	<?php
}
?>
Event.observe("plus_profil_link", "click",  function(evt){Event.stop(evt); showform ('divprofil_sec', 'plus_profil');}, false);
</script>