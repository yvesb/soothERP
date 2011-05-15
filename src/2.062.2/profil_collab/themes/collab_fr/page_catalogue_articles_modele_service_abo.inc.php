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

?><br />
<span class="labelled_text" style="font-weight:bolder">Abonnement :</span>
<table style="width:100%">
	<tr>
		<td style="width:40%" class="labelled_text">Durée de l'abonnement: </td>
		<td style="width:36%">
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
			<td>
			<input type="text" name="duree_abo_mois" id="duree_abo_mois" value="0" size="3"  class="classinput_nsize"/>&nbsp;mois 
			</td>
			<td>
			<input type="text" name="duree_abo_jour" id="duree_abo_jour" value="0" size="3"  class="classinput_nsize"/>&nbsp;jours
			</td>
			</tr>
			</table>
		</td>
		<td style="width:29%"></td>
	</tr>
	<tr>
		<td class="labelled_text">Engagement initial:</td>
		<td>
			<input type="text" name="engagement" id="engagement" value="0" size="3" class="classinput_nsize"/> x <span id="duree_eng">0</span> mois <span id="duree_eng_j">0</span> jours
		</td>
		<td></td>
	</tr>
	<tr>
		<td class="labelled_text">Réengagement automatique: </td>
		<td>
			<input type="text" name="reconduction" id="reconduction" value="0" size="3" class="classinput_nsize"/> x <span id="duree_rec">0</span> mois <span id="duree_rec_j">0</span> jours
		</td>
		<td></td>
	</tr>
	<tr>
		<td class="labelled_text">Délai du préavis avant résiliation: </td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
			<td>
			<input type="text" name="preavis_abo_mois" id="preavis_abo_mois" value="0" size="3"  class="classinput_nsize"/>&nbsp;mois </td>
			<td>
			<input type="text" name="preavis_abo_jour" id="preavis_abo_jour" value="0" size="3"  class="classinput_nsize"/>&nbsp;jours
			</td>
			</tr>
			</table>
		</td>
		<td></td>
	</tr>
	<tr>
		<td class="labelled_text"></td>
		<td>&nbsp;</td>
		<td ></td>
	</tr>
</table>


<SCRIPT type="text/javascript">
$("modele").value="<?php echo $id_modele;?>";
 Event.observe("duree_abo_mois", "blur", function(evt){
 	nummask(evt,"0", "X");
 	$("duree_eng").innerHTML = $("duree_abo_mois").value;
 	$("duree_rec").innerHTML = $("duree_abo_mois").value;
 }, false);
 Event.observe("duree_abo_jour", "blur", function(evt){nummask(evt,"0", "X");
 	$("duree_eng_j").innerHTML = $("duree_abo_jour").value;
 	$("duree_rec_j").innerHTML = $("duree_abo_jour").value;
 }, false);
 Event.observe("engagement", "blur", function(evt){nummask(evt,"0", "X");}, false);
 Event.observe("reconduction", "blur", function(evt){nummask(evt,"", "X");}, false);
 Event.observe("preavis_abo_mois", "blur", function(evt){nummask(evt,"0", "X");}, false);
 Event.observe("preavis_abo_jour", "blur", function(evt){nummask(evt,"0", "X");}, false);

 
//on masque le chargement
H_loading();
</SCRIPT>