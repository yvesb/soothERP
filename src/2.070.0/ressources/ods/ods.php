<?php
/*-
 * Copyright (c) 2009 Laurent VUIBERT
 * License : GNU Lesser General Public License v3
 */

require_once("class/odsFontFace.php");
require_once("class/odsStyle.php");
require_once("class/odsTable.php");
require_once("class/odsTableColumn.php");
require_once("class/odsTableRow.php");
require_once("class/odsTableCell.php");
require_once("class/odsDraw.php");

class ods {
	private $defaultTable;
	
	private $scripts;        // FIXME: Looking
	private $fontFaces;
	private $styles;
	private $tmpStyles;
	private $tmpPictures;
	private $tables;
	
	private $title;
	private $subject;
	private $keyword;
	private $description;
	
	public function __construct() {
		$this->title         = null;
		$this->subject       = null;
		$this->keyword       = null;
		$this->description   = null;
		$this->path2OdsFiles = ".";
		
		$this->defaultTable = null;
		
		$this->scripts   = array();
		$this->fontFaces = array();
		$this->styles    = array();
		$this->tables    = array();
		
		$this->addFontFaces( new odsFontFace( "Nimbus Sans L", "swiss" ) );
		$this->addFontFaces( new odsFontFace( "Bitstream Vera Sans", "system" ) );
		
		$this->addStyles( new odsStyleTableColumn("co1") );
		$this->addStyles( new odsStyleTable("ta1") );
		$this->addStyles( new odsStyleTableRow("ro1") );
		$this->addStyles( new odsStyleTableCell("ce1") );
		
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	
	public function setKeyword($keyword) {
		$this->keyword = $keyword;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	// Deprecated
	public function setPath2OdsFiles($path) {}
	
	public function addFontFaces(odsFontFace $odsFontFace) {
		if(in_array($odsFontFace,$this->fontFaces)) return;
		$this->fontFaces[$odsFontFace->getFontName()] = $odsFontFace;
	}
	
	public function addStyles(odsStyle $odsStyle) {
		if(in_array($odsStyle,$this->styles)) return;
		$this->styles[$odsStyle->getName()] = $odsStyle;
	}
	
	public function addTmpStyles(odsStyle $odsStyle) {
		if(in_array($odsStyle,$this->styles)) return;
		if(in_array($odsStyle,$this->tmpStyles)) return;
		$this->tmpStyles[$odsStyle->getName()] = $odsStyle;
		//echo "addTmpStyles:".$odsStyle->getName()."\n";
	}
	
	public function addTmpPictures($file) {
		if(in_array($file,$this->tmpPictures)) return;
		$this->tmpPictures[$file] = "Pictures/".md5(time().rand()).'.jpg';
		return $this->tmpPictures[$file];
	}
	
	public function getStyleByName($name) {
		if(isset($this->styles[$name])) return $this->styles[$name];
		if(isset($this->tmpStyles[$name])) return $this->tmpStyles[$name];
		return null; 
	}
	
	public function addTable(odsTable $odsTable) {
		if(in_array($odsTable,$this->tables)) return;
		$this->tables[$odsTable->getName()] = $odsTable;
	}
	
	public function setDefaultTable(odsTable $odsTable) {
		$this->defaultTable = $odsTable;
	}
	
	private function getDefaultTableName() {
		if($this->defaultTable) {
			return $this->defaultTable->getName();
		} elseif(count($this->tables)){
			$keys = array_keys($this->tables);
			//var_dump($keys);
			return $this->tables[$keys[0]]->getName();
		} else {
			return "feuille1";
		}
	}
	
	public function getContent() {
		$this->tmpStyles = array();
		$this->tmpPictures = array();
		
		$dom = new DOMDocument('1.0', 'UTF-8');
		$root = $dom->createElement('office:document-content');
			$root->setAttribute("xmlns:office", "urn:oasis:names:tc:opendocument:xmlns:office:1.0");
			$root->setAttribute("xmlns:style", "urn:oasis:names:tc:opendocument:xmlns:style:1.0");
			$root->setAttribute("xmlns:text", "urn:oasis:names:tc:opendocument:xmlns:text:1.0");
			$root->setAttribute("xmlns:table", "urn:oasis:names:tc:opendocument:xmlns:table:1.0");
			$root->setAttribute("xmlns:draw", "urn:oasis:names:tc:opendocument:xmlns:drawing:1.0");
			$root->setAttribute("xmlns:fo", "urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0");
			$root->setAttribute("xmlns:xlink", "http://www.w3.org/1999/xlink");
			$root->setAttribute("xmlns:dc", "http://purl.org/dc/elements/1.1/");
			$root->setAttribute("xmlns:meta", "urn:oasis:names:tc:opendocument:xmlns:meta:1.0");
			$root->setAttribute("xmlns:number", "urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0");
			$root->setAttribute("xmlns:presentation", "urn:oasis:names:tc:opendocument:xmlns:presentation:1.0");
			$root->setAttribute("xmlns:svg", "urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0");
			$root->setAttribute("xmlns:chart", "urn:oasis:names:tc:opendocument:xmlns:chart:1.0");
			$root->setAttribute("xmlns:dr3d", "urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0");
			$root->setAttribute("xmlns:math", "http://www.w3.org/1998/Math/MathML");
			$root->setAttribute("xmlns:form", "urn:oasis:names:tc:opendocument:xmlns:form:1.0");
			$root->setAttribute("xmlns:script", "urn:oasis:names:tc:opendocument:xmlns:script:1.0");
			$root->setAttribute("xmlns:ooo", "http://openoffice.org/2004/office");
			$root->setAttribute("xmlns:ooow", "http://openoffice.org/2004/writer");
			$root->setAttribute("xmlns:oooc", "http://openoffice.org/2004/calc");
			$root->setAttribute("xmlns:dom", "http://www.w3.org/2001/xml-events");
			$root->setAttribute("xmlns:xforms", "http://www.w3.org/2002/xforms");
			$root->setAttribute("xmlns:xsd", "http://www.w3.org/2001/XMLSchema");
			$root->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
			$root->setAttribute("xmlns:rpt", "http://openoffice.org/2005/report");
			$root->setAttribute("xmlns:of", "urn:oasis:names:tc:opendocument:xmlns:of:1.2");
			$root->setAttribute("xmlns:rdfa", "http://docs.oasis-open.org/opendocument/meta/rdfa#");
			$root->setAttribute("xmlns:field", "urn:openoffice:names:experimental:ooxml-odf-interop:xmlns:field:1.0");
			$root->setAttribute("xmlns:formx", "urn:openoffice:names:experimental:ooxml-odf-interop:xmlns:form:1.0");
			$root->setAttribute("office:version", "1.2");
			$dom->appendChild($root);

		// office:scripts
		$root->appendChild($dom->createElement('office:scripts'));
		
		//office:font-face-decls
		$office_font_face_decls =  $dom->createElement('office:font-face-decls');
		$root->appendChild($office_font_face_decls);
		
			foreach($this->fontFaces as $fontFace)
				$office_font_face_decls->appendChild($fontFace->getContent($this,$dom));

		// office:automatic-styles
		$office_automatic_styles =  $dom->createElement('office:automatic-styles');
			$root->appendChild($office_automatic_styles);
			
			foreach($this->styles as $style)
				$office_automatic_styles->appendChild($style->getContent($this,$dom));

		// office:body
		$office_body =  $dom->createElement('office:body');
			$root->appendChild($office_body);
		
			// office:spreadsheet
			$office_spreadsheet = $dom->createElement('office:spreadsheet');
				$office_body->appendChild($office_spreadsheet);

					foreach($this->tables as $table)
						$office_spreadsheet->appendChild($table->getContent($this,$dom));
		
			// the $this->tmpStyle can change in for ( add new elemements only )
			for($i=0; $i<count($this->tmpStyles); $i++) {
				$keys = array_keys($this->tmpStyles);
				$style = $this->tmpStyles[$keys[$i]];
				//echo "createTmpStyle:".$style->getName()."\n";
				$office_automatic_styles->appendChild($style->getContent($this,$dom));
			}
		
		return $dom->saveXML();
	}
	
	public function getMeta() {
		$dom = new DOMDocument('1.0', 'UTF-8');
		
		$root = $dom->createElement('office:document-meta');
			$root->setAttribute("xmlns:office", "urn:oasis:names:tc:opendocument:xmlns:office:1.0");
			$root->setAttribute("xmlns:xlink", "http://www.w3.org/1999/xlink");
			$root->setAttribute("xmlns:dc", "http://purl.org/dc/elements/1.1/");
			$root->setAttribute("xmlns:meta", "urn:oasis:names:tc:opendocument:xmlns:meta:1.0");
			$root->setAttribute("xmlns:ooo", "http://openoffice.org/2004/office");
			$root->setAttribute("office:version", "1.2");
			$dom->appendChild($root);
		
		$meta =  $dom->createElement('office:meta');
			$root->appendChild($meta);
		
		$meta->appendChild($dom->createElement('meta:creation-date',date("Y-m-d\TH:j:s")));
		$meta->appendChild($dom->createElement('meta:generator','ods générator'));
		$meta->appendChild($dom->createElement('dc:date',date("Y-m-d\TH:j:s")));
		$meta->appendChild($dom->createElement('meta:editing-duration','PT1S'));
		$meta->appendChild($dom->createElement('meta:editing-cycles','1'));
		if($this->title)
			$meta->appendChild($dom->createElement('dc:title',$this->title));
		if($this->subject)
			$meta->appendChild($dom->createElement('dc:subject',$this->subject));
		if($this->keyword)
			$meta->appendChild($dom->createElement('meta:keyword',$this->keyword));
		if($this->description)
			$meta->appendChild($dom->createElement('dc:description',$this->description));
		$elm = $dom->createElement('meta:document-statistic');
			$elm->setAttribute("meta:table-count", "1");
			$elm->setAttribute("meta:cell-count", "4");
			$elm->setAttribute("meta:object-count", "0");
			$meta->appendChild($elm);
		
		return $dom->saveXML();
	}
	
	public function getSettings() {
		$dom = new DOMDocument('1.0', 'UTF-8');
		
		$root = $dom->createElement('office:document-settings');
			$root->setAttribute("xmlns:office", "urn:oasis:names:tc:opendocument:xmlns:office:1.0");
			$root->setAttribute("xmlns:xlink",  "http://www.w3.org/1999/xlink");
			$root->setAttribute("xmlns:config", "urn:oasis:names:tc:opendocument:xmlns:config:1.0");
			$root->setAttribute("xmlns:ooo",    "http://openoffice.org/2004/office");
			$root->setAttribute("office:version", "1.2");
			$dom->appendChild($root);
		
			$office_settings =  $dom->createElement('office:settings');
				$root->appendChild($office_settings);
			
				$config_config_item_set = $dom->createElement('config:config-item-set');
					$config_config_item_set->setAttribute("config:name", "ooo:view-settings");
					$office_settings->appendChild($config_config_item_set);
				
					$config_config_item = $dom->createElement('config:config-item',0);
						$config_config_item->setAttribute("config:name", "VisibleAreaTop");
						$config_config_item->setAttribute("config:type", "int");
						$config_config_item_set->appendChild($config_config_item);
			
					$config_config_item = $dom->createElement('config:config-item',0);
						$config_config_item->setAttribute("config:name", "VisibleAreaLeft");
						$config_config_item->setAttribute("config:type", "int");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item',10018);
						$config_config_item->setAttribute("config:name", "VisibleAreaWidth");
						$config_config_item->setAttribute("config:type", "int");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item',2592);
						$config_config_item->setAttribute("config:name", "VisibleAreaHeight");
						$config_config_item->setAttribute("config:type", "int");
						$config_config_item_set->appendChild($config_config_item);
					
					$config_config_item_map_indexed = $dom->createElement('config:config-item-map-indexed');
						$config_config_item_map_indexed->setAttribute("config:name", "Views");
						$config_config_item_set->appendChild($config_config_item_map_indexed);
			
						$config_config_item_map_entry1 = $dom->createElement('config:config-item-map-entry');
							$config_config_item_map_indexed->appendChild($config_config_item_map_entry1);
			
							//<config:config-item config:name="ViewId" config:type="string">View1</config:config-item>
							$config_config_item = $dom->createElement('config:config-item', 'View1');
								$config_config_item->setAttribute("config:name", "ViewId");
								$config_config_item->setAttribute("config:type", "string");
								$config_config_item_map_entry1->appendChild($config_config_item);
								
							//<config:config-item-map-named config:name="Tables">
							$config_config_item_map_named = $dom->createElement('config:config-item-map-named');
								$config_config_item_map_named->setAttribute("config:name", "Tables");
								$config_config_item_map_entry1->appendChild($config_config_item_map_named);
								
								foreach($this->tables as $table)
									$config_config_item_map_named->appendChild($table->getSettings($this,$dom));

							$config_config_item = $dom->createElement('config:config-item', $this->getDefaultTableName());
								$config_config_item->setAttribute("config:name", "ActiveTable");
								$config_config_item->setAttribute("config:type", "string");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', '270');
								$config_config_item->setAttribute("config:name", "HorizontalScrollbarWidth");
								$config_config_item->setAttribute("config:type", "int");
								$config_config_item_map_entry1->appendChild($config_config_item);


							$config_config_item = $dom->createElement('config:config-item', '0');
								$config_config_item->setAttribute("config:name", "ZoomType");
								$config_config_item->setAttribute("config:type", "short");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', '100');
								$config_config_item->setAttribute("config:name", "ZoomValue");
								$config_config_item->setAttribute("config:type", "int");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', '60');
								$config_config_item->setAttribute("config:name", "PageViewZoomValue");
								$config_config_item->setAttribute("config:type", "int");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'false');
								$config_config_item->setAttribute("config:name", "ShowPageBreakPreview");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'true');
								$config_config_item->setAttribute("config:name", "ShowZeroValues");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'true');
								$config_config_item->setAttribute("config:name", "ShowNotes");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'true');
								$config_config_item->setAttribute("config:name", "ShowGrid");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', '12632256');
								$config_config_item->setAttribute("config:name", "GridColor");
								$config_config_item->setAttribute("config:type", "long");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'true');
								$config_config_item->setAttribute("config:name", "ShowPageBreaks");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);
										
							$config_config_item = $dom->createElement('config:config-item', 'true');
								$config_config_item->setAttribute("config:name", "HasColumnRowHeaders");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'true');
								$config_config_item->setAttribute("config:name", "HasSheetTabs");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'true');
								$config_config_item->setAttribute("config:name", "IsOutlineSymbolsSet");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'false');
								$config_config_item->setAttribute("config:name", "IsSnapToRaster");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'false');
								$config_config_item->setAttribute("config:name", "RasterIsVisible");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', '1000');
								$config_config_item->setAttribute("config:name", "RasterResolutionX");
								$config_config_item->setAttribute("config:type", "int");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', '1000');
								$config_config_item->setAttribute("config:name", "RasterResolutionY");
								$config_config_item->setAttribute("config:type", "int");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', '1');
								$config_config_item->setAttribute("config:name", "RasterSubdivisionX");
								$config_config_item->setAttribute("config:type", "int");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', '1');
								$config_config_item->setAttribute("config:name", "RasterSubdivisionY");
								$config_config_item->setAttribute("config:type", "int");
								$config_config_item_map_entry1->appendChild($config_config_item);

							$config_config_item = $dom->createElement('config:config-item', 'true');
								$config_config_item->setAttribute("config:name", "IsRasterAxisSynchronized");
								$config_config_item->setAttribute("config:type", "boolean");
								$config_config_item_map_entry1->appendChild($config_config_item);

				$config_config_item_set = $dom->createElement('config:config-item-set');
					$config_config_item_set->setAttribute("config:name", "ooo:configuration-settings");
					$office_settings->appendChild($config_config_item_set);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "ShowZeroValues");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "ShowNotes");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "ShowGrid");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', '12632256');// test 0
						$config_config_item->setAttribute("config:name", "GridColor");
						$config_config_item->setAttribute("config:type", "long");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "ShowPageBreaks");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', '3');
						$config_config_item->setAttribute("config:name", "LinkUpdateMode");
						$config_config_item->setAttribute("config:type", "short");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "HasColumnRowHeaders");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "HasSheetTabs");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "IsOutlineSymbolsSet");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'false');
						$config_config_item->setAttribute("config:name", "IsSnapToRaster");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'false');
						$config_config_item->setAttribute("config:name", "RasterIsVisible");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', '1000');
						$config_config_item->setAttribute("config:name", "RasterResolutionX");
						$config_config_item->setAttribute("config:type", "int");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', '1000');
						$config_config_item->setAttribute("config:name", "RasterResolutionY");
						$config_config_item->setAttribute("config:type", "int");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', '1');
						$config_config_item->setAttribute("config:name", "RasterSubdivisionX");
						$config_config_item->setAttribute("config:type", "int");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', '1');
						$config_config_item->setAttribute("config:name", "RasterSubdivisionY");
						$config_config_item->setAttribute("config:type", "int");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "IsRasterAxisSynchronized");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "AutoCalculate");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item');
						$config_config_item->setAttribute("config:name", "PrinterName");
						$config_config_item->setAttribute("config:type", "string");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item');
						$config_config_item->setAttribute("config:name", "PrinterSetup");
						$config_config_item->setAttribute("config:type", "base64Binary");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "ApplyUserData");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', '0');
						$config_config_item->setAttribute("config:name", "CharacterCompressionType");
						$config_config_item->setAttribute("config:type", "short");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'false');
						$config_config_item->setAttribute("config:name", "IsKernAsianPunctuation");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'false');
						$config_config_item->setAttribute("config:name", "SaveVersionOnClose");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "UpdateFromTemplate");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'true');
						$config_config_item->setAttribute("config:name", "AllowPrintJobCancel");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'false');
						$config_config_item->setAttribute("config:name", "LoadReadonly");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

					$config_config_item = $dom->createElement('config:config-item', 'false');
						$config_config_item->setAttribute("config:name", "IsDocumentShared");
						$config_config_item->setAttribute("config:type", "boolean");
						$config_config_item_set->appendChild($config_config_item);

			return $dom->saveXML();
	}

	public function getStyles() {
		$dom = new DOMDocument('1.0', 'UTF-8');
		
		$root = $dom->createElement('office:document-styles');
			$root->setAttribute("xmlns:office", "urn:oasis:names:tc:opendocument:xmlns:office:1.0");
			$root->setAttribute("xmlns:style", "urn:oasis:names:tc:opendocument:xmlns:style:1.0");
			$root->setAttribute("xmlns:text", "urn:oasis:names:tc:opendocument:xmlns:text:1.0");
			$root->setAttribute("xmlns:table", "urn:oasis:names:tc:opendocument:xmlns:table:1.0");
			$root->setAttribute("xmlns:draw", "urn:oasis:names:tc:opendocument:xmlns:drawing:1.0");
			$root->setAttribute("xmlns:fo", "urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0");
			$root->setAttribute("xmlns:xlink", "http://www.w3.org/1999/xlink");
			$root->setAttribute("xmlns:dc", "http://purl.org/dc/elements/1.1/");
			$root->setAttribute("xmlns:meta", "urn:oasis:names:tc:opendocument:xmlns:meta:1.0");
			$root->setAttribute("xmlns:number", "urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0");
			$root->setAttribute("xmlns:presentation", "urn:oasis:names:tc:opendocument:xmlns:presentation:1.0");
			$root->setAttribute("xmlns:svg", "urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0");
			$root->setAttribute("xmlns:chart", "urn:oasis:names:tc:opendocument:xmlns:chart:1.0");
			$root->setAttribute("xmlns:dr3d", "urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0");
			$root->setAttribute("xmlns:math", "http://www.w3.org/1998/Math/MathML");
			$root->setAttribute("xmlns:form", "urn:oasis:names:tc:opendocument:xmlns:form:1.0");
			$root->setAttribute("xmlns:script", "urn:oasis:names:tc:opendocument:xmlns:script:1.0");
			$root->setAttribute("xmlns:ooo", "http://openoffice.org/2004/office");
			$root->setAttribute("xmlns:ooow", "http://openoffice.org/2004/writer");
			$root->setAttribute("xmlns:oooc", "http://openoffice.org/2004/calc");
			$root->setAttribute("xmlns:dom", "http://www.w3.org/2001/xml-events");
			$root->setAttribute("xmlns:rpt", "http://openoffice.org/2005/report");
			$root->setAttribute("xmlns:of", "urn:oasis:names:tc:opendocument:xmlns:of:1.2");
			$root->setAttribute("xmlns:rdfa", "http://docs.oasis-open.org/opendocument/meta/rdfa#");
			$root->setAttribute("office:version", "1.2");
			$dom->appendChild($root);
		
		
			$office_font_face_decls = $dom->createElement('office:font-face-decls');
				$root->appendChild($office_font_face_decls);
				
				foreach($this->fontFaces as $fontFace)
					$office_font_face_decls->appendChild($fontFace->getStyles($this,$dom));
			
			$office_styles = $dom->createElement('office:styles');
				$root->appendChild($office_styles);
				
				$style_default_style = $dom->createElement('style:default-style');
					$style_default_style->setAttribute("style:family", "table-cell");
					$office_styles->appendChild($style_default_style);
				
					$style_table_cell_properties = $dom->createElement('style:table-cell-properties');
						$style_table_cell_properties->setAttribute("style:decimal-places", "2");
						$style_default_style->appendChild($style_table_cell_properties);
						
					$style_paragraph_properties = $dom->createElement('style:paragraph-properties');
						$style_paragraph_properties->setAttribute("style:tab-stop-distance", "1.25cm");
						$style_default_style->appendChild($style_paragraph_properties);
				
					$style_text_properties = $dom->createElement('style:text-properties');
						$style_text_properties->setAttribute("style:font-name", "Nimbus Sans L");
						$style_text_properties->setAttribute("fo:language", "fr");
						$style_text_properties->setAttribute("fo:country", "FR");
						$style_text_properties->setAttribute("style:font-name-asian", "Bitstream Vera Sans");
						$style_text_properties->setAttribute("style:language-asian", "zxx");
						$style_text_properties->setAttribute("style:country-asian", "none");
						$style_text_properties->setAttribute("style:font-name-complex", "Bitstream Vera Sans");
						$style_text_properties->setAttribute("style:language-complex", "zxx");
						$style_text_properties->setAttribute("style:country-complex", "none");
						$style_default_style->appendChild($style_text_properties);

				$style_default_style = $dom->createElement('style:default-style');
					$style_default_style->setAttribute("style:family", "graphic");
					$office_styles->appendChild($style_default_style);
				
					$style_graphic_properties = $dom->createElement('style:graphic-properties');
						$style_graphic_properties->setAttribute("draw:shadow-offset-x", "0.3cm");
						$style_graphic_properties->setAttribute("draw:shadow-offset-y", "0.3cm");
						$style_default_style->appendChild($style_graphic_properties);
					
					$style_paragraph_properties = $dom->createElement('style:paragraph-properties');
						$style_paragraph_properties->setAttribute("style:text-autospace", "ideograph-alpha");
						$style_paragraph_properties->setAttribute("style:punctuation-wrap", "simple");
						$style_paragraph_properties->setAttribute("style:line-break", "strict");
						$style_paragraph_properties->setAttribute("style:writing-mode", "page");
						$style_paragraph_properties->setAttribute("style:font-independent-line-spacing", "false");
						$style_default_style->appendChild($style_paragraph_properties);
						
						$style_tab_stops = $dom->createElement('style:tab-stops');
							$style_paragraph_properties->appendChild($style_tab_stops);
							
					$style_text_properties =  $dom->createElement('style:text-properties');
						$style_text_properties->setAttribute("style:use-window-font-color", "true");
						$style_text_properties->setAttribute("fo:font-family", "'Nimbus Roman No9 L'");
						$style_text_properties->setAttribute("style:font-family-generic", "roman");
						$style_text_properties->setAttribute("style:font-pitch", "variable");
						$style_text_properties->setAttribute("fo:font-size", "12pt");
						$style_text_properties->setAttribute("fo:language", "fr");
						$style_text_properties->setAttribute("fo:country", "FR");
						$style_text_properties->setAttribute("style:letter-kerning", "true");
						$style_text_properties->setAttribute("style:font-size-asian", "24pt");
						$style_text_properties->setAttribute("style:language-asian", "zxx");
						$style_text_properties->setAttribute("style:country-asian", "none");
						$style_text_properties->setAttribute("style:font-size-complex", "24pt");
						$style_text_properties->setAttribute("style:language-complex", "zxx");
						$style_text_properties->setAttribute("style:country-complex", "none");
						$style_default_style->appendChild($style_text_properties);

				//<number:number-style style:name="N0">
				$number_number_style = $dom->createElement('number:number-style');
					$number_number_style->setAttribute("style:name", "N0");
					$office_styles->appendChild($number_number_style);

					$number_number = $dom->createElement('number:number');
						$number_number->setAttribute("number:min-integer-digits", "1");
						$number_number_style->appendChild($number_number);				

				$style_style = $dom->createElement('style:style');
					$style_style->setAttribute("style:name", "Default");
					$style_style->setAttribute("style:family", "table-cell");
					$office_styles->appendChild($style_style);
					
				$style_style = $dom->createElement('style:style');
					$style_style->setAttribute("style:name", "Result");
					$style_style->setAttribute("style:family", "table-cell");
					$style_style->setAttribute("style:parent-style-name", "Default");
					$office_styles->appendChild($style_style);
					
					$style_text_properties = $dom->createElement('style:text-properties');
						$style_text_properties->setAttribute("fo:font-style", "italic");
						$style_text_properties->setAttribute("style:text-underline-style", "solid");
						$style_text_properties->setAttribute("style:text-underline-width", "auto");
						$style_text_properties->setAttribute("style:text-underline-color", "font-color");
						$style_text_properties->setAttribute("fo:font-weight", "bold");
						$style_style->appendChild($style_text_properties);

				$style_style = $dom->createElement('style:style');
					$style_style->setAttribute("style:name", "Result2");
					$style_style->setAttribute("style:family", "table-cell");
					$style_style->setAttribute("style:parent-style-name", "Result");
					$style_style->setAttribute("style:data-style-name", "N106");
					$office_styles->appendChild($style_style);
						
				$style_style = $dom->createElement('style:style');
					$style_style->setAttribute("style:name", "Heading");
					$style_style->setAttribute("style:family", "table-cell");
					$style_style->setAttribute("style:parent-style-name", "Default");
					$office_styles->appendChild($style_style);

					$style_table_cell_properties = $dom->createElement('style:table-cell-properties');
						$style_table_cell_properties->setAttribute("style:text-align-source", "fix");
						$style_table_cell_properties->setAttribute("style:repeat-content", "false");
						$style_style->appendChild($style_table_cell_properties);
					
					$style_paragraph_properties = $dom->createElement('style:paragraph-properties');
						$style_paragraph_properties->setAttribute("fo:text-align", "center");
						$style_style->appendChild($style_paragraph_properties);
						
					$style_text_properties = $dom->createElement('style:text-properties');
						$style_text_properties->setAttribute("fo:font-size", "16pt");
						$style_text_properties->setAttribute("fo:font-style", "italic");
						$style_text_properties->setAttribute("fo:font-weight", "bold");
						$style_style->appendChild($style_text_properties);

				$style_style = $dom->createElement('style:style');
					$style_style->setAttribute("style:name", "Heading1");
					$style_style->setAttribute("style:family", "table-cell");
					$style_style->setAttribute("style:parent-style-name", "Heading");
					$office_styles->appendChild($style_style);

					$style_table_cell_properties = $dom->createElement('style:table-cell-properties');
						$style_table_cell_properties->setAttribute("style:rotation-angle", "90");
						$style_style->appendChild($style_table_cell_properties);

			$office_automatic_styles = $dom->createElement('office:automatic-styles');
				$root->appendChild($office_automatic_styles);
				
				$style_page_layout = $dom->createElement('style:page-layout');
					$style_page_layout->setAttribute("style:name", "Mpm1");
					$office_automatic_styles->appendChild($style_page_layout);
				
					$style_page_layout_properties = $dom->createElement('style:page-layout-properties');
						$style_page_layout_properties->setAttribute("style:writing-mode", "lr-tb");
						$style_page_layout->appendChild($style_page_layout_properties);
					
					$style_header_style = $dom->createElement('style:header-style');
						$style_page_layout->appendChild($style_header_style);
			
						$style_header_footer_properties = $dom->createElement('style:header-footer-properties');
							$style_header_footer_properties->setAttribute("fo:min-height", "0.751cm");
							$style_header_footer_properties->setAttribute("fo:margin-left", "0cm");
							$style_header_footer_properties->setAttribute("fo:margin-right", "0cm");
							$style_header_footer_properties->setAttribute("fo:margin-bottom", "0.25cm");
							$style_header_style->appendChild($style_header_footer_properties);
					
					$style_footer_style = $dom->createElement('style:footer-style');
						$style_page_layout->appendChild($style_footer_style);
			
						$style_header_footer_properties = $dom->createElement('style:header-footer-properties');
							$style_header_footer_properties->setAttribute("fo:min-height", "0.751cm");
							$style_header_footer_properties->setAttribute("fo:margin-left", "0cm");
							$style_header_footer_properties->setAttribute("fo:margin-right", "0cm");
							$style_header_footer_properties->setAttribute("fo:margin-top", "0.25cm");
							$style_footer_style->appendChild($style_header_footer_properties);
					
				$style_page_layout = $dom->createElement('style:page-layout');
					$style_page_layout->setAttribute("style:name", "Mpm2");
					$office_automatic_styles->appendChild($style_page_layout);

					$style_page_layout_properties = $dom->createElement('style:page-layout-properties');
						$style_page_layout_properties->setAttribute("style:writing-mode", "lr-tb");
						$style_page_layout->appendChild($style_page_layout_properties);
				
					$style_header_style = $dom->createElement('style:header-style');
						$style_page_layout->appendChild($style_header_style);
				
						$style_header_footer_properties = $dom->createElement('style:header-footer-properties');
							$style_header_footer_properties->setAttribute("fo:min-height", "0.751cm");
							$style_header_footer_properties->setAttribute("fo:margin-left", "0cm");
							$style_header_footer_properties->setAttribute("fo:margin-right", "0cm");
							$style_header_footer_properties->setAttribute("fo:margin-bottom", "0.25cm");
							$style_header_footer_properties->setAttribute("fo:border", "0.088cm solid #000000");
							$style_header_footer_properties->setAttribute("fo:padding", "0.018cm");
							$style_header_footer_properties->setAttribute("fo:background-color", "#c0c0c0");
							$style_header_style->appendChild($style_header_footer_properties);
						
							$style_background_image = $dom->createElement('style:background-image');
								$style_header_footer_properties->appendChild($style_background_image);
				
					$style_footer_style = $dom->createElement('style:footer-style');
						$style_page_layout->appendChild($style_footer_style);
				
						$style_header_footer_properties = $dom->createElement('style:header-footer-properties');
							$style_header_footer_properties->setAttribute("fo:min-height", "0.751cm");
							$style_header_footer_properties->setAttribute("fo:margin-left", "0cm");
							$style_header_footer_properties->setAttribute("fo:margin-right", "0cm");
							$style_header_footer_properties->setAttribute("fo:margin-top", "0.25cm");
							$style_header_footer_properties->setAttribute("fo:border", "0.088cm solid #000000");
							$style_header_footer_properties->setAttribute("fo:padding", "0.018cm");
							$style_header_footer_properties->setAttribute("fo:background-color", "#c0c0c0");
							$style_footer_style->appendChild($style_header_footer_properties);
						
							$style_background_image = $dom->createElement('style:background-image');
								$style_header_footer_properties->appendChild($style_background_image);

			$office_master_styles = $dom->createElement('office:master-styles');
				$root->appendChild($office_master_styles);
		
				$style_master_page = $dom->createElement('style:master-page');
					$style_master_page->setAttribute("style:name", "Default");
					$style_master_page->setAttribute("style:page-layout-name", "Mpm1");
					$office_master_styles->appendChild($style_master_page);

					$style_header = $dom->createElement('style:header');
						$style_master_page->appendChild($style_header);

						$text_p = $dom->createElement('text:p');
							$style_header->appendChild($text_p);
						
							$text_sheet_name = $dom->createElement('text:sheet-name', '???');
								$text_p->appendChild($text_sheet_name);

					$style_header_left = $dom->createElement('style:header-left');
						$style_header_left->setAttribute("style:display", "false");
						$style_master_page->appendChild($style_header_left);

					$style_footer = $dom->createElement('style:footer');
						$style_master_page->appendChild($style_footer);
						
						$text_p = $dom->createElement('text:p', "Page");
							$style_footer->appendChild($text_p);
						
							$text_page_number = $dom->createElement('text:page-number', '1');
								$text_p->appendChild($text_page_number);

					$style_footer_left = $dom->createElement('style:footer-left');
						$style_footer_left->setAttribute("style:display", "false");
						$style_master_page->appendChild($style_footer_left);

				$style_master_page = $dom->createElement('style:master-page');
					$style_master_page->setAttribute("style:name", "Report");
					$style_master_page->setAttribute("style:page-layout-name", "Mpm2");
					$office_master_styles->appendChild($style_master_page);

					$style_header = $dom->createElement('style:header');
						$style_master_page->appendChild($style_header);

						$style_region_left = $dom->createElement('style:region-left');
							$style_header->appendChild($style_region_left);
						
							$text_p = $dom->createElement('text:p');
								$style_region_left->appendChild($text_p);
								
								$text_sheet_name = $dom->createElement('text:sheet-name', '???');
									$text_p->appendChild($text_sheet_name);

								$note_text = $dom->createTextNode('(');
									$text_p->appendChild($note_text);

								$text_title = $dom->createElement('text:title', '???');
									$text_p->appendChild($text_title);
									
								$note_text = $dom->createTextNode(')');
									$text_p->appendChild($note_text);

						$style_region_right = $dom->createElement('style:region-right');
							$style_header->appendChild($style_region_right);	
							
							$text_p = $dom->createElement('text:p');
								$style_region_right->appendChild($text_p);
								
								$text_date = $dom->createElement('text:date','31/10/2009');
									$text_date->setAttribute("style:data-style-name", "N2");
									$text_date->setAttribute("text:date-value", "2009-10-31");
									$text_p->appendChild($text_date);
						
								$note_text = $dom->createTextNode(',');
									$text_p->appendChild($note_text);
									
								$text_date = $dom->createElement('text:time','18:09:40');
									$text_p->appendChild($text_date);
					
					$style_header_left = $dom->createElement('style:header-left');
						$style_header_left->setAttribute("style:display", "false");
						$style_master_page->appendChild($style_header_left);

					$style_footer = $dom->createElement('style:footer');
						$style_master_page->appendChild($style_footer);
						
						$text_p = $dom->createElement('text:p', 'Page');
							$style_footer->appendChild($text_p);
							
							$text_page_number = $dom->createElement('text:page-number','1');
								$text_p->appendChild($text_page_number);
								
							$note_text = $dom->createTextNode('/');
								$text_p->appendChild($note_text);
						
							$text_page_count = $dom->createElement('text:page-count','99');
								$text_p->appendChild($text_page_count);
						
					$style_footer_left = $dom->createElement('style:footer-left');
						$style_footer_left->setAttribute("style:display", "false");
						$style_master_page->appendChild($style_footer_left);
				
		
		return $dom->saveXML();
	}
	
	private function getMimeType() {
		return "application/vnd.oasis.opendocument.spreadsheet";
	}
	
	private function getAcceleratorCurrent() {
		return "";
	}
	
	private function getManifest() {
		$dom = new DOMDocument('1.0', 'UTF-8');
		$root = $dom->createElement('manifest:manifest');
			$root->setAttribute("xmlns:manifest", "urn:oasis:names:tc:opendocument:xmlns:manifest:1.0");
			$dom->appendChild($root);
		
			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "application/vnd.oasis.opendocument.spreadsheet");
				$manifest_file_entry->setAttribute("manifest:version", "1.2");
				$manifest_file_entry->setAttribute("manifest:full-path", "/");
				$root->appendChild($manifest_file_entry);
			
			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "text/xml");
				$manifest_file_entry->setAttribute("manifest:full-path", "content.xml");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "text/xml");
				$manifest_file_entry->setAttribute("manifest:full-path", "styles.xml");
				$root->appendChild($manifest_file_entry);
			
			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "text/xml");
				$manifest_file_entry->setAttribute("manifest:full-path", "meta.xml");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Thumbnails/thumbnail.png");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Thumbnails/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/accelerator/current.xml");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/accelerator/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/progressbar/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/floater/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/popupmenu/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/menubar/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/toolbar/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/images/Bitmaps/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/images/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/statusbar/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "application/vnd.sun.xml.ui.configuration");
				$manifest_file_entry->setAttribute("manifest:full-path", "Configurations2/");
				$root->appendChild($manifest_file_entry);

			$manifest_file_entry = $dom->createElement("manifest:file-entry");
				$manifest_file_entry->setAttribute("manifest:media-type", "text/xml");
				$manifest_file_entry->setAttribute("manifest:full-path", "settings.xml");
				$root->appendChild($manifest_file_entry);

		return $dom->saveXML();
	}
	
	private function getThumbnail() {
		return base64_decode("
			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
			JXMAAAAASUVORK5CYII=");
	}
	
	public function genOdsFile($file) {
		$zip = new ZipArchive();
		
		if ($zip->open($file, ZIPARCHIVE::OVERWRITE)!==TRUE) {
		   exit("cannot open $file\n");
		}
		
		$zip->addFromString("meta.xml", $this->getMeta());
		$zip->addFromString("content.xml", $this->getContent());
		$zip->addFromString("mimetype", $this->getMimeType());
		$zip->addFromString("settings.xml", $this->getSettings());
		$zip->addFromString("styles.xml", $this->getStyles());
		$zip->addFromString("Configurations2/accelerator/current.xml", $this->getAcceleratorCurrent());
		$zip->addFromString("META-INF/manifest.xml", $this->getManifest());
		$zip->addFromString("Thumbnails/thumbnail.png", $this->getThumbnail());
		
		foreach($this->tmpPictures AS $imgfile => $name)
			$zip->addFile($imgfile,$name);
		
		$zip->close();
	}
	
	public function downloadOdsFile($fileName) {
		header('Content-type: application/vnd.oasis.opendocument.spreadsheet');
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		$tmpfile = tempnam("tmp", "genods");
		$this->genOdsFile($tmpfile);
		readfile($tmpfile);
		unlink($tmpfile);
	}


}
 
?>
