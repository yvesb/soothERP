<?php

// *************************************************************************************************************
// AFFICHAGE DU CHOIX DES CAISSES
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
var descriptions = new Array();
</script>
<div class="emarge">
    <table width="100%" border="0" cellspacing="4" cellpadding="2">
        <tr>
            <td style="width:25%; font-weight:bolder; text-align:left"></td>
            <td style="width:20%; font-weight:bolder; text-align:center;"></td>
            <td style="width:20%; font-weight:bolder; text-align:center"></td>
            <td style="width:20%; font-weight:bolder; text-align:center"></td>
            <td style="font-weight:bolder; text-align:center"></td>
        </tr>
        <?php
        foreach ($lesbonus as $bonus) {
            ?>
        <tr>
            <td colspan="5" style=" border-bottom:1px solid #999999">&nbsp;</td>
        </tr>
        <tr id="commission_bonus_<?php echo $bonus->id_commission_bonus; ?>">
            <td style="font-weight:bolder; text-align:left">
                    <?php echo ($bonus->nom); ?><br />
            </td>
            <td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px">
                    <?php echo $bonus->date_bonus;?>
            </td>
            <td id="lib_bonus_<?php echo $bonus->id_commission_bonus;?>" style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px">
                    <?php echo $bonus->lib_bonus;?>
            </td>
            <td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px">
                    <?php echo number_format($bonus->montant, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
            </td>
            <td style="width:15%; text-align:center">
                <span class="green_underlined" id="drc_<?php echo $bonus->ref_commercial; ?>">Editer</span>
                <script type="text/javascript">
                    Event.observe('drc_<?php echo $bonus->ref_commercial; ?>', "click", function(evt){
                        $("pop_up_bonus").style.display = "block";
                        page.traitecontent('pop_up_bonus','compta_bonus_commerciaux_edit.php?id_bonus=<?php echo $bonus->id_commission_bonus; ?>','true','pop_up_bonus');
                        Event.stop(evt);
                    });

                    Event.observe('lib_bonus_<?php echo $bonus->id_commission_bonus;?>', "mouseover", function(evt){
                        $("div_desc_bonus").style.display = "block";
                        $("div_desc_bonus").innerHTML = urldecode("<?php echo urlencode($bonus->id_commission_bonus);?>");
                    });
                </script>
            </td>
        </tr>
            <?php
        }
        ?>
    </table>
</div>


<SCRIPT type="text/javascript">

    //on masque le chargement
    H_loading();
</SCRIPT>