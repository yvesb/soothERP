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
</script>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<div class="emarge">

    <p class="titre">Gestion comptes bancaire de <?php echo htmlentities($contact->getNom())?></p>
    <div style="height:50px">
        <table class="minimizetable">
            <tr>
                <td class="contactview_corps">
                    <div id="cat_client" style="padding-left:10px; padding-right:10px">
                        <p>Ajouter un compte bancaire </p>
                        <div class="caract_table">

                            <table>
                                <tr>
                                    <td style="width:95%">
                                        <form action="compta_compte_bancaire_contact_add.php" method="post" id="compta_compte_bancaire_contact_add" name="compta_compte_bancaire_contact_add" target="formFrame" >
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
                                                        <input name="ref_contact" id="ref_contact" type="hidden" value="<?php echo $contact->getRef_contact();?>" />
                                                        <input name="lib_compte" id="lib_compte" type="text" value=""  class="classinput_xsize"  />
                                                    </td>
                                                    <td style="text-align:right">Nom de la Banque:
                                                    </td>
                                                    <td>
                                                        <?php echo Helper::createInputAnnu("ref_banque"); ?>
                                                    </td>
                                                    <td>
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
                                                    <td style="color:red; font-weight: bold;">
                                                        <div id="message_err_1"></div>
                                                        <div id="message_err_2"></div>
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
                                                <script type="text/javascript">
                                                    Event.observe('code_banque', 'focus',  function(evt){Event.stop(evt); focused = 'code_banque';}, false);
                                                    Event.observe('code_guichet', 'focus',  function(evt){Event.stop(evt); focused = 'code_guichet';}, false);
                                                    Event.observe('numero_compte', 'focus',  function(evt){Event.stop(evt); focused = 'numero_compte';}, false);
                                                    Event.observe('cle_rib', 'focus',  function(evt){Event.stop(evt); focused = 'cle_rib';}, false);

                                                    Event.observe('code_banque', 'keyup',  function(evt){Event.stop(evt); updateRIB();}, false);
                                                    Event.observe('code_guichet', 'keyup',  function(evt){Event.stop(evt); updateRIB();}, false);
                                                    Event.observe('numero_compte', 'keyup',  function(evt){Event.stop(evt); updateRIB();}, false);
                                                    Event.observe('cle_rib', 'keyup',  function(evt){Event.stop(evt); updateIBAN();}, false);
                                                    Event.observe('iban', 'keyup',  function(evt){Event.stop(evt); verifErreurs();}, false);
                                                    Event.observe('swift', 'keyup',  function(evt){Event.stop(evt); verifErreurs();}, false);
                                                </script>
                                            </table>
                                        </form>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php
                        if ($comptes_bancaires) {
                            ?>
                        <p>Comptes bancaires </p>
                            <?php

                            $fleches_ascenseur=0;
                            foreach ($comptes_bancaires as $compte_bancaire) {
                                ?>
                        <div class="caract_table">
                            <table>
                                <tr>
                                    <td style="width:95%">
                                        <form action="compta_compte_bancaire_contact_mod.php?id_compte_bancaire=<?php echo $compte_bancaire->id_compte_bancaire;?>" method="post" id="compta_compte_bancaire_contact_mod_<?php echo $compte_bancaire->id_compte_bancaire;?>" name="compta_compte_bancaire_contact_mod_<?php echo $compte_bancaire->id_compte_bancaire;?>" target="formFrame" >
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
                                                        <input name="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="hidden" value="<?php echo htmlentities($compte_bancaire->ref_contact);?>" />
                                                        <input name="lib_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="lib_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->lib_compte);?>"  class="classinput_xsize"  />
                                                    </td>
                                                    <td style="text-align:right">Nom de la Banque:
                                                    </td>
                                                    <td>
                                                        <?php echo Helper::createInputAnnu("ref_banque_".$compte_bancaire->id_compte_bancaire); ?>
                                                        <script type="text/javascript">
                                                            $("ref_banque_<?php echo $compte_bancaire->id_compte_bancaire ?>").value = "<?php echo $compte_bancaire->ref_banque ?>";
                                                            $("ref_banque_<?php echo $compte_bancaire->id_compte_bancaire ?>_nom_c").innerHTML = "<?php echo $compte_bancaire->nom_banque; ?>";
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
                                        <form method="post" action="compta_compte_bancaire_contact_sup.php" id="compta_compte_bancaire_contact_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>" name="compta_compte_bancaire_contact_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>" target="formFrame">
                                            <input name="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="hidden" value="<?php echo htmlentities($compte_bancaire->ref_contact);?>" />
                                            <input name="id_compte_bancaire" id="id_compte_bancaire" type="hidden" value="<?php echo $compte_bancaire->id_compte_bancaire; ?>" />
                                        </form>
                                        <a href="#" id="link_compta_compte_bancaire_contact_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
                                        <script type="text/javascript">
                                            Event.observe("link_compta_compte_bancaire_contact_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('compta_compte_bancaire_sup', 'compta_compte_bancaire_contact_sup_<?php echo $compte_bancaire->id_compte_bancaire; ?>');}, false);
                                        </script>
                                        <table cellspacing="0">
                                            <tr>
                                                <td>
                                                    <div id="up_arrow_<?php echo $compte_bancaire->id_compte_bancaire; ?>">
                                                                <?php
                                                                if ($fleches_ascenseur!=0) {
                                                                    ?>
                                                        <form action="compta_compte_bancaire_contact_ordre.php" method="post" id="compta_compte_bancaire_contact_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" name="compta_compte_bancaire_contact_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" target="formFrame">
                                                            <input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_bancaire->ordre)-1?>" />
                                                            <input name="id_compte_bancaire" id="id_compte_bancaire" type="hidden" value="<?php echo $compte_bancaire->id_compte_bancaire; ?>" />
                                                            <input name="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="hidden" value="<?php echo htmlentities($compte_bancaire->ref_contact);?>" />
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
                                                        <form action="compta_compte_bancaire_contact_ordre.php" method="post" id="compta_compte_bancaire_contact_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" name="compta_compte_bancaire_contact_ordre_<?php echo $compte_bancaire->id_compte_bancaire; ?>" target="formFrame">
                                                            <input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_bancaire->ordre)+1?>" />
                                                            <input name="id_compte_bancaire" id="id_compte_bancaire" type="hidden" value="<?php echo $compte_bancaire->id_compte_bancaire; ?>" />
                                                            <input name="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="ref_contact_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="hidden" value="<?php echo htmlentities($compte_bancaire->ref_contact);?>" />
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
            new Form.EventObserver('compta_compte_bancaire_contact_add', function(){formChanged();});

<?php
foreach ($comptes_bancaires as $compte_bancaire) {
    ?>
        new Form.EventObserver('compta_compte_bancaire_contact_mod_<?php echo $compte_bancaire->id_compte_bancaire;?>', function(){formChanged();});

        Event.observe($("actif_<?php echo $compte_bancaire->id_compte_bancaire;?>"), "click", function(evt){
            if ($("actif_<?php echo $compte_bancaire->id_compte_bancaire;?>").checked) {
                set_active_compte("<?php echo $compte_bancaire->id_compte_bancaire;?>");
            } else {
                set_desactive_compte("<?php echo $compte_bancaire->id_compte_bancaire;?>");
            }
        });


    <?php
}
?>

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