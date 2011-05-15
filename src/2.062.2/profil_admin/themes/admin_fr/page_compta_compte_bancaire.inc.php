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
<script type="text/javascript">
    tableau_smenu[0] = Array("smenu_comptabilite", "smenu_comptabilite.php" ,"true" ,"sub_content", "Comptabilité");
    tableau_smenu[1] = Array('compta_compte_bancaire','compta_compte_bancaire.php','true','sub_content', "Comptes bancaires de l'entreprise");
    update_menu_arbo();
</script>
<div class="emarge">

    <p class="titre">Comptes bancaires de l'entreprise</p>
    <div style="height:50px">
        <?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
        <table class="minimizetable">
            <tr>
                <td class="contactview_corps">
                    <div id="cat_client" style="padding-left:10px; padding-right:10px">
                        <p>Activer la gestion des traites et prélevements<input type="checkbox" value="1" id="compta_gest_prelevements" name="compta_gest_prelevements" <?php if($COMPTA_GEST_PRELEVEMENTS) echo "checked=\"checked\""; ?> /></p>
                        <div style="" id="show_new_compte">
                            <p>Ajouter un compte bancaire </p>


                            <div class="caract_table">

                                <table>
                                    <tr>
                                        <td style="width:95%">
                                            <form action="compta_compte_bancaire_add.php" method="post" id="compta_compte_bancaire_add" name="compta_compte_bancaire_add" target="formFrame" >
                                                <table>
                                                    <tr class="smallheight">
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:right">Libell&eacute;:
                                                        </td>
                                                        <td>
                                                            <input name="lib_compte" id="lib_compte" type="text" value=""  class="classinput_xsize"  />
                                                        </td>
                                                        <td style="text-align:right">Nom de la Banque:
                                                        </td>
                                                        <td>
                                                            <input name="ref_contact" id="ref_contact" type="hidden" value="<?php echo $REF_CONTACT_ENTREPRISE;?>" />
                                                            <input name="ref_banque" id="ref_banque" type="hidden" value="" />
                                                            <table cellpadding="0" cellspacing="0" border="0" style=" width:100%">
                                                                <tr>
                                                                    <td>
                                                                        <input name="nom_banque" id="nom_banque" type="text" value=""  class="classinput_xsize" readonly=""/>
                                                                    </td>
                                                                    <td style="width:20px">
                                                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right; cursor:pointer" id="ref_banque_select_img">
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <script type="text/javascript">
                                                                //effet de survol sur le faux select
                                                                Event.observe('ref_banque_select_img', 'mouseover',  function(){$("ref_banque_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
                                                                Event.observe('ref_banque_select_img', 'mousedown',  function(){$("ref_banque_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
                                                                Event.observe('ref_banque_select_img', 'mouseup',  function(){$("ref_banque_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);

                                                                Event.observe('ref_banque_select_img', 'mouseout',  function(){$("ref_banque_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
                                                                Event.observe('ref_banque_select_img', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_compte_b_set_contact", "\'ref_banque\', \'nom_banque\' "); preselect ('<?php echo $BANQUE_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
                                                                Event.observe('compta_gest_prelevements', 'click',  function(){
                                                                    activ_gest_prelevements($("compta_gest_prelevements").checked);
                                                                }, false);

                                                            </script>
                                                        </td>
                                                        <td style="text-align:center">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:right">Rib:
                                                        </td>
                                                        <td colspan="3">
                                                            <table style="width:100%" class="contactview_corps">
                                                                <tr>
                                                                    <td style="width:25%; text-align:center"><span style="font-size:9px">Code banque</span><br />
                                                                        <input name="code_banque" id="code_banque" type="text" value=""  class="classinput_nsize" size="5" maxlength="5"/>
                                                                    </td>
                                                                    <td style="width:25%; text-align:center"><span style="font-size:9px">Code guichet</span><br />
                                                                        <input name="code_guichet" id="code_guichet" type="text" value=""  class="classinput_nsize" size="5" maxlength="5"/>
                                                                    </td>
                                                                    <td style="width:25%; text-align:center"><span style="font-size:9px">Num&eacute;ro de compte</span><br />
                                                                        <input name="numero_compte" id="numero_compte" type="text" value=""  class="classinput_nsize" size="11" maxlength="11"/>
                                                                    </td>
                                                                    <td style="width:25%; text-align:center"><span style="font-size:9px">Clef rib</span><br />
                                                                        <input name="cle_rib" id="cle_rib" type="text" value=""  class="classinput_nsize" size="2" maxlength="2" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:right">iban :
                                                        </td>
                                                        <td>
                                                            <input name="iban" id="iban" type="text" value=""  class="classinput_nsize" size="28" />
                                                        </td>
                                                        <td style="text-align:right">swift:
                                                        </td>
                                                        <td>
                                                            <input name="swift" id="swift" type="text" value=""  class="classinput_nsize" size="28" />
                                                        </td>
                                                        <td style="text-align:center">
                                                            <input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </table>
                            </div><br />
                            <br />
                            <?php
                            if ($comptes_bancaires) {
                                ?>
                            <p>Comptes bancaires </p>
                                <?php

                                $fleches_ascenseur=0;
                                foreach ($comptes_bancaires as $compte_bancaire) {
                                    //if (isset($_REQUEST["id_compte_bancaire"]) && $compte_bancaire->id_compte_bancaire != $_REQUEST["id_compte_bancaire"]) {continue;}
                                    ?>
                            <div class="caract_table">
                                <table>
                                    <tr>
                                        <td style="width:95%">
                                            <form action="compta_compte_bancaire_mod.php" method="post" id="compta_compte_bancaire_mod_<?php echo $compte_bancaire->id_compte_bancaire;?>" name="compta_compte_bancaire_mod_<?php echo $compte_bancaire->id_compte_bancaire;?>" target="formFrame" >
                                                <table>
                                                    <tr class="smallheight">
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                        <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:right">Libell&eacute;:
                                                        </td>
                                                        <td>
                                                            <input name="lib_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="lib_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->lib_compte);?>"  class="classinput_xsize"  />
                                                        </td>
                                                        <td style="text-align:right">Nom de la Banque:
                                                        </td>
                                                        <td>
                                                            <input name="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="hidden" value="<?php echo htmlentities($compte_bancaire->ref_contact);?>" />
                                                            <input name="ref_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="ref_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="hidden" value="<?php echo htmlentities($compte_bancaire->ref_banque);?>" />
                                                            <input name="id_compte_bancaire" id="id_compte_bancaire" type="hidden" value="<?php echo $compte_bancaire->id_compte_bancaire;?>" />
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <input name="nom_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="nom_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->nom_banque);?>"  class="classinput_xsize" readonly=""/>
                                                                    </td>
                                                                    <td style="width:20px">
                                                                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>">
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <script type="text/javascript">
                                                                //effet de survol sur le faux select
                                                                Event.observe('ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>', 'mouseover',  function(){$("ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
                                                                Event.observe('ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>', 'mousedown',  function(){$("ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
                                                                Event.observe('ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>', 'mouseup',  function(){$("ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);

                                                                Event.observe('ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>', 'mouseout',  function(){$("ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
                                                                Event.observe('ref_banque_select_img_<?php echo $compte_bancaire->id_compte_bancaire;?>', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_compte_b_set_contact", "\'ref_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>\', \'nom_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>\' "); preselect ('<?php echo $BANQUE_ID_PROFIL; ?>', 'id_profil_m');}, false);
                                                            </script>
                                                        </td>
                                                        <td style="text-align:center">Actif:
                                                            <input type="checkbox" id="actif_<?php echo $compte_bancaire->id_compte_bancaire;?>" name="actif_<?php echo $compte_bancaire->id_compte_bancaire;?>" value="1" <?php if ($compte_bancaire->actif) {
            echo 'checked="checked"';
        };?>/>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:right">Rib:
                                                        </td>
                                                        <td colspan="3">
                                                            <table style="width:100%" class="contactview_corps">
                                                                <tr>
                                                                    <td style="width:25%; text-align:center"><span style="font-size:9px">Code banque</span><br />
                                                                        <input name="code_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="code_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->code_banque);?>"  class="classinput_nsize" size="5" maxlength="5"/>
                                                                    </td>
                                                                    <td style="width:25%; text-align:center"><span style="font-size:9px">Code guichet</span><br />
                                                                        <input name="code_guichet_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="code_guichet_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->code_guichet);?>"  class="classinput_nsize" size="5" maxlength="5"/>
                                                                    </td>
                                                                    <td style="width:25%; text-align:center"><span style="font-size:9px">Num&eacute;ro de compte</span><br />
                                                                        <input name="numero_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="numero_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->numero_compte);?>"  class="classinput_nsize" size="11" maxlength="11"/>
                                                                    </td>
                                                                    <td style="width:25%; text-align:center"><span style="font-size:9px">Clef rib</span><br />
                                                                        <input name="cle_rib_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="cle_rib_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->cle_rib);?>"  class="classinput_nsize" size="2" maxlength="2" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:right">iban :
                                                        </td>
                                                        <td>
                                                            <input name="iban_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="iban_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->iban);?>"  class="classinput_nsize" size="28" />
                                                        </td>
                                                        <td style="text-align:right">swift:
                                                        </td>
                                                        <td>
                                                            <input name="swift_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="swift_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->swift);?>"  class="classinput_nsize" size="28" />
                                                        </td>
                                                        <td style="text-align:center">
                                                            <input name="modifier_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="modifier_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                        <td style="width:55px; text-align:center">
                                            <form method="post" action="compta_compte_bancaire_sup.php" id="compta_compte_bancaire_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>" name="compta_compte_bancaire_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>" target="formFrame">
                                                <input name="id_compte_bancaire" id="id_compte_bancaire" type="hidden" value="<?php echo $compte_bancaire->id_compte_bancaire; ?>" />
                                            </form>
                                            <a href="#" id="link_compta_compte_bancaire_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>" style="display:none"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
                                            <script type="text/javascript">
                                                Event.observe("link_compta_compte_bancaire_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('compta_compte_bancaire_sup', 'compta_compte_bancaire_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>');}, false);
                                            </script>

                                        </td><td style="width:55px; text-align:center">

                                            <table cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <div id="up_arrow_<?php echo $compte_bancaire->id_compte_bancaire; ?>">
                                                                    <?php
        if ($fleches_ascenseur!=0) {
            ?>
                                                            <form action="compta_compte_bancaire_ordre.php" method="post" id="compta_compte_bancaire_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" name="compta_compte_bancaire_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" target="formFrame">
                                                                <input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_bancaire->ordre)-1?>" />
                                                                <input name="id_compte_bancaire" id="id_compte_bancaire" type="hidden" value="<?php echo $compte_bancaire->id_compte_bancaire; ?>" />
                                                                <input name="modifier_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" id="modifier_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
                                                            </form>
                                                                        <?php
        } else {
                                                                        ?>
                                                            <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>
                                                                        <?php
        }
        ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div id="down_arrow_<?php echo $compte_bancaire->id_compte_bancaire; ?>">
                                                                    <?php
        if ($fleches_ascenseur!=count($comptes_bancaires)-1) {
            ?>
                                                            <form action="compta_compte_bancaire_ordre.php" method="post" id="compta_compte_bancaire_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" name="compta_compte_bancaire_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" target="formFrame">
                                                                <input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_bancaire->ordre)+1?>" />
                                                                <input name="id_compte_bancaire" id="id_compte_bancaire" type="hidden" value="<?php echo $compte_bancaire->id_compte_bancaire; ?>" />
                                                                <input name="modifier_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" id="modifier_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
                                                            </form>
                                                                        <?php
        } else {
                                                                        ?>
                                                            <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>
                                                                        <?php
        }
        ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                                    <?php
                                    $fleches_ascenseur++;
                                }
                                ?>
                                <?php
}
?>

                        </div>
                </td>
            </tr>
        </table>

        <SCRIPT type="text/javascript">

<?php
foreach ($comptes_bancaires as $compte_bancaire) {
    //if (isset($_REQUEST["id_compte_bancaire"]) && $compte_bancaire->id_compte_bancaire != $_REQUEST["id_compte_bancaire"]) {continue;}
    ?>
                    new Form.EventObserver('compta_compte_bancaire_mod_<?php echo $compte_bancaire->id_compte_bancaire;?>', function(){formChanged();});

                    Event.observe($("actif_<?php echo $compte_bancaire->id_compte_bancaire;?>"), "click", function(evt){
                        if ($("actif_<?php echo $compte_bancaire->id_compte_bancaire;?>").checked) {
                            set_active_compte("<?php echo $compte_bancaire->id_compte_bancaire;?>");
                        } else {
                            set_desactive_compte("<?php echo $compte_bancaire->id_compte_bancaire;?>");
                        }
                    });

                    //changement automatique de champs pour le rib
                    Event.observe($("code_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>"), "keypress", function(evt){
                        if ($("code_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>").value.length >= 4) {
                            $("code_guichet_<?php echo $compte_bancaire->id_compte_bancaire;?>").focus()
                        }
                    });
                    Event.observe($("code_guichet_<?php echo $compte_bancaire->id_compte_bancaire;?>"), "keypress", function(evt){
                        if ($("code_guichet_<?php echo $compte_bancaire->id_compte_bancaire;?>").value.length >= 4) {
                            $("numero_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>").focus()
                        }
                    });
                    Event.observe($("numero_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>"), "keypress", function(evt){
                        if ($("numero_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>").value.length >= 10) {
                            $("cle_rib_<?php echo $compte_bancaire->id_compte_bancaire;?>").focus()
                        }
                    });
                    Event.observe($("cle_rib_<?php echo $compte_bancaire->id_compte_bancaire;?>"), "keypress", function(evt){
                        if ($("cle_rib_<?php echo $compte_bancaire->id_compte_bancaire;?>").value.length >= 1) {
                            $("iban_<?php echo $compte_bancaire->id_compte_bancaire;?>").focus()
                        }
                    });
    <?php
}
?>


            new Form.EventObserver('compta_compte_bancaire_add', function(){formChanged();});


            //changement automatique de champs pour le rib
            Event.observe($("code_banque"), "keypress", function(evt){
                if ($("code_banque").value.length >= 5) {
                    $("code_guichet").focus()
                }
            });
            Event.observe($("code_guichet"), "keypress", function(evt){
                if ($("code_guichet").value.length >= 5) {
                    $("numero_compte").focus()
                }
            });
            Event.observe($("numero_compte"), "keypress", function(evt){
                if ($("numero_compte").value.length >= 11) {
                    $("cle_rib").focus()
                }
            });
            Event.observe($("cle_rib"), "keypress", function(evt){
                if ($("cle_rib").value.length >= 2) {
                    $("iban").focus()
                }
            });

            //centrage du mini_moteur

            centrage_element("pop_up_mini_moteur");
            centrage_element("pop_up_mini_moteur_iframe");

            Event.observe(window, "resize", function(evt){
                centrage_element("pop_up_mini_moteur_iframe");
                centrage_element("pop_up_mini_moteur");
            });


            //on masque le chargement
            H_loading();
        </SCRIPT>
    </div>
</div>