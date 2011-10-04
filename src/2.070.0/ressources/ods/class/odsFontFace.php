<?php
/*-
 * Copyright (c) 2009 Laurent VUIBERT
 * License : GNU Lesser General Public License v3
 */

class odsFontFace {
	private $fontName; // = "Nimbus Sans L";
	private $fontFamilyGeneric;
	private $fontPitch;
	
	public function __construct($fontName, $fontFamilyGeneric = null, $fontPitch = 'variable') {
		$this->fontName          = $fontName;
		$this->fontFamilyGeneric = $fontFamilyGeneric;
		$this->fontPitch         = $fontPitch;
	}
	
	public function getContent(ods $ods, DOMDocument $dom) {
		$style_font_face = $dom->createElement('style:font-face');
			$style_font_face->setAttribute("style:name", $this->fontName);
			$style_font_face->setAttribute("svg:font-family", "'".$this->fontName."'");
			$style_font_face->setAttribute("style:font-family-generic", $this->fontFamilyGeneric);
			$style_font_face->setAttribute("style:font-pitch", $this->fontPitch);
		return $style_font_face;
	}
	
	public function getFontName() {
		return $this->fontName;
	}
	
	public function getStyles(ods $ods, DOMDocument $dom) {
		return $this->getContent($ods,$dom);
	}
}


?>
