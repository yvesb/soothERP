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
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('codes_promo','codes_promo.php' ,"true" ,"sub_content", "Codes promo");
update_menu_arbo();
</script>

<p class="titre">Codes promo</p>
<div style="height:50px">
	<div id="cat_client" class="contactview_corps" style="padding-left:10px; padding-right:10px;" >
	
		<table class="minimizetable">
			<tr>
				<td>
				
					<!-- AJOUT CODE PROMO -->
					<div id="add_code" style="float:right; cursor:pointer"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> <span style="font-weight:bolder">Nouveau code promo</span> </div>
					<br />
				
					<div class="caract_table" id="view_add_new" style="display:none">
						<?php include($DIR.$_SESSION['theme']->getDir_theme()."page_codes_promo_add.inc.php"); ?>
					</div>
				
					<script type="text/javascript">
					Event.observe('add_code', 'click',  function(){
						$("view_add_new").show();
						$("lib_code_promo").focus();
					}, false);
					</script>
				
				</td>
			</tr>	
		</table>
		<br/>
	
		
<?php
//**********************************
//Liste des codes promo existant
if ($codes_promo) { 

	
		//entete
?>

		<table style="width:100%">
			
			<tr>
				<td style="width:20%; text-align:left">Libell&eacute;: 
				</td>
				<td style="width:20%; text-align:left">Code:
				</td>
				<td style="width:20%; text-align:left">Pourcentage:  
				</td>
				<td style="width:5%; text-align:left">Actif:  
				</td>
				<td > 
				</td>
			</tr>
		</table>
				
			
		

	<?php 
	foreach ($codes_promo as $code_promo) { ?>
	
		<div class="caract_table" style="margin:1px; padding:4px 0px 6px 0px;" >
			
			<form action="codes_promo_mod.php" method="post" id="codes_promo_mod_<?php echo $code_promo->getId_code_promo();?>" name="codes_promo_mod_<?php echo $code_promo->getId_code_promo();?>" target="formFrame" >
				<input name="id_code_promo"  id="id_code_promo" type="hidden" value="<?php echo $code_promo->getId_code_promo(); ?>" />
				<table style="width:100%">
					<tr>
						<td style="width:20%;" >
							<input name="lib_code_promo" id="lib_code_promo" type="text" value="<?php echo ($code_promo->getArticle()->getLib_article());?>"  class="classinput_xsize"  />
						</td >
						<td style="width:20%;" >
							<input name="code_promo" id="code_promo" type="text" value="<?php echo $code_promo->getCode();?>"  class="classinput_xsize"  />
						</td>
						<td style="width:20%;" >
							<input name="pourc_code_promo" id="pourc_code_promo" type="text" value="<?php echo $code_promo->getPourcentage();?>"  class="classinput_xsize"  />
						</td>
						<td style="width:5%; text-align:center;" >
							<input name="actif_code_promo" id="actif_code_promo" type="checkbox" <?php echo ($code_promo->isActif())? 'checked="yes"' : '' ; ?>"   />
						</td>
						<td style="text-align:right">
							<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
						</td>
						<td  style="width:4%; text-align:right">
							<a href="#" id="link_code_promo_sup_<?php echo $code_promo->getId_code_promo(); ?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
						</td>
					</tr>
				</table>
			</form>
			
			<!-- formulaire de suppression -->
			<form method="post" action="codes_promo_sup.php" id="codes_promo_sup_<?php echo $code_promo->getId_code_promo(); ?>" name="codes_promo_sup_<?php echo $code_promo->getId_code_promo(); ?>" target="formFrame">
					<input name="id_code_promo" id="id_code_promo" type="hidden" value="<?php echo $code_promo->getId_code_promo(); ?>" />
			</form>
			
		</div>

		<?php
		//********************************************
		// JAVASCRIPT LIEE A UN CODE PROMO		?>	
		<script type="text/javascript">
				Event.observe("link_code_promo_sup_<?php echo $code_promo->getId_code_promo(); ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('codes_promo_sup', 'codes_promo_sup_<?php echo $code_promo->getId_code_promo(); ?>');}, false);
		</script>
	<?php
		
	}
}
	?>
	</div>
	<br />
</div>