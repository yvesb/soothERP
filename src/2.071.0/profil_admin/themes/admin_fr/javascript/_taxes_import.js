// taxes import
function import_taxes(page2call) {

		var AppelAjax = new Ajax.Request(
									page2call, {
									method: 'get',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { },
									onSuccess: function (requester){			
									traitetaxe(requester.responseText);	
									}
									}
									);
}



		
	var currentpays="";
	var fin_array= new Array();
	var ceux_present=new Array ();
	var que_ceuxabsent= new Array();
	var que_ceuxdupays= new Array();

function traitetaxe (content) {


	var temp_array= content.split(/\n/);
	var temp_listepays= new Array();
	var listepays= new Array();
	
	temp_listepays.clear();
	listepays.clear();
	fin_array.clear();
	
	temp_array.each(function(s){fin_array.push(s.split(/;/));});
	fin_array.each(function(lp) {temp_listepays.push(lp[2]);});
	listepays=temp_listepays.uniq();


	var AppelAjax = new Ajax.Updater(
									"taxes_pays", 
									"catalogue_taxes_pays.php", {
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { liste_pays: ""+listepays},
									evalScripts:true, 
									onLoading:S_loading, onException: function (){S_failure();}, 
									onComplete:H_loading
									}
									);
	
	 
}


function taxes_dispo(taxes_globarray) {

	que_ceuxabsent.clear();
	que_ceuxdupays.clear();
	pres=false;

	//on récupère les taxes du pays puis les taxes non encore importés
	que_ceuxdupays = taxes_globarray.reject(function(n){return parseInt(n[2])!=currentpays;});
	que_ceuxabsent=que_ceuxdupays.reject(function(n){
				i=0;
				while (i<ceux_present.length) 
				{
					pres=false;
							if(n[0]==ceux_present[i])	{
								pres=true;
								break;
							}
					i++;
				}			
					return pres;					
	});

//on affiche les taxes
	$("taxes_dispo").innerHTML="";
	if (que_ceuxabsent.length<=0){
	$("taxes_dispo").innerHTML="Pas de taxes disponible &agrave; l'importation pour ce pays";
	}
	que_ceuxabsent.uniq().each(function (n){																
	var divli= document.createElement("div");
		divli.setAttribute ("id", "taxe_imp"+n);										
	var link_import= document.createElement("a");
		link_import.setAttribute ("href", "catalogue_taxes_import.php?id_taxe="+escape(n[0])+"&lib_taxe="+escape(n[1])+"&id_pays="+escape(n[2])+"&code_taxe="+escape(n[3])+"&info_calcul="+escape(n[4]));
		link_import.setAttribute ("id", "link_import"+n);				
		link_import.setAttribute ("target", "formFrame");				
	var img_import= document.createElement("img");
		img_import.setAttribute ("src", dirtheme+"images/bt-importer.gif");
		img_import.setAttribute ("id", "img_import"+n);
		$("taxes_dispo").appendChild(divli);
		$("taxe_imp"+n).appendChild(link_import);
		$("link_import"+n).appendChild(img_import);
		new Insertion.Bottom($("taxe_imp"+n), ("&nbsp;&nbsp; "+n[1]+" ("+n[4]+")"))
		
		});
	
	//alert(listepays);
	//alert(fin_array.length);
	//alert(fin_array[1][2]);
	}
