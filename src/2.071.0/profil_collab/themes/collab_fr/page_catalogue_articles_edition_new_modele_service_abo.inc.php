<br />
<span class="labelled_text" style="font-weight:bolder">Abonnement :</span>
<table style="width:100%">
	<tr>
		<td style="width:40%" class="labelled_text">Durée de l'abonnement: </td>
		<td style="width:36%">
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
			<td>
			<input type="text" name="m_duree_abo_mois" id="m_duree_abo_mois" value="0" size="3"  class="classinput_nsize"/>&nbsp;mois 
			</td>
			<td>
			<input type="text" name="m_duree_abo_jour" id="m_duree_abo_jour" value="0" size="3"  class="classinput_nsize"/>&nbsp;jours
			</td>
			</tr>
			</table>
		</td>
		<td style="width:29%"></td>
	</tr>
	<tr>
		<td class="labelled_text">Engagement initial:</td>
		<td>
			<input type="text" name="m_engagement" id="m_engagement" value="0" size="3" class="classinput_nsize"/> x <span id="duree_eng">0</span> mois <span id="duree_eng_j">0</span> jours
		</td>
		<td></td>
	</tr>
	<tr>
		<td class="labelled_text">Réengagement automatique: </td>
		<td>
			<input type="text" name="m_reconduction" id="m_reconduction" value="0" size="3" class="classinput_nsize"/> x <span id="duree_rec">0</span> mois <span id="duree_rec_j">0</span> jours
		</td>
		<td></td>
	</tr>
	<tr>
		<td class="labelled_text">Délai du préavis avant résiliation: </td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
			<td>
			<input type="text" name="m_preavis_abo_mois" id="m_preavis_abo_mois" value="0" size="3"  class="classinput_nsize"/>&nbsp;mois </td>
			<td>
			<input type="text" name="m_preavis_abo_jour" id="m_preavis_abo_jour" value="0" size="3"  class="classinput_nsize"/>&nbsp;jours
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
 Event.observe("m_duree_abo_mois", "blur", function(evt){
 	nummask(evt,"0", "X");
 	$("duree_eng").innerHTML = $("m_duree_abo_mois").value;
 	$("duree_rec").innerHTML = $("m_duree_abo_mois").value;
 }, false);
 Event.observe("m_duree_abo_jour", "blur", function(evt){nummask(evt,"0", "X");
 	$("duree_eng_j").innerHTML = $("m_duree_abo_jour").value;
 	$("duree_rec_j").innerHTML = $("m_duree_abo_jour").value;
 }, false);
 Event.observe("m_engagement", "blur", function(evt){nummask(evt,"0", "X");}, false);
 Event.observe("m_reconduction", "blur", function(evt){nummask(evt,"", "X");}, false);
 Event.observe("m_preavis_abo_mois", "blur", function(evt){nummask(evt,"0", "X");}, false);
 Event.observe("m_preavis_abo_jour", "blur", function(evt){nummask(evt,"0", "X");}, false);

 
$("mod_modele").value = "<?php echo $art_categs->getModele ();?>";
//on masque le chargement
H_loading();
</SCRIPT>