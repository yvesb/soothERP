<?php
// *************************************************************************************************************
// REINITIALISATION DES FONCTIONS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

global $bdd;

$querys = array();

$querys[] = "SET FOREIGN_KEY_CHECKS=0;";

$querys[] = "DELETE FROM `fonctions`;";

$querys[] = "DELETE FROM `fonctions_permissions`;";

$querys[] = "
INSERT INTO `fonctions` (`id_fonction`, `lib_fonction`, `desc_fonction`, `id_fonction_parent`, `id_profil`) VALUES
(1, 'Direction', '', NULL, 3),
(2, 'Comptable', '', NULL, 3),
(3, 'Commercial', '', NULL, 3),
(4, 'Secrétariat', '', NULL, 3),
(5, 'Marketing', '', NULL, 3),
(6, 'Logistique', '', NULL, 3),
(7, 'Technique', '', NULL, 3);
";

$querys[] = "
INSERT INTO `fonctions_permissions` (`id_fonction`, `id_permission`, `value`) VALUES
(1, 6, 'ALL'),
(1, 7, 'ALL'),
(1, 8, 'ALL'),
(1, 12, 'ALL'),
(1, 15, 'ALL'),
(1, 16, 'ALL'),
(1, 19, 'ALL'),
(2, 5, 'ALL'),
(2, 6, 'ALL'),
(2, 9, 'ALL'),
(2, 10, 'ALL'),
(2, 11, 'ALL'),
(2, 12, 'ALL'),
(2, 13, 'ALL'),
(2, 18, 'ALL'),
(1, 34, 'ALL'),
(1, 20, 'ALL'),
(1, 38, 'ALL'),
(1, 30, 'ALL'),
(1, 14, 'ALL'),
(1, 35, 'ALL'),
(1, 21, 'ALL'),
(1, 11, 'ALL'),
(1, 13, 'ALL'),
(1, 10, 'ALL'),
(1, 37, 'ALL'),
(1, 33, 'ALL'),
(1, 9, 'ALL'),
(1, 5, 'ALL'),
(1, 18, 'ALL'),
(1, 17, 'ALL'),
(1, 27, 'ALL'),
(1, 29, 'ALL'),
(1, 28, 'ALL'),
(1, 24, 'ALL'),
(1, 26, 'ALL'),
(1, 25, 'ALL'),
(1, 32, 'ALL'),
(1, 31, 'ALL'),
(1, 36, 'ALL'),
(1, 22, 'ALL'),
(2, 27, 'ALL'),
(2, 29, 'ALL'),
(2, 28, 'ALL'),
(2, 17, 'ALL'),
(2, 33, 'ALL'),
(2, 37, 'ALL'),
(2, 34, 'ALL'),
(2, 36, 'ALL'),
(2, 22, 'ALL'),
(2, 38, 'ALL'),
(2, 30, 'ALL'),
(3, 24, 'ALL'),
(3, 26, 'ALL'),
(3, 25, 'ALL'),
(3, 36, 'SP,1,4'),
(3, 22, 'SP,1,3,4,7'),
(4, 24, 'ALL'),
(4, 25, 'ALL'),
(4, 36, 'ALL'),
(4, 22, 'ALL'),
(4, 38, 'ALL'),
(5, 14, 'ALL'),
(6, 30, 'ALL'),
(6, 21, 'ALL'),
(6, 35, 'ALL'),
(6, 32, 'ALL'),
(6, 31, 'ALL'),
(7, 24, 'ALL'),
(7, 25, '2'),
(7, 30, 'ALL'),
(7, 32, '12,13'),
(7, 31, '12,13');
";

$querys[] = "SET FOREIGN_KEY_CHECKS=1;";

foreach ($querys as $query){
	$bdd->query ($query);
}

?>
<script type="text/javascript">
window.location.href = "#annuaire_gestion_users_fonctions.php";
window.location.reload();
</script>