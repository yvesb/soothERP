<?php

// *************************************************************************************************************
// EDITION D'UNE TACHE
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

<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_reglement_edit" style="cursor:pointer; float:right" alt="Fermer" title="Fermer" /><br />
<br />

<table width="100%" border="0">
	<tr>
		<td style="width:50%;">	
			<table width="100%" border="0">
				<tr>
					<td style=" text-align:left; padding-left:10px; font-size:10px; width:20%;; border-left:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2; border-top:1px solid #d2d2d2;">
					<?php echo htmlentities($reglement->getLib_reglement_mode ()); ?>
					</td>
					<td style=" text-align:center; font-size:10px; border-bottom:1px solid #d2d2d2; border-top:1px solid #d2d2d2;"> le :
					<?php 
					if ($reglement->getDate_reglement ()!= 0000-00-00) {
						echo htmlentities ( date_Us_to_Fr ($reglement->getDate_reglement ()));
					}
					?>
					</td>
					<td style=" text-align:center; font-size:10px; border-bottom:1px solid #d2d2d2; border-top:1px solid #d2d2d2;">
					<?php echo price_format($reglement->getMontant_reglement ()); ?> r&eacute;gl&eacute;
					</td>
					<td style=" text-align:center; font-size:10px; border-bottom:1px solid #d2d2d2; border-top:1px solid #d2d2d2;">
					
					</td>
					<td style=" text-align:right; padding-right:10px; font-size:10px; width:20%; border-right:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2; border-top:1px solid #d2d2d2;">
					<form method="post" action="compta_reglements_sup.php" id="compta_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>" name="compta_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>" target="formFrame">
					<input name="ref_reglement" id="ref_reglement" type="hidden" value="<?php echo $reglement->getRef_reglement(); ?>" />
					</form>
					<a href="#" id="link_compta_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
					<script type="text/javascript">
					Event.observe("link_compta_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('documents_reglements_sup', 'compta_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>');}, false);
					</script>
					</td>
				</tr>
		</table>
		<form action="reglement_maj.php" method="post" id="reglement_maj" name="reglement_maj" target="formFrame" >
		<input type="hidden" value="<?php echo $reglement->getRef_reglement();?>" id="getRef_reglement()" name="getRef_reglement()" />
		<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
		</form>
		</td>
		<td  style=" background-color:#FFFFFF; border:1px solid #d6d6d6;">
		<div>
		
		<table width="100%" border="0"  cellspacing="0">
			<tr>
				<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:45%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<?php
			$indentation_lettrage = 0;
			foreach ($lettrages as $lettrage) {
				?>
				<tr>
					<td style="font-size:10px; cursor:pointer" id="doc1_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>">
					
					</td>
					<td style="font-size:10px; cursor:pointer" id="doc2_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>">
					<?php echo $lettrage->ref_doc;?>
					</td>
					<td style="text-align:right; font-size:10px; padding-right:10px;  cursor:pointer" id="doc3_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>">
					<?php	if ($lettrage->montant) { echo number_format($lettrage->montant, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }?>
					</td>
					<td style="padding-left:10px">
					</td>
				</tr>
				<tr>
					<td colspan="4"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
					<script type="text/javascript">
					Event.observe('doc1_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>', "click", function(evt){
						page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $lettrage->ref_doc; ?>'),'true','_blank');
					});
					Event.observe('doc2_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>', "click", function(evt){
						page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $lettrage->ref_doc; ?>'),'true','_blank');
					});
					Event.observe('doc3_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>', "click", function(evt){
						page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $lettrage->ref_doc; ?>'),'true','_blank');
					});
					
					</script>
					</td>
				</tr>
				<?php
			$indentation_lettrage++;
			}
			?>
			</table>
		</div>
		</td>
	</tr>
</table>

<SCRIPT type="text/javascript">
	
Event.observe("close_reglement_edit", "click", function(evt){
$("edition_reglement").innerHTML="";
$("edition_reglement").hide();
$("edition_reglement_iframe").hide();
}, false);


$("edition_reglement").show();
$("edition_reglement_iframe").show();
//on masque le chargement
H_loading();
</SCRIPT>