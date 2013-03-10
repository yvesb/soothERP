<?php

// *************************************************************************************************************
// AFFICHAGE DU CHOIX DES TERMINAUX DE PAIEMENT ELECTRONIQUE et VIRTUELS
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<div class="emarge"><br />

 <div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Gestion des traites et prélèvements</div>
    <div class="emarge" style="text-align:right" >
        <div>
            <table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
                <tr>
                    <td rowspan="2" style="width:120px; height:120px">
                        <div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
                            <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_carte.gif" />				</div>
                        <span style="width:35px">
                            <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			</td>
                    <td colspan="2" style="width:100%">
                        <br />
                        <br />
                        <br />

                        <div style="width:90%; height:50px; padding:25px">
                            <table width="100%" border="0" cellspacing="4" cellpadding="2">
                                <tr>
                                    <td style="width:20%; font-weight:bolder; text-align:left">Compte bancaire</td>
                                    <td style="width:20%; font-weight:bolder; text-align:right; padding-right:25px">N° de compte</td>
                                    <td colspan="2" style="width:20%; font-weight:bolder; text-align:center;">Prélèvements</td>
                                    <td colspan="2" style="width:20%; font-weight:bolder; text-align:center;">Traites</td>
                                    <td style="width:20%;font-weight:bolder; text-align:center" colspan="3">Accès Direct</td>
                                </tr>
                                <tr>
                                    <td style="width:20%; font-weight:bolder; text-align:left">&nbsp;</td>
                                    <td style="width:20%; font-weight:bolder; text-align:right; padding-right:25px">&nbsp;</td>
                                    <td style="width:10%; font-weight:bolder; text-align:center;">A faire</td>
                                    <td style="width:10%; font-weight:bolder; text-align:center;">Prévus</td>
                                    <td style="width:15%; font-weight:bolder; text-align:center;">A Présenter</td>
                                    <td style="width:10%; font-weight:bolder; text-align:center;">Prévues</td>
                                    <td style="width:15%;font-weight:bolder; text-align:center" colspan="3">&nbsp;</td>
                                </tr>
                                 <tr>
                                    <td style="width:20%; font-weight:bolder; text-align:left">&nbsp;</td>
                                    <td style="width:20%; font-weight:bolder; text-align:right; padding-right:25px">&nbsp</td>
                                    <td style="width:10%; font-weight:bolder; text-align:center">&nbsp;</td>
                                    <td style="width:10%; font-weight:bolder; text-align:center">&nbsp;</td>
                                    <td style="width:30%;font-weight:bolder; text-align:center" colspan="3">&nbsp;</td>
                                </tr>
                                <?php
                                $solde_total = 0;
                                foreach ($comptes_bancaires as $compte_bancaire) {
                                    ?>
                                <tr id="choix_compte_bancaire_<?php echo $compte_bancaire->id_compte_bancaire ?>">
                                    <td style="font-weight:bolder; text-align:left"><?php echo htmlentities($compte_bancaire->lib_compte); ?></td>
                                    <td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px"><?php echo $compte_bancaire->numero_compte; ?></td>
                                    <td style="font-weight:bolder; text-align:center; color:#999999;"><?php
                                    $mnt = 0;
                                    foreach ($infos_prelev as $prelev){
                                        if ($prelev->id_compte_bancaire == $compte_bancaire->id_compte_bancaire){
                                       $mnt += $prelev->a_payer;
                                        }
                                    }
                                    echo price_format($mnt).$MONNAIE[1];?> </td> <td style="font-weight:bolder; text-align:center; color:#999999;"> <?php
                                    $mnt = 0;
                                    foreach ($infos_echeances_prog as $prelev_prog){
                                        if ($prelev_prog->id_compte_bancaire == $compte_bancaire->id_compte_bancaire){
                                       $mnt += $prelev_prog->montant;
                                        }
                                    } echo price_format($mnt).$MONNAIE[1]."&nbsp;"; ?> &nbsp;</td>
                                    <td style="font-weight:bolder; text-align:center; color:#999999;"><?php
                                    $mnt = 0;
                                    foreach ($infos_traitena as $traitena){
                                        if ($traitena->id_compte_bancaire == $compte_bancaire->id_compte_bancaire){
                                       $mnt += $traitena->a_payer;
                                        }
                                    }
                                    echo price_format($mnt).$MONNAIE[1]; ?></td> <td style="font-weight:bolder; text-align:center; color:#999999;"> <?php
                                    $mnt = 0;
                                    foreach ($infos_traitena_prog as $traitena_prog){
                                        if ($traitena_prog->id_compte_bancaire == $compte_bancaire->id_compte_bancaire){
                                       $mnt += $traitena_prog->montant;
                                        }
                                    } echo price_format($mnt).$MONNAIE[1]; ?> &nbsp;</td>
                                    <td style="width:15%; text-align:right"><span class="green_underlined" id="tableau_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" >Tableau de Bord</span></td>
                                    <td style="width:5%; text-align:center; color:#97bf0d">&nbsp</td>
                                    <td style="width:15%; text-align:center">&nbsp;
                                    </td>
                                </tr>
                                <SCRIPT type="text/javascript">
                                    Event.observe('tableau_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>', 'click',  function(evt){
                                    Event.stop(evt);
                                    page.verify('compta_gestion_traites_prelev_tb','compta_gestion_traites_prelev_tb.php?id_compte_bancaire=<?php echo $compte_bancaire->id_compte_bancaire;?>','true','sub_content');
                                    }, false);
                                </SCRIPT>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bolder; text-align:left;">Sans autorisation :</td>
                                    <td style="font-weight:bolder; text-align:right; color:#999999;">&nbsp;</td>
                                    <td style="font-weight:bolder; text-align:center; color:#999999;"><?php
                                    $mnt = 0;
                                    foreach ($infos_echeances_sans_aut as $prelev_sans_aut){
                                        $mnt += $prelev_sans_aut->montant;
                                    }
                                    echo price_format($mnt).$MONNAIE[1]; ?> </td><td style="font-weight:bolder; text-align:center; color:#999999;"> <?php
                                    $mnt = 0;
                                    foreach ($infos_echeances_prog_sans_aut as $prelev_prog_sans_aut){
                                        $mnt += $prelev_prog_sans_aut->montant;
                                    }
                                    echo price_format($mnt).$MONNAIE[1];
                                    ?>
                                    </td>
                                    <td style="font-weight:bolder; text-align:center; color:#999999;"><?php
                                    $mnt = 0;
                                    foreach ($infos_traitena_sans_aut as $traitena_sans_aut){
                                        $mnt += $traitena_sans_aut->montant;
                                    }
                                    echo price_format($mnt).$MONNAIE[1]; ?> </td> <td style="font-weight:bolder; text-align:center; color:#999999;"> <?php
                                    $mnt = 0;
                                    foreach ($infos_traitena_prog_sans_aut as $traitena_prog_sans_aut){
                                        $mnt += $traitena_prog_sans_aut->montant;
                                    }
                                    echo price_format($mnt).$MONNAIE[1];
                                    ?></td>
                                    <td class="green_underlined" style="width:100%; text-align:center" id="compte_client_prelevements">G&eacute;rer les autorisations<br /><br /></td>

                                </tr>
                            </table>
                            <br/>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<br/>

</div>


<SCRIPT type="text/javascript">

Event.observe('compte_client_prelevements', "click", function(evt){
            page.verify('compta_gest_prelevements','compta_gest_prelevements.php','true','sub_content');
            Event.stop(evt);
        });

    function setheight_choix_tpe(){
        set_tomax_height("corps_choix_tpes" , -32);
    }
    Event.observe(window, "resize", setheight_choix_tpe, false);
    setheight_choix_tpe();

    //on masque le chargement
    H_loading();
</SCRIPT>