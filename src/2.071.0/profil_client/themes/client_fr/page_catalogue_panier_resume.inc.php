<?php
// *************************************************************************************************************
// résumé du panier
// *************************************************************************************************************


if(!isset($liste_contenu))
{		$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];}

?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td>
			<span>
				<?php if (!count($liste_contenu)) { ?>
					Votre panier est vide.
				<?php } ?>
				<ul id="lignes" style="padding:0px;width:275px">
				<?php  $indentation_contenu = 0;
				foreach ($liste_contenu as $contenu) {
					if ($contenu->type_of_line == "article") { ?>
					<li id="<?php echo $indentation_contenu;?>" style="padding-top:5px; border-top:1px solid #CCCCCC">
						<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_panier_line_".$contenu->type_of_line."_resume.inc.php" ?>
					</li>
					<?php } 
					if ($indentation_contenu == count($liste_contenu )) { echo "</li>";}
					$indentation_contenu++;
				} ?>
				</ul>
				<input type="hidden" value="<?php echo $indentation_contenu;?>" id="indentation_contenu" name="indentation_contenu"/>
			</span>
		</td>
	</tr>
</table>
