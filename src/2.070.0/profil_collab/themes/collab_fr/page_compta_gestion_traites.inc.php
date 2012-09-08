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

    <div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Gestion des traites acceptées
    </div>
    <div class="emarge" style="text-align:right" >
        <div>
            <table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
                <tr>
                    <td rowspan="2" style="width:120px; height:50px">
                        <div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
                            <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_carte.gif" />				</div>
                        <span style="width:35px">
                            <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			</td>
                    <td colspan="2" style="width:90%">
                        <br />
                        <br />
                        <br />

                        <div style="width:90%; height:50px; padding:25px">
                            <table width="100%" border="0" cellspacing="4" cellpadding="2">
                                <tr>
                                    <td style="width:25%; font-weight:bolder; text-align:left">Compte bancaire</td>
                                    <td style="width:20%; font-weight:bolder; text-align:right; padding-right:25px">Montant à prélever</td>
                                    <td style="width:20%; font-weight:bolder; text-align:center">Dernière traite</td>
                                    <td style="font-weight:bolder; text-align:center" colspan="3">Accès Direct</td>
                                </tr>
                                <?php
                                $solde_total = 0;
                                foreach ($infos_prelev as $prelev) {
                                    ?>
                                <tr id="choix_compte_bancaire_<?php echo $prelev->id_compte_bancaire ?>">
                                    <td style="font-weight:bolder; text-align:left"><?php echo htmlentities($prelev->lib_compte); ?></td>
                                    <td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px"><?php echo number_format($prelev->a_payer, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></td>
                                    <td style="font-weight:bolder; text-align:center; color:#999999;"><?php echo $laste_date!="" ? date_Us_to_Fr($laste_date):"N/A";?></td>
                                    <td style="width:15%; text-align:center"><span class="green_underlined" id="tableau_compte_<?php echo $prelev->id_compte_bancaire;?>" >Tableau de Bord</span></td>
                                    <td style="width:5%; text-align:center; color:#97bf0d">-</td>
                                    <td style="width:15%; text-align:center"><span class="green_underlined" id="prelev_<?php echo $prelev->id_compte_bancaire; ?>">Traite</span>
                                    </td>
                                </tr>
                                <SCRIPT type="text/javascript">
                                    Event.observe('tableau_compte_<?php echo $prelev->id_compte_bancaire;?>', 'click',  function(evt){
                                    Event.stop(evt);
                                    page.verify('compta_gestion_traites_tb','compta_gestion_traites_tb.php?id_compte_bancaire=<?php echo $prelev->id_compte_bancaire;?>','true','sub_content');
                                    }, false);
                                    Event.observe('prelev_<?php echo $prelev->id_compte_bancaire;?>', 'click',  function(evt){
                                    Event.stop(evt);
                                    page.verify('compta_gestion_traites_prelevements','compta_gestion_traites_prelevements.php?id_compte_bancaire=<?php echo $prelev->id_compte_bancaire;?>','true','sub_content');
                                    }, false);
                                </SCRIPT>
                                <?php
                                $solde_total += $prelev->a_payer;
                                }
                                ?>
                                <tr>
                                    <td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bolder; text-align:left">TOTAL</td>
                                    <td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px"><?php echo number_format($solde_total, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></td>
                                    <td style="font-weight:bolder; text-align:center; color:#999999;"></td>
                                    <td class="green_underlined" style="width:100%; text-align:center" id="compte_client_traites">G&eacute;rer les autorisations de traites accept&eacute;es<br /><br /></td>

                                </tr>
                            </table>
                            <br/>
                                                                            <?php
                                                if (count($infos_echeances_sans_aut) > 0){
                                                ?>
                                                <font color="#cc0000">Attention ! Il vous manque des autorisations de traite</font>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
                                                            <td><div class="bold_caisse" style="font-size:14px">Traites sans autorisation (<span id="detail_prelevements_sans_aut_links"> <span id = "detail_prelevements_sans_aut_show_link" class="green_underlined" style="font-size:12px"> Voir le d&eacute;tail </span><span id = "detail_prelevements_sans_aut_hide_link" class="green_underlined" style="font-size:12px;display:none;">Masquer le d&eacute;tail</span></span> )</div></td>
                                                            <td><div class="bold_caisse" style="font-size:14px"><?php echo number_format($prelev_sans_auth_montant, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></div></td>
                                                            <td style="width:20%"><div class="bold_caisse" style="font-size:16px">&nbsp;</div></td>
                                                            <script type="text/javascript">
                                                            Event.observe("detail_prelevements_sans_aut_links", "click",  function(evt){
                                                                   Event.stop(evt);
                                                                   $("detail_prelevements_sans_aut_show_link").toggle();
                                                                   $("detail_prelevements_sans_aut_hide_link").toggle();
                                                                   $("detail_prelevements_sans_aut").toggle();
                                                            }, false);
                                                            </script>
							</tr>
                                                        <tr id = "detail_prelevements_sans_aut" style="display:none;">
                                                            <td colspan="2">
                                                                <table>
                                                                    <?php
                                                                    foreach ($infos_echeances_sans_aut as $prelev){
                                                                    ?>
                                                                    <tr><td style="font-style:italic"><?php echo contact::_getNom($prelev->ref_contact); ?></td><td style="font-style:italic"><?php echo number_format($prelev->montant, $TARIFS_NB_DECIMALES, ".", "")." ".$MONNAIE[1];; ?></td><td style="font-style:italic">le <?php echo date_Us_to_Fr($prelev->date) ?></td><td style="font-style:italic"><?php echo $prelev->ref_doc ?></td><td style="font-style:italic">(<?php echo $prelev->type_reglement ?>)</td></tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </td>
                                                            <td style="width:20%"><div class="bold_caisse" style="font-size:16px">&nbsp;</div></td>
							</tr>
                                                </table>
                                                <?php
                                                }
                                                ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<br/>

</div>


<SCRIPT type="text/javascript">

		Event.observe('compte_client_traites', "click", function(evt){
            page.verify('compta_gest_traites','compta_gest_traites.php','true','sub_content');
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