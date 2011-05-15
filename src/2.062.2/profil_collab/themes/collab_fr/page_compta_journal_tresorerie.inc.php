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
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>


<div id="pop_up_compta_verify" class="compte_compta_verify" style="display:none">
	<a href="#" id="close_compta_verify" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
	<span style="font-weight:bolder">Vérification automatique des journaux de trésorerie.</span><br />
<br />
	<br />
	(cette opération peut durer plusieurs minutes)<br />

	<div id="aff_compta_verify" style="overflow:auto; height:430px">
			
			<SCRIPT type="text/javascript">
		
			Event.observe("verify_journal_start", "click", function(evt){
				Event.stop(evt);
				$("verify_journal_start").hide();
				$("progverify").style.width = "0%"
				$("verify_journal").show();
				var AppelAjax = new Ajax.Updater(
									"verify_journal", 
									"compta_journal_tresorerie_verify.php", {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { recherche: '1', date_fin : $("date_fin").value, date_debut : $("date_debut").value, date_exercice: $("date_exercice").value, page_to_show: '1'},
									evalScripts:true, 
									onLoading:S_loading,
									onComplete:H_loading}
									);
			}, false);
			</SCRIPT>
			<div style="text-align:left;">
			<div class="progress_barre"><div class="files_progress" id="progverify"></div></div>
			<div id="verify_journal" style="display:none"></div><br />

			<span id="verify_journal_start" style="display:block;  text-decoration:underline;cursor:pointer">Lancer la vérification automatique des journaux de trésorerie pour la période sélectionnée</span>
			</div>
		</div>
	
	
	</div>
	
	<script type="text/javascript">
	Event.observe("close_compta_verify", "click",  function(evt){Event.stop(evt); close_compta_verify();}, false);
	//centrage du mini_moteur
	centrage_element("pop_up_compta_verify");
	Event.observe(window, "resize", function(evt){
	centrage_element("pop_up_compta_verify");
	});
	</script>
</div>
<div class="emarge">
<div class="titre">Journaux de Trésorerie </div>

<div class="articletview_corps" id="grand_livre_conteneur" >
	<div style="padding:8px">
<!--	<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif"  onclick="javascript:window.print()"/>-->
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td></td>
			<td><div style="width:180px; text-align:right;" >Type de journaux</div></td>
			<td>
			<select id="id_journal" name="id_journal" class="classinput_nsize">
				<OPTGROUP disabled="disabled" label="JOUNAUX DE BANQUE" ></OPTGROUP>
				<?php 
					foreach ( $liste_journaux as $journal) {
						if  ($journal->id_journal_parent != $DEFAUT_ID_JOURNAL_BANQUES) {continue;}
						?>
						<option value="<?php echo $journal->id_journal;?>" ><?php echo $journal->lib_journal." ".$journal->contrepartie;?></option>
						<?php 
					}
				?>
				<OPTGROUP disabled="disabled" label="JOUNAUX DE CAISSE" ></OPTGROUP>
				<?php 
					foreach ( $liste_journaux as $journal) {
						if  ($journal->id_journal_parent != $DEFAUT_ID_JOURNAL_CAISSES) {continue;}
						?>
						<option value="<?php echo $journal->id_journal;?>" ><?php echo $journal->lib_journal." ".$journal->contrepartie;?></option>
						<?php 
					}
				?>
			</select>
			</td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp;</td>
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
			<span id="open_verifi_journal" style="cursor:pointer; text-decoration:underline">Vérifier les journaux</span>
			<SCRIPT type="text/javascript">
			Event.observe("open_verifi_journal", "click", function(evt){
				ouvre_compta_verify();
			}, false);
			</SCRIPT>
			</td>
		</tr>
		<tr>
			<td></td>
			<td style=" text-align:right;">P&eacute;riode:&nbsp;&nbsp; </td>
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
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td style="text-align:right; width:70%">
		 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="Imprimer" title="Imprimer" style="cursor:pointer" id="print_grand_livre"/>
		 
		 </td>
		</tr>
		<tr>
			<td><input type="hidden" id="ref_contact" name="ref_contact" value=""  />
			
			</td>
			<td style="text-align:right">du&nbsp; </td>
			<td><input type="text" id="date_debut" name="date_debut" value="" class="classinput_nsize" /></td>
			<td>&nbsp;</td>
			<td>au&nbsp; </td>
			<td><input type="text" id="date_fin" name="date_fin" value="" class="classinput_nsize" /></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" id="reload_grand_livre" style="cursor:pointer;"/></td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
		</tr>
	</table>
	<br />
	
		
		<div id="compta_journal_tresorerie_result_content" style="OVERFLOW-Y: auto; OVERFLOW-X: auto;">
		
		</div>
		
		<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
	</div>
</div>
</div>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<SCRIPT type="text/javascript">
//centrage de l'editeur
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");
});

	Event.observe("print_grand_livre", "click", function(evt){
		Event.stop(evt);
		window.open ("compta_journal_tresorerie_result.php?recherche=1&print=1&page_to_show_s="+$("page_to_show_s").value+"&ref_contact="+$("ref_contact").value+"&date_fin="+$("date_fin").value+"&date_debut="+$("date_debut").value+"&date_exercice="+$("date_exercice").value+"&id_journal="+$("id_journal").value, "_blank");
	}, false);

//masque de date

	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("reload_grand_livre", "click", function(evt){
		Event.stop(evt);
		$("page_to_show_s").value = "1";
		compta_journal_tresorerie_result ();
	}, false);
	Event.observe("date_exercice", "change", function(evt){
		Event.stop(evt);
		$("page_to_show_s").value = "1";
		compta_journal_tresorerie_result_byexercice ();
	}, false);
	Event.observe("id_journal", "change", function(evt){
		Event.stop(evt);
		$("page_to_show_s").value = "1";
		compta_journal_tresorerie_result_byexercice ();
	}, false);
	
function setheight_grand_livre(){
set_tomax_height("grand_livre_conteneur" , -32);
set_tomax_height("compta_journal_tresorerie_result_content" , -42);
}
Event.observe(window, "resize", setheight_grand_livre, false);
setheight_grand_livre();

compta_journal_tresorerie_result_byexercice ();
//on masque le chargement
H_loading();
</SCRIPT>