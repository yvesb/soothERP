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
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_facture_mini.inc.php" ?>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>


<div id="pop_up_compta_verify" class="compte_compta_verify" style="display:none">
	<a href="#" id="close_compta_verify" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
	<span style="font-weight:bolder">Vérification automatique du journal.</span><br />
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
									"compta_journal_ventes_verify.php", {
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

			<span id="verify_journal_start" style="display:block;  text-decoration:underline;cursor:pointer">Lancer la vérification automatique du journal pour la période sélectionnée</span>
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
<div class="titre">Journal des ventes <?php if (isset($_REQUEST["ref_contact"])) { echo $contact->getNom(); } ?></div>

<div class="articletview_corps" id="grand_livre_conteneur" >
	<div style="padding:8px">
<!--	<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif"  onclick="javascript:window.print()"/>-->
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td></td>
			<td style="width:285px">P&eacute;riode:&nbsp;&nbsp; </td>
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
			<td style="text-align:right">
			<span id="open_verifi_journal" style="cursor:pointer; text-decoration:underline">Vérifier le journal</span>
			<SCRIPT type="text/javascript">
			Event.observe("open_verifi_journal", "click", function(evt){
				ouvre_compta_verify();
			}, false);
			</SCRIPT>
			</td>
		</tr>
		<tr>
			<td><input type="hidden" id="ref_contact" name="ref_contact" value="<?php if (isset($_REQUEST["ref_contact"])) { echo $contact->getRef_contact(); } ?>"  />
			
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
		<tr>
			<td></td>
			<td></td>
			<td colspan="4"></td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td style="text-align:right; width:70%">
		 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="Imprimer" title="Imprimer" style="cursor:pointer" id="print_grand_livre"/></td>
		</tr>
		<tr>
			<td></td>
			<td>Numéro&nbsp;de&nbsp;compte:&nbsp;&nbsp;
			</td>
			<td colspan="4"><input type="text" id="numero_compte" name="numero_compte" value="" class="classinput_nsize" />
			</td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td style="text-align:right; width:70%">
		 
		 </td>
		</tr>
	</table>
	<br />
	
		
		<div id="compta_journal_ventes_result_content" style="OVERFLOW-Y: auto; OVERFLOW-X: auto;">
		
		</div>
		
		<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
	</div>
</div>
</div>
<SCRIPT type="text/javascript">

	Event.observe("print_grand_livre", "click", function(evt){
		Event.stop(evt);
		window.open ("compta_journal_ventes_result.php?recherche=1&print=1&page_to_show_s="+$("page_to_show_s").value+"&ref_contact="+$("ref_contact").value+"&numero_compte="+$("numero_compte").value+"&date_fin="+$("date_fin").value+"&date_debut="+$("date_debut").value+"&date_exercice="+$("date_exercice").value, "_blank");
	}, false);

function submit_simple_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:  
		$("page_to_show_s").value = "1";
		compta_journal_ventes_result_byexercice ();
		Event.stop(event);
	break;   
	}
}
	Event.observe("numero_compte", "keypress", function(evt){
		 submit_simple_if_Key_RETURN (evt);
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
		compta_journal_ventes_result ();
	}, false);
	Event.observe("date_exercice", "change", function(evt){
		Event.stop(evt);
		$("page_to_show_s").value = "1";
		compta_journal_ventes_result_byexercice ();
	}, false);
	
function setheight_grand_livre(){
set_tomax_height("grand_livre_conteneur" , -32);
set_tomax_height("compta_journal_ventes_result_content" , -42);
}
Event.observe(window, "resize", setheight_grand_livre, false);
setheight_grand_livre();

compta_journal_ventes_result_byexercice ();
//on masque le chargement
H_loading();
</SCRIPT>