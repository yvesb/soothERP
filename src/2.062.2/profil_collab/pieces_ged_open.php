<?php
// *************************************************************************************************************
// ENREGISTREMENT DU NOMBRE DE TELECHARGEMENT
// *************************************************************************************************************

require ("_dir.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_piece"])) {

	$query = "SELECT pa.id_piece, pa.type_objet, pa.ref_objet, p.lib_piece, p.fichier, p.note
						FROM pieces_associations pa 
							LEFT JOIN pieces p ON p.id_piece = pa.id_piece 
						WHERE pa.id_piece = '".$_REQUEST["id_piece"]."' ";
	$resultat = $bdd->query ($query);
	if ($lib = $resultat->fetchObject()) {
	copy($GED_DIR.$lib->fichier, $GED_DIR.$lib->lib_piece);
		?><html>
		<head>
		<meta http-equiv="Refresh" content="0;URL=<?php echo $GED_DIR.$lib->lib_piece;?>">
		</head>
		</html>
		<?php	
	}
}
?>