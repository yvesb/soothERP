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
<span style="font-weight:bolder">Utilisation de crédits</span><br />
<br />
<span class="bolder"><?php echo htmlentities($article->getLib_article ()); ?></span>

<table width="100%" border="0">
	<tr>
		<td style="border:1px solid #d2d2d2;">	
		
		<form action="catalogue_articles_consommation_use_valid.php" method="post" id="catalogue_articles_consommation_use_valid" name="catalogue_articles_consommation_use_valid" target="formFrame" >
		
		<input type="hidden" name="conso_id_compte_credit" id="conso_id_compte_credit" value="<?php echo ($consommation->id_compte_credit); ?>"/>
		<input type="hidden" name="conso_ref_article" id="conso_ref_article" value="<?php echo ($consommation->ref_article); ?>"/>
			<table width="100%" border="0" class="roundedtable">
				<tr>
					<td width="35%" >
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
					<td ><?php echo date_Us_to_Fr($consommation->date_souscription); ?>
					
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Echéance:</span>
					</td>
					<td >
					<?php echo date_Us_to_Fr($consommation->date_echeance); ?>
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Crédits restants:</span>
					</td>
					<td ><?php echo ($consommation->credits_restants); ?>
					</td>
				</tr>
				<tr>
					<td >
					<span class="labelled">Crédits à débiter:</span>
					</td>
					<td >
						<input type="text" name="conso_credits_used" id="conso_credits_used" value="1" size="5"/>
					</td>
				</tr>
		</table><br />
		<div style="text-align:right">
		<input name="consommation_use_valid" id="consommation_use_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
		</div>
	</form>
	<script type="text/javascript">
				Event.observe("conso_credits_used", "blur", function(evt){nummask(evt,"0", "X.X"); }, false);
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

Event.observe("catalogue_articles_consommation_use_valid", "submit", function(evt){
		Event.stop(evt);

		$("titre_alert").innerHTML = 'Confirmer';
		$("texte_alert").innerHTML = 'Confirmer la consommation de '+$("conso_credits_used").value+' crédits';
		$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
		
		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";
		
		$("bouton0").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		$("catalogue_articles_consommation_use_valid").submit();
		}
		
		$("bouton1").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		} 
}, false);
//on masque le chargement
H_loading();
</SCRIPT>