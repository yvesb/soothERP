<?php

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

?>
<table width="100%" border="0">
	<tr>
		<td style="width: 3%"></td>
		<td style="width:45%;"></td>
		<td style="width: 4%;"></td>
		<td style="width:45%"></td>
		<td style="width: 3%"></td>
	</tr>
	<tr>
		<td ></td>
		<td style="text-align:right;%">Choix du Collisage : </td>
		<td ></td>
		<td style="text-align:left;">
			<select style="width:100%;text-align:right;" id="choix_collisage"  name="choix_collisage" class="classinput_xsize">
				<?php
				$s = true;
				foreach ($collisages as $collisage) { ?>
					<option value="<?php echo $collisage; ?>" <?php if($s){$s=false; echo 'selected="selected"';} ?> ><?php echo $collisage; ?>&nbsp;</option>
				<?php } ?>
			</select>
		</td>
		<td ></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td style="text-align:right;">Multiplicateur</td>
		<td></td>
		<td>
			<input style="width:92%;text-align:right;" id="multiplicateur" name="multiplicateur" value="1"/>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3"></td>
		<td>&nbsp;</td>
	</tr>
</table>

<table width="100%" border="0">
	<tr>
		<td style="width: 3%"></td>
		<td style="width:45%"></td>
		<td style="width: 4%"></td>
		<td style="width:15%"></td>
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
			<input id="resultat_calcul" name="resultat_calcul" style="text-align:right;" />&nbsp;<?php /*echo $unite;*/?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6">&nbsp;</td>
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
		<td>&nbsp;</td>
		<td></td>
		<td style="text-align:right;">
			<img id="calcul_qte_valider" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
		</td>
		<td></td>
	</tr>
</table>

<SCRIPT type="text/javascript">
	
	function calculResultat(){
		
		var m = $("multiplicateur").value.replace(",",".");;
		var c = $("choix_collisage").options[$("choix_collisage").selectedIndex].value;

		var multi =  parseFloat(m);
		var colli =  parseFloat(c);

		var indice_valo = parseFloat(<?php echo $indice_valo; ?>);
		
		if( isNaN(multi) ){
			$("multiplicateur").style.backgroundColor = "#cd5c5c";
		}else{
			$("multiplicateur").style.backgroundColor = "";

			var nb_decimale = <?php echo $ARTICLE_QTE_NB_DEC;?>;
			
			multi =  parseFloat(m).toFixed(nb_decimale);
			colli =  parseFloat(c).toFixed(nb_decimale);
			var multiLite = parseFloat(m).toFixed(0);
			if( ( multi - multiLite )== 0){$("multiplicateur").value = multiLite;}
			else{$("multiplicateur").value = multi;}
			
			if(indice_valo > 0 && $("appli_indice_valo").checked){
				var tmp_res = ( multi * colli ).toFixed(nb_decimale);

				if( (( Math.floor(tmp_res / indice_valo) )*indice_valo) == tmp_res ){
					//$("resultat_calcul").style.backgroundColor = "yellow";
					var tmp_resLite = (( Math.floor(tmp_res / indice_valo) )*indice_valo).toFixed(0);
					if( (tmp_res - tmp_resLite) == 0){$("resultat_calcul").value = tmp_resLite;}
					else{$("resultat_calcul").value = tmp_res;}
				}else{
					//$("resultat_calcul").style.backgroundColor = "green";
					tmp_res = ((Math.floor(tmp_res/indice_valo)+1)*indice_valo).toFixed(nb_decimale); 
					var tmp_resLite = ((Math.floor(tmp_res/indice_valo)+1)*indice_valo).toFixed(0);
					if( (tmp_res - tmp_resLite) == 0){$("resultat_calcul").value = tmp_resLite;}
					else{$("resultat_calcul").value = tmp_res;}
				}
			}else{
				//$("resultat_calcul").style.backgroundColor = "blue";
				var tmp_res = ( multi * colli ).toFixed(nb_decimale);
				var tmp_resLite = ( multi * colli ).toFixed(0);
				if( (tmp_res - tmp_resLite) == 0){$("resultat_calcul").value = tmp_resLite;}
				else{$("resultat_calcul").value = tmp_res;}
			}
		}
	}

	//On calcul le résultat à l'ouverture de la pop-up
	calculResultat();
	
	Event.observe("choix_collisage", "change", function(evt){
		Event.stop(evt);
		calculResultat();
	}, false);


	Event.observe("multiplicateur", "blur", function(evt){
		Event.stop(evt);
		if (!isNaN(parseFloat($("multiplicateur").value))){
			$("multiplicateur").style.backgroundColor = "";
			calculResultat();
		}else{
			$("multiplicateur").style.backgroundColor = "#cd5c5c";
		}
	}, false);

	
	Event.observe("resultat_calcul", "blur", function(evt){
		Event.stop(evt);
		if (!isNaN(parseFloat($("resultat_calcul").value))){
			$("resultat_calcul").style.backgroundColor = "";
		}else{
			$("resultat_calcul").style.backgroundColor = "#cd5c5c";
		}
	}, false);

	
	Event.observe("calcul_qte_valider", "click", function(evt){
		Event.stop(evt);
		if (!isNaN(parseFloat($("resultat_calcul").value))){
			// Quantité normale
			var qte = (parseFloat($("resultat_calcul").value));
			// Quantité raccourcis ex : 2.00 devient 2
			var qteLite = (parseFloat($("resultat_calcul").value)).toFixed(0);
			if(qte == parseFloat(qteLite)){
				window.parent.document.getElementById("<?php echo $cible;?>").value = qteLite;
			}else{
				window.parent.document.getElementById("<?php echo $cible;?>").value = qte;
			}
			$("resultat_calcul").style.backgroundColor = "";
			window.parent.document.getElementById("pop_up_options").style.display = "none";
		}else{
			$("resultat_calcul").style.backgroundColor = "#cd5c5c";
		}
	}, false);

	<?php if ($indice_valo > 0){ ?>
	Event.observe("appli_indice_valo", "change", function(evt){
		calculResultat();
	}, false);
	<?php }?>
</script>
<?php  /*
<table width="100%" border="0">
	<tr>
		<td style="width: 3%"></td>
		<td style="width:15"></td>
		<td style="width:64%"></td>
		<td style="width:15%; text-align:right;">
			<img id="calcul_valider" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
			<script type="text/javascript">
				Event.observe("calcul_valider", "click", function(evt){
					Event.stop(evt);

					if (!isNaN(parseFloat($("resultat_calcul").value))){
						var qte = (parseFloat($("resultat_calcul").value)).toFixed(2);
						var qteLite = (parseFloat($("resultat_calcul").value)).toFixed(0);
						if(qte == parseFloat(qteLite)){
							window.parent.document.getElementById("<?php echo $cible;?>").value = qteLite;
						}else{
							window.parent.document.getElementById("<?php echo $cible;?>").value = qte;
						}
							window.parent.document.getElementById("pop_up_options").style.display = "none";
						}else{
							alert("resultat");
						}
					}, false);
				</script>
			</td>
		<td style="width: 3%"></td>
	</tr>
</table>
*/ ?>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>