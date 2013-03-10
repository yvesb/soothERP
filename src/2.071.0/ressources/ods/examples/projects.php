<?php

require_once("../ods.php");

$projet = new project();
$projet->addItem("2010-01-05", "2010-01-10", "#1", "#aaaaff");
$projet->addItem("2010-01-15", "2010-03-25", "#2", "#ffaaaa");
$projet->addItem("2010-01-01", "2010-01-25", "#3", "#aaffaa");

//echo $projet->html("2010-01-01","2010-02-28");
$projet->ods("2010-01-01","2010-02-28");



class project {
	private $projectItems;
	
	public function __construct() {
		$this->projectItems = array();
	}
	
	private function gendate($start, $end) {
		$data = array();
		
		if(!preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $start))
			throw new Exception("Error; start date YYYY-MM-DD :".$start);
		$ex1 = explode("-",$start); 
		
		if(!preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $end))
			throw new Exception("Error; end date YYYY-MM-DD :".$end);
		$ex2 = explode("-",$end);
			
		$start = mktime(0,0,0,$ex1[1],$ex1[2],$ex1[0]);
		$end   = mktime(0,0,0,$ex2[1],$ex2[2],$ex2[0]);
		
		$data['days']       = array();
		$data['days_nb']    = array();
		$data['months']     = array();
		$data['weeks']      = array();
		$data['total_days'] = 0;
	
		$pstart = $start;
		while($pstart<=$end) {
			array_push($data['days'],array('title'=>date('D',$pstart).' '.date('j',$pstart),'day'=>'1'));
			
			$monthNb = date('n',$pstart);
			if(!isset($data['months'][$monthNb])) {
				$data['months'][$monthNb] = array(
					'title' => date('F',$pstart),
					'day'=>'0'
				);
			};
			$data['months'][$monthNb]['day']++;
			
			$weekNb = date('W',$pstart);
			if($weekNb == 53) $weekNb = 1;
			if(!isset($data['weeks'][$weekNb])) {
				$data['weeks'][$weekNb] = array(
					'title' => $weekNb,
					'day'=>'0'
				);
			};
			$data['weeks'][$weekNb]['day']++;
			
			$pstart+=60*60*24;
			$data['total_days']++;
		}
		
		$data['projects'] = array();
		foreach($this->projectItems as $projet) {
			$ex1 = explode("-",$projet['start']); 
			$ex2 = explode("-",$projet['end']);
			$pstart = mktime(0,0,0,$ex1[1],$ex1[2],$ex1[0]);
			$pend   = mktime(0,0,0,$ex2[1],$ex2[2],$ex2[0]);
			
			if( $pstart<=$end AND $pend>=$start ) {
				$tmp = array();
				$tmp['title'] = $projet['title'];
				$tmp['color'] = $projet['color'];
				$tmp['shift'] = ($pstart-$start)/(60*60*24);
				if($tmp['shift']<0) $tmp['shift']=0;
				if($pend>$end) 
					$tmp['days'] = ($end-$pstart)/(60*60*24)+1;
				else
					$tmp['days'] = ($pend-$pstart)/(60*60*24)+1;
				
				array_push($data['projects'], $tmp);
			}
		}
		
		return $data;
	}
	
	public function addItem($start, $end, $title, $color) {
		if(!preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $start))
			throw new Exception("Error; start date YYYY-MM-DD :".$start);
		
		if(!preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $end))
			throw new Exception("Error; end date YYYY-MM-DD :".$end);
		
		if(!preg_match("/^\#[0-9a-fA-F]{6}$/", $color))
			throw new Exception("Error; color #XXXXXX :".$color);
			
		array_push($this->projectItems,
			array(
				"start" => $start,
				"end"   => $end,
				"title" => $title,
				"color" => $color
			)
		);
	}
	
	public function html($start, $end) {
		$data = $this->gendate($start, $end);
		$r="";
		
		$r .= "<table>";
		
		$r .= "<tr>";
		foreach($data['months'] AS $moi)
			$r .= "<td style='border:1px solid black' colspan='$moi[day]'>$moi[title]</td>";
		$r .= "</tr>\n";
		
		$r .= "<tr>";
		foreach($data['weeks'] AS $week)
			$r .= "<td style='border:1px solid black' colspan='$week[day]'>$week[title]</td>";
		$r .= "</tr>\n";
		
		$r .= "<tr>";
		foreach($data['days'] AS $day)
			$r .= "<td style='border:1px solid black' colspan='$day[day]'>$day[title]</td>";
		$r .= "</tr>\n";
		
		foreach($data['projects'] AS $projet) {
			$r .= "<tr>";
			if($projet["shift"])
				$r .= "<td colspan='$projet[shift]'>&nbsp;</td>";
			$r .= "<td style='border:1px solid black; background-color:$projet[color]' colspan='$projet[days]'>$projet[title]</td>";
			$r .= "</tr>\n";
		}
		
		$r .= "</table>";
		
		return $r;
	}
	
	public function ods($start, $end) {
		$data = $this->gendate($start, $end);
		
		$ods   = new ods();
		$table = new odsTable('table 1');
	
		$table->setHorizontalSplit(1);
		$table->setVerticalSplit(3);
	
		// Set coluomn width
		$styleColumn = new odsStyleTableColumn();
		$styleColumn->setColumnWidth("4cm");
		$table->addTableColumn( new odsTableColumn($styleColumn) );
		
		$table->addTableColumn( $column = new odsTableColumn($styleColumn = new odsStyleTableColumn()) );
		$styleColumn->setColumnWidth("1.5cm");
		$column->setRepeated($data['total_days']);
		
		// Set Title Style
		$styleTitle1 = new odsStyleTableCell();
		$styleTitle1->setBorder("0.01cm solid #000000");
		$styleTitle1->setFontWeight('bold');
		
		$styleTitle2 = clone $styleTitle1;
		$styleTitle2->setTextAlign("center");
		
		
		// Months style
		$row   = new odsTableRow();
		$row->addCell( new odsTableCellString("Months:",$styleTitle1));
		foreach($data['months'] AS $moi) {
			$cell = new odsTableCellString($moi['title'],$styleTitle2);
			$cell->setNumberColumnsSpanned($moi['day']);
			$row->addCell( $cell );
		}
		$table->addRow($row);
		
		$row   = new odsTableRow();
		$row->addCell( new odsTableCellString("Weeks :",$styleTitle1));
		foreach($data['weeks'] AS $week) {
			$cell = new odsTableCellString($week['title'],$styleTitle2);
			$cell->setNumberColumnsSpanned($week['day']);
			$row->addCell( $cell );
		}
		$table->addRow($row);
		
		$row   = new odsTableRow();
		$row->addCell( new odsTableCellString("Days:",$styleTitle1));
		foreach($data['days'] AS $day) {
			$cell = new odsTableCellString($day['title'],$styleTitle2);
			$cell->setNumberColumnsSpanned($day['day']);
			$row->addCell( $cell );
		}
		$table->addRow($row);	
		
		foreach($data['projects'] AS $projet) {
			$row   = new odsTableRow();
			
			$row->addCell( new odsTableCellString($projet['title'],$styleTitle1));
			
			if($projet["shift"]) {
				$cell = new odsTableCellEmpty();
				$cell->setNumberColumnsRepeated($projet["shift"]);
				$row->addCell( $cell );
			}
			
			$styleX = clone($styleTitle2);
			$styleX->setBackgroundColor($projet[color]);
			
			$cell = new odsTableCellString($projet['title'],$styleX);
			$cell->setNumberColumnsSpanned($projet['days']);
			$row->addCell( $cell );
			$table->addRow($row);
		}
		
		$ods->addTable($table);
		$ods->downloadOdsFile("tab.ods"); exit();
	}
}

?>