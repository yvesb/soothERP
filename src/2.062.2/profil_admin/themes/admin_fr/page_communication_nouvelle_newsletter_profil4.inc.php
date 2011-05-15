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
	<p class="titre_config" >Critères Clients</p>
	<div class="reduce_in_edit_mode">
		<table class="minimizetable">
			<tr>
				<td style="width:180px"></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td>Catégorie: </span>
				</td>
				<td>
					<input type="checkbox" name="toutes_client_categorie" id="toutes_client_categorie" value="" checked="checked" />Toutes<br />
					<script type="text/javascript">
					new Event.observe("toutes_client_categorie", "click", function(){
						if ($("toutes_client_categorie").checked) {
							
						<?php
						foreach ($ANNUAIRE_CATEGORIES as $categorie) {
							?>
							$("client_categorie_<?php echo $categorie->id_categorie;?>").checked = "";
							<?php
						}
						?>
						}
					}, false);
					</script>
				<?php 
				foreach ($ANNUAIRE_CATEGORIES as $categorie) {
					?>
					<input type="checkbox" name="client_categorie_<?php echo $categorie->id_categorie;?>" id="client_categorie_<?php echo $categorie->id_categorie;?>" value="<?php echo $categorie->id_categorie;?>" /><?php echo $categorie->lib_categorie;?>
						
					<script type="text/javascript">
					new Event.observe("client_categorie_<?php echo $categorie->id_categorie;?>", "click", function(){
						if ($("client_categorie_<?php echo $categorie->id_categorie;?>").checked) {
							$("toutes_client_categorie").checked = "";
						}
					}, false);
					</script><br />
					<?php
				}
				?>
				</td>
			</tr>
			<tr>
				<td colspan="2"  class="undered_titre_config">
				</td>
			</tr>
			<tr>
				<td>Type de client : </span>
				</td>
				<td>
					<input type="checkbox" name="tous_client_type" id="tous_client_type" value="" checked="checked" />Tous<br />
					<script type="text/javascript">
					new Event.observe("tous_client_type", "click", function(){
						if ($("tous_client_type").checked) {
							$("client_type_piste").checked = "";
							$("client_type_prospect").checked = "";
							$("client_type_client").checked = "";
							$("client_type_ancien").checked = "";
						}
					}, false);
					</script>
					<input type="checkbox" name="client_type_piste" id="client_type_piste" value="piste" /> Piste<br />
					<input type="checkbox" name="client_type_prospect" id="client_type_prospect"  value="prospect"/> Prospect<br />
					<input type="checkbox" name="client_type_client" id="client_type_client" value="client"/> Client<br />
					<input type="checkbox" name="client_type_ancien" id="client_type_ancien"  value="ancien client"/> Ancien client<br />
					<input type="checkbox" name="client_type_bloque" id="client_type_bloque"  value="Compte bloqué"/> Compte bloqué<br />
					<script type="text/javascript">
					new Event.observe("client_type_piste", "click", function(){
						if ($("client_type_piste").checked) {
							$("tous_client_type").checked = "";
						}
					}, false);
					new Event.observe("client_type_prospect", "click", function(){
						if ($("client_type_prospect").checked) {
							$("tous_client_type").checked = "";
						}
					}, false);
					new Event.observe("client_type_client", "click", function(){
						if ($("client_type_client").checked) {
							$("tous_client_type").checked = "";
						}
					}, false);
					new Event.observe("client_type_ancien", "click", function(){
						if ($("client_type_ancien").checked) {
							$("tous_client_type").checked = "";
						}
					}, false);
					new Event.observe("client_type_bloque", "click", function(){
						if ($("client_type_bloque").checked) {
							$("tous_client_type").checked = "";
						}
					}, false);
					</script>
				</td>
			</tr>
			<tr>
				<td colspan="2"  class="undered_titre_config">
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled_ralonger">Catégorie de client : </span>
				</td>
				<td>
				<?php
				if(empty($liste_categories_clients))  {
					?>
					<input type="checkbox" value="0" id="tous_client" name="tous_client" checked="yes" disabled> Toutes les catégories.
					<?php
				}	else {
					?>
					
					<input type="checkbox" name="tous_client" id="tous_client" value="" checked="checked" />Toutes<br />
					<script type="text/javascript">
					new Event.observe("tous_client", "click", function(){
						if ($("tous_client").checked) {
							
						<?php
						foreach ($liste_categories_clients as $cat_client) {
							?>
							$("client_categ_<?php echo $cat_client->id_client_categ;?>").checked = "";
							<?php
						}
						?>
						}
					}, false);
					</script>
					<?php 
					foreach ($liste_categories_clients as $cat_client) {
					?>
					<input type="checkbox" name="client_categ_<?php echo $cat_client->id_client_categ;?>" id="client_categ_<?php echo $cat_client->id_client_categ;?>" value="<?php echo $cat_client->id_client_categ;?>" /><?php echo ($cat_client->lib_client_categ);?>
					<script type="text/javascript">
					new Event.observe("client_categ_<?php echo $cat_client->id_client_categ;?>", "click", function(){
						if ($("client_categ_<?php echo $cat_client->id_client_categ;?>").checked) {
							$("tous_client").checked = "";
						}
					}, false);
					</script>
					<br />
					<?php
					}
				}
				?>
				</td>
			</tr>
			<tr>
				<td colspan="2"  class="undered_titre_config">
				</td>
			</tr>
			<tr>
				<td>
				<span >Code postal ou département:</span>
				</td>
				<td>
				<span class="infobulle" id="client_cp_info">
				<iframe frameborder="0" scrolling="no" src="about:_blank"></iframe>
				<span>
				<p class="infotext">S&eacute;parez les valeurs par des &apos;;&apos;<br/>Exemple 1 : 75;94190 <br/>Exemple 2 : 75000</p>
				</span>
				</span>
				<input type="text" id="client_cp" name="client_cp">
				</td>
			</tr>
		</table>
	</div>
</div>

<script type="text/javascript">

new Event.observe("client_cp", "mouseover", function(){$("client_cp_info").style.display = "block";}, false);
new Event.observe("client_cp", "mouseout", function(){$("client_cp_info").style.display = "none";}, false);

//on masque le chargement
H_loading();
</script>