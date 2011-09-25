<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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

?><div class="emarge"><br />

<span class="titre" style="float:left; padding-left:140px; width: 40%">Relevés du compte <?php echo $compte_bancaire->getLib_compte ();?></span>


<span style=" float:right; text-align:right; width:19%"><br />
<span id="retour_gestion" style="cursor:pointer; text-decoration:underline">Retour au tableau de bord</span>

<script type="text/javascript">
Event.observe('retour_gestion', 'click',  function(evt){
Event.stop(evt); 
page.verify('compte_bancaire_gestion2','compta_compte_bancaire_gestion2.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire();?>','true','sub_content');
}, false);
</script>
</span>
<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_compte_bancaire">

<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
	<tr>
		<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
			<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_banque.jpg" />				</div>
			<span style="width:35px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			</td>
		<td colspan="2" style="width:90%; background-color:#FFFFFF" >

			<SCRIPT type="text/javascript">
			lines_releves = new Array();
			</SCRIPT>
			
			<table style="width:100%; cursor:pointer; " id="line_releve_0">
				<tr id="releve_0">
					<td style="width:10%">
					<div style="text-align:left">
					
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_compta_left_arrow.gif" id="bt_view_releve_0" style="cursor:pointer"/>
					</div>
					</td>
					<td>
					<div>
					<?php echo date("d-m-Y");?>
					</div>
					</td>
					<td>
					<div style="text-align:right">
					en cours
					</div>
					</td>
					<td style="width:25px">
					<div style="text-align:right">
					
					</div>
					</td>
				</tr>
			</table>
			<SCRIPT type="text/javascript">
			lines_releves.push("line_releve_0");
			Event.observe('releve_0', 'click',  function(evt){
				Event.stop(evt); 
				S_loading();
				for (i = 0; i < lines_releves.length; i++) {
					$(lines_releves[i]).style.color="#000000";
				}
				$("line_releve_0").style.color="#AAAAAA";
				$("date_fin").value = "<?php echo date("Y-m-d");?>";
				$("page_to_show").value="1";
				page.compte_bancaire_moves();
			}, false);
			</SCRIPT>
			<?php 
			foreach ($liste_releves as $releve) {
				?>
				<table style="width:100%" id="line_releve_<?php echo $releve->id_compte_bancaire_releve;?>">
					<tr>
						<td style="width:10%" title="Afficher les opérations">
						<div style="text-align:left; cursor:pointer" id="releve_<?php echo $releve->id_compte_bancaire_releve;?>">
						
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_compta_left_arrow.gif" id="bt_view_releve_<?php echo $releve->id_compte_bancaire_releve;?>" style="cursor:pointer"/>
						</div>
						</td>
						<td id="mod_releve_1_<?php echo $releve->id_compte_bancaire_releve;?>" style="cursor:pointer" title="modifier">
						<div>
						<?php echo date_Us_to_Fr($releve->date_releve);?>
						</div>
						</td>
						<td id="mod_releve_2_<?php echo $releve->id_compte_bancaire_releve;?>" style="cursor:pointer" >
						<div title="solde calculé : <?php echo price_format($releve->solde_calcule)." ".$MONNAIE[1];?>" style="text-align:right; <?php if (price_format($releve->solde_calcule) != price_format($releve->solde_reel)) { ?>color:#FF0000;<?php } ?>">
						<?php echo price_format($releve->solde_reel)." ".$MONNAIE[1];?>
						</div>
						</td>
						<td id="mod_releve_3_<?php echo $releve->id_compte_bancaire_releve;?>" style="cursor:pointer; width:25px" >
						<div style="text-align:right;">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/edit_releve.gif" id="bt_edit_releve_<?php echo $releve->id_compte_bancaire_releve;?>" style="cursor:pointer" title="Editer"/>
						</div>
						</td>
					</tr>
				</table>
				<SCRIPT type="text/javascript">
				lines_releves.push("line_releve_<?php echo $releve->id_compte_bancaire_releve;?>");
				
				Event.observe("mod_releve_1_<?php echo $releve->id_compte_bancaire_releve;?>", "click",  function(evt){
					Event.stop(evt); 
					S_loading();
					for (i = 0; i < lines_releves.length; i++) {
						$(lines_releves[i]).style.color="#000000";
					}
					$("line_releve_<?php echo $releve->id_compte_bancaire_releve;?>").style.color="#AAAAAA";
					$("date_fin").value = "<?php echo date_Fr_to_Us(date_Us_to_Fr($releve->date_releve));?>";
					$("page_to_show").value="1";
					page.compte_bancaire_moves();
				}, false);
				
				Event.observe("mod_releve_2_<?php echo $releve->id_compte_bancaire_releve;?>", "click",  function(evt){
					Event.stop(evt); 
					S_loading();
					for (i = 0; i < lines_releves.length; i++) {
						$(lines_releves[i]).style.color="#000000";
					}
					$("line_releve_<?php echo $releve->id_compte_bancaire_releve;?>").style.color="#AAAAAA";
					$("date_fin").value = "<?php echo date_Fr_to_Us(date_Us_to_Fr($releve->date_releve));?>";
					$("page_to_show").value="1";
					page.compte_bancaire_moves();
				}, false);
				
				Event.observe('releve_<?php echo $releve->id_compte_bancaire_releve;?>', 'click',  function(evt){
					Event.stop(evt); 
					S_loading();
					for (i = 0; i < lines_releves.length; i++) {
						$(lines_releves[i]).style.color="#000000";
					}
					$("line_releve_<?php echo $releve->id_compte_bancaire_releve;?>").style.color="#AAAAAA";
					$("date_fin").value = "<?php echo date_Fr_to_Us(date_Us_to_Fr($releve->date_releve));?>";
					$("page_to_show").value="1";
					page.compte_bancaire_moves();
				}, false);
				
				
				Event.observe("mod_releve_3_<?php echo $releve->id_compte_bancaire_releve;?>", "click",  function(evt){
					Event.stop(evt);
					S_loading();
					page.verify('edit_releve_compte','compta_compte_bancaire_releves_edit.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&id_compte_bancaire_releve=<?php echo $releve->id_compte_bancaire_releve;?>','true','edition_operation');
					$("edition_operation").show();
				}, false);
				</SCRIPT>
				<?php 
			}
			?>


			</td>
	</tr>
</table>

<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_operation_iframe" class="edition_operation_iframe" style="display:none"></iframe>
<div id="edition_operation" class="edition_operation" style="display:none; text-align:left">
</div>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>