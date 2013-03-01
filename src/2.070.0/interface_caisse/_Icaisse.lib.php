<?php

abstract /*final*/ class Icaisse {
	
	
	const MAGASIN_CHANGED = 0;
	const MAGASIN_NOT_CHANGED = 1;
	const MAGASIN_CAN_NOT_CHANGED = 2;
	
	public static function IcaisseAddInSESSION(){
		$_SESSION['Icaisse'] = array();
	}
	
	public static function IcaisseExistsInSESSION(){
		return isset($_SESSION['Icaisse']);
	}
	
	public static function Icaisse_SESSION_verify(){
		if( ! Icaisse::IcaisseExistsInSESSION())
		{		Icaisse::IcaisseAddInSESSION();}
	}
	
	public static function setSESSION_IdCompteCaisse($id_compte_caisse){
		Icaisse::Icaisse_SESSION_verify();
		$_SESSION['Icaisse']['id_compte_caisse'] = $id_compte_caisse;
	}
	
	public static function getSESSION_IdCompteCaisse(){
		if(Icaisse::IcaisseExistsInSESSION() && isset($_SESSION['Icaisse']['id_compte_caisse']))
		{			return $_SESSION['Icaisse']['id_compte_caisse'];}
		else{	return false;}
	}

	// alogo : retourne 
	//	- vrai si on doit afficher le bouton "Choix du point de vente"
	//		->Au moins 2 magasins sont trouvés avec les conditions suivantes
	//			o actif 
	//			o vente au comptoire
	//			o possède une caisse : Cette caisse sera sauvegardée dans $_SESSION['Icaisse']['id_compte_caisse']
	//	- faut  sinon
	//met la variable "$afficher_magasin" à "true" dés qu'on trouve un 2ème magasin actifs avec la Vente au comptoir
	public static function afficherBoutonChoixPointDeVente(){
		$mag_found = 0;
		reset($_SESSION['magasins']);
		for($i = 0; $i < count($_SESSION['magasins']) ; $i++){
			$index = key($_SESSION['magasins']);
			$listeCaisse = compte_caisse::charger_comptes_caisses($_SESSION['magasins'][$index]->getId_magasin (), true);
			$bVAC = ($_SESSION['magasins'][$index]->getMode_vente() == "VAC");
			$bACTIF = $_SESSION['magasins'][$index]->getActif();
			$bCAISSE = (count($listeCaisse) > 0);
			
			if($bVAC && $bACTIF && $bCAISSE){
				$mag_found++;
				if($mag_found == 2)
				{		return true;}
			}
			next($_SESSION['magasins']);
		}
		return false;
	}
	
	//	alogo : définie comme magasin courrant ($_SESSION['magasins']) le 1er magasin qui réuni les conditions suivantes :
	//	- actif 
	//	- vente au comptoire
	//	- possède une caisse : Cette caisse sera sauvegardée dans $_SESSION['Icaisse']['id_compte_caisse']
	// retour : MAGASIN_CHANGED ou MAGASIN_CAN_NOT_CHANGED
	public static function searchMagasinVACWithCaisseActive(){
		reset($_SESSION['magasins']);
		for($i = 0; $i < count($_SESSION['magasins']) ; $i++){
			$index = key($_SESSION['magasins']);
			$listeCaisse = compte_caisse::charger_comptes_caisses($_SESSION['magasins'][$index]->getId_magasin (), true);
			$bVAC = ($_SESSION['magasins'][$index]->getMode_vente() == "VAC");
			$bACTIF = $_SESSION['magasins'][$index]->getActif();
			$bCAISSE = (count($listeCaisse) > 0);
			
			if($bVAC && $bACTIF && $bCAISSE){
				setcookie('last_id_magasin', $_SESSION['magasins'][$index]->getId_magasin(), time() + (365*24*3600), "/");
				$_SESSION['magasin'] = &$_SESSION['magasins'][$index];
				
				Icaisse::setSESSION_IdCompteCaisse($listeCaisse[0]->id_compte_caisse);
				return Icaisse::MAGASIN_CHANGED;
			}
			next($_SESSION['magasins']);
		}
		return Icaisse::MAGASIN_CAN_NOT_CHANGED;
	}
	
	public static function getMagasinsVACWithCaisseActive(){
	$magasins = array();
	for($i = 0; $i < count($_SESSION['magasins']) ; $i++){
			$index = key($_SESSION['magasins']);
			$listeCaisse 	= compte_caisse::charger_comptes_caisses($_SESSION['magasins'][$index]->getId_magasin (), true);
			$bVAC 				= ($_SESSION['magasins'][$index]->getMode_vente() == "VAC");
			$bACTIF 			= $_SESSION['magasins'][$index]->getActif();
			$bCAISSE 			= (count($listeCaisse) > 0);
			
			if($bVAC && $bACTIF && $bCAISSE)
			{		$magasins[] = $_SESSION['magasins'][$index];}
			next($_SESSION['magasins']);
		}
		return $magasins;
	}
	
	
	public static function getTicket_cell_LIB($lib_article){
		return addslashes(preg_replace('(\r\n|\n|\r)','',$lib_article));
	}
	
	public static function getTicket_cell_QTE($qte){
		return $qte;
	}
	
	public static function getTicket_cell_PUTTC($prix, $tva = null){
		if(is_null($tva))
		{			return price_format($prix);}								// $prix est TTC
		else{	return price_format(ht2ttc($prix, $tva));} 	// $prix est HT
	}
	
	public static function getTicket_cell_REMISE($remise){
		return price_format($remise);
	}
	
	public static function getTicket_cell_PRIXTTC($qte, $prix, $remise,  $tva = null){
		if(is_null($tva))
		{			return price_format($qte * $prix * (1 - ($remise/100)));}								//prix est TTC
		else{	return price_format($qte * ht2ttc($prix, $tva) * (1 - ($remise/100)));}	//prix est HT
	}
}
?>