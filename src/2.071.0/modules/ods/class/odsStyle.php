<?php
/*-
 * Copyright (c) 2009 Laurent VUIBERT
 * License : GNU Lesser General Public License v3
 */

abstract class odsStyle {
	protected $name;
	protected $family; // table-column, table-row, table, table-cell
	
	protected function __construct($name, $family) {
		if($name == null) $name = $this->getType().'-'.$this->randString();
		
		$this->name   = $name;
		$this->family = $family;
	}
	
	protected function getContent(ods $ods, DOMDocument $dom) {
		$style_style = $dom->createElement('style:style');
			$style_style->setAttribute("style:name", $this->name);
			$style_style->setAttribute("style:family", $this->family);
		return $style_style;
	} 

	public function getName() {
		return $this->name;
	}
	
	public function __clone() {
		$this->name = 'clone-'.$this->name.'-'.rand(0,99999999999);
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	abstract protected function getType();
	
	protected function randString() {
		return md5(time().rand().$this->getType());
	}
	
}

class odsStyleTableColumn extends odsStyle {
	private $breakBefore;           // auto
	private $columnWidth;           // 2.267cm
	private $useOptimalColumnWidth; // true, false
	
	public function __construct($name = null) {
		parent::__construct($name, "table-column");
		$this->breakBefore           = "auto";
		$this->columnWidth           = "2.267cm";
		$this->useOptimalColumnWidth = "false";
	}
	
	public function setColumnWidth($columnWidth) {
		$this->columnWidth = $columnWidth;
	}
	
	public function setBreakBefore($breakBefore) {
		$this->breakBefore = $breakBefore;
	}
	
	public function setUseOptimalColumnWidth($useOptimalColumnWidth) {
		$this->useOptimalColumnWidth = $useOptimalColumnWidth;
	}
	
	public function getContent(ods $ods,DOMDocument $dom) {
		$style_style = parent::getContent($ods,$dom);
			
			// style:table-column-properties
			$style_table_column_properties = $dom->createElement('style:table-column-properties');
				$style_table_column_properties->setAttribute("fo:break-before", $this->breakBefore);
				$style_table_column_properties->setAttribute("style:use-optimal-column-width", $this->useOptimalColumnWidth);
				$style_table_column_properties->setAttribute("style:column-width", $this->columnWidth);
				$style_style->appendChild($style_table_column_properties);

		return $style_style;
	}
	
	public function getType() {
		return 'odsStyleTableColumn';
	}
	
}

class odsStyleTable extends odsStyle {
	private $masterPageName;      // Default
	private $display;             // true
	private $writingMode;         // lr-tb

	public function __construct($name = null) {
		parent::__construct($name, "table");
		$this->masterPageName = "Default";
		$this->display        = "true";
		$this->writingMode    = "lr-tb";
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$style_style = parent::getContent($ods,$dom);
			$style_style->setAttribute("style:master-page-name", $this->masterPageName);
			
			// style:table-properties
			$style_table_properties = $dom->createElement('style:table-properties');
				$style_table_properties->setAttribute("table:display", $this->display);
				$style_table_properties->setAttribute("style:writing-mode", $this->writingMode);
				$style_style->appendChild($style_table_properties);
		return $style_style;
	}
	
	public function getType() {
		return 'odsStyleTable';
	}
}

class odsStyleTableRow extends odsStyle {
	private $rowHeight;           // 0.52cm
	private $breakBefore;         // auto
	private $useOptimalRowHeight; // true, false
	
	public function __construct($name = null) {
		parent::__construct($name, "table-row");
		$this->rowHeight           = "0.52cm";
		$this->breakBefore         = "auto";
		$this->useOptimalRowHeight = "true";
	}

	public function setRowHeight($rowHeight) {
		$this->rowHeight = $rowHeight;
	}

	public function setBreakBefore($breakBefore) {
		$this->breakBefore = $breakBefore;
	}

	public function setUseOptimalRowHeight($useOptimalRowHeight) {
		$this->useOptimalRowHeight = $useOptimalRowHeight;
	}

	public function getContent(ods $ods, DOMDocument $dom) {
		$style_style = parent::getContent($ods,$dom);
			
			// style:table-row-properties
			$style_table_row_properties = $dom->createElement('style:table-row-properties');
				$style_table_row_properties->setAttribute("style:row-height", $this->rowHeight);
				$style_table_row_properties->setAttribute("fo:break-before", $this->breakBefore);
				$style_table_row_properties->setAttribute("style:use-optimal-row-height", $this->useOptimalRowHeight);
				$style_style->appendChild($style_table_row_properties);
				
		return $style_style; 
	}
	
	public function getType() {
		return 'odsStyleTableRow';
	}
}

class odsStyleParagraph extends odsStyle {
	
	public function __construct($name = null) {
		parent::__construct($name, "paragraph");
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$style_style = parent::getContent($ods,$dom);
			
			// style:table-row-properties
			$style_paragraph_properties = $dom->createElement('style:paragraph-properties');
				$style_paragraph_properties->setAttribute("fo:text-align", 'center');
				$style_style->appendChild($style_paragraph_properties);
				
		return $style_style; 
	}
	
	public function getType() {
		return 'odsStyleParagraph';
	}
}

class odsStyleTableCell extends odsStyle {
	private $parentStyleName;     // Default
	private $textAlignSource;     // fix
	private $repeatContent;       // true, false
	private $color;               // opt: #ffffff
	private $backgroundColor;     // opt: #ffffff
	private $border;              // opt: 0.002cm solid #000000
	private $textAlign;           // opt: center
	private $verticalAlign;       // opt: top, middle, bottom
	private $marginLeft;          // opt: 0cm
	private $fontWeight;          // opt: bold
	private $fontSize;            // opt: 18pt;
	private $fontStyle;           // opt: italic, normal
	private $underline;           // opt: font-color, #000000, null
	private $fontFace;            // opt: fontFace
	private $styleDataName;       // opt: interne
	private $wrapOption;          // opt: false, wrap
	private $hyphenate;           // opt: true, false in string
	private $shrinkToFit;         // opt; true, false in string
	
	public function __construct($name = null) {
		parent::__construct($name, "table-cell");
		$this->parentStyleName     = "Default";
		$this->textAlignSource     = "fix";
		$this->repeatContent       = "false";
		$this->color               = false;
		$this->backgroundColor     = false;
		$this->border              = false;
		$this->textAlign           = false;
		$this->verticalAlign       = false;
		$this->marginLeft          = false;
		$this->fontWeight          = false;
		$this->fontSize            = false;
		$this->fontStyle           = false;
		$this->underline           = false;
		$this->fontFace            = false;
		$this->styleDataName       = false;
		$this->wrapOption          = false;
		$this->hyphenate           = false;
		$this->shrinkToFit         = false;
	}
	
	public function setColor($color) {
		$this->color = $color;
	}
	
	public function setBackgroundColor($color) {
		$this->backgroundColor = $color;
	}

	public function setBorder($border) {
		$this->border = $border;
	}
	
	public function setTextAlign($textAlign) {
		$this->textAlign = $textAlign;
	}
	
	public function setVerticalAlign($verticalAlign) {
		$this->verticalAlign = $verticalAlign;
	}
	
	public function setFontWeight($weight) {
		$this->fontWeight = $weight;
	}
	
	public function setFontStyle($fontStyle) {
		$this->fontStyle = $fontStyle;
	}
	
	public function setUnderline($underline) {
		$this->underline = $underline;
	}
	
	public function setStyleDataName($styleDataName) {
		$this->styleDataName = $styleDataName;
	}
	
	public function setFontSize($fontSize) {
		$this->fontSize = $fontSize;
	}
	
	public function setFontFace(odsFontFace $fontFace) {
		$this->fontFace = $fontFace;
	}
	
	public function setWrapOption($wrapOption) {
		$this->wrapOption = $wrapOption;
	}
	
	public function setHyphenate($hyphenate) {
		$this->hyphenate = $hyphenate;
	}
	
	public function setShrinkToFit($shrinkToFit) {
		$this->shrinkToFit = $shrinkToFit;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		// style:style
		$style_style = parent::getContent($ods,$dom);
			$style_style->setAttribute("style:parent-style-name", $this->parentStyleName);
			if($this->styleDataName)
				$style_style->setAttribute("style:data-style-name", $this->styleDataName);
			
			// style:table-cell-properties
			$style_table_cell_properties = $dom->createElement('style:table-cell-properties');
				$style_table_cell_properties->setAttribute("style:text-align-source", $this->textAlignSource);
				$style_table_cell_properties->setAttribute("style:repeat-content", $this->repeatContent);
				
				if($this->backgroundColor)
					$style_table_cell_properties->setAttribute("fo:background-color", $this->backgroundColor);
					
				if($this->border)
					$style_table_cell_properties->setAttribute("fo:border", $this->border);
				
				$style_style->appendChild($style_table_cell_properties);

				if($this->textAlign) {
					// style:paragraph-properties
					$style_paragraph_properties = $dom->createElement('style:paragraph-properties');
						$style_paragraph_properties->setAttribute("fo:text-align", $this->textAlign);
						$style_paragraph_properties->setAttribute("fo:margin-left", "0cm");
						$style_style->appendChild($style_paragraph_properties);
				}
				
				if($this->verticalAlign) {
					$style_table_cell_properties->setAttribute("style:vertical-align", $this->verticalAlign);
				}
				
				if($this->wrapOption) {
					$style_table_cell_properties->setAttribute("fo:wrap-option", $this->wrapOption);
				}
				
				if($this->shrinkToFit) {
					$style_table_cell_properties->setAttribute("style:shrink-to-fit", $this->shrinkToFit);
				}
				
				if($this->color OR $this->fontWeight OR $this->fontStyle OR $this->underline OR $this->fontSize OR $this->fontFace OR $this->hyphenate) {
					// style:text-properties
					$style_text_properties = $dom->createElement('style:text-properties');
					
						if($this->color)
							$style_text_properties->setAttribute("fo:color", $this->color);
							
						if($this->fontWeight) {
							$style_text_properties->setAttribute("fo:font-weight", $this->fontWeight);
							$style_text_properties->setAttribute("style:font-weight-asian", $this->fontWeight);
							$style_text_properties->setAttribute("style:font-weight-complex", $this->fontWeight);
						}
						
						if($this->fontStyle) {
							$style_text_properties->setAttribute("fo:font-style", $this->fontStyle);
							$style_text_properties->setAttribute("fo:font-style-asian", $this->fontStyle);
							$style_text_properties->setAttribute("fo:font-style-complex", $this->fontStyle);
						}
						
						if($this->underline) {
							$style_text_properties->setAttribute("style:text-underline-style", 'solid');
							$style_text_properties->setAttribute("style:text-underline-width", 'auto');
							$style_text_properties->setAttribute("style:text-underline-color", $this->underline);
						}
						
						if($this->fontSize) {
							$style_text_properties->setAttribute("fo:font-size", $this->fontSize);
							$style_text_properties->setAttribute("style:font-size-asian", $this->fontSize);
							$style_text_properties->setAttribute("style:font-size-complex", $this->fontSize);
						}
						
						if($this->fontFace) {
							$style_text_properties->setAttribute("style:font-name", $this->fontFace->getFontName());
						}
						
						if($this->hyphenate) {
							$style_text_properties->setAttribute("fo:hyphenate", $this->hyphenate);
						}
						
						$style_style->appendChild($style_text_properties);
				}
				
				
		return $style_style;
	}
	 
	public function getType() {
		return 'odsStyleTableCell';
	}
}

class odsStyleGraphic extends odsStyle {
	private $stroke;      // none
	private $strokeWidth; // 0.1cm
	private $strokeColor; // #000000
	private $markerStart; // null
	private $markerEnd;   //null
	private $fill;        // none
 	private $luminance;   // 0%
 	private $contrast;    // 0%
 	private $gamma;       // 100%
 	private $red;         // 0%
 	private $green;       // 0%
 	private $blue;        // 0%  
 	private $opacity;     // 100%

	public function __construct($name = null) {
		parent::__construct($name, "graphic");
		$this->stroke      = null;
		$this->strokeWidth = null;
		$this->strokeColor = null;
		$this->markerStart = null;
		$this->markerEnd   = null;
		$this->fill        = null;
		$this->luminance   = null;
		$this->contrast    = null;
		$this->gamma       = null;
		$this->red         = null;
		$this->green       = null;
		$this->blue        = null;
		$this->opacity     = null;
	}
	
	public function setStroke(odsStyleStrokeDash $stroke) {
		$this->stroke = $stroke;
	}
	
	public function setStrokeWidth($strokeWidth) {
		$this->strokeWidth = $strokeWidth;
	}
	
	public function setStrokeColor($strokeColor) {
		$this->strokeColor = $strokeColor;
	}
	
	public function setMarkerStart($markerStart) {
		$this->markerStart = $markerStart;
	}

	public function setMarkerEnd($markerEnd) {
		$this->markerEnd = $markerEnd;
	}
	
	public function setFill($fill) {
		$this->fill = $fill;
	}
	
	public function setLuminance($luminance) {
		$this->luminance = $luminance;
	}
	
	public function setContrast($contrast) {
		$this->contrast = $contrast;
	}
	
	public function setGamma($gamma) {
		$this->gamma = $gamma;
	}
	
	public function setRed($red) {
		$this->red = $red;
	}
	
	public function setGreen($green) {
		$this->green = $green;
	}
	
	public function setBlue($blue) {
		$this->blue = $blue;
	}
	
	public function setOpacity($opacity) {
		$this->opacity = $opacity;
	}
	
	public function getContent(ods $ods,DOMDocument $dom) {
		$style_style = parent::getContent($ods,$dom);
		
			// style:table-row-properties
			$style_graphic_properties = $dom->createElement('style:graphic-properties');
				$style_graphic_properties->setAttribute("draw:textarea-horizontal-align", "center");
				$style_graphic_properties->setAttribute("draw:textarea-vertical-align", "middle");
				//$style_graphic_properties->setAttribute("draw:color-mode", "standard");
				//$style_graphic_properties->setAttribute("fo:clip", "rect(0cm, 0cm, 0cm, 0cm)");
				//$style_graphic_properties->setAttribute("style:mirror", "none");

				if($this->stroke) {
					$style_graphic_properties->setAttribute("draw:stroke",        'dash');
					$style_graphic_properties->setAttribute("draw:stroke-dash",   $this->stroke->getName());
					$ods->addTmpStyles($this->stroke);
				}
				if($this->strokeWidth) {
					$style_graphic_properties->setAttribute("svg:stroke-width",   $this->strokeWidth);
					$style_graphic_properties->setAttribute("fo:padding-top",     $this->strokeWidth);
					$style_graphic_properties->setAttribute("fo:padding-bottom",  $this->strokeWidth);
					$style_graphic_properties->setAttribute("fo:padding-left",    $this->strokeWidth);
					$style_graphic_properties->setAttribute("fo:padding-right",   $this->strokeWidth);	
				}
				if($this->strokeColor) {
					$style_graphic_properties->setAttribute("svg:stroke-color",   $this->strokeColor);
				}
				if($this->markerStart) {
					$style_graphic_properties->setAttribute("draw:marker-start",  $this->markerStart->getName());
					$ods->addTmpStyles($this->markerStart);
				}
				if($this->markerEnd) {
					$style_graphic_properties->setAttribute("draw:marker-end",  $this->markerEnd->getName());
					$ods->addTmpStyles($this->markerEnd);
				}
				if($this->fill)
					$style_graphic_properties->setAttribute("draw:fill",          $this->fill);
				if($this->luminance)
					$style_graphic_properties->setAttribute("draw:luminance",     $this->luminance);
				if($this->contrast)
					$style_graphic_properties->setAttribute("draw:contrast",      $this->contrast);
				if($this->gamma)
					$style_graphic_properties->setAttribute("draw:gamma",         $this->gamma);
				if($this->red)
					$style_graphic_properties->setAttribute("draw:red",           $this->red);
				if($this->green)
					$style_graphic_properties->setAttribute("draw:green",         $this->green);
				if($this->blue)
					$style_graphic_properties->setAttribute("draw:blue",          $this->blue);
				if($this->opacity)
					$style_graphic_properties->setAttribute("draw:image-opacity", $this->opacity);
				
				$style_style->appendChild($style_graphic_properties);
				
		return $style_style;
	}

	public function getType() {
		return 'odsStyleGraphic';
	}
	
}

class odsStyleGraphicGeneric extends odsStyleGraphic {
	
	public function __construct() {
		$this->name='odsStyleGraphicGeneric';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		 
		 $style_default_style = $dom->createElement('style:default-style');
			 $style_default_style->setAttribute('style:family', 'graphic');
		 
		 $style_graphic_properties = $dom->createElement('style:graphic-properties');
		 	$style_graphic_properties->setAttribute('draw:shadow-offset-x', '0.3cm');
		 	$style_graphic_properties->setAttribute('draw:shadow-offset-y', '0.3cm');
			$style_default_style->appendChild($style_graphic_properties);


		 $style_paragraph_properties = $dom->createElement('style:paragraph-properties');
		 	$style_paragraph_properties->setAttribute('style:text-autospace', 'ideograph-alpha');
		 	$style_paragraph_properties->setAttribute('style:punctuation-wrap', 'simple');
		 	$style_paragraph_properties->setAttribute('style:line-break', 'strict');
		 	$style_paragraph_properties->setAttribute('style:writing-mode', 'page');
		 	$style_paragraph_properties->setAttribute('style:font-independent-line-spacing', 'false');
		 	$style_default_style->appendChild($style_paragraph_properties);
		 	
		 	$style_tab_stops = $dom->createElement('style:tab-stops');
		 		$style_paragraph_properties->appendChild($style_tab_stops);
		 	
		 $style_text_properties = $dom->createElement('style:text-properties');
		 	$style_text_properties->setAttribute('style:use-window-font-color', 'true');
		 	$style_text_properties->setAttribute('fo:font-family', "'Nimbus Roman No9 L'");
		 	$style_text_properties->setAttribute('style:font-family-generic', 'roman');
		 	$style_text_properties->setAttribute('style:font-pitch', 'variable');
		 	$style_text_properties->setAttribute('fo:font-size', '12pt');
		 	$style_text_properties->setAttribute('fo:language', 'fr');
		 	$style_text_properties->setAttribute('fo:country', 'FR');
		 	$style_text_properties->setAttribute('style:letter-kerning', 'true');
		 	$style_text_properties->setAttribute('style:font-size-asian', '24pt');
		 	$style_text_properties->setAttribute('style:language-asian', 'zxx');
		 	$style_text_properties->setAttribute('style:country-asian', 'none');
		 	$style_text_properties->setAttribute('style:font-size-complex', '24pt');
		 	$style_text_properties->setAttribute('style:language-complex', 'zxx');
		 	$style_text_properties->setAttribute('style:country-complex', 'none');
			$style_default_style->appendChild($style_text_properties);
		 
		 return $style_default_style;
	}
	
	public function getType() {
		return 'odsStyleGraphicGeneric';
	}
}

class odsStyleStrokeDash extends odsStyle {
	protected $displayName;
	protected $drawStyle;
	protected $drawDots1;
	protected $drawDots1Length;
	protected $drawDots2;
	protected $drawDots2Length;
	protected $drawDistance;
	
	protected function __construct($name, $displayName,$drawStyle,$drawDots1,$drawDots1Length,$drawDots2,$drawDots2Length,$drawDistance) {
		$this->name            = $name;
		$this->displayName     = $displayName;
		$this->drawStyle       = $drawStyle;
		$this->drawDots1       = $drawDots1;
		$this->drawDots1Length = $drawDots1Length;
		$this->drawDots2       = $drawDots2;
		$this->drawDots2Length = $drawDots2Length;
		$this->drawDistance    = $drawDistance;
	}
	
	function getContent(ods $ods, DOMDocument $dom) {
		$draw_stroke_dash = $dom->createElement('draw:stroke-dash');
			$draw_stroke_dash->setAttribute('draw:name',         $this->name);
			$draw_stroke_dash->setAttribute('draw:display-name', $this->displayName);
			$draw_stroke_dash->setAttribute('draw:style',        $this->drawStyle);
			$draw_stroke_dash->setAttribute('draw:dots1',        $this->drawDots1);
			if($this->drawDots1Length)
				$draw_stroke_dash->setAttribute('draw:dots1-length', $this->drawDots1Length);
			if($this->drawDots2)
				$draw_stroke_dash->setAttribute('draw:dots2',        $this->drawDots2);
			if($this->drawDots2Length)
				$draw_stroke_dash->setAttribute('draw:dots2-length', $this->drawDots2Length);
			$draw_stroke_dash->setAttribute('draw:distance',     $this->drawDistance);
		return $draw_stroke_dash;
	}
	
	public function getType() {
		return 'odsStyleStrokeDash';
	}
}

class odsStyleStrokeDashUltrafine extends odsStyleStrokeDash {
	public function __construct() { parent::__construct('Ultrafine_20_Dashed','Ultrafine Dashed','rect','1','0.051cm','1','0.051cm','0.051cm');	}		
	public function getType() {	return 'odsStyleStrokeDashUltrafine'; }
}

class odsStyleStrokeDashUltrafineVar extends odsStyleStrokeDash {
	public function __construct() { parent::__construct('Fine_20_Dashed_20__28_var_29_','Fine Dashed (var)','rect','1','197%',null,null,'197%');	}		
	public function getType() {	return 'UltrafineVar'; }
}

class odsStyleStrokeDashFine extends odsStyleStrokeDash {
	public function __construct() { parent::__construct('Fine_20_Dashed','Fine Dashed','rect','1','0.508cm','1','0.508cm','0.508cm');	}		
	public function getType() { return 'odsStyleStrokeDashFine'; }
}

class odsStyleStrokeDashUltrafineAndDots extends odsStyleStrokeDash {
	public function __construct() { parent::__construct('Ultrafine_20_2_20_Dots_20_3_20_Dashes','Ultrafine 2 Dots 3 Dashes','rect','2','0.051cm','3','0.254cm','0.254cm');	}		
	public function getType() { return 'odsStyleStrokeDashUltrafineAndDots'; }
}

class odsStyleStrokeDashFineDotted extends odsStyleStrokeDash {
	public function __construct() { parent::__construct('Fine_20_Dotted','Fine Dotted','rect','1',null,null,null,'0.457cm');	}		
	public function getType() { return 'odsStyleStrokeDashFineDotted'; }
}

class odsStyleStrokeDashLineAndDot extends odsStyleStrokeDash {
	public function __construct() { parent::__construct('Line_20_with_20_Fine_20_Dots','Line_20_with_20_Fine_20_Dots','rect','1','2.007cm','10',null,'0.152cm');	}		
	public function getType() { return 'odsStyleStrokeDashLineAndDot'; }
}

class odsStyleStrokeDash2Dots1Dash extends odsStyleStrokeDash {
	public function __construct() { parent::__construct('_32__20_Dots_20_1_20_Dash','2 Dots 1 Dash','rect','2',null,'1','0.203cm','0.203cm');	}		
	public function getType() { return 'odsStyleStrokeDashLineAndDot'; }
}

class odsStyleStrokeMarker extends odsStyle {
	protected $displayName;
	protected $viewBox;
	protected $d;
	
	public function __construct($name, $displayName, $viewBox, $d) {
		$this->name            = $name;
		$this->displayName     = $displayName;
		$this->viewBox         = $viewBox;
		$this->d               = $d;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$draw_marker = $dom->createElement('draw:marker');
			$draw_marker->setAttribute("style:name",        $this->name);
			$draw_marker->setAttribute("draw:display-name", $this->displayName);
			$draw_marker->setAttribute("svg:viewBox", $this->viewBox);
			$draw_marker->setAttribute("svg:d", $this->d);
		return $draw_marker;
	}
	
	public function getType() {
		return 'odsStyleStrokeMarker';
	}
}

class odsStyleStrokeMarkerArrow extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerArrow','Marker Arrow','0 0 20 30','m10 0-10 30h20z'); }
	public function getType() { return 'odsStyleStrokeMarkerArrow'; }
}

class odsStyleStrokeMarkerSquare extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerSquare','Marker Square','0 0 10 10','m0 0h10v10h-10z'); }
	public function getType() { return 'odsStyleStrokeMarkerArrow'; }
}

class odsStyleStrokeMarkerNarrowArrow extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerNarrowArrow','Marker Narrow Arrow','0 0 1321 3493','m1321 3493h-1321l702-3493z'); }
	public function getType() { return 'odsStyleStrokeMarkerNarrowArrow'; }
}

class odsStyleStrokeMarkerTipRating extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerTipRating','Marker Tip Rating','0 0 836 110','m0 0h278 278 280v36 36 38h-278-278-280v-36-36z'); }
	public function getType() { return 'odsStyleStrokeMarkerTipRating'; }
}

class odsStyleStrokeMarkerDoubleArrow extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerDoubleArrow','Marker Double Arrow','0 0 1131 1918','m737 1131h394l-564-1131-567 1131h398l-398 787h1131z'); }
	public function getType() { return 'odsStyleStrokeMarkerDoubleArrow'; }
}

class odsStyleStrokeMarkerSimetraArrow extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerSimetraArrow','Marker Simetra Arrow','0 0 1013 1130','m1009 1050-449-1008-22-30-29-12-34 12-21 26-449 1012-5 13v8l5 21 12 21 17 13 21 4h903l21-4 21-13 9-21 4-21v-8z'); }
	public function getType() { return 'odsStyleStrokeMarkerSimetraArrow'; }
}

class odsStyleStrokeMarkerLineArrow extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerLineArrow','Marker Line Arrow','0 0 1122 2243','m0 2108v17 17l12 42 30 34 38 21 43 4 29-8 30-21 25-26 13-34 343-1532 339 1520 13 42 29 34 39 21 42 4 42-12 34-30 21-42v-39-12l-4 4-440-1998-9-42-25-39-38-25-43-8-42 8-38 25-26 39-8 42z'); }
	public function getType() { return 'odsStyleStrokeMarkerLineArrow'; }
}

class odsStyleStrokeMarkerRondNarrowArrow extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerRondNarrowArrow','Marker Rond Narrow Arrow','0 0 1131 2256','m1127 2120-449-2006-9-42-25-39-38-25-38-8-43 8-38 25-25 39-9 42-449 2006v13l-4 9 9 42 25 38 38 25 42 9h903l42-9 38-25 26-38 8-42v-9z'); }
	public function getType() { return 'odsStyleStrokeMarkerRondNarrowArrow'; }
}

class odsStyleStrokeMarkerCircleArrow extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerCircleArrow','Marker Circle Arrow','0 0 1131 1131','m462 1118-102-29-102-51-93-72-72-93-51-102-29-102-13-105 13-102 29-106 51-102 72-89 93-72 102-50 102-34 106-9 101 9 106 34 98 50 93 72 72 89 51 102 29 106 13 102-13 105-29 102-51 102-72 93-93 72-98 51-106 29-101 13z'); }
	public function getType() { return 'odsStyleStrokeMarkerCircleArrow'; }
}

class odsStyleStrokeMarkerSquare45 extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerSquare45','Marker Square 45','0 0 1131 1131','m0 564 564 567 567-567-567-564z'); }
	public function getType() { return 'odsStyleStrokeMarkerSquare45'; }
}

class odsStyleStrokeMarkerConcaveArrow extends odsStyleStrokeMarker {
	public function __construct() { parent::__construct('MarkerConcaveArrow','Marker Concave Arrow','0 0 1131 1580','m1013 1491 118 89-567-1580-564 1580 114-85 136-68 148-46 161-17 161 13 153 46z'); }
	public function getType() { return 'odsStyleStrokeMarkerConcaveArrow'; }
}


abstract class odsStyleMoney extends odsStyle {
	//abstract protected function __construct();
	//abstract protected function getContent();
	//abstract protected function getType();
}


class odsStyleMoneyEUR extends odsStyleMoney {
	
	public function __construct() {
		$this->name='NCur-EUR-P0';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_currency_style = $dom->createElement('number:currency-style');
			$number_currency_style->setAttribute("style:name", "NCur-EUR-P0");
			$number_currency_style->setAttribute("style:volatile", "true");
		
			$number_number = $dom->createElement('number:number');
				$number_number->setAttribute("number:decimal-places", "2");
				$number_number->setAttribute("number:min-integer-digits", "1");
				$number_number->setAttribute("number:grouping", "true");
				$number_currency_style->appendChild($number_number);
				
			$number_text = $dom->createElement('number:text', ' ');
				$number_currency_style->appendChild($number_text);
		
			$number_currency_symbol = $dom->createElement('number:currency-symbol', '€');
				$number_currency_symbol->setAttribute("number:language", "fr");
				$number_currency_symbol->setAttribute("number:country", "FR");
				$number_number->setAttribute("number:grouping", "true");
				$number_currency_style->appendChild($number_currency_symbol);
		return $number_currency_style;
	}
	
	public function getType() {
		return 'odsStyleMoneyEUR';
	}
}

class odsStyleMoneyEURNeg extends odsStyleMoney {
	
	public function __construct() {
		$this->name='NCur-EUR';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
	
		$number_currency_style = $dom->createElement('number:currency-style');
			$number_currency_style->setAttribute("style:name", "NCur-EUR");
	
			$style_text_properties = $dom->createElement('style:text-properties');
				$style_text_properties->setAttribute("fo:color", "#ff0000");
				$number_currency_style->appendChild($style_text_properties);
	
			$number_text = $dom->createElement('number:text', '-');
				$number_currency_style->appendChild($number_text);
		
			$number_number = $dom->createElement('number:number');
				$number_number->setAttribute("number:decimal-places", "2");
				$number_number->setAttribute("number:min-integer-digits", "1");
				$number_number->setAttribute("number:grouping", "true");
				$number_currency_style->appendChild($number_number);
				
			$number_text = $dom->createElement('number:text', ' ');
				$number_currency_style->appendChild($number_text);
		
			$number_currency_symbol = $dom->createElement('number:currency-symbol', '€');
				$number_currency_symbol->setAttribute("number:language", "fr");
				$number_currency_symbol->setAttribute("number:country", "FR");
				$number_currency_style->appendChild($number_currency_symbol);
		
			$style_map = $dom->createElement('style:map');
				$style_map->setAttribute("style:condition", "value()>=0");
				$style_map->setAttribute("style:apply-style-name", "NCur-EUR-P0");
				$number_currency_style->appendChild($style_map);

		return $number_currency_style;
	}

	public function getType() {
		return 'odsStyleMoneyEURNeg';
	}
}

class odsStyleMoneyUSD extends odsStyleMoney {
	
	public function __construct() {
		$this->name='NCur-USD-P0';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_currency_style = $dom->createElement('number:currency-style');
			$number_currency_style->setAttribute("style:name", "NCur-USD-P0");
			$number_currency_style->setAttribute("style:volatile", "true");

			$number_currency_symbol = $dom->createElement('number:currency-symbol', '$');
				$number_currency_symbol->setAttribute("number:language", "en");
				$number_currency_symbol->setAttribute("number:country", "US");
				$number_currency_symbol->setAttribute("number:grouping", "true");
				$number_currency_style->appendChild($number_currency_symbol);
		
			$number_number = $dom->createElement('number:number');
				$number_number->setAttribute("number:decimal-places", "2");
				$number_number->setAttribute("number:min-integer-digits", "1");
				$number_number->setAttribute("number:grouping", "true");
				$number_currency_style->appendChild($number_number);
		return $number_currency_style;
		
	}
	
	public function getType() {
		return 'odsStyleMoneyUSD';
	}
}

class odsStyleMoneyUSDNeg extends odsStyleMoney {
	
	public function __construct(){
		$this->name='NCur-USD';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_currency_style = $dom->createElement('number:currency-style');
			$number_currency_style->setAttribute("style:name", "NCur-USD");

			$style_text_properties = $dom->createElement('style:text-properties');
				$style_text_properties->setAttribute("fo:color", "#ff0000");
				$number_currency_style->appendChild($style_text_properties);

			$number_text = $dom->createElement('number:text', '-');
				$number_currency_style->appendChild($number_text);
		
			$number_currency_symbol = $dom->createElement('number:currency-symbol', '$');
				$number_currency_symbol->setAttribute("number:language", "en");
				$number_currency_symbol->setAttribute("number:country", "US");
				$number_currency_style->appendChild($number_currency_symbol);
		
			$number_number = $dom->createElement('number:number');
				$number_number->setAttribute("number:decimal-places", "2");
				$number_number->setAttribute("number:min-integer-digits", "1");
				$number_number->setAttribute("number:grouping", "true");
				$number_currency_style->appendChild($number_number);
								
			$style_map = $dom->createElement('style:map');
				$style_map->setAttribute("style:condition", "value()>=0");
				$style_map->setAttribute("style:apply-style-name", "NCur-USD-P0");
				$number_currency_style->appendChild($style_map);
		return $number_currency_style;
	}
	
	public function getType() {
		return 'odsStyleMoneyUSDNeg';
	}
}

class odsStyleMoneyGBP extends odsStyleMoney {
	
	public function __construct() {
		$this->name='NCur-GBP-P0';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_currency_style = $dom->createElement('number:currency-style');
			$number_currency_style->setAttribute("style:name", "NCur-GBP-P0");
			$number_currency_style->setAttribute("style:volatile", "true");

			$number_currency_symbol = $dom->createElement('number:currency-symbol', '£');
				$number_currency_symbol->setAttribute("number:language", "en");
				$number_currency_symbol->setAttribute("number:country", "GB");
				$number_currency_style->appendChild($number_currency_symbol);
		
			$number_number = $dom->createElement('number:number');
				$number_number->setAttribute("number:decimal-places", "2");
				$number_number->setAttribute("number:min-integer-digits", "1");
				$number_number->setAttribute("number:grouping", "true");
				$number_currency_style->appendChild($number_number);
		return $number_currency_style;
	}
	
	public function getType() {
		return 'odsStyleMoneyGBP';
	}
}

class odsStyleMoneyGBPNeg extends odsStyleMoney {
	
	public function __construct() {
		$this->name='NCur-GBP';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_currency_style = $dom->createElement('number:currency-style');
			$number_currency_style->setAttribute("style:name", "NCur-GBP");

			$style_text_properties = $dom->createElement('style:text-properties');
				$style_text_properties->setAttribute("fo:color", "#ff0000");
				$number_currency_style->appendChild($style_text_properties);

			$number_text = $dom->createElement('number:text', '-');
				$number_currency_style->appendChild($number_text);
		
			$number_currency_symbol = $dom->createElement('number:currency-symbol', '£');
				$number_currency_symbol->setAttribute("number:language", "en");
				$number_currency_symbol->setAttribute("number:country", "GB");
				$number_currency_style->appendChild($number_currency_symbol);
		
			$number_number = $dom->createElement('number:number');
				$number_number->setAttribute("number:decimal-places", "2");
				$number_number->setAttribute("number:min-integer-digits", "1");
				$number_number->setAttribute("number:grouping", "true");
				$number_currency_style->appendChild($number_number);
								
			$style_map = $dom->createElement('style:map');
				$style_map->setAttribute("style:condition", "value()>=0");
				$style_map->setAttribute("style:apply-style-name", "NCur-GBP-P0");
				$number_currency_style->appendChild($style_map);
		return $number_currency_style;
	}
	
	public function getType() {
		return 'odsStyleMoneyGBPNeg';
	}
}

abstract class odsStyleDate extends odsStyle {
	protected $language;
	
	protected function setLanguage($number_date_style) {
		if(!isset($this->language)) return;
		$number_date_style->setAttribute("number:language", $this->language);
		$number_date_style->setAttribute("number:country", $this->language);
	}
}

class odsStyleDateMMDDYYYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-MMDDYYYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_day = $dom->createElement('number:day');
				$number_day->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_day);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_year->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateMMDDYYYY';
	}
}

class odsStyleDateMMDDYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-MMDDYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_day = $dom->createElement('number:day');
				$number_day->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_day);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateMMDDYY';
	}
}

class odsStyleDateDDMMYYYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-DDMMYYYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_day = $dom->createElement('number:day');
				$number_day->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_day);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);
	
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_year->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateDDMMYYYY';
	}
}

class odsStyleDateDDMMYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-DDMMYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_day = $dom->createElement('number:day');
				$number_day->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_day);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);
	
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateDDMMYY';
	}
}

class odsStyleDateDMMMYYYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-DMMMYYYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);
	
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:textual", "true");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_year->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateDMMMYYYY';
	}
}

class odsStyleDateDMMMYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-DMMMYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);
	
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:textual", "true");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateDMMMYY';
	}
}

class odsStyleDateDMMMMYYYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-DMMMMYYYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);
	
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:textual", "true");
				$number_month->setAttribute(" number:style", "long");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_year->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateDMMMMYYYY';
	}
}

class odsStyleDateDMMMMYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-DMMMMYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);
	
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:textual", "true");
				$number_month->setAttribute(" number:style", "long");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateDMMMMYY';
	}
}

class odsStyleDateMMMDYYYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-MMMDYYYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:textual", "true");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);	

			$number_text = $dom->createElement('number:text', ', ');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_year->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateDMMMMYY';
	}
}

class odsStyleDateMMMDYY extends odsStyleDate {
	public function __construct($language) {
		$this->name='Date-MMMDYY';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_month = $dom->createElement('number:month');
				$number_month->setAttribute("number:textual", "true");
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);	

			$number_text = $dom->createElement('number:text', ', ');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_date_style->appendChild($number_year);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateDMMMM';
	}
}

abstract class odsStyleTime extends odsStyle {
}

class odsStyleTimeHHMMSS extends odsStyleTime {
	public function __construct() {
		$this->name='Time-HHMMSS';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_time_style = $dom->createElement('number:time-style');
			$number_time_style->setAttribute("style:name", $this->name);
			
			$number_hours = $dom->createElement('number:hours');
				$number_hours->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_hours);

			$number_text = $dom->createElement('number:text', ':');
				$number_time_style->appendChild($number_text);

			$number_minutes = $dom->createElement('number:minutes');
				$number_minutes->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_minutes);	

			$number_text = $dom->createElement('number:text', ':');
				$number_time_style->appendChild($number_text);

			$number_seconds = $dom->createElement('number:seconds');
				$number_seconds->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_seconds);	
			
		return $number_time_style;
	}

	public function getType() {
		return 'odsStyleTimeHHMMSS';
	}
}

class odsStyleTimeHHMM extends odsStyleTime {
	public function __construct() {
		$this->name='Time-HHMM';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_time_style = $dom->createElement('number:time-style');
			$number_time_style->setAttribute("style:name", $this->name);
			
			$number_hours = $dom->createElement('number:hours');
				$number_hours->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_hours);

			$number_text = $dom->createElement('number:text', ':');
				$number_time_style->appendChild($number_text);

			$number_minutes = $dom->createElement('number:minutes');
				$number_minutes->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_minutes);	
			
		return $number_time_style;
	}

	public function getType() {
		return 'odsStyleTimeHHMM';
	}
}

class odsStyleTimeHHMMSSAMPM extends odsStyleTime {
	public function __construct() {
		$this->name='Time-HHMMSSAMPM';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_time_style = $dom->createElement('number:time-style');
			$number_time_style->setAttribute("style:name", $this->name);
			
			$number_hours = $dom->createElement('number:hours');
				$number_hours->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_hours);

			$number_text = $dom->createElement('number:text', ':');
				$number_time_style->appendChild($number_text);

			$number_minutes = $dom->createElement('number:minutes');
				$number_minutes->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_minutes);	

			$number_text = $dom->createElement('number:text', ':');
				$number_time_style->appendChild($number_text);

			$number_seconds = $dom->createElement('number:seconds');
				$number_seconds->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_seconds);	

			$number_text = $dom->createElement('number:text', ' ');
				$number_time_style->appendChild($number_text);

			$number_am_pm = $dom->createElement('number:am-pm');
				$number_am_pm->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_am_pm);	
			
		return $number_time_style;
	}

	public function getType() {
		return 'odsStyleTimeHHMMSSAMPM';
	}
}

class odsStyleTimeHHMMAMPM extends odsStyleTime {
	public function __construct() {
		$this->name='Time-HHMMAMPM';
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_time_style = $dom->createElement('number:time-style');
			$number_time_style->setAttribute("style:name", $this->name);
			
			$number_hours = $dom->createElement('number:hours');
				$number_hours->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_hours);

			$number_text = $dom->createElement('number:text', ':');
				$number_time_style->appendChild($number_text);

			$number_minutes = $dom->createElement('number:minutes');
				$number_minutes->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_minutes);	

			$number_text = $dom->createElement('number:text', ' ');
				$number_time_style->appendChild($number_text);
			
			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_am_pm = $dom->createElement('number:am-pm');
				$number_am_pm->setAttribute("number:style", "long");
				$number_time_style->appendChild($number_am_pm);	
			
		return $number_time_style;
	}

	public function getType() {
		return 'odsStyleTimeHHMMAMPM';
	}
}

abstract class odsStyleDateTime extends odsStyleDate {
}

class odsStyleDateTimeMMDDYYHHMMSSAMPM extends odsStyleDateTime {
	public function __construct($language) {
		$this->name='DateTime-MMDDYYHHMMSSAMPM';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_month = $dom->createElement('number:month');
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);	

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_date_style->appendChild($number_year);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_hours = $dom->createElement('number:hours');
			$number_hours->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_hours);

			$number_text = $dom->createElement('number:text', ':');
				$number_date_style->appendChild($number_text);

			$number_minutes = $dom->createElement('number:minutes');
			$number_minutes->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_minutes);
				
			$number_text = $dom->createElement('number:text', ':');
				$number_date_style->appendChild($number_text);

			$number_seconds = $dom->createElement('number:seconds');
				$number_seconds->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_seconds);
				
			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);
			
			$number_am_pm = $dom->createElement('number:am-pm');
				$number_date_style->appendChild($number_am_pm);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateTimeMMDDYYHHMMSSAMPM';
	}
}

class odsStyleDateTimeMMDDYYHHMMAMPM extends odsStyleDateTime {
	public function __construct($language) {
		$this->name='DateTime-MMDDYYHHMMAMPM';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_month = $dom->createElement('number:month');
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);	

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_date_style->appendChild($number_year);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_hours = $dom->createElement('number:hours');
			$number_hours->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_hours);

			$number_text = $dom->createElement('number:text', ':');
				$number_date_style->appendChild($number_text);

			$number_minutes = $dom->createElement('number:minutes');
			$number_minutes->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_minutes);
			
			$number_am_pm = $dom->createElement('number:am-pm');
				$number_date_style->appendChild($number_am_pm);
			
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateTimeMMDDYYHHMMAMPM';
	}
}

class odsStyleDateTimeDDMMYYHHMMSS extends odsStyleDateTime {
	public function __construct($language) {
		$this->name='DateTime-DDMMYYHHMMSS';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);	

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);
			
			$number_month = $dom->createElement('number:month');
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_date_style->appendChild($number_year);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_hours = $dom->createElement('number:hours');
			$number_hours->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_hours);

			$number_text = $dom->createElement('number:text', ':');
				$number_date_style->appendChild($number_text);

			$number_minutes = $dom->createElement('number:minutes');
			$number_minutes->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_minutes);
				
			$number_text = $dom->createElement('number:text', ':');
				$number_date_style->appendChild($number_text);

			$number_seconds = $dom->createElement('number:seconds');
				$number_seconds->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_seconds);
				
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateTimeDDMMYYHHMMSS';
	}
}

class odsStyleDateTimeDDMMYYHHMM extends odsStyleDateTime {
	public function __construct($language) {
		$this->name='DateTime-DDMMYYHHMM';
		$this->language = $language;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$number_date_style = $dom->createElement('number:date-style');
			$number_date_style->setAttribute("style:name", $this->name);
			$number_date_style->setAttribute("number:automatic-order", "true");
			$this->setLanguage($number_date_style);
			
			$number_day = $dom->createElement('number:day');
				$number_date_style->appendChild($number_day);	

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);
			
			$number_month = $dom->createElement('number:month');
				$number_date_style->appendChild($number_month);

			$number_text = $dom->createElement('number:text', '/');
				$number_date_style->appendChild($number_text);

			$number_year = $dom->createElement('number:year');
				$number_date_style->appendChild($number_year);

			$number_text = $dom->createElement('number:text', ' ');
				$number_date_style->appendChild($number_text);

			$number_hours = $dom->createElement('number:hours');
			$number_hours->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_hours);

			$number_text = $dom->createElement('number:text', ':');
				$number_date_style->appendChild($number_text);

			$number_minutes = $dom->createElement('number:minutes');
			$number_minutes->setAttribute("number:style", "long");
				$number_date_style->appendChild($number_minutes);
				
		return $number_date_style;
	}

	public function getType() {
		return 'odsStyleDateTimeDDMMYYHHMM';
	}
}

?>