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
$form['fiches_par_page'] = $search['fiches_par_page'] = $COMPTA_EXTRAIT_COMPTE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
//chargment des resultat du grand livre

$form['date_debut'] = $search['date_debut'] = $_REQUEST['date_debut'] ;
$form['date_fin'] = $search['date_fin'] = $_REQUEST['date_fin'] ;

// Profils

$form['id_profil'] = $search['id_profil'] = $CLIENT_ID_PROFIL;
if (isset($_REQUEST['id_profil']) && $_REQUEST['id_profil'] == "fournisseurs") {
	$form['id_profil'] = $FOURNISSEUR_ID_PROFIL;
	$search['id_profil'] = $FOURNISSEUR_ID_PROFIL;
} else {
	$form['id_profil'] = $CLIENT_ID_PROFIL;
	$search['id_profil'] = $CLIENT_ID_PROFIL;

}

$fiches = array();
	$query = "SELECT a.ref_contact, nom 
						FROM annuaire a 
						 	LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact
						WHERE  ap.id_profil = '".$search['id_profil']."'
						ORDER BY nom ASC 
						";
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }


foreach ($fiches as $ctact) {

	$contact = new contact ($ctact->ref_contact);
	$ref_contact = $ctact->ref_contact;
	
	//complement de la requete pour les documents
	$query_select = "";
	$query_join 	= "";
	$query_where 	= "";
	$query_group	= "";
	
	if ($ref_contact) {
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where .=  " ref_contact = '".$ref_contact."' "; 
	}
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where .=  " d.date_creation_doc >= '".($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where .=  " d.date_creation_doc < '".($search['date_fin'])."' "; 
	}
	
	//complement de la requete pour les reglements
	
	$query_select2 = "";
	$query_join2 	= "";
	$query_where2 	= "";
	$query_group2	= "";
	
	if ($ref_contact) {
		if ($query_where2) { $query_where2 .= " &&  "; }
		if (!$query_where2) { $query_where2 .= "WHERE "; }
		$query_where2 .=  " r.ref_contact = '".$ref_contact."' "; 
	}
	if ($search['date_debut']) {
		if ($query_where2) { $query_where2 .= " &&  "; }
		if (!$query_where2) { $query_where2 .= "WHERE "; }
		$query_where2 .=  " date_reglement >= '".($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where2) { $query_where2 .= " &&  "; }
		if (!$query_where2) { $query_where2 .= "WHERE "; }
		$query_where2 .=  " date_reglement < '".($search['date_fin'])."' "; 
	}
	// Sélection
	// Sélection des documents du contact
	$grand_livre_documents = array();
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, ref_contact, de.lib_etat_doc,

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,

									 		date_creation_doc as date,
											fnr.lib_niveau_relance 	

						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
							LEFT JOIN factures_relances_niveaux fnr ON fnr.id_niveau_relance = df.id_niveau_relance 
						".$query_where." && (d.id_type_doc = '4' || d.id_type_doc = '8') && (d.id_etat_doc != '17' && d.id_etat_doc != '33')
						GROUP BY d.ref_doc 
						ORDER BY date ASC";

	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) {
		$grand_livre_documents[$var->ref_doc] = $var; 
	}
	
	// Sélection des règlements du contact
	$grand_livre_reglements = array();
	$query = "SELECT r.ref_reglement, r.id_reglement_mode, r.ref_contact, rm.lib_reglement_mode,
									 r.date_saisie, r.date_reglement as date, r.montant_reglement as montant_ttc, rm.type_reglement, 
									 rec.numero_cheque as nchq_e, rsc.numero_cheque as nchq_s

						FROM reglements r  
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode 
							LEFT JOIN regmt_e_chq rec ON r.ref_reglement = rec.ref_reglement 
							LEFT JOIN regmt_s_chq rsc ON r.ref_reglement = rsc.ref_reglement 
						".$query_where2." && valide = 1
						GROUP BY r.ref_reglement 
						ORDER BY date ASC";

	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) {
		// Association des ref_doc correspondant au reglement
		$var->ref_doc = array();
			$query2 = "SELECT ref_doc
								FROM reglements_docs 
								WHERE ref_reglement = '".$var->ref_reglement."' && liaison_valide = '1'";
		
			$resultat2 = $bdd->query ($query2);
			while ($var2 = $resultat2->fetchObject()) { $var->ref_doc[$var2->ref_doc] = $var2->ref_doc; }
			
			$grand_livre_reglements[$var->ref_reglement] = $var; 
	}
	unset ($var, $resultat, $query);
	$ctact->ran = 0;
	if (!$search['date_debut']) {
		$ctact->ran = 0;
	} else {
		//on récupère le report à nouveau si il existe
		$query_ran = "SELECT id_exercice_ran, ref_contact, date_ran as date, montant_ran
									FROM compta_exercices_reports
									WHERE date_ran = '".$search['date_debut']." 00:00:00' && ref_contact = '".$ref_contact."' ";
		$resultat_ran = $bdd->query ($query_ran);
		if ($tmp_ran = $resultat_ran->fetchObject()) {
			$ctact->ran = $tmp_ran->montant_ran;
		} else {

	// echo "2 ";
				$ran_last_livre_documents = array();
				$query_ran_last_doc = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, ref_contact, de.lib_etat_doc,
			
													( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
														FROM docs_lines dl
														WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,
														date_creation_doc as date,
														fnr.lib_niveau_relance 	
			
									FROM documents d 
										LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
										LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
										LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
										LEFT JOIN factures_relances_niveaux fnr ON fnr.id_niveau_relance = df.id_niveau_relance 
									WHERE ref_contact = '".$ref_contact."' &&   d.date_creation_doc < '".$search['date_debut']."'  && (d.id_type_doc = '4' || d.id_type_doc = '8') && (d.id_etat_doc != '17' && d.id_etat_doc != '33')
									GROUP BY d.ref_doc 
									ORDER BY date ASC";
			
				$ran_last_doc = $bdd->query ($query_ran_last_doc);
				while ($var_ran_last_doc = $ran_last_doc->fetchObject()) {
					$tmp_doc = open_doc( $var_ran_last_doc->ref_doc);
					$var_ran_last_doc->montant_ttc = $tmp_doc->getMontant_to_pay ();
					$ran_last_livre_documents[$var_ran_last_doc->ref_doc] = $var_ran_last_doc; 
				}
				
				//on calcul un ran qui cumule l'ensemble des résultats
				foreach ($ran_last_livre_documents as $ran_last_documents) {
					//document en débit
					if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc >= 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc < 0))) {
						$ctact->ran = $ctact->ran - abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
					} 
					//document en crédit
					if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc < 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc >= 0)) ) { 
						$ctact->ran = $ctact->ran + abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
					} 
				}
			
		}
	}
	
	$ctact->credit = 0;
	$ctact->debit = 0;
	//on calcul un ran qui cumule l'ensemble des résultats
	foreach ($grand_livre_documents as $ran_last_documents) {
		//document en débit
		if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc >= 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc < 0))) {
			$ctact->debit = $ctact->debit + abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
		} 
		//document en crédit
		if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc < 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc >= 0)) ) { 
			$ctact->credit = $ctact->credit + abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
		} 
		
	}
	foreach ($grand_livre_reglements as $ran_last_reglement) {	
		// Règlement en débit
		if (isset($ran_last_reglement->ref_reglement) && $ran_last_reglement->type_reglement == "sortant") {
			$ctact->debit = $ctact->debit + abs(number_format($ran_last_reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
		} 
		//règlement en crédit
		if (isset($ran_last_reglement->ref_reglement) && $ran_last_reglement->type_reglement == "entrant") { 
			$ctact->credit = $ctact->credit + abs(number_format($ran_last_reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
		} 
	}
	
	
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

	?>
	<html>
	<body style="font:12px Arial, Helvetica, sans-serif">
	Soldes des comptes <?php echo $_REQUEST['id_profil'];?> du <?php echo date_Us_to_Fr($search['date_debut']);?> au  <?php echo date_Us_to_Fr($search['date_fin']);?><br />

	<table style="width:100%; font:12px Arial, Helvetica, sans-serif" cellpadding="0" cellspacing="0">
	<tr>
		<td style="font-weight:bolder">
		Fournisseur
		</td>
		<td style="font-weight:bolder; text-align:right">
		Report
		</td>
		<td style="font-weight:bolder; text-align:right">
		Débit
		</td>
		<td style="font-weight:bolder; text-align:right">
		Crédit
		</td>
		<td style="font-weight:bolder; text-align:right">
		Solde
		</td>
	</tr>
		
	<?php 
	foreach ($fiches as $solde) {	
		?>
	<tr valign="top">
		<td style=" border-top:1px solid #999999">&nbsp;
		<?php echo ($solde->nom);?>
		</td>
		<td style=" border-top:1px solid #999999; text-align:right">&nbsp;
		<?php echo price_format($solde->ran).$MONNAIE[1];?>
		</td>
		<td style=" border-top:1px solid #999999; text-align:right">&nbsp;
		<?php echo price_format($solde->debit).$MONNAIE[1];?>
		</td>
		<td style=" border-top:1px solid #999999; text-align:right">&nbsp;
		<?php echo price_format($solde->credit).$MONNAIE[1];?>
		</td>
		<td style=" border-top:1px solid #999999; text-align:right">&nbsp;
		<?php echo price_format($solde->credit-$solde->debit+$solde->ran).$MONNAIE[1];?>
		</td>
	</tr>
		<?php 
	}
?>
</table>
</body>
</html>