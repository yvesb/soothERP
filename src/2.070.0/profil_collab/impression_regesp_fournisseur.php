<?php
// *************************************************************************************************************
// AFFICHAGE DU GRAND LIVRE D'UN CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("11")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

function cmp($ar1, $ar2, $key)
{
  return ( ($ar1->$key > $ar2->$key) ? 1 : ( ($ar1->$key == $ar2->$key) ? 0 : -1));
}

function tri($array, $critere)
{
  $cmp = create_function('$a, $b', 'return cmp($a, $b, "'.$critere.'");');
  uasort($array, $cmp);
  return $array;
}

//fonction de génération des lettrages (double numérotation alphabétique)
function cre_lettrage ($old_lettrage){
	$a="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
 	$part_a = substr($old_lettrage ,0,1);
 	$part_b = substr($old_lettrage ,1,1);
	if (strpos($a, $part_b) == strlen($a)-1) { 
		$part_b = "A";
		$part_a = substr($a ,strpos($a, $part_a)+1,1);
	} else {
		$part_b = substr($a ,strpos($a, $part_b)+1,1);
	}
	return $part_a.$part_b;
 
}

//**************************************
// Controle
$nb_fiches = 0;

$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
//chargment des resultat du grand livre

$form['date_debut'] = $search['date_debut'] = $_REQUEST['date_debut'] ;
$form['date_fin'] = $search['date_fin'] = $_REQUEST['date_fin'] ;

$stocks_moves = array();

	//complement de la requete pour les documents
	$query_select = "";
	$query_join 	= "";
	$query_where 	= "";
	$query_group	= "";
	
	
	//complement de la requete pour les reglements
	
	$query_select2 = "";
	$query_join2 	= "";
	$query_where2 	= "WHERE ap.id_profil='5' ";
	$query_group2	= "";
	
	if ($search['date_debut']) {
		if ($query_where2) { $query_where2 .= " &&  "; }
		$query_where2 .=  " date_reglement >= '".($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where2) { $query_where2 .= " &&  "; }
		$query_where2 .=  " date_reglement < '".($search['date_fin'])."' "; 
	}
	// Sélection
	
	// Sélection des règlements du contact
	$grand_livre_reglements = array();
	$query = "SELECT r.ref_reglement, r.id_reglement_mode, r.ref_contact, rm.lib_reglement_mode,
									 r.date_saisie, r.date_reglement as date, r.montant_reglement as montant_ttc, rm.type_reglement, 
									 rec.numero_cheque as nchq_e, rsc.numero_cheque as nchq_s,
									 a.nom

						FROM reglements r  
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode 
							LEFT JOIN regmt_e_chq rec ON r.ref_reglement = rec.ref_reglement 
							LEFT JOIN regmt_s_chq rsc ON r.ref_reglement = rsc.ref_reglement 
							LEFT JOIN annuaire a ON a.ref_contact = r.ref_contact 
							LEFT JOIN annuaire_profils ap ON ap.ref_contact = a.ref_contact 
						".$query_where2." && valide = 1 && r.id_reglement_mode IN ('1', '7')
						GROUP BY r.ref_reglement 
						ORDER BY date ASC";

	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) {
		// Association des ref_doc correspondant au reglement
		$var->ref_doc = array();
			$query2 = "SELECT rd.ref_doc
								FROM reglements_docs rd
								LEFT JOIN documents d ON d.ref_doc = rd.ref_doc
								WHERE ref_reglement = '".$var->ref_reglement."' && liaison_valide = '1' && d.id_type_doc = 8";
		
			$resultat2 = $bdd->query ($query2);
			while ($var2 = $resultat2->fetchObject()) { $var->ref_doc[$var2->ref_doc] = $var2->ref_doc; }
			if (count($var->ref_doc)) {
				$grand_livre_reglements[$var->ref_reglement] = $var; 
			}
	}
	unset ($var, $resultat, $query);
	
	?>
	<html>
	<body style="font:12px Arial, Helvetica, sans-serif">
	Règlements Fournisseurs en espèce du <?php echo date_Us_to_Fr($search['date_debut']);?> au  <?php echo date_Us_to_Fr($search['date_fin']);?><br />

	<table style="width:100%; font:12px Arial, Helvetica, sans-serif" cellpadding="0" cellspacing="0">
	<tr>
		<td style="font-weight:bolder">
		Date
		</td>
		
		<td style="font-weight:bolder">
		Fournisseur
		</td>
		<td style="font-weight:bolder; text-align:right">
		Montant
		</td>
		<td style="font-weight:bolder; text-align:right">
		N° de Facture
		</td>
	</tr>
		
	<?php 
	foreach ($grand_livre_reglements as $reglement) {	
		?>
	<tr valign="top">
		<td style=" border-top:1px solid #999999">
		<?php echo date_Us_to_Fr($reglement->date);?>
		</td>
		<td style=" border-top:1px solid #999999">
		<?php echo ($reglement->nom);?>
		</td>
		<td style=" border-top:1px solid #999999; text-align:right">
		<?php echo price_format($reglement->montant_ttc).$MONNAIE[1];?>
		</td>
		<td style=" border-top:1px solid #999999; text-align:right">&nbsp;
		<?php  foreach ($reglement->ref_doc as $docu_ass) {echo ($docu_ass)."<br />";};?>
		</td>
	</tr>
		<?php 
	}
	

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


?>
</table>
</body>
</html>