<?php
// *************************************************************************************************************
// - D'UNE LIGNE D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require_once ($DIR."_article_liaisons_types.class.php");

function cmp_qte($a,$b){
	if ($a["Qte"] == $b["Qte"])
        	return 0;
    		return ($a["Qte"] < $b["Qte"]) ? -1 : 1;
}

function cmp_prix($a,$b){
	if ($a["Prix"] == $b["Prix"])
        	return 0;
    		return ($a["Prix"] < $b["Prix"]) ? -1 : 1;
}

function cmp_ordre($a,$b){
	if ($a["ordre"] == $b["ordre"])
        	return 0;
    		return ($a["ordre"] < $b["ordre"]) ? -1 : 1;
}

	
function traite_liaisons_array(&$Mydoc, $Liaisons,$quantite){
	$result = array();
	
		foreach($Liaisons as $liaison){
		if ($liaison->id_liaison_type == 7){
				if (array_key_exists("ref_article",$liaison)){
				$tmp["Ref_article"] = $liaison->ref_article;
				$tmp["Ratio"] = 1 / $liaison->ratio;
				}else{
				$tmp["Ref_article"] = $liaison->ref_article_lie;	
				$tmp["Ratio"] = $liaison->ratio;
				}
				$Myarticle = new article($tmp["Ref_article"]);

			$tmp["Lib_article"] = $liaison->lib_article;
			$tmp["Qte"] = $quantite * $tmp["Ratio"];
			$tmp["Valo_indice"] = $Myarticle->getValo_indice();
			
			if($tmp["Qte"] < $tmp["Valo_indice"])
			{		$tmp["Qte"] = $tmp["Valo_indice"];}
			$tmp["Prix"] = $tmp["Qte"] * $Mydoc->select_article_pu(&$Myarticle,$tmp["Qte"]);
			$result[] = $tmp;
			} 
		
		}
		return $result;
}
		
		
		
//$result[ref_article_lie]["Ref_article"]
//$result[ref_article_lie]["Ratio"]
//$result[ref_article_lie]["Lib_article"]
//$result[ref_article_lie]["Qte"]
//$result[ref_article_lie]["Valo_indice"]
//$result[ref_article_lie]["Prix"]
function Calcul_pack_equiv(&$Mydoc, &$Myarticle, $Myquantite){
	
		$Liaisons = array();
		$result = array();
		
		$Liaisons = $Myarticle->getLiaisons();
		
		$tmp["Ref_article"] = $Myarticle->getRef_article();	
		$tmp["Lib_article"] = $Myarticle->getLib_article();
		$tmp["Ratio"] = 1;
		$tmp["Valo_indice"] = $Myarticle->getValo_indice();
		while ($Myquantite > 0){
			$tmp["Qte"] = $Myquantite;
			if($tmp["Qte"] < $tmp["Valo_indice"])
			{		$tmp["Qte"] = $tmp["Valo_indice"];}
			$tmp["Prix"] = $tmp["Qte"] * $Mydoc->select_article_pu(&$Myarticle, $tmp["Qte"]);
			$Equiv = traite_liaisons_array(&$Mydoc, $Liaisons, $Myquantite);
			$Equiv[] = $tmp;
			usort($Equiv,"cmp_prix");
		
			$continue = True;
			foreach($Equiv as $produit){
				if($produit["Qte"] >= $produit["Valo_indice"] && $continue){
					$produit["Qte"] = floor($produit["Qte"] / $produit["Valo_indice"]) * $produit["Valo_indice"];
					$Myquantite -= $produit["Qte"]/$produit["Ratio"];
					if(array_key_exists($produit["Ref_article"],$result)){
						$result[ $produit["Ref_article"] ]["Qte"] += $produit["Qte"];
					}else{
						$result[ $produit["Ref_article"] ] = $produit;
					}
					$continue = False;
				}
			}
		}
		return $result;
}		
		
if (!isset($_REQUEST['ref_article'])){
	echo "la référence de l'article n'est pas spécifiée";
	exit;
}

if (!isset($_REQUEST['ref_doc'])){
	echo "la référence du document n'est pas spécifiée";
	exit;
}

if (!isset($_REQUEST['qte_article'])){
	echo "la quantité de l'article n'est pas spécifiée";
	exit;
}


$Myarticle = new article($_REQUEST['ref_article']);
$Mydoc = open_doc($_REQUEST['ref_doc']);
$qte_article = $_REQUEST['qte_article'];
$liaisons_type_liste = art_liaison_type::getLiaisons_type(); 

//$Liaisons=$Myarticle->getLiaisons();

$Pack_liaison = array();

//*****************************************************************************************************
//	Affichage
//*****************************************************************************************************	
	
include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_article_liste_liaisons.inc.php");
?>