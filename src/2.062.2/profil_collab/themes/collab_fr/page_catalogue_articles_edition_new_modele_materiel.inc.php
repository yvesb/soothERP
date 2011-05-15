<br />

	<table style="width:100%">
		<tr>
			<td style="width:40%" class="labelled_text">Poids: </td>
			<td style="width:16%"><input type="text" name="m_poids" id="m_poids" value="<?php if (isset($article)) { echo $article->getPoids ();}?>"  class="classinput_xsize"/></td>
			<td style="width:49%">Kg</td>
		</tr>
		<tr>
			<td class="labelled_text">Colisage:</td>
			<td>
				<input type="text" name="m_colisage" id="m_colisage" value="<?php if (isset($article)) { echo $article->getColisage ();}?>"  class="classinput_xsize"/>			</td>
			<td >Ex: 1;5;20</td>
		</tr>
		<tr>
			<td class="labelled_text">Dur&eacute;e de Garantie: </td>
			<td><input type="text" name="m_dure_garantie" id="m_dure_garantie" value="<?php if (isset($article)) { echo $article->getDuree_garantie ();} else { echo $DEFAUT_GARANTIE;}?>"  class="classinput_xsize"/></td>
			<td >mois</td>
		</tr>
		
	</table>

<SCRIPT type="text/javascript">

Event.observe("m_poids", "blur", function(evt){nummask(evt,"0", "X.X");}, false);

Event.observe("m_dure_garantie", "blur", function(evt){nummask(evt,"<?php if (isset($article)) { echo $article->getDuree_garantie ();} else {echo "12";}?>", "X");}, false);

 Event.observe("m_colisage", "blur", function(evt){nummask(evt,"<?php if (isset($article)) { echo $article->getColisage ();}?>", "X.XX;X.XX");}, false);		


$("mod_modele").value = "<?php echo $art_categs->getModele ();?>";
//on masque le chargement
H_loading();
</SCRIPT>