<?php

// *************************************************************************************************************
// AFFICHAGE D'UN DOCUMENT
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
    $("wait_calcul_content").style.display= "block";
<?php
if (isset($_REQUEST['id_type_doc']) || isset($_REQUEST["fonction_generer"])) {
    ?>
            //on réinjecte dans l'historique la version édition si c'est un nouveau document qui a été créé
            historique.unshift("documents_edition.php?ref_doc=<?php echo htmlentities($document->getRef_doc())?>");
            default_show_url = "documents_edition.php?ref_doc=<?php echo htmlentities($document->getRef_doc())?>";
            document.location.hash = "documents_edition.php?ref_doc=<?php echo htmlentities($document->getRef_doc())?>";
    <?php
}
?>
    document_accept_reglement = <?php if($document->getACCEPT_REGMT() == 0) {
    echo 'false';
}else {
    echo 'true';
}?>;
    quantite_locked = false;
    allow_recalcul_encours = false;
    montant_total_neg=false;
    array_menu_e_document	=	new Array();
    array_menu_e_document[0] 	=	new Array('document_content', 'menu_1');
    array_menu_e_document[1] 	=	new Array('rechercher_content', 'menu_2');
    //array_menu_e_document[2] 	=	new Array('historique_content', 'menu_3');
    array_menu_e_document[3] 	=	new Array('reglements_content', 'menu_4');
    array_menu_e_document[4] 	=	new Array('note_content', 'menu_5');
    array_menu_e_document[5] 	=	new Array('options_avancees', 'menu_6');
    array_menu_e_document[6] 	=	new Array('compta_content', 'menu_7');
<?php if ($id_type_doc <5) {
    if ( $_SESSION['user']->check_permission ("6") ) {?>
    array_menu_e_document[7] 	=	new Array('marge_content', 'menu_8');
        <?php }
    if ( $_SESSION['user']->check_permission ("17") ) {?>
    array_menu_e_document[8] 	=	new Array('commercial_content', 'menu_8b');
        <?php }
} ?>
             array_menu_e_document[9] 	=	new Array('pieces_content', 'menu_9');
</script>
<div id="main_doc_div" style="" class="emarge"><br />
    <div style="height:50px; width:99%">
        <?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>
        <?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_recherche_mini.inc.php" ?>
        <?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_recherche_mini.inc.php" ?>
        <?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_lines_info_modeles.inc.php" ?>
        <?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_recherche_newmini.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_article_sn.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_content_model.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_lines_link.inc.php" ?>
        <div id="historique_content"  class="mini_moteur_doc" style="display:none;" >
        </div>
        <div id="mod_contenu_content"  class="mini_moteur_doc" style="display:none;" ></div>
        <div id="pop_up_lines_livraison_modes_doc" class="lines_livraison_modes_doc" style="display:none;">
        </div>
        <div>
            <div id="pop_up_lines_liste_tva_doc" class="lines_liste_tva_doc" style="display:none;">

                <a href="#" id="link_close_pop_up_lines_liste_tva_doc" style="float:right">
                    <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
                </a>
                <script type="text/javascript">
                    Event.observe("link_close_pop_up_lines_liste_tva_doc", "click",  function(evt){Event.stop(evt); $("pop_up_lines_liste_tva_doc").style.display = "none";}, false);
                </script>
                <div style="font-weight:bolder">Modifier le taux de T.V.A. des lignes sélectionnées </div>
                <br />

                Nouveau Taux: <input type="text" id="newtva_taux_lines" name="newtva_taux_lines" class="classinput_hsize" value="0"/>
                <br /><br />
                <div style="text-align:center">

                    <input name="modifier_tva_taux_lines" id="modifier_tva_taux_lines" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
                </div>
                <SCRIPT type="text/javascript">
                    //centrage de la pop up
                    centrage_element("pop_up_lines_liste_tva_doc");

                    Event.observe(window, "resize", function(evt){
                        centrage_element("pop_up_lines_liste_tva_doc");
                    });

                    Event.observe("newtva_taux_lines", "blur", function(evt){
                        nummask(evt, 0, "X.XY");
                    });

                    Event.observe("modifier_tva_taux_lines", "click", function(evt){
                        $("pop_up_lines_liste_tva_doc").style.display = "none";
                        maj_tva_lines_doc($("newtva_taux_lines").value);
                    });

                </SCRIPT>

            </div>
            <ul id="menu_recherche" class="menu">
                <div id="doc_menu_6">
                    <a href="#" id="menu_6" class="menu_unselect" style=" float:right">Options avanc&eacute;es</a>
                </div>

                <div id="tool_item_menu" style="float:right; width:60px; position:relative; cursor:pointer;">
                    <span class="hymenu_unselect" style="float:right;">
	Outils
                    </span>
                    <span id="tool_uitem_menu" style="position:absolute; top:18px; left:5px; width:160px; text-align:right; display:none; z-index:100" >
                        <span id="doc_menu_7" style="display:none; text-align: left">
                            <a href="#" id="menu_7" class="menu_unselect">Comptabilité</a>
                        </span>
                            <?php if ($id_type_doc <5) {?>
                        <span id="doc_menu_8" style="text-align: left">
    <?php  if ($_SESSION['user']->check_permission ("6")) {?>
                            <a href="#" id="menu_8" class="menu_unselect">Marges</a>
        <?php }
                            if ($_SESSION['user']->check_permission ("17")) {?>
                            <a href="#" id="menu_8b" class="menu_unselect">Commercial</a>
        <?php }?>
                        </span>
    <?php } ?>
                        <span id="doc_menu_9" style="text-align: left">
                            <a href="#" id="menu_9" class="menu_unselect">Pièces jointes</a>
                        </span>

                    </span>
                </div>
                <script type="text/javascript">
                    Event.observe("tool_item_menu", "click",  function(evt){
                        Event.stop(evt);
                        $("tool_uitem_menu").toggle();
                    }, false);
                </script>
                <li id="doc_menu_1">
                    <a href="#" id="menu_1" class="menu_select"><?php echo htmlentities($document->getLib_type_doc());?>  <?php echo htmlentities($document->getRef_doc());?></a>
                </li>
                <li id="doc_menu_2">
                    <a href="#" id="menu_2" class="menu_unselect">Ajouter un article</a>
                </li>

                <li id="doc_menu_4" style=" <?php
if ($document->getACCEPT_REGMT() == 0) {?>display:none;
    <?php
}
                ?>">
                    <a href="#" id="menu_4" class="menu_unselect">R&egrave;glements</a>
                </li>
                <!--	<li id="doc_menu_3">
		<a href="#" id="menu_3" class="menu_unselect">Historique</a>
	</li>-->
                <li id="doc_menu_5">
                    <a href="#" id="menu_5" class="menu_unselect" style=" <?php if ($document->getDescription () != "") {
    echo "color:#FF0000";
}?>">Note</a>
                </li>
            </ul>
        </div>

        <div id="document_content" class="articletview_corps"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; position:relative">

            <div style=" height:355px; width:99%;">
                <div style="padding:10px">

                    <div id="block_head">
<?php
$load="1";
include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_block_headoc_".$document->getID_TYPE_DOC().".inc.php"
        ?>
                    </div>

                    <div id="block_linkandedit" style="width:99%">
                        <table cellpadding="0" cellspacing="0" border="0" style="width:100%">
                            <tr>
                                <td style="width:86%">
                                    <div id="block_liaisons" style="width:99%;">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_block_liaisons.inc.php" ?>
                                    </div>
                                    <div style=" height:8px;"></div>
                                    <div id="block_rechercher_rapide" style="width:99%;">
                                        <table cellpadding="0" cellspacing="0" border="0" style="width:100%" class="document_head_list_r_search">
                                            <tr style="height:32px; line-height:32px;">
                                                <td style="width:150px; padding-left:3px;height:32px; line-height:32px;" class="doc_bold">
					Recherche rapide:
                                                </td>
                                                <td style="width:250px;height:32px; line-height:32px;">
                                                    <input type="text" name="lib_article_r" id="lib_article_r" value=""  class="classinput_xsize"/>
                                                </td>
                                                <td style="height:32px; line-height:32px;">
                                                    &nbsp;&nbsp;<a href="#" id="go_rechercher_rapide" class="doc_link_standard"> Ins&eacute;rer </a> <span id="message_r" style="color:#FF0000"></span>
                                                </td>
                                                <td style="height:32px; line-height:32px;">
<?php if (count($modeles_lignes) > 0) { ?>
                                                    &nbsp;&nbsp;<a href="#" id="use_content_model" class="doc_link_standard"> Utiliser un mod&egrave;le de contenu </a> <span id="message_ru" style="color:#FF0000"></span>
    <?php } ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <!-- Afficher , Imprimer, E-mail -->
                                <td style="text-align:right">
                                    <a href="documents_editing.php?ref_doc=<?php echo $document->getRef_doc()?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-afficher.gif" alt="Afficher" title="Afficher"/></a>
                                    <div style="height:5px; line-height:5px"></div>

                                    <a href="documents_editing.php?ref_doc=<?php echo $document->getRef_doc()?>&print=1" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="Imprimer" title="Imprimer"/></a>
                                    <div style="height:5px; line-height:5px"></div>


                                    <div style="position:relative; top:3px; left:5px;  height:0px;">
                                        <iframe id="iframe_choix_send_mail" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville"></iframe>
                                        <div id="choix_send_mail"  class="choix_complete_ville" style="display:none; left:-185px; width:311px; height:85px"></div></div>
                                    <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-email.gif" alt="Envoyer par email" title="Envoyer par email" style="cursor:pointer" id="send_mail_to_client"/>
                                    <script type="text/javascript">

                                        Event.observe("send_mail_to_client", "click",  function(evt){
                                            Event.stop(evt);
                                            if ($("choix_send_mail").style.display=="none") {
                                                var AppelAjax = new Ajax.Updater(
                                                "choix_send_mail",
                                                "documents_contact_email_list.php",
                                                {parameters: {ref_doc: "<?php echo $document->getRef_doc()?>"},
                                                    evalScripts:true,
                                                    onLoading:S_loading, onException: function () {S_failure();},
                                                    onComplete: function(requester) {
                                                        H_loading();
                                                        if (requester.responseText!="") {
                                                            $("choix_send_mail").style.display="block";
                                                            $("iframe_choix_send_mail").style.display="block";
                                                        }
                                                    }
                                                }
                                            );
                                            } else {
                                                $("choix_send_mail").style.display="none";
                                                $("iframe_choix_send_mail").style.display="none";
                                            }
                                        }, false);

                                    </script>
<?php
if ($SEND_FAX2MAIL) {
    ?>
                                    <div style="height:5px; line-height:5px"></div>
                                    <div style="position:relative; top:3px; left:5px;  height:0px;">
                                        <iframe id="iframe_choix_send_fax" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville"></iframe>
                                        <div id="choix_send_fax"  class="choix_complete_ville" style="display:none; left:-185px; width:311px; height:85px"></div></div>
                                    <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fax.gif" alt="Envoyer par fax" title="Envoyer par fax" style="cursor:pointer" id="send_fax_to_client"/>
                                    <script type="text/javascript">

                                        Event.observe("send_fax_to_client", "click",  function(evt){
                                            Event.stop(evt);
                                            if ($("choix_send_fax").style.display=="none") {
                                                var AppelAjax = new Ajax.Updater(
                                                "choix_send_fax",
                                                "documents_contact_fax_list.php",
                                                {parameters: {ref_doc: "<?php echo $document->getRef_doc()?>"},
                                                    evalScripts:true,
                                                    onLoading:S_loading, onException: function () {S_failure();},
                                                    onComplete: function(requester) {
                                                        H_loading();
                                                        if (requester.responseText!="") {
                                                            $("choix_send_fax").style.display="block";
                                                            $("iframe_choix_send_fax").style.display="block";
                                                        }
                                                    }
                                                }
                                            );
                                            } else {
                                                $("choix_send_fax").style.display="none";
                                                $("iframe_choix_send_fax").style.display="none";
                                            }
                                        }, false);

                                    </script>
    <?php
}
?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <br />
                    <!-- Entete Menu article in docs-->
                    <div id="block_lignes_articles" style="width:99%">

                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="document_box_head">
                            <tr>
                                <td style="width:1px;">
                                    <div style="width:1px;">
                                    </div>
                                </td>
                                <td style="width:135px; padding-left:2px;" class="document_border_topright_head_bold">
                                    <div style="width:132px;">
			R&eacute;f&eacute;rence
                                    </div>
                                </td>
                                <td style="width:285px; padding-left:3px;" class="doc_head_bold">
                                    <div style="width:285px;">
			Description
                                    </div>
                                </td>
                                <td style=" width:27px;" class="document_border_topright_head_bold">
                                    <div style="width:27px;">
                                    </div>
                                </td>
                                <td style="width:70px; text-align:center" class="document_border_topright_head_bold">
                                    <div style="width:70px;">
			Qt&eacute;
                                    </div>
                                </td>
                                <?php if ($document->getID_TYPE_DOC() == $COMMANDE_CLIENT_ID_TYPE_DOC) {?>
                                <td style="width:50px; text-align:center;" class="document_border_topright_head_bold">
                                    <div style="width:50px;">
			Livr&eacute;e
                                    </div>
                                </td>
    <?php } ?>
								<?php if ($document->getID_TYPE_DOC() == $DEVIS_CLIENT_ID_TYPE_DOC  && !empty($USE_PA_HT_FORCED)) {?>
                                <td style="width:55px; text-align:center;" class="document_border_topright_head_bold">
                                   <div style="width:55px;">
			PA HT
                                  </div>
                              </td>
	<?php } ?>
                                <?php if ($document->getID_TYPE_DOC() == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC) {?>
                                <td style="width:50px; text-align:center;" class="document_border_topright_head_bold">
                                    <div style="width:50px;">
			Re&ccedil;u
                                    </div>
                                </td>
                                    <?php } ?>
                                <td style="width:70px; text-align:center;" class="document_border_topright_head_bold">
                                    <div style="width:70px;">
                                        <span id="col_pu">PU</span>
                                    </div>
                                </td>
                                <?php if ($AFF_REMISES) {
                                    if($id_type_doc == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC || $id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC){?>
                                        <td style="width:65px; text-align:center;" class="document_border_topright_head_bold">
                                            <div style="width:65px;">
                                    <?php } else { ?>
                                        <td style="width:70px; text-align:center;" class="document_border_topright_head_bold">
                                            <div style="width:70px;">
                                    <?php } ?>
                                    
				R (%)
                                    </div>
                                </td>

    <?php }  else {?>
                                <td style="width:0px; text-align:center">
                                </td>
    <?php } ?>
                                <td style="width:70px; text-align:center;" class="document_border_topright_head_bold">
                                    <div style="width:70px;">T.V.A.</div>
                                </td>
                                <td style="width:70px; text-align:center;" class="document_border_topright_head_bold">
                                    <div style="width:70px;"><span id="col_pt">PT</span></div>
                                </td>
                                <td >
                                    <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
                                        <tr>
                                            <td style="width:25px; text-align:right;"><div style="width:25px;">&nbsp;</div>
                                            </td>
                                            <td style="width:25px; text-align:right;"><div style="width:25px;">&nbsp;</div>
                                            </td>
                                            <td style="width:25px; text-align:right;"><div style="width:25px;">&nbsp;</div>
                                            </td>
                                            <td style="width:25px; text-align:right;"><div style="width:25px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- Appel des page_documents_line -->
                        <ul id="lignes" class="document_u_liste" style="padding:0px; width:100%">
                            <?php
                            $indentation_contenu = 0;
                            $liste_contenu = $document->getContenu ();
                                foreach ($liste_contenu as $contenu) {

                                    if($document->is_taxe($contenu->lib_article)===true)
                                       $taxe=1;
                                    else
                                       $taxe=0;
                                    $nb_lignes_liees = $document->getNb_lignes_liees($contenu->ref_doc_line);
                                    //Ajout condition pour séparer taxe de l'article (=total de 2 articles)
                                    if ($contenu->ref_doc_line_parent == "" || (isset($TAXE_IN_PU) && $TAXE_IN_PU==0 &&  $taxe==1)) {
                                        if ($indentation_contenu != 0) {
            echo "</li>";
                                            }
        ?>
                            <li id="<?php echo $contenu->ref_doc_line."_".$indentation_contenu;?>">
                                        <?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_".$contenu->type_of_line.".inc.php" ?>
                                        <?php
                                    }
                                    else {
                                        ?>
                                <div id="<?php echo $contenu->ref_doc_line."_".$indentation_contenu;?>">
        <?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_".$contenu->type_of_line.".inc.php" ?>
                                </div>
        <?php
    }
    if ($indentation_contenu == count($liste_contenu )) {
        echo "</li>";
    }
    $indentation_contenu++;
}
?>
                        </ul>
                        <input type="hidden" value="<?php echo $indentation_contenu;?>" id="indentation_contenu" name="indentation_contenu"/>
                        <div id="totalsdeslignes" style=" width:99%;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
                                <tr>
                                    <td rowspan="2" style="width:33px">
                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/arrow_ltr.png" />
                                    </td>
                                    <td style="height:4px; line-height:4px">
                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
                                    </td>
                                    <td style="height:4px; line-height:4px">
                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:325px;">
                                        <a href="#" id="all_coche" class="doc_link_simple">Tout cocher</a> / <a href="#" id="all_decoche" class="doc_link_simple">Tout d&eacute;cocher</a> / <a href="#" id="all_inv_coche" class="doc_link_simple">Inverser la s&eacute;lection</a>
                                    </td>
                                    <td style="width:160px;" >
                                        <select id="coche_action" name="coche_action" class="classinput_xsize">
                                            <option value="">Pour la s&eacute;lection</option>
                                            <option value="delete_multiples_lines">Supprimer</option>
                                            <option value="copie_line_to_doc">Copier vers document existant</option>
                                            <option value="copie_line_to_newdoc">Copier vers nouveau document</option>
                                            <OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>
                                            <?php
if ($document->getID_TYPE_DOC () == $DEVIS_CLIENT_ID_TYPE_DOC) {
    ?>
                                            <option value="generer_commande_client">G&eacute;n&eacute;rer une commande</option>
                                            <option value="generer_devis_client">G&eacute;n&eacute;rer un nouveau devis</option>
                                            <option value="reset_pu_ht">R&eacute;g&eacute;n&eacute;rer le tarif par d&eacute;faut</option>
                                                <?php foreach ($tarifs_liste as $tar_list) {
                                                    ?>
                                            <option value="set_pu_ht_to_id_tarif_<?php echo ($tar_list->id_tarif);?>"><?php echo htmlentities($tar_list->lib_tarif);?></option>
                                                    <?php
    }?>
                                            <OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>
                                            <option value="maj_tva_liste">Modifier taux de T.V.A.</option>

    <?php
                                            }
                                            ?>
                                            <?php
if ($document->getID_TYPE_DOC () == $COMMANDE_CLIENT_ID_TYPE_DOC) {
                                                ?>
                                            <option value="generer_bl_client">G&eacute;n&eacute;rer une livraison</option>
    <?php
                                                if ($document->getId_etat_doc () == 7 || $document->getId_etat_doc () == 10) {
                                                    ?>
                                            <option value="generer_commande_client">Renouveler la commande</option>
        <?php
    }
                                                ?>
                                            <option value="reset_pu_ht">R&eacute;g&eacute;n&eacute;rer le tarif par d&eacute;faut</option>
                                                <?php foreach ($tarifs_liste as $tar_list) {
                                                    ?>
                                            <option value="set_pu_ht_to_id_tarif_<?php echo ($tar_list->id_tarif);?>"><?php echo htmlentities($tar_list->lib_tarif);?></option>
                                                    <?php
                                                }?>
                                            <OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>
                                            <option value="maj_tva_liste">Modifier taux de T.V.A.</option>

                                                <?php
                                            }
                                            ?>
<?php
                                            if ($document->getID_TYPE_DOC () == $LIVRAISON_CLIENT_ID_TYPE_DOC) {
                                                ?>
    <?php
                                                if ($document->getId_etat_doc () == 15) {
                                                    ?>
                                            <option value="generer_retour_client">Enregistrer un retour</option>
        <?php
    }
                                                ?>
                                            <option value="reset_pu_ht">R&eacute;g&eacute;n&eacute;rer le tarif par d&eacute;faut</option>
                                                <?php foreach ($tarifs_liste as $tar_list) {
                                                    ?>
                                            <option value="set_pu_ht_to_id_tarif_<?php echo ($tar_list->id_tarif);?>"><?php echo htmlentities($tar_list->lib_tarif);?></option>
                                                    <?php
    }?>
                                            <OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>
                                            <option value="maj_tva_liste">Modifier taux de T.V.A.</option>

    <?php
                                            }
                                            ?>
<?php
if ($document->getID_TYPE_DOC () == $FACTURE_CLIENT_ID_TYPE_DOC) {
                                                ?>
                                            <option value="generer_facture_avoir_client">G&eacute;n&eacute;rer une facture d'avoir</option>
                                            <option value="reset_pu_ht">R&eacute;g&eacute;n&eacute;rer le tarif par d&eacute;faut</option>
                                                <?php foreach ($tarifs_liste as $tar_list) {
                                                    ?>
                                            <option value="set_pu_ht_to_id_tarif_<?php echo ($tar_list->id_tarif);?>"><?php echo htmlentities($tar_list->lib_tarif);?></option>
                                                    <?php
                                                }?>
                                            <OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>
                                            <option value="maj_tva_liste">Modifier taux de T.V.A.</option>
    <?php
}
                                            ?>
                                            <?php
                                            //actions pour les documents fournisseurs

                                            if ($document->getID_TYPE_DOC () == $DEVIS_FOURNISSEUR_ID_TYPE_DOC) {
                                                ?>
                                            <option value="generer_commande_fournisseur">G&eacute;n&eacute;rer une commande</option>
                                            <option value="generer_devis_fournisseur">G&eacute;n&eacute;rer un nouveau devis</option>
                                            <OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>

                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($document->getID_TYPE_DOC () == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC) {
                                                ?>
                                            <option value="generer_br_fournisseur">G&eacute;n&eacute;rer un bon de r&eacute;ception</option>
                                            <option value="generer_commande_fournisseur">G&eacute;n&eacute;rer une commande</option>
                                            <OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>

    <?php
                                            }
                                            ?>
                                            <?php
                                            if ($document->getID_TYPE_DOC () == $LIVRAISON_FOURNISSEUR_ID_TYPE_DOC) {
                                                ?>
                                            <option value="generer_retour_fournisseur">Cr&eacute;er un retour</option>
                                            <option value="generer_fa_fournisseur" <?php //permission (6) Accès Consulter les prix d’achat
    if (!$_SESSION['user']->check_permission ("6")) {?>disabled="disabled"<?php } ?>>G&eacute;n&eacute;rer une facture</option>
                                            <OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>

                                                <?php
}
?>
<?php
if ($document->getID_TYPE_DOC () == $FACTURE_FOURNISSEUR_ID_TYPE_DOC) {
                                        ?>
                                            <OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>

    <?php
}
                                    ?>


                                        </select>
                                    </td>
<?php if ($document->getID_TYPE_DOC() == $COMMANDE_CLIENT_ID_TYPE_DOC) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php } ?>
<?php if ($document->getID_TYPE_DOC() == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php } ?>
<?php if ($AFF_REMISES) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php }  else {?>
                                    <td style="width:0px; text-align:center">
                                    </td>
    <?php } ?>
                                    <td style="width:230px; text-align:right;">
                                        <table style="width:230px; float:right;" class="">
                                            <tr id="ins_info" style="cursor:pointer">
                                                <td style="width:20px; text-align:center; font-weight:bolder;">
                                                    <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/line_info_add.gif" />
                                                </td>
                                                <td class="doc_link_standard" style="text-align:left"> Ins&eacute;rer une ligne d'information
                                                </td>
                                            </tr>
                                            <tr id="ins_ss_total" style="cursor:pointer">
                                                <td style="width:20px; text-align:center; font-weight:bolder;">
                                                    <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/line_subtoto_add.gif" />
                                                </td>
                                                <td class="doc_link_standard" style="text-align:left"> Ins&eacute;rer une ligne de sous-total
                                                </td>
                                            </tr>
<?php if(method_exists($document,'getId_livraison_mode')) { ?>
                                            <tr id="ins_livraison_mode" style="cursor:pointer">
                                                <td style="width:20px; text-align: center; font-weight:bolder;">
                                                    <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/line_calivraison_add.gif" />
                                                </td>
                                                <td class="doc_link_standard" style="text-align:left">Calculer les frais de transport
                                                </td>
                                            </tr>
    <?php } ?>
                                        </table>



                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="">&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:4px; line-height:4px;" colspan="4">
                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="document_box">
                                <tr>
                                    <td style="width:185px" rowspan="3">
                                        <div style="width:185px;">
                                            <table style="width:185px">
                                                <tr>
                                                    <td colspan="2" style="font-weight:bolder">
					T.V.A.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:right; width:95px">
                                                        <div id="distinct_intit_tva"<?php
if (!$ASSUJETTI_TVA && ($id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC || $id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC) && $document->getMontant_tva () == 0) {
                                                            echo 'style="display:none;" ';
}
?>></div>
                                                    </td>
                                                    <td style="text-align:right">
                                                        <div id="distinct_toto_tva" <?php
                                                             if (!$ASSUJETTI_TVA && ($id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC || $id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC) && $document->getMontant_tva () == 0) {
                                                                 echo 'style="display:none;" ';
                                                             }
?>></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bolder">
					Total T.V.A.
                                                    </td>
                                                    <td style="font-weight:bolder; text-align:right; border-top:1px solid #9dabb3;">
                                                        <div id="d_toto_tva" <?php
if (!$ASSUJETTI_TVA && ($id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC || $id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC) && $document->getMontant_tva () == 0) {
    echo 'style="display:none;" ';
}
?>></div>
<?php
if (!$ASSUJETTI_TVA && ($id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC || $id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC) && $document->getMontant_tva () == 0) {
    echo 'n/a';
}
                                    ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td style=" width:213px">
                                        <div style="width:213px;">
                                        </div>
                                    </td>
                                    <td style=" width:27px;">
                                        <div style="width:27px;">
                                        </div>
                                    </td>
                                    <td style="width:70px; text-align:center">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
<?php if ($document->getID_TYPE_DOC() == $COMMANDE_CLIENT_ID_TYPE_DOC) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php } ?>
<?php if ($document->getID_TYPE_DOC() == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php } ?>
<?php if ($AFF_REMISES) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php }  else {?>
                                    <td style="width:0px; text-align:center">
                                    </td>
    <?php } ?>
                                    <td style="width:230px" rowspan="3">
                                        <div style="width:230px;">
                                            <table style="width:230px">
                                                <tr>
                                                    <td style="width:140px; text-align:right; font-weight:bolder;">
                                                        <div style="width:140px;">
						Prix total H.T. :
                                                        </div>
                                                    </td>
                                                    <td style="width:90px; text-align:right;">
                                                        <div style="width:90px;">
                                                            <div id="pt_ht"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:140px; text-align:right; font-weight:bolder;">
                                                        <div style="width:140px;">
						T.V.A. :
                                                        </div>
                                                    </td>
                                                    <td style="width:90px; text-align:right;">
                                                        <div style="width:90px;">
                                                            <div id="toto_tva" <?php
if (!$ASSUJETTI_TVA && ($id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC || $id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC) && $document->getMontant_tva () == 0) {
    echo 'style="display:none;" ';
}
?>></div>
<?php
if (!$ASSUJETTI_TVA && ($id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC || $id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC) && $document->getMontant_tva () == 0) {
    echo 'n/a';
}
?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:140px; text-align:right; font-weight:bolder;">
                                                        <div style="width:140px;">
						Prix total T.T.C. :
                                                        </div>
                                                    </td>
                                                    <td style="width:90px; text-align:right; border-top:1px solid #9dabb3;">
                                                        <div style="width:90px;">
                                                            <div id="pt_ttc"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="">&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td style=" width:213px">
                                        <div style="width:213px;">
                                        </div>
                                    </td>
                                    <td style=" width:27px;">
                                        <div style="width:27px;">
                                        </div>
                                    </td>
                                    <td style="width:70px; text-align:center">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
<?php if ($document->getID_TYPE_DOC() == $COMMANDE_CLIENT_ID_TYPE_DOC) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php } ?>
<?php if ($document->getID_TYPE_DOC() == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php } ?>
<?php if ($AFF_REMISES) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php }  else {?>
                                    <td style="width:0px; text-align:center">
                                    </td>
    <?php } ?>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="">&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td style=" width:213px">
                                        <div style="width:213px;">
                                        </div>
                                    </td>
                                    <td style=" width:27px;">
                                        <div style="width:27px;">
                                        </div>
                                    </td>
                                    <td style="width:70px; text-align:center">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
<?php if ($document->getID_TYPE_DOC() == $COMMANDE_CLIENT_ID_TYPE_DOC) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php } ?>
<?php if ($document->getID_TYPE_DOC() == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php } ?>
<?php if ($AFF_REMISES) {?>
                                    <td style="width:70px; text-align:center;">
                                        <div style="width:70px;">
                                        </div>
                                    </td>
    <?php }  else {?>
                                    <td style="width:0px; text-align:center">
                                    </td>
    <?php } ?>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="width:25px; text-align:right;">
                                        <div style="width:25px;">
                                        </div>
                                    </td>
                                    <td style="">&nbsp;
                                    </td>
                                </tr>
                            </table>
                            Afficher  les prix <input name="prix_afficher" id="prix_afficher_ht" type="radio" value="HT" <?php if ($document->getApp_tarifs() == "HT" || $document->getApp_tarifs() == "") {
    echo 'checked="checked"';
}?> />HT <input name="prix_afficher" id="prix_afficher_ttc" type="radio" value="TTC" <?php if ($document->getApp_tarifs() == "TTC") {
    echo 'checked="checked"';
}?> />TTC<br />
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="rechercher_content" style="display:none;">
            <table cellpadding="0" cellspacing="0" border="0" style="width:100%">
                <tr>
                    <td class="articletview_corps">
                        <div style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:block" id="result_search_art">
                            <div id="recherche_article_simple" style="height:125px;" >
                                <form action="#" method="GET" id="form_recherche_s" name="form_recherche_s">
                                    <table style="width:97%">
                                        <tr class="smallheight">
                                            <td style="width:2%">&nbsp;</td>
                                            <td style="width:14%">&nbsp;</td>
                                            <td style="width:34%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                            <td style="width:3%">&nbsp;</td>
                                            <td style="width:20%">&nbsp;</td>
                                            <td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                            <td style="width:3%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>
                                                <span class="labelled_text">Cat&eacute;gorie:</span>
                                                <input type="hidden" name="id_tarif_s" id="id_tarif_s" value="<?php echo $_SESSION['magasin']->getId_tarif()?>" />
                                                <input type="hidden" name="id_stock_s" id="id_stock_s" value="<?php echo $_SESSION['magasin']->getId_stock()?>" />
                                                <input type="hidden" name="orderby_s" id="orderby_s" value="lib_article" />
                                                <input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
                                                <input type=hidden name="recherche" value="1" />			</td>
                                            <td>
                                                <select  name="ref_art_categ_s" id="ref_art_categ_s" class="classinput_xsize">
                                                    <option value="">Toutes</option>
<?php
                                                    $select_art_categ =	get_articles_categories("", array($LIVRAISON_MODE_ART_CATEG));
                                                    foreach ($select_art_categ  as $s_art_categ) {
                                                        ?>
                                                    <option value="<?php echo ($s_art_categ->ref_art_categ)?>">
    <?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
                                                    </option>
    <?php
}
?>
                                                </select>	</td>
                                            <td>&nbsp;</td>
                                            <td><span class="labelled_text">Rechercher:</span></td>
                                            <td><input type="text" name="lib_article_s" id="lib_article_s" value=""   class="classinput_xsize"/></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr <?php if(!$GESTION_CONSTRUCTEUR) {?>style="display:none"<?php } ?>>
                                            <td>&nbsp;</td>
                                            <td><span class="labelled_text">Constructeur:</span></td>
                                            <td>
                                                <select name="ref_constructeur_s" id="ref_constructeur_s" class="classinput_xsize" style="width:100%">
                                                    <option value="">Tous</option>
                                                    <option value="0">Sans constructeur</option>
<?php
                                                    foreach ($constructeurs_liste as $constructeur_liste) {
    ?>
                                                    <option value="<?php echo $constructeur_liste->ref_contact;?>"><?php echo $constructeur_liste->nom;?></option>
    <?php
}
?>
                                                </select>			</td>
                                            <td></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                            </td>
                                            <td></td>
                                            <td style="text-align:right">
                                                <input name="submit" type="image" onclick="$('page_to_show_s').value=1; $('recherche_auto').value='';" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
                                                <input type="image" name="annuler_recherche_s" id="annuler_recherche_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="5" style="text-align:center">
                                                <div id="block_recherche_spe_doc">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_recherche_article_typedoc_".$document->getID_TYPE_DOC().".inc.php" ?>
                                                </div>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
                                    <input type="hidden" name="recherche_auto" id="recherche_auto" value=""/>
                                </form>
                            </div>
                            <div id="resultat" style="height:125px; background-color:#FFFFFF"></div>
                        </div>
                    </td>
                    <td  style="width:250px;" class="infotable_bg" >
                        <table width="250px" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style=" height:1px; line-height:1px;">
                                    <table width="width:250px;" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="text-align:center; font-weight:bolder; width:250px;">
							Panier
                                            </td>
                                        </tr>
                                    </table>
                                    <span style=" height:1px; line-height:1px;">
                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="250px" height="1px"/>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><div id="panier_content" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; background-color:#c2cfd7" >&nbsp;</div></td>
                            </tr>
                            <tr>
                                <td><div style="font-weight:bolder; line-height:30px; text-align: right">TOTAL: <span id="panier_total">&nbsp;</span></div></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div id="reglements_content" class="articletview_corps" style="display:none; OVERFLOW-Y: auto; OVERFLOW-X: auto; " ><?php
if ($document->getACCEPT_REGMT() != 0) {
    $echeances = $document->getEcheancier();
    include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_reglements.inc.php" ;
}
?></div>


        <div id="note_content" style="display:none; height:50px; OVERFLOW-Y: auto; OVERFLOW-X: auto; " >
            <table cellpadding="0" cellspacing="0" border="0" style="width:100%">
                <tr class="articletview_corps">
                    <td style=" width:5%">
                    </td>
                    <td>
                        <div id="editeur_descript_long" >
                            <div id="editeur_bt_barre" class="barre_editeur">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="center">
                                            <select name="editeur_fontname" id="editeur_fontname" class="" >
                                                <option value="">Police</option>
                                                <option value="Arial, Helvetica, sans-serif">Arial</option>
                                                <option value="Times New Roman, Times, serif">Times New Roman</option>
                                                <option value="Courier New, Courier, mono">Courrier New</option>
                                                <option value="Verdana, sans-serif">Verdana</option>
                                            </select>		</td>
                                        <td align="center">
                                            <select name="editeur_size" id="editeur_size" class="" >
                                                <option value="">Taille</option>
                                                <option value="1">1 (8 pt)</option>
                                                <option value="2">2 (10 pt)</option>
                                                <option value="3">3 (12 pt)</option>
                                                <option value="4">4 (14 pt)</option>
                                                <option value="5">5 (18 pt)</option>
                                                <option value="6">6 (24 pt)</option>
                                                <option value="7">7 (36 pt)</option>
                                            </select>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_bold" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/bold.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_italic" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/italic.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_souligner" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/underline.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_align_left" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyleft.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_align_center" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifycenter.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_align_right" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyright.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_align_justify" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/justifyfull.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_outdent" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/outdent.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_indent" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/indent.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_insertorderedlist" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/insertorderedlist.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_insertunorderedlist" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/insertunorderedlist.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_forecolor" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/forecolor.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_hilitecolor" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/hilitecolor.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_link" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/createlink.gif" />			</a>		</td>
                                        <td align="center">
                                            <a href="#" id="editeur_unlink" class="bt_wysiwyg">
                                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/_small_wysiwyg/unlink.gif" />			</a>		</td>
                                    </tr>
                                </table>
                            </div>
                            <iframe name="description_html" id="description_html" class="classinput_xsize" style="height:150px; display:block; width:100%" frameborder="0"></iframe><br />
                            <iframe width="161" height="113" id="colorpalette" src="colors.php?proto=editeur&ifr=description_html" style="display:none; position:absolute; border:1px solid #000000; OVERFLOW: hidden;" frameborder="0" scrolling="no"></iframe><br />
                            <textarea name="description" rows="6" style="display:none;" id="description"><?php echo htmlentities($document->getDescription ());?></textarea>
                            <a href="#" id="doc_description"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" /></a>
                        </div>
                    </td>
                    <td style=" width:5%;">
                    </td>
                </tr>
            </table>
        </div>


<?php if ($id_type_doc <5) {
    if ($_SESSION['user']->check_permission ("6")) {?>
        <div id="marge_content" class="articletview_corps" style="display:none; " >
        </div>
        <?php }
    if ($_SESSION['user']->check_permission ("17")) {?>
        <div id="commercial_content" class="articletview_corps" style="display:none; " >
        </div>
        <?php
    }
} ?>

        <div id="options_avancees" class="articletview_corps" style="display:none; " >
        </div>

        <div id="pieces_content" class="articletview_corps" style="display:none; OVERFLOW-Y: auto; OVERFLOW-X: auto; " >
        </div>


        <div id="compta_content" class="articletview_corps" style="display:none; OVERFLOW-Y: auto; OVERFLOW-X: auto; " >
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:75%">
                        <div id="compta_facture">
                        </div>
                    </td>
                    <td style="width:25%">&nbsp;
                    </td>

                </tr>
            </table>
        </div>

    </div>
</div>


<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<script type="text/javascript">
    //centrage de l'editeur

    centrage_element("edition_reglement");
    centrage_element("edition_reglement_iframe");

    Event.observe(window, "resize", function(evt){
        centrage_element("edition_reglement_iframe");
        centrage_element("edition_reglement");
    });


    //initialisation de l'éditeur de texte
    Event.observe('editeur_bold', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("bold", null);});
    Event.observe('editeur_italic', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("italic", null);});
    Event.observe('editeur_souligner', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("underline", null);});
    Event.observe('editeur_align_left', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("justifyleft", null);});
    Event.observe('editeur_align_center', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("justifycenter", null);});
    Event.observe('editeur_align_right', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("justifyright", null);});
    Event.observe('editeur_align_justify', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("JustifyFull", null);});
    Event.observe('editeur_outdent', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("outdent", null);});
    Event.observe('editeur_indent', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("indent", null);});
    Event.observe('editeur_insertorderedlist', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("insertorderedlist", null);});
    Event.observe('editeur_insertunorderedlist', "click", function(evt){Event.stop(evt); editeur.HTML_exeCmd("insertunorderedlist", null);});
    Event.observe('editeur_fontname', "change", function(evt){ if ($("editeur_fontname").value!="") { editeur.HTML_exeCmd("FontName", $("editeur_fontname").value); $("editeur_fontname").selectedIndex=0; };});
    Event.observe('editeur_size', "change", function(evt){ if ($("editeur_size").value!="") { editeur.HTML_exeCmd("FontSize", $("editeur_size").value); $("editeur_size").selectedIndex=0;};});

    Event.observe('editeur_forecolor', "click", function(evt){Event.stop(evt); editeur.recordRange(2); parent.command = "forecolor"; $("colorpalette").style.left = getOffsetLeft($("editeur_forecolor"))+"px"; $("colorpalette").style.top = (getOffsetTop($("editeur_forecolor")))+"px"; $("colorpalette").style.display=""; });

    Event.observe('editeur_hilitecolor', "click", function(evt){Event.stop(evt); editeur.recordRange(2); editeur.HTML_surlignage(); $("colorpalette").style.left = getOffsetLeft($("editeur_hilitecolor"))+"px"; $("colorpalette").style.top = (getOffsetTop($("editeur_hilitecolor")))+"px"; $("colorpalette").style.display=""; });

    Event.observe('editeur_link', "click", function(evt){Event.stop(evt); var szURL = prompt("Entrez l'adresse url:", "http://");   if ((szURL != null) && (szURL != "")) { editeur.HTML_exeCmd("CreateLink", szURL)};});
    Event.observe('editeur_unlink', "click", function(evt){editeur.HTML_exeCmd("unlink", null);});


    //Event.observe(document, "mousedown", function(evt){editeur.dismisscolorpalette();});
    Event.observe($("description_html").contentWindow.document, "mousedown", function(evt){editeur.dismisscolorpalette();});
    //Event.observe(document, "keypress", function(evt){editeur.dismisscolorpalette();});
    Event.observe($("description_html").contentWindow.document, "keypress", function(evt){editeur.dismisscolorpalette();});


    Event.observe($("description_html").contentWindow.document, "mouseup", function(evt){editeur.HTML_getstyle_delay(200);});
    Event.observe($("description_html").contentWindow.document, "dblclick", function(evt){editeur.HTML_getstyle();});
    Event.observe($("description_html").contentWindow.document, "keyup", function(evt){editeur.HTML_getstyle_delay(400);});
    Event.observe($("description_html").contentWindow.document, "blur", function(evt){editeur.HTML_save();});
    Event.observe($("description_html"), "blur", function(evt){editeur.HTML_save();});
    //---------------------------------------------------------------
    //fin d'intialisation de l'éditeur
    //---------------------------------------------------------------


    //actions du menu
    Event.observe('doc_description', "click", function(evt){
        editeur.HTML_save();
        maj_doc_description('description');
        Event.stop(evt);
    });


    function setheight_document_edition(){
        set_tomax_height("document_content" , -32);
        set_tomax_height('result_search_art' , -40);
        set_tomax_height('rechercher_content' , -25);
        set_tomax_height('resultat' , -40);
        set_tomax_height('panier_content' , -62);
        set_tomax_height('reglements_content' , -32);
        //set_tomax_height('historique_content' , -32);
        set_tomax_height('note_content' , -32);
        set_tomax_height('description_html' , -112);
        set_tomax_height('editeur_descript_long' , -32);
        set_tomax_height('compta_content' , -32);
<?php if ($id_type_doc <5) {
    if ($_SESSION['user']->check_permission ("6")) {?>
                set_tomax_height('marge_content' , -32);
        <?php }
    if ($_SESSION['user']->check_permission ("17")) {?>
                set_tomax_height('commercial_content' , -32);
        <?php
    }
} ?>
            }
            Event.observe(window, "resize", setheight_document_edition, false);
            setheight_document_edition();

            //actions du menu
            Event.observe('menu_1', "click", function(evt){
                view_menu_1('document_content', 'menu_1', array_menu_e_document);
                $("tool_uitem_menu").hide();
                set_tomax_height('document_content' , -32);
                reglement_rapide = false;
                Event.stop(evt);
            });

            Event.observe('menu_2', "click", function(evt){
                view_menu_1('rechercher_content', 'menu_2', array_menu_e_document);
                $("tool_uitem_menu").hide();
                set_tomax_height('result_search_art' , -25);
                set_tomax_height('rechercher_content' , -40);
                set_tomax_height('resultat' , -40);
                from_rapide_search = "";
                set_tomax_height('panier_content' , -62);
                $('resultat').innerHTML = '';
                reglement_rapide = false;
                Event.stop(evt);
            });

            Event.observe('menu_4', "click", function(evt){
                view_menu_1('reglements_content', 'menu_4', array_menu_e_document);
                $("tool_uitem_menu").hide();
                $("docs_liste").innerHTML = "";
                document_calcul_tarif (1);
                if (montant_total_neg) {
                    page.traitecontent('liste_docs_nonreglees','documents_reglements_liste_docs_nonreglees.php?ref_doc=<?php echo $document->getRef_doc(); ?>&montant_neg=1','true','liste_docs_nonreglees');
                } else {
                    page.traitecontent('liste_docs_nonreglees','documents_reglements_liste_docs_nonreglees.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','liste_docs_nonreglees');
                }
                set_tomax_height('reglements_content' , -32);
                reglement_rapide = false;
                Event.stop(evt);
            });


            Event.observe('menu_5', "click", function(evt){
                view_menu_1('note_content', 'menu_5', array_menu_e_document);
                $("tool_uitem_menu").hide();
                set_tomax_height('note_content' , -32);
                set_tomax_height('description_html' , -112);
                set_tomax_height('editeur_descript_long' , -32);
                editeur.HTML_editor("description", "description_html", "editeur");
                reglement_rapide = false;
                Event.stop(evt);
            });

            Event.observe('menu_6', "click", function(evt){
                view_menu_1('options_avancees', 'menu_6', array_menu_e_document);
                $("tool_uitem_menu").hide();
                set_tomax_height('options_avancees' , -42);
                charger_contenu_options();
                reglement_rapide = false;
                Event.stop(evt);
            });


            Event.observe('menu_7', "click", function(evt){
                view_menu_1('compta_content', 'menu_7', array_menu_e_document);
                $("tool_uitem_menu").hide();
                set_tomax_height('compta_content' , -32);
                page.traitecontent('compta_doc','documents_compta.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','compta_facture');

                reglement_rapide = false;
                Event.stop(evt);
            });

<?php if ($id_type_doc <5) {
    if ($_SESSION['user']->check_permission ("6")) {?>
            Event.observe('menu_8', "click", function(evt){
                view_menu_1('marge_content', 'menu_8', array_menu_e_document);
                $("tool_uitem_menu").hide();
                set_tomax_height('marge_content' , -32);
                page.traitecontent('marge_content','documents_marges.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','marge_content');
                Event.stop(evt);
            });
        <?php }
    if ($_SESSION['user']->check_permission ("17")) {?>
    Event.observe('menu_8b', "click", function(evt){
        view_menu_1('commercial_content', 'menu_8b', array_menu_e_document);
        $("tool_uitem_menu").hide();
        set_tomax_height('commercial_content' , -32);
        page.traitecontent('commercial_content','documents_commercial.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','commercial_content');
        Event.stop(evt);
    });
        <?php }
} ?>

                    Event.observe('menu_9', "click", function(evt){
                        view_menu_1('pieces_content', 'menu_9', array_menu_e_document);
                        $("tool_uitem_menu").hide();
                        set_tomax_height('pieces_content' , -32);
                        page.traitecontent('pieces_ged','pieces_ged.php?ref_objet=<?php echo $document->getRef_doc(); ?>&type_objet=document','true','pieces_content');

                        reglement_rapide = false;
                        Event.stop(evt);
                    });

                    //remise à zero du formulaire
                    Event.observe('annuler_recherche_s', "click", function(evt){Event.stop(evt); reset_moteur_s ('form_recherche_s', 'ref_art_categ_s'); $("recherche_auto").value= ""	});

                    //lance la recherche
                    Event.observe('form_recherche_s', "submit", function(evt){page.document_recherche_article(); Event.stop(evt);});

                    wait_recherche_rapide = false;

                    last_ssearch_ref_doc_line = "";
                    //observer le retour chariot lors de la saisie du code barre pour lancer la recherche
                    function submit_simple_if_Key_RETURN (event) {

                        var key = event.which || event.keyCode;
                        switch (key) {
                            case Event.KEY_RETURN:
                                if (!wait_recherche_rapide) {
                                    wait_recherche_rapide = true;
                                    setTimeout("wait_recherche_rapide_allow()",500);
                                    //on check si on vient de la recherche rapide
                                    if (Event.element(event) != $('lib_article_s')) {
                                        //on test si c'est un multiplicateur de ref_doc_line
                                        if (check_multiply_ref_doc_line_qte()) {
                                            Event.stop(event);
                                            break;
                                        }
                                        // si c'est pas le cas on continu la procédure
                                    }

                                    page.document_recherche_article();
                                }
                                Event.stop(event);
                                break;
                        }
                    }

                    Event.observe('lib_article_s', "keypress", function(evt){submit_simple_if_Key_RETURN (evt);});

                    //recherche rapide
                    function init_start_recherche_r () {
                        $("recherche_auto").value= "0";
                        reset_moteur_s ('form_recherche_s', 'ref_art_categ_s');
                        $("message_r").innerHTML = "";
                        $("lib_article_s").value = $("lib_article_r").value ;

                    }
                    Event.observe('go_rechercher_rapide', "click", function(evt){Event.stop(evt);
                        if (!wait_recherche_rapide) {
                            if (! check_multiply_ref_doc_line_qte()) {
                                wait_recherche_rapide = true;
                                init_start_recherche_r ();
                                from_rapide_search = "1";
                                page.document_recherche_article();
                                setTimeout("wait_recherche_rapide_allow()",500);
                            }
                        }
                    });

                    Event.observe('lib_article_r', "keypress", function(evt){
                        init_start_recherche_r ();
                        from_rapide_search = "1";
                        submit_simple_if_Key_RETURN (evt);
                    });

                    //centrage du mini_moteur de recherche d'un contact

                    centrage_element("pop_up_mini_moteur");
                    centrage_element("pop_up_mini_moteur_iframe");
                    //centrage_element("main_doc_div");

                    Event.observe(window, "resize", function(evt){
                        centrage_element("pop_up_mini_moteur_iframe");
                        centrage_element("pop_up_mini_moteur");
                        //centrage_element("main_doc_div");
                    });

                    //centrage du mini_moteur de recherche d'un document
                    centrage_element("pop_up_mini_moteur_doc");
                    centrage_element("pop_up_mini_moteur_doc_iframe");

                    Event.observe(window, "resize", function(evt){
                        centrage_element("pop_up_mini_moteur_doc_iframe");
                        centrage_element("pop_up_mini_moteur_doc");
                    });

                    //centrage du mini_moteur
                    centrage_element("pop_up_mini_moteur_cata");
                    centrage_element("pop_up_mini_moteur_cata_iframe");

                    Event.observe(window, "resize", function(evt){
                        centrage_element("pop_up_mini_moteur_cata_iframe");
                        centrage_element("pop_up_mini_moteur_cata");
                    });

                    //centrage de la pop up de gestion des sn
                    centrage_element("pop_up_mini_article_sn");
                    centrage_element("pop_up_mini_article_sn_iframe");

                    Event.observe(window, "resize", function(evt){
                        centrage_element("pop_up_mini_article_sn_iframe");
                        centrage_element("pop_up_mini_article_sn");
                    });

                    //lancement de la fonction proto pour les actions sur la sélection
                    var action_select= new action_line_coche("action_select");

                    //lignes coche decoche inv_coche
                    Event.observe("all_coche", "click", function(evt){Event.stop(evt); all_line_coche ("coche");});
                    Event.observe("all_decoche", "click", function(evt){Event.stop(evt); all_line_coche ("decoche");});
                    Event.observe("all_inv_coche", "click", function(evt){Event.stop(evt); all_line_coche ("inv_coche");});

                    //action sur les lignes selectionnées
                    Event.observe("coche_action", "change", function(evt){action_select.action($("coche_action").value);});

                    start_date = new Date;

                    //insertion de ligne sstoto
                    Event.observe("ins_ss_total", "click", function(evt){
                        add_new_line_other_type ($("ref_doc").value, "sous-total");
                    }, false);

                    //insertion de ligne info
                    Event.observe("ins_info", "click", function(evt){
                        $("pop_up_lines_info_modeles_doc").style.display = "block";
                        //add_new_line_other_type ($("ref_doc").value, "information");
                    }, false);

<?php if (count($modeles_lignes) > 0) { ?>
    Event.observe("use_content_model", "click", function(evt){
        Event.stop(evt);
        $("pop_up_content_model").style.display = "block";
    }, false);
    <?php } ?>

<?php if(method_exists($document,'getId_livraison_mode')) { ?>
    //calcul frais de port
    Event.observe("ins_livraison_mode", "click", function(evt){
        page.traitecontent('documents_lines_livraison_modes','documents_lines_livraison_modes.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','pop_up_lines_livraison_modes_doc');
    }, false);
    <?php } ?>

    //observateur sur choix affichage tarif HT/TTC
    Event.observe("prix_afficher_ht", "click", function(evt){
        maj_app_tarifs ("HT");
        document_calcul_tarif ();
    }, false);
    Event.observe("prix_afficher_ttc", "click", function(evt){
        maj_app_tarifs ("TTC");
        document_calcul_tarif ();
    }, false);

    //calcul des tarifs affichés
    document_calcul_tarif (true);

    //focus sur recherche rapide
    $("lib_article_r").focus();

    //drag and drop
    element_moved = "";
    Position.includeScrollOffsets = true;
    Sortable.create("lignes",{dropOnEmpty:true, ghosting:false, scroll:"document_content", handle: "documents_li_handle", scrollSensitivity: 55, overlap: "vertical", onChange: function(element){element_moved=element;},  onUpdate: function(){doc_line_maj_ordre(element_moved)}});


    //remplissage si on fait un retour dans l'historique
    if (historique_request[3][0] == historique[0] && (default_show_id == "from_histo" || default_show_id == "to_histo")) {
        //history sur recherche simple
        if (historique_request[3][1] == "simple") {
            //$("lib_art_categ_s").innerHTML = historique_request[3]["lib_art_categ_s"];
            //$('ref_art_categ_s').value = 		historique_request[3]["ref_art_categ_s"];

            view_menu_1('rechercher_content', 'menu_2', array_menu_e_document);
            $('lib_article_s').value = 		historique_request[3]["lib_article_s"];

            preselect ((historique_request[3]["ref_art_categ_s"]), 'ref_art_categ_s') ;
            preselect ((historique_request[3]["ref_constructeur_s"]), 'ref_constructeur_s') ;

            $('recherche_auto').value = 	historique_request[3]["recherche_auto"];
            $('page_to_show_s').value = 	historique_request[3]["page_to_show_s"];
            $('orderby_s').value = 	historique_request[3]["orderby_s"];
            $('orderorder_s').value = 	historique_request[3]["orderorder_s"];
            set_tomax_height('result_search_art' , -25);
            set_tomax_height('rechercher_content' , -40);
            set_tomax_height('resultat' , -40);
            from_rapide_search = historique_request[3]["from_rapide_search"];
            set_tomax_height('panier_content' , -62);
            reglement_rapide = false;
            page.document_recherche_article();
        }

    }

<?php if ($id_type_doc <5 && isset($_REQUEST["marges"]) && 	$_SESSION['user']->check_permission ("6")) {?>
    view_menu_1('marge_content', 'menu_8', array_menu_e_document);
    $("tool_uitem_menu").hide();
    set_tomax_height('marge_content' , -32);
    page.traitecontent('marge_content','documents_marges.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','marge_content');
    <?php } ?>

<?php if ($id_type_doc <5 && isset($_REQUEST["commercial"]) && 	$_SESSION['user']->check_permission ("17")) {?>
    view_menu_1('commercial_content', 'menu_8b', array_menu_e_document);
    $("tool_uitem_menu").hide();
    set_tomax_height('commercial_content' , -32);
    page.traitecontent('commercial_content','documents_commercial.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','commercial_content');
    <?php } ?>

    //verification du depassement des stocks
    window.setTimeout("depasse_stock ()", 1000);
    //on masque le chargement
    H_loading();
    $("wait_calcul_content").style.display= "none";

</script>