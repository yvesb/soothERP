<?php

abstract class Icaisse {
	
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
}
?>