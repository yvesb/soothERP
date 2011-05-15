<table width="100%" border="0" cellspacing="4" cellpadding="2">
   <br />
   <span style="font-style:italic;font-weight:bold;">Autorisations de prélevements :</span>
    <tr>
        <td colspan="5" style=" border-bottom:1px solid #999999">&nbsp;</td>
    </tr>
    <tr>
        <td style="width:25%; font-weight:bolder; text-align:left">Nom</td>
        <td style="width:20%; font-weight:bolder; text-align:left; padding-right:25px">Banque</td>
        <td style="font-weight:bolder; text-align:left">IBAN</td>
        <td style="width:30px; font-weight:bolder; text-align:left" colspan="3">Actions</td>
    </tr>
    <tr>
        <td colspan="5" style=" border-top:1px solid #999999"><input type="hidden" id="aut_to_del" value=""/> &nbsp;</td>
    </tr>
    <?php if(empty($results)){
        ?> <tr>
            <td>
                Aucune autorisation de prélevement.
            </td>
        </tr><?php
        } else{ foreach($results as $resultat) { ?>
    <tr>
        <td>
                <?php echo $resultat->nom ?>
        </td>
        <td>
                <?php echo $resultat->nom_banque ?>
        </td>
        <td>
                <?php echo $resultat->iban ?>
        </td>
        <td>
            <span class="green_underlined" id="drc_<?php echo $resultat->id_compte_bancaire_autorisation; ?>">Editer</span> - <span class="green_underlined" id="supp_<?php echo $resultat->id_compte_bancaire_autorisation; ?>">Supprimer</span>
            <!--| Supprimer-->
            <script type="text/javascript">
                Event.observe('drc_<?php echo $resultat->id_compte_bancaire_autorisation; ?>', "click", function(evt){
                    $("pop_up_prelev").style.display = "block";
                    page.traitecontent('pop_up_prelev','compta_gest_prelevements_edit.php?id_prelev=<?php echo $resultat->id_compte_bancaire_autorisation; ?>','true','pop_up_prelev');
                    Event.stop(evt);
                });
                Event.observe('supp_<?php echo $resultat->id_compte_bancaire_autorisation; ?>', "click", function(evt){
                   $('aut_to_del').value = <?php echo $resultat->id_compte_bancaire_autorisation; ?>;
                   compta_prelevement_del();
                   parent.window.location.reload();
                    Event.stop(evt);
                });
                
            </script>
        </td>
    </tr>
        <?php }
        } ?>
    <br />
    <br />

    <span style="font-style:italic;font-weight:bold;">Autorisations de traites :</span>
    <tr>
        <td colspan="5" style=" border-bottom:1px solid #999999">&nbsp;</td>
    </tr>
    <tr>
        <td style="width:25%; font-weight:bolder; text-align:left">Nom</td>
        <td style="width:20%; font-weight:bolder; text-align:left; padding-right:25px">Banque</td>
        <td style="font-weight:bolder; text-align:left">IBAN</td>
        <td style="width:30px; font-weight:bolder; text-align:left" colspan="3">Actions</td>
    </tr>
    <tr>
        <td colspan="5" style=" border-top:1px solid #999999">&nbsp;</td>
    </tr>
    <?php if(empty($results_traitena)){
        ?> <tr>
            <td>
                Aucune autorisation de traite.
            </td>
        </tr><?php
        } else{
        foreach($results_traitena as $resultat_traitena) { ?>
    <tr>
        <td>
                <?php echo $resultat_traitena->nom ?>
        </td>
        <td>
                <?php echo $resultat_traitena->nom_banque ?>
        </td>
        <td>
                <?php echo $resultat_traitena->iban ?>
        </td>
        <td>
            <span class="green_underlined" id="drca_<?php echo $resultat_traitena->id_compte_bancaire_autorisation; ?>">Editer</span> - <span class="green_underlined" id="suppt_<?php echo $resultat_traitena->id_compte_bancaire_autorisation; ?>">Supprimer</span>
            <!--| Supprimer-->
            <script type="text/javascript">
                Event.observe('drca_<?php echo $resultat_traitena->id_compte_bancaire_autorisation; ?>', "click", function(evt){
                    $("pop_up_traitena").style.display = "block";
                    page.traitecontent('pop_up_traitena','compta_gest_traitena_edit.php?id_prelev=<?php echo $resultat_traitena->id_compte_bancaire_autorisation; ?>','true','pop_up_traitena');
                    Event.stop(evt);
                });
                Event.observe('suppt_<?php echo $resultat_traitena->id_compte_bancaire_autorisation; ?>', "click", function(evt){
                   $('aut_to_del').value = <?php echo $resultat_traitena->id_compte_bancaire_autorisation; ?>;
                   compta_prelevement_del();
                   parent.window.location.reload();
                    Event.stop(evt);
                });
            </script>
        </td>
    </tr>
    <?php }
        }?>
</table>

<script type="text/javascript">
    //compta_prelevements_result();


    //centrage de la pop up comm
    centrage_element("pop_up_prelev");
    centrage_element("pop_up_mini_moteur");
    centrage_element("pop_up_mini_moteur_iframe");
    centrage_element("pop_up_piecej_add");

    Event.observe(window, "resize", function(evt){
        centrage_element("pop_up_prelev");
        centrage_element("pop_up_mini_moteur_iframe");
        centrage_element("pop_up_mini_moteur");
        centrage_element("pop_up_piecej_add");
    });

centrage_element("pop_up_traitena");
    centrage_element("pop_up_mini_moteur");
    centrage_element("pop_up_mini_moteur_iframe");
    centrage_element("pop_up_piecej_add");

    Event.observe(window, "resize", function(evt){
        centrage_element("pop_up_traitena");
        centrage_element("pop_up_mini_moteur_iframe");
        centrage_element("pop_up_mini_moteur");
        centrage_element("pop_up_piecej_add");
    });

    //on masque le chargement
    H_loading();
</script>