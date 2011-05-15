<?php

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


?>
	<table width="100%" border="0">
		<tr>
			<td style="width: 3%"></td>
			<td style="width:45%"></td>
			<td style="width: 4%"></td>
			<td style="width:45%"></td>
			<td style="width: 3%"></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align:center;">forme géométrique : </td>
			<td></td>
			<td>
				<select  id="forme_geo"  name="forme_geo" class="classinput_xsize">
					<option value="carre"			>Carré</option>
					<option selected="selected" value="rectangle"	>Rectangle</option>
					<option value="cercle"		>Cercle</option>
					<option value="triangle"	>Triangle</option>
				</select>
				<!-- Div sélectionné par défaut -->
				<input type="hidden" id="selectedDiv" value="calcul_rectangle"/>

				<script type="text/javascript">
					Event.observe("forme_geo", "change", function(evt){
						Event.stop(evt);
						if($("selectedDiv").value != ""){
							$($("selectedDiv").value).hide();
						}
						switch ($("forme_geo").options[$("forme_geo").selectedIndex].value){
							case 'carre':{	$("calcul_carre_cote").value = "0";
															$("calcul_carre_cote").style.backgroundColor = "";
															$("resultat_calcul").style.backgroundColor = "";
															$("calcul_carre").show();
															$("selectedDiv").value = "calcul_carre";
															break;}
							case 'rectangle':{$("calcul_rectangle_longueur").value = "0";
															$("calcul_rectangle_largeur").value = "0";
															$("calcul_rectangle_longueur").style.backgroundColor = "";
															$("calcul_rectangle_largeur").style.backgroundColor = "";
															$("resultat_calcul").style.backgroundColor = "";
															$("calcul_rectangle").show();
															$("selectedDiv").value = "calcul_rectangle";
															break;}
							case 'cercle':{	$("calcul_cercle_rayon").value = "0";
															$("calcul_cercle_rayon").style.backgroundColor = "";
															$("resultat_calcul").style.backgroundColor = "";
															$("calcul_cercle").show();
															$("selectedDiv").value = "calcul_cercle";
															break;}
							case 'triangle':{$("calcul_triangle_hauteur").value = "0";
															$("calcul_triangle_base").value = "0";
															$("calcul_triangle_hauteur").style.backgroundColor = "";
															$("calcul_triangle_base").style.backgroundColor = "";
															$("resultat_calcul").style.backgroundColor = "";
															$("calcul_triangle").show();
															$("selectedDiv").value = "calcul_triangle";
															break;}
							default:break;
						}
					}, false);
				</script>
			</td>
			<td></td>
		</tr>
	</table>

	<div id="calcul_carre" style="display:none">
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
				<td style="text-align:center;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/carre.png" height="100px" /></td>
				<td></td>
				<td>
					<table width="100%" border="0">
						<tr>
						<td style="width:25% ;text-align:right;">côté : </td>
						<td style="width:75% ;text-align:left;"><input style="text-align:right;" id="calcul_carre_cote" value="0" />&nbsp;m</td>
						</tr>
					</table>
				<td></td>
			</tr>
		</table>
	</div>
	
	<div id="calcul_rectangle" style="display:<?php if($id_valo == 9){echo "block;";}else{echo "none;";} ?>;">
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
				<td style="text-align:center;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/rectangle.png" height="100px" /></td>
				<td></td>
				<td>
					<table width="100%" border="0">
						<tr>
							<td style="width:25% ;text-align:right;">longueur : </td>
							<td style="width:75% ;text-align:left;"><input style="text-align:right;" id="calcul_rectangle_longueur" value="0" />&nbsp;m</td>
						</tr>
						<tr>
							<td style="text-align:right;">largeur :</td>
							<td style="text-align:left;"><input style="text-align:right;" id="calcul_rectangle_largeur" value="0"/>&nbsp;m</td>
						</tr>
					</table>
				<td></td>
			</tr>
		</table>
	</div>
	
	<div id="calcul_cercle" style="display:none;">
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
				<td style="text-align:center;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/cercle.png" height="100px" /></td>
				<td></td>
				<td>
					<table width="100%" border="0">
						<tr>
							<td style="width:25% ;text-align:right;">rayon : </td>
							<td style="width:75% ;text-align:left;"><input style="text-align:right;" id="calcul_cercle_rayon" value="0" />&nbsp;m</td>
						</tr>
					</table>
				</td>
				<td></td>
			</tr>
		</table>
	</div>
	
	<div id="calcul_triangle" style="display:none;">
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
				<td style="text-align:center;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/triangle.png" height="100px" /></td>
				<td></td>
				<td>
					<table width="100%" border="0">
						<tr>
							<td style="width:25% ;text-align:right;">hauteur : </td>
							<td style="width:75% ;text-align:left;"><input style="text-align:right;" id="calcul_triangle_hauteur" value="0" />&nbsp;m</td>
						</tr>
						<tr>
							<td style="text-align:right;">base :</td>
							<td style="text-align:left;"><input style="text-align:right;" id="calcul_triangle_base" value="0"/>&nbsp;m</td>
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
				<td style="width:50%"></td>
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
					<input id="resultat_calcul" name="resultat_calcul" style="text-align:right;" value="0"/>&nbsp;m&sup2;
				</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="6"><br/></td>
			</tr>
			<tr>
				<td colspan="6"><br/></td>
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
				case 'calcul_carre':{

					var vc = $("calcul_carre_cote").value.replace(",",".");
					var val_cote =  parseFloat(vc);

					if( isNaN(val_cote) ){
						$("calcul_carre_cote").style.backgroundColor = "#cd5c5c";
					}else{
						$("calcul_carre_cote").style.backgroundColor = "";
						
						val_cote =  parseFloat(vc).toFixed(nb_decimale);
						var val_coteLite = parseFloat(vc).toFixed(0);
						if( ( val_cote - val_coteLite )== 0){$("calcul_carre_cote").value = val_coteLite;}
						else{$("calcul_carre_cote").value = val_cote;}
						
						tmp_res = (val_cote*val_cote);
					}
					break;}
				case 'calcul_rectangle':{

					var vlo = $("calcul_rectangle_longueur").value.replace(",",".");
					var val_long =  parseFloat(vlo);
					
					var vla = $("calcul_rectangle_largeur").value.replace(",",".");
					var val_large =  parseFloat(vla);

					if( (!isNaN(val_long)) && (!isNaN(val_large)) ){
						$("calcul_rectangle_longueur").style.backgroundColor = "";
						$("calcul_rectangle_largeur").style.backgroundColor = "";
						
						val_long =  parseFloat(vlo).toFixed(nb_decimale);
						var val_longLite = parseFloat(vlo).toFixed(0);
						if( ( val_long - val_longLite )== 0){$("calcul_rectangle_longueur").value = val_longLite;}
						else{$("calcul_rectangle_longueur").value = val_long;}

						val_large =  parseFloat(vla).toFixed(nb_decimale);
						var val_largeLite = parseFloat(vla).toFixed(0);
						if( ( val_large - val_largeLite )== 0){$("calcul_rectangle_largeur").value = val_largeLite;}
						else{$("calcul_rectangle_largeur").value = val_large;}
						
						tmp_res = (val_long*val_large);
					}else{
						if( isNaN(parseFloat(resLong)) ){
							//alert("longueur");
							$("calcul_rectangle_longueur").style.backgroundColor = "#cd5c5c";
						}
						if( isNaN(parseFloat(resLarge)) ){
							//alert("largeur");
							$("calcul_rectangle_largeur").style.backgroundColor = "#cd5c5c";
						}
					}
					break;}						
				case 'calcul_cercle':{

					var vr = $("calcul_cercle_rayon").value.replace(",",".");
					var val_ray =  parseFloat(vr);

					if( isNaN(val_ray) ){
						$("calcul_cercle_rayon").style.backgroundColor = "#cd5c5c";
					}else{
						$("calcul_cercle_rayon").style.backgroundColor = "";
						
						val_ray =  parseFloat(vr).toFixed(nb_decimale);
						var val_rayLite = parseFloat(vr).toFixed(0);
						if( ( val_ray - val_rayLite )== 0){$("calcul_cercle_rayon").value = val_rayLite;}
						else{$("calcul_cercle_rayon").value = val_ray;}
						
						tmp_res = (Math.PI*val_ray*val_ray);
					}
					break;}
				case 'calcul_triangle':{
					var vlh = $("calcul_triangle_hauteur").value.replace(",",".");
					var val_haut =  parseFloat(vlh);
					
					var vlb = $("calcul_triangle_base").value.replace(",",".");
					var val_base =  parseFloat(vlb);

					if( (!isNaN(val_haut)) && (!isNaN(val_base)) ){
						$("calcul_triangle_hauteur").style.backgroundColor = "";
						$("calcul_triangle_base").style.backgroundColor = "";
						
						val_haut =  parseFloat(vlh).toFixed(nb_decimale);
						var val_hautLite = parseFloat(vlh).toFixed(0);
						if( ( val_haut - val_hautLite )== 0){$("calcul_triangle_hauteur").value = val_hautLite;}
						else{$("calcul_triangle_hauteur").value = val_haut;}

						val_base =  parseFloat(vlb).toFixed(nb_decimale);
						var val_baseLite = parseFloat(vlb).toFixed(0);
						if( ( val_base - val_baseLite )== 0){$("calcul_triangle_base").value = val_baseLite;}
						else{$("calcul_triangle_base").value = val_base;}
						
						tmp_res = (val_haut*val_base)/2;
					}else{
						if( isNaN(parseFloat(val_haut)) ){
							//alert("longueur");
							$("calcul_triangle_hauteur").style.backgroundColor = "#cd5c5c";
						}
						if( isNaN(parseFloat(val_base)) ){
							//alert("largeur");
							$("calcul_triangle_base").style.backgroundColor = "#cd5c5c";
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

		
		Event.observe("calcul_carre_cote", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);
	
		Event.observe("calcul_rectangle_longueur", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);
		Event.observe("calcul_rectangle_largeur", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);
	
		Event.observe("calcul_cercle_rayon", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);
	
		Event.observe("calcul_triangle_hauteur", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);
		
		Event.observe("calcul_triangle_base", "blur", function(evt){
			Event.stop(evt);
			calculResultat();
		}, false);

		<?php if ($indice_valo > 0){ ?>
		Event.observe("appli_indice_valo", "change", function(evt){
			calculResultat();
		}, false);
		<?php }?>
	</script>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>