<?php

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_COOKIE["tarif"])) {
	$tarif = $_COOKIE["tarif"]; 
} else {
	$tarif = $DEFAUT_APP_TARIFS_CLIENT; 
}
setcookie("tarif", $tarif, time()+ $COOKIE_LOGIN_LT, '/');

$_REQUEST['recherche'] = 1;

// Moteur de recherche pour les commandes en cours

// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if ($_REQUEST['page_to_show']) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $DOCUMENT_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
$form['orderby'] = $search['orderby'] = "date_doc";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "DESC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}
$nb_fiches = 0;

$form['id_type_doc'] = $search['id_type_doc'] = 0;
if ($_REQUEST['id_type_doc']) {
	$form['id_type_doc'] = $_REQUEST['id_type_doc'];
	$search['id_type_doc'] = $_REQUEST['id_type_doc'];
}

$form['ref_constructeur'] = $search['ref_constructeur'] = "";
if (isset($_REQUEST['ref_constructeur'])) {
	$form['ref_constructeur'] = $_REQUEST['ref_constructeur'];
	$search['ref_constructeur'] = $_REQUEST['ref_constructeur'];
}
$form['ref_client'] = $search['ref_client'] = "";
if (isset($_REQUEST['ref_client'])) {
	$form['ref_client'] = $_REQUEST['ref_client'];
	$search['ref_client'] = $_REQUEST['ref_client'];
}

$form['ref_fournisseur'] = $search['ref_fournisseur'] = "";
if (isset($_REQUEST['ref_fournisseur'])) {
	$form['ref_fournisseur'] = $_REQUEST['ref_fournisseur'];
	$search['ref_fournisseur'] = $_REQUEST['ref_fournisseur'];
}
$form['id_name_mag'] = $search['id_name_mag'] = "";
if (isset($_REQUEST['id_name_mag'])) {
	$form['id_name_mag'] = $_REQUEST['id_name_mag'];
	$search['id_name_mag'] = $_REQUEST['id_name_mag'];
}
$form['id_name_stock'] = $search['id_name_stock'] = "";
if (isset($_REQUEST['id_name_stock'])) {
	$form['id_name_stock'] = $_REQUEST['id_name_stock'];
	$search['id_name_stock'] = $_REQUEST['id_name_stock'];
}
$form['id_name_categ_art'] = $search['id_name_categ_art'] = "";
if (isset($_REQUEST['id_name_categ_art'])) {
	$form['id_name_categ_art'] = $_REQUEST['id_name_categ_art'];
	$search['id_name_categ_art'] = $_REQUEST['id_name_categ_art'];
}

$form['cmdecours'] = $search['cmdecours'] = 0;
if ($_REQUEST['cmdecours']) {
	$form['cmdecours'] = 1;
	$search['cmdecours'] = 1;
}

$form['cmderec'] = $search['cmderec'] = 0;
if ($_REQUEST['cmderec']) {
	$form['cmderec'] = 1;
	$search['cmderec'] = 1;
}

$form['cmderetard'] = $search['cmderetard'] = 0;
if ($_REQUEST['cmderetard']) {
	$form['cmderetard'] = 1;
	$search['cmderetard'] = 1;
}

$form['cmdeavalid'] = $search['cmdeavalid'] = 0;
if ($_REQUEST['cmdeavalid']) {
	$form['cmdeavalid'] = 1;
	$search['cmdeavalid'] = 1;
}

$form['cmdeaprep'] = $search['cmdeaprep'] = 0;
if ($_REQUEST['cmdeaprep']) {
	$form['cmdeaprep'] = 1;
	$search['cmdeaprep'] = 1;
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= "1 ";

	}

	// bouton radio : toutes les commandes en cours
	if ($search['cmdecours']) {
		$query_where 	.= " && (d.id_etat_doc = 9 OR d.id_etat_doc = 6)";
	}
	
	// bouton radio : uniquement les commandes récentes
	if ($search['cmderec']) {
		$query_where .= " && TO_DAYS(NOW()) - TO_DAYS(d.date_creation_doc) <= '".$DELAI_COMMANDE_CLIENT_RECENTE."' ";
	}
	
	// bouton radio : uniquement les commandes en retard        
	if ($search['cmderetard']) {
		$query_where .= " && (TO_DAYS(NOW()) - TO_DAYS(d.date_creation_doc) >= '".$DELAI_COMMANDE_CLIENT_RETARD."' )";
	}
	
	// bouton radio : commandes à valider
	if ($search['cmdeavalid']) {
	
	$query_where .= " && d.id_etat_doc = 8";
	}
	
	// bouton radio : commandes à livrer
	if ($search['cmdeaprep']) {
	
		$requete = "SELECT ref_doc
					FROM docs_lines
					WHERE ref_doc
						IN (
						SELECT ref_doc
						FROM documents
						WHERE id_etat_doc
							IN ( 6, 9 )
							)
						GROUP BY ref_doc
						ORDER BY ref_doc ASC";
		$resultat = $bdd->query($requete);
		while ($cmdes = $resultat->fetchObject()) { $tabselect[] = $cmdes; }
		unset ($cmdes, $resultat, $requete);
	
			foreach ($tabselect as $commande) {
				$tabalivrer[] = $commande->ref_doc; }
	
		$requete = "SELECT dl.ref_article, dl.qte, dl.ref_doc, dc.id_stock, a.modele
					FROM docs_lines dl
					LEFT JOIN doc_cdc dc ON dl.ref_doc = dc.ref_doc
					LEFT JOIN articles a ON dl.ref_article = a.ref_article
					WHERE (
						dl.ref_article != 'INFORMATION' OR 'SSTOTAL') 
						&& dl.ref_doc
						IN (
							SELECT ref_doc
							FROM documents
							WHERE id_etat_doc
							IN ( 6, 9 )
							)
					ORDER BY dl.ref_doc ASC";
	$resultat = $bdd->query($requete);
	while ($art = $resultat->fetchObject()) { $arts[] = $art; }
	unset ($art, $resultat, $requete);
	
		$requete = "SELECT ref_article, qte, id_stock
					FROM stocks_articles
					GROUP BY ref_article";
	$resultat = $bdd->query($requete);
	while ($sa = $resultat->fetchObject()) { $sas[] = $sa; }
	unset ($sa, $resultat, $requete);
	
	//$tabalivrer est une liste des commandes en cours ou en saisie
	//l'algo suivant analyse tous les articles de ces commandes:  si un article matériel ne se trouve pas en stock, la cmde
	// auquel appartient l'article est enlevée du tableau $tabalivrer.
	//le cpteur permet de repérer les articles qui échapperaient à une comparaison des qtités en stock
		// cad : - si l'article est un service --> $cpteur++ --> la cmde n'est pas enlevée du tabalivrer
	    //       - si l'article est un matériel, mais qu'il ne se trouve pas dans la liste de stocks, cela veut dire
		//        que sa qtité en stock est 0 --> $cpteur ne rencontre pas de $cpteur++, donc reste à 0,
		//		  en fin de boucle, la cmde est enlevée du tabalivrer
	
	$cpteur=0; 
	
		foreach ($arts as $art) { //parcours des articles faisant partie des commandes en cours
			if ($art->modele == "service") { $cpteur++;}
			foreach ($sas as $sa) { //parcours des articles en stock
				if (($sa->ref_article == $art->ref_article) AND ($sa->id_stock == $art->id_stock)) { 
					$cpteur++;	
					if ($art->qte > $sa->qte) { 
						unset($tabalivrer[array_search($art->ref_doc,$tabalivrer)]);			
					}	
				}		
			}
			if ($cpteur == 0) { unset($tabalivrer[array_search($art->ref_doc,$tabalivrer)]); }
			$cpteur = 0;
		}	
			
	$query_where 	.= " && (d.id_etat_doc = 11 OR d.id_etat_doc = 13) && (d.id_type_doc = 3)";
	//$query_where 	.= " && d.ref_doc IN (\"".implode('","', $tabalivrer)."\") && d.id_etat_doc = 9 " ;
	}
	
	
	// liste déroulante : par fabriquant
	if ($search['ref_constructeur']) {
		$query_where 	.=  " && d.ref_doc IN ( SELECT ref_doc FROM docs_lines WHERE ref_article 
											IN ( SELECT ref_article 
												FROM articles 
												WHERE ref_constructeur = '".$search['ref_constructeur']."'))";
	}
	// liste déroulante : par client
	if ($search['ref_client']) {
		$query_where 	.= " && d.ref_contact = '".$search['ref_client']."'";
	}
	// liste déroulante : par magasin
	if ($search['id_name_mag']) {
		$query_where 	.= " && dc.id_magasin = '".$search['id_name_mag']."'";
	
	}
	// liste déroulante : par stock de départ
	if ($search['id_name_stock']) {
		$query_where 	.= " && dc.id_stock = '".$search['id_name_stock']."'";
	
	}
	// liste déroulante : par catégorie d'article

	if ($search['id_name_categ_art']) {
		$liste_categories = "";
		$liste_categs = array();
		$liste_categs = get_child_categories ($liste_categs, $search['id_name_categ_art']);
		foreach ($liste_categs as $categ) {
			if ($liste_categories) { $liste_categories .= ", "; }
			$liste_categories .= " '".$categ."' ";
		}
		
		$query_where 	.= " && d.ref_doc IN ( SELECT ref_doc FROM docs_lines WHERE ref_article 
											IN ( SELECT ref_article 
												FROM articles 
												WHERE ref_art_categ 
													IN ( ".$liste_categories." ))) ";
		
	}
	
	// liste déroulante : par fournisseur
	if ($search['ref_fournisseur']) {
		$query_where 	.= " && d.ref_doc IN ( SELECT ref_doc FROM docs_lines WHERE ref_article 
											IN ( SELECT ref_article 
												FROM articles_ref_fournisseur 
												WHERE ref_fournisseur = '".$search['ref_fournisseur']."'))";
	}
	// champ caché, ne retient que les commandes
	if ($search['id_type_doc']) { 
	
            if (empty ($search['cmdeaprep'])){
                $query_where 	.= "&& ((d.id_etat_doc = 6 OR d.id_etat_doc = 8 OR d.id_etat_doc = 9) && (d.id_type_doc = '".$search['id_type_doc']."') )";
            }

        }
	
	// Recherche : sélection des commandes
	if(empty($search['cmdeaprep'])){
            $query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc, ref_contact, nom_contact, dc.id_stock,dc.date_livraison,

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,
											
										( SELECT SUM(qte * pu_ht * (1-remise/100) )
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ht,

									 		d.date_creation_doc as date_doc

						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc
							LEFT JOIN doc_cdc dc ON d.ref_doc = dc.ref_doc
							
							".$query_join."

						WHERE ".$query_where."
						GROUP BY d.ref_doc 
						ORDER BY ".$search['orderby']." ".$search['orderorder'];
        }else{
            $query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc, ref_contact, nom_contact, dc.id_stock,

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,

										( SELECT SUM(qte * pu_ht * (1-remise/100) )
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ht,

									 		d.date_creation_doc as date_doc

						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc
							LEFT JOIN doc_blc dc ON d.ref_doc = dc.ref_doc

							".$query_join."

						WHERE ".$query_where."
						GROUP BY d.ref_doc
						ORDER BY ".$search['orderby']." ".$search['orderorder'];
        }
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	// Comptage des résultats
	$query = "SELECT d.ref_doc
						FROM documents d 
						
							LEFT JOIN doc_cdc dc ON d.ref_doc = dc.ref_doc
							".$query_join."
						WHERE ".$query_where."
						GROUP BY d.ref_doc " ;
	
        $resultat = $bdd->query($query);
	while ($result = $resultat->fetchObject()) { $nb_fiches ++; }
	//echo "<br><hr>".nl2br ($query);
	unset ($result, $resultat, $query);

	// sélection des articles
	foreach ($fiches as $fiche) {
	$query = "SELECT dl.ref_doc_line, dl.ref_doc, dl.ref_article, dl.lib_article, dl.desc_article, dl.qte, dl.pu_ht, dlc.qte_livree,dl.remise,
						a.modele, ( (dl.pu_ht-(dl.pu_ht*dl.remise/100)) * (1+tva/100)) as pu_ttc,
										( SELECT SUM(sa.qte) 
									 		FROM stocks_articles sa
									 		WHERE sa.ref_article = dl.ref_article && sa.id_stock = '".$fiche->id_stock."'
									 	) as qte_stock
				FROM docs_lines dl
				LEFT JOIN articles a ON dl.ref_article = a.ref_article
				LEFT JOIN doc_lines_cdc dlc ON dl.ref_doc_line = dlc.ref_doc_line
				WHERE 	ref_doc = '".$fiche->ref_doc."' && dl.ref_article NOT LIKE 'TAXE%'
				GROUP BY ref_doc_line ";
	$resultat = $bdd->query($query);
         
            while ($article = $resultat->fetchObject()) { $detail_art[] = $article; }
            unset ($article, $resultat, $query);

				
	}
if (empty ($detail_art)){?>
    <script type="text/javascript">
    alert("Il n'y a pas d'article dans vos commandes");
    </script>
    <?php
}else{
     if($fiches){
        ini_set("memory_limit","40M");
                // impression pdf du grand livre

        if (!isset($_REQUEST["code_pdf_modele"])) {
                        $_REQUEST["code_pdf_modele"] = get_code_pdf_modele_commande_client();
                        }
                //$infos

                $code_pdf_modele = $_REQUEST["code_pdf_modele"];
                $infos = array();
                $lib = "COMMANDES CLIENTS";
                $infos["lib_type_printed"] = $lib;



                if(isset($_REQUEST["impress"])){
                    $GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
                    $GLOBALS['PDF_OPTIONS']['AutoPrint'] = 1;

                    include_once ($PDF_MODELES_DIR.$code_pdf_modele.".class.php");
                    $class = "pdf_".$code_pdf_modele;
                    $pdf = new $class;
                            // Création
                    $pdf->create_pdf($infos, $fiches,$detail_art);

                    // Sortie

                    $pdf->Output();

                } else {
                    $GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
                    $GLOBALS['PDF_OPTIONS']['AutoPrint'] = 0;

                    include_once ($PDF_MODELES_DIR.$code_pdf_modele.".class.php");
                    $class = "pdf_".$code_pdf_modele;
                    $pdf = new $class;

                            // Création

                        $pdf->create_pdf($infos, $fiches,$detail_art);
                        $pdf->Output();


                    // Sortie
              }
     }else{
     ?>
     <script type="text/javascript">
     alert('Aucun résultats');
     </script>
     <?php

     }
 }?>
