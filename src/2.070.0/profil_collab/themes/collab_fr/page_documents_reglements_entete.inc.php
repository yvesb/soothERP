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
<table cellpadding="0" cellspacing="0" border="0" style="width:100%" id="document_reglement_entete" class="document_box">
    <tr style=" line-height:20px; height:20px;" class="document_head_list">
        <td  style=" padding-left:3px;" class="doc_bold" >
			R&egrave;glements

        </td>
    </tr>
    <tr>
        <td style="background-color:#FFFFFF; padding:3px;">
            <table style="background-color:#FFFFFF; width:100%; height:100%">
                <tr>
                    <td>
                        <div>
                            <br />
                            <?php
                            foreach ($liste_reglements as $liste_reglement) {
                                if ($liste_reglement->valide) {
                                  if ($liste_reglement->type_reglement == "sortant" && $document->getACCEPT_REGMT() == 1 && $liste_reglement->montant_on_doc > 0){
                                        $montant_acquite -= $liste_reglement->montant_on_doc;
                                  }
                                  else if ($liste_reglement->type_reglement == "entrant" && $document->getACCEPT_REGMT() == -1 && $liste_reglement->montant_on_doc <= 0){
                                        $montant_acquite += $liste_reglement->montant_on_doc;
                                  }
                                  else{
                                    $montant_acquite += $liste_reglement->montant_on_doc;
                                  }
                                    $liste_reglement_valide[] = $liste_reglement;
                                }
                            }
                            ?>
                            <table style="width:100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="3" style="text-align:center">
                                        <div class="montant_due">
                                            <span id="montant_total_reglement"> </span>
                                            <?php echo $MONNAIE[1]; ?>							</div>							</td>
                                </tr>
                                <?php
                                if (!isset($liste_reglement_valide) || !$liste_reglement_valide) {?>
                                <tr>
                                    <td colspan="3" style="text-align:center">
                                        <span style="font-size:9px; font-style:italic;">Aucun r&egrave;glement enregistr&eacute;.</span>
                                        <BR/>
                                        <span style="font-size:9px; font-style:italic;"><?php echo isset($nb_echeances_restantes)?$nb_echeances_restantes:0;?> &eacute;ch&eacute;ances</span>
                                    </td>
                                </tr>
                                    <?php
                                }  else {?>
                                <tr>
                                    <td colspan="3" style="text-align:left; background-color:#d2d2d2 ">
                                        <span style="font-size:12px; padding-left:3px">R&egrave;glements effectu&eacute;s</span>
                                    </td>
                                </tr>
                                    <?php
                                    for ($i=0; $i<3 ;$i++) {
                                        if (isset($liste_reglement_valide[$i])) {
                                            if($liste_reglement_valide[$i]->montant_on_doc >0) {
                                                ?>
                                <tr class="<?php if ($liste_reglement_valide[$i]->valide) {
                    echo "reglement_line_valide";
                } else {
                                                                echo "reglement_line_unvalide";
                                                            }?>">
                                    <td style="width:20%;; border-left:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;">
                                        <div style=" text-align:left; padding-left:10px; font-size:10px; width:75px;">
                                                            <?php
                if ($liste_reglement_valide[$i]->date_reglement!= 0000-00-00) {
                    echo htmlentities ( date_Us_to_Fr ($liste_reglement_valide[$i]->date_reglement));
                }
                                                        ?>
                                        </div>
                                    </td>
                                    <td id="rg_montant_on_doc_aff_<?php echo $i?>" style=" text-align:right; padding-right:10px; font-size:10px; width:30%; border-bottom:1px solid #d2d2d2;">
                                                        <?php
                echo htmlentities(number_format($liste_reglement_valide[$i]->montant_on_doc, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1];
                ?>	</td>
                                    <td style=" text-align:center; font-size:10px;  border-right:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;">
                                                <?php echo htmlentities($liste_reglement_valide[$i]->lib_reglement_mode); ?>
                                    </td>
                                </tr>
                                                <?php
                                            }
                                        }
    }?>
    <?php
    if (count($liste_reglement_valide) >3) {
        ?>
                                <tr>
                                    <td colspan="3" style="text-align:left; border-left:1px solid #d2d2d2; border-right:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;">
                                        <div style="font-size:10px; font-style:italic; cursor:pointer; padding-left:10px; width:100%" id="view_all_reglements">...</div>								</td>
                                </tr>
        <?php
    }
    ?>
                                <tr id="reglement_done" style="display:none">
                                    <td colspan="2" style="text-align:left; border-left:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;">
                                        <span style="font-size:10px; font-style:italic; padding-left:10px; color:#FF0000">R&egrave;glement complet effectu&eacute;</span>								</td>
                                    <td style=" text-align:right; padding-right:10px; font-size:10px; color:#FF0000; border-right:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;">&nbsp;
                                    </td>
                                </tr>
    <?php
}
?>
                                <tr id="reglement_partiel" style="display:none">
                                    <td colspan="2" style="text-align:left; border-left:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;">
                                        <span style="font-size:11px; font-style:italic; padding-left:10px; color:#FF0000">Montant restant &agrave; r&eacute;gler: <?php if($nb_echeances_restantes > 0) {
    echo " (".$nb_echeances_restantes."&eacute;ch)";
} ?></span></td>
                                    <td style=" text-align:right; padding-right:10px; font-size:10px; color:#FF0000; border-right:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;">
                                        <span id="montant_due"></span> <?php echo $MONNAIE[1]; ?></td>
                                </tr>
                            </table>
                            <span id="montant_acquite" style="display:none"><?php echo $montant_acquite?></span>
                        </div>
                    </td>
                    <td style=" vertical-align:middle; width:1%">
                        <div style="width:110px" id="affichage_paiement_rapide">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="text-align:center">
                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-espece.gif" id="bt_paiement_espece" style="cursor:pointer"/>
                                        <div style="height:5px; line-height:5px"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center">
                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-cheque.gif" id="bt_paiement_cheque" style="cursor:pointer"/>
                                        <div style="height:5px; line-height:5px"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center">
                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-carte_bancaire.gif" id="bt_paiement_carte_bancaire" style="cursor:pointer"/>
                                        <div style="height:5px; line-height:5px"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td >
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<script type="text/javascript">
    Event.observe('bt_paiement_espece', 'click',  function(){
        reglement_rapide = true;
        view_menu_1('reglements_content', 'menu_4', array_menu_e_document);
        set_tomax_height('reglements_content' , -32);
        $("docs_liste").innerHTML = "";
        document_calcul_tarif ();

        if (montant_total_neg) {
<?php if ($document->getACCEPT_REGMT() == 1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $ESP_S_ID_REGMT_MODE;?>");
    <?php } ?>
<?php if ($document->getACCEPT_REGMT() == -1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $ESP_E_ID_REGMT_MODE;?>");
    <?php } ?>
                                                                            page.traitecontent('liste_docs_nonreglees','documents_reglements_liste_docs_nonreglees.php?ref_doc=<?php echo $document->getRef_doc(); ?>&montant_neg=1','true','liste_docs_nonreglees');
                                                                        } else {
<?php if ($document->getACCEPT_REGMT() == 1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $ESP_E_ID_REGMT_MODE;?>");
    <?php } ?>
<?php if ($document->getACCEPT_REGMT() == -1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $ESP_S_ID_REGMT_MODE;?>");
    <?php } ?>
                                                                            page.traitecontent('liste_docs_nonreglees','documents_reglements_liste_docs_nonreglees.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','liste_docs_nonreglees');
                                                                        }
                                                                    }, false);

                                                                    Event.observe('bt_paiement_cheque', 'click',  function(){
                                                                        reglement_rapide = true;
                                                                        view_menu_1('reglements_content', 'menu_4', array_menu_e_document);
                                                                        set_tomax_height('reglements_content' , -32);
                                                                        $("docs_liste").innerHTML = "";
                                                                        document_calcul_tarif ();

                                                                        if (montant_total_neg) {
<?php if ($document->getACCEPT_REGMT() == 1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $CHQ_S_ID_REGMT_MODE;?>");
    <?php } ?>
<?php if ($document->getACCEPT_REGMT() == -1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $CHQ_E_ID_REGMT_MODE;?>");
    <?php } ?>
                                                                            page.traitecontent('liste_docs_nonreglees','documents_reglements_liste_docs_nonreglees.php?ref_doc=<?php echo $document->getRef_doc(); ?>&montant_neg=1','true','liste_docs_nonreglees');
                                                                        } else {
<?php if ($document->getACCEPT_REGMT() == 1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $CHQ_E_ID_REGMT_MODE;?>");
    <?php } ?>
<?php if ($document->getACCEPT_REGMT() == -1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $CHQ_S_ID_REGMT_MODE;?>");
    <?php } ?>
                                                                            page.traitecontent('liste_docs_nonreglees','documents_reglements_liste_docs_nonreglees.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','liste_docs_nonreglees');
                                                                        }
                                                                    }, false);

                                                                    Event.observe('bt_paiement_carte_bancaire', 'click',  function(){
                                                                        reglement_rapide = true;
                                                                        view_menu_1('reglements_content', 'menu_4', array_menu_e_document);
                                                                        set_tomax_height('reglements_content' , -32);
                                                                        $("docs_liste").innerHTML = "";
                                                                        document_calcul_tarif ();

                                                                        if (montant_total_neg) {
<?php if ($document->getACCEPT_REGMT() == 1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $CB_S_ID_REGMT_MODE;?>");
    <?php } ?>
<?php if ($document->getACCEPT_REGMT() == -1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $CB_E_ID_REGMT_MODE;?>");
    <?php } ?>
                                                                            page.traitecontent('liste_docs_nonreglees','documents_reglements_liste_docs_nonreglees.php?ref_doc=<?php echo $document->getRef_doc(); ?>&montant_neg=1','true','liste_docs_nonreglees');
                                                                        } else {
<?php if ($document->getACCEPT_REGMT() == 1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $CB_E_ID_REGMT_MODE;?>");
    <?php } ?>
<?php if ($document->getACCEPT_REGMT() == -1) { ?>
                                                                            insert_form_new_reglement ("reglement_add_block", "<?php echo $CB_S_ID_REGMT_MODE;?>");
    <?php } ?>
                                                                            page.traitecontent('liste_docs_nonreglees','documents_reglements_liste_docs_nonreglees.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','liste_docs_nonreglees');
                                                                        }
                                                                    }, false);


<?php 
if ($liste_reglement_valide && count($liste_reglement_valide) >3) {?>
            Event.observe('view_all_reglements', 'click',  function(evt){
                view_menu_1('reglements_content', 'menu_4', array_menu_e_document);
                set_tomax_height('reglements_content' , -32);
                Event.stop(evt);
            }, false);
    <?php
}
?>


<?php
if ($document->getACCEPT_REGMT() != 0) {
    ?>
            $("doc_menu_4").show();
    <?php
} else {
    ?>
            $("doc_menu_4").hide();
    <?php
}
?>

<?php if (!isset($load)) {?>
    document_calcul_tarif ();
    <?php
}
?>
</script>