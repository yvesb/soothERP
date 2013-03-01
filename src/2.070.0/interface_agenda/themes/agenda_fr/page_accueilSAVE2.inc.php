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
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
	<tr height="80px" >
		<td colspan="3">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
			<tr>
				<td>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/home.gif" style="position:relative; left:5px; top: 5px" alt="Accueil" title="Accueil" />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/print.gif" style="position:relative; left:5px; top: 5px" alt="Imprimer" title="Imprimer" />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/search.gif" style="position:relative; left:5px; top: 5px" alt="Rechercher" title="Rechercher" />
				</td>
			</tr>
			<tr height="30px">
				<td style="text-align:center;">
					<table height="100%" width="100%" cellpadding="0" cellspacing="2" border="0">
						<tr>
						<td></td>
						<td width="45px" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/bt_next_left_bleu_fonce.gif');
						background-repeat:no-repeat; cursor:pointer; text-align:center; vertical-align:middle;">&nbsp;</td>
						<td width="75px" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/fond_bleu_fonce.gif');
						background-repeat:repeat-x; cursor:pointer; text-align:center; vertical-align:middle;">
							<span style="color:white;">Jour</span>
						</td>
						<td width="75px" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/fond_bleu_fonce.gif');
						background-repeat:repeat-x; cursor:pointer; text-align:center; vertical-align:middle;">
							<span style="color:white;">Semaine</span>
						</td>
						<td width="75px" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/fond_bleu_fonce.gif');
						background-repeat:repeat-x; cursor:pointer; text-align:center; vertical-align:middle;">
							<span style="color:white;">Mois</span>
						</td>
						<td width="45px" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/bt_next_right_bleu_fonce.gif');
						background-repeat:no-repeat; cursor:pointer; text-align:center; vertical-align:middle;">&nbsp;</td>
						<td></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr height="20px">
				<td style="text-align:center;">
					<?php echo strftime('%d %B %Y', strtotime("now")); ?>&nbsp;&nbsp;&nbsp;<span id="horloge"></span>
					<script language="JavaScript">
						caisse_heure("horloge");
					</script>
				</td>
			</tr>
			<tr height="10px">
				<td>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	
	<tr height="100%">
	
		<!--  -->
		<td width="150px" style="background-color:#d0cfdd">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
				<tr height="20px" >
					<td colspan="2">
					Agenda
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" border="0" cellpadding="0" cellspacing="5px">
							<tr height="20px">
								<td width="7px"><div style="-moz-border-radius : 3px; background-color:red; width:100%; height: 100%; border: 1px solid black;">&nbsp;</div></td>
								<td><div style="-moz-border-radius : 3px; background-color:white; width:100%; height: 100%; border: 1px solid black;">Service Travau</div></td>
							</tr>
							<tr height="20px">
								<td><div style="-moz-border-radius : 3px; background-color:red; width:100%; height: 100%; border: 1px solid black;">&nbsp;</div></td>
								<td><div style="-moz-border-radius : 3px; background-color:white; width:100%; height: 100%; border: 1px solid black;">Service Travau</div></td>
							</tr>
							<tr height="20px">
								<td><div style="-moz-border-radius : 3px; background-color:red; width:100%; height: 100%; border: 1px solid black;">&nbsp;</div></td>
								<td><div style="-moz-border-radius : 3px; background-color:white; width:100%; height: 100%; border: 1px solid black;">Service Travau</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr height="150px">
					<td>
						<div style="height:100%; vertical-align:bottom;"></div>
						<div ></div>
						
						
						
	  					<table width="100%" border="1" cellpadding="0" cellspacing="0">
	  						<thead>
								  <tr>
								  	<td class="button">«</td>
	  								<td colspan="5" class="button">December 2009</td>
	  								<td class="button">»</td>
	  							</tr>
	  							<tr>
	  								<th class="weekend">L</th>
	  								<th>M</th>
	  								<th>M</th>
	  								<th>J</th>
	  								<th>V</th>
	  								<th>S</th>
	  								<th class="weekend">D</th>
	  							</tr>
	  						</thead>
	  						<tbody>
		  						<tr class="days">
		  							<td class="otherDay weekend">29</td>
		  							<td class="otherDay">30</td>
		  							<td class="">1</td>
		  							<td class="">2</td>
		  							<td class="">3</td>
		  							<td class="">4</td>
		  							<td class="weekend">5</td>
		  						</tr>
		  						<tr class="days">
		  							<td class="weekend">6</td>
		  							<td class="">7</td>
		  							<td class="">8</td>
		  							<td class="">9</td>
		  							<td class="">10</td>
		  							<td class="">11</td>
		  							<td class="weekend">12</td>
		  						</tr>
		  						<tr class="days">
		  							<td class="weekend">13</td>
		  							<td class="">14</td>
		  							<td class="">15</td>
		  							<td class="">16</td>
		  							<td class="">17</td>
		  							<td class="">18</td>
		  							<td class="weekend">19</td>
		  						</tr>
		  						<tr class="days">
		  						<td class="weekend">20</td>
		  							<td class="">21</td>
		  							<td class="">22</td>
		  							<td class="selected today">23</td>
		  							<td class="">24</td>
		  							<td class="">25</td>
		  							<td class="weekend">26</td>
		  						</tr>
		  						<tr class="days">
		  							<td class="weekend">27</td>
		  							<td class="">28</td>
		  							<td class="">29</td>
		  							<td class="">30</td>
		  							<td class="">31</td>
		  							<td class="otherDay">1</td>
		  							<td class="otherDay weekend">2</td>
		  						</tr>
		  						<tr class="days" style="display: none;">
		  							<td class="otherDay weekend">3</td>
		  							<td class="otherDay">4</td>
		  							<td class="otherDay">5</td>
		  							<td class="otherDay">6</td>
		  							<td class="otherDay">7</td>
		  							<td class="otherDay">8</td>
		  							<td class="otherDay weekend">9</td>
		  						</tr>
	  						</tbody>
	  					</table>
        	</td>
				</tr>
			</table>
		</td>
		
		
		<!--  -->
		<td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0"  style="background-color: #9695a5">
				<tr height="20px">
			  	<td width="40px"></td>
			  	<td>
	  				<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td id="td_LUNDI" 		width="14%" style="color:white;text-align:center;"><?php echo strftime('%a %d/%m', strtotime("21-12-2009")); ?></td>
								<td id="td_MARDI" 		width="14%" style="color:white;text-align:center;"><?php echo strftime('%a %d/%m', strtotime("22-12-2009")); ?></td>
								<td id="td_MERCREDI" 	width="14%" style="color:white;text-align:center;"><?php echo strftime('%a %d/%m', strtotime("23-12-2009")); ?></td>
								<td id="td_JEUDI" 		width="14%" style="color:white;text-align:center;"><?php echo strftime('%a %d/%m', strtotime("24-12-2009")); ?></td>
								<td id="td_VENDREDI" 	width="14%" style="color:white;text-align:center;"><?php echo strftime('%a %d/%m', strtotime("25-12-2009")); ?></td>
								<td id="td_SAMEDI" 		width="14%" style="color:white;text-align:center;"><?php echo strftime('%a %d/%m', strtotime("26-12-2009")); ?></td>
								<td id="td_DIMANCHE" 	width="14%" style="color:white;text-align:center;"><?php echo strftime('%a %d/%m', strtotime("27-12-2009")); ?></td>
							</tr>
						</table>
			  	</td>
			  	<td width="15px"></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="7">
						<table width="100%" border="0" cellpadding="3" cellspacing="0" style="background-color:white;">
							<tr>
								<td colspan="7" >
									<div style="-moz-border-radius : 3px; background-color:green; width:100%; height: 100%; padding: px" >Congées Gaelle</div>
								</td>
							</tr>
							<tr>
								<td width="14%"></td>
								<td colspan="5">
									<div style="-moz-border-radius : 3px; background-color:green; width:100%; height: 100%; padding: px" >Congées BOB</div>
								</td>
								<td width="14%"></td>
							</tr>
						</table>
					</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="9">
			<!-- Grille des heures : 1 ligne = 1/2 Heure -->
			<div style="height:580px;overflow:auto" >
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<!-- Jour de la semaine -->
					<tr>
						<td width="40px">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<?php for($i=0; $i<(24*2); $i++){ ?>
								<tr height="<?php echo $tailleDemieHeure;?>px">
									<td><?php echo $i;?></td>
								</tr>	
								<?php }?>
							</table>
						</td>
						<td>
							<table id="grilleDemieHeure" width="100%" border="1" cellpadding="0" cellspacing="0" style="background-color:white;">
							<tr height="<?php echo $tailleDemieHeure;?>px">
									<td id="gride_0_0"><div id="ZERO" style="position:relative;top:0px; left:0px;width:100%"></div></td>
									<td id="gride_0_1"></td>
									<td id="gride_0_2"></td>
									<td id="gride_0_3"></td>
									<td id="gride_0_4"></td>
									<td id="gride_0_5"></td>
									<td id="gride_0_6"></td>
								</tr>
								<?php for($i=1; $i<(24*2); $i++){ ?>
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
			</div>
					</td>
				</tr>
			</table>
			</td>
		<td width="200px">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%" >
				<tr height="20px" style="background-color: #9695a5">
					<td style="text-align:right">Alerte !&nbsp;</td>
				</tr>
				<tr style="background-color:white;" height="5px">
					<td></td>
				</tr>
				<tr style="background-color:white;">
					<td align="center">
						<table width="90%" border="0" cellpadding="0" cellspacing="0" height="100%">
							<tr>
								<td>Evènement</td>
							</tr>
							<tr height="10px">
								<td style="border-top-width:1px; border-top-color:black; border-top-style:solid;"></td>
							</tr>
							<tr>
								<td>
									<input type="text" value = "" style="width:97%"/>
								</td>
							</tr>
							<tr>
								<td>Agenda</td>
							</tr>
							<tr>
								<td>
									<select style="width:100%">
										<option>A</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" /> Toute la journée</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
										<tr>
											<td>du</td>
											<td><input type="text" value = "" style="width:80px"/></td>
											<td>à</td>
											<td><input type="text" value = "" style="width:40px"/></td>
											<td></td>
										</tr>
										<tr>
											<td>du</td>
											<td><input type="text" value = "" style="width:80px"/></td>
											<td>à</td>
											<td><input type="text" value = "" style="width:40px"/></td>
											<td></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr height="10px">
								<td></td>
							</tr>
							<tr>
								<td>Contact</td>
							</tr>
							<tr>
								<td>
									<select style="width:100%">
										<option>C</option>
									</select>
								</td>
							</tr>
							<tr height="10px">
								<td></td>
							</tr>
							<tr>
								<td>Adresse & Coordonnées</td>
							</tr>
							<tr>
								<td>
									<select style="width:100%">
										<option>A</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<input type="button" value="Itinéraie" style="width:75px"/> <input type="button" value="Plan" style="width:50px"/>
								</td>
							</tr>
							<tr height="10px">
								<td></td>
							</tr>
							<tr>
								<td>Adresse & Coordonnées sélectionnées :</td>
							</tr>
							<tr>
								<td>
									3 rue Machin truc <br/>
									BP 61
									34000 Montpellier
									0466223899
								</td>
							</tr>
							<tr height="5px">
								<td style="border-top-width:1px; border-top-color:black; border-top-style:solid;"></td>
							</tr>
							<tr>
								<td>Notes</td>
							</tr>
							<tr>
								<td><textarea rows="2" style="overflow:auto; width:97%"></textarea></td>
							</tr>
							<tr>
								<td></td>
							</tr>
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
<div id="AUTRE1" style="display:none;">
	<input type="button" id="bouton0" value="B" />
	<input type="button" id="boutonPLUS" value="+" />
	<input type="button" id="boutonMOINS" value="-" />
	<input type="button" id="boutonUP" value="UP" />
	<input type="button" id="boutonDOWN" value="DN" />
	<input type="button" id="boutonLEFT" value="&lt;" />
	<input type="button" id="boutonTest2" value="T2" />
	<input type="button" id="boutonTest" value="T" />
</div>
	
<div id="AUTRE2"  style="display:none;">
	<input type="text" id="MouseXPosition"/>
	<input type="text" id="MouseYPosition"/>
	<input type="text" id="stat"/>
	<input type="text" id="dif"/>
	<input type="text" id="target"/>
	<input type="text" id="action"/>
</div>
<div id="AUTRE3" style="display:none;">
	<input type="text" id="info1"/>
	<input type="text" id="info2"/>
	<input type="text" id="info3"/>
	<input type="text" id="info4"/>
	<input type="text" id="info5"/>
	<input type="text" id="info6"/>
</div>
<div id="AUTRE4" style="display:none;">
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
			this.cellJour = Math.floor(left / ($("ZERO").offsetWidth+2));
			this.cellHeurDeb = Math.floor(top / tailleDemieHeure);
			this.cellHeurFin = this.cellHeurDeb + Math.round(this.height / tailleDemieHeure);
		}
		else{
			this.cellJour = Math.floor(this.node.offsetLeft / ($("ZERO").offsetWidth+2));
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
		var futurCellJourJour =  	Math.floor((mouse_X - coords.x) / ($("ZERO").offsetWidth+2));
		var futurX = futurCellJourJour * ($("ZERO").offsetWidth+2);
		var futurY = futurCellHeurDeb * tailleDemieHeure;

		if(futurX >= 0 && futurX <= ($("ZERO").offsetWidth*7)){
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
<div style="display:none">
	<textarea id="textdebug" style="width:99%; height:300px"></textarea>
</div>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
