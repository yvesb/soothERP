<?php
/*-
 * Copyright (c) 2009 Laurent VUIBERT
 * License : GNU Lesser General Public License v3
 */
 
abstract class odsDraw {
	protected $styleGraphic;
	protected $zIndex;
	
	abstract function __construct();
	abstract function getContent(ods $ods, DOMDocument $dom);
	abstract protected function getType();
	
	public function setZIndex($zIndex){
		$this->zIndex = $zIndex;
	}
}

class odsDrawLine extends odsDraw {
	private $styleParagraph;
	private $x1; // 1cm
	private $y1; // 1cm
	private $x2; // 2cm
	private $y2; // 2cm
	
	static private $defaultStyle = null;
	static private $defaultStyleParagraph = null;

	
	public function __construct($x1, $y1, $x2, $y2, $odsStyleGraphic = null, $odsStyleParagraph = null ) {
		$this->styleGraphic   = $odsStyleGraphic;
		$this->styleParagraph = $odsStyleParagraph;
		$this->x1        = $x1;
		$this->y1        = $y1;
		$this->x2        = $x2;
		$this->y2        = $y2;
		$this->zIndex    = "0";		
	}
	
	function getContent(ods $ods, DOMDocument $dom) {

		if($this->styleGraphic)
			$style = $this->styleGraphic;
		else 
			$style = self::getOdstyleGraphic();

		if($this->styleParagraph)
			$styleParagraph = $this->styleParagraph;
		else 
			$styleParagraph = self::getOdstyleParagraph();			
		
		$ods->addTmpStyles($style);
		$ods->addTmpStyles($styleParagraph);
				
		$draw_line = $dom->createElement('draw:line');
			$draw_line->setAttribute('draw:z-index', $this->zIndex);
			$draw_line->setAttribute('draw:style-name', $style->getName());
			$draw_line->setAttribute('draw:text-style-name', $styleParagraph->getName());
			$draw_line->setAttribute('svg:x1', $this->x1);
			$draw_line->setAttribute('svg:y1', $this->y1);
			$draw_line->setAttribute('svg:x2', $this->x2);
			$draw_line->setAttribute('svg:y2', $this->y2);
			
			$text_p = $dom->createElement('text:p');
				$draw_line->appendChild($text_p);
			
		return $draw_line;
	}
	
	static public function getOdstyleGraphic() {
		if(!self::$defaultStyle)
			self::$defaultStyle = new odsStyleGraphic("gr-line"); 
		return self::$defaultStyle;
	}
	
	static public function getOdstyleParagraph() {
		if(!self::$defaultStyleParagraph)
			self::$defaultStyleParagraph = new odsStyleParagraph("p1");
		return self::$defaultStyleParagraph;
	}
	
	public function getType() {
		return "odsDrawLine";
	}
}


?>
