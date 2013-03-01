<div class="headbar">
    <span id="link_close_pop_up_prelev" style="float:right" class="clic">
        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
    </span>
    <script type="text/javascript">
        Event.observe("link_close_pop_up_prelev", "click",  function(evt){Event.stop(evt); $("pop_up_prelev").hide();}, false);
    </script>
</div>
<div class="popup-content">

    <table width="100%" border="0" cellspacing="4" cellpadding="2">
        <tr>
            <td colspan="2" style="width:15%; font-style: italic; font-weight: bold;">Créer une autorisation de prélevement</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="width:15%">
                <span class="labelled">Nom du client:</span>
            </td>
            <td style="width:45%">
                <?php echo Helper::createInputAnnu("ref_client","",array("callback"=>"update_autorisations_compte","filtres"=>"lib=client")); ?>
                <script type="text/javascript">
                    $("ref_client").value = "<?php echo $current->ref_contact; ?>";
                    $("ref_client_nom_c").innerHTML ="<?php echo $current->nom; ?>";
                </script>
                <input type="hidden" id="id_prelevement" name="id_prelevement" value="<?php echo $_REQUEST["id_prelev"] ?>" />
            </td>
            <td>&nbsp</td>
            <td>&nbsp</td>
        </tr>
        <tr>
            <td>
                <span class="labelled">Compte bancaire:</span>
            </td>
            <td colspan="2">
                <select name="id_compte_src" id="id_compte_src" style="font-size: 85%;" class="classinput_xsize">

                </select>
            </td>
            <td><span class="clic" id="add_compte_src">+</span></td>
        </tr>
        <tr id="field_compte_src_add" style="display:none;">
            <td colspan="4" style="padding: 5px 0px; border-style: solid; border-width: 1px; ">
                <table>
                    <tr class="smallheight">
                        <td style="width: 5%;"><img src="../profil_collab/themes/collab_fr/images/blank.gif" id="imgsizeform" width="100%" height="1"></td>
                        <td style="width: 20%;"><img src="../profil_collab/themes/collab_fr/images/blank.gif" id="imgsizeform" width="100%" height="1"></td>
                        <td style="width: 20%;"><img src="../profil_collab/themes/collab_fr/images/blank.gif" id="imgsizeform" width="100%" height="1"></td>
                        <td style="width: 20%;"><img src="../profil_collab/themes/collab_fr/images/blank.gif" id="imgsizeform" width="100%" height="1"></td>
                        <td><img src="../profil_collab/themes/collab_fr/images/blank.gif" id="imgsizeform" width="100%" height="1"></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;" class="labelled">Libellé:
                        </td>
                        <td>
                            <input name="lib_compte" id="lib_compte" value="" class="classinput_xsize" type="text">
                        </td>
                        <td style="text-align: right;" class="labelled">Nom de la Banque:
                        </td>
                        <td>
                            <?php echo Helper::createInputAnnu("ref_banque"); ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;" class="labelled">RIB:
                        </td>
                        <td colspan="3">
                            <table style="width: 100%;" class="contactview_corps">
                                <tr>
                                    <td style="width: 25%; text-align: center;"><span style="font-size: 9px;">Code banque</span><br>
                                        <input name="code_banque" id="code_banque" value="" class="classinput_nsize" size="5" maxlength="5" type="text">
                                    </td>
                                    <td style="width: 25%; text-align: center;"><span style="font-size: 9px;">Code guichet</span><br>
                                        <input name="code_guichet" id="code_guichet" value="" class="classinput_nsize" size="5" maxlength="5" type="text">
                                    </td>
                                    <td style="width: 25%; text-align: center;"><span style="font-size: 9px;">Numéro de compte</span><br>
                                        <input name="numero_compte" id="numero_compte" value="" class="classinput_nsize" size="11" maxlength="11" type="text">
                                    </td>
                                    <td style="width: 25%; text-align: center;"><span style="font-size: 9px;">Clef rib</span><br>
                                        <input name="cle_rib" id="cle_rib" value="" class="classinput_nsize" size="2" maxlength="2" type="text">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;" class="labelled">IBAN :
                        </td>
                        <td>
                            <input name="iban" id="iban" value="" class="classinput_nsize" size="28" type="text">
                        </td>
                        <td style="text-align: right;" class="labelled">SWIFT/BIC:
                        </td>
                        <td>
                            <input name="swift" id="swift" value="" class="classinput_nsize" size="28" type="text">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" style="color: red; font-weight: bold;">
                            <div id="message_err_1"></div>
                            <div id="message_err_2"></div>
                        </td>
                        <td style="text-align: right;">
                            <input name="submit_compte" id="submit_compte" src="../profil_collab/themes/collab_fr/images/bt-ajouter.gif" type="image">
                        </td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <span class="labelled">Pièce jointe :</span>
            </td>
            <td>
                <select name="id_pj_prelev" id="id_pj_prelev" class="classinput_xsize">
                    <option value="0">Aucune...</option>
                </select>
            </td>
            <td><span class="clic" id="add_pj_prelev">+</span></td>
            <td>&nbsp</td>
        </tr>
        <tr>
            <td>
                <span class="labelled">Destination du prélevement:</span>
            </td>
            <td>
                <select name="id_compte_dest" id="id_compte_dest" class="classinput_xsize">
                    <?php foreach($comptes_entreprise as $compte) { ?>
                    <option value="<?php echo $compte->id_compte_bancaire; ?>"><?php echo $compte->lib_compte; ?> : <?php echo $compte->iban; ?></option>
                        <?php } ?>
                </select>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <input name="submit_a" id="submit_a" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <script type="text/javascript">
        Event.observe('add_compte_src', "click", function(evt){
            if($("ref_client").value != "")
                $("field_compte_src_add").style.display = "";
            Event.stop(evt);
        });
        Event.observe('add_pj_prelev', "click", function(evt){
            if($("ref_client").value != ""){
                page.traitecontent("pop_up_piecej_add_content_up", "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>page_piece_ged_form.inc.php", true, "pop_up_piecej_add_content_up")
                //$("ref_objet").value = $("ref_client").value;
                $("pop_up_piecej_add").style.display = "block";
            }
            Event.stop(evt);
        });
        Event.observe('submit_a', "click", function(evt){
            if($("ref_client").value != ""){
                compta_prelevement_edit();
                $("pop_up_prelev").hide();
            }
            Event.stop(evt);
        });

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
        Event.observe('submit_compte', "click", function(evt){
            compta_compte_add();
            $("field_compte_src_add").hide();
            update_autorisations_compte('ref_client','ref_client_nom_c', $("ref_client").value, $("ref_client_nom_c").firstChild.nodeValue);
            Event.stop(evt);
            H_loading();
        });
        
        update_autorisations_compte('ref_client','ref_client_nom_c', $("ref_client").value, $("ref_client_nom_c").firstChild.nodeValue);
        preselect('<?php echo $current->id_compte_bancaire_src ?>', 'id_compte_src');
        preselect('<?php echo $current->id_piece_jointe_autorisation ?>', 'id_pj_prelev');
        preselect('<?php echo $current->id_compte_bancaire_dest ?>', 'id_compte_dest');
        H_loading();
    </script>
</div>