<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(!isset($_REQUEST["ref_agenda"])){
	echo "la référence de l'agenda n'est pas spécifiée";
	exit;
}
$ref_agenda = $_REQUEST["ref_agenda"];



global $bdd;
$query = "SELECT `id_type_agenda` FROM `agendas` WHERE `ref_agenda` = '".$ref_agenda."' ";
$res = $bdd->query($query);
if(!$retour = $res->fetchObject()){
	return false;
}
$id_type_agenda = $retour->id_type_agenda;

if($id_type_agenda == 1)
{?>
	<input id="evt_edition_lib2" name="evt_edition_lib2" cols="15" rows="1" style="width: 97%;" type="hidden" />
	<select id="evt_choix_stock" class="edition_event" name="evt_choix_stock" style="width:100%">
<?php 
	global $bdd;
	$query = "SELECT `ref_article` FROM `agendas_types_location` WHERE `ref_agenda` = '".$ref_agenda."' ";					
	$res = $bdd->query($query);
	if(!$retour = $res->fetchObject()){
		return false;
	}
	$ref_article = $retour->ref_article;
	
	$query = "SELECT `id_stock`, `lib_stock` FROM `stocks` WHERE `actif` = '1' ";					
	$res = $bdd->query($query);
	while($retour = $res->fetchObject()){
		$stocks[]=$retour;
		echo "<option value='".$retour->id_stock."' >".$retour->lib_stock."</option>";
	}
			
	//print_r($stocks);
?>
</select>
<script type="text/javascript">
	onload = majQte_stock("evt_info_qte", $("evt_choix_stock").value, "<?php echo $ref_article;?>", "<?php echo $ref_agenda ?>", $("evt_edition_date_deb").value, $("evt_edition_heure_deb").value, $("evt_edition_heure_fin").value);
	var qte_calcule = parseInt($("evt_info_qte").innerHTML);
	if($("evt_edition_qte").value != "")
	{
		qte_calcule += parseInt($("evt_edition_qte").value);
		$("evt_info_qte").innerHTML = qte_calcule;
	}
	Event.observe("evt_choix_stock", "change",  function(evt){
		Event.stop(evt);
		majQte_stock("evt_info_qte", $("evt_choix_stock").value, "<?php echo $ref_article;?>", "<?php echo $ref_agenda ?>", $("evt_edition_date_deb").value, $("evt_edition_heure_deb").value, $("evt_edition_heure_fin").value);
		if($("MajEvent").style.display == "")
		{
			var qte_calcule = parseInt($("evt_info_qte").innerHTML);
			if($("evt_edition_qte").value != "" && $("evt_info_qte").innerHTML != "")
			{
				qte_calcule += parseInt($("evt_edition_qte").value);
				$("evt_info_qte").innerHTML = qte_calcule;
			}			
		}
		}, false);
	Event.observe("evt_edition_qte", "change",  function(evt){
		if(parseInt($("evt_info_qte").innerHTML) < parseInt($("evt_edition_qte").value))
		{
			$("evt_edition_qte").style.color='red';
		}
		else
		{
			$("evt_edition_qte").style.color='black';
		}
	}, false);
	Event.observe("evt_edition_qte", "keyup",  function(evt){
		var reg = new RegExp("[^0-9.,]","gi");
		$("evt_edition_qte").value = $("evt_edition_qte").value.replace(reg,"");
	}, false);
	$("evt_edition_qte").focus();
	Event.observe("evt_edition_qte", 'keydown', function(evt) {
		if(evt.keyCode == 13){//ENTRER
			$("evt_edition_lib2").value = "Location  x"+ $("evt_edition_qte").value;
			switch($("panneau_deition_curent_mode").value){
				case panneau_deition_modes.creation : { ValiderEventLocation(scale_used); break; }
				case panneau_deition_modes.edition  : { MajEventLocation(scale_used); break; }
				default: {break;}
			}
			return;
		}
		if(evt.keyCode == 27){//Echap
			switch($("panneau_deition_curent_mode").value){
				case panneau_deition_modes.creation : { AnnulerEvent(scale_used); break; }
				case panneau_deition_modes.edition  : { panneau_eition_reset_formulaire(); break; }
				default: {break;}
			}
			return;
		}
	}, false);
</script>
<div 	class="" style="height:5px"></div>
<table>
<tr>
<td style="text-align:left;width:150px;"> Stock Disponible : </td><td style="text-align:right"><span id="evt_info_qte" name="evt_info_qte" style="text-align:right;"></span></td>
</tr>
<tr>
<td style="text-align:left;vertical-align:middle;"> Quantité : </td><td style="text-align:right"><input type="text" id="evt_edition_qte" name="evt_edition_qte" class="edition_event" style="width:32px; padding-left:2px; padding-right:2px;text-align:right" maxlength="5"  value="" /></input></td>
</tr>
</table>

<?php 
}else{?>
<div 	class="panneau_edition_event_titre2">Titre</div>
<!-- textarea id="evt_edition_lib2" name="evt_edition_lib2" cols="15" rows="1" style="width: 97%;" ></textarea -->
<input type= "text" id="evt_edition_lib2" name="evt_edition_lib2" cols="15" style="width: 97%;" />
<div class="" style="height:3px"></div>
<script type="text/javascript">
Event.observe("evt_edition_lib2", 'keydown', function(evt) {
	if(evt.keyCode == 13){//ENTRER
		switch($("panneau_deition_curent_mode").value){
			case panneau_deition_modes.creation : { ValiderEvent(scale_used); break; }
			case panneau_deition_modes.edition  : { MajEvent(scale_used); break; }
			default: {break;}
		}
		return;
	}
	if(evt.keyCode == 27){//Echap
		switch($("panneau_deition_curent_mode").value){
			case panneau_deition_modes.creation : { AnnulerEvent(scale_used); break; }
			case panneau_deition_modes.edition  : { panneau_eition_reset_formulaire(); break; }
			default: {break;}
		}
		return;
	}
}, false);
</script>
<?php
}?>