<?php

// *************************************************************************************************************
// EDITION D'UNE TACHE
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
if (!$reglement->getRef_reglement()) {
	?>
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_reglement_edit" style="cursor:pointer; float:right" alt="Fermer" title="Fermer" />
	<span style="font-weight:bolder">Ce règlement n'existe pas ou a été supprimé</span>

	<SCRIPT type="text/javascript">

	Event.observe("close_reglement_edit", "click", function(evt){
	$("edition_reglement").innerHTML="";
	$("edition_reglement").hide();
	$("edition_reglement_iframe").hide();
	}, false);

	//on masque le chargement
	H_loading();
	</SCRIPT>
	<?php
	exit();
}

?>

<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_reglement_edit" style="cursor:pointer; float:right" alt="Fermer" title="Fermer" />
<form method="post" action="compta_reglements_sup.php" id="documents_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>" name="documents_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>" target="formFrame">
    <input name="ref_reglement" id="ref_reglement" type="hidden" value="<?php echo $reglement->getRef_reglement(); ?>" />
</form>
<table style="width:100%;">
	<tr>
		<td style="width:50%;">
			<span style="font-weight:bolder">D&eacute;tails du règlement</span>

                        <a href="#" id="link_documents_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>" style="color:blue;left:305px;position:absolute;top:25px;">Supprimer</a>
                        <script type="text/javascript">
                            Event.observe("link_documents_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>", "click",  function(evt){
                                Event.stop(evt); alerte.confirm_supprimer('documents_reglements_sup', 'documents_reglements_sup_<?php echo $reglement->getRef_reglement(); ?>');
                            }, false);
                        </script>

			<table class="div_deco1" style="width:85%; padding:5px;">
				<tr>
					<td>Type de r&eacute;glement :</td>
                                        <td><?php echo $reglement->getLib_reglement_mode(); ?></td>
				</tr>
                                <tr>
					<td>Montant :</td>
                                        <td><?php echo price_format($reglement->getMontant_reglement()); ?></td>
				</tr>

                                 <?php foreach($reglements_infos as $type => $val){
                                    $info = format_info($type,$val);
                                    if(!empty($info['lib'])){ ?>
                                        <tr>
                                            <td><?php echo $info['lib'].' :'; ?></td>
                                            <td><?php echo $info['val']; ?></td>
                                        </tr>
                                    <?php }
                                 } ?>

                                 <tr>
					<td>Date de réglement :</td>
                                         <td><?php echo $reglement->getDate_reglement(); ?></td>
				</tr>
				<tr>
					<td>Date d'échéance :</td>
                                        <td><?php echo $reglement->getDate_echeance(); ?></td>
				</tr>
                                <tr>
                                        <td colspan="2" style="font-size: 11px; font-style: italic; color: red;" >
                                               <?php echo $reglement->getInfos_depot(); ?>
                                        </td>
				</tr>
			</table>

                        <?php /* if($reglement->getId_reglement_mode() == )*/ ?>
		</td>
		<td style="width:50%;">
			<span style="font-weight:bolder">Liste des documents liés à ce règlement</span>
			<div style=" background-color:#FFFFFF; border:1px solid #d6d6d6;">

			<?php
			$indentation_lettrage = 0;
                        $total_attribuer = 0;
			foreach ($lettrages as $lettrage) {
				$doc = open_doc($lettrage->ref_doc);
                                $total_attribuer += $lettrage->montant;
				?>
				<table width="100%" border="0"  cellspacing="0" id="view_doc_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>">
					<tr>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>
					<tr>
						<td style="font-size:10px; cursor:pointer; padding-left:10px;" id="doc1_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>">
							<?php echo $doc->getDate_creation(); ?>
						</td>
						<td style="font-size:10px; cursor:pointer; <?php if (!$lettrage->liaison_valide) {echo 'color:#CCCCCC;';}?>" id="doc2_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>">
                                                    <?php echo $lettrage->ref_doc;?>
						</td>
						<td>
							<?php echo $doc->getLib_etat_doc(); ?>
						</td>
						<td style="text-align:right; font-size:11px; padding-right:3px;  cursor:pointer" id="doc3_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>">
                                                    <?php	if ($lettrage->montant) { echo number_format($lettrage->montant, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }?>
						</td>
						<td style="padding-left:11px">
                                                    <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/unlink.gif" border="0" style="cursor:pointer" id="unlink_doc1_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>">
						</td>
					</tr>

					<tr>
						<td colspan="5"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
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

						Event.observe('unlink_doc1_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>', "click", function(evt){
							unlink_doc_to_reglement ('<?php echo $lettrage->ref_doc;?>', '<?php echo $reglement->getRef_reglement();?>', 'view_doc_<?php echo $indentation_lettrage;?>_<?php echo $lettrage->ref_doc;?>', '<?php if (isset($ref_doc)) { echo $ref_doc; } ?>', '<?php if (isset($ref_contact)) { echo $ref_contact; } ?>');
						});
						</script>
						</td>
					</tr>

                                   </table>
				<?php
			$indentation_lettrage++;
			}

                        if($total_attribuer == $reglement->getMontant_reglement()){
                            echo '<span style="font-size: 11px; padding-left:10px; font-style: italic; " >Réglement totalement attribué.</span>';
                        }else{
                            echo '<span style="font-size: 11px; padding-left:10px; font-style: italic; " >Soit '.price_format($total_attribuer).$MONNAIE[1].' attribués (<span style="color: red;">'.price_format($reglement->getMontant_reglement()-$total_attribuer).$MONNAIE[1].' disponibles</span>).</span>';
                        }
			?>
		</div>
		</td>
	</tr>
         <tr>
             <td colspan="2" style="padding: 20px 15px;" >
                 <?php


                  ?>
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