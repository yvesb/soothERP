<?php

// *************************************************************************************************************
//journal des ventes
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
<div class="titre">Grand livre clients</div>

<div class="articletview_corps" id="grand_livre_conteneur" >
	<div style="padding:8px">
<!--	<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif"  onclick="javascript:window.print()"/>-->
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td></td>
			<td style="width:285px; text-align:right">P&eacute;riode:&nbsp;&nbsp; </td>
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
			<td style="text-align:right">
			</td>
		</tr>
		<tr>
			<td></td>
			<td style="width:385px">&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td style="text-align:right">
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
			<td></td>
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
			</td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align:right">Comptes non équilibrés uniquement:</td>
			<td colspan="4"><input type="checkbox" id="equi" name="equi" value="1" /></td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td style="text-align:right; width:590px ">
		 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="Imprimer" title="Imprimer" style="cursor:pointer" id="print_grand_livre"/></td>
		</tr>
		
	</table>
	<br />
	
		
	</div>
</div>
</div>
<SCRIPT type="text/javascript">

	Event.observe("print_grand_livre", "click", function(evt){
		Event.stop(evt);
		equi = "&equi=0";
		if ($("equi").checked) {equi = "&equi=1";}
		window.open ("compta_extrait_compte_contact_solde_det.php?id_profil=clients&date_fin="+$("date_fin").value+"&date_debut="+$("date_debut").value+"&date_exercice="+$("date_exercice").value+equi, "_blank");
	}, false);


//masque de date
	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
	
	Event.observe("date_exercice", "change", function(evt){
		Event.stop(evt);
		$("date_debut").value = "";
		$("date_fin").value = "";
	}, false);
	

//on masque le chargement
H_loading();
</SCRIPT>