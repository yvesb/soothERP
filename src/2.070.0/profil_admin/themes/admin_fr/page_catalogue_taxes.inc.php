<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage

$page_variables = array ("MAJ_SERVEUR['url']");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************

//$Serveur_Distant="http://localhost/serveur_distant";

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
</script>
<div class="emarge">

<p class="titre">Taxes applicables </p>

<div  class="contactview_corps">
<div  style="padding-left:10px; padding-right:10px; height:350px">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2"><br />
			<div style="text-align:center; width:100%;" id="taxes_pays"></div>		</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="50%" align="center">
		<div class="tarif_table" style="width:250px" >
		
			Taxes pr&eacute;sentes:<br />
			<br />
			<div id="taxes_client" style="overflow:auto; width:250px; height:300px; text-align:left;">			</div>		
		</div>		</td>
		<td width="50%" align="center">
		<div class="tarif_table" style="width:250px">
			Taxes disponibles &agrave; l'importation:<br />
			<br />
			<div id="taxes_dispo" style="overflow:auto; width:250px; height:300px; text-align:left;">			</div>
		</div>		</td>
	</tr>
	<tr>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
	</tr>
</table>


</div>

<SCRIPT type="text/javascript">


import_taxes ("<?php echo $MAJ_SERVEUR['url']?>taxes.txt");

</SCRIPT>
</div>
</div>
