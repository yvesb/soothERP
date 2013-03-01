<?php
// *************************************************************************************************************
// AFFICHAGE DU GRAND LIVRE D'UN CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (!$_SESSION['user']->check_permission ("12")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

function cmp($ar1, $ar2, $key){
  return ( ($ar1->$key > $ar2->$key) ? 1 : ( ($ar1->$key == $ar2->$key) ? 0 : -1));
}

function tri($array, $critere){
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

$form['date_debut'] = "" ;
if (isset($_REQUEST['date_debut'])) {
	$form['date_debut'] = date_Fr_to_Us($_REQUEST['date_debut']);
	$search['date_debut'] = date_Fr_to_Us($_REQUEST['date_debut']);
}

$form['date_fin'] = "" ;
if (isset($_REQUEST['date_fin'])) {
	$form['date_fin'] = date_Fr_to_Us($_REQUEST['date_fin']);
	$search['date_fin'] = date_Fr_to_Us($_REQUEST['date_fin']);
}


$form['date_exercice"'] = "" ;
if (isset($_REQUEST['date_exercice']) && ($_REQUEST['date_fin'] == "" && $_REQUEST['date_fin'] == "")) {
	$form['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_debut'] = ($search['date_exercice'][0]);
	$search['date_fin'] = ($search['date_exercice'][1]);
}

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


$stocks_moves = array();

foreach ($fiches as $ctact) {

	$contact = new contact ($ctact->ref_contact);
	$ref_contact = $ctact->ref_contact;
	$ctact->nom_contact = $contact->GetNom();
	$ctact->compteextrait = array();
	
	//complement de la requete pour les documents
	$query_select = "";
	$query_join 	= "";
	$query_where 	= "";
	$query_group	= "";
	
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
		$query_where .=  " d.date_creation_doc < '".($search['date_fin'])." 23:59:59' "; 
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
						".$query_where." && (d.id_type_doc = '".($search['id_profil'] == $CLIENT_ID_PROFIL ? "4" : "8")."') && (d.id_etat_doc != '".($search['id_profil'] == $CLIENT_ID_PROFIL ? "17": "33")."')
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
						".$query_where2."&& rm.type_reglement = '".($search['id_profil'] == $CLIENT_ID_PROFIL ? "entrant" : "sortant")."' && valide = 1
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
	
	// Gestion du Lettrage
	$lettrage = "AA";
	foreach ($grand_livre_documents as $documents) {
	$use_lettrage = 0;
			// A moins qu'un lettrage existe pour le document
			if (isset($documents->lettrage)) {$use_lettrage = $documents->lettrage;}
			
			// Sinon on récupére le lettrage attribué à un autre documents qui fait parti des règlements
			if ($use_lettrage == 0) {
				foreach ($grand_livre_reglements as $reglement) {
					foreach ($reglement->ref_doc as $nref_doc) {
						if ($use_lettrage != 0) {continue;}
						if (isset($grand_livre_documents[$nref_doc]->lettrage)) {
							$use_lettrage = $grand_livre_documents[$nref_doc]->lettrage ;
							foreach ($reglement->ref_doc as $lref_doc) {
								if (isset($grand_livre_documents[$lref_doc]) && !isset($grand_livre_documents[$lref_doc]->lettrage)) {
								$grand_livre_documents[$lref_doc]->lettrage = $use_lettrage;
								}
								$reglement->lettrage = $use_lettrage;
							}
						}
					}
				}
			}
			// On recupére le lettrage si un reglement correspondant au document est deja existant
			if ($use_lettrage == 0) {
				foreach ($grand_livre_reglements as $reglement) {
					if ($use_lettrage != 0) {continue;}
					if (isset($reglement->ref_doc[$documents->ref_doc]) && isset($reglement->lettrage)) {
						$use_lettrage = $reglement->lettrage;
					}
				}
			}
			// Si aucun lettrage n'as été trouvé
			if ($use_lettrage == 0) { $use_lettrage = $lettrage; $lettrage = cre_lettrage ($lettrage);}
			
			// Alors on injecte le lettrage dans tout les règlements et les documents associés
			foreach ($grand_livre_reglements as $reglement) {
				if (isset($reglement->ref_doc[$documents->ref_doc]) && !isset($reglement->lettrage)) {
				$reglement->lettrage = $use_lettrage;
				}
			}
		// Par sécurité on attribut le lettrage au document actuel
		if (!isset($documents->lettrage)) {
		$documents->lettrage = $use_lettrage;
		}
	}
	// On attribut des lettrages aux règlements n'étant pas relié à des factures (en vérifiant si il n'y a pas de document auquel il est lié qui aurait un letttrage)
	foreach ($grand_livre_reglements as $reglement) {
		if (!isset($reglement->lettrage)) {
			//$lettrage = cre_lettrage ($lettrage);
		 	$reglement->lettrage = "--";
		}
	}
	
	
	// On injecte les résultats des factures et des règlements
	$grand_livre_tmp = array();
	if (!isset($_REQUEST["report"])) {
	if (!$search['date_debut']) {
		$tmp_ran_last = new stdclass;
		$tmp_ran_last->date = $ENTREPRISE_DATE_CREATION;
		$tmp_ran_last->id_exercice_ran = "1";
		$tmp_ran_last->ref_contact = $ref_contact;
		$tmp_ran_last->montant_ran = 0;
		$tmp_ran->lettrage = "--";
		$grand_livre_tmp[] = $tmp_ran;
	} else {
		//on récupère le report à nouveau si il existe
		$query_ran = "SELECT id_exercice_ran, ref_contact, date_ran as date, montant_ran
									FROM compta_exercices_reports
									WHERE date_ran = '".$search['date_debut']." 00:00:00' && ref_contact = '".$ref_contact."' ";
		$resultat_ran = $bdd->query ($query_ran);
		if ($tmp_ran = $resultat_ran->fetchObject()) {
			$tmp_ran->lettrage = "--";
			$grand_livre_tmp[] = $tmp_ran;
		} else {
			//sauf si le précédent exercice n'est pas clôturé alors on va calculer le report depuis le dernier exercice clôturé
			$query_ran_last = "SELECT id_exercice_ran, ref_contact, date_ran as date, montant_ran
												FROM compta_exercices_reports
												WHERE date_ran = '".$search['date_debut']." 00:00:00' && ref_contact = '".$ref_contact."' 
												ORDER BY date_ran DESC
												LIMIT 1";
			$resultat_ran_last = $bdd->query ($query_ran_last);
			if (!$tmp_ran_last = $resultat_ran_last->fetchObject()) {
				if ($search['date_debut'] != $ENTREPRISE_DATE_CREATION) {
				$tmp_ran_last = new stdclass;
				$tmp_ran_last->date = $ENTREPRISE_DATE_CREATION;
				$tmp_ran_last->id_exercice_ran = "1";
				$tmp_ran_last->ref_contact = $ref_contact;
				$tmp_ran_last->montant_ran = 0;
				}
			}
			if ($tmp_ran_last) {
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
									WHERE ref_contact = '".$ref_contact."' &&   d.date_creation_doc >= '".$tmp_ran_last->date." 00:00:00' && d.date_creation_doc < '".$search['date_debut']."'  && (d.id_type_doc = '".($search['id_profil'] == $CLIENT_ID_PROFIL ? "4" : "8")."') && (d.id_etat_doc != '".($search['id_profil'] == $CLIENT_ID_PROFIL ? "17": "33")."')
									GROUP BY d.ref_doc 
									ORDER BY date ASC";
			
				$ran_last_doc = $bdd->query ($query_ran_last_doc);
				while ($var_ran_last_doc = $ran_last_doc->fetchObject()) {
					$ran_last_livre_documents[$var_ran_last_doc->ref_doc] = $var_ran_last_doc; 
				}
				
				// Sélection des règlements du contact
				$ran_last_livre_reglements = array();
				$query_ran_last_reg = "SELECT r.ref_reglement, r.id_reglement_mode, r.ref_contact, rm.lib_reglement_mode,
												 r.date_reglement as date, r.montant_reglement as montant_ttc, rm.type_reglement, 
												 rec.numero_cheque as nchq_e, rsc.numero_cheque as nchq_s
			
									FROM reglements r  
										LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode 
										LEFT JOIN regmt_e_chq rec ON r.ref_reglement = rec.ref_reglement 
										LEFT JOIN regmt_s_chq rsc ON r.ref_reglement = rsc.ref_reglement 
									WHERE r.ref_contact = '".$ref_contact."' &&  date_reglement >= '".$tmp_ran_last->date." 00:00:00' && date_reglement < '".$search['date_debut']."'  && rm.type_reglement = '".($search['id_profil'] == $CLIENT_ID_PROFIL ? "entrant" : "sortant")."' && valide = 1
									GROUP BY r.ref_reglement 
									ORDER BY date ASC";
			
				$resultat_ran_last_reg = $bdd->query ($query_ran_last_reg);
				while ($var_ran_last_reg = $resultat_ran_last_reg->fetchObject()) {
					$ran_last_livre_reglements[$var_ran_last_reg->ref_reglement] = $var_ran_last_reg; 
				}
				//on calcul un ran qui cumule l'ensemble des résultats
				foreach ($ran_last_livre_documents as $ran_last_documents) {
					//document en débit
					if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc >= 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc < 0))) {
						$tmp_ran_last->montant_ran = $tmp_ran_last->montant_ran - abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
					} 
					//document en crédit
					if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc < 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc >= 0)) ) { 
						$tmp_ran_last->montant_ran = $tmp_ran_last->montant_ran + abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
					} 
					
				}
				foreach ($ran_last_livre_reglements as $ran_last_reglement) {	
					// Règlement en débit
					if (isset($ran_last_reglement->ref_reglement) && $ran_last_reglement->type_reglement == "sortant") {
						$tmp_ran_last->montant_ran = $tmp_ran_last->montant_ran - abs(number_format($ran_last_reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
					} 
					//règlement en crédit
					if (isset($ran_last_reglement->ref_reglement) && $ran_last_reglement->type_reglement == "entrant") { 
						$tmp_ran_last->montant_ran = $tmp_ran_last->montant_ran + abs(number_format($ran_last_reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
					} 
				}
				$tmp_ran_last->date = $search['date_debut'];
				$tmp_ran_last->lettrage = "--";
				$grand_livre_tmp[] = $tmp_ran_last;
			}
		}
	}
	}

	foreach ($grand_livre_documents as $documents) {	$grand_livre_tmp[] = $documents; }
	foreach ($grand_livre_reglements as $reglement) {	$grand_livre_tmp[] = $reglement; }
	
	// Tri grand livre (afin d'afficher les documents et les règlements dans l'ordre des dates
	
	$nb_fiches = count($grand_livre_documents)+count($grand_livre_reglements);
	
	//limitation du nombre de résultats affichés
	$tmp_grand_livre = tri($grand_livre_tmp, "date");
	$grand_livre = array();
	
	$limit_depart = 1;
	if (isset($tmp_grand_livre[0]->id_exercice_ran)) {$limit_depart++;}
	$limit_fin = $limit_depart + $search['fiches_par_page'];
	

	$i = 0;
	foreach ($tmp_grand_livre as $line_livre) {
		$grand_livre[] = $line_livre;
		$i++;
	}
	$ctact->compteextrait = $grand_livre;
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$solde_total_final = 0;
?>
	<html>
	<head>
	<style>
	td{
	font:12px Arial, Helvetica, sans-serif
	}
	</style>
	</head>
	<body style="font:12px Arial, Helvetica, sans-serif">
 Grand livre <?php echo $_REQUEST['id_profil'];?>	<br>
<br>

<?php 
foreach ($fiches as $ctact) {
	?> <div id="infos_contact_<?php echo htmlentities($ctact->ref_contact )?>" >
	<?php
 if (count($ctact->compteextrait) >20) {?>
<div style="page-break-before:always; margin-top:2cm;"></div> 
		<?php 
	} else {
		?><br>

		<?php
	}
	?>
<hr/>
	Solde du compte <?php echo $_REQUEST['id_profil'];?> <span style="font-weight:bolder; color:#FF0000"><?php echo htmlentities($ctact->nom_contact )?></span> du <?php echo date_Us_to_Fr($search['date_debut']);?> au  <?php echo date_Us_to_Fr($search['date_fin']);?><br />

<table width="99%" border="0" cellspacing="0" cellpadding="0" style="background-color:#EEEEEE">
	<tr>
		<td style="text-align:left; width:5%; font-weight:bolder">
		<div >Date
		</div>
		</td>
		<td style="text-align:left; font-weight:bolder; width:20%;"  >
		<div>
		Libellé
		</div>
		</td>
		<td style="text-align:right; font-weight:bolder; width:15%;">
		<div>
		
		</div>
		</td>
		<td style="text-align:right; font-weight:bolder; width:15%;">
		<div>
		
		</div>
		</td>
		<td style="text-align:right; width:10%; font-weight:bolder">
		<div style="width:120px">
		Débit
		</div>
		</td>
		<td style="padding-right:10px;  width:5%; font-weight:bolder">
			<div style="width:55px; text-align:right;">
			Lt
			</div>
		</td>
		<td style="text-align:right; width:10%; font-weight:bolder">
		<div style="width:120px">
		Crédit
		</div>
		</td>
		<td style="text-align:right; width:10%; font-weight:bolder">
		<div style="width:120px">
		Solde
		</div>
		</td>
	</tr>
<?php 
$colorise=0;
$montant_total_credit = 0;
$montant_total_debit = 0;
$montant_total_solde = 0;
foreach ($ctact->compteextrait as $line) {
$montant_en_credit = 0;
$montant_en_debit = 0;
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
	?>
	
	<tr  class="<?php echo $class_colorise;?>" id="ligne_<?php echo $colorise;?>">
		<td style="font-size:10px; text-align:left;" class="<?php echo htmlentities($line->lettrage);?>">
		<div >
		<?php echo date_Us_to_Fr($line->date);?>
		</div>
		</td>
		<td style="text-align:left;" class="<?php echo htmlentities($line->lettrage);?>">
		<div>
		<?php if (isset($line->id_exercice_ran)) {?>
		Report
		<?php } 
		?>
		
		<?php if (isset($line->ref_doc) && !is_array($line->ref_doc) ) {?>
		<a href="#" id="grand_livre_line_<?php echo $colorise;?>" style="color:#000000; text-decoration:none">
		<span style="font-weight:bolder"><?php echo htmlentities($line->lib_type_doc);?></span> <span style="font-size:10px"><?php echo htmlentities($line->ref_doc);?></span>
		</a>
		</div>
		<?php } 
		if (isset($line->ref_reglement)) { ?>
		<a href="#" id="grand_livre_line_<?php echo $colorise;?>" style="color:#000000; text-decoration:none">
		<span style="font-weight:bolder">Règlement</span>  <span style="font-size:10px">(<?php echo htmlentities($line->lib_reglement_mode);?> <?php if (isset($line->nchq_s) && $line->nchq_s != "") {echo " n°".$line->nchq_s;}?><?php if (isset($line->nchq_e) && $line->nchq_e != "") {echo " n°".$line->nchq_e;}?>)</span>
		</a><br />
		<?php //  print_r($line->ref_doc);?>
		</div>
		
		<?php } ?>
		</td>
		<td style="text-align:right; " class="<?php echo htmlentities($line->lettrage);?>">
		<div style="text-align:right; ">
		<?php 
		if (isset($line->ref_doc) && !is_array($line->ref_doc) ) {
			?>
			 <span style="font-size:10px; <?php if ($line->id_etat_doc == "16") { ?>color: #FF0000;<?php }?>"><?php echo htmlentities($line->lib_etat_doc);?></span><br />
			<?php 
		} 
		?>
		</div>
		</td>
		<td style="text-align:right; font-weight:bolder" class="<?php echo htmlentities($line->lettrage);?>">
		<div>
		<?php 
		if (isset($line->lib_niveau_relance) ) {
			?>
			 <span style="font-size:10px"><?php echo htmlentities($line->lib_niveau_relance);?></span>
			<?php 
		} 
		?>
		</div>
		</td>
		<td style="text-align:right;" class="<?php echo htmlentities($line->lettrage);?>">
		<div style="text-align:right;">
		<?php 
		if (isset($line->ref_doc) && !is_array($line->ref_doc) && (($line->id_type_doc == 4 && $line->montant_ttc >= 0) || ($line->id_type_doc == 8 && $line->montant_ttc < 0))) {
			$montant_en_debit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_debit);
		} 
		if (isset($line->ref_reglement) && $line->type_reglement == "sortant") {
			$montant_en_debit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_debit);
		} 
		if (isset($line->montant_ran) && $line->montant_ran < 0) {
			$montant_en_debit = abs(number_format($line->montant_ran, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_debit);
		} 
		$montant_total_debit += $montant_en_debit;
		?>
		</div>
		</td>
		<td style="font-size:10px; padding-right:10px; text-align:right;" class="<?php echo htmlentities($line->lettrage);?>">
			<div style="width:55px;" id="grand_livre_line_lt_<?php echo $colorise;?>">
				<div style="cursor:pointer">
					<?php echo htmlentities($line->lettrage);?>
				</div>
			</div>
			
		</td>
		<td style="text-align:right;" class="<?php echo htmlentities($line->lettrage);?>">
		<div style="">
		<?php 
		if (isset($line->ref_doc) && !is_array($line->ref_doc) && (($line->id_type_doc == 4 && $line->montant_ttc < 0) || ($line->id_type_doc == 8 && $line->montant_ttc >= 0)) ) { 
			$montant_en_credit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_credit);
		} 
		
		if (isset($line->ref_reglement) && $line->type_reglement == "entrant") { 
			$montant_en_credit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_credit);
		} 
		if (isset($line->montant_ran) && $line->montant_ran > 0) {
			$montant_en_credit = abs(number_format($line->montant_ran, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_credit);
		} 
		$montant_total_credit += $montant_en_credit;
		?>
		
		</div>
		</td>
		<td style="text-align:right;" class="<?php echo htmlentities($line->lettrage);?>">
		<div style="">
		<?php
		$montant_total_solde = $montant_total_solde + $montant_en_credit - $montant_en_debit;
		echo price_format($montant_total_solde);
		
		?>
		</div>
		</td>
	</tr>
	<?php
	
}
?>
	<tr>
		<td style="text-align:left; font-weight:bolder" colspan="4">
		<div>
		TOTAL DU COMPTE
		</div>
		</td>
		<td style="text-align:right;font-weight:bolder">
		<div style="">
		<?php echo htmlentities(price_format($montant_total_debit));?>
		</div>
		</td>
		<td style="padding-right:10px; font-weight:bolder">
			<div style=" text-align:right;">

			</div>
		</td>
		<td style="text-align:right; font-weight:bolder">
		<div style="">
		<?php echo htmlentities(price_format($montant_total_credit));?>
		</div>
		</td>
		<td style="text-align:right; font-weight:bolder">
		<div style="">
		<?php 
		echo htmlentities(price_format($montant_total_solde)); 
		$solde_total_final += $montant_total_solde;
		if (round($montant_total_solde,2) == "0" && isset($_REQUEST["equi"]) && $_REQUEST["equi"]) {
			?>
			<script type="text/javascript">
			document.getElementById("infos_contact_<?php echo htmlentities($ctact->ref_contact )?>").style.display = "none";
			</script>
			<?php
			}
		?>
		</div>
		</td>
	</tr>
</table>
<?php if (count($ctact->compteextrait) >20) {?>
<div style="page-break-before:always; margin-top:2cm;"></div> 
		<?php 
	}
	?>
	</div>
	<?php
}
?>
<div style="page-break-before:always; margin-top:2cm;"></div> 

	Soldes des  <?php echo count($fiches);?> comptes <?php echo $_REQUEST['id_profil'];?> 
	 du <?php echo date_Us_to_Fr($search['date_debut']);?> au  <?php echo date_Us_to_Fr($search['date_fin']);?> 
	:&nbsp; &nbsp; <?php echo price_format($solde_total_final)." ".$MONNAIE[1];?><br />
	 
	 
</body>
</html>