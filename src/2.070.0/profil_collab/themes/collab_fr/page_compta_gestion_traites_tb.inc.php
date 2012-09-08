<?php

// *************************************************************************************************************
// Tableau de BORD compte bancaire
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

	
</script>
<div class="emarge"><br />

<div class="titre" style=" padding-left:140px;"><?php echo htmlentities($compte_bancaire->getLib_compte()); ?> -  Tableau de bord
</div>
<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_compte_bancaire">

	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
		<tr>
			<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_banque.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:60%; background-color:#FFFFFF" >
			<br />
			<br />
			<br />

			<div>
			<table border="0" cellspacing="0" cellpadding="0" style="width:100%; height:100%">
				<tr>
					<td></td>
					<td>
					<div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
                                                            <td><div class="bold_caisse" style="font-size:16px">Traites acceptées &agrave; effectuer (<span id="detail_prelevements_links"> <span id = "detail_prelevements_show_link" class="green_underlined" style="font-size:12px"> Voir le d&eacute;tail </span><span id = "detail_prelevements_hide_link" class="green_underlined" style="font-size:12px;display:none;">Masquer le d&eacute;tail</span></span> )</div></td>
                                                            <td><div class="bold_caisse" style="font-size:16px"><?php echo number_format($prelev_a_effectuer, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></div></td>
                                                            <td style="width:20%"><div class="bold_caisse" style="font-size:16px">&nbsp;</div></td>
                                                            <script type="text/javascript">
                                                            Event.observe("detail_prelevements_links", "click",  function(evt){
                                                                   Event.stop(evt);
                                                                   $("detail_prelevements_show_link").toggle();
                                                                   $("detail_prelevements_hide_link").toggle();
                                                                   $("detail_prelevements").toggle();
                                                            }, false);
                                                            </script>
							</tr>
                                                        <tr id = "detail_prelevements" style="display:none;">
                                                            <td colspan="2">
                                                                <table>
                                                                    <?php
                                                                    foreach ($infos_prelev as $prelev){
                                                                    ?>
                                                                    <tr><td style="font-style:italic"><?php echo contact::_getNom($prelev->ref_contact); ?></td><td style="font-style:italic"><?php echo number_format($prelev->montant, $TARIFS_NB_DECIMALES, ".", "")." ".$MONNAIE[1];; ?></td><td style="font-style:italic">le <?php echo date_Us_to_Fr($prelev->date) ?></td><td style="font-style:italic"><?php echo $prelev->ref_doc ?></td><td style="font-style:italic">(<?php echo $prelev->type_reglement ?>)</td></tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </td>
                                                            <td style="width:20%"><div class="bold_caisse" style="font-size:16px">&nbsp;</div></td>
							</tr>
							<tr>
                                                            <td><div class="bold_caisse" style="font-size:16px">&Eacute;ch&eacute;ances programm&eacute;es ( <span id="detail_echeances_links"> <span id = "detail_echeances_show_link" class="green_underlined" style="font-size:12px">Voir le d&eacute;tail</span><span id = "detail_echeances_hide_link" class="green_underlined" style="font-size:12px;display:none;">Masquer le d&eacute;tail</span></span> )</div></td>
                                                            <td ><div class="bold_caisse" style="font-size:16px"><?php echo number_format($echeances_prog, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></div></td>
                                                            <td style="width:20%"><div class="bold_caisse" style="font-size:16px">&nbsp;</div></td>
							    <script type="text/javascript">
                                                            Event.observe("detail_echeances_links", "click",  function(evt){
                                                                   Event.stop(evt);
                                                                   $("detail_echeances_show_link").toggle();
                                                                   $("detail_echeances_hide_link").toggle();
                                                                   $("detail_echeances").toggle();
                                                            }, false);
                                                            </script></tr>
                                                        <tr id = "detail_echeances" style="display:none;">
                                                            <td colspan="2">
                                                                <table>
                                                                    <?php
                                                                    foreach ($infos_echeances_prog as $echeance){
                                                                    ?>
                                                                    <tr><td style="font-style:italic"><?php echo contact::_getNom($echeance->ref_contact); ?></td><td style="font-style:italic"><?php echo number_format($echeance->montant, $TARIFS_NB_DECIMALES, ".", "")." ".$MONNAIE[1];; ?></td><td style="font-style:italic">le <?php echo date_Us_to_Fr($echeance->date) ?></td><td style="font-style:italic"><?php echo $echeance->ref_doc ?></td><td style="font-style:italic">(<?php echo $echeance->type_reglement ?>)</td></tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </td>
                                                            <td style="width:20%"><div class="bold_caisse" style="font-size:16px">&nbsp;</div></td>
							</tr>
							<tr>
								<td colspan="2" class="line_caisse_top">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							
							<tr>
								<td colspan="2">
								<span style="color:#97bf0d; float:right">
                                                                    <span id="consulter_compte_<?php echo $compte_bancaire->getId_compte_bancaire(); ?>"  class="green_underlined"  ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_consulter.gif" />
                                                                    </span>
								</span>
								<?php if ($last_operation) {?>
								<div style="float:left; color:#999999">Dernier opération enregistrée: <?php echo date_Us_to_Fr($last_operation);?></div>
								<?php } ?>
								</td>
								<td>&nbsp;</td>
							</tr>
						</table>
						<br />
						<br />
                                                <?php
                                                if (count($infos_echeances_sans_aut) > 0){
                                                ?>
                                                <font color="#cc0000">Attention ! Il vous manque des autorisations de traite acceptée</font>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
                                                            <td><div class="bold_caisse" style="font-size:14px">Traites acceptées sans autorisation (<span id="detail_prelevements_sans_aut_links"> <span id = "detail_prelevements_sans_aut_show_link" class="green_underlined" style="font-size:12px"> Voir le d&eacute;tail </span><span id = "detail_prelevements_sans_aut_hide_link" class="green_underlined" style="font-size:12px;display:none;">Masquer le d&eacute;tail</span></span> )</div></td>
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
						<br />
					</div>
					</td>
					<td style="width:8px;">
					<div style="height:100%; "></div>
					</td>
					<td></td>
				</tr>
			</table>
			</div>
			
			</td>
			<td style="width:8px">
			</td>
			<td style="background-color:#FFFFFF" >
			<br />
			<br />
			<br />
					<div style="padding: 15px 25px;">
					<div class="line_caisse_bottom"></div>
					<div class="bold_caisse" style="font-size:16px">Opérations de gestion</div> 
					<div class="line_caisse_top"></div>
					<br />
					<br />
					<span id="import_ope" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Historique des traites</span><br /><br />

					</div>
						<script type="text/javascript">
						Event.observe("import_ope", "click",  function(evt){
							Event.stop(evt);
							page.verify('import_mouvement_compte','compta_compte_bancaire_operations_import.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&from_tb=1','true','edition_operation');
							$("edition_operation").show();
						}, false);

						</script>
			</td>
		</tr>
</table>
</div>
</div>

</div>

<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_operation_iframe" class="edition_operation_iframe" style="display:none"></iframe>
<div id="edition_operation" class="edition_operation" style="display:none">
</div>
<SCRIPT type="text/javascript">

function setheight_gestion_caisse(){
set_tomax_height("corps_gestion_caisses" , -32);
}
Event.observe(window, "resize", setheight_gestion_caisse, false);
setheight_gestion_caisse();


	Event.observe("consulter_compte_<?php echo $compte_bancaire->getId_compte_bancaire(); ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("compta_gestion_traites_prelevements", "compta_gestion_traites_prelevements.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire(); ?>", "true", "sub_content");
	}, false);
	

//centrage de l'editeur
centrage_element("edition_operation");
centrage_element("edition_operation_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_operation");
centrage_element("edition_operation_iframe");
});
//on masque le chargement
H_loading();
</SCRIPT>