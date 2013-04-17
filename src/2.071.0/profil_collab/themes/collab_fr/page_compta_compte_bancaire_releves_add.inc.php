<?php

// *************************************************************************************************************
// AJOUT D'UN RELEVE
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_edit_ope" style="cursor:pointer; float:right"/>
<script type="text/javascript">
Event.observe('close_edit_ope', 'click',  function(evt){
Event.stop(evt); 
$("edition_operation").hide();
}, false);
</script>

<p  style="font-weight:bolder">Ajouter un relevé</p>
<div class="emarge">
	<table class="minimizetable" style="width:450px">
		<tr>
			<td>
			<form action="compta_compte_bancaire_releves_add_valid.php" method="post" id="releve_add_valid" name="releve_add_valid" target="formFrame" >
			<table style="width:100%">
				<tr>
					<td>
					Date
					<div>
					<input type="text" id="date_new_releve" name="date_new_releve" value="<?php echo date("d-m-Y");?>" class="classinput_lsize" />
					</div>
					</td>
					<td>
					Montant
					<div>
					<input type="hidden" id="id_compte_bancaire_new_releve" name="id_compte_bancaire_new_releve" value="<?php echo $compte_bancaire->getId_compte_bancaire();?>" />
					<input type="text" id="montant_reel_new_releve" name="montant_reel_new_releve" value="0.00" class="classinput_lsize"  />
									<?php if (isset($_REQUEST["from_tb"])) { ?>
									<input type="hidden" name="from_tb" id="from_tb" value="1"/>
									<?php }?>
					</div>
					</td>
					<td><br />

						<div style="text-align:right">
						<input name="add_releve_add_valid" id="add_releve_add_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-enregistrer.gif" />
						</div>
					</td>
				</tr>
			</table>
			</form>
			<SCRIPT type="text/javascript">
			Event.observe("date_new_releve", "blur", datemask, false);
			Event.observe("montant_reel_new_releve", "blur", function(evt){	Event.stop(evt);	nummask(evt, 0, "X.XY"); });
			</SCRIPT>
			
			</td>
		</tr>
	</table>
</div>
<SCRIPT type="text/javascript">


//on masque le chargement
H_loading();
</SCRIPT>