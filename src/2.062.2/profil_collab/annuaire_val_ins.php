<?php
// *************************************************************************************************************
// 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!isset($_REQUEST['id_contact_tmp'])){
	echo "l'identifiant du contact n'est pas spécifié";
	exit;
}
$id_contact_tmp = $_REQUEST['id_contact_tmp'];

if(!isset($_REQUEST['action'])){
	echo "l'action n'est pas spécifiée";
	exit;
}
$action = $_REQUEST['action'];

if(!isset($_REQUEST['onglet'])){
	echo "l'onglet n'est pas spécifiée";
	exit;
}
$onglet = $_REQUEST['onglet'];

if($onglet == "inscriptions_confirmees" || $onglet == "inscriptions_non_confirmees")
{		$query_where = "&&	a.mode = 'inscription'";}
elseif($onglet == "modification_confirmees" || $onglet == "modification_non_confirmees")
{		$query_where = "&&	a.mode = 'modification'";}
else
{		echo "l'onglet '".$onglet."' n'est pas connu.";exit;}

$query ="	SELECT	a.id_contact_tmp, a.id_interface, i.dossier, i.id_profil	  									
    			FROM			annuaire_tmp a
    			LEFT JOIN interfaces i ON a.id_interface = i.id_interface
    			WHERE		a.id_contact_tmp = ".$id_contact_tmp."
    			".$query_where;
$resultat_bd = $bdd->query($query);
if(!$res = $resultat_bd->fetchObject()){
	echo "l'objet est mal enregistré dans la base de données";
	exit;
}
unset($resultat_bd);


function &getObjInscription($dossier){
	$sufixe = substr($dossier, 0, -1);
	if(file_exists($DIR.$dossier."_inscription_".$sufixe.".class.php")){
		require_once($DIR.$dossier."_inscription_".$sufixe.".class.php");
		$classe_inscription = "Inscription_".$sufixe;
		return new $classe_inscription($res->id_interface);
	}
	else
	{		return new Inscription_profil_client($res->id_interface);}
}

function &getObjModification(){
	$sufixe = substr($dossier, 0, -1);
	if(file_exists($DIR.$dossier."_inscription_".$sufixe.".class.php")){
		require_once($DIR.$dossier."_inscription_".$sufixe.".class.php");
		$classe_inscription = "Modification_".$sufixe;
		return new $classe_inscription($res->id_interface);
	}
	else
	{		return new Inscription_profil_client($res->id_interface);}
}


$resultat = false;

echo "\n\naction + onglet -> ".$action."_".$onglet."\n\n";

switch($action."_".$onglet) {
	case "valider_inscriptions_confirmees":{
		$inscription &= getObjInscription($res->dossier);
		$resultat = !is_null($inscription->validation_inscription_contact_par_collaborateur($id_contact_tmp)); ?>
		<script type="text/javascript">
		alerte.alerte_erreur('Validation des inscriptions', '<?php echo ($resultat) ? "Validation effectuée avec succès." : "Erreur lors de la validation"; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		<?php if($resultat)
		{ ?>remove_tag('id_ins_<?php echo $id_contact_tmp; ?>');<?php } ?>
		</script>
		<?php 
		unset($inscription);
	break;}
	case "refuser_inscriptions_confirmees":{
		$inscription &= getObjInscription($res->dossier);
		$resultat = !is_null($inscription->refus_inscription_contact_par_collaborateur($id_contact_tmp)); ?>
		<script type="text/javascript">
		alerte.alerte_erreur('Validation des inscriptions', '<?php echo ($resultat) ? "Suppression effectuée avec succès." : "Erreur lors de la suppression"; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		<?php if($resultat)
		{ ?>remove_tag('id_ins_<?php echo $id_contact_tmp; ?>');<?php } ?>
		</script>
		<?php
		unset($inscription);
	break;}
	
	case "valider_inscriptions_non_confirmees":{
		$inscription &= getObjInscription($res->dossier);
		$resultat = !is_null($inscription->validation_inscription_contact_par_collaborateur($id_contact_tmp)); ?>
		<script type="text/javascript">
		alerte.alerte_erreur('Validation des inscriptions', '<?php echo ($resultat) ? "Validation effectuée avec succès." : "Erreur lors de la validation"; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		<?php if($resultat)
		{ ?>remove_tag('id_ins_<?php echo $id_contact_tmp; ?>');<?php } ?>
		</script>
		<?php
		unset($inscription);
	break;}
	case "refuser_inscriptions_non_confirmees":{
		$inscription &= getObjInscription($res->dossier);
		$resultat = !is_null($inscription->refus_inscription_contact_par_collaborateur($id_contact_tmp)); ?>
		<script type="text/javascript">
		alerte.alerte_erreur('Validation des inscriptions', '<?php echo ($resultat) ? "Suppression effectuée avec succès." : "Erreur lors de la suppression"; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		<?php if($resultat)
		{ ?>remove_tag('id_ins_<?php echo $id_contact_tmp; ?>');<?php } ?>
		</script>
		<?php
		unset($inscription);
	break;}
	
	case "valider_modification_confirmees":{
		$modification &= getObjModification($res->dossier);
		$resultat = $modification->validation_modification_contact_par_collaborateur($id_contact_tmp); ?>
		<script type="text/javascript">
		alerte.alerte_erreur('Validation des inscriptions', '<?php echo ($resultat) ? "Validation effectuée avec succès." : "Erreur lors de la validation"; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		<?php if($resultat)
		{ ?>remove_tag('id_ins_<?php echo $id_contact_tmp; ?>');<?php } ?>
		</script>
		<?php
		unset($modification);
	break;}
	case "refuser_modification_confirmees":{
		$modification &= getObjModification($res->dossier);
		$resultat = $modification->refus_modification_contact_par_collaborateur($id_contact_tmp); ?>
		<script type="text/javascript">
		alerte.alerte_erreur('Validation des inscriptions', '<?php echo ($resultat) ? "Suppression effectuée avec succès." : "Erreur lors de la suppression"; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		<?php if($resultat)
		{ ?>remove_tag('id_ins_<?php echo $id_contact_tmp; ?>');<?php } ?>
		</script>
		<?php
		unset($modification);
	break;}
	
	case "valider_modification_non_confirmees":{
		$modification &= getObjModification($res->dossier);
		$resultat = $modification->validation_modification_contact_par_collaborateur($id_contact_tmp); ?>
		<script type="text/javascript">
		alerte.alerte_erreur('Validation des inscriptions', '<?php echo ($resultat) ? "Validation effectuée avec succès." : "Erreur lors de la validation"; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		<?php if($resultat)
		{ ?>remove_tag('id_ins_<?php echo $id_contact_tmp; ?>');<?php } ?>
		</script>
		<?php
		unset($modification);
	break;}
	case "refuser_modification_non_confirmees":{
		$modification &= getObjModification($res->dossier);
		$resultat = $modification->refus_modification_contact_par_collaborateur($id_contact_tmp); ?>
		<script type="text/javascript">
		alerte.alerte_erreur('Validation des inscriptions', '<?php echo ($resultat) ? "Suppression effectuée avec succès." : "Erreur lors de la suppression"; ?>','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		<?php if($resultat)
		{ ?>remove_tag('id_ins_<?php echo $id_contact_tmp; ?>');<?php } ?>
		</script>
		<?php
		unset($modification);
	break;}
	
	default	:	break;
}

echo "\n\n\$resultat -> ".($resultat);

?>
