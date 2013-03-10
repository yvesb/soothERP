<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
</script>
<div class="emarge">

<p class="titre">Taux de T.V.A.
<?php
	
	$pays="";
	
	//liste des TVA par pays
	
		foreach ($tvas  as $tva){
			if ($tva['id_pays']!=number_format($pays)) {
				?>
				</p>
				<p>
				<?php echo htmlentities($tva['pays'])?><br />
				<?php $pays	=	 $tva['id_pays'];
			}
				?>
				<?php echo htmlentities($tva['tva']);?>%<br />
<?php 
	}
?>
<SCRIPT type="text/javascript">
</SCRIPT>
</div>