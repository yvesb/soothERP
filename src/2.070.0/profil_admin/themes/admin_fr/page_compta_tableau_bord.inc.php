<?php

// *************************************************************************************************************
// TABLEAU DE BORD COMPLET
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
<p class="titre">Tableau de bord</p>


<div class="sous_titre1">CA par catégorie de client</div>
<table width="70%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:40%">&nbsp;</td>
		<td style="text-align:right; width:20%">N</td>
		<td style="text-align:right; width:20%">N-1</td>
		<td style="text-align:right; width:20%">N-2</td>
	</tr>
	<?php
	$total_categ_client_n = 0;
	$total_categ_client_n1 = 0;
	$total_categ_client_n2 = 0;
	foreach ($liste_categories_client as $categ_client) {
		?>
		<tr>
			<td>Chiffre d'affaire <?php echo $categ_client->lib_client_categ;?></td>
			<td style="text-align:right">
			<?php
			if (isset($CA_categ_client[$categ_client->id_client_categ][0])) {
				$total_categ_client_n += $CA_categ_client[$categ_client->id_client_categ][0];
				echo price_format($CA_categ_client[$categ_client->id_client_categ][0])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_categ_client[$categ_client->id_client_categ][1])) {
				$total_categ_client_n1 += $CA_categ_client[$categ_client->id_client_categ][1];
				echo price_format($CA_categ_client[$categ_client->id_client_categ][1])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_categ_client[$categ_client->id_client_categ][2])) {
				$total_categ_client_n2 += $CA_categ_client[$categ_client->id_client_categ][2];
				echo price_format($CA_categ_client[$categ_client->id_client_categ][2])." ".$MONNAIE[1];
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style="font-weight:bolder">Chiffre d'affaire TOTAL:</td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_categ_client_n)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_categ_client_n1)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_categ_client_n2)." ".$MONNAIE[1];?></td>
	</tr>
</table>
<br />
<br />

<div class="sous_titre1">Achats par catégorie de fournisseur</div>
<table width="70%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:40%">&nbsp;</td>
		<td style="text-align:right; width:20%">N</td>
		<td style="text-align:right; width:20%">N-1</td>
		<td style="text-align:right; width:20%">N-2</td>
	</tr>
	<?php
	$total_categ_fournisseur_n = 0;
	$total_categ_fournisseur_n1 = 0;
	$total_categ_fournisseur_n2 = 0;
	foreach ($liste_categories_fournisseur as $categ_fournisseur) {
		?>
		<tr>
			<td>Chiffre d'affaire <?php echo $categ_fournisseur->lib_fournisseur_categ;?></td>
			<td style="text-align:right">
			<?php
			if (isset($CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][0])) {
				$total_categ_fournisseur_n += $CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][0];
				echo price_format($CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][0])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][1])) {
				$total_categ_fournisseur_n1 += $CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][1];
				echo price_format($CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][1])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][2])) {
				$total_categ_fournisseur_n2 += $CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][2];
				echo price_format($CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][2])." ".$MONNAIE[1];
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style="font-weight:bolder">Chiffre d'affaire TOTAL:</td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_categ_fournisseur_n)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_categ_fournisseur_n1)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_categ_fournisseur_n2)." ".$MONNAIE[1];?></td>
	</tr>
</table>

<br />
<br />

<div class="sous_titre1">CA par point de vente</div>
<table width="70%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:40%">&nbsp;</td>
		<td style="text-align:right; width:20%">N</td>
		<td style="text-align:right; width:20%">N-1</td>
		<td style="text-align:right; width:20%">N-2</td>
	</tr>
	<?php
	$total_magasin_n = 0;
	$total_magasin_n1 = 0;
	$total_magasin_n2 = 0;
	foreach ($magasins_liste as $magasin) {
		?>
		<tr>
			<td>Chiffre d'affaire <?php echo $magasin->lib_magasin;?></td>
			<td style="text-align:right">
			<?php
			if (isset($CA_magasins[$magasin->id_magasin][0])) {
				$total_magasin_n += $CA_magasins[$magasin->id_magasin][0];
				echo price_format($CA_magasins[$magasin->id_magasin][0])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_magasins[$magasin->id_magasin][1])) {
				$total_magasin_n1 += $CA_magasins[$magasin->id_magasin][1];
				echo price_format($CA_magasins[$magasin->id_magasin][1])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_magasins[$magasin->id_magasin][2])) {
				$total_magasin_n2 += $CA_magasins[$magasin->id_magasin][2];
				echo price_format($CA_magasins[$magasin->id_magasin][2])." ".$MONNAIE[1];
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style="font-weight:bolder">Chiffre d'affaire TOTAL:</td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_magasin_n)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_magasin_n1)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_magasin_n2)." ".$MONNAIE[1];?></td>
	</tr>
</table>

<br />
<br />

<div class="sous_titre1">CA par activité</div>
<table width="70%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:40%">&nbsp;</td>
		<td style="text-align:right; width:20%">N</td>
		<td style="text-align:right; width:20%">N-1</td>
		<td style="text-align:right; width:20%">N-2</td>
	</tr>
	<?php
	$total_activite_n = 0;
	$total_activite_n1 = 0;
	$total_activite_n2 = 0;
	foreach ($liste_art_categ as $art_categ) {
		?>
		<tr>
			<td>Chiffre d'affaire <?php echo $art_categ->lib_art_categ;?></td>
			<td style="text-align:right">
			<?php
			if (isset($CA_activites[$art_categ->ref_art_categ][0])) {
				$total_activite_n += $CA_activites[$art_categ->ref_art_categ][0];
				echo price_format($CA_activites[$art_categ->ref_art_categ][0])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_activites[$art_categ->ref_art_categ][1])) {
				$total_activite_n1 += $CA_activites[$art_categ->ref_art_categ][1];
				echo price_format($CA_activites[$art_categ->ref_art_categ][1])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_activites[$art_categ->ref_art_categ][2])) {
				$total_activite_n2 += $CA_activites[$art_categ->ref_art_categ][2];
				echo price_format($CA_activites[$art_categ->ref_art_categ][2])." ".$MONNAIE[1];
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style="font-weight:bolder">Chiffre d'affaire TOTAL:</td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_activite_n)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_activite_n1)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_activite_n2)." ".$MONNAIE[1];?></td>
	</tr>
</table>


<br />
<br />

<div class="sous_titre1">Marchandises en stock</div>
<table width="70%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:40%">&nbsp;</td>
		<td style="text-align:right; width:20%">N</td>
		<td style="text-align:right; width:20%">N-1</td>
		<td style="text-align:right; width:20%">N-2</td>
	</tr>
	<?php
	$total_valeur_stocks_n = 0;
	$total_valeur_stocks_n1 = 0;
	$total_valeur_stocks_n2 = 0;
	foreach ($stocks_liste as $stock) {
		?>
		<tr>
			<td>Stock <?php echo $stock->lib_stock;?></td>
			<td style="text-align:right">
			<?php
			if (isset($CA_valeur_stocks[$stock->id_stock][0])) {
				$total_valeur_stocks_n += $CA_valeur_stocks[$stock->id_stock][0];
				echo price_format($CA_valeur_stocks[$stock->id_stock][0])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_valeur_stocks[$stock->id_stock][1])) {
				$total_valeur_stocks_n1 += $CA_valeur_stocks[$stock->id_stock][1];
				echo price_format($CA_valeur_stocks[$stock->id_stock][1])." ".$MONNAIE[1];
			}
			?>
			</td>
			<td style="text-align:right">
			<?php
			if (isset($CA_valeur_stocks[$stock->id_stock][2])) {
				$total_valeur_stocks_n2 += $CA_valeur_stocks[$stock->id_stock][2];
				echo price_format($CA_valeur_stocks[$stock->id_stock][2])." ".$MONNAIE[1];
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style="font-weight:bolder">Stock TOTAL:</td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_valeur_stocks_n)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_valeur_stocks_n1)." ".$MONNAIE[1];?></td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_valeur_stocks_n2)." ".$MONNAIE[1];?></td>
	</tr>
</table>


<br />
<br />



<div class="sous_titre1">Comptes bancaires</div>
<table width="40%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:60%">&nbsp;</td>
		<td style="text-align:right; width:40%"> </td>
	</tr>
	<?php
	$total_compte_bancaire= 0;
	foreach ($comptes_bancaires as $compte_b) {
		?>
		<tr>
			<td>Compte <?php echo $compte_b->lib_compte;?> n° <?php echo $compte_b->numero_compte;?></td>
			<td style="text-align:right">
			<?php
			if (isset($Solde_compte_bancaire[$compte_b->id_compte_bancaire])) {
				$total_compte_bancaire += $Solde_compte_bancaire[$compte_b->id_compte_bancaire];
				echo price_format($Solde_compte_bancaire[$compte_b->id_compte_bancaire])." ".$MONNAIE[1];
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style="font-weight:bolder">TOTAL:</td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_compte_bancaire)." ".$MONNAIE[1];?></td>
	</tr>
</table>


<br />
<br />


<div class="sous_titre1">Caisses </div>
<table width="40%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:60%">&nbsp;</td>
		<td style="text-align:right; width:40%"> </td>
	</tr>
	<?php
	$total_caisse= 0;
	foreach ($comptes_caisses as $caisse) {
		?>
		<tr>
			<td>Caisse <?php echo $caisse->lib_caisse;?></td>
			<td style="text-align:right">
			<?php
			if (isset($Solde_caisses[$caisse->id_compte_caisse])) {
				$total_caisse += $Solde_caisses[$caisse->id_compte_caisse];
				//echo price_format($Solde_caisses[$caisse->id_compte_caisse])." ".$MONNAIE[1];
				echo "XX ".$MONNAIE[1];
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style="font-weight:bolder">TOTAL:</td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_caisse)." ".$MONNAIE[1];?></td>
	</tr>
</table>

<br />
<br />


<div class="sous_titre1">Soldes des comptes clients </div>
<table width="40%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:60%">&nbsp;</td>
		<td style="text-align:right; width:40%"> </td>
	</tr>
	<?php
	$total_compte_client= 0;
	foreach ($liste_categories_client as $categ_client) {
		?>
		<tr>
			<td><?php echo $categ_client->lib_client_categ;?></td>
			<td style="text-align:right">
			<?php
			if (isset($Solde_categ_client[$categ_client->id_client_categ])) {
				$total_compte_client += $Solde_categ_client[$categ_client->id_client_categ];
				echo price_format($Solde_categ_client[$categ_client->id_client_categ])." ".$MONNAIE[1];
				//echo "XX ".$MONNAIE[1];
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style="font-weight:bolder">Solde <?php if ( $total_compte_client< 0) {  ?>débiteur<?php } else {?>créditeur<?php } ?>:</td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_compte_client)." ".$MONNAIE[1];?></td>
	</tr>
</table>

<br />
<br />


<div class="sous_titre1">Solde des comptes fournisseurs</div>
<table width="40%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:60%">&nbsp;</td>
		<td style="text-align:right; width:40%"> </td>
	</tr>
	<?php
	$total_compte_fournisseur= 0;
	foreach ($liste_categories_fournisseur as $categ_fournisseur) {
		?>
		<tr>
			<td><?php echo $categ_fournisseur->lib_fournisseur_categ;?></td>
			<td style="text-align:right">
			<?php
			if (isset($Solde_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ])) {
				$total_compte_fournisseur += $Solde_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ];
				echo price_format($Solde_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ])." ".$MONNAIE[1];
				//echo "XX ".$MONNAIE[1];
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style="font-weight:bolder">Solde <?php if ( $total_compte_fournisseur< 0) {  ?>débiteur<?php } else {?>créditeur<?php } ?>:</td>
		<td style="text-align:right; font-weight:bolder"><?php echo price_format($total_compte_fournisseur)." ".$MONNAIE[1];?></td>
	</tr>
</table>

<br />
<br />



</div>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>