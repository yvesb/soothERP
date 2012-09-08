
<br />
<span class="labelled_text" style="font-weight:bolder">Service prepayés :</span>
<table style="width:100%">
	<tr>
		<td style="width:40%" class="labelled_text">Durée de validité: </td>
		<td style="width:36%">
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
			<td>
			<input type="text" name="m_duree_validite_mois" id="m_duree_validite_mois" value="0" size="3"  class="classinput_nsize"/>&nbsp;mois 
			</td>
			<td>
			<input type="text" name="m_duree_validite_jour" id="m_duree_validite_jour" value="0" size="3"  class="classinput_nsize"/>&nbsp;jours
			</td>
			</tr>
			</table>
		</td>
		<td style="width:29%"></td>
	</tr>
 <tr>
		<td style="width:40%" class="labelled_text">Nombre de crédits: </td>
		<td style="width:36%">
			<input type="text" name="m_nb_credits" id="m_nb_credits" value="1" size="3"  class="classinput_nsize"/>
		</td>
		<td style="width:29%"></td>
	</tr>
	<tr>
		<td class="labelled_text"></td>
		<td>&nbsp;</td>
		<td ></td>
	</tr>
</table>

<SCRIPT type="text/javascript">
 Event.observe("m_duree_validite_mois", "blur", function(evt){
 	nummask(evt,"0", "X");
 }, false);
 Event.observe("m_duree_validite_jour", "blur", function(evt){nummask(evt,"0", "X");
 }, false);
 Event.observe("m_nb_credits", "blur", function(evt){nummask(evt,"1", "X");
 }, false);
 
$("mod_modele").value = "<?php echo $art_categs->getModele ();?>";
//on masque le chargement
H_loading();
</SCRIPT>