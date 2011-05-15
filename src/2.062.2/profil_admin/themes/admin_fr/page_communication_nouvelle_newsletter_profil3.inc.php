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

?>
<script type="text/javascript" language="javascript">
</script>
<div class=""> 
	<p class="titre_config">Critères Collaborateurs</p>
	<div class="reduce_in_edit_mode">
		<table class="minimizetable">
			<tr>
				<td  style="width:180px"></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<?php
				if(empty($liste_fonctions_collab))  {
					?>
					<td>
					</td>
					<td>
					<input type="checkbox" value="0" id="tous_collab" name="tous_collab" checked="checked" disabled>Tous les collaborateurs.
					</td>
					<?php
				} else {
					?>
					<td>
					<span>Fonctions:</span>
					</td>
					<td>
					<input type="checkbox" value="0" id="tous_collab" name="tous_collab" checked="checked" >Toutes 
					<script type="text/javascript">
					new Event.observe("tous_collab", "click", function(){
						if ($("tous_collab").checked) {
							
						<?php
						foreach ($liste_fonctions_collab as $fct_collab) {
							?>
							$("collab_fonction_<?php echo $fct_collab->id_fonction;?>").checked = "";
							<?php
						}
						?>
						}
					}, false);
					</script>
					</td>
			</tr>
			<tr>
					<td >
					</td><td>
					<?php
					foreach ($liste_fonctions_collab as $fct_collab) {
						?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="<?php echo 10*$fct_collab->indentation;?>px"/>
						<input type="checkbox" name="collab_fonction_<?php echo $fct_collab->id_fonction;?>" id="collab_fonction_<?php echo $fct_collab->id_fonction;?>" value="<?php echo $fct_collab->id_fonction;?>" /><?php echo ($fct_collab->lib_fonction);?>
						
					<script type="text/javascript">
					new Event.observe("collab_fonction_<?php echo $fct_collab->id_fonction;?>", "click", function(){
						if ($("collab_fonction_<?php echo $fct_collab->id_fonction;?>").checked) {
							$("tous_collab").checked = "";
						}
					}, false);
					</script>
						<br />
						<?php
					}
					?>
					</td>
					<?php 
				} 
				?>
			</tr>
		</table>
	</div>
</div>

<script type="text/javascript">
//on masque le chargement
H_loading();
</script>