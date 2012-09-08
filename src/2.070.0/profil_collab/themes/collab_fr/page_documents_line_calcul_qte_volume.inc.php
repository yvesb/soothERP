<?php

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


?>
	<table width="100%" border="0">
		<tr>
			<td style="width: 3%"></td>
			<td style="width:40%"></td>
			<td style="width: 4%"></td>
			<td style="width:40%"></td>
			<td style="width: 3%"></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align:center;">forme géométrique : </td>
			<td></td>
			<td>
				<select  id="forme_geo"  name="forme_geo" class="classinput_xsize">
					<option value="cube"			>Cube</option>
					<option selected="selected" value="pave_droit">Pavé</option>
					<option value="cylindre"	>Cylindre</option>
				</select>
				<!-- Div sélectionné par défaut -->
				<input type="hidden" id="selectedDiv" value="calcul_pave_droit"/>

				<script type="text/javascript">
					Event.observe("forme_geo", "change", function(evt){
						Event.stop(evt);
						if($("selectedDiv").value != ""){
							$($("selectedDiv").value).hide();
						}
						switch ($("forme_geo").options[$("forme_geo").selectedIndex].value){
							case 'cube':{		$("calcul_cube_cote").value = "0";
															$("calcul_cube_cote").style.backgroundColor = "";
															$("resultat_calcul").style.backgroundColor = "";
															$("calcul_cube").show();
															$("selectedDiv").value = "calcul_cube";
															break;}
							case 'pave_droit':{$("calcul_pave_droit_longueur").value = "0";
															$("calcul_pave_droit_largeur").value = "0";
															$("calcul_pave_droit_hauteur").value = "0";
															$("calcul_pave_droit_longueur").style.backgroundColor = "";
															$("calcul_pave_droit_largeur").style.backgroundColor = "";
															$("calcul_pave_droit_hauteur").style.backgroundColor = "";
															$("resultat_calcul").style.backgroundColor = "";
															$("calcul_pave_droit").show();
															$("selectedDiv").value = "calcul_pave_droit";
															break;}
							case 'cylindre':{$("calcul_cylindre_rayon").value = "0";
															$("calcul_cylindre_hauteur").value = "0";
															$("calcul_cylindre_rayon").style.backgroundColor = "";
															$("calcul_cylindre_hauteur").style.backgroundColor = "";
															$("resultat_calcul").style.backgroundColor = "";
															$("calcul_cylindre").show();
															$("selectedDiv").value = "calcul_cylindre";
															break;}
							default:break;
						}
					}, false);
				</script>
			</td>
			<td></td>
		</tr>
	</table>

	<div id="calcul_cube" style="display:none">
		<table width="100%" border="0">
			<tr>
				<td style="width: 3%"></td>
				<td style="width:40%"></td>
				<td style="width: 4%"></td>
				<td style="width:40%"></td>
				<td style="width: 3%"></td>
			</tr>
			<tr>
				<td></td>
				<td style="text-align:center;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cube.png" height="100px" /></td>
				<td></td>
				<td>
					<table width="100%" border="0">
						<tr>
							<td style="width:25% ;text-align:right;">côté : </td>
							<td style="width:75% ;text-align:left;"><input style="text-align:right;" id="calcul_cube_cote" value="0"/>&nbsp;<?php if($id_valo == 10){echo "m";}elseif($id_valo == 11){echo "cm";} ?>
						</tr>
					</table>
				</td>
				<td></td>
			</tr>
		</table>
	</div>
	
	<div id="calcul_pave_droit" style="display:<?php if($id_valo == 10 || $id_valo == 11){echo "block;";}else{echo "none;";} ?>;">
		<table width="100%" border="0">
			<tr>
				<td style="width: 3%"></td>
				<td style="width:40%"></td>
				<td style="width: 4%"></td>
				<td style="width:40%"></td>
				<td style="width: 3%"></td>
			</tr>
			<tr>
				<td></td>
				<td style="text-align:center;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/pave_droit.png" height="100px" /></td>
				<td></td>
				<td>
					<table width="100%" border="0">
						<tr>
							<td style="width:25% ;text-align:right;">longueur : </td>
							<td style="width:75% ;text-align:left;"><input style="text-align:right;" id="calcul_pave_droit_longueur" value="0" />&nbsp;<?php if($id_valo == 10){echo "m";}elseif($id_valo == 11){echo "cm";} ?></td>
						</tr>
						<tr>
							<td style="text-align:right;">largeur :</td>
							<td style="text-align:left;"><input style="text-align:right;" id="calcul_pave_droit_largeur" value="0"/>&nbsp;<?php if($id_valo == 10){echo "m";}elseif($id_valo == 11){echo "cm";} ?></td>
						</tr>
						<tr>
							<td style="text-align:right;">hauteur :</td>
							<td style="text-align:left;"><input style="text-align:right;" id="calcul_pave_droit_hauteur" value="0"/>&nbsp;<?php if($id_valo == 10){echo "m";}elseif($id_valo == 11){echo "cm";} ?></td>
						</tr>
					</table>
				</td>
				<td></td>
			</tr>
		</table>
	</div>
	
	<div id="calcul_cylindre" style="display:none;">
		<table width="100%" border="0">
			<tr>
				<td style="width: 3%"></td>
				<td style="width:40%"></td>
				<td style="width: 4%"></td>
				<td style="width:40%"></td>
				<td style="width: 3%"></td>
			</tr>
			<tr>
				<td></td>
				<td style="text-align:center;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cylindre.png" height="100px" /></td>
				<td></td>
				<td>
					<table width="100%" border="0">
						<tr>
							<td style="width:25% ;text-align:right;">rayon : </td>
							<td style="width:75% ;text-align:left;"><input style="text-align:right;" id="calcul_cylindre_rayon" value="0" />&nbsp;<?php if($id_valo == 10){echo "m";}elseif($id_valo == 11){echo "cm";} ?></td>
						</tr>
						<tr>
							<td style="text-align:right;">hauteur :</td>
							<td style="text-align:left;"><input style="text-align:right;" id="calcul_cylindre_hauteur" value="0"/>&nbsp;<?php if($id_valo == 10){echo "m";}elseif($id_valo == 11){echo "cm";} ?></td>
						</tr>
					</table>
				</td>
				<td></td>
			</tr>
		</table>
	</div>
	
	<div>
		<table width="100%" border="0">
			<tr>
				<td style="width: 3%"></td>
				<td style="width:40%"></td>
				<td style="width: 4%"></td>
				<td style="width:10%"></td>
				<td style="width:30%"></td>
				<td style="width: 3%"></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td colspan="2"><hr/></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td style="text-align:right;">Résultat :</td>
				<td style="text-align:left;">
					<input id="resultat_calcul" name="resultat_calcul" style="text-align:right;" value="0"/>&nbsp;
					<?php 
						if($id_valo == 10) {echo "m&sup3;";}
						else {echo "L";}
					?>
				</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="5"><br/></td>
			</tr>
			<tr>
				<td colspan="5"><br/></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<?php if ($indice_valo > 0){ ?>
						<input id="appli_indice_valo" name="appli_indice_valo" type="checkbox" checked="checked" />
						Appliquer l'indice de valorisation : 
						<input type="text" disabled="disabled" style="width:50px;text-align:right;" value="<?php echo $indice_valo; ?>"/>	
					<?php }?>
				</td>
				<td></td>
				<td></td>
				<td style="text-align:right;">
					<img id="calcul_geo_valider" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />

				</td>
				<td></td>
			</tr>
		</table>
	</div>
	
	<SCRIPT type="text/javascript">
	
		function calculResultat(){
			var indice_valo = parseFloat(<?php echo $indice_valo; ?>);
			var tmp_res = -1;
			var nb_decimale = parseInt(<?php echo $ARTICLE_QTE_NB_DEC;?>);
			
			switch ($("selectedDiv").value){
				case 'calcul_cube':{
					var vc = $("calcul_cube_cote").value.replace(",",".");
					var val_cote =  parseFloat(vc);

					if( isNaN(val_cote) ){
						$("calcul_cube_cote").style.backgroundColor = "#cd5c5c";
					}else{
						$("calcul_cube_cote").style.backgroundColor = "";
						
						val_cote =  parseFloat(vc).toFixed(nb_decimale);
						var val_coteLite = parseFloat(vc).toFixed(0);
						if( ( val_cote - val_coteLite )== 0){$("calcul_cube_cote").value = val_coteLite;}
						else{$("calcul_cube_cote").value = val_cote;}
						
						<?php if($id_valo == 11){ ?>//LITRES
							tmp_res = (val_cote*val_cote*val_cote)/1000;
						<?php }else{?>
							tmp_res = (val_cote*val_cote*val_cote);
						<?php }?>
					}
					break;}
				case 'calcul_pave_droit':{

					var vlo = $("calcul_pave_droit_longueur").value.replace(",",".");
					var val_long =  parseFloat(vlo);
					
					var vla = $("calcul_pave_droit_largeur").value.replace(",",".");
					var val_large =  parseFloat(vla);
					
					var vlh = $("calcul_pave_droit_hauteur").value.replace(",",".");
					var val_haut =  parseFloat(vlh);

					if( (!isNaN(val_long)) && (!isNaN(val_large)) && (!isNaN(val_haut)) ){
						$("calcul_pave_droit_longueur").style.backgroundColor = "";
						$("calcul_pave_droit_largeur").style.backgroundColor = "";
						$("calcul_pave_droit_hauteur").style.backgroundColor = "";
						
						val_long =  parseFloat(vlo).toFixed(nb_decimale);
						var val_longLite = parseFloat(vlo).toFixed(0);
						if( ( val_long - val_longLite )== 0){$("calcul_pave_droit_longueur").value = val_longLite;}
						else{$("calcul_pave_droit_longueur").value = val_long;}

						val_large =  parseFloat(vla).toFixed(nb_decimale);
						var val_largeLite = parseFloat(vla).toFixed(0);
						if( ( val_large - val_largeLite )== 0){$("calcul_pave_droit_largeur").value = val_largeLite;}
						else{$("calcul_pave_droit_largeur").value = val_large;}

						val_haut =  parseFloat(vlh).toFixed(nb_decimale);
						var val_hautLite = parseFloat(vlh).toFixed(0);
						if( ( val_haut - val_hautLite )== 0){$("calcul_pave_droit_hauteur").value = val_hautLite;}
						else{$("calcul_pave_droit_hauteur").value = val_haut;}
						
						<?php if($id_valo == 11){ ?>//LITRES
							tmp_res = (val_long*val_large*val_haut)/1000;
						<?php }else{?>
							tmp_res = (val_long*val_large*val_haut);
						<?php }?>
					}else{
						if( isNaN(parseFloat(val_long)) ){
							//alert("longueur");
							$("calcul_pave_droit_longueur").style.backgroundColor = "#cd5c5c";
						}
						if( isNaN(parseFloat(val_large)) ){
							//alert("largeur");
							$("calcul_pave_droit_largeur").style.backgroundColor = "#cd5c5c";
						}
						if( isNaN(parseFloat(val_haut)) ){
							//alert("largeur");
							$("calcul_pave_droit_hauteur").style.backgroundColor = "#cd5c5c";
						}
					}
					break;}
				case 'calcul_cylindre':{
					var vh = $("calcul_cylindre_hauteur").value.replace(",",".");
					var val_haut =  parseFloat(vh);
					
					var vr = $("calcul_cylindre_rayon").value.replace(",",".");
					var val_ray =  parseFloat(vr);

					if( (!isNaN(val_haut)) && (!isNaN(val_ray)) ){
						$("calcul_cylindre_hauteur").style.backgroundColor = "";
						$("calcul_cylindre_rayon").style.backgroundColor = "";
						
						val_haut =  parseFloat(vh).toFixed(nb_decimale);
						var val_hautLite = parseFloat(vh).toFixed(0);
						if( ( val_haut - val_hautLite )== 0){$("calcul_cylindre_hauteur").value = val_hautLite;}
						else{$("calcul_cylindre_hauteur").value = val_haut;}

						val_ray =  parseFloat(vr).toFixed(nb_decimale);
						var val_rayLite = parseFloat(vr).toFixed(0);
						if( ( val_ray - val_rayLite )== 0){$("calcul_cylindre_rayon").value = val_rayLite;}
						else{$("calcul_cylindre_rayon").value = val_ray;}
						
						<?php if($id_valo == 11){ ?>//LITRES
							tmp_res = Math.PI*parseFloat(val_ray)*parseFloat(val_ray)*parseFloat(val_haut)/1000;
						<?php }else{?>
							tmp_res = Math.PI*parseFloat(val_ray)*parseFloat(val_ray)*parseFloat(val_haut);
						<?php }?>
					}else{
						if( isNaN(parseFloat(val_haut)) ){
							//alert("longueur");
							$("calcul_cylindre_hauteur").style.backgroundColor = "#cd5c5c";
						}
						if( isNaN(parseFloat(val_ray)) ){
							//alert("largeur");
							$("calcul_cylindre_rayon").style.backgroundColor = "#cd5c5c";
						}
					}
					break;}
				default:{break;}
			}
			
		 	tmp_res = tmp_res.toFixed(10);
		 	
			if(indice_valo > 0 && $("appli_indice_valo").checked){
				
				if( (( Math.floor(tmp_res / indice_valo) )*indice_valo) == tmp_res ){
					//$("resultat_calcul").style.backgroundColor = "yellow";
					var tmp_resLite = (( Math.floor(tmp_res / indice_valo) )*indice_valo).toFixed(0);
					tmp_res = (( Math.floor(tmp_res / indice_valo) )*indice_valo).toFixed(nb_decimale);
					if( (tmp_res - tmp_resLite) == 0){$("resultat_calcul").value = tmp_resLite;}
					else{$("resultat_calcul").value = tmp_res;}
				}else{
					//$("resultat_calcul").style.backgroundColor = "green";
					tmp_res = ((Math.floor(tmp_res/indice_valo)+1)*indice_valo).toFixed(nb_decimale); 
					var tmp_resLite = ((Math.floor(tmp_res/indice_valo)+1)*indice_valo).toFixed(0)
					if( (tmp_res - tmp_resLite) == 0){$("resultat_calcul").value = tmp_resLite;}
					else{$("resultat_calcul").value = tmp_res;}
				}
			}else{
				//$("resultat_calcul").style.backgroundColor = "blue";
				var tmp_resLite2 = parseFloat(tmp_res+0).toFixed(0)
				tmp_res = parseFloat(tmp_res+0).toFixed(nb_decimale); 
				if( (tmp_res - tmp_resLite2) == 0){$("resultat_calcul").value = tmp_resLite2;}
				else{$("resultat_calcul").value = tmp_res;}
			}
		}

		
		Event.observe("calcul_cylindre_rayon", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);

		
		Event.observe("calcul_cylindre_hauteur", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);

		
		Event.observe("calcul_pave_droit_longueur", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);

		
		Event.observe("calcul_pave_droit_largeur", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);

		
		Event.observe("calcul_pave_droit_hauteur", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);

		
		Event.observe("calcul_cube_cote", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);

		
		<?php if ($indice_valo > 0){ ?>
		Event.observe("appli_indice_valo", "change", function(evt){
			calculResultat();
		}, false);
		<?php }?>

		
		Event.observe("calcul_geo_valider", "click", function(evt){
			Event.stop(evt);

			if (!isNaN(parseFloat($("resultat_calcul").value))){
				var qte = (parseFloat($("resultat_calcul").value)).toFixed(2);
				var qteLite = (parseFloat($("resultat_calcul").value)).toFixed(0);
				if(qte == parseFloat(qteLite)){
					window.parent.document.getElementById("<?php echo $cible;?>").value = qteLite;
				}else{
					window.parent.document.getElementById("<?php echo $cible;?>").value = qte;
				}
                                window.parent.document.getElementById("<?php echo $cible;?>").fireEvent("blur");
				$("resultat_calcul").style.backgroundColor = "";
				window.parent.document.getElementById("pop_up_options").style.display = "none";
			}else{
				$("resultat_calcul").style.backgroundColor = "#cd5c5c";
			}
		}, false);
	</script>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>