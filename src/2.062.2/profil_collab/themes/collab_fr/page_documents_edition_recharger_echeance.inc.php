
<?php

// *************************************************************************************************************
// RETOUR MODIFICATION ECHEANCE
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);

$document = open_doc ($ref_doc);
$echeances = $document->getEcheancier();
//******************************************************************
// Variables communes d'affichage
//******************************************************************
?>
<script type="text/javascript">
                                <?php //écheancier
                                                $montant_terme = 0;
                                                if (!isset($echeances) || !$echeances) {?>
window.parent.$("table_echeanciers").innerHTML = '<tr>'+
                                                    '<td colspan="6" style="text-align:left; background-color:#809eb6 " class="doc_bold2">'+
                                                    '<span style="font-size:12px; padding-left:10px">Ech&eacute;ancier</span>'+
                                                    '<input name="bt_ajouter" id="bt_ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" style="position:relative;left: 50%;width: 55px;padding-top:2px" />'+
                                                    '</td>'+
                                                    '</tr>'+
                                                    '<tr>'+
                                                    '<td colspan="6" style="text-align:center">'+
                                                    '<span style="font-size:11px; font-style:italic;">Aucune &eacute;ch&eacute;ance enregistr&eacute;e.</span>'+
                                                    '</td>'+
                                                 '</tr>';
window.parent.Event.observe('bt_ajouter', "click", function(evt){
	window.parent.Event.stop(evt);
	window.parent.doc_modifier_echeance("<?php echo $document->getRef_doc(); ?>", "<?php echo $montant_acquite ?>");
});
                                                 <?php
                                                    } else {?>
window.parent.$("table_echeanciers").innerHTML = '<tr>'+
                                                        '<td colspan="6" style="text-align:left; background-color:#809eb6 " class="doc_bold2">'+
                                                        '<span style="font-size:12px; padding-left:10px">Ech&eacute;ancier</span>'+
                                                        '</td>'+
                                                '</tr>'+
                                                <?php $i=0;
                                                foreach ($echeances as $echeance) {
                                                ?>
                                                        '<tr id="ligne_reglement_">'+

                                                        '<td style="padding-left:5px;font-size:11px; border-bottom:1px solid #d2d2d2;  width:20%;">'+
                                                        '<!-- ici les codes couleurs -->'+
                                                        '<span ><img width="8px" height="8px" src="<?php echo $DIR.$_SESSION["theme"]->getDir_theme()?>images/puce_<?php echo $echeance->etat; ?>.png"/></span>&nbsp;'+
                                                        ' <?php
                                                        if ($echeance->date!= 0000-00-00) {
                                                                echo htmlentities ( date_Us_to_Fr ($echeance->date));
                                                        }
                                                        else
                                                        {
                                                            if($echeance->jour == 0 || $echeance->jour == 1)
                                                                echo htmlentities ( $echeance->jour." jour");
                                                            else if($echeance->jour >1 )
                                                                echo htmlentities ( $echeance->jour." jours");
                                                        }
                                                        ?>'+
                                                        '</td>'+



                                                        '<td style=" text-align:left; padding-left:10px; font-size:11px; width:25%;border-bottom:1px solid #d2d2d2;">'+
                                                        '<?php echo htmlentities($echeance->type_reglement); ?>'+
                                                        '</td>'+
                                                        '<td style=" text-align:left; padding-left:10px; font-size:11px; width:35%;border-bottom:1px solid #d2d2d2;">'+
                                                        '<?php
                                                            if ($echeance->mode_reglement == ""){
                                                                    echo "Au choix du client";
                                                            }else{
                                                            global $bdd;
                                                            $query = "SELECT `lib_reglement_mode` FROM `reglements_modes` WHERE `id_reglement_mode` = '".$echeance->mode_reglement."' ";
                                                            $retour = $bdd->query($query);

                                                            if($res = $retour->fetchObject()){
                                                                    echo htmlentities($res->lib_reglement_mode);
                                                        }} ?>'+
                                                        '</td>'+




                                                        '<td style=" text-align:right; padding-right:0px; font-size:11px; border-bottom:1px solid #d2d2d2; width:25%">'+
                                                        '<?php echo htmlentities(number_format($echeance->montant, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]; ?>'+
                                                        '</td>'+

                                                        <?php if($i<0){ ?>
                                                        '<td style=" text-align:center; font-size:11px; width:15%;  border-bottom:1px solid #d2d2d2;vertical-align: middle">'+
                                                        '<input name="bt_modifier" id="bt_modifier" type="image" src="<?php echo $DIR.$_SESSION["theme"]->getDir_theme()?>images/bt-modifier.gif" style="width: 55px;padding-top: 2px" />'+
                                                        '</td>'+
                                                        '<td style=" text-align:center; font-size:11px; width:15%;  border-bottom:1px solid #d2d2d2;vertical-align: middle">'+
                                                        '<input name="bt_supprimer" id="bt_supprimer" type="image" src="<?php echo $DIR.$_SESSION["theme"]->getDir_theme()?>images/bt-supprimer.gif" style="width: 55px;padding-top: 2px" />'+
                                                        '</td>'+
                                                        <?php } $i++;?>
                                                            
                                                        '</tr>'+
                                                        <?php
                                                        if ($echeance->etat == 3){
                                                                $montant_terme += $echeance->montant;
                                                        }
                                                }
                                                ?>
                                                '<tr id="reglement_done2" style="display:none">'+
                                                        '<td colspan="4" style="text-align:left; border-left:1px solid #d2d2d2; ">'+
                                                                '<span style="font-size:11px; font-style:italic; padding-left:10px; color:#FF0000">R&egrave;glement complet effectu&eacute;</span></td>'+
                                                        '<td style=" text-align:right; padding-right:10px; font-size:11px; color:#FF0000; border-right:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;">'+
                                                        '</td>'+
                                                '</tr>'+
                                                '<tr id="reglement_partiel2" >'+
                                                        '<td colspan="3" style="text-align:left;  ">'+
                                                                '<span style="font-size:11px; font-style:italic; padding-left:10px; color:#FF0000">Montant des &eacute;ch&eacute;ances arriv&eacute;es &agrave; terme :</span>'+
                                                                '<span  class="doc_bold3" style="color:#FF0000;"> <?php echo htmlentities(number_format(($montant_terme-$montant_acquite)>=0 ? ($montant_terme-$montant_acquite):0, $TARIFS_NB_DECIMALES, ".", ""	)); ?>  <?php echo $MONNAIE[1]; ?></span>'+
                                                                '</td>'+
                                                        '<td style=" text-align:right; font-size:11px; color:#FF0000;">'+
                                                                
                                                                '<input name="bt_modifier" id="bt_modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="padding-top:2px" />'+

                                                        '</td>'+
                                                        '<td style="width:15%">'+
                                                        '</td>'+
                                                '</tr>';

window.parent.Event.observe('bt_modifier', "click", function(evt){
	window.parent.Event.stop(evt);
        divPrinc = window.parent.document.getElementById('id_body');
        divPrinc.setAttribute('id', 'id_body_princ');
	window.parent.doc_modifier_echeance("<?php echo $document->getRef_doc(); ?>", "<?php echo $montant_acquite ?>");
});
/*window.parent.Event.observe('bt_supprimer', "click", function(evt){
	window.parent.Event.stop(evt);
	window.parent.$("titre_alert").innerHTML = "<div style='width:100%; text-align:center'>Suppression de	l'&eacute;ch&eacute;ance</div>";
	window.parent.$("texte_alert").innerHTML = "&Ecirc;tes-vous s&ucirc;r de bien	vouloir supprimer cette &eacute;ch&eacute;ance ?";
	window.parent.$("bouton_alert").innerHTML = "<input type=\"submit\" id=\"bouton1\" name=\"bouton1\" value=\"Valider\" /><input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Annuler\" />";
	window.parent.show_pop_alerte();
	window.parent.$("bouton0").focus();
	window.parent.$("bouton0").onclick= function () {
		window.parent.hide_pop_alerte ();
	}
	window.parent.$("bouton1").onclick= function () {
		window.parent.hide_pop_alerte ();
		window.parent.doc_supprimer_echeance("<?php //echo $document->getRef_doc(); ?>", "<?php //echo $montant_acquite ?>");
	}
});*/
/*Recharger le bloc de reglement*/
<?php $type_doc = $document->getID_TYPE_DOC ();
if($type_doc !=1){?>
 window.parent.page.traitecontent('documents_entete','documents_entete_maj_reglements.php?ref_doc=<?php echo $_REQUEST['ref_doc']?>','true','block_reglement');
                            <?php
}
                    }
                    ?>
</script>