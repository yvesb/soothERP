<?php

// *************************************************************************************************************
// situation des commerciaux
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);


function nb_mois($date1, $date2) {
   list($year1,$month1,$day1) = explode("-",$date1);
   list($year2,$month2,$day2) = explode("-",$date2);
   return (($year2-$year1)*12 + ($month2-$month1));
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">	
</script>


<div class="emarge">
<div id="pop_up_commerciaux_det" style="display:none" class="mini_moteur_comm">
</div>
<div class="titre">Situation Commerciaux</div>

<div class="articletview_corps" id="compta_situation_commerciaux_conteneur" >
	<div style="padding:8px">
<!--	<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif"  onclick="javascript:window.print()"/>-->
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td></td>
			<td style="width:85px">P&eacute;riode:&nbsp;&nbsp; </td>
			<td colspan="2">
			<select id="date_exercice" name="date_exercice" class="classinput_nsize">
			<?php
			for($i = 0; $i< count($liste_exercices); $i++) {
				//décompte du nombre de mois en deux exercices
				$date1 = date("Y-m-d",strtotime($liste_exercices[$i]->date_fin));
				if (isset($liste_exercices[$i+1])) {
					
					$date2 = date("Y-m-d", strtotime($liste_exercices[$i+1]->date_fin));
					$date1_debut = date("Y-m-d", mktime(0, 0, 0, date("m" ,strtotime($date2)) , date("d" ,strtotime($date2))+1 , date ("Y", strtotime($date2)) ));
				} else {
					$date2 = $ENTREPRISE_DATE_CREATION;				
					$date1_debut = $date2;
				}
				//affichage de l'exercice
				?>
				<option value="<?php echo $date1_debut.";".$date1; ?>" style="font-weight:bolder;<?php 
							if (!$liste_exercices[$i]->etat_exercice) {
								?>color: #999999;<?php
							} else {
								if ($liste_exercices[$i]->date_fin >= date("Y-m-d")) {
									?>color: #66CC33;<?php
								} else {
									?>color: #CC3333;<?php
								}
							}
							?>"><?php echo $liste_exercices[$i]->lib_exercice;?></option>
				<?php 
				
				for ($j = 0; $j <= nb_mois($date2, $date1); $j++) {
					$mois = date("Y-m-d", mktime(0, 0, 0, round(date("m" ,strtotime($date1))-$j) , 1, date ("Y", strtotime($date1)) ) );
					$mois_fin = date("Y-m-d", mktime(0, 0, 0, round(date("m" ,strtotime($date1))-$j+1) , 0, date ("Y", strtotime($date1)) ) );
					setlocale(LC_TIME, $INFO_LOCALE);
					?>
					<option value="<?php if (date("Y-m", strtotime($mois)) == date("Y-m",  strtotime($date1_debut)) ) {echo $date1_debut;} else {echo $mois;}?>;<?php if ($j == 0) {echo $date1;} else {echo $mois_fin;}?>"><?php echo lmb_strftime("%B %Y", $INFO_LOCALE, strtotime($mois))." " ;?></option>
					<?php 
					if (date("Y-m", strtotime($mois)) == date("Y-m",  strtotime($date1_debut)) ) {break;}
				}
				?>
			
				<?php 
			}
			?>
			</select>
			</td>
			<td></td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td style="text-align:right">
			
			<span id="imprimer_recap_comm" style="cursor:pointer; text-decoration:underline">Imprimer le récapitulatif</span>
			<br />
			<span id="imprimer_resultats_commerciaux" style="cursor:pointer; text-decoration:underline">Imprimer les résultats des commerciaux</span>
			<br />
			<span id="exporter_resultats_commerciaux" style="cursor:pointer; text-decoration:underline">Exporter les résultats des commerciaux</span>
			<SCRIPT type="text/javascript">
			Event.observe("imprimer_recap_comm", "click", function(evt){
				Event.stop(evt);
				window.open ("compta_situation_commerciaux_result.php?recherche=1&print=1&page_to_show_s="+$("page_to_show_s").value+"&date_fin="+$("date_fin").value+"&date_debut="+$("date_debut").value+"&date_exercice="+$("date_exercice").value, "_blank");
			}, false);
			
			Event.observe("imprimer_resultats_commerciaux", "click", function(evt){
				Event.stop(evt);
				window.open ("situation_commerciaux_result_editing.php?recherche=1&print=2&page_to_show_s="+$("page_to_show_s").value+"&date_fin="+$("date_fin").value+"&date_debut="+$("date_debut").value+"&date_exercice="+$("date_exercice").value, "_blank");
			}, false);
			
			Event.observe('exporter_resultats_commerciaux', "click", function(evt){
				$("pop_up_export_com").style.display = "";
				page.traitecontent("pop_up_export_com","com_export.php?recherche=1&print=2&page_to_show_s="+$("page_to_show_s").value+"&date_fin="+$("date_fin").value+"&date_debut="+$("date_debut").value+"&date_exercice="+$("date_exercice").value,"true","pop_up_export_com");
				Event.stop(evt);
			});
			//centrage de la pop up comm
			centrage_element("pop_up_export_com");

			Event.observe(window, "resize", function(evt){
			centrage_element("pop_up_export_com");
			});
			//on masque le chargement
			H_loading();
			</SCRIPT>
			<?php
			include ("page_com_export.php");
			?>
			</td>
		</tr>
		<tr>
			<td>
			
			</td>
			<td style="text-align:right">du&nbsp; </td>
			<td><input type="text" id="date_debut" name="date_debut" value="" class="classinput_nsize" /></td>
			<td>&nbsp;</td>
			<td>au&nbsp; </td>
			<td><input type="text" id="date_fin" name="date_fin" value="" class="classinput_nsize" /></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" id="reload_comm_recap" style="cursor:pointer;"/></td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp; </td>
			<td colspan="4">
			</td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td style="text-align:right; width:70%">
		 
		 </td>
		</tr>
	</table>
	<br />
	
		
	<div class="emarge">
	<table width="100%" border="0" cellspacing="4" cellpadding="2">
		<tr>
			<td style="width:25%; font-weight:bolder; text-align:left">Commercial</td>
			<td style="width:20%; font-weight:bolder; text-align:center; ">CA</td>
			<td style="width:20%; font-weight:bolder; text-align:center">Marge</td>
			<td style="width:20%; font-weight:bolder; text-align:center">Commission</td>
			<td style="font-weight:bolder; text-align:center" colspan="3">Action</td>
		</tr>
	</table>
	</div>
		<div id="compta_situation_commerciaux_result_content" style="OVERFLOW-Y: auto; OVERFLOW-X: auto;">
		
		</div>
		
		<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
	</div>
</div>
</div>
<SCRIPT type="text/javascript">

//masque de date

	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("reload_comm_recap", "click", function(evt){
		Event.stop(evt);
		$("page_to_show_s").value = "1";
		compta_situation_commerciaux_result ();
	}, false);
	Event.observe("date_exercice", "change", function(evt){
		Event.stop(evt);
		$("page_to_show_s").value = "1";
		compta_situation_commerciaux_result_byexercice ();
	}, false);
	
function setheight_commerciaux(){
set_tomax_height("compta_situation_commerciaux_conteneur" , -32);
set_tomax_height("compta_situation_commerciaux_result_content" , -42);
}
Event.observe(window, "resize", setheight_commerciaux, false);
setheight_commerciaux();


//centrage de la pop up comm
centrage_element("pop_up_commerciaux_det");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_commerciaux_det");
});


compta_situation_commerciaux_result_byexercice ();
//on masque le chargement
H_loading();
</SCRIPT>
