<?php
require ("_dir.inc.php");
require ("_profil.inc.php");


$ref_contact = $_POST["ref_contact"];
$ref_coord = $_POST["ref_coord"];								
$coordonnee = new coordonnee($ref_coord);
$coordonnee->envoi_mail_invitation();

?>
<SCRIPT type="text/javascript">
alert("<?php echo "Invitation envoyée";?>");
page.traitecontent('userlist', 'annuaire_view_fiche.php?ref_contact=<?php echo $ref_contact;?>' ,"true" ,"sub_content");
</script>