<div id="menu_principal">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td style="width:35%">
				<div class="nom_utilisateur" >
					Bonjour
					<?php if($_SESSION['user']->getLogin()) { 
						echo ", ".str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $_SESSION['user']->getContactName ())); 
					} ?>
				</div>
			</td>
			<td>
				<ul id="menu">
					<li>
						<a href='index.php'>Accueil</a>
					</li>
					<?php if ((!$_SESSION['user']->getLogin() && $AFF_CAT_VISITEUR) || ($_SESSION['user']->getLogin() && $AFF_CAT_CLIENT)) {?>
					<li>
						<a href='catalogue_liste_articles.php'>Catalogue</a> 
					</li>
					<?php } ?>
					<li style="position:relative" id="aff_panier">
						<a href='catalogue_panier_view.php'>Mon Panier</a>
						<span id="panier" style="display:none; padding-left:-5px;">
						<?php include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_resume.inc.php"); ?>
						</span>
						<script type="text/javascript">
							Event.observe('aff_panier', 'mouseover',  function(evt){
								Event.stop(evt);
								$("panier").toggle();
							}, false);
							Event.observe('aff_panier', 'mouseout',  function(evt){
								Event.stop(evt);
								$("panier").toggle();
							}, false);
						</script>
					</li>
					<li>
						<a href='_user_infos.php'>Mon Compte</a> 
					</li>
					<li>
						<a href='contact.php'>Contact</a> 
					</li>
				</ul>
			</td>
			<td style="width:35%">
				<div class="end_menu">
					<?php if($_SESSION['user']->getLogin()) { ?>
					<span id="sedeconnecter" >Se déconnecter</span>
					<script type="text/javascript">
						Event.observe('sedeconnecter', 'click',  function(evt){
							Event.stop(evt);
							window.open ("<?php echo $DIR;?>site/__session_stop.php", "_top");
						}, false);
					</script>
					<?php }else{ ?>
					<span id="seconnecter" >Se connecter</span>
					<script type="text/javascript">
						Event.observe('seconnecter', 'click',  function(evt){
							Event.stop(evt);
							window.open ("_user_login.php", "_top");
						}, false);
					</script>
					<?php } ?>
				</div>
			</td>
		</tr>
	</table>
</div>
