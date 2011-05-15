<?php
// *************************************************************************************************************
// PAGE DE RE-LOGIN DE L'UTILISATEUR 
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;

require ("_dir.inc.php");
require ($DIR."_session.inc.php");


// Vérification de la page de provennance
if (isset ($_REQUEST['page_from'])) {		$page_from = &$_REQUEST['page_from'];  }
else {																	$page_from = "";  }
// Vérification de l'id_profil
if (isset ($_SESSION['USER_INFOS']['id_profil'])) {		$id_profil = &$_SESSION['USER_INFOS']['id_profil'];  }
else {																	$id_profil = "";  }

// *************************************************************************************************************
// TRAITEMENTS 
// *************************************************************************************************************

// REF_USER ou LOGIN si prédéfini
$predefined_user = "";
if (isset($_SESSION['USER_INFOS']['ref_user'])) {
	$predefined_user = $_SESSION['USER_INFOS']['ref_user'];
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<table cellpadding=0 cellspacing=0 border=0 style="width:100%; background-color:#FFFFFF; text-align:center"><tr><td>
<form action ="<?php echo $_ENV['CHEMIN_ABSOLU']; ?>session_user_valid.php" method=POST name="form_login_inc" target="formFrame">
<input type=hidden name="page_from" value="<?php echo $page_from?>">
<input type=hidden name="id_profil" value="<?php echo $id_profil?>">
<input type=hidden name="try" id="try" value="1">
<table width="100%" cellpadding=0 cellspacing=0 border=0 align="center">
	<tr>
		<td colspan="2" style="text-align:center; font-weight:bolder; line-height:20px; height:20px;  border-bottom:1px solid #000000;">
						
			<a href="#" id="close_ask_login"><img src="<?php echo $_ENV['CHEMIN_ABSOLU']; ?>profil_collab/themes/<?php echo $_SESSION['theme']->getCode_theme();?>/images/supprime.gif" border="0" style="float:right"></a>
			 
			Veuillez vous r&eacute;identifier
			</td>
		</tr>
	<tr>
		<td style="text-align: right"><?php echo ""?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align: right"> Utilisateur : </td>
		<td>
		<?php
		if (isset($_SESSION['USER_INFOS'])) {
			echo  htmlentities($_SESSION['USER_INFOS']['contact_name']); 
			?>
			<br />
			<?php
			echo  htmlentities($_SESSION['USER_INFOS']['pseudo']);
		}
		?>
		<input type="hidden" name='login' size=25 value="<?php echo $predefined_user?>"/>
		</td>
	</tr>
	<tr>
		<td style="text-align: right"> Mot de passe : </td>
		<td><input type=password name="code"  id="code_relogin" size=25 value="" />		</td>
	</tr>
	<tr>
		<td colspan=2 align="center"><div id="session_user_message" style="font:1em Arial, Helvetica, sans-serif; color:#FF0000; font-weight:bolder"></div><br/><input type="submit" name="submit" value="Valider" />		</td>
	</tr>
	<tr>
		<td colspan=2 align="right">	
	<a href="#" onclick="window.open ('../<?php echo $DIR;?>site/__session_stop.php', '_top');" style="text-decoration:none">Quitter</a>
		<script type="text/javascript">
		Event.observe("close_ask_login", "click",  function(evt){Event.stop(evt); close_ask_login();}, false);
		</script>
					
	</td>
	</tr>
</table>
</form>
<script language='javascript'>
	document.form_login_inc.code.focus();
</script>
</td></tr></table>


