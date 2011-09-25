<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

if(!isset($profils_mini)){
    $profils_mini = getAll_profils();
} else {    //Cas des pages anciennes...
    $profils_obj = $profils_mini;
    $profils_mini = array();
    foreach($profils_obj as $profil){
        $new_prof = new stdClass();
        $new_prof->id_profil = $profil->getId_profil();
        $new_prof->actif = $profil->getActif();
        $new_prof->lib_profil = $profil->getLib_profil();
        $profils_mini[] = $new_prof;
    }
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


// Formulaire de recherche
?>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_mini_moteur_iframe" class="mini_moteur_iframe"></iframe>
<div id="pop_up_mini_moteur" class="mini_moteur">
    <div class="headbar">
        <span class="clic" id="close_mini_recherche_annu" style="float:right">
            <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
        </span>
    </div>
    <div class="popup_content">
        <div id="recherche_contact" class="corps_mini_moteur">
            <div id="recherche_contact_simple" class="menu_link_affichage">
                <div style="font-weight:bolder">Recherche d'un contact </div>
                <form action="#" id="form_recherche_mini" name="form_recherche_mini" method="GET">
                    <table style="width:97%">
                        <tr class="smallheight">
                            <td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                            <td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                            <td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                            <td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                            <td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type=hidden name="recherche" value="1" />
                                <input type="hidden" name="orderby_m" id="orderby_m" value="nom" />
                                <input type="hidden" name="orderorder_m" id="orderorder_m" value="ASC" />
                                <input type="hidden" name="fonction_retour_m" id="fonction_retour_m" value="" />
                                <input type="hidden" name="param_retour_m" id="param_retour_m" value="" />
                                <span class="labelled">Nom&nbsp;ou&nbsp;D&eacute;nomination:</span></td>
                            <td><input type="text" name="nom_m" id="nom_m" value=""   class="classinput_xsize"/></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><span class="labelled">Profil : </span></td>
                            <td><select name="id_profil_m" id="id_profil_m"  class="classinput_xsize">
                                    <?php /*if(count($profils_mini) > 1 || count($profils_mini)==0){ ?>
                                <option value="0"> -- Tous </option>
                                <?php }
                                $separateur = 1;
                                for ($i=0; $i<count($profils_mini); $i++) {
                                    if ($profils_mini[$i]->getActif() == 2 && $separateur && $i != 0) {
                                        $separateur = 0;
                                        ?>
                                        <optgroup disabled="disabled" label="__________________________________" ></optgroup>
                                        <?php
                                    }
                                    ?>
                                    <option value="<?php echo $profils_mini[$i]->getId_profil()?>" ><?php echo $profils_mini[$i]->getLib_profil()?></option>
                                    <?php
                                }*/
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    profils = new Array();
                                    profils[0] = new Array();
                                    profils[0]["actif"] = 1;
                                    profils[0]["id"] = "0";
                                    profils[0]["lib"] = " -- Tous ";
                                    <?php foreach($profils_mini as $num=>$profil) { ?>
                                        profils[<?php echo $num+1 ?>] = new Array();
                                        profils[<?php echo $num+1 ?>]["actif"] = <?php echo $profil->actif ?>;
                                        profils[<?php echo $num+1 ?>]["id"] = "<?php echo $profil->id_profil ?>";
                                        profils[<?php echo $num+1 ?>]["lib"] = "<?php echo $profil->lib_profil ?>";
                                    <?php } ?>
                                </script>
                            </td>
                            <td>&nbsp;</td>
                            <td style="text-align:right"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>&nbsp;</td>
                            <td>
                                <input name="submit_m" type="image" onclick="$('page_to_show_m').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" />
                            </td>
                            <td>
                            <!--<input type="image" name="res_s" id="res_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>-->
                                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_new_contact.gif" id="create_new_contact" style="cursor:pointer; float:right" />
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    <input type="hidden" name="page_to_show_m" id="page_to_show_m" value="1"/>
                </form>
            </div>

        </div>

        <div id="resultat_contact_mini" style="overflow:auto; height:266px"></div>
    </div>

    <script type="text/javascript">
        Event.observe("close_mini_recherche_annu", "click",  function(evt){Event.stop(evt);close_mini_moteur_contacts();}, false);

        //creation d'un nouveau contact (transfère la ref_doc si on est dans un document
        Event.observe("create_new_contact", "click",  function(evt){
            Event.stop(evt);
<?php
if (isset($document)) {
    ?>
                        return_to_page = "ref_doc=<?php echo $document->getRef_doc();?>";
    <?php
}
?>
<?php
if (isset($comptes_cbs)) {
    ?>
                        return_to_page = "compte_cbs=1";
    <?php
}
?>

                    page.verify('annuaire_nouvelle_fiche','#annuaire_nouvelle_fiche.php','true','_self');
                }, false);

                //lance la recherche
                Event.observe('form_recherche_mini', "submit", function(evt){page.annuaire_recherche_mini();
                    Event.stop(evt);});

                //on masque le chargement
                H_loading();
    </script>
</div>