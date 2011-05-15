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
								<td><div class="bold_caisse" style="font-size:16px">Solde Théorique &gt;&gt;</div></td>
								<td align="right"><div class="bold_caisse" style="font-size:16px"><?php echo number_format($Solde_compte_bancaire, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></div></td>
								<td style="width:20%">&nbsp;</td>
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
								<?php if (isset($liste_releves[0])) {?>
								<div style="float:left; color:#999999">Dernier relevé enregistré: <?php echo date_Us_to_Fr($liste_releves[0]->date_releve)." ".getTime_from_date ($liste_releves[0]->date_releve);?></div>
								<?php } ?>
								<?php if ($last_operation) {?>
								<div style="float:left; color:#999999">Dernier opération enregistrée: <?php echo date_Us_to_Fr($last_operation);?></div>
								<?php } ?>
								</td>
								<td>&nbsp;</td>
							</tr>
						</table>
						<br />
						<br />
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class="bold_caisse" style="font-size:16px">Graphiques</div></td>
								<td align="right"></td>
								<td style="width:20%">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="line_caisse_top">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2">
								<span style=" font-weight:bolder; color:#999999">Solde à 30 jours</span><br />
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td>
										</td>
										<td>
										</td>
										<td style="height:5px">
										</td>
										<td style="width:75px;border-left:1px solid #999999; color:#999999;" rowspan="4">
										<table border="0" cellpadding="0" cellspacing="0" height="45px">
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo round($max_solde_30,0);?></td></tr>
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo round($max_solde_30/2,0);?></td></tr>
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;">0</td></tr>
										</table>
										</td>
									</tr>
									<tr>
										<td style="width:25px;">
										
											<div  class="blank_histo" style="height:30px" >&nbsp;</div>
										</td>
										<td valign="bottom" style="vertical-align:bottom">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php
										$o = 0;
										foreach ($solde_30 as $s_30) { ?>
										<td style="padding-right:2px; vertical-align: bottom; color:#999999;" valign="bottom">
										<div id="s3p_hist_<?php echo $o;?>" <?php
										if ($s_30 > 0) {
											?>	class="green_histo" style="background-color:<?php
										if (isset($degrader_30_pos[$o])) { echo $degrader_30_pos[$o]; }?>; height:0px" title="<?php echo number_format(($s_30), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>" <?php 
											}
											else {
											?>	class="blank_histo" <?php }
											?> >&nbsp;</div>
											<?php if ($s_30 > 0) {?>
											<script>rise_height("s3p_hist_<?php echo $o;?>", <?php echo $s_30 * 30 /$max_solde_30;?>);</script>
											<?php }?>
											</td>
											<?php
											$o++;
										}
										?>
										</tr>
										</table>
										</td>
										<td style="width:25px;">
										</td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #999999;">
										</td>
										<td style="border-bottom:1px solid #999999;">
										</td>
										<td style="border-bottom:1px solid #999999;">
										</td>
									</tr>
									<tr>
										<td style="width:25px;">
											<div  class="blank_histo" style="height:30px" >&nbsp;</div>
										</td>
										<td valign="top" style="vertical-align:top">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php
										$o = 0;
										foreach ($solde_30 as $s_30) { ?>
										<td style="padding-right:2px; vertical-align: top; color:#999999;" valign="top">
										<div id="s3n_hist_<?php echo $o;?>" <?php
										if ($s_30 < 0) {
											?>	class="red_histo" style="background-color:<?php
										if (isset($degrader_30_neg[$o])) { echo $degrader_30_neg[$o]; }?>;height:0px" title="<?php echo number_format(($s_30), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>" <?php }
											else {
											?>	class="blank_histo" <?php }
											?> >&nbsp;</div>
											<?php if ($s_30 < 0) {?>
											<script>rise_height("s3n_hist_<?php echo $o;?>", <?php echo (abs($s_30) * 30) /$max_solde_30;?>);</script>
											<?php }?>
											</td>
											<?php
											$o++;
										}
										?>
										</tr>
										</table>
										</td>
										<td style="width:25px;">
										</td>
									</tr>
									<tr>
										<td colspan="4" style="height:2px"><div></div>
										</td>
									</tr>
									<tr>
										<td style="border-top:1px solid #999999;">
										</td>
										<td style="border-top:1px solid #999999;">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php 
										$liste_abs = array(30,25,20,15,10,5,1);
										for ($j = 29; $j >=0 ; $j--) {
										
											?>
											<td style="padding:1px; vertical-align: top; font-size:8px; color:#999999;" valign="bottom">
											<div  class="blank_histo" ><?php if (in_array($j+1, $liste_abs)) {  echo $j+1;}?></div>
											</td>
											<?php
										}
										?>
										</tr>
										</table>
										</td>
										<td  style="border-top:1px solid #999999;">
										</td>
										<td >
										</td>
									</tr>
								</table>
								<br />
							<span style=" font-weight:bolder; color:#999999">Solde sur 12 mois</span><br />
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td>
										</td>
										<td>
										</td>
										<td style="height:5px">
										</td>
										<td style="width:75px;border-left:1px solid #999999;" rowspan="4">
										<table border="0" cellpadding="0" cellspacing="0" height="70px">
											<tr>
												<td style="font-size:8px; vertical-align:top;">-</td>
												<td style="font-size:10px; padding-left:1px; vertical-align:top; color:#999999;"><?php echo round($max_solde_12,0);?></td>
											</tr>
											<tr>
												<td style="font-size:8px; vertical-align: middle;">-</td>
												<td style="font-size:10px; padding-left:1px; vertical-align: middle; color:#999999;"><?php echo round($max_solde_12/2,0);?></td>
											</tr>
											<tr>
												<td style="font-size:8px; vertical-align: bottom;">-</td>
												<td style="font-size:10px; padding-left:1px; vertical-align: bottom; color:#999999;">0</td>
											</tr>
										</table>
										</td>
									</tr>
									<tr>
										<td style="width:25px;">
										<div style="height:60px">&nbsp;</div>
										</td>
										<td valign="bottom" style="vertical-align:bottom">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php 
										$o = 0;
										foreach ($solde_12 as $s_12) { ?>
										<td style="padding-right:21px; vertical-align: bottom;" valign="bottom">
										<div id="s1p_histo_<?php echo $o;?>" <?php
										if ($s_12 > 0) {
											?> style=" width:10px; background-color:<?php
										if (isset($degrader_12_pos[$o])) { echo $degrader_12_pos[$o]; }?>;height:0px" title="<?php echo number_format(($s_12), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>" <?php }
											else {
											?>	style=" width:10px" <?php }
											?> >&nbsp;</div>
											<?php if ($s_12 > 0) {?>
											<script>rise_height("s1p_histo_<?php echo $o;?>", <?php echo ($s_12 * 60) /$max_solde_12;?>);</script>
											<?php }?>
											</td>
											<?php
											$o++;
										}
										?>
										</tr>
										</table>
										</td>
										<td style="width:25px;">
										</td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #999999;">
										</td>
										<td style="border-bottom:1px solid #999999;">
										</td>
										<td style="border-bottom:1px solid #999999;">
										</td>
									</tr>
									<tr>
										<td style="width:25px;">
											<div  class="blank_histo" style="height:60px" >&nbsp;</div>
										</td>
										<td valign="top" style="vertical-align:top">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php
										$o = 0;
										foreach ($solde_12 as $s_12) { ?>
										<td style="padding-right:21px; vertical-align: top; color:#999999;" valign="top">
										<div id="s1n_hist_<?php echo $o;?>" <?php
										if ($s_12 < 0) {
											?>	style=" width:10px; background-color:<?php
										if (isset($degrader_12_neg[$o])) { echo $degrader_12_neg[$o]; }?>;height:0px" title="<?php echo number_format(($s_12), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>" <?php }
											else {
											?>	style=" width:10px" <?php }
											?> >&nbsp;</div>
											<?php if ($s_12 < 0) {?>
											<script>rise_height("s1n_hist_<?php echo $o;?>", <?php echo (abs($s_12) * 60) /$max_solde_12;?>);</script>
											<?php }?>
											</td>
											<?php
											$o++;
										}
										?>
										</tr>
										</table>
										</td>
										<td style="width:25px;">
										</td>
									</tr>
									
									<tr>
										<td colspan="4" style="height:2px"><div></div>
										</td>
									</tr>
									<tr>
										<td style="border-top:1px solid #999999;">
										</td>
										<td style="border-top:1px solid #999999;">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php 
										
										setlocale(LC_TIME, $INFO_LOCALE);
										for ($j = 11; $j >=0 ; $j--) {
											?>
											<td style="vertical-align: top; font-size:8px; color:#999999 " valign="bottom">
											<div style="width:31px;" ><span style="width:10px; text-align:center"><?php  echo date("M y", mktime(0, 0, 0, date("m" ,time())-$j , 1, date ("Y", time()) ) );?></span></div>
											</td>
											<?php
										}
										?>
										</tr>
										</table>
										</td>
										<td  style="border-top:1px solid #999999;">
										</td>
										<td >
										</td>
									</tr>
								</table>
								
								
								</td>
								<td>&nbsp;</td>
							</tr>
						</table>
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
					<span id="traite" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Remise d'effet</span><br /><br />
					
					<span id="add_ope" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Enregistrer des opérations</span><br /><br />

					<span id="import_ope" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Importer des opérations</span><br /><br />

					<span id="search_ope" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Rechercher une opération</span><br /><br />

					<span id="search_chq_rem" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Rechercher un chèque remisé</span><br /><br />

						<br />
					<span id="add_releve" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Enregistrer un relevé</span><br /><br />

<br />

					<span id="print_rib" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />Imprimer un RIB</span><br /><br />
					</div>
						<script type="text/javascript">
						
						Event.observe("add_ope", "click",  function(evt){
							Event.stop(evt);
							page.verify('add_mouvement_compte','compta_compte_bancaire_operations_add.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&from_tb=1','true','edition_operation');
							$("edition_operation").show();
						}, false);
						
						Event.observe("import_ope", "click",  function(evt){
							Event.stop(evt);
							page.verify('import_mouvement_compte','compta_compte_bancaire_operations_import.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&from_tb=1','true','edition_operation');
							$("edition_operation").show();
						}, false);

						Event.observe('search_ope', 'click',  function(evt){
						Event.stop(evt); 
						page.verify('compte_bancaire_recherche','compta_compte_bancaire_recherche.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>','true','sub_content');
						}, false);


						Event.observe('search_chq_rem', 'click',  function(evt){
						Event.stop(evt); 
						page.verify('compte_bancaire_recherche_chq','compta_compte_bancaire_recherche_chq.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>','true','sub_content');
						}, false);



						Event.observe("add_releve", "click",  function(evt){
							Event.stop(evt);
							page.verify('add_compta_compte_bancaire_releves','compta_compte_bancaire_releves_add.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&from_tb=1','true','edition_operation');
							$("edition_operation").show();
						}, false);
						
						
						
						Event.observe("print_rib", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_compte_bancaire_rib", "compta_compte_bancaire_rib_imprimer.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire(); ?>", "true", "_blank");
						}, false);
						
						Event.observe("traite", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_remise_bancaire_traite", "compta_remise_bancaire_traite.php?id_caisse=1", "true", "sub_content");
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
		page.verify("compta_compte_bancaire_moves", "compta_compte_bancaire_moves.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire(); ?>", "true", "sub_content");
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