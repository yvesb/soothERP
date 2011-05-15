<table width="100%" border="0" cellspacing="4" cellpadding="2">
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
    <?php foreach($results as $resultat) { ?>
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
            <span class="green_underlined" id="drc_<?php echo $resultat->id_compte_bancaire_autorisation; ?>">Editer</span>
            <!--| Supprimer-->
            <script type="text/javascript">
                Event.observe('drc_<?php echo $resultat->id_compte_bancaire_autorisation; ?>', "click", function(evt){
                    $("pop_up_traites").style.display = "block";
                    page.traitecontent('pop_up_traites','compta_gest_traites_edit.php?id_traites=<?php echo $resultat->id_compte_bancaire_autorisation; ?>','true','pop_up_traites');
                    Event.stop(evt);
                });

                
            </script>
        </td>
    </tr>
        <?php } ?>
</table>