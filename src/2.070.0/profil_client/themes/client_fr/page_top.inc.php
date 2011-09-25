<div id="header">
<table style="width:100%; " class="main_table">
	<tr>
		<td style="vertical-align: middle" align="center">
		<?php if (file_exists($DIR.$_SESSION['theme']->getDir_theme()."images/".$NOM_LOGO)) {?>
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/<?php echo $NOM_LOGO;?>" />
		<?php } ?>
		</td>
		<td style="vertical-align: bottom">
		<div id="rechercher_simple_entete">
		<form name="rechercher_simple" id="rechercher_simple" action="catalogue_liste_articles.php">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/recherche_simple_1.gif"/></td>
				<td>
					<input type="text" id="lib_article" name="lib_article" value="" class="input_rechercher_top"/>
				</td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/recherche_simple_bt.gif" id="start_recherche_simple" style="cursor:pointer" /></td>
			</tr>
		</table>
		</form>
				<script type="text/javascript">
				Event.observe('start_recherche_simple', 'click',  function(evt){
					Event.stop(evt);
					$("rechercher_simple").submit();
					}
				);
				</script>
		</div>
		</td>
		<td style="vertical-align: bottom">
		<div id="logo_lmb">
		<a href="http://www.lundimatin.fr" target="_blank">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/entete_logolmb.gif" />
		</a>
		</div>
		</td>

	</tr>
</table>
</div>