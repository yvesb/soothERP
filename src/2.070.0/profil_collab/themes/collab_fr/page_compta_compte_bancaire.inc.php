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
<div class="emarge">

    <p class="titre">Edition des comptes bancaires</p>
    <div style="height:50px">
        <div style="text-align:right">
            <span id="retour_gestion" style="cursor:pointer; text-decoration:underline">Retour à la gestion des comptes</span>
            <script type="text/javascript">
                Event.observe('retour_gestion', 'click',  function(evt){
                    Event.stop(evt);
                    page.verify('compte_bancaire_gestion','compta_compte_bancaire_gestion.php','true','sub_content');
                }, false);
            </script>
        </div>
        <br />
        <br />
        <table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
            <tr>
                <td rowspan="2" style="width:120px; height:50px">
                    <div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_banque.jpg" />				</div>
                    <span style="width:35px">
                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			</td>
                <td colspan="2" style="width:90%">
                    <table class="minimizetable">
                        <tr>
                            <td >
                                <div id="cat_client" style="padding-left:10px; padding-right:10px">

                                    <?php
                                    if ($comptes_bancaires) {
                                        ?>
                                    <p>Comptes bancaires </p>
                                        <?php

                                        $fleches_ascenseur=0;
                                        foreach ($comptes_bancaires as $compte_bancaire) {
                                            if (isset($_REQUEST["id_compte_bancaire"]) && $compte_bancaire->id_compte_bancaire != $_REQUEST["id_compte_bancaire"]) {
                                                continue;
        }
        ?>
                                    <div >
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
                                                                    <input type="text" disabled="disabled" value="<?php echo htmlentities($compte_bancaire->lib_compte);?>"  class="classinput_xsize"  />
                                                                    <input name="lib_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="lib_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="hidden"  value="<?php echo htmlentities($compte_bancaire->lib_compte);?>"  class="classinput_xsize"  />
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
                                                                                <input name="nom_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>" id="nom_banque_<?php echo $compte_bancaire->id_compte_bancaire;?>" type="text" value="<?php echo htmlentities($compte_bancaire->nom_banque);?>"  class="classinput_xsize" readonly="readonly"/>
                                                                            </td>
                                                                        </tr>
                                                                    </table>


                                                                </td>
                                                                <td style="text-align:center"><?php if ($compte_bancaire->actif) {
            echo 'Compte actif';
        } else {
            echo "Compte inactif";
        }?>
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
                </td>
            </tr>
        </table>

        <SCRIPT type="text/javascript">


<?php
foreach ($comptes_bancaires as $compte_bancaire) {
    if (isset($_REQUEST["id_compte_bancaire"]) && $compte_bancaire->id_compte_bancaire != $_REQUEST["id_compte_bancaire"]) {
        continue;
    }
    ?>
                    new Form.EventObserver('compta_compte_bancaire_mod_<?php echo $compte_bancaire->id_compte_bancaire;?>', function(){formChanged();});


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


            //on masque le chargement
            H_loading();
        </SCRIPT>
    </div>
</div>