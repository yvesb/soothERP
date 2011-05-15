<?php

// *************************************************************************************************************
// ACCUEIL DU PROFIL COLLAB
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

$tailleDemieHeure = 20;
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
	<tr height="80px">
		<td>Entete avec une hauteur fixe 
		</td>
	</tr>
	<tr>
		<td>
			<!-- Grille des heures : 1 ligne = 1/2 Heure -->
			<table width="100%" border="1" cellpadding="0" cellspacing="0">
				<!-- Jour de la semaine -->
				<tr id="position_jour" height="20px">
			  	<td 									width="40px"></td>
			  	<td>
	  				<table width="100%" border="1" cellpadding="0" cellspacing="0">
							<tr height="100%">
								<td id="td_LUNDI" 		width="14%">LUNDI</td>
								<td id="td_MARDI" 		width="14%">MARDI</td>
								<td id="td_MERCREDI" 	width="14%">MERCREDI</td>
								<td id="td_JEUDI" 		width="14%">JEUDI</td>
								<td id="td_VENDREDI" 	width="14%">VENDREDI</td>
								<td id="td_SAMEDI" 		width="14%">SAMEDI</td>
								<td id="td_DIMANCHE" 	width="14%">DIMANCHE</td>
							</tr>
						</table>
			  	</td>
				</tr>
				<tr>
					<td>
						<table width="100%" border="1" cellpadding="0" cellspacing="0">
							<?php for($i=0; $i<(24*1); $i++){ ?>
							<tr height="<?php echo $tailleDemieHeure;?>px">
								<td><?php echo $i;?></td>
							</tr>	
							<?php }?>
						</table>
					</td>
					<td>
						<table id="grilleDemieHeure" width="100%" border="1" cellpadding="0" cellspacing="0">
						<tr height="<?php echo $tailleDemieHeure;?>px">
								<td id="gride_0_0"><div id="ZERO" style="position:relative;top:0px; left:0px;width:100%"></div></td>
								<td id="gride_0_1"></td>
								<td id="gride_0_2"></td>
								<td id="gride_0_3"></td>
								<td id="gride_0_4"></td>
								<td id="gride_0_5"></td>
								<td id="gride_0_6"></td>
							</tr>
							<?php for($i=1; $i<(24*1); $i++){ ?>
							<tr height="<?php echo $tailleDemieHeure;?>px">
								<td id="<?php echo "gride_".$i."_0";?>"></td>
								<td id="<?php echo "gride_".$i."_1";?>"></td>
								<td id="<?php echo "gride_".$i."_2";?>"></td>
								<td id="<?php echo "gride_".$i."_3";?>"></td>
								<td id="<?php echo "gride_".$i."_4";?>"></td>
								<td id="<?php echo "gride_".$i."_5";?>"></td>
								<td id="<?php echo "gride_".$i."_6";?>"></td>
							</tr>
							<?php }?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
			
<?php 
//@TODO Enlever les div AUTRE
?>
<div id="AUTRE1" >
	<input type="button" id="bouton0" value="B" />
	<input type="button" id="boutonPLUS" value="+" />
	<input type="button" id="boutonMOINS" value="-" />
	<input type="button" id="boutonUP" value="UP" />
	<input type="button" id="boutonDOWN" value="DN" />
	<input type="button" id="boutonLEFT" value="&lt;" />
	<input type="button" id="boutonTest2" value="T2" />
	<input type="button" id="boutonTest" value="T" />
</div>
	
<div id="AUTRE2" >
	<input type="text" id="MouseXPosition"/>
	<input type="text" id="MouseYPosition"/>
	<input type="text" id="stat"/>
	<input type="text" id="dif"/>
	<input type="text" id="target"/>
	<input type="text" id="action"/>
</div>
<div id="AUTRE3">
	<input type="text" id="info1"/>
	<input type="text" id="info2"/>
	<input type="text" id="info3"/>
	<input type="text" id="info4"/>
	<input type="text" id="info5"/>
	<input type="text" id="info6"/>
</div>
<div id="AUTRE4">
	<input type="text" id="info7"/>
	<input type="text" id="info8"/>
	<input type="text" id="info9"/>
	<input type="text" id="info10"/>
	<input type="text" id="info11"/>
	<input type="text" id="info12"/>
</div>


<script type="text/javascript">
//DECLARATION DES VARIABLES GLOBALES
	iMouseDown  = false;
	mousePos = null;
	beginMousePos = null;
	action = "";
	tailleDemieHeure = parseInt("<?php echo $tailleDemieHeure; ?>");
	tailleJour = 100;
	evenementUsed = null;
	target = null;

	matriceDemieHeure = new Array();
	for(j = 0; j<7; j++){
		matriceDemieHeure.push(new Array());
		for(h = 0; h<24; h++){
			matriceDemieHeure[j].push(new Array());
		}
	}

	evenements = new Array();
</script>

<script type="text/javascript">
	<?php 
	//@TODO AGNEDA : A ENLEVER
	?>
	//var parent = $("ZERO");
	//parent.appendChild(CreateDivEvenement("eventId_001", 100, (parent.offsetWidth+2) * 2, 100, 200, ""));
</script>

<script type="text/javascript">
//###########################################################################
//DEB CLASSE evenement
//###########################################################################
evenement = Class.create();
evenement.prototype = {
	initialize: function(node, left, top) {
		this.node = node;

		//coordonnées de la souris lorsque qu'on édite ou on bouge un objet evenement
		//this.mouseX = mouseX;
		//this.mouseY = mouseY;
		
		var coordsOfEvent = getCoordsOfEvent(this.node);

		this.id = this.node.id.substr(8);
		
		this.x = coordsOfEvent.x;
		this.y = coordsOfEvent.y;
		this.originalX= this.x;
		this.originalY= this.y;
		
		this.width = node.offsetWidth; 
		this.height = node.offsetHeight;
		this.originalWidth = this.width;
		this.originalHeight = this.height;

		this.cellJour;
		this.cellHeurDeb;
		this.cellHeurFin;
		if(left && top){
			this.cellJour = Math.floor(left / largeurColoneSemaine());
			this.cellHeurDeb = Math.floor(top / tailleDemieHeure);
			this.cellHeurFin = this.cellHeurDeb + Math.round(this.height / tailleDemieHeure);
		}
		else{
			this.cellJour = Math.floor(this.node.offsetLeft / largeurColoneSemaine());
			this.cellHeurDeb = Math.floor(this.node.offsetTop / tailleDemieHeure);
			this.cellHeurFin = this.cellHeurDeb + Math.round(this.height / tailleDemieHeure);
		}
	},

	addIntoMatrice : function(){
		for(i = 0; i < (this.cellHeurFin - this.cellHeurDeb); i++){
			matriceDemieHeure[this.cellJour][this.cellHeurDeb+i].push(this);
		}
	},

	deleteFromMatrice : function(){
		for(i = 0; i < (this.cellHeurFin - this.cellHeurDeb); i++){
			for(k = 0; k<matriceDemieHeure[this.cellJour][this.cellHeurDeb+i].length; k++){
				if(matriceDemieHeure[this.cellJour][this.cellHeurDeb+i][k] == this){
					matriceDemieHeure[this.cellJour][this.cellHeurDeb+i][k] = matriceDemieHeure[this.cellJour][this.cellHeurDeb+i][0];
					matriceDemieHeure[this.cellJour][this.cellHeurDeb+i].shift();
					break;
				}
			}
		}
	},
	
	calculerSaLargeur : function(){
		return tailleJour;
	},

	move : function(mouse_X , mouse_Y){
		
		this.deleteFromMatrice();
		var coords = getCoordsOnGride($("ZERO").parentNode);
		var res = false;
		var futurCellHeurDeb = 		Math.floor((mouse_Y - coords.y + $("sub_content").scrollTop) / tailleDemieHeure);
		var futurCellHeurFin = 		futurCellHeurDeb + Math.round(this.height / tailleDemieHeure);
		var futurCellJourJour =  	Math.floor((mouse_X - coords.x) / largeurColoneSemaine());
		var futurX = futurCellJourJour * largeurColoneSemaine();
		var futurY = futurCellHeurDeb * tailleDemieHeure;

		if(futurX >= 0 && futurX <= (largeurColoneSemaine()*7)){
			this.node.style.left = futurX + "px";
			res = true;
		}
		if(futurY >= 0 && futurY <= (tailleDemieHeure*23)){
			this.node.style.top = futurY + "px";
			res = true;
		}
		if(res){
			this.cellHeurDeb = futurCellHeurDeb;
			this.cellHeurFin = futurCellHeurFin;
			this.cellJour		 = futurCellJourJour;
		}
		this.addIntoMatrice();
		return res;
	},

	edit: function(mouse_X, mouse_Y){
		this.deleteFromMatrice();
		var coords = getCoordsOnGride($("ZERO").parentNode);
		this.cellHeurFin = Math.floor((mouse_Y - coords.y + $("sub_content").scrollTop) / tailleDemieHeure) +1;
		var futurY_deFin = this.cellHeurFin * tailleDemieHeure;

		var res = false;
		
		if(!res && futurY_deFin >= (this.node.offsetTop+3*tailleDemieHeure) && futurY_deFin <= (tailleDemieHeure*24)){
			this.node.style.height = (futurY_deFin - this.node.offsetTop) + "px";
			res = true;
		}
		if(!res && futurY_deFin <= (tailleDemieHeure*24)){
			this.node.style.height = (2*tailleDemieHeure)+"px";
			res = true;
		}
		
		this.addIntoMatrice();
		return res;
	},
	
	save : function(){
	//SI l'event à bougé -> Saubegarde + return TRUE
	//sinon return FALSE
	
	matriceDemieHeure;
	
	if(this.x != this.originalX || this.y != this.originalY || this.width != this.originalWidth || this.height != this.originalHeight){
			//L'event a été modifié -> sauvegarde
			//alert("SAUVEGARDE DE L OBEJET");
			return true;
		}else{
			return false;
		}
	}
}
//###########################################################################
// FIN CLASSE evenement
//###########################################################################
</script>


<script type="text/javascript">
	// ASSOCIATION DES EVENEMENTS SOURIS AUX FONCTIONS
	document.onmousemove = mouseMove2;
	document.onmouseup   = mouseUp2;
	document.onmousedown = mouseDown2;
</script>


<script type="text/javascript">
<?php 
//@TODO AGENDA A ENLEVER
?>


Event.observe("boutonPLUS", "click", function(ev) {
	Event.stop(ev);
	$("textdebug").value += "\nmatriceDemieHeure.length: "+matriceDemieHeure.length+"\n";
	for(h = 0; h<24; h++){
		$("textdebug").value += "\n[";
		for(j = 0; j< 7; j++){
			$("textdebug").value += matriceDemieHeure[j][h].length + "][";
		}
		$("textdebug").value += "]\n";
	}
}, false);

Event.observe("boutonMOINS", "click", function(ev) {
	Event.stop(ev);
	var divTest = $("DIV_DE_TEST");
	divTest.style.height= (parseInt(divTest.style.height)-tailleDemieHeure)+"px";
}, false);

Event.observe("boutonUP", "click", function(ev) {
	Event.stop(ev);
	var divTest = $("DIV_DE_TEST");
	divTest.style.top= (parseInt(divTest.style.top)-tailleDemieHeure)+"px";
}, false);

Event.observe("boutonTest2", "click", function(ev) {
	Event.stop(ev);
	ecarterEvenements(0);
	//ecarterEvenements(1);
	//ecarterEvenements(2);
	//ecarterEvenements(3);
	//ecarterEvenements(4);
	//ecarterEvenements(5);
	//ecarterEvenements(6);
	alert("a");
}, false);

Event.observe("boutonTest", "click", function(ev) {
	$("textdebug").value += "\nmatriceDemieHeure.length: "+matriceDemieHeure.length+"\n";
	for(h = 0; h<24; h++){
		$("textdebug").value += "\n[";
		for(j = 0; j< 7; j++){
			$("textdebug").value += matriceDemieHeure[j][h].length + "][";
		}
		$("textdebug").value += "]\n";
	}
}, false);

Event.observe("bouton0", "click", function(ev) {
	Event.stop(ev);
	for(h =0; h < 24; h++){
		var ce = calculEcartement(matriceDemieHeure[0], h);
		$("textdebug").value += "\ne:" + ce.ecart + " p:" + ce.prof;
	}
}, false);

</script>
<div><textarea id="textdebug" style="width:99%; height:300px"></textarea></div>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
