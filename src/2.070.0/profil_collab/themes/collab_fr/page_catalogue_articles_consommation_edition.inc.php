<?php

// *************************************************************************************************************
// EDITION DE CONSOMMATION
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
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_consommation_edit" style="cursor:pointer; float:right" alt="Fermer" title="Fermer" />
<span style="font-weight:bolder">Edition de consommation</span><br />
<br />
<span class="bolder"><?php echo htmlentities($article->getLib_article()); ?></span>

<table width="100%" border="0">
	<tr>
		<td style="border:1px solid #d2d2d2">	
		
		<form action="catalogue_articles_consommation_edition_valid.php" method="post" id="catalogue_articles_consommation_edition_valid" name="catalogue_articles_consommation_edition_valid" target="formFrame" >
		
		<?php if(isset($source)){?>
			<input type="hidden" name="source" id="source" value="<?php echo $source;?>"/>
		<?php }?>
		<?php if(isset($develop_conso)){?>
			<input type="hidden" name="develop_abo" id="develop_abo" value="<?php echo $develop_conso;?>"/>
		<?php }?>
		<input type="hidden" name="conso_id_compte_credit" id="conso_id_compte_credit" value="<?php echo ($consommation->id_compte_credit); ?>"/>
		<input type="hidden" name="conso_ref_article" id="conso_ref_article" value="<?php echo ($consommation->ref_article); ?>"/>
		<input type="hidden" name="conso_ref_contact" id="conso_ref_contact" value="<?php echo ($consommation->ref_contact); ?>"/>
			<table width="100%" border="0" class="roundedtable">
				<tr>
					<td >
					<span class="labelled">Client:</span>
					</td>
					<td >
					<?php echo ($consommation->nom); ?>					
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Souscription:</span>
					</td>
					<td >
						<input type="text" name="conso_date_souscription" id="conso_date_souscription" value="<?php echo date_Us_to_Fr($consommation->date_souscription); ?>"/>
					
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Echéance:</span>
					</td>
					<td >
						<input type="text" name="conso_date_echeance" id="conso_date_echeance" value="<?php echo date_Us_to_Fr($consommation->date_echeance); ?>"/>
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Crédits restants:</span>
					</td>
					<td >
						<input type="text" name="conso_credits_restants" id="conso_credits_restants" value="<?php echo ($consommation->credits_restants); ?>"/>
					</td>
				</tr>
		</table><br />
		<div style="text-align:right">
		<input name="consommation_mod_valid" id="consommation_mod_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
		
		</div>
	</form>
	<script type="text/javascript">
				Event.observe("conso_date_souscription", "blur", datemask, false);
				Event.observe("conso_date_echeance", "blur", datemask, false);
				Event.observe("conso_credits_restants", "blur", function(evt){nummask(evt,"0", "X.X"); }, false);
	</script>
	<div style="text-align:right">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_consommer.gif"  id="consommer" <?php /*if (!$consommation->credits_restants) {?> style="display:none"<?php } */?>/>
	</div>
	<script type="text/javascript">
		Event.observe("consommer", "click",  function(evt){
			Event.stop(evt);
			page.traitecontent('catalogue_articles_consommation_use','catalogue_articles_consommation_use.php?id_compte_credit=<?php echo $consommation->id_compte_credit;?>&ref_article=<?php echo $consommation->ref_article;?>','true','edition_consommation');
			$("edition_consommation").show();
		}, false);
	</script>
	
<br />
		
		<span style=" font-weight:bolder">Liste des consommations</span>
		<div style=" background-color:#FFFFFF; border:1px solid #d6d6d6;">
		
			<?php
			$indentation_conso = 0;
			foreach ($consommation->consos as $conso) {
				?>
		<table width="100%" border="0"  cellspacing="0" id="view_conso_<?php echo $indentation_conso;?>">
			<tr>
				<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:45%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
				<tr>
					<td style="font-size:10px; cursor:pointer" id="conso1_<?php echo $indentation_conso;?>">
					
					</td>
					<td style="font-size:10px; cursor:pointer; " id="conso2_<?php echo $indentation_conso;?>">
					
					<?php	if ($conso->credit_used) { echo date_Us_to_Fr($conso->date_conso);}?>
					</td>
					<td style="text-align:right; font-size:11px; padding-right:10px;  cursor:pointer" id="conso3_<?php echo $indentation_conso;?>_">
					<?php	if ($conso->credit_used) { echo ($conso->credit_used)." ";}?>
					</td>
					<td style="padding-left:11px">
					</td>
				</tr>
				<tr>
					<td colspan="4"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
					
					</td>
				</tr>
			</table>
				<?php
			$indentation_conso++;
			}
			?>
		</div>
		</td>
	</tr>
</table>

<SCRIPT type="text/javascript">
Event.observe("close_consommation_edit", "click", function(evt){
$("edition_consommation").innerHTML="";
$("edition_consommation").hide();
}, false);
//on masque le chargement
H_loading();
</SCRIPT>