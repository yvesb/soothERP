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

//raccourci de la barre du haut
?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_affichage", "smenu_affichage.php" ,"true" ,"sub_content", "Affichage");
tableau_smenu[1] = Array("smenu_recherche_perso", "smenu_recherche_perso.php" ,"true" ,"sub_content", "Recherches personnalisées");
update_menu_arbo();
</script>

<p class="titre">Recherche <?php echo $titre;?> </p>
<div style="height:50px">
	<div id="cat_client" class="contactview_corps" style="padding-left:10px; padding-right:10px;" >
	
		<table class="minimizetable">
			<tr>
				<td>
				
					<!-- AJOUT RECHERCHE PERSO -->
					<div id="add_recherche" style="float:right; cursor:pointer"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> <span style="font-weight:bolder">Nouvelle recherche</span> </div>
					<br />
				
					<div class="caract_table" id="view_add_new" style="display:none">
						<?php include($DIR.$_SESSION['theme']->getDir_theme()."page_recherche_add.inc.php"); ?>
					</div>
				
					<script type="text/javascript">
					Event.observe('add_recherche', 'click',  function(){
						$("view_add_new").show();
					}, false);
					</script>
				
				</td>
			</tr>	
		</table>
		<br/>
	
		
<?php
//**********************************
//Liste des codes promo existant
if ($liste_recherche) { 

	
		//entete
?>

		<table style="width:100%">
			
			<tr>
				<td style="width:15%; text-align:left">Libell&eacute;: 
				</td>
				<td style="width:20%; text-align:left">Description:
				</td>
				<td style="width:55%; text-align:left">Requ&ecirc;te:  
				<td > 
				</td>
			</tr>
		</table>
		<?php
	//liste recherche pour modif
	foreach ($liste_recherche as $recherche) { ?>
	
		<div class="caract_table" style="margin:1px; padding:4px 0px 6px 0px;" >

			<form action="recherche_mod.php" method="post" id="recherche_mod_<?php echo $recherche->id_recherche_perso;?>" name="recherche_mod_<?php echo $recherche->id_recherche_perso;?>" target="formFrame" >
				<input name="id_recherche"  id="id_recherche" type="hidden" value="<?php echo $recherche->id_recherche_perso; ?>" />
				<input name="parent"  id="parent" type="hidden" value="<?php echo $parent; ?>" />
				<table style="width:100%">
					<tr>
						<td style="width:15%;" >
							<input name="lib_recherche" id="lib_recherche" type="text" value="<?php echo $recherche->lib_recherche_perso;?>"  class="classinput_xsize"  />
						</td >
						<td style="width:20%;" >
							<input name="desc_recherche" id="desc_recherche" type="text" value="<?php echo $recherche->desc_recherche;?>"  class="classinput_xsize"  />
						</td>
						<td style="width:55%;" >	
							<textarea name="requete" id="requete" rows=3 COLS=60><?php echo $recherche->requete;?></textarea>
						</td>
						<td style="text-align:right">
							<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
						</td>
						<td  style="width:4%; text-align:right">
							<a href="#" id="link_recherche_sup_<?php echo $recherche->id_recherche_perso; ?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
						</td>
					</tr>
				</table>
			</form>
			
		<!-- formulaire de suppression -->
			<form method="post" action="recherche_sup.php" id="recherche_sup_<?php echo $recherche->id_recherche_perso; ?>" name="recherche_sup_<?php echo $recherche->id_recherche_perso; ?>" target="formFrame">
					<input name="id_recherche" id="id_recherche" type="hidden" value="<?php echo $recherche->id_recherche_perso; ?>" />
					<input name="parent"  id="parent" type="hidden" value="<?php echo $parent; ?>" />
			</form>
		</div>
		
		<!-- Pour suppression -->
		<script type="text/javascript">
				Event.observe("link_recherche_sup_<?php echo $recherche->id_recherche_perso; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('recherche_sup', 'recherche_sup_<?php echo $recherche->id_recherche_perso; ?>');}, false);
		</script>
	<?php
		}
	}
	?>	
	</div>
	<br />
</div>