<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript">
<?php 
	switch ($type_print){
		case "print_ticket"  :{ ?>
			if ("createEvent" in document){
				var element = document.createElement("LMBPrintDataElement");
//				alert("url "+window.location.protocol+"//"+window.location.host+window.location.pathname+"caisse_imprimer_doc.php?ref_doc=<?php echo $ticket->getRef_doc();?>");
				element.setAttribute("url", window.location.protocol+"//"+window.location.host+window.location.pathname+"caisse_imprimer_doc.php?ref_doc=<?php echo $ticket->getRef_doc();?>");

				element.setAttribute("printer_type", "ticket");
				document.documentElement.appendChild(element);
				
				var ev = document.createEvent("Events");
				ev.initEvent("LMBPrintRequest", true, false);
				element.dispatchEvent(ev);
			}
			caisse_reset("recherche_article");
			<?php break;
		} 
		case "print_factrure":{ ?>
			if ("createEvent" in document){
				var element = document.createElement("LMBPrintDataElement");
				element.setAttribute("url", window.location.protocol+"//"+window.location.host+window.location.pathname+"caisse_imprimer_doc.php?ref_doc=<?php echo $ref_fac;?>");
				
				element.setAttribute("printer_type", "formatA4");
				document.documentElement.appendChild(element);
				
				var ev = document.createEvent("Events");
				ev.initEvent("LMBPrintRequest", true, false);
				element.dispatchEvent(ev);
			}
			caisse_reset("recherche_article");
			<?php break;
		}
		case "no_print"      :{?>
			//alert("aucune impression");
			caisse_reset("recherche_article");
			<?php break;
		}
		default:{ ?>
			caisse_reset("recherche_article");
		<?php 
			break;
		}
	}
?>

H_loading();
	
</script>

